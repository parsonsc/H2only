<?php
/**
 * Template Name: Form Page w tag Template
 *
 */

get_header(); ?>
<!--  Conditional Container Tag: RNLI (4826) | H2O_Sign UP Page (28547) | H2O (3387) | Expected URL:  --> 

<script type="text/javascript"> 
var ftRandom = Math.random()*1000000; 
document.write('<iframe style="position:absolute; visibility:hidden; width:1px; height:1px;" src="https://servedby.flashtalking.com/container/4826;28547;3387;iframe/?spotName=H2O_Sign_UP_Page&cachebuster='+ftRandom+'"></iframe>'); 
</script>
    <div id="main" role="main">
        <div class="grid-container grid-parent">
 

            <div class="grid-100 grid-parent content-block">
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