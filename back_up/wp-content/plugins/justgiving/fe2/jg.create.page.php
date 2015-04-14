<?php

function jg_autocomplete_suggestions(){
    // Query for suggestions
    $suggestions = array();
    include_once(JG_PLUGIN_DIR.'/lib/JustGivingClient.php');
    $wpjg_generalSettings = get_option('jg_general_settings');
    $client = new JustGivingClient(
        $wpjg_generalSettings['ApiLocation'],
        $wpjg_generalSettings['ApiKey'],
        $wpjg_generalSettings['ApiVersion'],
        $wpjg_generalSettings['TestUsername'], $wpjg_generalSettings['TestValidPassword']);    
    $pages = $client->Page->SuggestPageShortNames($_REQUEST['term']);

    foreach ($pages->Names as $post):
        $suggestion = array();
        $suggestion['label'] = esc_html($post);
 
        $suggestions[]= $suggestion;
    endforeach;
 
    // JSON encode and echo
    $response = $_GET["callback"] . "(" . json_encode($suggestions) . ")";
    echo $response;
    exit;
}

function jg_front_end_create_page($atts){
    session_start();
    ob_start();
    global $current_user;
    global $wp_roles;
    global $wpdb;
    global $error;	
    global $js_shortcode_on_front;
           
    extract(shortcode_atts(array('forgot'=> 0, 'display' => true, 'redirect' => '', 'submit' => 'page', 'create' => '', 'thanks' => ''), $atts));
    $user = '';
    $pass = '';
    $errors = array();
    
    //print_r($_SESSION);
    /*
    if ( trim($_SESSION['userEnc']) == '' ){
        $redirectLink = trim(home_url());
        if (intval($redirectLink) != 0)
            $redirectLink = get_permalink($redirectLink);
        else{
            if (jg_check_missing_http($redirectLink))
                $redirectLink = 'http://'. $redirectLink;
        }
        wp_redirect( $redirectLink ); exit;
    }
    */
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] &&
            !empty( $_POST['action'] ) &&
            $_POST['action'] == 'createpage' &&
            wp_verify_nonce($_POST['createpage_nonce_field'],'verify_true_create') &&
            ($_POST['formName'] == 'createpage') ) {
        
        include_once(JG_PLUGIN_DIR.'/lib/JustGivingClient.php');
        $wpjg_generalSettings = get_option('jg_general_settings');
        $client = new JustGivingClient(
            $wpjg_generalSettings['ApiLocation'],
            $wpjg_generalSettings['ApiKey'],
            $wpjg_generalSettings['ApiVersion'],
            $wpjg_generalSettings['TestUsername'], $wpjg_generalSettings['TestValidPassword']);
        $pageExists = $client->Page->IsShortNameRegistered($_POST['pageshortname']);        
        /*create page*/
        if (!$pageExists){
            $dto = array(
                'currency' => 'GBP',
                'pageShortName' => $_POST['pageshortname'],
                'charityId' =>  $wpjg_generalSettings['Charity'],
                'eventId' => $wpjg_generalSettings['Event'],
                'justGivingOptIn' => ((bool) $_POST['jgoptin']),
                'charityOptIn' => ((bool) $_POST['charityoptin']),
                'pageTitle' => stripslashes($_POST['pagetitle']),
                'charityFunded' => false
            );
            //print_R($dto)   ;
    
            $page = $client->Page->Create(trim($_SESSION['userEnc']), $dto);
            /*update user with url*/
            

            //print_R($page);
            //print_R($thanks);
            $errorMark = '';
            if (!$page) $errorMark = 'Could not create page at JustGiving';
            if ($page){
                $result = $wpdb->get_results (
                    $wpdb->prepare(
                        "SELECT * FROM $wpdb->jgusers WHERE `userEnc`='%s';", trim($_SESSION['userEnc'])
                    )
                ); 
                if (count ($result) > 0) {
                    $wpdb->update(
                        $wpdb->prefix . "jgusers",
                        array(
                            'pageurl' => $page->next->uri
                        ),
                        array(                 
                            'userEnc' => trim($_SESSION['userEnc'])
                        ),
                        array(  
                            'optin' => $_POST['charityoptin']
                        ), 
                        array( 
                            '%s'
                        ),
                        array( 
                            '%s'
                        ),
                        array( 
                            '%d'
                        ));
                }
                else{
                    $wpdb->insert( 
                        $wpdb->prefix . "jgusers", 
                        array(  
                            'email' => trim($_SESSION['email']),
                            'userEnc' => trim($_SESSION['userEnc']),
                            'pageurl' => $page->next->uri,
                            'signupdate' => time(),
                            'optin' => $_POST['charityoptin']
                        ), 
                        array(
                            '%s',
                            '%s', 
                            '%s',         
                            '%d',
                            '%d'
                            
                        ) 
                    );                 
                }            
                // -> send straight to thanks

                $redirectLink = trim($thanks);
                if (intval($redirectLink) != 0){
                    $redirectLink = get_permalink($redirectLink);
                }
                else{
                    if (jg_check_missing_http($redirectLink))
                        $redirectLink = 'http://'. $redirectLink;
                }
                $vars = array(
                    'firstname' => $result['firstname'],
                    'url' => $page->next->uri,
                    'editurl' => $page->signOnUrl
                );
                $useracc = $client->Account->GetUser(trim($_SESSION['userEnc']));
                if (trim($vars['firstname']) == ''){
                    $vars['firstname'] =  $useracc->firstName;
                    $result['firstname'] =  $useracc->firstName;
                    $result['lastname'] =  $useracc->lastName;
                }
                $email = $_SESSION['email'];
                if (trim($email) == ''){
                    $email = $useracc->email;
                }
                wp_redirect( $redirectLink .'?nexturl='.$page->next->uri );
                $ba = sendthanks(trim($email), $result['firstname']. ' '. $result['lastname'], $vars, 1);  
                exit;
                
            }
        }
        $errors['shortname']['message'] = "A page already exists with this name";
    }
?>
    <form enctype="multipart/form-data" method="post"
          id="createpage" class="user-forms" action="<?php echo jg_curpageurl(); ?>">

    <div class="container water-bg water-line-top createpage">
		<div class="col-xs-12">

        <span class="error"><?php echo $errorMark; ?></span>
        <div class="form-item input-row">
            <label for="pageshortname">Your H2Only name <span class="hint"></span> <span class="tooltip" title="This is the address of your JustGiving fundraising page ie www.justgiving.com/johnsmith" ></span></label>
            <input type="text" name="pageshortname" id="pageshortname" value="<?php echo stripslashes($_POST['pageshortname']); ?>" class="input-text" validate="required:true" />
            <span class="error"><?php echo $errors['shortname']['message'];  ?></span>
        </div>
        <div class="form-item input-row">
            <label for="pagetitle">H2Only page title <span class="hint"></span><span class="tooltip" title="This is the title that will appear at the top of your JustGiving fundraising page" ></span></label>
            <input type="text" name="pagetitle" id="pagetitle" value="<?php echo stripslashes($_POST['pagetitle']); ?>" class="input-text" validate="required:true" />
            <span class="error"><?php echo $errors['pagetitle']['message'];  ?></span>
        </div>
        <div class="form-item radiogroup-row">
            <div class="label">I&rsquo;m happy for JustGiving to contact me after H2Only <span class="hint"></span><span class="tooltip" title="Stay up to date with with JustGiving's news, tips and inspiring stories" ></span></div>
            <div class="radiogroup">
                <label><input type="radio" name="jgoptin" id="jgoptinyes" value="1" <?php echo ($_POST['jgoptin'] =='1') ? 'checked="checked"':''; ?> validate="required:true" />Yes</label>    
                <label><input type="radio" name="jgoptin" id="jgoptinno" value="0" <?php echo ($_POST['jgoptin'] =='0') ? 'checked="checked"':''; ?> validate="required:true" />No</label>    
            </div>
            <span class="error"><?php echo $errorMark; ?></span>
        </div>
        <div class="form-item radiogroup-row">
            <div class="label">I&rsquo;m happy for the RNLI to get in touch again after H2Only <span class="hint"></span><span class="tooltip" title="Stay up to date with your charity's news about how your support is helping" ></span></div>
            <div class="radiogroup">
                <label><input type="radio" name="charityoptin" id="charityoptinyes" value="1" <?php echo ($_POST['charityoptin']=='1') ? 'checked="checked"':''; ?> validate="required:true" />Yes</label>    
                <label><input type="radio" name="charityoptin" id="charityoptinno" value="0" <?php echo ($_POST['charityoptin'] =='0') ? 'checked="checked"':''; ?> validate="required:true" />No</label>    
            </div>
            <span class="error"><?php echo $errorMark; ?></span>
        </div>

        </div>
        </div>

        <div class="col-xs-12 fieldset-submit water-line-bottom createpage">
	        <div class="form-item input-row centered">
	        <button class="button" title="<?php _e('Next', 'justgiving'); ?>" type="submit">
	            <?php _e('Next', 'justgiving'); ?>
	        </button>          
	        <p class="form-submit">
	            <input name="action" type="hidden" id="action" value="createpage" />
	            <input type="hidden" name="formName" value="createpage" />
	        </p>
				<?php 
	        		wp_nonce_field('verify_true_create','createpage_nonce_field'); 
				?>
	        </div>
        </div>

        </div></div>
    </form><!-- #adduser -->
<?php    
    $output = ob_get_contents();
    ob_end_clean();
	
    return $output;
}
?>