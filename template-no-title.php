<?php
/*
* Template Name: Without page title
*/
get_header();

global $nickel_site_width, $nickel_layout_type;

?>

<div id="main-content" class="main-content ">
	<?php
		if ( MAGAZINE_LAYOUT == 'sidebar-left' ) {
			get_sidebar( 'page' );
		}
	?>
	<div class="content-wrapper <?php echo $nickel_site_width; ?>">

			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'page' );

				endwhile;
				
			?>

	</div><!-- .content-wrapper -->
	<?php
		if ( MAGAZINE_LAYOUT == 'sidebar-right' ) {
			get_sidebar( 'page' );
		}
	?>
</div><!-- #main-content -->

<?php
get_footer();