<?php
/**
 * The template for displaying Author archive pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Nickel
 * @since Nickel 1.0
 */

get_header();

global $nickel_site_width;

?>

<div id="main-content" class="main-content">
	<h1 class="main-page-title"><?php esc_html_e('Author', 'nickel'); echo ': ' . get_the_author(); ?></h1>
	<div class="content-wrapper">
		<?php if ( have_posts() ) :
				/*
				 * Since we called the_post() above, we need to rewind
				 * the loop back to the beginning that way we can run
				 * the loop properly, in full.
				 */
				rewind_posts();

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
	<?php the_posts_pagination(); ?>
</div><!-- #main-content -->

<?php
get_footer();
