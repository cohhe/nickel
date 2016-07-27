<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Nickel
 * @since Nickel 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */	
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-container">

	<?php if ( have_comments() ) : ?>

	<h4 class="comments-title"><?php esc_html_e('Comments', 'nickel'); ?></h4>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'nickel' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'nickel' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'nickel' ) ); ?></div>
	</nav><!-- #comment-nav-above -->
	<?php endif; // Check for comment navigation. ?>

	<ol class="commentlist">
		<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size'=> 60,
			) );
		?>
	</ol><!-- .comment-list -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'nickel' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'nickel' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'nickel' ) ); ?></div>
	</nav><!-- #comment-nav-below -->
	<?php endif; // Check for comment navigation. ?>

	<?php if ( ! comments_open() ) : ?>
	<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'nickel' ); ?></p>
	<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form(
		array('comment_notes_after' => '',
				'logged_in_as' => '',
				'url' => '',
				'title_reply'      => esc_html__( 'Leave a reply', 'nickel'),
				'comment_notes_before' => '<span class="comment-form-before">' . esc_html__('Your email adress will not be published. Required fields are marked*', 'nickel') . '</span>',
				'label_submit'    => esc_html__( 'Post Comment', 'nickel'),
				'comment_field' =>  '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . esc_html__('Comment*', 'nickel') . '">' . '</textarea></p>',
				'fields' => array(
					'author' =>
						'<div class="comment-form-top">
						<span class="comment-author"><input id="author" name="author" type="text" placeholder="' . esc_html__('Name*', 'nickel') . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" /></span>',
					'email' =>
						'<span class="comment-email"><input id="email" name="email" type="text" placeholder="' . esc_html__('E-mail*', 'nickel') . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" /></span><div class="clearfix"></div></div>',
					'url' =>
						'<span class="comment-url"><input id="url" name="url" type="text" placeholder="' . esc_html__('Website', 'nickel') . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></span>',
				)
			)
		); ?>

</div><!-- #comments -->