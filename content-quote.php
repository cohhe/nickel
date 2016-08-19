<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Nickel
 * @since Nickel 1.0
 */

global $nickel_article_width;
$background = '';
if ( !is_single() ) {
	$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'nickel-latest-news' );
	$post_class = 'not-single-post';
	$header_class = 'simple';
	if ( !empty($img) ) {
		$background = ' style="background: url(' . $img['0'] . ') no-repeat;"';
	} else {
		$background = ' data-noimage="true"';
	}
} else {
	$post_class = 'single-post';
	$header_class = '';
}

$comments = wp_count_comments( get_the_ID() ); 
$comment_count = $comments->approved;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class($nickel_article_width.$post_class); echo $background; ?>>
	<header class="entry-header <?php echo $header_class; ?>">
		<?php
			if ( !is_single() && ( is_home() || is_archive() || is_search() ) ) {
				$whole_blockquote = nickel_getTextBetweenTags(get_the_content(), 'blockquote');
				$blockquote_cite = nickel_getTextBetweenTags($whole_blockquote, 'cite');
				echo '<div class="quote-date">' . get_the_date( get_option( 'date_format' ), get_the_ID() ) . '</div>';
				the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
				echo '<div class="post-cite-say">' . __('Say', 'nickel') . '</div>';
				echo '<div class="post-cite">' . $blockquote_cite . '</div>';
				echo '<div class="clearfix"></div>';
				echo '</header><!-- .entry-header -->
				<div class="overlay_border"></div>';
			} elseif ( is_single() && !is_home() ) {
				echo '</header><!-- .entry-header -->';
				$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'nickel-full-width' );
				echo '<div class="single-post-image-container">';
				if ( !empty($img) ) {
					echo '<img src="'.$img['0'].'" class="single-post-image" alt="Post with image">';
				}
				$cat_names = array();
				foreach (get_the_category() as $cat_value) {
					$cat_names[] = $cat_value->name;
				}
				echo '<span class="single-post-category">'.implode(', ',$cat_names).'</span>';
				echo '</div>';
				the_title( '<h1 class="entry-title">', '</h1>' );
			}
		?>
	<?php if ( !is_single() && ( is_home() || is_archive() || is_search() ) ) : ?>
	<?php else : ?>
	<div class="entry-content">
		<div id="entry-content-wrapper">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'nickel' ) ); ?>
		</div>
		<div class="entry-content-meta">
			<?php
				nickel_post_category_list( get_the_ID() );
				nickel_post_tag_list( get_the_ID() );
			?>
			<span class="entry-content-date icon-calendar"><?php echo get_the_date( get_option( 'date_format' ), get_the_ID() ); ?></span>
			<span class="entry-content-time icon-clock"><?php echo human_time_diff(get_the_time('U',$prev_post->ID),current_time('timestamp')) .  ' '.__('ago', 'nickel'); ?></span>
		</div>
		<?php if ( function_exists('nickel_get_content_share') ) { echo nickel_get_content_share(); } ?>
		<?php nickel_prev_next_links(); ?>
		<?php if ( get_the_author_meta( 'description' ) ) { ?>
			<div id="author-info">
				<h4 class="author-title"><?php _e('About post author', 'nickel'); ?></h4>
				<div class="author-infobox">
					<div id="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'vh_author_bio_avatar_size', 120 ) ); ?>
					</div>
					<div id="author-description">
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo get_the_author(); ?></a>
						<p><?php the_author_meta( 'description' ); ?></p>
					</div><!-- end of author-description -->
				</div>
				<div class="clearfix"></div>
			</div><!-- end of entry-author-info -->
		<?php } ?>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'nickel' ) . '</span>',
				'after'       => '<div class="clearfix"></div></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>
</article><!-- #post-## -->