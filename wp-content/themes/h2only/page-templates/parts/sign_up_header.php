        <a href="<?php echo home_url(); ?>"><header class="sign_up_header" role="banner">
            <div class="inner_content">    
                <img src="<?php echo get_template_directory_uri(); ?>/img/sign_header_trans.png" alt="h2only" class="hero_img" width="100%">     
                <!-- <img src="<?php echo get_template_directory_uri(); ?>/img/header_trans_tab.png" alt="h2only" class="hero_img tablet" width="100%">  -->
                <img src="<?php echo get_template_directory_uri(); ?>/img/sign_header_trans_mob.png" alt="h2only" class="hero_img mobile" width="100%">    
                <div class="header_inner_content">
                    <!-- site logo -->
                    <section class="site_logo">
                        <?php if ( is_page_template('page-templates/home.php') ) { ?>
                        <h1 class="logo"><a href="<?php echo home_url(); ?>" class="site_logo"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="LifeBoats" width="100%" />
                        </a></h1>          
                        <?php }else{?>
                        
                        <img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="LifeBoats" width="100%" />
                  
                        <?php } ?>
                    </section>
                </div>
            </div>
        </header></a> 