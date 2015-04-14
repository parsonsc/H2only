<?php
/*
Plugin Name: Homepage Blocks
Description: Homepage blocks 
Author: David Gurney
Version: 1.0
Author URI: http://www.thegoodagency.co.uk
*/

class HomepageBlocks {
	var $meta_fields = array("block_link","block_link_copy");
	function HomepageBlocks()
	{
		// Register custom post types
		register_post_type('homepage_block', array(
			'labels' => array(
					'name' => __( 'Homepage blocks' ),
					'singular_name' => __( 'Homepage block' ),
					'add_new' => _x('Add New', 'homepage_block'),
					'add_new_item' => __('Add New Homepage block'),
					'edit_item' => __('Edit Homepage Block'),
					'new_item' => __('New Homepage Block'),
					'view_item' => __('View Homepage Block'),
					'search_items' => __('Search Homepage Blocks'),
					'not_found' =>  __('No Homepage Blocks found'),
					'not_found_in_trash' => __('No Homepage Blocks found in Trash'), 
					'parent_item_colon' => '',
					'menu_name' => 'Homepage blocks'				
			),
			'public' => true,
			'label' => __('Homepage blocks'),
			'singular_label' => __('Homepage block'),
			'public' => true,
			'exclude_from_search' => true,
			'show_ui' => true, // UI in admin panel
			'_builtin' => false, // It's a custom post type, not built in
			'_edit_link' => 'post.php?post=%d',
			'capability_type' => 'post',
			'hierarchical' => false,			
			'query_var' => "homepage_block",			
			'supports' => array('title', 'thumbnail', 'revisions', 'page-attributes', 'editor'),
            'has_archive' => false,
		));
		
		// Insert post hook
		add_action("save_post", array(&$this, "wp_insert_post"), 10, 2);
	}
	

	
		
	// When a post is inserted or updated
	function wp_insert_post($post_id, $post = null)
	{
		if ($post->post_type == "homepage_block")
		{
			// Loop through the POST data
			foreach ($this->meta_fields as $key)
			{
				$value = @$_POST[$key];
				if (empty($value))
				{
					delete_post_meta($post_id, $key);
					continue;
				}

				// If value is a string it should be unique
				if (!is_array($value))
				{
					// Update meta
					if (!update_post_meta($post_id, $key, $value))
					{
						// Or add the meta data
						add_post_meta($post_id, $key, $value);
					}
				}
				else
				{
					// If passed along is an array, we should remove all previous data
					delete_post_meta($post_id, $key);
					
					// Loop through the array adding new values to the post meta as different entries with the same name
					foreach ($value as $entry)
						add_post_meta($post_id, $key, $entry);
				}
			}
		}
	}
	
}

// Initiate the plugin
add_action("init", "HomepageBlocksInit");
function HomepageBlocksInit() { global $hpblock; $hpblock = new HomepageBlocks(); }