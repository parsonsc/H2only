<?php
/**
 * Template Name: Front Page Return
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
                    <h3><strong>"Congratulations my h<sub>2</sub>onlies!"</strong></h3>
                    <p class="bliss24">
&quot;You can&rsquo;t become a Master of self-control without a bit of hard work and an ocean of willpower. Well done and thanks for raising money for the RNLI. Now it&rsquo;s all over, pour yourself your favourite drink and start celebrating. I&rsquo;m partial to a pina colada, myself. With extra colada.&quot;          
                    </p>

                    <!-- a href="#">
                    <img class="singup-2015 " src="<?php echo get_template_directory_uri().'/img/singup-2015.png' ?>" />
                    </a>
                    <a href="#">
                    <img class="singup-2015-sm" src="<?php echo get_template_directory_uri().'/img/singup-2015-sm.png' ?>" />
                    </a -->
                    

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
                    <h3>You're an <strong>H<sub>2</sub>Only Hero</strong></h3>
                    <p>
                    Last year, our lifeboat crews and lifeguards saved 425 lives &ndash; and thousands more were rescued. The money you raised by drinking nothing but water will help us save more lives at sea and keep more people safe. Thank you. 
                    </p>          
                    <p>
                    <img class="full-img-responsive" src="<?php echo get_template_directory_uri().'/img/heroes.png' ?>" />
                    </p>

                    <p>
                    <a href="http://rnli.org/aboutus/aboutthernli/Pages/about-the-rnli.aspx">
                    <img class="" src="<?php echo get_template_directory_uri().'/img/read-more.png' ?>" />
                    </a>
                    </p>
                </div>
                <div <?php echo post_class('col-sm-6')?> >
                    <h3>The <strong>Next Challenge</strong></h3>
                    <p>
                    Did you sail through the H<sub>2</sub>Only challenge? Are you looking for the next one? Perhaps the Grand Master has inspired you to keep supporting our seafaring heroes. Whatever the reason, we can help you.
                    </p>
                    <p>
                    <img class="full-img-responsive" src="<?php echo get_template_directory_uri().'/img/next-challenge.png' ?>" />
                    </p>

                    <p><a href="http://rnli.org/howtosupportus/getinvolved/events/Pages/default.aspx">
                    <img class="" src="<?php echo get_template_directory_uri().'/img/find-out-more.png' ?>" />
                    </a>
                    </p>
                </div>
            </div>
            <div class="water-line-bottom foot-a-hero"></div> 
            <!-- END NEW ADDITION -->

            <div class="row water-bg water-line-top daily-update">
                <div <?php echo post_class('col-sm-6')?> >
                    <h3 class="alignCenter">You're an <strong>H<sub>2</sub>Only Hero</strong></h3>
                    <p>
Last year, our lifeboat crews and lifeguards saved 425 lives &ndash; and thousands more were rescued. The money you raised by drinking nothing but water will help us save more lives at sea and keep more people safe. Thank you. 
                    </p>
                    <p>
                    <a href="http://rnli.org/aboutus/aboutthernli/Pages/about-the-rnli.aspx">
                    <img class="" src="<?php echo get_template_directory_uri().'/img/read-more.png' ?>" />
                    </a>
                    </p>
                </div>
                <div <?php echo post_class('col-sm-6')?> >
                    <img class="full-img-responsive" src="<?php echo get_template_directory_uri().'/img/heroes.png' ?>" />
                </div>
            </div>            
            <div class="water-line-bottom foot-daily-update"></div>

            <div class="row water-bg water-line-top daily-update">
                <div <?php echo post_class('col-sm-6')?> >
                    <img class="full-img-responsive" src="<?php echo get_template_directory_uri().'/img/next-challenge.png' ?>" />
                </div>
                <div <?php echo post_class('col-sm-6')?> >
                    <h3 class="alignCenter">The <strong>Next Challenge</strong></h3>
                    <p>
                    Did you sail through the H<sub>2</sub>Only challenge? Are you looking for the next one? Perhaps the Grand Master has inspired you to keep supporting our seafaring heroes. Whatever the reason, we can help you.
                    </p>
                    
                    <p><a href="http://rnli.org/howtosupportus/getinvolved/events/Pages/default.aspx">
                    <img class="" src="<?php echo get_template_directory_uri().'/img/find-out-more.png' ?>" />
                    </a>
                    </p>
                </div>                
            </div>            
            <div class="water-line-bottom foot-daily-update"></div>           
           

        </div>
    </div>
            
              

<?php get_sidebar( 'front' ); ?>
<?php get_footer(); ?>