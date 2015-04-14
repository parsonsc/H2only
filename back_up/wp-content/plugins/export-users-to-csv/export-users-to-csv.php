<?php
/**
 * @package Export_Users_to_CSV
 */
/*
Plugin Name: Export Users to CSV
Description: Export Users data and metadata to a csv file.
Version: 400000
*/

load_plugin_textdomain( 'export-users-to-csv', false, basename( dirname( __FILE__ ) ) . '/languages' );

/**
 * Main plugin class
 *
 * @since 0.1
 **/
class PP_EU_Export_Users {

	/**
	 * Class contructor
	 *
	 * @since 0.1
	 **/
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
		add_action( 'init', array( $this, 'generate_csv' ) );
		add_filter( 'pp_eu_exclude_data', array( $this, 'exclude_data' ) );
	}

	/**
	 * Add administration menus
	 *
	 * @since 0.1
	 **/
	public function add_admin_pages() {
		add_users_page( __( 'Export to CSV', 'export-users-to-csv' ), __( 'Export to CSV', 'export-users-to-csv' ), 'list_users', 'export-users-to-csv', array( $this, 'users_page' ) );
	}

	/**
	 * Process content of CSV file
	 *
	 * @since 0.1
	 **/
	public function generate_csv() {

		if ( isset( $_POST['_wpnonce-pp-eu-export-users-users-page_export'] ) ) {
			check_admin_referer( 'pp-eu-export-users-users-page_export', '_wpnonce-pp-eu-export-users-users-page_export' );

			$args = array(
				'fields' => 'all_with_meta',
				'role' => stripslashes( $_POST['role'] )
			);


			$sitename = sanitize_key( get_bloginfo( 'name' ) );
			if ( ! empty( $sitename ) )
				$sitename .= '.';
			$filename = 'H2O_import_' . date( 'Ymd' ) . '.csv';

			header( 'Content-Description: File Transfer' );
			header( 'Content-Disposition: attachment; filename=' . $filename );
			header( 'Content-Type: text/csv; charset=' . get_option( 'blog_charset' ), true );

			global $wpdb;
            $hdata_keys = array(
                'H2Only Microsite' => array('value' => 'Y'),
                'Fundraiser User ID' => array('field'=>'id'),
                'Fundraiser Title' => array('field'=>'title', 'type'=> 'noother'),
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
                'Send Pack' => array('field'=>'packbypost', 'type'=>'bool')
            );

            $headers = array();
            foreach ( $hdata_keys as $name => $field ) {    
                if ( in_array( $field, $exclude_data ) )
                    unset( $hdata_keys[$name] );
                else
                    $headers[] = '"' . $name . '"';
            }
                            
            $where = '';
            if (empty( $_POST['start_date']) && empty( $_POST['end_date'])){
                $where = "signupdate <= '". strtotime('midnight') ."' AND signupdate >= '". strtotime('-1 day midnight')."'";
            }
            if ( ! empty( $_POST['start_date'] ) ){
                $where .= (strlen($where) > 0) ? ' AND ':'';
                $where .= $wpdb->prepare( " signupdate >= %s", strtotime( $_POST['start_date'] .' midnight' ) );
            }
            if ( ! empty( $_POST['end_date'] ) ) {
                $where .= (strlen($where) > 0) ? ' AND ':'';
                $where .= $wpdb->prepare( " signupdate < %s", strtotime( $_POST['end_date'] .' +1 day midnight' ) ) ;
            }
            else{
                $where .= (strlen($where) > 0) ? ' AND ':'';
                $where .= $wpdb->prepare( " signupdate < %s", strtotime( '+1 month midnight', strtotime( $_POST['start_date'] ) ) ) ;            
            }
       
            $users = $wpdb->get_results($wpdb->prepare( " SELECT * FROM ".$wpdb->prefix."jgusers WHERE ". $where ." AND firstname != ''" ) );
            //print_R($wpdb->prepare( " SELECT * FROM ".$wpdb->prefix."jgusers WHERE ". $where ));
            //exit;            
			echo implode( ',', $headers ) . "\n";
			//$data = array();
			//$data[] = $headers;
            foreach ( $users as $user ) {
                $data = array();
                foreach ( $hdata_keys as $def => $field ) {
                    $ldata = '';
                    if (isset($field['field'])){
                        $ldata = isset( $user->{trim($field['field'])} ) ? stripslashes($user->{trim($field['field'])}) : '';
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
                                case 'noother':
                                    $ldata = (stripos($ldata, 'other') !== false && strlen(trim($ldata)) == 5) ? '' : $ldata;
                                    break;
                                default:
                                    echo 
                                    $ldata = stripslashes($ldata);
                                    break;
                            }
                        }                
                    }
                    else if (isset($field['value'])){
                        $ldata = stripslashes($field['value']);
                    }
                    if ($ldata != '' && (strpos( $ldata, trim($ldata) ) !== false)){
                        $data[] = '"' . str_replace( '"', '""', str_replace( ',', '', trim($ldata) ) ) . '"';						
                    }
                    else $data[] = '"' . str_replace( '"', '""', '' ) . '"';	                    
                }
                echo implode( ',', $data ) . "\n";
            }
		
			//print_R($data);
			exit;
		}
	}

	/**
	 * Content of the settings page
	 *
	 * @since 0.1
	 **/
	public function users_page() {
    
		wp_register_script( 'date.js', plugin_dir_url( __FILE__ ) . 'date.js', array('jquery'), '2.0.0' );
		wp_enqueue_script( 'date.js' );
        
        global $wp_scripts;
        wp_register_script( 
            'bgiframe', 
            plugin_dir_url( __FILE__ ) . 'jquery.bgiframe.min.js',  
            '1.0.2', 
            false 
            );
        $wp_scripts->add_data( 'bgiframe', 'conditional', 'IE' );    
        wp_enqueue_script( 'bgiframe' );
    
		wp_register_script( 'datePicker', plugin_dir_url( __FILE__ ) . 'jquery.datePicker.js', array('jquery'), '2.0.0' );
		wp_enqueue_script( 'datePicker' );    
        wp_enqueue_style( 'datePicker', plugin_dir_url( __FILE__ ) . 'datePicker.css', array(), '2013-10-14' );

		if ( ! current_user_can( 'list_users' ) )
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'export-users-to-csv' ) );
            
        $dates = $this->export_date_options();

?>
<style type="text/css">
a.dp-choose-date {
	float: left;
	width: 16px;
	height: 16px;
	padding: 0;
	margin: 5px 3px 0;
	display: block;
	text-indent: -2000px;
	overflow: hidden;
	background: url(<?php echo plugin_dir_url( __FILE__ );?>calendar.png) no-repeat; 
}
a.dp-choose-date.dp-disabled {
	background-position: 0 -20px;
	cursor: default;
}
/* makes the input field shorter once the date picker code
 * has run (to allow space for the calendar icon
 */
input.dp-applied {
	width: 140px;
	float: left;
}
</style>
<script type="text/javascript" charset="utf-8">
    jQuery(document).ready(function ($) {
        $('.date-pick').datePicker(
		{
			startDate: '<?php echo $dates['first']; ?>',
			endDate: '<?php echo $dates['last']; ?>'
		}
		);
    });
</script>

<div class="wrap">
	<h2><?php _e( 'Export users to a CSV file', 'export-users-to-csv' ); ?></h2>
	<?php
	if ( isset( $_GET['error'] ) ) {
		echo '<div class="updated"><p><strong>' . __( 'No user found.', 'export-users-to-csv' ) . '</strong></p></div>';
	}
	?>
	<form method="post" action="" enctype="multipart/form-data">
		<?php wp_nonce_field( 'pp-eu-export-users-users-page_export', '_wpnonce-pp-eu-export-users-users-page_export' ); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label><?php _e( 'Date range user registered', 'export-users-to-csv' ); ?></label></th>
				<td>
                    <label><?php _e( 'Start Date', 'export-users-to-csv' ); ?></label><br />
					<input name="start_date" id="pp_eu_users_start_date" value="" class="date-pick" /><br /><br />
					<label><?php _e( 'End Date', 'export-users-to-csv' ); ?></label><br />
					<input name="end_date" id="pp_eu_users_end_date" value="" class="date-pick" />
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="hidden" name="_wp_http_referer" value="<?php echo $_SERVER['REQUEST_URI'] ?>" />
			<input type="submit" class="button-primary" value="<?php _e( 'Export', 'export-users-to-csv' ); ?>" />
		</p>
	</form>
<?php
	}

	public function exclude_data() {
		$exclude = array( 'user_pass', 'user_activation_key' );

		return $exclude;
	}

	private function export_date_options() {
		global $wpdb, $wp_locale;
        $wpdb->show_errors = true;
		$months = $wpdb->get_results( $wpdb->prepare("SELECT min(signupdate) AS first_date, max(signupdate) AS last_date FROM ".$wpdb->prefix."jgusers"  ." WHERE firstname != '';" ));
		return array(
            'first' => date('Y-m-d',$months[0]->first_date),
            'last' => date('Y-m-d',$months[0]->last_date),
            );
	}

}

new PP_EU_Export_Users;
