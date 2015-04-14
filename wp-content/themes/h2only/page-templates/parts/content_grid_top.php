<section class="row top_grid">
    <div class="inner_content">
        <ul>            
            <li class="block right">
                <h3>BRAVE IT. RAISE MONEY.</h3>
                <img src="<?php echo get_template_directory_uri(); ?>/img/brave_it.jpg" alt="Brave it!"> 
                <article class="grid_copy">
                    <p>Our lifeboat crews and lifeguards know all about staying strong. They do it every day – dropping everything to go out on the water and save lives. 
                    Many of our crews are volunteers, so they rely on the support of people like you. So be inspired by their dedication day after day, and go H<sub class="lower_2">2</sub>Only for just 10.</p> 
                    <a href="http://rnli.org/aboutus/Pages/About-us-new.aspx/" class="site_cta">MORE ABOUT THE RNLI</a>
                </article>                      
            </li>
            <li class="block left">
                <h3>H<sub class="lower_2">2</sub>ONLY KIT</h3>
                <img src="<?php echo get_template_directory_uri(); ?>/img/h2only_kit.jpg" alt="H2only Kit">  
                <article class="grid_copy">
                    <p>If you’re going to deny the drinks you love, you’ll need help, hope and beer on the horizon. Plus some fundraising ideas, to make it all worthwhile.</p>     
                    <a href="<?php echo get_permalink(230); ?>" class="site_cta">Download your kit </a>
                </article>                
            </li>

            <li class="block left">
                <h3>h<sub class="lower_2">2</sub>only Crew</h3>
                <img src="<?php echo get_template_directory_uri(); ?>/img/h2only_crew.jpg" alt="H2only Crew">  
                <article class="grid_copy">
                    <p>You don’t have to go it alone. Team up with your coffee-break buddies or after-work pub pals and deny your cravings together. You’ll raise even more money as a crew.</p>    
                    <a href="http://www.facebook.com/sharer.php?s=100&p[title]=<?php echo urlencode($fbtitle);?>&p[summary]=<?php echo urlencode($fbcopy);?>&p[url]=<?php bloginfo( 'url' ); ?>&p[images][0]=<?php echo get_template_directory_uri(); ?>/img/fbook.jpg&u=<?php urlencode(bloginfo( 'url' )); ?>&t=<?php echo urlencode($fbtitle);?>" target="_blank" class="site_cta" title="Facebook">Tell your friends</a>
                </article>
                
            </li>
            <li class="block right">
                <h3>DON’T MISS THE APP</h3>
                <img src="<?php echo get_template_directory_uri(); ?>/img/download_app.jpg" alt="All aboard the app"> 
                <article class="grid_copy">
                    <p>The H<sub class="lower_2">2</sub>Only app will be available on 26 May. It’ll be your buddy for 10 days, with fun challenges to keep you going and a live stream so you can keep track of your fellow H<sub>2</sub>Onlies. Sign up for the challenge and we’ll let you know when the app is ready.</p> 
<?php
preg_match("/iPhone|Android|iPad|iPod|iWatch|webOS/", $_SERVER['HTTP_USER_AGENT'], $matches);
$os = current($matches);
$link = '';
switch($os){
   case 'iPhone':
   case 'iPad':
   case 'iPod':
   case 'iWatch':   
        $link='ios'; break;
   case 'Android': $link='g+'; break;
   case 'webOS': $link='m+'; break;
   default: $link='ios';
}
?>                    
                    <a href="<?php echo get_permalink(194); ?>" data-type="<?php echo $link; ?>" class="site_cta">Take the challenge</a>
                </article>                      
            </li>
        </ul>
    </div>
</section>
<div class="clear"></div>