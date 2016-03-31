<?php
/**
 * The Content Sidebar
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */

if ( MAGAZINE_LAYOUT != 'sidebar-no' && is_active_sidebar( 'sidebar-5' ) ) {
?>
<div id="secondary" class="content-sidebar widget-area col-sm-3 col-md-3 col-lg-3">
	<div id="content-sidebar" class="content-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-5' ); ?>
	</div><!-- #content-sidebar -->
</div>
<?php
}