<?php
/**
 * The Template for displaying all single news posts.
 *
 */

get_header(); ?>

				<div class="grid-100">
				
					<?php while ( have_posts() ) : the_post(); ?>

					<div class="news-date"><span class="the-red">News</span> | <?php the_time('l, jS F') ?></div>
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
					<div class="common-social-links news-article">
						<ul>
							<li><a href="javascript:;" title="Twitter" class="twitter">Twitter</a></li>
							<li><a href="javascript:;" title="Facebook" class="facebook">Facebook</a></li>
							<li><a href="javascript:;" title="Email" class="email">Email</a></li>
						</ul>
					</div>
					<hr />
					<?php
			        $added = "";
			        if(isset($_SERVER['HTTP_REFERER'])) { 
			                $old_url = $_SERVER['HTTP_REFERER'];
			        }
					?>
					<a class="back" href="<?php echo $old_url;?>">Back to News</a>	
					<?php h2only_post_nav(); ?>
					<?php comments_template(); ?>
					<?php endwhile; ?>									
				</div>



<?php get_sidebar(); ?>
<?php get_footer(); ?>