 <?php
$twcopy = 'Can you deny the drinks you love for 10 days? Brave it and go #H2Only to help #RNLI save lives at sea '; 
$fbtitle = 'Go on, just one sip';
$fbcopy = "Can you deny the drinks you love? Brave it for 10 days without tea, coffee, wine, beer and fizzy drinks to help the RNLI save lives at sea. Take the challenge from 2 June at 5pm to 12 June at 5pm.";
$emsubj = 'Go on, just one sip';
$embody = '
I dare you to take the H2Only challenge and say no to tea, coffee, wine, beer and fizzy drinks for 10 days. 

That’s 10 days, from 5pm on 2 June to 5pm on 12 June, to help the RNLI’s brave lifeboat crew to save lives at sea. Are you in? 

Find out more - http://www.h2only.org.uk
Sign up now - http://www.h2only.org.uk/jg-account
';
 ?>
 <header class="site_header" role="banner">
            <div class="inner_content">    
                <img src="<?php echo get_template_directory_uri(); ?>/img/header_trans.png" alt="h2only" class="hero_img desktop_only" width="100%">      
                <img src="<?php echo get_template_directory_uri(); ?>/img/header_trans_tab.png" alt="h2only" class="hero_img tablet" width="100%"> 
                <img src="<?php echo get_template_directory_uri(); ?>/img/header_trans_mob.png" alt="h2only" class="hero_img mobile" width="100%">       
                <div class="header_inner_content">
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
                                <a href="http://www.facebook.com/sharer.php?s=100&p[title]=<?php echo urlencode($fbtitle);?>&p[summary]=<?php echo urlencode($fbcopy);?>&p[url]=<?php bloginfo( 'url' ); ?>&p[images][0]=<?php echo get_template_directory_uri(); ?>/img/fbook.jpg&u=<?php urlencode(bloginfo( 'url' )); ?>&t=<?php echo urlencode($fbtitle);?>&u=<?php urlencode(bloginfo( 'url' )); ?>&t=<?php echo urlencode($fbtitle);?>" title="Facebook"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li class="twitter">
                                <a href="http://twitter.com/share?text=<?php echo urlencode($twcopy); ?>&url=<?php bloginfo( 'url' ); ?>" title="Twitter" ><i class="fa fa-twitter"></i></a>
                            </li>
                            <li class="email">
                                <a href="mailto: ?subject=<?php echo str_replace(" ", "%20",$emsubj)?>&body=<?php echo str_replace(" ", "%20",str_replace("<br />", "%0D%0A",nl2br($embody)));?>" title="Email" ><i class="fa fa-envelope-o"></i></a>
                            </li>
                        </ul>
                    </section>  
                
                    <?php if ( is_page_template('page-templates/home.php') ) { ?>
                        <section class="hero_banner">                            
                            <div class="hero_banner_copy">
                                <!-- <h1>H2Only <img src="<?php echo get_template_directory_uri(); ?>/img/h2_only.png" alt="" width="100%"></h1> -->
                                <p>Can you deny the drinks you love for 10 days?<br />Take the challenge and say no to tea, coffee, wine, beer and fizzy drinks to help the RNLI save lives at sea.  </p>
                                <a href="<?php echo get_permalink(194); ?>" class="site_cta">Take the challenge</a>
                                <!-- <p><strong>ONLY 
                                <?php
                                    $date = strtotime("June 2, 5:00 PM");
                                    $remaining = $date - time();
                                    $days_remaining = floor($remaining / 86400);
                                    $hours_remaining = floor(($remaining % 86400) / 3600);
				    $daysArr = str_split($days_remaining, 1);            
				    $hrsArr = str_split($hours_remaining, 1);            
                                ?>            
                                <?php echo $days_remaining;?> DAY<?php echo ($days_remaining < 2) ? '':'S';?></strong></p>   -->  

                                <section class="countdown">
                                    <p>
                                    <?php
                                    if (count($daysArr) == 1) array_unshift($daysArr, 0);  
                                    foreach ($daysArr as $dy):
                                    ?>
                                    <span><?php echo $dy;?></span>
                                    <?php
                                    endforeach;
                                    ?>
                                     Day<?php echo ($days_remaining != 1) ? 's':'';?> and 
                                    <?php
                                    if (count($hrsArr) == 1) array_unshift($hrsArr, 0);
                                    foreach ($hrsArr as $hr):
                                    ?>
                                    <span><?php echo $hr;?></span>
                                    <?php
                                    endforeach;
                                    ?>
                                     Hour<?php echo ($hours_remaining != 1) ? 's':'';?> left</p>

                                    <article class="countdown_tagline">
                                        <div>7 weeks to go</div>
                                        <div>Challenge your friends</div>
                                        <div>5 weeks ‘til water only</div>
                                        <div>Start practising “no” </div>
                                        <div>Commence caffeine withdrawal</div>
                                        <div>Finish that bottle</div>
                                        <div>Start saying bye-bye beer</div>
                                        <div>Enjoy happy hour </div>
                                    </article>
                                </section>                            
                            </div>
                        </section>
                    <?php } ?>                    
                </div>
            </div>
            <div class="white_bar"></div>
        </header>
