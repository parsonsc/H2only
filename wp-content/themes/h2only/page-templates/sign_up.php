<?php
/**
 * Template Name: sign up 2015
 *
 */

get_header(); ?>
<!--  Conditional Container Tag: RNLI (4826) | H2O_Sign UP Page (28547) | H2O (3387) | Expected URL:  --> 
<?php include 'parts/sign_up_header.php';?>

<script type="text/javascript"> 
var ftRandom = Math.random()*1000000; 
document.write('<iframe style="position:absolute; visibility:hidden; width:1px; height:1px;" src="https://servedby.flashtalking.com/container/4826;28547;3387;iframe/?spotName=H2O_Sign_UP_Page&cachebuster='+ftRandom+'"></iframe>'); 
</script>
    <div id="main" role="main" class="blue_bg">         	
           
            <?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>

			<?php endwhile; ?>               
        </div>


<?php get_footer(); ?>