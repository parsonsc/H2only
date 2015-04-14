<?php
//function needed to check if the current page already has a ? sign in the address bar
if(!function_exists('jg_curpageurl_password_recovery')){
    function jg_curpageurl_password_recovery() {
        $pageURL = 'http';
        if ($_SERVER["SERVER_PORT"] == "443")
			$pageURL .= "s";
        $pageURL .= "://";  
        $pageURL .= $_SERVER["SERVER_NAME"];
        if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443")
			$pageURL .= ":".$_SERVER["SERVER_PORT"];        
        $pageURL .= $_SERVER["REQUEST_URI"];        
        $questionPos = strpos( (string)$pageURL, '?' );
        $submittedPos = strpos( (string)$pageURL, 'submitted=yes' );
        if ($submittedPos !== false)
            return $pageURL;
        elseif($questionPos !== false)
            return $pageURL.'&submitted=yes';
        else
            return $pageURL.'?submitted=yes';
    }
}


//function to display the password recovery page
function jg_front_end_password_recovery($atts){
    ob_start();
    global $current_user;
    global $wp_roles;
    global $wpdb;
    global $error;	
    global $jg_shortcode_on_front;
    global $wpdb;
    
    $linkLoginName = '';
    $linkKey = '';
    
    ob_start();
    extract(shortcode_atts(array('login'=> 0, 'display' => true), $atts));
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'recover_password' && wp_verify_nonce($_POST['password_recovery_nonce_field'],'verify_true_password_recovery') ) {
        $postedData = $_POST['username_email'];	//we get the raw data
        //check to see if it's an e-mail (and if this is valid/present in the database) or is a username
        if (is_email($postedData)){
            $jg_generalSettings = get_option('jg_general_settings');
            include_once(JG_PLUGIN_DIR.'/lib/JustGivingClient.php');
            $client = new JustGivingClient(
                $jg_generalSettings['ApiLocation'],
                $jg_generalSettings['ApiKey'],
                $jg_generalSettings['ApiVersion'],
                $jg_generalSettings['TestUsername'], $jg_generalSettings['TestValidPassword']);
            $hasJGAccount = $client->Account->IsEmailRegistered(trim($postedData));
            if ($hasJGAccount){
                $ret = $client->Account->RequestPasswordReminder($postedData);
                if (!$ret){
                    $recoverPasswordFilterArray['sentMessageCouldntSendMessage'] = '<strong>'. __('ERROR', 'justgiving') .': </strong>' . sprintf(__( 'There was an error while trying to send the activation link to %1$s!', 'justgiving'), $postedData);
                    $recoverPasswordFilterArray['sentMessageCouldntSendMessage'] = apply_filters('jg_recover_password_sent_message_error_sending', $recoverPasswordFilterArray['sentMessageCouldntSendMessage']);
                    $messageNo = '5';
                    $message = $recoverPasswordFilterArray['sentMessageCouldntSendMessage'];
                }
                else{
                    $permaLnk2 = '';
                    if (trim($login) != ''){
                        $permaLnk2 = trim($login);
                        if (intval($permaLnk2) != 0)
                            $permaLnk2 = get_permalink($permaLnk2);
                        else{
                            if (jg_check_missing_http($permaLnk2))
                                $permaLnk2 = 'http://'. $permaLnk2;
                        }
                    }
                    $message = __( 'A link has been sent to '.$postedData.' . Please follow that link to change your password', 'justgiving');
                    if (trim($permaLnk2) != '')
                        $message .= '<meta http-equiv="Refresh" content="3;url='.$permaLnk2.'" />';
                    $messageNo = '1';
                }
            }else{
                $recoverPasswordFilterArray['sentMessage2'] = __('The email address entered wasn\'t found in the database!', 'justgiving').'<br/>'.__('Please check that you entered the correct email address.', 'justgiving');
                $recoverPasswordFilterArray['sentMessage2'] = apply_filters('jg_recover_password_sent_message2', $recoverPasswordFilterArray['sentMessage2']);
                $messageNo = '2';
                $message = $recoverPasswordFilterArray['sentMessage2'];
            }
        }
    }
    
    /* use this action hook to add extra content before the password recovery form. */
    do_action( 'jg_before_recover_password_fields' );
    //display error message and the form
    if (($messageNo == '') || ($messageNo == '2') || ($messageNo == '4')){
        $recoverPasswordFilterArray['messageDisplay1'] = '<p class="warning">'.$message.'</p><!-- .warning -->';
        $recoverPasswordFilterArray['messageDisplay1'] = apply_filters('jg_recover_password_displayed_message1', $recoverPasswordFilterArray['messageDisplay1']);
        echo $recoverPasswordFilterArray['messageDisplay1'];
        echo '<form enctype="multipart/form-data" method="post" id="recover_password" class="user-forms" action="'.$address = jg_curpageurl_password_recovery().'">';

        echo '<div class="container login water-bg water-line-top">
				<div class=".col-xs-* col-xs-12">';

            $username_email = '';
            if (isset($_POST['username_email']))
                $username_email = $_POST['username_email'];
            $recoverPasswordFilterArray['input'] = '
                <div class="form-item input-row">
                    <label for="username_email">'. __('Please enter your registered email address', 'justgiving').'<span class="error">'. $errorMark.'</span></label>
                    <input name="username_email" type="email" id="username_email" value="'.trim($username_email).'" class="input-text" validate="required:true" />
                    <p class="description">'. __('You will receive a link to create a new password via email.', 'justgiving'). '</p>
                </div><!-- .username_email -->';
            $recoverPasswordFilterArray['input'] = apply_filters('jg_recover_password_input', $recoverPasswordFilterArray['input'], trim($username_email));
            echo $recoverPasswordFilterArray['input'];
?>
        <div class="form-item input-row centered">        

            <button class="button" title="<?php _e('Get New Password', 'justgiving'); ?>" type="submit" name="recover_password" id="recover_password">
                <?php _e('Get New Password', 'justgiving'); ?>
            </button>
            <input name="action" type="hidden" id="action" value="recover_password" />
            <?php wp_nonce_field('verify_true_password_recovery', 'password_recovery_nonce_field'); ?>
        </div>

        <div class="forgot-links">
	        <a class="back-home" href="<?php echo get_home_url(); ?>">Return to homepage</a> <span>|</span>
	        <a class="back-home" href="<?php echo get_home_url().'/login/'; ?>">Return to log in page</a>
        </div>

        </div></div>
        </form><!-- #recover_password -->
<?php
    }elseif (($messageNo == '5')  || ($messageNo == '6')){
        $recoverPasswordFilterArray['messageDisplay1'] = '
                <p class="warning">'.$message.'</p><!-- .warning -->';
        $recoverPasswordFilterArray['messageDisplay1'] = apply_filters('jg_recover_password_displayed_message1', $recoverPasswordFilterArray['messageDisplay1']);
        echo $recoverPasswordFilterArray['messageDisplay1'];
    }else{
        //display success message
        $recoverPasswordFilterArray['messageDisplay2'] = '
                <div class="grid-100"><p class="success">'.$message.'</p><!-- .success --></div>';

        $recoverPasswordFilterArray['messageDisplay2'] = apply_filters('jg_recover_password_displayed_message2', $recoverPasswordFilterArray['messageDisplay2']);
        echo $recoverPasswordFilterArray['messageDisplay2'];
    }
    /* use this action hook to add extra content after the password recovery form. */
    do_action( 'jg_after_recover_password_fields' );
    $output = ob_get_contents();
    ob_end_clean();
	
    return $output;
}    
?>