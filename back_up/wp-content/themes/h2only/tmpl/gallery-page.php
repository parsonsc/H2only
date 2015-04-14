<?php
/**
 * Template Name: Gallery Page Template
 *
 */

get_header(); ?>

    <div class="clearfix clear vertical-breaker-35 mobile-vertical-breaker-10"></div>

    <div id="main" role="main">
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
				<h1><?php echo the_title(); ?></h1>
				<?php echo the_content(); ?>
			</div>
  		<?php
  				wp_reset_postdata();
            endwhile;
        endif;				
        ?>
        </div>
        <div class="grid-container">
            <div class="grid-100"> 
            
                <?php echo do_shortcode("[BHF_uploader]"); ?>
                
                
            </div>
        </div>            
        <div class="grid-container">
            <div class="grid-100 grid-parent">      
            <?php echo do_shortcode( "[AFG_gallery id='2']" ); ?>
            </div>
        </div>
        <div class="grid-container">
            <div class="grid-100"> 
                <div class="grid-item-outer ">
                    <div class="grid-item-inner">            
            <h3>We need your <span class="the-red">red</span>dies</h3>
            <p>You&rsquo;ve packed up your red clothes, popped the red balloons and eaten the last red cupcake. Now there&rsquo;s one more, vital thing to do; send us your money and help fight heart disease.</p>
            <a href="<?php echo get_permalink(824); ?>" class="big-red-with-varient-arrow">Send your money now</a>
                    </div>
                </div>            
            </div>
        </div>
        
	</div>	
<?php get_footer(); ?>