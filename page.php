<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Nickel
 * @since Nickel 1.0
 */

get_header();

global $nickel_site_width, $nickel_layout_type;

?>

<div id="main-content" class="main-content ">
	<?php if ( !is_front_page() ) { ?>
		<h1 class="main-page-title"><?php the_title(); ?></h1>
		<div class="clearfix"></div>
	<?php } ?>
	<?php
		if ( NICKEL_LAYOUT == 'sidebar-left' ) {
			get_sidebar( 'page' );
		}
	?>
	<div class="content-wrapper <?php echo esc_attr($nickel_site_width); ?>">

			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}

				endwhile;
				
			?>

	</div><!-- .content-wrapper -->
	<?php
		if ( NICKEL_LAYOUT == 'sidebar-right' ) {
			get_sidebar( 'page' );
		}
	?>
</div><!-- #main-content -->

<?php
get_footer();