<?php   
/*   
    Plugin Name: Cron User export  

*/

/* get the admin setup to add settings */
define( 'CR_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) );
define( 'CRONEXPORT_VERSION', '1.0.0' );

$cr_admin = CR_PLUGIN_DIR . '/admin/';	
if (file_exists ( $cr_admin.'class.admin.php' ))	require_once($cr_admin.'class.admin.php');
$CR_Admin = new CR_Admin();
register_activation_hook( __FILE__, array( $CR_Admin, 'cronexport_activate' ) );
register_deactivation_hook( __FILE__, array( $CR_Admin, 'cronexport_deactivate' ) );
add_action( 'admin_init', array( $CR_Admin, 'cronexport_initialize' ) );
add_action( 'admin_menu', array( $CR_Admin, 'cronexport_admin' ) );

/* The activation hook is executed when the plugin is activated. */
register_activation_hook(__FILE__,'cronexport_activation');

/* The deactivation hook is executed when the plugin is deactivated */
register_deactivation_hook(__FILE__,'cronexport_deactivation');

/* This function is executed when the user activates the plugin */
function cronexport_activation(){  
    if (!wp_next_scheduled('cron_usersexport'))
        wp_schedule_event(time(), 'daily', 'cron_usersexport');
}

/* This function is executed when the user deactivates the plugin */
function cronexport_deactivation(){  
    wp_clear_scheduled_hook('cron_usersexport');
}

/* We add a function of our own to the my_hook action. */
add_action('cron_usersexport','output_csv');


/* This is the function that is executed by the hourly recurring action my_hook */
function output_csv(){   
    //do something.
    global $wpdb, $wp_locale;

	if (file_exists(CR_PLUGIN_DIR. '/tempfiles/results_'. strtotime('midnight') .'.csv')) break;
    
    $hdata_keys = array(
        'H2Only Microsite' => array('value' => 'Y'),
        'Fundraiser User ID' => array('field'=>'id'),
        'Fundraiser Title' => array('field'=>'title'),
        'Fundraiser First Name' => array('field'=>'firstname'),
        'Fundraiser Last Name' => array('field'=>'lastname'),
        'Fundraiser Address Line 1' => array('field'=>'address'),
        'Fundraiser Address Line 2' => array('value' => ''),
        'Fundraiser Town/City' => array('field'=>'towncity'),
        'Fundraiser County/State' => array('field'=>'county'),
        'Fundraiser Post/Zip Code' => array('field'=>'postcode'),
        'Fundraiser Country' => array('field'=>'country'),
        'Fundraiser E-mail' => array('field'=>'email'),
        'Fundraiser Further Contact' => array('field'=>'optin', 'type'=>'bool'),
        'Fundraiser DOB' => array('field'=>'dob', 'type'=>'date', 'format' => 'd/m/Y'),
        'Page Created Date' => array('field'=>'signupdate', 'type'=>'date', 'format' => 'd/m/Y'),
        'Event ID' => array('value' => '1300871'),
        'Event Source code' => array('value' => 'NPH2014M'),
        'Send Pack' => array('field'=>'packbypost')
    );

    $headers = array();
    foreach ( $hdata_keys as $name => $field ) {    
        if ( in_array( $field, $exclude_data ) )
            unset( $hdata_keys[$name] );
        else
            $headers[] = $name;
    }
    //print_R($headers); 
    
    $outfile = CR_PLUGIN_DIR. '/tempfiles/results_'. strtotime('midnight') .'.csv';
    
    $fp = fopen($outfile, 'w');
    //print_R($headers);
    //exit;            
    fputcsv($fp, $headers);

    
    $users = $wpdb->get_results($wpdb->prepare( "
        SELECT * FROM ".$wpdb->prefix."jgusers WHERE signupdate <= '".strtotime('midnight')."' 
         AND signupdate >= '".strtotime('-1 day midnight')." AND firstname != '' 
    " ));

    /*
    $users = $wpdb->get_results($wpdb->prepare( "
        SELECT * FROM ".$wpdb->prefix."jgusers;" ));
    */
    foreach ( $users as $user ) {
        $data = array();
        foreach ( $hdata_keys as $def => $field ) {
            $ldata = '';
            if (isset($field['field'])){
                $ldata = isset( $user->{trim($field['field'])} ) ? $user->{trim($field['field'])} : '';
                if (isset($field['type'])){
                    switch ($field['type']){
                        case 'bool':
                            $ldata = ($ldata == 1) ? 'Yes': 'No';
                            break;
                        case 'date':
                            if (!preg_match('/^\d+$/', trim($ldata))){
                                $ldata = preg_replace('/\D+/', '/', trim($ldata));
                            }
                            else $ldata = date($field['format'], $ldata);
                            break;
                    }
                }                
            }
            else if (isset($field['value'])){
                $ldata = $field['value'];
            }
            $data[] = $ldata;
        }
        fputcsv($fp, $data);
    }
    fclose($fp);

    /*
    include(CR_PLUGIN_DIR .'/phpseclib/Net/SFTP.php');
    
    $cron_Settings = get_option('cr_general_settings');
    if (!isset($cron_Settings['Server']) || 
        !isset($cron_Settings['Username'])|| 
        !isset($cron_Settings['ValidPassword'])
        ) break;
    $sftp = new Net_SFTP($cron_Settings['Server']);
    if (!$sftp->login($cron_Settings['Username'], $cron_Settings['ValidPassword'])) {
        break;
    }
    $files = glob(CR_PLUGIN_DIR .'/tempfiles/*.{csv}', GLOB_BRACE);
    foreach($files as $file) {
        echo $file;
        $tfile = str_replace(CR_PLUGIN_DIR .'/tempfiles/' , '', $file);
        if (trim($cron_Settings['RemotePath']) != '') {
            if (substr($cron_Settings['RemotePath'], -1) !== DIRECTORY_SEPARATOR ){
                 $tfile = $cron_Settings['RemotePath'] . DIRECTORY_SEPARATOR . $tfile;
            }
            else $tfile = $cron_Settings['RemotePath'] . $tfile;
        }
        if ($sftp->put($tfile, $file, NET_SFTP_LOCAL_FILE)){
            unlink($file);
        }
    }
    */
}
?>