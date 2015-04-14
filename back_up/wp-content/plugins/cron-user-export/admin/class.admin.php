<?php if (!defined('CRONEXPORT_VERSION')) exit('No direct script access allowed');
class CR_Admin{
    private $version = NULL;

    function __construct(){
        $this->version = CRONEXPORT_VERSION;
    }
    function cronexport_initialize(){
        // check for activation
        $check = get_option( 'cronexport_activation' );
        register_setting( 'cr_general_settings', 'cr_general_settings' );
        // redirect on activation
        if ($check != "set") {   
            // add theme options
            add_option( 'cronexport_activation', 'set');
            // load DB activation function if updating plugin
            $this->cronexport_activate();
            // Redirect
            wp_redirect( admin_url().'users.php?page=CronExportOptionsAndSettings' );
        }
        return false;
    }
    
    function cronexport_deactivate() {
        // remove activation check & version
        delete_option( 'cronexport_activation' );
        delete_option( 'cronexport_version' );
        
        // Flush rewrite rules when deactivated
        flush_rewrite_rules();
    }
    
    function cronexport_admin(){  
        // create menu item
        $cronexport_options = add_submenu_page( 'users.php', 'CronExport', 'CronExport', 'delete_users', 'CronExportOptionsAndSettings', array( $this, 'cronexport_options_page' ) );
        // add menu item
        //add_action( "admin_print_styles-$cronexport_options", array( $this, 'cronexport_load' ) );
    }
    
    function cronexport_options_page() {
        // Grab Options Page
        include( CR_PLUGIN_DIR.'/admin/options.php' );
    }    
    
    function cronexport_activate(){
        $wppb_default_settings = array(
            'Server' => 	"https://api-staging.cronexport.com/",
            'ApiKey' => 	"decbf1d2",
            'Username' 	=> "david.gurney@thegoodagency.co.uk",
            'ValidPassword' => "DGcp!091",
            'RemotePath' => ""
        );
        add_option( 'cr_general_settings', $wppb_default_settings);        
    }
}
?>