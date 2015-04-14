<?php
/**
 * Template Name: Front Page Retain day13
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



            <div class="row water-bg water-line-top make-waves">
                <div <?php post_class( $class = ' col-sm-6') ?>>
                <div class="water-box-top"></div>
                    <img class="img-responsive" src="<?php $uploads = wp_upload_dir(); echo str_replace('http://', '//', $uploads['baseurl']) .'/' . $custom ?>" alt="<?php echo strip_tags(get_the_title()); ?>" />
                </div>
                <div <?php post_class( $class = ' col-sm-6') ?>>
                    <h3><?php the_title(); ?></h3>
                    <?php the_content(); ?> 
                </div>            
            </div>
            <div class="water-line-bottom foot-make-waves"></div> 



            <?php
                }
                else{ ?>        
            <div class="row water-bg water-line-top make-waves"> <!-- BLOCK 3 -->
                <div <?php post_class( $class = ' col-sm-6') ?> >
                    <h3><?php the_title(); ?></h3>
                    <?php the_content(); ?>
                </div>
                <div class=" col-sm-6">
                    <img class="full-img-responsive" src="<?php $uploads = wp_upload_dir(); echo str_replace('http://', '//', $uploads['baseurl']) .'/' . $custom ?>" alt="<?php echo strip_tags(get_the_title()); ?>" />
                </div>
            </div>
            <div class="water-line-bottom foot-make-waves"></div>


            <!-- BEGIN NEW ADDITION -->
            <div class="row water-bg water-line-top day1">
                <div <?php echo post_class('col-sm-6')?> >
                    <h3>Day 13:<br/><strong>H2-Only One day to go</strong></h3>
                    <p>
                    Check out your apps &ndash; there&rsquo;s one more flavour challenge to go. Earn something delicious for your water and you&rsquo;ll be even closer to the finish line. 
                    </p>

                    <p>
                    <img class="full-img-responsive" src="<?php echo get_template_directory_uri().'/img/day13.png' ?>" />
                    </p>
                </div>
                <div <?php echo post_class('col-sm-6')?> >
                    <h3>The Mocktail Hour:<br/>                    
                    <strong>Mine&rsquo;s a Watertini</strong></h3>

                    <p>Shaken, not stirred. Glam up your water with this simple, chic recipe.</p>
                    
                    <ul>
                    <h5><strong>RECIPE:</strong></h5>
                     <li>10ml pure H<sub>2</sub>O</li>
                     <li>65ml chilled water</li>
                     <li>A dash of water-flavoured water</li>
                    </ul>
                    <img class="full-img-responsive" src="<?php echo get_template_directory_uri().'/img/watertini.png' ?>" />

                </div>            

            </div>
             <div class="water-line-bottom day1-footer"></div> 
            <!-- END NEW ADDITION -->

             <!-- Daily UPDATE -->
            <div class="row water-bg water-line-top daily-update">
                <div <?php echo post_class('col-sm-6')?> >
                    <h3 class="alignCenter">Day 13:<br/><strong>H2-Only One day to go</strong></h3>
                    <p>
                    Check out your apps &ndash; there&rsquo;s one more flavour challenge to go. Earn something delicious for your water and you&rsquo;ll be even closer to the finish line. 
                    </p>
                </div>
                <div <?php echo post_class('col-sm-6')?> >
                    <img class="full-img-responsive" src="<?php echo get_template_directory_uri().'/img/day13.png' ?>" />
                </div>
            </div>            
            <div class="water-line-bottom foot-daily-update"></div>
            
            <!-- MOCKTAIL OF THE DAY -->
             <div class="row water-bg water-line-top mocktail-of-the-day">
                <div <?php echo post_class('col-sm-6')?> >
                    <img class="full-img-responsive" 
                    src="<?php echo get_template_directory_uri().'/img/watertini.png' ?>" /><p></p>
                </div>
                <div <?php echo post_class('col-sm-6')?> >
                    <h3 class="alignCenter">The Mocktail Hour:<br/>

                    <strong>Mine&rsquo;s a Watertini</strong></h3>


                    <p>Shaken, not stirred. Glam up your water with this simple, chic recipe.</p>
                    
                    <ul>
                    <h5><strong>RECIPE:</strong></h5>
                     <li>10ml pure H<sub>2</sub>O</li>
                     <li>65ml chilled water</li>
                     <li>A dash of water-flavoured water</li>
                    </ul>

                </div>
            </div>
             <div class="water-line-bottom foot-mocktail-of-the-day"></div>            
            <!-- WHY SO GOOD -->
            <!--div class="row water-bg water-line-top why-so-good">
                <div <?php echo post_class('col-sm-6')?> >
                    <h3 class="alignCenter">All About H2 Only and why it so Good</h3>
                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse faucibus, mi ut posuere elementum, neque quam blandit felis, nec lacinia arcu metus ac magna.</p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse faucibus, mi ut posuere elementum, neque quam blandit felis, nec lacinia arcu metus ac magna.</p>

                    <p>
                    <a target="_blank" class="button submit" title="Sign up now" 
                    href="http://www.h2only.org.uk/sign-up" onclick="javascript:_gaq.push(['_trackEvent','outbound-article','http://www.h2only.org.uk']);">Sign up now</a>

                    <a href="#" class="jointeam"><img src="<?php echo get_template_directory_uri().'/img/create-join-team.jpg'; ?>"></a>
                    </p>
                </div>
                <div <?php echo post_class('col-sm-6')?> >

                    <img class="full-img-responsive" 
                    src="<?php echo get_template_directory_uri().'/img/recipe-blank.png' ?>" />

                </div>
            </div>
             <div class="water-line-bottom foot-why-so-good"></div --> 








            <!-- BEGIN NEW ADDITION -->
            <div class="row water-bg water-line-top">
                <div <?php echo post_class('col-sm-6')?> >
                    <h3 class="dektop-calc-title">Save Calories and Cash<br/><strong>and save lives</strong></h3>
                    <!--h3 class="alignCenter mobile-calc-title">Calorie Cost Calculator</h3 -->
                    <p>
                    Your H2Only challenge might hit rough seas at times.</p>
                    <p>But one thing&rsquo;s certain, drinking nothing but water for two<br/>
                    weeks will be kind to your wallet and your waistline.</p>

                    <h4 class="save desktop">Find Out how much you will save</h4>
                    <h4 class="save mobile">Tell us what you have & we&rsquo;ll calculate 
                    the savings you&rsquo;ll make during h2only!</h4>

                    <div class="row desktop calorie-values">
                        <span class="col-sm-6">
                            <img src="<?php echo get_template_directory_uri().'/img/icon-calories.png'; ?>"/>
                            <span class="calories-count"></span>
                        </span>
                        <span class="col-sm-6">
                            <img src="<?php echo get_template_directory_uri().'/img/icon-cost.png'; ?>"/> 
                            <span class="calories-cost"></span>
                        </span>
                    </div>
                </div>

                <div <?php echo post_class('col-sm-6 range-sliders')?> >

                    <!-- RANGE SLIDER -->
                    
                    <div class="calorie-slider pint">
                        <div class="pint counter"></div>
                        <span class="icon pints"></span><div class="slide" id="pints"></div>
                    </div>
                
                    <div class="calorie-slider pop">
                        <div class="pop counter"></div>
                        <span class="icon pop"></span><div class="slide" id="pop"></div>
                    </div>

                    <div class="calorie-slider juice">
                        <div class="juice counter"></div>
                        <span class="icon juice"></span><div class="slide" id="juice"></div>
                    </div>

                    <div class="calorie-slider tea">
                        <div class="tea counter"></div>
                        <span class="icon tea"></span><div class="slide" id="tea"></div>
                    </div>

                    <div class="calorie-slider coffee">
                        <div class="coffee counter"></div>
                        <span class="icon coffee"></span><div class="slide" id="coffee"></div>
                    </div>

                    <div class="row mobile calorie-values">
                        <span class="col-sm-6">
                            <img src="<?php echo get_template_directory_uri().'/img/icon-calories.png'; ?>"/>
                            <span class="calories-count"></span>
                            </span>
                            <span class="col-sm-6">
                            <img src="<?php echo get_template_directory_uri().'/img/icon-cost.png'; ?>"/> 
                            <span class="calories-cost"></span>
                        </span>
                    </div>

                 </div>


            </div>
             <div class="water-line-bottom"></div> 
            <!-- END NEW ADDITION -->


            <!-- MOCKTAIL OF THE DAY -->
             <!--div class="row water-bg water-line-top get_your_kit">
                <div <?php echo post_class('col-sm-6')?> >

                    <h3 class="alignCenter">Grab a fundraiser pac:<br/>
                    <strong>& get started!</strong></h3>
                    <img class="full-img-responsive" 
                    src="<?php echo get_template_directory_uri().'/img/recipe-blank.png' ?>" /><p></p>


                    <a class="button" title="Coming soon" href="/fundraising-pack.zip">Download the fundraising pack</a>
                    <a target="_blank" class="button postkit" title="Sign up now" href="http://www.h2only.org.uk/sign-up?packpost=1" onclick="javascript:_gaq.push(['_trackEvent','outbound-article','http://www.h2only.org.uk']);">get a fundraising pack in the post</a>

                </div>
                <div <?php echo post_class('col-sm-6')?> >
                    <h3 class="alignCenter">Buy the official <strong>Limited Edition</strong>:<br/>
                    H2Only Bottle</h3>

                    <img class="full-img-responsive" 
                    src="<?php echo get_template_directory_uri().'/img/recipe-blank.png' ?>" />

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse faucibus, mi ut posuere elementum, neque quam blandit felis, nec lacinia arcu metus ac magna</p>

                    <a target="_blank" class="button buy-a-bottle" href="http://www.rnlishop.org.uk/H<sub>2</sub>Only/info/h2only-bobble-bottle/999957.html" onclick="javascript:_gaq.push(['_trackEvent','outbound-article','http://www.rnlishop.org.uk']);">buy a bottle now</a>

                </div>
            </div>
             <div class="water-line-bottom foot-get_your_kit"></div -->


            <?php
                }
            }else{
            
            if ($postcount % 2 == 0) { /*even*/
                $opened = true; ?>
               
            <div class="row water-bg water-line-top get-pack 3"> 
                                      
                <div <?php post_class( $class = ' col-sm-6') ?> > <!-- BLOCK 4 -->
                    <h3><?php the_title(); ?></h3>
                    <?php  if ($pos=strpos($post->post_content, '<!--more-->')){ ?>

                    <div class="post-copy equal">
                        <?php global $more; $more = 0;
                        the_content('', false);
                        $more = 1; ?>
                    </div>

                    <?php the_content('',true); 

                } else { ?>
                        <div class="post-copy equal">
                    <?php the_content(); ?>
                    </div>
          <?php } ?>
                </div>

            <?php                
            } // END IF

            else { /*odd*/ ?> 

                <div <?php post_class( $class = ' col-sm-6') ?> > <!-- BLOCK 5 -->
                    <h3><?php the_title(); ?></h3>
                    
                        <?php if ($pos=strpos($post->post_content, '<!--more-->')){ ?>
                    <div class="post-copy equal">
                        <?php global $more; $more = 0;
                        the_content('', false);
                        $more = 1; ?>


                    </div>
                    <?php the_content('',true);

                    } else { ?>
                        <div class="post-copy equal">
                            <?php the_content(); ?>
                        </div>
                    <?php } ?>
                    
                </div>
                </div>
            <div class="water-line-bottom foot-get-pack"></div> 
        <?php            
            } // END ELSE 
                
        } // END ELSE
        ?> 
             

        <?php endwhile; if ($opened) echo '</div>'; ?>

        <?php endif; ?>            
        <!-- </div> #primary -->
   

<?php get_sidebar( 'front' ); ?>
<?php get_footer(); ?>