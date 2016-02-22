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
?>

<div id="main-content" class="main-content">
	<div class="content-wrapper">
	</div><!-- .content-wrapper -->
</div><!-- #main-content -->

<?php
get_footer();
