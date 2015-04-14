<?php
/*
Plugin Name: Homepage blocks
*/

define('HOMEPAGE_VERSION', '2.9');
define('HOMEPAGE_URL', plugin_dir_url( __FILE__ ));
define('HOMEPAGE_PATH', plugin_dir_path( __FILE__ ));

require_once 'app/class-homepage-controller.php';

class Homepage_Plugin {
	
	function __construct() {
	
		$this->init();
	}
	
	public function init() {
		
		// init controller
		$this->homepage_controller = new Homepage_Controller();
		
		add_action( 'admin_menu', array($this, 'register_menu') );
		add_action( 'init', array($this, 'register_script') );
		

		add_shortcode( 'homepage', array($this, 'shortcode_handler') );	

		if ( is_admin() )
		{
			add_action( 'wp_ajax_homepage_save_item', array($this, 'wp_ajax_save_item') );
			add_action( 'admin_init', array($this, 'admin_init_hook') );
		}
	}
	
	function register_menu()
	{
		$userrole = $this->get_userrole();
		
		$menu = add_menu_page(
				__('HomePage Blocks', 'homepage_blocks'),
				__('HomePage Blocks', 'homepage_blocks'),
				$userrole,
				'homepage_overview',
				array($this, 'show_overview'),
				HOMEPAGE_URL . 'images/logo-16.png' );
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'homepage_overview',
				__('Overview', 'homepage_blocks'),
				__('Overview', 'homepage_blocks'),
				$userrole,
				'homepage_overview',
				array($this, 'show_overview' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'homepage_overview',
				__('New Block page', 'homepage_blocks'),
				__('New Block page', 'homepage_blocks'),
				$userrole,
				'homepage_add_new',
				array($this, 'add_new' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'homepage_overview',
				__('Manage Block pages', 'homepage_blocks'),
				__('Manage Block pages', 'homepage_blocks'),
				$userrole,
				'homepage_show_items',
				array($this, 'show_items' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'homepage_overview',
				__('Settings', 'homepage_blocks'),
				__('Settings', 'homepage_blocks'),
				'manage_options',
				'homepage_edit_settings',
				array($this, 'edit_settings' ) );
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				null,
				__('View Block page', 'homepage_blocks'),
				__('View Block page', 'homepage_blocks'),	
				$userrole,	
				'homepage_show_item',	
				array($this, 'show_item' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				null,
				__('Edit Block page', 'homepage_blocks'),
				__('Edit Block page', 'homepage_blocks'),
				$userrole,
				'homepage_edit_item',
				array($this, 'edit_item' ) );
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
	}
	
	function register_script()
	{
		//wp_register_script('homepage-skins-script', HOMEPAGE_URL . 'engine/homepagesliderskins.js', array('jquery'), HOMEPAGE_VERSION, false);
		wp_register_script('homepage-script', HOMEPAGE_URL . 'engine/homepage.js', array('jquery'), HOMEPAGE_VERSION, false);
		wp_register_script('homepage-creator-script', HOMEPAGE_URL . 'app/homepage-creator.js', array('jquery'), HOMEPAGE_VERSION, false);
		wp_register_style('homepage-css', HOMEPAGE_URL . 'engine/homepageengine.css');
		wp_register_style('homepage-admin-style', HOMEPAGE_URL . 'homepage.css');
	}
	
	function enqueue_script()
	{
		//wp_enqueue_script('homepage-skins-script');

	}
	
	function enqueue_admin_script($hook)
	{
		wp_enqueue_script('post');
		if (function_exists("wp_enqueue_media"))
		{
			wp_enqueue_media();
		}
		else
		{
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
			wp_enqueue_script('media-upload');
		}
		//wp_enqueue_script('homepage-skins-script');
		wp_enqueue_script('homepage-script');
		wp_enqueue_script('homepage-creator-script');
		wp_enqueue_style('homepage-css');
		wp_enqueue_style('homepage-admin-style');
	}

	function admin_init_hook()
	{
		// change text of history media uploader
		if (!function_exists("wp_enqueue_media"))
		{
			global $pagenow;
			
			if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
				add_filter( 'gettext', array($this, 'replace_thickbox_text' ), 1, 3 );
			}
		}
		
		// add meta boxes
		//$this->homepage_controller->add_metaboxes();
	}
	
	function replace_thickbox_text($translated_text, $text, $domain) {
		
		if ('Insert into Post' == $text) {
			$referer = strpos( wp_get_referer(), 'homepage' );
			if ( $referer != '' ) {
				return __('Insert into homepage', 'homepage_blocks' );
			}
		}
		return $translated_text;
	}
	
	function show_overview() {
		
		$this->homepage_controller->show_overview();
	}
	
	function show_items() {
		
		$this->homepage_controller->show_items();
	}
	
	function add_new() {
		
		$this->homepage_controller->add_new();
	}
	
	function show_item() {
		
		$this->homepage_controller->show_item();
	}
	
	function edit_item() {
	
		$this->homepage_controller->edit_item();
	}
	
	function edit_settings() {
	
		$this->homepage_controller->edit_settings();
	}
	
	function get_userrole() {
	
		return $this->homepage_controller->get_userrole();
	}
	
	function shortcode_handler($atts) {
		
		if ( !isset($atts['id']) )
			return __('Please specify a block page id', 'homepage_blocks');
		wp_enqueue_script('homepage-script');
		wp_enqueue_style('homepage-css');
		return $this->homepage_controller->generate_body_code( $atts['id'], false);
	}
	
	function wp_ajax_save_item() {

		$items = json_decode(stripcslashes($_POST["item"]), true);
		
		foreach ($items as $key => &$value)
		{
			if ($value === true)
				$value = "true";
			
			if ($value === false)
				$value = "false";
		}
		
		if (isset($items["slides"]) && count($items["slides"]) > 0)
		{
			foreach ($items["slides"] as $key => &$slide)
			{
				foreach ($slide as $key => &$value)
				{
					if ($value === true)
						$value = "true";
						
					if ($value === false)
						$value = "false";
				}
			}
		}
		
		header('Content-Type: application/json');
		echo json_encode($this->homepage_controller->save_item($items));
		die();
	}
	
}

/**
 * Init the plugin
 */
$homepage_plugin = new Homepage_Plugin();

/**
 * Global php function
 * @param $id
 */
function homepage_blocks($id) {

	echo $homepage_plugin->homepage_controller->generate_body_code($id, false);
}

/**
 * Uninstallation
 */
function homepage_uninstall() {

	global $wpdb;
	$table_name = $wpdb->prefix . "homepage_blocks";
	$wpdb->query("DROP TABLE IF EXISTS $table_name");
}

if ( function_exists('register_uninstall_hook') )
{
	register_uninstall_hook( __FILE__, 'homepage_uninstall' );
}

//define('HOMEPAGE_VERSION_TYPE', 'F');
