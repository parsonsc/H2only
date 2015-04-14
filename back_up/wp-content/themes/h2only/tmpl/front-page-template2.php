<?php
/**
 * Template Name: Front Page Template 2
 *
 */

get_header(); ?>

<!--  Conditional Container Tag: RNLI (4826) | H2O_Landing Page (28546) | H2O (3387) | Expected URL:  --> 

<script type="text/javascript"> 
var ftRandom = Math.random()*1000000; 
document.write('<iframe style="position:absolute; visibility:hidden; width:1px; height:1px;" src="http://servedby.flashtalking.com/container/4826;28546;3387;iframe/?spotName=H2O_Landing_Page&cachebuster='+ftRandom+'"></iframe>'); 
</script>
    <div role="main" class="container">

        <div class="content">    


<?php
    global $homePageBits;
	$homePageBits = new WP_Query();
	$homePageBits->query(
		array(
			'post_type' => 'homepage_block',
			'post_status'=> 'publish',
			'order' => 'ASC',
			'orderby' => 'menu_order'			
			)
		);
	if ($homePageBits->have_posts()):
        $homePageBits->in_the_loop = true;
        $postcount = 0;
        $opened = false;
		while ($homePageBits->have_posts()): 
            $postcount++;
			$homePageBits->the_post();
			$block_link = get_post_meta($post->ID, 'block_link', true);
			$block_link_copy = get_post_meta($post->ID, 'block_link_copy', true);
			$custom = get_post_custom();
			$custom = get_post_meta($custom["_thumbnail_id"][0],'_wp_attached_file',true);  
            if ('' != get_the_post_thumbnail()){

            
                /* full width */
                if ($postcount % 2 == 0) { /*even*/ ?> 
                </div> 



            <div class="row water-bg water-line-top">
                <div <?php post_class( $class = ' col-sm-6') ?>>
                <div class="water-box-top"></div>
                    <img class="img-responsive" src="<?php $uploads = wp_upload_dir(); echo str_replace('http://', '//', $uploads['baseurl']) .'/' . $custom ?>" alt="<?php echo strip_tags(get_the_title()); ?>" />
                </div>
                <div <?php post_class( $class = ' col-sm-6') ?>>
                    <h3><?php the_title(); ?></h3>
                    <?php the_content(); ?> 
                </div>            
            </div>
            <div class="water-line-bottom"></div> 



            <?php
                }
                else{ ?>        
            <div class="row water-bg water-line-top"> <!-- BLOCK 3 -->
                <div <?php post_class( $class = ' col-sm-6') ?> >
                    <h3><?php the_title(); ?></h3>
                    <?php the_content(); ?>
                </div>
                <div class=" col-sm-6">
                    <img class="full-img-responsive" src="<?php $uploads = wp_upload_dir(); echo str_replace('http://', '//', $uploads['baseurl']) .'/' . $custom ?>" alt="<?php echo strip_tags(get_the_title()); ?>" />
                </div>
            </div>
            <div class="water-line-bottom"></div>


            <!-- BEGIN NEW ADDITION -->
            <div class="row water-bg water-line-top">
                <div <?php echo post_class('col-sm-6')?> >
                    <h3>Day 1<br/><strong>Good Luck, My Holiness</strong></h3>
                    <p>
                    It&rsquo;s time to wave goodbye to tea, coffee, juice, beer and wine.
                     But don&rsquo;t fear. Download the app and we&rsquo;ll be there to guide you when the waters get choppy. 
                    </p>

                    <p>
                    <img class="full-img-responsive" src="<?php echo get_template_directory_uri().'/img/man-save-cals.png' ?>" />
                    </p>
                </div>
                <div <?php echo post_class('col-sm-6')?> >
                    <h3>The Mocktail Hour:<br/>Mine&rsquo;s a Watertini</h3>

                    <p>Shaken not stirred. Glam up your water with this simple, chic recipe</p>

                    <ul>
                    <h5><strong>RECIPE:</strong></h5>
                     <li>10ml pure H20</li>
                     <li>65ml chilled water</li>
                     <li>A dash of water-flavoured water</li>
                    </ul>

                    <img class="full-img-responsive" src="<?php echo get_template_directory_uri().'/img/recipe-blank.png' ?>" />

                </div>
            </div>
             <div class="water-line-bottom"></div> 
            <!-- END NEW ADDITION -->


            <!-- BEGIN NEW ADDITION -->
            <div class="row water-bg water-line-top">
                <div <?php echo post_class('col-sm-6')?> >
                    <h3>Save Calories and Cash<br/><strong>and save lives</strong></h3>
                    <p>
                    Your H2Only challenge might hit rough seas at times.</p>
                    <p>But one thing&rsquo;s certain, drinking nothing but water for two<br/>
                    weeks will be kind to your wallet and your waistline.</p>

                    <h4>Find Out how much you will save</h4>

                    <div class="row">
                        <span class="col-sm-6">
                            <img src="<?php echo get_template_directory_uri().'/img/icon-calories.png'; ?>"/> Calories: 27,062
                        </span>
                        <span class="col-sm-6">
                            <img src="<?php echo get_template_directory_uri().'/img/icon-cost.png'; ?>"/> Cost: 800
                        </span>
                    </div>
                    </p>

                </div>

                <div <?php echo post_class('col-sm-6')?> >

                    <p>
                    <label for="amount">Price range:</label>
                    <input type="text" id="amount" style="border:0; color:#f6931f; font-weight:bold;">
                    </p>
                    <div id="slider-range"></div>
 
                    <img class="img-responsive" src="<?php echo get_template_directory_uri().'/img/slider-chart.jpg'; ?>"/>
                </div>

            </div>
             <div class="water-line-bottom"></div> 
            <!-- END NEW ADDITION -->


            <?php
                }
            }
        } // END ELSE
        ?> 
             

        <?php endwhile; if ($opened) echo '</div>'; ?>

        <?php endif; ?>            
        <!-- </div> #primary -->
   

<?php get_sidebar( 'front' ); ?>
<?php get_footer(); ?>