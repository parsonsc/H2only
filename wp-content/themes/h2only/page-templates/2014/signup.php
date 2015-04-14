<?php
/**
 * Template Name: Sign up template
 *
 */
 if ( is_user_logged_in() && !isset($_REQUEST['action'])  ){
 	$destination = get_permalink(188);
	wp_redirect($destination);
    header("Status: 403");
    exit;
}
get_header(); ?>

	<?php 
	$page_id     = get_queried_object_id();
	$class = '';
	if ($page_id != 15) $class = 'narrow';
	?>
    <div id="main" class="sign-up <?php echo $class; ?>" role="main">
        <div class="grid-container">
        <?php 
        /* The loop: the_post retrieves the content
         * of the new Page you created to list the posts,
         * e.g., an intro describing the posts shown listed on this Page..
         */
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();    
        ?>    
	        <div class="grid-100">
				<?php get_template_part( 'content', 'page' ); ?>						
			</div>
  		<?php  			
            endwhile;
        endif;				
        ?>
 		</div>
	</div>
		
<?php get_footer(); ?>