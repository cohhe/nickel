<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Nickel
 * @since Nickel 1.0
 */

$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'nickel-full-width' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<div id="entry-content-wrapper">
			<?php if ( !empty($img) ) {
				echo '<img src="'.esc_url($img['0']).'" class="single-post-image" alt="Page with image">';
			} ?>
			<?php the_content(); ?>
		</div>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'nickel' ) . '</span>',
				'after'       => '<div class="clearfix"></div></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->