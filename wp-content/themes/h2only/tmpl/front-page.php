<?php
/**
 * Template Name: Front Page Final
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


            <!-- BEGIN NEW ADDITION -->
            <div class="row water-bg water-line-top">
                <div <?php echo post_class('col-sm-6 congrats2015')?> >
                    <h3><strong>"Congratulations my h2onlies!"</strong></h3>
                    <p class="bliss24">
                    "You can&rsquo;t become a master of self-control without a bit of hard work and an ocean of willpower. Well done and thanks for raising money for the RNLI. Now it's all over, pour yourself your favourite drink and start celebrating &ndash; I&rsquo;m partial to a pina colada, myself. With extra colada."
                    </p>

                    <a href="#">
                    <img class="singup-2015 " src="<?php echo get_template_directory_uri().'/img/singup-2015.png' ?>" />
                    </a>
                    <a href="#">
                    <img class="singup-2015-sm" src="<?php echo get_template_directory_uri().'/img/singup-2015-sm.png' ?>" />
                    </a>
                    

                </div>
                <div <?php echo post_class('col-sm-6')?> >
                    <img class="full-img-responsive" 
                    src="<?php echo get_template_directory_uri().'/img/man-with-drink.png' ?>" />

                </div>
            </div>
             <div class="water-line-bottom"></div> 
            <!-- END NEW ADDITION -->



            <!-- BEGIN NEW ADDITION -->
            <div class="row water-bg water-line-top a-hero">
                <div <?php echo post_class('col-sm-6')?> >
                    <h3>You're an <strong>H2Only Hero!</strong></h3>
                    Last year, our lifeboat crews and lifeguards saved 425 lives &ndash; and thousands more were rescued. The money you raised by drinking nothing but water will help us save more lives at sea and keep more people safe. Thank you. 
                    <p>
                    <img class="full-img-responsive" src="<?php echo get_template_directory_uri().'/img/heroes.png' ?>" />
                    </p>

                    <p>
                    <a href="#">
                    <img class="" src="<?php echo get_template_directory_uri().'/img/read-more.png' ?>" />
                    </a>
                    </p>

                </div>
                <div <?php echo post_class('col-sm-6')?> >
                    <h3>The <strong>Next Challenge</strong></h3>

                    Did you sail through the H2Only challenge? Are you looking for the next one? Perhaps the Grand Master has inspired you to keep supporting our seafaring heroes. Whatever the reason, we can help you.

                     <p>
                    <img class="full-img-responsive" src="<?php echo get_template_directory_uri().'/img/next-challenge.png' ?>" />
                    </p>

                    <p><a href="#">
                    <img class="" src="<?php echo get_template_directory_uri().'/img/find-out-more.png' ?>" />
                    </a>
                    </p>


                </div>
            </div>
             <div class="water-line-bottom foot-a-hero"></div> 
            <!-- END NEW ADDITION -->



              <!-- BEGIN NEW ADDITION -->
            <div class="row water-bg water-line-top get-involved">
                <div <?php echo post_class('col-sm-6')?> >
                    <h3>How your money helps</h3>

                    <p>
                    <img class="full-img-responsive" src="<?php echo get_template_directory_uri().'/img/return-holder.png' ?>" />
                    </p>

                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse faucibus, mi ut posuere elementum, neque quam blandit felis, nec lacinia arcu metus ac magna.Suspendisse faucibus, mi ut posuere elementum, neque quam blandit felis, nec lacinia arcu metus ac magna. 

                    <p>
                    <a href="#">
                    <img class="" src="<?php echo get_template_directory_uri().'/img/read-more.png' ?>" />
                    </a>
                    </p>

                </div>
                <div <?php echo post_class('col-sm-6')?> >
                    <h3>Get Involved With The RNLI</h3>

                    <p>
                    <img class="full-img-responsive" src="<?php echo get_template_directory_uri().'/img/return-holder.png' ?>" />
                    </p>

                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse faucibus, mi ut posuere elementum, neque quam blandit felis, nec lacinia arcu metus ac magna.Suspendisse faucibus, mi ut posuere elementum, neque quam blandit felis, nec lacinia arcu metus ac magna. 

                    <p>
                    <a href="#">
                    <img class="" src="<?php echo get_template_directory_uri().'/img/find-out-more.png' ?>" />
                    </a>
                    </p>

                </div>
            </div>
             <div class="water-line-bottom foot-get-involved"></div> 
            <!-- END NEW ADDITION -->


            
              

<?php get_sidebar( 'front' ); ?>
<?php get_footer(); ?>