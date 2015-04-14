    <!-- site footer -->
    <footer class="site_footer">
        <div class="inner_content">
            <section class="footer_nav">
                    <ul class="rnli">                        
                        <li>
                            <a href="<?php bloginfo( 'url' ); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/footer_h2only.png" alt="">
                            </a>
                        </li>
                        <li class="hide_desktop">
                            <a href="http://www.rnli.org/">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/footer_logo.png" alt="Lifeboats">
                            </a>
                        </li>
                        <li class="footer_social">
                            <a href="https://twitter.com/rnli" class="twitter">
                               <i class="fa fa-twitter"></i> FOLLOW @RNLI
                            </a>
                        </li>
                        <li class="footer_social">
                            <a href="https://www.facebook.com/rnli" class="facebook">
                                <i class="fa fa-facebook"></i>LIKE RNLI
                            </a>
                        </li>

                        <li class="desktop_only">
                            <a href="http://www.rnli.org/">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/footer_logo.png" alt="Lifeboats">
                            </a>
                        </li>
                    </ul>
                
            </section>
            <div class="clear"></div>
            <ul class="footer_subnav">
                <li><a href="<?php bloginfo( 'url' ); ?>">H<sub class="lower_2">2</sub>Only</a></li>
                <li>
                    <a href="http://www.rnli.org/">RNLI Home</a>
                </li>
                <?php h2only_nav_menu( array( 'theme_location' => 'footer-links', 'container'=> '' ), false ); ?>                
                <li>                        
                    <a href="http://www.frsb.org.uk/"><img alt="Fund Raising Standards Board Logo" src="<?php echo get_template_directory_uri(); ?>/img/fsrb.png" alt="" /></a>
                </li>
            </ul>
            <div class="clear"></div>
            <article class="legal">
                <p>The Royal National Lifeboat Institution is a charity registered in England and Wales (209603) and Scotland (SC037736). 
                Registered charity number 20003326 in the Republic of Ireland. RNLI (Sales) Ltd &ndash; 2202240, RNLI (Enterprises) Ltd &ndash; 1784500 and RNLI College Ltd &ndash; 7705470 are all companies registered at West Quay Road, Poole BH15 1HZ. Images &amp; copyright &copy; RNLI 2015. </p>
            </article>
        </div>
    </footer>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
<?php
ob_end_flush();
?>