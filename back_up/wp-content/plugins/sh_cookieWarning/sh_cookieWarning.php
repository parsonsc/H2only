<?php
/*
Plugin Name: sh_cookieWarning
Plugin URI: http://adf.ly/IvElY
Description: Automatically generates tag's for new and updated posts
Version: 1.2
Author: Scott herbert
Author URI: http://scott-herbert.com
*/
define( 'COOK_PLUGIN_URL', str_replace("http:","",plugins_url( 'sh_cookieWarning' ) ) );
if ( is_admin() ){
// Add the admin action
    add_action('admin_menu', 'sh_cookieWarning_admin_menu');
}
add_action('wp_enqueue_scripts', 'sh_cookieWarning_header'); 
add_action( 'admin_init', 'register_cookieWarningsetting' );

function register_cookieWarningsetting() {
	register_setting( 'cookieWarning_options', 'sh_cookieWarningMessage'); 
	register_setting( 'cookieWarning_options', 'sh_cookieWarningStyle'); 
} 


function sh_cookieWarning_admin_menu() {
add_options_page('Cookie Warning', 'Cookie warning settings', 'administrator',
'sh_cookieWarning-slug', 'sh_cookieWarning_html_page');
}

function sh_cookieWarning_html_page() {
if (!current_user_can('manage_options'))  {
	wp_die( __('You do not have sufficient permissions to access this page.') );
} else {
?>
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<?php settings_fields('cookieWarning_options'); ?>
<table width="510">
<tr valign="top">
<th width="192" scope="row">Warning Message</th>
<td width="406">
<textarea name="sh_cookieWarningMessage" id="sh_cookieWarningMessage" rows="10" cols="50" class="large-text code"><?php echo get_option('sh_cookieWarningMessage'); ?></textarea>
</td>
</tr>
<tr valign="top">
<th width="192" scope="row">Select the style</th>
<td width="406">


<input type="checkbox" name="sh_cookieWarningStyle" value="4" <?PHP if(get_option('sh_cookieWarningStyle')=="4") echo"checked"; ?>/> <img src="<?php
	echo get_option('siteurl') . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/4.jpg';
?>" /></br>
</td>
</tr>
</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="sh_cookieWarningMessage" />
<input type="hidden" name="page_options" value="sh_cookieWarningStyle" />
<p>
<input type="submit" value="<?php _e('Save Changes') ?>" />
</p>

</form>

<?Php
	}
}

function sh_cookieWarning_header(){
    wp_enqueue_script('cookiewarning', COOK_PLUGIN_URL .'/js/cookiewarning4.js', array('jquery'));
}