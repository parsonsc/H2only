<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 */
?>
		
			<footer role="contentinfo" class="footer">
				<div class="inner_content">
					<div id="footer-nav-social" class="col-sm-6">
	                    <a class="button bbold twitter" href="http://twitter.com/h2onlyhq" title="Twitter" ><img class="img-responsive" src="<?php echo get_template_directory_uri().'/img/twitter.jpg';?>"/></a>
	                    <a class="button bbold facebook" href="https://www.facebook.com/pages/H2Only/701066859936676" title="Facebook"><img class="img-responsive" src="<?php echo get_template_directory_uri().'/img/facebook.jpg';?>"/></a>
					</div>

	                <div class="footer-logo col-sm-3">
		                <a href="<?php bloginfo( 'url' ); ?>">
		                <img class="img-responsive" src="<?php echo get_template_directory_uri().'/img/logo-sml.png';?>"/>
		                </a>
	                </div>
	                <div class="footer-lifeboat col-sm-3">
		                <a href="http://www.rnli.org.uk/" class="external" 
		                title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
		                <img class="img-responsive" src="<?php echo get_template_directory_uri().'/img/rnli-sml.png';?>"/></a>
	                </div>

					<div class="footer-nav col-md-12">
		                <?php wp_nav_menu( array( 'theme_location' => 'sitemap', 'menu_class' => 'sitemap' ) ); ?>
					</div>

					<div class="footer-copy col-sm-10">
						The <strong>Royal National Lifeboat Institution</strong> is a charity registered in England and Wales (209603) and Scotland (SC037736). Charity number CHY 2678 in the Republic of Ireland | RNLI (Trading) Ltd &ndash; 1073377, RNLI (Sales) Ltd &ndash; 2202240, RNLI (Enterprises) Ltd &ndash; 1784500 and RNLI College Ltd &ndash; 7705470 are all companies registered at West Quay Road, Poole BH15 1HZ. Images &amp; copyright &copy; RNLI 2014. 
					</div>
					<div class="footer-frsb col-sm-2">
						<a href="http://www.frsb.org.uk/">
							<img alt="Fund Raising Standards Board Logo" 
							src="<?php echo get_bloginfo('template_directory'); ?>/img/frsb.png" />
						</a>
					</div>		
				</div>			
		</footer>
</div> <?php // END FOOTER CONTAINER ?>

    <!-- Scripts -->
	<?php wp_footer(); ?>
    

</body>
</html>
