<?php
/**
 * The template for displaying image attachments
 *
 * @package WordPress
 * @subpackage Nickel
 * @since Nickel 1.0
 */

// Retrieve attachment metadata.
$metadata = wp_get_attachment_metadata();

get_header();

$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'nickel-full-width' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<div id="entry-content-wrapper">
			<?php if ( !empty($img) ) {
				echo '<img src="'.$img['0'].'" class="single-post-image" alt="Page with image">';
			} ?>
			<?php the_content(); ?>
		</div>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'nickel' ) . '</span>',
				'after'       => '<div class="clearfix"></div></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

<?php
get_footer();
