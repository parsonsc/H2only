<?php
/**
 * Template Name: Front Page Stripped
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


            
              

<?php get_sidebar( 'front' ); ?>
<?php get_footer(); ?>