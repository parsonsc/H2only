<?php
/**
 * Template Name: Thanks Page Template
 *
 */

get_header();
 
if (isset($_REQUEST['nexturl'])){
?>
    <a href="<?php echo $_REQUEST['nexturl'];?>" onclick="window.open('<?php echo $_REQUEST['nexturl'];?>'); return false;" target="_blank" class="jgpage" id="jgpage">&nbsp;</a>
    <script type="text/javascript">
    //<![CDATA[

    jQuery(document).ready(function ($) {
        jQuery('.jgpage').click();
    });
    //]]>
    </script>
<?php
}
?>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php the_content();?>
        <?php endwhile; endif;?>
<!-- Secure Conditional Container Tag: RNLI (4826) | H2O_Confirmation (28548) | H2O (3387) | Expected URL:  --> 

<script type="text/javascript"> 
var ftRandom = Math.random()*1000000; 
document.write('<iframe style="position:absolute; visibility:hidden; width:1px; height:1px;" src="https://servedby.flashtalking.com/container/4826;28548;3387;iframe/?spotName=H2O_Confirmation&cachebuster='+ftRandom+'"></iframe>'); 
</script>
    <div role="main" class="container">
        <div class="content"> 
               
<?php 
$postcount = 0;
$args = array(
    'post_type'        => 'post',
    'post_status'      => 'publish'
);
$myposts = get_posts( $args );
foreach ( $myposts as $post ) : 
    setup_postdata( $post ); 
    $postcount++;
    $custom = get_post_custom();
    $custom = get_post_meta($custom["_thumbnail_id"][0],'_wp_attached_file',true);  
    if ($postcount == 2 || '' != get_the_post_thumbnail()){
        if ($postcount == 2) { /*even*/
?>
            <div class="row water-bg water-line-top">
                <div <?php post_class( $class = ' col-sm-8') ?>>
                    <h3 class="centered"><?php the_title(); ?></h3>
                    <?php 
                    if ($pos=strpos($post->post_content, '<!--more-->')){
                        global $more; $more = 0;
                        the_content('', false);
                        $more = 1; ?>
                    <?php
                    }else{
                    ?>
                        <div class="post-copy equal">
                        <?php
                        the_content();
                        ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div <?php post_class( $class = ' col-sm-4') ?>>
                    <?php 
                    if ($pos=strpos($post->post_content, '<!--more-->')){
                        the_content('',true);
                    }
                    ?>
                </div>
            </div>
            <div class="water-line-bottom"></div>

<?php
                    }
                    else{
?>                
     
            <div class="row water-bg water-line-top">
                <div <?php post_class( $class = ' col-sm-6') ?>>
                    <h3><?php the_title(); ?></h3>
                    <?php the_content(); ?>
					<?php
					if ($postcount == 1){
$twcopy = 'Ice tea without tea. A pint of water at happy hour. Test your willpower. Take the water-only #H2Only challenge at '; 
$fbtitle = 'Take two weeks. Drink nothing but water.';
$fbcopy = "For two weeks, I’m going to drink nothing but water to raise money for our heroes of the high seas. Test your willpower and see if you can drink H2Only – sign up now.";
$emsubj = 'RNLI H2Only';
$embody = '
hello there

2 weeks. Just water. Are you up to the challenge?

thanks
';                    
					?>
                    <div class="centered social-links">
                    <p class="social-links-description">Share with your friends, family and colleagues. get them involved!</p>
                        <ul class="menu">
                            <li class="twitter"><a href="http://twitter.com/share?url=<?php bloginfo( 'url' ); ?>&amp;text=<?php echo urlencode($twcopy); ?>" title="Twitter" >Twitter</a></li>
                            <li class="facebook"><a href="http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo urlencode($fbtitle);?>&amp;p[summary]=<?php echo urlencode($fbcopy);?>&amp;p[url]=<?php bloginfo( 'url' ); ?>&amp;p[images][0]=<?php bloginfo( 'url' ); ?>/wp-content/themes/h2only/img/facebook-icon.jpg" title="Facebook">Facebook</a></li>
                            <li class="email"><a href="mailto: ?subject=<?php echo str_replace(" ", "%20",$emsubj)?>&body=<?php echo str_replace(" ", "%20",str_replace("<br />", "%0D%0A",nl2br($embody)));?>" title="Email" >Email</a></li>
                        </ul>
                    </div>

				<?php
				}

				?>                    
                </div>


                <div class=" col-sm-6">
                    <img class="full-img-responsive" src="<?php $uploads = wp_upload_dir(); echo str_replace('http://', '//', $uploads['baseurl']) .'/' . $custom ?>" alt="<?php echo strip_tags(get_the_title()); ?>" />






                </div>      

            </div>
            <div class="water-line-bottom"></div>


<?php
                }
}
else{ 
            if ($postcount % 2 == 1){ /*even*/
                $opened = true;
?>                







			<div class="row water-bg water-line-top">                      
                <div <?php post_class( $class = ' col-sm-6') ?>>
                    <h3><?php the_title(); ?></h3>
                    <?php if ($pos=strpos($post->post_content, '<!--more-->')){ ?>
                    <div class="post-copy equal">
                        <?php global $more; $more = 0;
                        the_content('', false);
                        $more = 1; 
                        ?>
                    </div>
                        <?php the_content('',true);
                    } else { ?>
                        <div class="post-copy equal">
                            <?php the_content(); ?>
                        </div>
                    <?php } ?>
                </div>
<?php                
                }
                else {/*odd*/
                    $opened = false;
?>



                <div <?php post_class( $class = ' col-sm-6') ?>>
                    <h3><?php the_title(); ?></h3>
                    <?php if ($pos=strpos($post->post_content, '<!--more-->')){ ?>
                    <div class="post-copy equal">
                        <?php global $more; $more = 0;
                        the_content('', false);
                        $more = 1; 
                        ?>
                    </div>
                        <?php the_content('',true);
                    } else { ?>
                        <div class="post-copy equal">
                            <?php the_content(); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="water-line-bottom"></div> 


            



<?php            
                }
                
            }
endforeach;  // added 
wp_reset_postdata();
        if ($opened) echo '</div>';
?>            
	</div><!-- #primary -->

<?php get_sidebar( 'front' ); ?>

    <div class="row">
        <div class=" col-sm-12 back-home-wrapper">
        	<a href="<?php echo home_url(); ?>">Return to homepage</a>
        </div>
    </div>
    </div>
<?php get_footer(); ?>