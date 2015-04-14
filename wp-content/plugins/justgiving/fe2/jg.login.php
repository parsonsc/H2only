<?php
global $wpjg_login; 
$wpjg_login = false;
session_start();

function wpjg_signon(){	
    global $error;
    global $wpjg_login;
    global $wpdb;
    
    $wpjg_generalSettings = get_option('jg_general_settings');

    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'log-in' && wp_verify_nonce($_POST['login_nonce_field'],'verify_true_login') && ($_POST['formName'] == 'login') ){

        /*wrong password - but maybe they changed the password at justgiving */
        include_once(JG_PLUGIN_DIR.'/lib/JustGivingClient.php');
        $client = new JustGivingClient(
            $wpjg_generalSettings['ApiLocation'],
            $wpjg_generalSettings['ApiKey'],
            $wpjg_generalSettings['ApiVersion'],
            $wpjg_generalSettings['TestUsername'], $wpjg_generalSettings['TestValidPassword']);        

        $hasJGAccount = $client->Account->IsEmailRegistered(trim($_POST['user-name']));
        if($hasJGAccount){
            /* if login JG change password */
            $ret = $client->Account->ValidateAccount(trim($_POST['user-name']), trim($_POST['password']) );
            if ($ret->isValid ){   
                $_SESSION['email'] = trim($_POST['user-name']);
                $_SESSION['userEnc'] = base64_encode($_POST['user-name'].':'.trim($_POST['password']));
                /*if in db then nothing else new row*/
            }                  
            else  $wpjg_login = new WP_Error('login', __("Password incorrect"));
        }
        else  $wpjg_login = new WP_Error('login', __("no Login"));
    }
}
add_action('init', 'wpjg_signon');

function jg_front_end_login( $atts ){
    $loginFilterArray = array();
    ob_start();

    global $wpjg_login;
    $wpjg_generalSettings = get_option('jg_general_settings');
    extract(shortcode_atts(array('forgot'=> 0, 'display' => true, 'redirect' => '', 'register'=> 0, 'create'=> 0, 'submit' => 'page'), $atts));
    $passworderror = '';
    $usernameerror = '';
    //echo $permaLnk2;
    if ( isset($_SESSION['userEnc']) ){ // Successful login
        $permaLnk2 = jg_curpageurl();
        if (trim($create) != ''){
            $permaLnk2 = trim($create);
            if (intval($permaLnk2) != 0)
                $permaLnk2 = get_permalink($permaLnk2);
            else{
                if (jg_check_missing_http($permaLnk2))
                    $permaLnk2 = 'http://'. $permaLnk2;
            }
        }
        $loginFilterArray['redirectMessage'] = '<font id="messageTextColor">' . sprintf(__('You will soon be redirected automatically. If you see this page for more than 1 second, please click %1$s', 'justgiving'), '<a href="'.$permaLnk2.'">'. __('here', 'justgiving').'</a>.<meta http-equiv="Refresh" content="1;url='.$permaLnk2.'" />') . '</font><br/><br/>';
        echo $loginFilterArray['redirectMessage'] = apply_filters('wppb_login_redirect_message', $loginFilterArray['redirectMessage'], $permaLnk2);
    }else{ // Not logged in
        if (!empty( $_POST['action'] ) && isset($_POST['formName']) ){
            if ($_POST['formName'] == 'login'){
?>
                <p class="error">
<?php 
                    if (trim($_POST['user-name']) == ''){
                        if (isset($wpjg_generalSettings['loginWith']) && ($wpjg_generalSettings['loginWith'] == 'email')){
                            $loginFilterArray['emptyUsernameError'] = __('The email field is empty', 'justgiving').'.'; 
                            $loginFilterArray['emptyUsernameError'] = apply_filters('wpjg_login_empty_email_as_username_error_message', $loginFilterArray['emptyUsernameError']);                                    
                        }else{
                            $loginFilterArray['emptyUsernameError'] = __('The username field is empty', 'justgiving').'.'; 
                            $loginFilterArray['emptyUsernameError'] = apply_filters('wpjg_login_empty_username_error_message', $loginFilterArray['emptyUsernameError']);
                        }
                        $usernameerror = $loginFilterArray['emptyUsernameError'];
                    }elseif (trim($_POST['password']) == ''){
                        $loginFilterArray['emptyPasswordError'] = __('The password field is empty', 'justgiving').'.'; 
                        $loginFilterArray['emptyPasswordError'] = apply_filters('wpjg_login_empty_password_error_message', $loginFilterArray['emptyPasswordError']);
                        
                        $passworderror =  $loginFilterArray['emptyPasswordError'];
                    }

                    if ( is_wp_error($wpjg_login) ){
                        $loginFilterArray['wpError'] = 'Incorrect password';
                        $loginFilterArray['wpError'] = apply_filters('wpjg_login_wp_error_message', $loginFilterArray['wpError'],$wpjg_login);
                        $passworderror =  $loginFilterArray['wpError'];
                    }
?>
                </p><!-- .error -->
<?php
            }
        }
        /* use this action hook to add extra content before the login form. */
	do_action( 'wppb_before_login' );?>	
	<form action="<?php jg_curpageurl(); ?>" method="post" class="user-forms" name="loginForm">

	<div class="container login water-bg water-line-top">
		<div class="col-xs-* col-xs-12">
        <?php
        if (isset($_POST['user-name']))
            $userName = esc_html( $_POST['user-name'] );
        else if (isset($_SESSION['email']))
            $userName = esc_html( $_SESSION['email'] );
        else $userName = '';
        
        $loginFilterArray['loginUsername'] = '
            <div class="form-item input-row">
                <label for="user-name">'. __('Your email address', 'justgiving') .'</label>
                <span class="error">'.$usernameerror.'</span>
                <input type="email" name="user-name" id="user-name" class="input-text" value="'.$userName.'"  validate="required:true" />
                
            </div><!-- .form-username -->';
        $loginFilterArray['loginUsername'] = apply_filters('wpjg_login_username', $loginFilterArray['loginUsername'], $userName);
        echo $loginFilterArray['loginUsername'];
        $loginFilterArray['loginPassword'] = '
            <div class="form-item input-row">
                <label for="password">'. __('Password', 'justgiving') .'</label>
                <span class="error">'.$passworderror.'</span>
                <input type="password" name="password" id="password" class="input-text"  validate="required:true" />
                
            </div><!-- .form-password -->';
        $loginFilterArray['loginPassword'] = apply_filters('wpjg_login_password', $loginFilterArray['loginPassword']);
        echo $loginFilterArray['loginPassword'];        
        ?>

        
        </div>
        <?php
            if ($display === true){
                $siteURL = get_permalink($forgot);
                $loginFilterArray['loginURL'] = '
                    
                    <div class="forgot-pwd"><a href="'.$siteURL.'">'. __('Lost password?', 'justgiving').'</a></div>';
                $loginFilterArray['loginURL'] = apply_filters('wpjg_login_url', $loginFilterArray['loginURL'], $siteURL);
                echo $loginFilterArray['loginURL'];
            }
            ?>
      </div>


    <div class="container login">
     <div class="row">
     	<div class="col-xs-* col-xs-12 fieldset-submit water-line-bottom"> 
        <div class="form-item input-row centered">        
            <button title="<?php _e('Login', 'justgiving'); ?>" class="button" type="submit">
		<?php _e('Login', 'justgiving'); ?>
            </button>
            
	    <input type="hidden" name="action" value="log-in" />
            <input type="hidden" name="button" value="<?php echo $submit;?>" />
            <input type="hidden" name="formName" value="login" />
            <?php
            wp_nonce_field('verify_true_login','login_nonce_field'); ?>

            <a class="back-home" href="<?php echo get_home_url(); ?>">Return to homepage</a>
        </div>
        </div>
    </div>
    </div>

	</form><!-- .sign-in -->

	<?php         
    }
    /* use this action hook to add extra content after the login form. */
    do_action( 'wppb_after_login' );	
    $output = ob_get_contents();
    ob_end_clean();
    $loginFilterArray = apply_filters('wpjg_login', $loginFilterArray);
    return $output;
}    
?>