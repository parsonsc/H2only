<?php
/**
 * The Template for displaying all single news posts.
 *
 */

get_header(); ?>


		<div class="clearfix clear vertical-breaker-35 mobile-vertical-breaker-20"></div>
		
		<div id="main" role="main">
			
			<div class="grid-container">
				<?php while ( have_posts() ) : the_post(); ?>
                <?php
                if (in_category('news')) :
                ?>
				<div class="grid-100 news">				
                    
					<div class="news-date"><span class="the-red"><a href="<?php echo get_permalink(11);?>">News</a></span> | <?php the_time('l, jS F') ?></div>
					<h1><?php the_title(); ?></h1>
                <?php
                else :
                ?>
                <div class="grid-100 case">		
                    <div class="case-study-title"><span class="the-red">Our Heroes </span> | <?php echo str_replace("Meet ", "", get_the_title()); ?></div>                    
                    <?php
                    endif;
                    ?>
					<?php the_content(); ?>
					<div class="common-social-links news-article">
						<ul>
                            <li class="twitter" id="menu-item-37"><a href="http://www.twitter.com/share?url=<?php echo add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) ?>&amp;text=">Twitter</a></li>
                            <li class="facebook" id="menu-item-38"><a href="http://www.facebook.com/sharer.php?url=<?php echo add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) ?>">Facebook</a></li>
                            <li class="email" id="menu-item-39"><a href="mailto: ?subject=%20&body=%0D%0A%0D%0A<?php echo add_query_arg( $wp->query_string, '', home_url( $wp->request )); ?>%0D%0A%0D%0A">Email</a></li>
						</ul>
					</div>
					<hr />
					<?php
			        $added = "";
			        if(isset($_SERVER['HTTP_REFERER'])) { 
			                $old_url = $_SERVER['HTTP_REFERER'];
			        }
					?>
                    <?php
                    if (in_category('news')) :
                    ?>
					<a class="back" href="<?php echo get_permalink(11);?>">Back to News</a>	
                     <?php
                    else :
                    ?>
                    <a class="back" href="<?php echo get_permalink(7);?>">Back to Case studies</a>	              
                    <?php
                    endif;
                    ?>
					<?php comments_template(); ?>
				</div>
				<?php endwhile; ?>									
			</div>
		</div>


<?php get_sidebar(); ?>
<?php get_footer(); ?>