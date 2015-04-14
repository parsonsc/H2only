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
$twcopy = 'Can you deny the drinks you love for 10 days? Brave it and go #H2Only to help #RNLI save lives at sea '; 
$fbtitle = 'Go on, just one sip';
$fbcopy = "Can you deny the drinks you love? Brave it for 10 days without tea, coffee, wine, beer and fizzy drinks to help the RNLI save lives at sea. Take the challenge from 2 June at 5pm to 12 June at 5pm.";
$emsubj = 'Go on, just one sip';
$embody = '
I dare you to take the H2Only challenge and say no to tea, coffee, wine, beer and fizzy drinks for 10 days. 

That’s 10 days, from 5pm on 2 June to 5pm on 12 June, to help the RNLI’s brave lifeboat crew to save lives at sea. Are you in? 
';
$meta = '';
$metaArry = array();
$metaArry['og:title'] = 'Go on, just one sip';
$metaArry['og:description'] = "Can you deny the drinks you love? Brave it for 10 days without tea, coffee, wine, beer and fizzy drinks to help the RNLI save lives at sea. Take the challenge from 2 June at 5pm to 12 June at 5pm."; 
$metaArry['og:image'] = get_site_url() ."/badge.jpg";
$metaArry['og:url'] = get_permalink();

$metaArry['twitter:description']= "Can you deny the drinks you love for 10 days? Brave it and go #H2Only to help #RNLI save lives at sea"; 
$metaArry['twitter:image:src'] = get_site_url() ."/badge.jpg";
$metaArry['twitter:card'] = "summary" ;
$metaArry['twitter:site'] = "@H2OnlyHQ";
$metaArry['twitter:creator'] = "@H2OnlyHQ" ;
$metaArry['twitter:title'] = get_bloginfo('name'); 
if (isset($_GET['party'])){
    $metaArry['og:title'] = 'Ahoy there, party animals!';
    $metaArry['og:type'] = "website"; 
    $metaArry['og:image'] = get_site_url() ."/badge.jpg";
    $metaArry['og:url'] = get_permalink().'?party';
    $metaArry['og:description'] = "I'm packing away the cocktail shaker from 2-12 June. And I challenge you to join me and deny our favourite drinks for 10 days. Sign up and let's go H2Only together to help the RNLI to save lives at sea.";
    $metaArry['og:site_name'] = get_bloginfo('name');
    $metaArry['twitter:card'] = "summary" ;
    $metaArry['twitter:site'] = "@H2OnlyHQ";
    $metaArry['twitter:creator'] = "@H2OnlyHQ" ;
    $metaArry['twitter:title'] = "Ahoy there, party animals!"; 
    $metaArry['twitter:description'] ="I'm packing away the cocktail shaker from 2-12 June. And I challenge you to join me and deny our favourite drinks for 10 days. Sign up and let's go H2Only together to help the RNLI to save lives at sea. "; 
    $metaArry['twitter:image:src'] = get_site_url() ."/badge.jpg";
}
elseif (isset($_GET['beer'])){
    $metaArry['og:title'] = 'Ahoy there, beer buddies!';
    $metaArry['og:type'] = "website"; 
    $metaArry['og:image'] = get_site_url() ."/badge.jpg";
    $metaArry['og:url'] = get_permalink().'?beer';

    $metaArry['og:description'] = "I'm calling time at the bar from 2-12 June. And I challenge you to avoid the pub and go H2Only with me. That's no beer, wine, tea, coffee or fizzy drinks for 10 days. Sign up and let's go to help the RNLI save lives at sea.";
    $metaArry['og:site_name'] = get_bloginfo('name');
    $metaArry['twitter:card'] = "summary" ;
    $metaArry['twitter:site'] = "@H2OnlyHQ";
    $metaArry['twitter:creator'] = "@H2OnlyHQ" ;
    $metaArry['twitter:title'] = "Ahoy there, beer buddies!"; 
    $metaArry['twitter:description'] ="I'm calling time at the bar from 2-12 June. And I challenge you to avoid the pub and go H2Only with me. That's no beer, wine, tea, coffee or fizzy drinks for 10 days. Sign up and let's go to help the RNLI save lives at sea."; 
    $metaArry['twitter:image:src'] = get_site_url() ."/badge.jpg";    
    
}
elseif (isset($_GET['tea'])){
    $metaArry['og:title'] = 'Ahoy there, tea-breakers!';
    $metaArry['og:type'] = "website"; 
    $metaArry['og:image'] = get_site_url() ."/badge.jpg";
    $metaArry['og:url'] = get_permalink().'?tea';

    $metaArry['og:description'] = "I'm switching off the kettle and the coffee machine from 2-12 June. And I challenge you to swap our tea breaks for water cooler moments, as we go H2Only together. That's no tea, coffee, fizzy drinks, beer or wine to raise money and help the RNLI save lives at sea.";
    $metaArry['og:site_name'] = get_bloginfo('name');
    $metaArry['twitter:card'] = "summary" ;
    $metaArry['twitter:site'] = "@H2OnlyHQ";
    $metaArry['twitter:creator'] = "@H2OnlyHQ" ;
    $metaArry['twitter:title'] = "Ahoy there, tea-breakers!"; 
    $metaArry['twitter:description'] ="I'm switching off the kettle and the coffee machine from 2-12 June. And I challenge you to swap our tea breaks for water cooler moments, as we go H2Only together. That's no tea, coffee, fizzy drinks, beer or wine to raise money and help the RNLI save lives at sea."; 
    $metaArry['twitter:image:src'] = get_site_url() ."/badge.jpg";        
    
}
if (count($metaArry) > 0){
    //print_R($metaArry);
    foreach ($metaArry as $k=> $v){
         $meta .= sprintf('<meta property="%1$s" name="%1$s" content="%2$s" />' . "\n" , esc_attr($k), esc_attr($v));
    }
}
ob_start();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html <?php h2only_html_schema(); ?> prefix="og: http://ogp.me/ns#"<?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html <?php h2only_html_schema(); ?> prefix="og: http://ogp.me/ns#"<?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html <?php h2only_html_schema(); ?> prefix="og: http://ogp.me/ns#"<?php language_attributes(); ?> class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php h2only_html_schema(); ?> prefix="og: http://ogp.me/ns#"<?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title itemprop="name"><?php wp_title(''); ?></title>
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/img/ms-icon-150x150.png" />
    <link rel="apple-touch-icon" sizes="70x70" href="<?php echo get_template_directory_uri(); ?>/img/ms-icon-70x70.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/img/ms-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="150x150" href="<?php echo get_template_directory_uri(); ?>/img/ms-icon-150x150.png" />

    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.jpg">
    <!--[if IE]>
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico">
    <![endif]-->
    <!--[if lt IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" />
    <![endif]-->
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/img/social/ms-icon-150x150.png">

    <?php wp_head(); ?>
    
    <?php echo $meta;?>
</head>
<body>
    <?php include_once("analyticstracking.php") ?>
    <div class="site_container  <?php echo lcfirst(str_replace(" ", "", ucwords(trim(strtolower(preg_replace('/\b[a-zA-Z]{1,2}\b/u','',preg_replace('/[^a-zA-Z]+/u',' ', get_post_type()))))))); ?> <?php echo lcfirst(str_replace(" ", "", ucwords(trim(strtolower(preg_replace('/\b[a-zA-Z]{1,2}\b/u','',preg_replace('/[^a-zA-Z]+/u',' ', get_the_title()))))))); ?>" id="wrapper">
       
       