<?php
/**
 * H2Only functions and definitions.
 *
 */

if ( ! isset( $content_width ) )
	$content_width = 604;

if ( ! current_user_can( 'manage_options' ) ) {
    show_admin_bar( false );
}     

function callback($buffer){
    return $buffer;
}

function add_ob_start(){
    ob_start("callback");
}

function flush_ob_end(){
    ob_end_flush();
}
add_action('init', 'add_ob_start');
add_action('wp_footer', 'flush_ob_end');
/**
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Thirteen supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since 
 *
 * @return void
 */
function h2only_setup() {

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'editor-style.css' ) );

	// Switches default core markup for search form, comment form, and comments
	// to output valid HTML5.
	add_theme_support( 'html5', array( 'search-form' ) );

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Navigation Menu', 'h2only' ) );
	register_nav_menu( 'topnav', __( 'Top Right menu', 'h2only' ) );
	register_nav_menu( 'footer', __( 'Footer menu', 'h2only' ) );
	register_nav_menu( 'sitemap', __( 'Site map', 'h2only' ) );
    
	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 621, 350, true );
    add_image_size( 'news-thumb', 220, 135, true );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'h2only_setup' );

function my_favicon() { 
	$out = "\n\t".'<link rel="icon" href="'. get_bloginfo('template_directory'). '/favicon.ico" />'."\n";
    echo $out;
}
add_action('wp_head', 'my_favicon');


add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}

add_filter( 'mce_buttons_2', 'h2only_buttons' );
function h2only_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

add_filter( 'image_send_to_editor', 'h2only_image_to_editor', 10, 8 ); 
function h2only_image_to_editor( $html, $id, $caption, $title, $align, $url, $size, $alt )
{
    $html = get_image_tag($id, '', $title, $align, $size);
    $html5 = '<div class="article-media-item figure align'. $align .'" id="post-'. $id .'-media-'. $id .'">';
    $capt = '';
    if ($caption) {
        $capt = '<div class="footer">'.$caption.'</div>';
    }    
    $html5 .= '<img src="'.$url.'" alt="'.$title.'" class="size-'.$size.'" />'.$capt;
    $html5 .= "</div>";
    return $html5;
}

add_filter( 'tiny_mce_before_init', 'h2only_mce_before_init' );
function h2only_mce_before_init( $settings ) {

	$style_formats = array(
    	array(
    		'title' => 'Big Button CTA',
    		'selector' => 'a', // --- * This means it will only work with links * ---
    		'classes' => 'button'
    	),
        array(
    		'title' => 'Floating image left',
    		'selector' => 'img', 
    		'classes' => 'left-float'
    	),
        array(
    		'title' => 'Floating image right',
    		'selector' => 'img', 
    		'classes' => 'right-float'
    	),
        array(
    		'title' => 'Large copy',
    		'selector' => 'p', 
    		'classes' => 'large'
    	),
        array(
    		'title' => 'Droplet list',
    		'selector' => 'ul', 
    		'classes' => 'drop'
    	),
    	array(
    		'title' => 'Red copy',
            'inline' => 'span', 
    		'classes' => 'the-red',
            'wrapper' => true
    	),        
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;
}
function h2only_main_title($title) {
    if ( is_user_logged_in() ){
        global $current_user;
        get_currentuserinfo();
        $title = str_replace("<name>", $current_user->user_firstname, $title);
    }
	return str_replace("~", "", $title);
}

function h2only_mod_title($title) {
	if (!is_admin()) {
        $title = preg_replace('/~/','<strong>',$title,1);
		$title = preg_replace('/~/','</strong>',$title,1);
        $title = str_replace('H2Only','H<sub>2</sub>Only', $title);
	}
    if ( is_user_logged_in() ){
        global $current_user;
        get_currentuserinfo();
        $title = str_replace("<name>", $current_user->user_firstname, $title);
    }
	return str_replace("~", "", $title);
}

add_filter('the_title', 'h2only_mod_title', 3, 1);
add_filter( 'wp_title', 'h2only_main_title', 3, 1);
add_filter( 'wpseo_title', 'h2only_main_title', 3, 1);

function add_markup_pages($output) {
    if (!is_admin()){
        $output = preg_replace('/class="page_item/', 'class="first page-item', $output, 1);
        //echo $output . strripos($output, 'class="page_item') . '||'.strlen('class="page_item');
        if (strripos($output, 'class="page_item')){
            $output = substr_replace($output, 'class="last page-item', strripos($output, 'class="page_item'), strlen('class="page_item'));
        }
        else{
            $output = substr_replace($output, 'last page-item', strripos($output, 'page-item'), strlen('page-item'));
        }
    }
    return $output;
}
add_filter('wp_list_pages', 'add_markup_pages');

function add_markup_nav($output) {
    if (!is_admin()){
        if (stripos($output, 'class="menu-item')){
            $output = substr_replace($output, 'class="first menu-item', stripos($output, 'class="menu-item'), strlen('class="menu-item'));
        }
        if (strripos($output, 'class="menu-item')){
            $output = substr_replace($output, 'class="last menu-item', strripos($output, 'class="menu-item'), strlen('class="menu-item'));
        }
        else{
            $output = substr_replace($output, 'last menu-item', strripos($output, 'menu-item'), strlen('menu-item'));
        }    
    }
    return $output;
}
add_filter('wp_nav_menu', 'add_markup_nav');

function h2only_nav_menu($args){
	$args['echo'] = 0;
	$current_url = get_permalink();
	$the_menu = wp_nav_menu( $args );
	//$the_menu = wp_list_pages($args );
	$pos = strpos($the_menu, "current-menu-item");
	if ($pos === false) {
		if ( in_category(7) || post_is_in_descendant_category('7') ) {
			$the_menu = str_replace("nav-case-studies","nav-case-studies current-page-ancestor",$the_menu);
		}
		elseif ( in_category( '6' ) || post_is_in_descendant_category('6') ) {
			$the_menu = str_replace("nav-news","nav-news current-page-ancestor",$the_menu);
		}
	}
    if ( is_user_logged_in() ){
        $the_menu = str_replace(get_permalink(15),  get_permalink(188), $the_menu);
    }

    $the_menu = str_replace(get_permalink(13),  get_permalink(824).'?nologin', $the_menu);

	$the_menu = preg_replace('/\s+id="[^"]*"/','',$the_menu);	
	$the_menu = str_replace("menu-item menu-item-type-custom menu-item-object-custom","",$the_menu);
	$the_menu = str_replace("menu-item menu-item-type-post_type menu-item-object-page","",$the_menu);

	//$the_menu = preg_replace("<li class=\"page([a-zA-Z0-9\-\_]+)\spage([a-zA-Z0-9\-\_]+)\scurrent_page_ancestor\scurrent_page_parent\">","li class=\"selected\"",$the_menu);
	$menu = $the_menu;  
	//$menu .= '</ul></div>'. "\n";  
	print $menu;  	
}

function post_is_in_descendant_category( $cats, $_post = null ){
	foreach ( (array) $cats as $cat ) {
		// get_term_children() accepts integer ID only
		$descendants = get_term_children( (int) $cat, 'category');
		if ( $descendants && in_category( $descendants, $_post ) )
			return true;
	}
	return false;
}



//Making jQuery Google API
function modify_jquery() {
    if (!is_admin() && !in_array( $GLOBALS['pagenow'], array( 'wp-login.php' ) ) ) {
		wp_deregister_script('jquery');
        wp_register_script('jquery', ('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'), false, null, true);
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'modify_jquery');


if ( !is_admin() ) :
/**
 * Hack to display fallback JavaScript *right* after jQuery loaded.
 */
function __jquery_fallback( $src, $handle = null )
{
    static $run_next = false;

    if ( $run_next ) {
        $local = get_template_directory_uri() . '/js/lib/jquery.min.js';
        echo <<<JS
<script type="text/javascript">/*//<![CDATA[*/window.jQuery || document.write('<script type="text/javascript" src="$local"><\/script>');/*//]]>*/</script>

JS;
        $run_next = false;
    }

    if ( $handle === 'jquery' )
        $run_next = true;
    return $src;
}
add_filter( 'script_loader_src', '__jquery_fallback', 10, 2 );
add_action( 'wp_foot', '__jquery_fallback', 2 );
endif;

/**
 * Enqueues scripts and styles for front end.
 *
 *
 * @return void
 */
function h2only_scripts_styles() {
	// Adds JavaScript to pages with the comment form to support sites with
	// threaded comments (when in use).
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
        
	// Loads our main stylesheets.
    $httpHost = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '' ;
       
    $linkurl = '';

    //wp_register_style('typoFonts', $linkurl);
    
	wp_enqueue_style( 'reset', get_template_directory_uri() . '/css/reset.css', array(), '2014-3-21' );
	//wp_enqueue_style( 'fonts', '//f.fontdeck.com/s/css/I+7V/2ZBKU5S9V0kveK9CHDgBZw/www.h2only.org.uk/43943.css', array(), '2014-3-21' );

	//wp_enqueue_style( 'grid', get_template_directory_uri() . '/css/grid.css', array(), '2014-3-21' );
	//wp_enqueue_style( 'screen', get_template_directory_uri() . '/css/screen.css', array(), '2014-3-21' );
	wp_enqueue_style( 'smooth', get_template_directory_uri() . '/css/smoothness/jquery-ui-1.10.3.custom.min.css', array(), '2014-3-21' );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '' );
	wp_enqueue_style( 'custom', get_template_directory_uri() . '/css/custom.css', array(), '' );
    // wp_enqueue_style( 'ui-slide-style', get_template_directory_uri().'/css/jquery.nouislider.css' );
    wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', array(), '' );

    
	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'ie', get_template_directory_uri() . '/css/ie.css', array( 'h2only-style' ), '2014-3-21' );
	wp_style_add_data( 'ie', 'conditional', 'lt IE 8' );


    wp_enqueue_script( 'ui-slider', get_template_directory_uri().'/js/lib/jquery.nouislider.min.js' );
    
    global $wp_scripts;
    wp_register_script( 
        'selectivizr', 
        get_template_directory_uri() . '/js/lib/selectivizr-1.0.2.min.js',false, null,  
        false 
    );
    $wp_scripts->add_data( 'selectivizr', 'conditional', '(gte IE 6) & (lte IE 8)' );    
    wp_enqueue_script( 'selectivizr' );


    wp_enqueue_script( 'selectivizr' );

    wp_register_script( 
        'modernizr',
        get_template_directory_uri() . '/js/lib/modernizr-2.6.2.min.js', 
        false, 
        null,
        false
    );
    wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.6.2.min.js', array(), false );
    wp_register_script( 
        'html5shiv', 
        get_template_directory_uri() . '/js/lib/html5shiv.js', 
        false, 
        null,
        false
    );
    $wp_scripts->add_data( 'html5shiv', 'conditional', 'lt IE 9' );    
    wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/lib/html5shiv.js', array(), false  );
    	     
	wp_enqueue_script( 'h2only-css3', get_template_directory_uri() . '/js/lib/css3-mediaqueries.js', array( 'jquery' ), '2014-3-21', true );
    //wp_enqueue_script( 'h2only-jquery-ui', get_template_directory_uri() . '/js/plug/jquery-ui-1.10.3.custom.min.js', array( 'jquery' ), '2014-3-21', true );
	//wp_enqueue_script( 'h2only-icheck', get_template_directory_uri() . '/js/plug/jquery.icheck.min.js', array( 'jquery' ), '2014-3-21', true );
	//wp_enqueue_script( 'h2only-customselect', get_template_directory_uri() . '/js/plug/jquery.customSelect.min.js', array( 'jquery' ), '2014-3-21', true );
    wp_enqueue_script( 'h2only-punch', get_template_directory_uri() . '/js/plug/jquery.ui.touch-punch.min.js', array( 'jquery' ), '2014-3-21', true );
	wp_enqueue_script( 'h2only-validate', get_template_directory_uri() . '/js/plug/jquery.validate.min.js', array( 'jquery' ), '2014-3-21', true );
    wp_enqueue_script( 'h2only-meanmenu', get_template_directory_uri() . '/js/plug/jquery.meanmenu.2.0.min.js', array( 'jquery' ), '2014-3-21', true );
    wp_enqueue_script( 'h2only-placeholder', get_template_directory_uri() . '/js/plug/placeholders.min.js', array( 'jquery' ), '2014-3-21', true );	
    //wp_enqueue_script( 'h2only-postcodes', get_template_directory_uri() . '/js/plug/jquery.postcodes.js', array( 'jquery' ), '2014-3-21', true );	
    wp_enqueue_script( 'h2only-main', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '2014-3-21', true );
    wp_enqueue_script( 'h2only-plugins', get_template_directory_uri() . '/js/plugins.js', array( 'jquery' ), '2014-3-21', true );
}
add_action( 'wp_enqueue_scripts', 'h2only_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since 
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function h2only_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'h2only' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'h2only_wp_title', 10, 2 );

/**
 * Registers two widget areas.
 *
 * @since 
 *
 * @return void
 */
function h2only_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area', 'h2only' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the footer section of the site.', 'h2only' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Widget Area', 'h2only' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'h2only' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'h2only_widgets_init' );

if ( ! function_exists( 'h2only_paging_nav' ) ) :
/**
 * Displays navigation to next/previous set of posts when applicable.
 *
 * @since 
 *
 * @return void
 */
function h2only_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'h2only' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'h2only' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'h2only' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'h2only_post_nav' ) ) :
/**
 * Displays navigation to next/previous post when applicable.
*
* @since 
*
* @return void
*/
function h2only_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'h2only' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'h2only' ) ); ?>
			<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'h2only' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'h2only_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own h2only_entry_meta() to override in a child theme.
 *
 * @since 
 *
 * @return void
 */
function h2only_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', 'h2only' ) . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		h2only_entry_date();

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'h2only' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'h2only' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'h2only' ), get_the_author() ) ),
			get_the_author()
		);
	}
}
endif;

if ( ! function_exists( 'h2only_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own h2only_entry_date() to override in a child theme.
 *
 * @since 
 *
 * @param boolean $echo Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function h2only_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'h2only' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'h2only' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

if ( ! function_exists( 'h2only_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 *
 * @since 
 *
 * @return void
 */
function h2only_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'h2only_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Returns the URL from the post.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since 
 *
 * @return string The Link format URL.
 */
function h2only_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Extends the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since 
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function h2only_body_class( $classes ) {
	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
		$classes[] = 'sidebar';

	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';

	return $classes;
}
add_filter( 'body_class', 'h2only_body_class' );

/**
 * Adjusts content_width value for video post formats and attachment templates.
 *
 * @since 
 *
 * @return void
 */
function h2only_content_width() {
	global $content_width;

	if ( is_attachment() )
		$content_width = 724;
	elseif ( has_post_format( 'audio' ) )
		$content_width = 484;
}
add_action( 'template_redirect', 'h2only_content_width' );

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since 
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 */
function h2only_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'h2only_customize_register' );

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wp_generator');

add_filter('wppb_register_content_address2', 'hideIt2');
add_filter('wppb_register_content_address3', 'hideIt2');
add_filter('wppb_register_content_address1', 'tightenIt2');
add_filter('wppb_register_content_address2', 'tightenIt2');
add_filter('wppb_register_content_address3', 'tightenIt2');
function hideIt2($oldString){
    $oldString = str_replace('label for=', 'label class="hide-label" for=',  $oldString);
    return $oldString;
}
function tightenIt2($oldString){
    $oldString = str_replace('div class="input-group', 'div class="tighten input-group',  $oldString);
    return $oldString;
}
include('extra_functions.php');
