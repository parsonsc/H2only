<?php
/**
 * Template Name: Form Page Template
 *
 */

get_header(); ?>
    <div id="main" role="main">
        <div class="grid-container grid-parent row">
 

            <div class="grid-100 grid-parent content-block col-xs-12">
                <div class="border-top block">
                
                </div>  
                <div class="clearfix clear vertical-breaker-15 mobile-vertical-breaker-15"></div>
            <?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>

			<?php endwhile; ?>                
                    
                <div class="clearfix clear vertical-breaker-15 mobile-vertical-breaker-15"></div>
                <div class="border-bottom block">
            
                </div>
            </div>

        </div>
	</div><!-- #primary -->
    <div class="clearfix clear vertical-breaker-35 mobile-vertical-breaker-35"></div>
<?php get_sidebar( 'front' ); ?>
<?php get_footer(); ?>