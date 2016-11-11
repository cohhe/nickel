<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Nickel
 * @since Nickel 1.0
 */

get_header();

global $nickel_site_width;
?>

<div id="main-content" class="main-content row">
	<?php
		if ( NICKEL_LAYOUT == 'sidebar-left' ) {
			get_sidebar( 'post' );
		}
	?>
	<div class="content-wrapper <?php echo esc_attr($nickel_site_width); ?>">
		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				/*
				 * Include the post format-specific template for the content. If you want to
				 * use this in a child theme, then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */

				get_template_part( 'content', get_post_format() ? get_post_format() : get_post_type() );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile;
		?>
	</div><!-- .content-wrapper -->
	<?php
		if ( NICKEL_LAYOUT == 'sidebar-right' ) {
			get_sidebar( 'post' );
		}
	?>
</div><!-- #main-content -->

<?php
get_footer();