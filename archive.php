<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Nickel 1.0
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
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
	<h1 class="main-page-title"><?php _e('Archive', 'nickel'); echo ': ' . single_month_title(' ', false); ?></h1>
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
	</div><!-- .content-wrapper -->
	<?php nickel_paging_nav(); ?>
</div><!-- #main-content -->

<?php
get_footer();