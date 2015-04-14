<?php 
/**
 * Template Name: Generic Page
 *
 * @package H2Only2015
 */
get_header(); 
?>
<section class="row  full_bg">
    <div class="inner_content">
 			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?> 
    </div>
</section>
<div class="clear"></div>

               
<?php get_footer(); ?>