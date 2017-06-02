<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Nickel
 * @since Nickel 1.0
 */

get_header();

global $nickel_site_width;
?>
<div id="main-content" class="main-content">
	<h1 class="main-page-title"><?php esc_html_e('Search results', 'nickel'); echo ': ' . get_search_query(); ?></h1>
	<div class="content-wrapper">
		<?php if ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

				endwhile;
			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif;
		?>
		<div class="clearfix"></div>
	</div><!-- .content-wrapper -->
</div><!-- #main-content -->

<?php
get_footer();
