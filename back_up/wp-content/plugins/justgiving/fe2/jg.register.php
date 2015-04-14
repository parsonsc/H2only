<?php
session_start();
function MyCheckDate( $postedDate ) {
    if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $postedDate)){
        list( $year , $month , $day ) = explode('-',$postedDate);
        return( checkdate( $month , $day , $year ) );
    } else {
        return( false );
    }
}
//function to display the registration page
function jg_front_end_register($atts){
    ob_start();
    global $current_user;
    global $wp_roles;
    global $wpdb;
    global $error;	
    global $js_shortcode_on_front;
    

    /* Check if users can register. */
    $registration = get_option( 'users_can_register' );
        
    extract(shortcode_atts(array('forgot'=> 0, 'display' => true, 'redirect' => '', 'submit' => 'page', 'create' => '', 'thanks' => '', 'login' => ''), $atts));

    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'adduser' && wp_verify_nonce($_POST['register_nonce_field'],'verify_true_registration') && ($_POST['formName'] == 'register') ) {

        $default_role = get_option( 'default_role' );
        $user_pass = '';
        if (isset($_POST['password']))
            $user_pass = esc_attr( $_POST['password'] );
        $email = '';
        if (isset($_POST['email'])){
            $email = trim ($_POST['email']);
            $_SESSION['email'] = $email;
        }
        $pos = strpos($_POST['dob'], '-');
        if (MyCheckDate($_POST['dob'])){
            //american or off a date field
            list( $year , $month , $day ) = explode('-',$_POST['dob']);
            $_POST['dob'] = date('d-m-Y', mktime(0, 0, 0, $month, $day, $year));
        }
        $user_name = jg_generate_random_username($email);
        $first_name = '';
        if (isset($_POST['firstname']))
            $first_name = trim ($_POST['firstname']);
        $last_name = '';
        if (isset($_POST['lastname']))
            $last_name = trim ($_POST['lastname']);        
        $userdata = array(
            'user_pass' => $user_pass,
            'user_login' => esc_attr( $user_name ),
            'first_name' => esc_attr( $first_name ),
            'last_name' => esc_attr( $last_name ),
            'user_email' => esc_attr( $email ),
            'role' => $default_role
        );
        if ($_POST['haveaccount'] == 0 &&
                $_POST['createpage'] == 1 &&
                (trim($userdata['user_pass']) == '' ||
                 trim($userdata['user_pass']) != trim($_POST['cpassword']))){
            /* no account but no details to make one */
            $foundError = true;
        }
        include_once(JG_PLUGIN_DIR.'/lib/functions.php');
        $results = array(
            'title' => '',
            'firstname' => '',
            'lastname' => '',
            'email' => '',
            'dob' => '',
            'address' => '',
            'town' => '',
            'county' => '',
            'postcode' => '',
            'packpost' => '',
            'createpage' => '',
            'haveaccount' => ''
        );	
        $rules = array(
            'title' => 'notEmpty',
            'firstname' => 'notEmpty',
            'lastname' => 'notEmpty',
            'email' => 'email',
            'dob' => 'date',
            'address' => 'notEmpty',
            'town' => 'notEmpty',
            'county' => 'notEmpty',
            'postcode' => 'postCode',
            'packpost' => 'notEmpty',
            'createpage' => 'notEmpty'
        );
        $messages = array(
            'title' => 'Please choose your title',
            'firstname' => 'Please enter your first name',
            'lastname' => 'Please enter your surname',
            'email' => 'Please enter your email address',
            'dob' => 'Please enter your date of birth',
            'address' => 'Please enter your address',
            'town' => 'Please enter your town',
            'county' => 'Please enter your county',
            'postcode' => 'Please enter your postcode',
            'packpost' => 'Would you like a fundraising pack',
            'createpage' => 'Would you like to create a fundraising page'
        );    
        foreach ($results as $key => $value){
                $results[$key] = $_POST[$key];
        }

        $errors = validateInputs($results, $rules, $messages);
        if (count($errors) != 0) $foundError = true;

        include_once(JG_PLUGIN_DIR.'/lib/JustGivingClient.php');
        $wpjg_generalSettings = get_option('jg_general_settings');
        $client = new JustGivingClient(
            $wpjg_generalSettings['ApiLocation'],
            $wpjg_generalSettings['ApiKey'],
            $wpjg_generalSettings['ApiVersion'],
            $wpjg_generalSettings['TestUsername'], $wpjg_generalSettings['TestValidPassword']);
        
        $hasJGAccount = $client->Account->IsEmailRegistered(trim($results['email']));
        /*
        if ($results['hasaccount'] == 0 && $hasJGAccount){
            $errors['email']['message'] = 'A JustGiving account exists for that email address';
            $foundError = true;
        }
        */
        //print_R($hasJGAccount);        
        if (!$foundError){
            //print_R($_POST);
            //print_R($userdata);
            //$new_user = wp_insert_user( $userdata );
            unset($_POST['password']);
            unset($_POST['cpassword']);
            unset($_POST['firstname']);
            unset($_POST['lastname']);
            unset($_POST['action']);
            unset($_POST['register_nonce_field']);
            unset($_POST['formName']);
            unset($_POST['submit']);
            unset($_POST['_wp_http_referer']);
            
            $wpdb->insert( 
                $wpdb->prefix . "jgusers", 
                array( 
                    'title' => $results['title'], 
                    'firstname' => $results['firstname'], 
                    'lastname' => $results['lastname'], 
                    'dob' => $results['dob'], 
                    'email' => $results['email'], 
                    'address' => isset($results['address']) ? $results['address'] : '', 
                    'towncity' => isset($results['town']) ? $results['town'] : '', 
                    'county' => isset($results['county']) ? $results['county'] : '', 
                    'postcode' => isset($results['postcode']) ? $results['postcode'] : '',
                    'packbypost' => isset($results['packpost']) ? $results['packpost'] : '',
                    'cpage' => isset($results['createpage']) ? $results['createpage'] : '',
                    'hasaccount' => isset($results['haveaccount']) ? $results['haveaccount'] : '',
                    'userEnc' => base64_encode($results['email'].':'.trim($_POST['password'])),
                    'pageurl' => '',
                    'signupdate' => time()
                ), 
                array(
                    '%s', 
                    '%s', 
                    '%s', 
                    '%s', 
                    '%s', 
                    '%s', 
                    '%s', 
                    '%s', 
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%d'             
                ) 
            ); 
            
            if($hasJGAccount){

                /* if login JG change password */
                if ($_POST['createpage'] == 1)
                {
                    //create a page
                    $_SESSION['email'] = trim($results['email']);
                    $redirectLink = trim($login);
                    if (intval($redirectLink) != 0)
                        $redirectLink = get_permalink($redirectLink);
                    else{
                        if (jg_check_missing_http($redirectLink))
                            $redirectLink = 'http://'. $redirectLink;
                    }

                    wp_redirect( $redirectLink ); exit;
                }
                else
                { 
                                
                    // -> send stright to thanks - send email
                    $redirectLink = trim($thanks);
                    if (intval($redirectLink) != 0)
                        $redirectLink = get_permalink($redirectLink);
                    else{
                        if (jg_check_missing_http($redirectLink))
                            $redirectLink = 'http://'. $redirectLink;
                    }
                    
                    wp_redirect( $redirectLink );
                    $vars = array(
                        'firstname' => $results['firstname']
                    );
                    sendthanks($results['email'], $results['firstname']. ' '. $results['lastname'], $vars, 0);                            
                    exit;
                }
            }
            else{

                if ($_POST['haveaccount'] == 0 && trim($userdata['user_pass']) != '' ){

                //include_once(JG_PLUGIN_DIR.'/lib/ApiClients/Model/CreateAccountRequest.php');
                    $request = array();
                    $request['email'] = $results['email'];
                    $request['firstName'] = $results['firstname'];
                    $request['lastName'] = $results['lastname'];
                    $request['password'] = trim($userdata['user_pass']);
                    $request['title'] = trim($results['title']);
                    $request['address']['line1'] = trim($results['address']);
                    $request['address']['countyOrState'] = trim($results['county']);
                    $request['address']['townOrCity'] = trim($results['town']);
                    $request['address']['postcodeOrZipcode'] = trim($results['postcode']);
                    $request['address']['country'] = 'United Kingdom';
                    $request['acceptTermsAndConditions'] = true;
                    //print_R($request);
                    $response = $client->Account->Create($request);
                    //print_R($response);
                    if ($_POST['createpage'] == 1)
                    {
                        $_SESSION['email'] = trim($results['email']);                    
                        $_SESSION['userEnc'] = base64_encode($results['email'].':'.trim($userdata['user_pass']));
                        //create a page
                        $redirectLink = trim($create);
                        if (intval($redirectLink) != 0)
                            $redirectLink = get_permalink($redirectLink);
                        else{
                            if (jg_check_missing_http($redirectLink))
                                $redirectLink = 'http://'. $redirectLink;
                        }
                        //echo 'goto' .$redirectLink;
                        wp_redirect( $redirectLink ); exit;
                        
                    }
                    else
                    {
                        //echo $thanks;
                     
                        // -> send stright to thanks - send email
                        $redirectLink = trim($thanks);
                        if (intval($redirectLink) != 0)
                            $redirectLink = get_permalink($redirectLink);
                        else{
                            if (jg_check_missing_http($redirectLink))
                                $redirectLink = 'http://'. $redirectLink;
                        }
                        //echo 'goto' .$redirectLink;
                        wp_redirect( $redirectLink );
                        $vars = array(
                            'firstname' => $results['firstname']
                        );
                        sendthanks($results['email'], $results['firstname']. ' '. $results['lastname'], $vars, 0);                           
                        exit;
                    }
                }
                else
                {
                    if ($_POST['createpage'] == 1)
                    {
                        $_SESSION['email'] = trim($results['email']);                    
                        //login with the account you said you had 
                        // even though you don't have an account on this email
                        // cos we'd have found it by now
                        $redirectLink = trim($login);
                        if (intval($redirectLink) != 0)
                            $redirectLink = get_permalink($redirectLink);
                        else{
                            if (jg_check_missing_http($redirectLink))
                                $redirectLink = 'http://'. $redirectLink;
                        }
                        //echo 'goto' .$redirectLink;
                        wp_redirect( $redirectLink ); exit;                    
                    }
                    else{
                        //echo 'meh';
                        //echo $thanks;                    
                        /* what to do if login is incorrect but wanted to create a page ?*/
                        // -> send stright to thanks
                        //echo $thanks;
                        $redirectLink = trim($thanks);
                        if (intval($redirectLink) != 0)
                            $redirectLink = get_permalink($redirectLink);
                        else{
                            if (jg_check_missing_http($redirectLink))
                                $redirectLink = 'http://'. $redirectLink;
                        }
                        //echo $redirectLink;
                        wp_redirect( $redirectLink );
                        $vars = array(
                            'firstname' => $results['firstname']
                        );
                        sendthanks($results['email'], $results['firstname']. ' '. $results['lastname'], $vars, 0);                    
                        exit;
                    }
                }
            }
            $redirectLink = trim($redirect);
            if (intval($redirectLink) != 0)
                $redirectLink = get_permalink($redirectLink);
            else{
                if (jg_check_missing_http($redirectLink))
                    $redirectLink = 'http://'. $redirectLink;
            }
            wp_redirect( $redirectLink ); exit;
        }
    }
    if ( $registration || current_user_can( 'create_users' ) ) :
?>


    <form enctype="multipart/form-data" method="post" id="adduser" class="user-forms container" action="<?php echo jg_curpageurl(); ?>">
        
    <div class="row water-bg water-line-top">    
    <div class="col-xs-* col-xs-12 fieldset">
        <div class="form-item input-row">
            <label for="title" class="inline">Title</label>
            <select name="title" id="title" value="<?php echo $_POST['title']?>" class="input-text" validate="required:true" />
                <option value=""></option>
                <option value="Mr" <?php echo ($_POST['title'] == 'Mr')? 'selected="selected"':''; ?>>Mr</option>
                <option value="Mrs" <?php echo ($_POST['title'] == 'Mrs')? 'selected="selected"':''; ?>>Mrs</option>
                <option value="Miss"<?php echo ($_POST['title'] == 'Miss')? 'selected="selected"':''; ?>>Miss</option>
                <option value="Ms" <?php echo ($_POST['title'] == 'Ms')? 'selected="selected"':''; ?>>Ms</option>
                <option value="Dr" <?php echo ($_POST['title'] == 'Dr')? 'selected="selected"':''; ?>>Dr</option>
                <option value="Other" <?php echo ($_POST['title'] == 'Other')? 'selected="selected"':''; ?>>Other</option>
            </select>
            <span class="error"><?php echo $errors['title']['message'];  ?></span>
        </div>
        <div class="form-item input-row">
            <label for="firstname" class="inline">First name</label>
            <input type="text" name="firstname" id="firstname" value="<?php echo $_POST['firstname']?>" class="input-text" validate="required:true" />
            <span class="error"><?php echo $errors['firstname']['message'];  ?></span>
        </div>
        <div class="form-item input-row">
            <label for="lastname" class="inline">Last name</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo $_POST['lastname']; ?>" class="input-text" validate="required:true" />
            <span class="error"><?php echo $errors['lastname']['message'];  ?></span>
        </div>
        <div class="form-item input-row">
            <label for="dob" class="inline">Date of birth</label>
            <input type="date" name="dob" max="<?php echo date('Y-m-d'); ?>" id="dob" value="<?php echo $_POST['dob']; ?>" class="input-text" validate="required:true" />
            <span class="error"><?php echo $errors['dob']['message']; ?></span>
        </div>
    </div> <!-- END Fieldset 1 -->




	<div class="col-xs-* col-xs-12 fieldset">
        <div class="form-item input-row">
            <label for="address" class="inline">Address</label>
            <input type="text" name="address" id="address" value="<?php echo $_POST['address']; ?>" class="input-text" validate="required:true" />
            <span class="error"><?php echo $errors['address']['message']; ?></span>
        </div>
        <div class="form-item input-row">
            <label for="town" class="inline">Town or City</label>
            <input type="text" name="town" id="town" value="<?php echo $_POST['town']; ?>" class="input-text" validate="required:true" />
            <span class="error"><?php echo $errors['town']['message']; ?></span>
        </div>
        <div class="form-item input-row">
            <label for="county" class="inline">County</label>
            <input type="text" name="county" id="county" value="<?php echo $_POST['county']; ?>" class="input-text" validate="required:true" />
            <span class="error"><?php echo $errors['county']['message']; ?></span>
        </div>
        <div class="form-item input-row">
            <label for="postcode" class="inline">Postcode</label>
            <input type="text" name="postcode" id="postcode" value="<?php echo $_POST['postcode']; ?>" class="input-text" validate="required:true" />
            <span class="error"><?php echo $errors['postcode']['message']; ?></span>
        </div>
    </div> <!-- END Fieldset 2 -->




    <div class="col-xs-* col-xs-12 fieldset email">
        <div class="form-item input-row">
            <label for="email" class="inline">Email address</label>
            <input type="email" name="email" id="email" value="<?php echo $_POST['email']; ?>" class="input-text" validate="required:true" />
            <span class="error"><?php echo $errors['email']['message']; ?></span>
        </div>
     </div> <!-- END Fieldset -->


        <div class="form-item radiogroup-row">
            <div class="label inline">Send me a fundraising pack by post<span class="error"><?php echo $errors['packpost']['message']; ?></span></div>
            <div class="radiogroup">
                <label><input type="radio" name="packpost" id="packpostyes" value="1" <?php echo ($_REQUEST['packpost'] =='1') ? 'checked="checked"':''; ?> validate="required:true" />Yes</label>    
                <label><input type="radio" name="packpost" id="packpostno" value="0" <?php echo ($_REQUEST['packpost'] =='0') ? 'checked="checked"':''; ?> validate="required:true" />No</label>    
            </div>            
        </div>
        <div class="form-item radiogroup-row">
            <div class="label inline">Create a JustGiving page?<span class="error"><?php echo $errors['createpage']['message']; ?></span></div>
            <div class="radiogroup">
                <label><input type="radio" name="createpage" id="createpageyes" value="1" <?php echo ($_POST['createpage']=='1') ? 'checked="checked"':''; ?> validate="required:true" />Yes</label>    
                <label><input type="radio" name="createpage" id="createpageno" value="0" <?php echo ($_POST['createpage'] =='0') ? 'checked="checked"':''; ?> validate="required:true" />No</label>    
            </div>            
        </div>
        <div class="optional clearfix" data-opt="createpage">
            <div class="form-item radiogroup-row">
                <div class="label inline">Do you have a JustGiving account<span class="error"><?php echo $errors['haveaccount']['message']; ?></span></div>
                <div class="radiogroup">
                    <label><input type="radio" name="haveaccount" id="haveaccountyes" value="1" <?php echo ($_POST['haveaccount']=='1') ? 'checked="checked"':''; ?> validate="required:true" />Yes</label>    
                    <label><input type="radio" name="haveaccount" id="haveaccountno" value="0" <?php echo ($_POST['haveaccount'] =='0') ? 'checked="checked"':''; ?> validate="required:true" />No</label>    
                </div>
                <p class="description createaccount">You can create a JustGiving account right now using the email address above. Simply create a password below and you&rsquo;re good to go.</p>
            </div>
            <div class="form-item input-row createaccount">
                <label for="password" class="inline">Create a JustGiving password</label>
                <input type="password" name="password" id="password" value="<?php echo $_POST['password']; ?>" class="input-text" validate="required:true" />
                <span class="error"><?php echo $errors['password']['message']; ?></span>
            </div>
            <div class="form-item input-row createaccount">
                <label for="cpassword" class="inline">Confirm password</label>
                <input type="password" name="cpassword" equalTo='#password' id="cpassword" value="<?php echo $_POST['cpassword']; ?>" class="input-text" validate="required:true" />
                <span class="error"><?php echo $errors['cpassword']['message']; ?></span>
            </div>
        </div>
     </div>
  	<div class="water-line-bottom"></div>


     <div class="row">
     <div class="col-xs-* col-xs-12 fieldset-submit water-line-top">  
        <div class="form-item input-row centered">
            <button class="button submit" title="<?php _e('Complete sign up', 'justgiving'); ?>" type="submit">
                <?php _e('Sign up', 'justgiving'); ?>
            </button>
        </div>
        <p class="form-submit">
            <input name="action" type="hidden" id="action" value="adduser" />
            <input type="hidden" name="formName" value="register" />
        </p><!-- .form-submit -->
		<?php 
        wp_nonce_field('verify_true_registration','register_nonce_field'); 
		?>
		<a class="back-home" href="<?php echo get_home_url(); ?>">Return to homepage</a>
	</div>
	</div>

    </form><!-- #adduser -->

<?php
    endif;
    $output = ob_get_contents();
    ob_end_clean();
	
    return $output;
}
?>