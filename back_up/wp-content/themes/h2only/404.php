<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

	<div id="primary" class="container">
		<div id="content" class="col-xs-12" role="main">




				<h1 class="page-title"><?php _e( 'Not found', 'h2only' ); ?></h1>

			<div class="page-wrapper">
				<div class="page-content">
					<h2><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'h2only' ); ?></h2>
					<p><?php _e( 'It looks like nothing was found at this location.', 'h2only' ); ?></p>

				</div><!-- .page-content -->
			</div><!-- .page-wrapper -->


		</div><!-- #content -->

	</div><!-- #primary -->
<?php get_footer(); ?>