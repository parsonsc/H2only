<?php
if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}

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
        
    extract(shortcode_atts(array('forgot'=> 0, 'display' => true, 'redirect' => '', 'submit' => 'page', 'create' => '', 'thanks' => '', 'login' => '', 'template' => ''), $atts));
    $ordate = '';
    $errors = array();
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] 
        && !empty( $_POST['action'] ) 
        && $_POST['action'] == 'adduser' 
        && wp_verify_nonce($_POST['register_nonce_field'],'verify_true_registration') 
        && ($_POST['formName'] == 'register') ) {
        $default_role = get_option( 'default_role' );
        $user_pass = '';
        if (isset($_POST['password']))
            $user_pass = esc_attr( $_POST['password'] );
        $email = '';
        if (isset($_POST['email'])){
            $email = trim ($_POST['email']);
            $_SESSION['email'] = $email;
        }
        $_SESSION['optin'] = isset($_POST['optin']) ? $_POST['optin'] : 0;
        $_SESSION['country'] = isset($_POST['country']) ? $_POST['country'] : 0;
        $ordate = $_POST['dob'];
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
        /*
        if ($_POST['haveaccount'] == 0 &&
                $_POST['createpage'] == 1 &&
                (trim($userdata['user_pass']) == '' ||
                 trim($userdata['user_pass']) != trim($_POST['cpassword']))){

            $foundError = true;
        }
           */
        include_once(JG_PLUGIN_DIR.'/lib/functions.php');
        $results = array(
            'title' => '',
            'firstname' => '',
            'lastname' => '',
            'email' => '',
            'address' => '',
            'address2' => '',
            'town' => '',
            'county' => '',
            'postcode' => '',
            'packpost' => '',
            'createpage' => '',
            'haveaccount' => '',
            'optin' => 0,
            'country' => '',
            'heardabout' => '',
            'password' => '',
            'cpassword' => '',
            'tsandcs' => '',
        );	
        $rules = array(
            'title' => 'notEmpty',
            'title_alt' => 'other_title',
            'firstname' => 'notEmpty',
            'lastname' => 'notEmpty',
            'email' => 'email',
            'address' => 'notEmpty',
            /*'address2' => 'notEmpty',*/
            'town' => 'notEmpty',
            'postcode' => ($_POST['country'] == 'Ireland') ? '' : 'postCode',
            'createpage' => 'notEmpty',
            'country' => 'ukonly',
            'password' => 'length6',
           /* 'cpassword' => 'length6',*/
            'tsandcs' => 'notEmpty',            
        );
        $messages = array(
            'title' => 'Please choose your title',
            'firstname' => 'Please enter your first name',
            'lastname' => 'Please enter your surname',
            'email' => "Hmm. There's something wrong with this address. Please check.",
            'address' => 'Please enter your address',
            'address2' => 'Please enter your address',
            'town' => 'Please enter your town',
            'postcode' => 'Please enter your postcode',
            'packpost' => 'Would you like a fundraising pack',
            'createpage' => 'Would you like to create a fundraising page',
            'country' => 'ukonly',
            'password' => 'Please enter a password',
            /*'cpassword' => 'notEmpty',*/
            'tsandcs' => 'You must accept the terms and conditions'
        );    
        foreach ($results as $key => $value){
                $results[$key] = $_POST[$key];
        }
        

        
        $errors = validateJGInputs($results, $rules, $messages);
        if (count($errors) != 0) $foundError = true;
        if (($_POST['country'] != 'United Kingdom' && $_POST['country'] != 'Ireland') && $_POST['createpage'] == 1){
             $foundError = true;
             $errors['country']['message'] = "We're sorry - you can't create a JustGiving page from this country";
        }
        include_once(JG_PLUGIN_DIR.'/lib/JustGivingClient.php');
        $wpjg_generalSettings = get_option('jg_general_settings');
        $client = new JustGivingClient(
            $wpjg_generalSettings['ApiLocation'],
            $wpjg_generalSettings['ApiKey'],
            $wpjg_generalSettings['ApiVersion'],
            $wpjg_generalSettings['TestUsername'], $wpjg_generalSettings['TestValidPassword'], true);
        //print_R($errors);
        $hasJGAccount = $client->Account->IsEmailRegistered(trim($results['email']));

        if ($hasJGAccount){
            $errors['email']['message'] = 'A JustGiving account exists for that email address';
            $foundError = true;
        }
        //print_R($errors);
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
            if ($results['country'] == 'Ireland' ) $results['postcode'] = 'n/a';
            $wpdb->insert( 
                $wpdb->prefix . "jgusers", 
                array( 
                    'title' => ($results['title'] =='Other' && trim($results['other_title']) !== '') ? $results['other_title'] : $results['title'], 
                    'firstname' => $results['firstname'], 
                    'lastname' => $results['lastname'], 
                    'dob' => $results['dob'], 
                    'email' => $results['email'], 
                    'address' => isset($results['address']) ? $results['address'] : '', 
                    'address2' => isset($results['address2']) ? $results['address2'] : '', 
                    'towncity' => isset($results['town']) ? $results['town'] : '', 
                    'county' => isset($results['county']) ? $results['county'] : '', 
                    'postcode' => isset($results['postcode']) ? $results['postcode'] : '',
                    'packbypost' => isset($results['packpost']) ? $results['packpost'] : '',
                    'cpage' => isset($results['createpage']) ? $results['createpage'] : '',
                    'hasaccount' => isset($results['haveaccount']) ? $results['haveaccount'] : '',
                    'userEnc' => base64_encode($results['email'].':'.trim($userdata['user_pass'])),
                    'pageurl' => '',
                    'signupdate' => time(),
                    'optin' => isset($results['optin']) ? $results['optin'] : 0,
                    'country' => isset($results['country']) ? $results['country'] : '',
                    'heardabout' => isset($results['heardabout']) ? $results['heardabout'] : '',
                    'tsandcs' => $_POST['tandcs']
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
                    '%s',
                    '%d',
                    '%d',
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
                    $_SESSION['userEnc'] = base64_encode($results['email'].':'.trim($userdata['user_pass']));
                
                    $redirectLink = trim($login);
                    if (intval($redirectLink) != 0)
                        $redirectLink = get_permalink($redirectLink);
                    else{
                        if (jg_check_missing_http($redirectLink))
                            $redirectLink = 'http://'. $redirectLink;
                    }
                    wp_redirect( $redirectLink ); exit;
                }
                elseif ((intval(trim($redirect)) != 0)){
                    $redirectLink = get_permalink($redirect);
                    wp_redirect( $redirectLink );
                    exit;
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

                if ($_POST['haveaccount'] == 0  && trim($userdata['user_pass']) != '' ){

                //include_once(JG_PLUGIN_DIR.'/lib/ApiClients/Model/CreateAccountRequest.php');
                    $request = array();
                    $request['email'] = trim($results['email']);
                    $request['firstName'] = $results['firstname'];
                    $request['lastName'] = $results['lastname'];
                    $request['password'] = trim($userdata['user_pass']);
                    $request['title'] = ($results['title'] =='Other' && trim($results['other_title']) !== '') ? $results['other_title']: $results['title'];
                    $request['address']['line1'] = trim($results['address']);
                    $request['address']['line2'] = trim($results['address2']);
                    $request['address']['countyOrState'] = trim($results['county']);
                    $request['address']['townOrCity'] = trim($results['town']);
                    $request['address']['postcodeOrZipcode'] = trim($results['postcode']);
                    $request['address']['country'] = trim($results['country']);
                    $request['acceptTermsAndConditions'] = true;

                    $response = $client->Account->Create($request);
                    //$current = print_R($_POST, true);
                    //file_put_contents('curldata.txt', $current, FILE_APPEND);
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
                        //$current = print_R('goto a' .$redirectLink, true);
                        //file_put_contents('curldata.txt', $current, FILE_APPEND);

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
                        //$current = print_R('goto b' .$redirectLink, true);
                        //file_put_contents('curldata.txt', $current, FILE_APPEND);
                        $vars = array(
                            'firstname' => $results['firstname']
                        );
                        sendthanks($results['email'], $results['firstname']. ' '. $results['lastname'], $vars, 0);                           
                        wp_redirect( $redirectLink );
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
                        //$current = print_R('goto c' .$redirectLink, true);
                        //file_put_contents('curldata.txt', $current, FILE_APPEND);

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
                        $vars = array(
                            'firstname' => $results['firstname']
                        );
                        sendthanks($results['email'], $results['firstname']. ' '. $results['lastname'], $vars, 0);      
                        //$current = print_R('goto d' .$redirectLink, true);
                        //file_put_contents('curldata.txt', $current, FILE_APPEND);                        
                        wp_redirect( $redirectLink );
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
    // if ( $registration || current_user_can( 'create_users' ) ) :
    require_once(JG_PLUGIN_DIR.'/lib/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->template_dir = JG_PLUGIN_DIR.'/smarty/templates/';
    $smarty->compile_dir  = JG_PLUGIN_DIR.'/smarty/templates_c/';
    $smarty->config_dir   = JG_PLUGIN_DIR.'/smarty/configs/';
    $smarty->cache_dir    = JG_PLUGIN_DIR.'/smarty/cache/';
   
    $smarty->assign('formurl', jg_curpageurl());
    $smarty->assign('Errors', $errors);

    include_once(JG_PLUGIN_DIR.'/lib/JustGivingClient.php');
    $wpjg_generalSettings = get_option('jg_general_settings');
    $client = new JustGivingClient(
        $wpjg_generalSettings['ApiLocation'],
        $wpjg_generalSettings['ApiKey'],
        $wpjg_generalSettings['ApiVersion'],
        $wpjg_generalSettings['TestUsername'], $wpjg_generalSettings['TestValidPassword']);
        
    $countries = get_transient('justgiving_countries')  ;
    if (DEBUG){
        $countries = NULL;
    }  

    if (!$countries){
        $countries = $client->Country->GetCountries();
    } 
    //print_r($countries);
    if (!DEBUG){
        set_transient('justgiving_countries', $countries, 60 * 60 * 12); // 1/2 day storage
    }
    include_once(JG_PLUGIN_DIR.'/lib/functions.php');

    if (!isset($_POST['country']) || $_POST['country'] == '') $_POST['country'] ="United Kingdom";
    $smarty->assign('countries', $countries);  
    
    $smarty->assign('maxdate', date('Y-m-d'));
    

    if (isset($_POST['dob'])) $_POST['dob'] = $ordate;
    
    $smarty->assign('Get', $_GET);    
    $smarty->assign('Post', $_POST);
    $smarty->assign('nonce', wp_nonce_field('verify_true_registration','register_nonce_field', true, false)); 
    $smarty->assign('home',get_home_url());
    $smarty->assign('settings', $wpjg_generalSettings);    
    if ($template != '') $smarty->display($template);    
    else $smarty->display('register.html');
    
    $output = ob_get_contents();
    ob_end_clean();
	
    return $output;
}
?>