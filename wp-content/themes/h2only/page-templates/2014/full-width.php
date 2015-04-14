<?php
/**
 * Template Name: Full-width Page Template, No Sidebar
 *
 */

get_header(); ?>

	<div class="container">
		<div class="content" role="main">
		 <div class="row">
		 <div class="col-xs-12">
			<?php while ( have_posts() ) : the_post(); ?>
				<div <?php post_class( $class = ' col-xs-12') ?> >
				<?php the_content(); ?>
				</div>
			<?php endwhile; // end of the loop. ?>
			</div>
		</div><!-- #content -->
		</div>
	</div><!-- #primary -->

<?php get_footer(); ?>