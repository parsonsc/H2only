<?php
function jg_front_end_view_user($atts){
    if(session_id() == '' || !isset($_SESSION)) {
        // session isn't started
        session_start();
    }

    global $current_user;
    global $wp_roles;
    global $wpdb;
    global $error;	
    global $js_shortcode_on_front;
           
    extract(shortcode_atts(array('forgot'=> 0, 'display' => true, 'redirect' => '', 'teampage' => '', 'submit' => 'page', 'create' => '', 'thanks' => '', 'template' => ''), $atts));

    if (!isset($_SESSION['userEnc']) || trim($_SESSION['userEnc']) == '' ){
        $redirectLink = trim(home_url());
        if (intval($redirectLink) != 0)
            $redirectLink = get_permalink($redirectLink);
        else{
            if (jg_check_missing_http($redirectLink))
                $redirectLink = 'http://'. $redirectLink;
        }
        //echo $redirectLink ;
        wp_redirect( $redirectLink ); exit;
    }
    
    include_once(JG_PLUGIN_DIR.'/lib/JustGivingClient.php');
    $wpjg_generalSettings = get_option('jg_general_settings');
    $client = new JustGivingClient(
        $wpjg_generalSettings['ApiLocation'],
        $wpjg_generalSettings['ApiKey'],
        $wpjg_generalSettings['ApiVersion'],
        $wpjg_generalSettings['TestUsername'], $wpjg_generalSettings['TestValidPassword'], true);
    
    $user = $client->Account->GetUser(trim($_SESSION['userEnc']));
    if ($user){
        //print_R($user);
        $userRows = $wpdb->get_results(" SELECT * FROM {$wpdb->prefix}jgusers WHERE `email`='{$user->email}';");
        //print_R($userRows);
        $pages = $client->Page->ListAll(trim($_SESSION['userEnc']));
        
        $teams = $client->Team->Search();
        
        $pagecount = 0;
        foreach ($pages as $page){
            //print_R($page);
            if ($page->charityId == $wpjg_generalSettings['Charity']) 
            {
                if (strlen(trim($wpjg_generalSettings['Event'])) > 0 
                    && $page->eventId == $wpjg_generalSettings['Event'] ) 
                {
                    $pagecount++;
                    if ($teams)
                    {
                        print_R($teams);
                    }
                    else
                    {       
                        $uniqueId = uniqid();            
                        $request = array();
                        $request['teamShortName'] = "team".$uniqueId ;
                        $request['name'] = "team".$uniqueId;
                        $request['story'] = "story".$uniqueId;
                        $request['targetType'] = "Aggregate";
                        $request['teamType'] = "ByInvitationOnly";
                        $request['teamMembers'] = array(array(
                            'pageShortName' => $page->pageShortName
                        ));
                        $response = $client->Team->Create($request, trim($_SESSION['userEnc']));
                        if ($response == 1){
                            $response = $client->Team->Get($request['teamShortName']);
                            print_R($response);
                        }                        
                    }
                    print_R($page);                
                }
            }            
        }
        if ($pagecount == 0){
?>        
            <p><a href="<?php echo get_permalink( 7 ); ?>">Create page</a></p>
<?php            
        }
        /*
        require_once(JG_PLUGIN_DIR.'/lib/Smarty.class.php');
        $smarty = new Smarty();
        $smarty->template_dir = JG_PLUGIN_DIR.'/smarty/templates/';
        $smarty->compile_dir  = JG_PLUGIN_DIR.'/smarty/templates_c/';
        $smarty->config_dir   = JG_PLUGIN_DIR.'/smarty/configs/';
        $smarty->cache_dir    = JG_PLUGIN_DIR.'/smarty/cache/';
       
        $formurl = jg_curpageurl();
        $smarty->assign('pageshortname',stripslashes($_POST['pageshortname']));
        $smarty->assign('errorshortname',$errors['shortname']['message']); 
        $smarty->assign('pagetitle', stripslashes($_POST['pagetitle']));
        $smarty->assign('errorpagetitle', $errors['pagetitle']['message']); 
        $smarty->assign('nonce', wp_nonce_field('verify_true_create','createpage_nonce_field', true, false)); 
        $smarty->assign('jgoptinyes', ($_POST['jgoptin'] =='1' || !isset($_REQUEST['jgoptin'])) ? 'checked="checked"':'');
        $smarty->assign('jgoptinno', ($_POST['jgoptin'] =='0') ? 'checked="checked"':'');
        $smarty->assign('choptinyes', ($_POST['charityoptin']=='1' || ($_SESSION['optin'] == 1 && $_POST['charityoptin'] != 0)  || (!isset($_REQUEST['charityoptin']) && (!isset($_SESSION['optin']) || $_SESSION['optin'] != 0))) ? 'checked="checked"':'');
        $smarty->assign('choptinno', ($_POST['charityoptin'] =='0') ? 'checked="checked"':'');
        $smarty->assign('settings', $wpjg_generalSettings);        
        $smarty->assign('formurl', $formurl);
        $smarty->display('create-page.html');    
        */
    }
    $output = ob_get_contents();
    ob_end_clean();
	
    return $output;
}   