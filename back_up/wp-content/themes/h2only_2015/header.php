<?php 
if(function_exists('lcfirst') === false) {
    function lcfirst($str) {
        $str[0] = strtolower($str[0]);
        return $str;
    }
} 

function csssafename($int, $span = 10){
    $string = '';
    $int = $int % $span;
    switch ((int)$int){
        case 0: return 'first';
        case 1: return 'second';
        case 2: return 'third';
        case 3: return 'fourth';
        case 4: return 'fifth';
        case 5: return 'sixth';
        case 6: return 'seventh';
        case 7: return 'eighth';
        case 8: return 'ninth';
        case 9: return 'tenth';
    }
}
$twcopy = 'Ice tea without tea. A pint of water at happy hour. Test your willpower. Take the water-only #H2Only challenge at '; 
$fbtitle = 'Take two weeks. Drink nothing but water.';
$fbcopy = "For two weeks, I’m going to drink nothing but water to raise money for our heroes of the high seas. Test your willpower and see if you can drink H2Only – sign up now.";
$emsubj = 'RNLI H2Only';
$embody = '
hello there

2 weeks. Just water. Are you up to the challenge?

thanks
';
ob_start();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html <?php h2only_html_schema(); ?> <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html <?php h2only_html_schema(); ?> <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html <?php h2only_html_schema(); ?> <?php language_attributes(); ?> class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php h2only_html_schema(); ?> <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title itemprop="name"><?php wp_title(''); ?></title>
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/img/social/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/img/social/apple-touch-icon-57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/img/social/apple-touch-icon-72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/img/social/apple-touch-icon-76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/img/social/apple-touch-icon-114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/img/social/apple-touch-icon-120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/img/asocial/pple-touch-icon-144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/img/social/apple-touch-icon-152.png" />
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/social/favicon.png">
    <!--[if IE]>
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/social/favicon.ico">
    <![endif]-->
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/img/social/apple-touch-icon-144.png">

    <?php wp_head(); ?>
 
</head>
<body>
    <?php include_once("analyticstracking.php") ?>
    <div class="site_container  <?php echo lcfirst(str_replace(" ", "", ucwords(trim(strtolower(preg_replace('/\b[a-zA-Z]{1,2}\b/u','',preg_replace('/[^a-zA-Z]+/u',' ', get_post_type()))))))); ?> <?php echo lcfirst(str_replace(" ", "", ucwords(trim(strtolower(preg_replace('/\b[a-zA-Z]{1,2}\b/u','',preg_replace('/[^a-zA-Z]+/u',' ', get_the_title()))))))); ?>" id="wrapper">
        <header class="site_header" role="banner">
            <div class="inner_content">
                <!-- site logo -->
                <section class="site_logo">
                <?php if ( is_page_template('page-templates/home.php') ) { ?>
                <h1 class="logo"><a href="<?php echo home_url(); ?>" class="site_logo"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="LifeBoats" width="100%" />
                </a></h1>          
                <?php }else{?>
                <a href="<?php echo home_url(); ?>" class="site_logo">
                <img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="LifeBoats" width="100%" />
                </a>
                <?php } ?>
                </section>
                <section class="social_buttons">
                    <ul id="menu-social" class="menu">
                        <li class="facebook">
                            <a href="http://www.facebook.com/sharer.php?s=100&p[title]=<?php echo urlencode($fbtitle);?>&p[summary]=<?php echo urlencode($fbcopy);?>&p[url]=<?php bloginfo( 'url' ); ?>&p[images][0]=<?php echo get_template_directory_uri(); ?>/img/fbook.jpg" title="Facebook">Facebook</a>
                        </li>
                        <li class="twitter">
                            <a href="http://twitter.com/share?text=<?php echo urlencode($twcopy); ?>&url=<?php bloginfo( 'url' ); ?>" title="Twitter" >Twitter</a>
                        </li>
                        <li class="email">
                            <a href="mailto: ?subject=<?php echo str_replace(" ", "%20",$emsubj)?>&body=<?php echo str_replace(" ", "%20",str_replace("<br />", "%0D%0A",nl2br($embody)));?>" title="Email" >Email</a>
                        </li>
                    </ul>
                </section>  
            </div>
        </header>
        <?php if ( is_page_template('page-templates/home.php') ) { ?>
        <section class="hero_banner">
            <div class="inner_content">
                <img src="<?php echo get_template_directory_uri(); ?>/img/header_trans.png" alt="" width="100%">
                <div class="hero_banner_copy">
                    <h1>H2Only <img src="<?php echo get_template_directory_uri(); ?>/img/h2_only.png" alt="" width="100%"></h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vel volutpat ante. In hac habitasse platea dictumst.</p>
                    <p><strong>ONLY 
<?php
$date = strtotime("May 25, 1:00 AM");
$remaining = $date - time();
$days_remaining = floor($remaining / 86400);
$hours_remaining = floor(($remaining % 86400) / 3600);            
?>            
                    <?php echo $days_remaining;?> DAY<?php echo ($days_remaining < 2) ? '':'S';?> TO GO</strong></p>
                    <a href="<?php echo get_permalink(6); ?>" class="site_cta">Sign up now</a>
                </div>
            </div>
        </section>
        <?php } ?>