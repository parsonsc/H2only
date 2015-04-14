<?php 

require_once 'class-homepage-list-table.php';
require_once 'class-homepage-creator.php';

class Homepage_View {

	private $controller;
	private $list_table;
	private $creator;
	
	function __construct($controller) {
		
		$this->controller = $controller;
	}
	
	function add_metaboxes() {
		//add_meta_box('overview_features', __('homepage Slider Features', 'homepage_blocks'), array($this, 'show_features'), 'homepage_overview', 'features', '');
		//add_meta_box('overview_upgrade', __('Upgrade to Commercial Version', 'homepage_blocks'), array($this, 'show_upgrade_to_commercial'), 'homepage_overview', 'upgrade', '');
		//add_meta_box('overview_news', __('homepage News', 'homepage_blocks'), array($this, 'show_news'), 'homepage_overview', 'news', '');
		//add_meta_box('overview_contact', __('Contact Us', 'homepage_blocks'), array($this, 'show_contact'), 'homepage_overview', 'contact', '');
	}
	
	function show_upgrade_to_commercial() {
		/*?>
		<ul class="homepage-feature-list">
			<li>Use on commercial websites</li>
			<li>Remove the homepage.com watermark</li>
			<li>Priority techincal support</li>
			<li><a href="http://www.homepage.com/order/?product=slider" target="_blank">Upgrade to Commercial Version</a></li>
		</ul>
		<?php*/
	}
	
	function show_news() {
		/*
		include_once( ABSPATH . WPINC . '/feed.php' );
		
		$rss = fetch_feed( 'http://www.homepage.com/feed/' );
		
		$maxitems = 0;
		if ( ! is_wp_error( $rss ) )
		{
			$maxitems = $rss->get_item_quantity( 5 );
			$rss_items = $rss->get_items( 0, $maxitems );
		}
		?>
		
		<ul class="homepage-feature-list">
		    <?php if ( $maxitems > 0 ) {
		        foreach ( $rss_items as $item )
		        {
		        	?>
		        	<li>
		                <a href="<?php echo esc_url( $item->get_permalink() ); ?>" target="_blank" 
		                    title="<?php printf( __( 'Posted %s', 'homepage_blocks' ), $item->get_date('j F Y | g:i a') ); ?>">
		                    <?php echo esc_html( $item->get_title() ); ?>
		                </a>
		                <p><?php echo $item->get_description(); ?></p>
		            </li>
		        	<?php 
		        }
		    } ?>
		</ul>
		<?php
        */
	}
	
	function show_features() {
		/*?>
		<ul class="homepage-feature-list">
			<li>Support images, YouTube, Vimeo and MP4/WebM videos</li>
			<li>Works on mobile, tablets and all major web browsers, including iPhone, iPad, Android, Firefox, Safari, Chrome, Internet Explorer 7/8/9/10/11 and Opera</li>
			<li>Amazing transition effects</li>
			<li>Pre-defined professional skins</li>
			<li>Fully responsive</li>
			<li>Easy-to-use wizard style user interface</li>
			<li>Instantly preview</li>
			<li>Provide shortcode and PHP code to insert the slider to pages, posts or templates</li>
		</ul>
		<?php*/
	}
	
	function show_contact() {
		/*?>
		<p>Priority technical support is available for Commercial Version users at support@homepage.com. Please include your license information, WordPress version, link to your slider, all related error messages in your email.</p> 
		<?php*/
	}
	
	function print_overview() {
		
		?>
		<div class="wrap">
		<div id="icon-homepage" class="icon32"><br /></div>
			
		<h2><?php echo __( 'Homepage blocks', 'homepage_blocks' ); ?> </h2>
		 
		<div id="welcome-panel" class="welcome-panel">
			<div class="welcome-panel-content">
				<div class="welcome-panel-column-container">
					<div class="welcome-panel-column">
						<h4>Get Started</h4>
						<a class="button button-primary button-hero" href="<?php echo admin_url('admin.php?page=homepage_add_new'); ?>">Create A New set</a>
					</div>
					<div class="welcome-panel-column welcome-panel-last">
						<h4>More Actions</h4>
						<ul>
							<li><a href="<?php echo admin_url('admin.php?page=homepage_show_items'); ?>" class="welcome-icon welcome-widgets-menus">Manage Existing block pages</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
            
		<?php
	}
	
	
	function print_edit_settings() {
	?>
		<div class="wrap">
		<div id="icon-homepage" class="icon32"><br /></div>
			
		<h2><?php _e( 'Settings', 'homepage_blocks' ); ?> </h2>
		<?php

		if ( isset($_POST['save-slider-options']))
		{		
			unset($_POST['save-slider-options']);
			
			$this->controller->save_settings($_POST);
			
			echo '<div class="updated"><p>Settings saved.</p></div>';
		}
						
		$userrole = $this->controller->get_userrole();
		
		?>
		
		<h3>This page is only available for users of Administrator role.</h3>
		
        <form method="post">
        
        <table class="form-table">
        
        <tr valign="top">
			<th scope="row">Set minimum user role</th>
			<td>
				<select name="userrole">
				  <option value="Administrator" <?php echo ($userrole == 'manage_options') ? 'selected="selected"' : ''; ?>>Administrator</option>
				  <option value="Editor" <?php echo ($userrole == 'moderate_comments') ? 'selected="selected"' : ''; ?>>Editor</option>
				  <option value="Author" <?php echo ($userrole == 'upload_files') ? 'selected="selected"' : ''; ?>>Author</option>
				</select>
			</td>
		</tr>
				
        </table>
        
        <p class="submit"><input type="submit" name="save-slider-options" id="save-slider-options" class="button button-primary" value="Save Changes"  /></p>
        
        </form>
        
		</div>
		<?php
	}
		
	function print_items() {
		
		?>
		<div class="wrap">
		<div id="icon-homepage" class="icon32"><br /></div>
			
		<h2><?php _e( 'Manage block pages', 'homepage_blocks' ); ?> <a href="<?php echo admin_url('admin.php?page=homepage_add_new'); ?>" class="add-new-h2"> <?php _e( 'New block page', 'homepage_blocks' ); ?></a> </h2>
		
		<?php $this->process_actions(); ?>
		
		<form id="slider-list-table" method="post">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
		<?php 
		
		if ( !is_object($this->list_table) )
			$this->list_table = new Homepage_List_Table($this);
		
		$this->list_table->list_data = $this->controller->get_list_data();
		$this->list_table->prepare_items();
		$this->list_table->display();		
		?>								
        </form>
        
		</div>
		<?php
	}
	
	function print_item()
	{
		if ( !isset( $_REQUEST['itemid'] ) )
			return;
		
		?>
		<div class="wrap">
		<div id="icon-homepage" class="icon32"><br /></div>
					
		<h2><?php _e( 'View block page', 'homepage_blocks' ); ?> <a href="<?php echo admin_url('admin.php?page=homepage_edit_item') . '&itemid=' . $_REQUEST['itemid']; ?>" class="add-new-h2"> <?php _e( 'Edit Slider', 'homepage_blocks' ); ?>  </a> </h2>
		
		<div class="updated"><p style="text-align:center;">  <?php _e( 'To embed the block page into your page, use shortcode', 'homepage_blocks' ); ?> <strong><?php echo esc_attr('[homepage id="' . $_REQUEST['itemid'] . '"]'); ?></strong></p></div>

		<div class="updated"><p style="text-align:center;">  <?php _e( 'To embed the block page into your template, use php code', 'homepage_blocks' ); ?> <strong><?php echo esc_attr('<?php echo do_shortcode(\'[homepage id="' . $_REQUEST['itemid'] . '"]\'); ?>'); ?></strong></p></div>
		
		<?php
		echo $this->controller->generate_body_code( $_REQUEST['itemid'], true ); 
		?>	 
		
		</div>
		<?php
	}
	
	function process_actions()
	{
		
		if ( isset($_REQUEST['action']) && ($_REQUEST['action'] == 'delete') && isset( $_REQUEST['itemid'] ) )
		{
			$deleted = 0;
			
			if ( is_array( $_REQUEST['itemid'] ) )
			{
				foreach( $_REQUEST['itemid'] as $id)
				{
					$ret = $this->controller->delete_item($id);
					if ($ret > 0)
						$deleted += $ret;
				}
			}
			else
			{
				$deleted = $this->controller->delete_item( $_REQUEST['itemid'] );
			}
			
			if ($deleted > 0)
			{
				echo '<div class="updated"><p>';
				printf( _n('%d block page deleted.', '%d block pages deleted.', $deleted), $deleted );
				echo '</p></div>';
			}
		}
		
		if ( isset($_REQUEST['action']) && ($_REQUEST['action'] == 'clone') && isset( $_REQUEST['itemid'] ) )
		{
			$cloned_id = $this->controller->clone_item( $_REQUEST['itemid'] );
			if ($cloned_id > 0)
			{
				echo '<div class="updated"><p>';
				printf( 'New block page created with ID: %d', $cloned_id );
				echo '</p></div>';
			}
			else
			{
				echo '<div class="error"><p>';
				printf( 'The block page cannot be cloned.' );
				echo '</p></div>';
			}
		}
	}

	function print_add_new() {
		
		?>
		<div class="wrap">
		<div id="icon-homepage" class="icon32"><br /></div>
			
		<h2><?php _e( 'New block page', 'homepage_blocks' ); ?> <a href="<?php echo admin_url('admin.php?page=homepage_show_items'); ?>" class="add-new-h2"> <?php _e( 'Manage block pages', 'homepage_blocks' ); ?>  </a> </h2>
		
		<?php 
		$this->creator = new Homepage_Creator($this);		
		echo $this->creator->render( -1, null);
	}
	
	function print_edit_item()
	{
		if ( !isset( $_REQUEST['itemid'] ) )
			return;
	
		?>
		<div class="wrap">
		<div id="icon-homepage" class="icon32"><br /></div>
			
		<h2><?php _e( 'Edit block page', 'homepage_blocks' ); ?> <a href="<?php echo admin_url('admin.php?page=homepage_show_item') . '&itemid=' . $_REQUEST['itemid']; ?>" class="add-new-h2"> <?php _e( 'View block page', 'homepage_blocks' ); ?>  </a> </h2>
		
		<?php 
		$this->creator = new Homepage_Creator($this);
		echo $this->creator->render( $_REQUEST['itemid'], $this->controller->get_item_data( $_REQUEST['itemid'] ) );
	}
	
}