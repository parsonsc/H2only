<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
$template = get_page_template() ;
if (strpos($template , 'return') !== false )  {              
$twcopy = "I said bye to beer and ta-ta to tea for 2 weeks for the RNLI. There's still time to sponsor me <PUT YOUR JUSTGIVING LINK HERE> #H2Only" ; 
$fbtitle = 'I did it!';
$fbcopy = "I said bye to beer and ta-ta to tea for 2 weeks, to raise money for the RNLI. There's still time to sponsor me and help save lives at sea."; 
$emsubj = 'I did it!';
$embody = '
Ahoy there!
 
I sailed through the H2Only challenge, taking 2 weeks drinking nothing but water for the RNLI. 
 
There\'s still time to sponsor me at <PUT YOUR JUSTGIVING LINK HERE> to help save lives at sea.
 
Thanks,
';
}
else{  
$twcopy = 'I\'m saying bye to beer and ta-ta to tea for 2 weeks for the RNLI. Will you sponsor me to help me stay strong? <PUT YOUR JUSTGIVING LINK HERE> #H2Only '; 
$fbtitle = 'H2Only | Mine\'s a water';
$fbcopy = 'I\'m saying bye to beer, laters to lattes and ta-ta to tea for 2 weeks to raise money for the RNLI. Will you sponsor me to help me stay strong?'; 
$emsubj = 'RNLI H2Only';
$embody = '
Ahoy there!
 
I\'m taking the H2Only challenge to raise money for the RNLI, so they can save more lives at sea. 
 
The H2Only challenge is 2 weeks drinking nothing but water; which means I\'ll be saying no thanks to tea, coffee, fizzy drinks, wine and beer. It won\'t be easy, but I\'m determined to stay afloat. 
 
Sponsor me or, better still, join me at <PUT YOUR JUSTGIVING LINK HERE>
 
Thanks,
';
} 
?>
<!DOCTYPE html>
<!-- [if lt IE 7 ]><html class="no-js ie6" lang="en"> <![endif] -->
<!-- [if IE 7 ]><html class="no-js ie7" lang="en"> <![endif] -->
<!-- [if IE 8 ]><html class="no-js ie8" lang="en"> <![endif] -->
<!-- [if IE 9 ]><html class="no-js ie9" lang="en"> <![endif] -->
<!-- [if (gt IE 9)|!(IE)]><! -->
<html class="no-js" lang="en" itemscope itemtype="http://schema.org/Blog"> <!-- <![endif] -->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">

    <!-- IE Compatibility Metas -->    
    <!-- [if lt IE 9]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <![endif] -->	

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <title><?php wp_title( '|', true, 'right' ); ?></title>
    
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<?php
if (strpos($template , 'return') !== false )  { 
?>                                     
<meta property="og:title" content="I did it!" />
<meta property="og:description" content="I said bye to beer and ta-ta to tea for 2 weeks, to raise money for the RNLI. There's still time to sponsor me and help save lives at sea." />
<meta property="og:url" content="<?php bloginfo( 'url' ); ?>" />
<meta property="og:image" content="<?php bloginfo( 'url' ); ?>/wp-content/themes/h2only/img/fbook.jpg" />
<?php
}
else{  
?>
<meta property="og:title" content="Make mine a water!" />
<meta property="og:description" content="I'm saying bye to beer and ta-ta to tea for 2 weeks, to raise money for the RNLI. Will you sponsor me to go #H2Only and stay strong? " />
<meta property="og:url" content="<?php bloginfo( 'url' ); ?>" />
<meta property="og:image" content="<?php bloginfo( 'url' ); ?>/wp-content/themes/h2only/img/fbook.jpg" />
<?php
}
?>
	<?php wp_head(); ?>
<?php
/*    
<script type="text/javascript">

WebFontConfig = { fontdeck: { id: '43943' } };

(function() {
  var wf = document.createElement('script');
  wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
  '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
  wf.type = 'text/javascript';
  wf.async = 'true';
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(wf, s);
})();
</script>    
*/
?>
</head>

<body <?php body_class(); ?>>
	<!--[if lt IE 7]>
        <div id="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</div>
    <![endif]-->
	<div id="wrapper">        
		
		<header role="banner" class="header">
			<div class="inner_content grid-container grid-100 grid-parent">
                <?php 
                //echo '<p>this is the page template' . $template . '</p>';
                if (is_home() || is_front_page() || strpos($template , 'front-page') !== false )  {               
                ?>            
                <div class="">
                   <!--  <div id="header-logo"><a href="http://www.rnli.org.uk/" class="external" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><span><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></span></a>
                        <img class="img-responsive date mobile-xs" src="<?php echo get_bloginfo('template_directory'); ?>/img/date-sm.png"  alt="27th may to 10th June" />
                    </div> -->
                    <!--<div id="header-strap" >
                         <h1 class="strap graphic"><a href="<?php bloginfo( 'url' ); ?>"><span><?php bloginfo( 'name' ); ?></span></a></h1>
                        <?php                        
                        if (strpos($template , 'return') !== false )  {              
                        ?>
                        <h2 class="description desktop">
                            <span class="home-desc1"><strong>YOU DID IT! YOU&rsquo;RE A MASTER OF SELF-CONTROL.</strong></span>
                        </h2>                            
                            
                            
                        <h2 class="description mobile">  
                            <span class="home-desc1"><strong>YOU DID IT! YOU&rsquo;RE A MASTER OF SELF-CONTROL.</strong></span><br />
                        </h2>
                        
                        <p class="desc-btn"><a href="http://rnli.org/howtosupportus/getinvolved/events/Pages/default.aspx" class="button widebutton">
                         <span><img src="<?php echo get_template_directory_uri().'/img/challenge.png';?>"/></span>
                        </a>
                        </p>
                        <?php                        
                        }else{
                        ?>
                        <h2 class="description desktop">
                            <span class="home-desc1">Can you become a <br />master of self control?</span>
                            <span class="home-desc2">Take 2 weeks. Drink nothing but water.</span>
                        </h2>

                        <h2 class="description mobile">
                            <span class="home-desc1">Become a master of self control?</span><br />
                            <span class="home-desc2">Take 2 weeks.<br/>Drink nothing but water.</span>
                        </h2>

                        <p class="desc-btn"><a href="<?php echo get_permalink(6); ?>" class="button widebutton">
                         <span><img src="<?php echo get_template_directory_uri().'/img/signup-sm.png';?>"/></span>
                        </a>
                        </p>
                        <?php
                        }
                        ?>                         
                    </div>                    -->
                </div>
               <div class="grid-50 mobile-grid-100">
                    <div class="common-social-links">
                        <ul id="menu-social" class="menu">
                            <li class="hashtag"><span>#h2only</span></li>
                            <li class="facebook"><a href="http://www.facebook.com/sharer.php?s=100&p[title]=<?php echo urlencode($fbtitle);?>&p[summary]=<?php echo urlencode($fbcopy);?>&p[url]=<?php bloginfo( 'url' ); ?>&p[images][0]=<?php bloginfo( 'url' ); ?>/wp-content/themes/h2only/img/fbook.jpg" title="Facebook">Facebook</a></li>
                            <li class="twitter"><a href="http://twitter.com/share?text=<?php echo urlencode($twcopy); ?>" title="Twitter" >Twitter</a></li>
                            <li class="email hide-on-mobile"><a href="mailto: ?subject=<?php echo str_replace(" ", "%20",$emsubj)?>&body=<?php echo str_replace(" ", "%20",str_replace("<br />", "%0D%0A",nl2br($embody)));?>" title="Email" >Email</a></li>
                        </ul>
                    </div>                
                    <!--<div class="graphic date" itemscope itemtype="http://schema.org/Event">
                        <meta itemprop="startDate" content="2014-05-27">
                        <meta itemprop="endDate" content="2014-06-10">
                        <meta itemprop="name" content="<?php bloginfo( 'name' ); ?>">
                        <meta itemprop="image" content="<?php bloginfo( 'url' ); ?>/wp-content/themes/h2only/img/fbook.jpg">
                        <div class="zen-holder">
                            <img class="zen-man" src="<?php echo get_bloginfo('template_directory'); ?>/img/man3.png"  alt="27th may to 10th June" />
                            <img class="zen-man mobile" src="<?php echo get_bloginfo('template_directory'); ?>/img/man-sm3.png"  alt="27th may to 10th June" />
<?php                        
if (strpos($template , 'return') === false )  {              
?>                            
                            <img class="date" src="<?php echo get_bloginfo('template_directory'); ?>/img/date.png"  alt="27th may to 10th June" />
                            <img class="date mobile" src="<?php echo get_bloginfo('template_directory'); ?>/img/date-sm.png"  alt="27th may to 10th June" />
<?php
}
else{
?>
                            <img class="date" src="<?php echo get_bloginfo('template_directory'); ?>/img/blank.png"  alt="27th may to 10th June" />
                            <img class="date mobile" src="<?php echo get_bloginfo('template_directory'); ?>/img/blank.png"  alt="27th may to 10th June" />
<?php
}
?>
                        </div>
                    </div>
                </div> -->
<?php
}else{
?>
                <div class="grid-50 mobile-grid-100">
                    <div id="header-logo"><a href="http://www.rnli.org.uk/" class="external" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><span><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></span></a></div>
                </div>
                <div class="grid-50 mobile-grid-100">
                    <div class="common-social-links hide-on-mobile">
                        <ul id="menu-social" class="menu">
                            <li class="hashtag"><span>#h2only</span></li>
                            <li class="twitter"><a href="http://twitter.com/share?url=<?php bloginfo( 'url' ); ?>&amp;text=<?php echo urlencode($twcopy); ?>" title="Twitter" >Twitter</a></li>
                            <li class="facebook"><a href="http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo urlencode($fbtitle);?>&amp;p[summary]=<?php echo urlencode($fbcopy);?>&amp;p[url]=<?php bloginfo( 'url' ); ?>&amp;p[images][0]=<?php bloginfo( 'url' ); ?>/wp-content/themes/h2only/img/facebook-icon.jpg" title="Facebook">Facebook</a></li>
                            <li class="email"><a href="mailto: ?subject=<?php echo str_replace(" ", "%20",$emsubj)?>&body=<?php echo str_replace(" ", "%20",str_replace("<br />", "%0D%0A",nl2br($embody)));?>" title="Email" >Email</a></li>
                        </ul>
                    </div>                
                </div>
               <!--  <div class="grid-70 prefix-30 mobile-grid-100 grid-parent">
                    <div id="header-strap" >
                        <div class="strap graphic"><a href="<?php bloginfo( 'url' ); ?>"><span><?php bloginfo( 'name' ); ?></span></a></div>     
                    </div>
                    <div class="graphic date" itemscope itemtype="http://schema.org/Event">
                        <meta itemprop="startDate" content="2014-05-27">
                        <meta itemprop="endDate" content="2014-06-10">
                        <meta itemprop="name" content="<?php bloginfo( 'name' ); ?>">
                        <meta itemprop="image" content="<?php bloginfo( 'url' ); ?>/wp-content/themes/h2only/img/facebook-icon.jpg">
                        <img src="<?php echo get_bloginfo('template_directory'); ?>/img/date.png"  alt="27th may to 10th June" />
                    </div>                
					
                </div>                --> 
<?php
}  
?>                  
                
			</div>
            <div class="border-bottom block"></div>
		</header>
        <?php 

        if( is_page_template('tmpl/form-page.php') ) {
            //echo '<div class="water-line-signup"><div>';
        }
        if( is_front_page() ) {
        }
        else {
            // echo '<div class="water-line-other"></div>';
        } 
        
        ?>

<div class="container">
   <div class="row">
        <div class="col-xs-12">      
            <?php 
            while ( have_posts() ) : the_post();
            if (is_home() || is_front_page() || strpos($template , 'front-page') !== false ) { ?>
                <h2 class="maintitle"><?php echo nl2br(strip_tags(get_the_content(),'<strong><br><span><br /><sub>')); ?></h2>
            <?php }else{ ?>
                <h1 class="maintitle"><?php echo nl2br(strip_tags(get_the_title(),'<strong><br><span><br /><sub>')); ?></h1>
            <?php
            }   endwhile;
            ?>
        </div>
    </div>
</div>   
