<?php
/**
 * The Footer widget areas.
 */
?>

<?php
/* The footer widget area is triggered if any of the areas
	 * have widgets. So let's check that first.
	 *
	 */
if ( ! is_active_sidebar( 'sidebar-1' )
	&& ! is_active_sidebar( 'sidebar-2' )
	&& ! is_active_sidebar( 'sidebar-3' )
	&& ! is_active_sidebar( 'sidebar-4' )
)
	return;

// How many footer columns to show?
$footer_columns = 0;
if ( is_active_sidebar( 'sidebar-1' ) ) { $footer_columns++; }
if ( is_active_sidebar( 'sidebar-2' ) ) { $footer_columns++; }
if ( is_active_sidebar( 'sidebar-3' ) ) { $footer_columns++; }
if ( is_active_sidebar( 'sidebar-4' ) ) { $footer_columns++; }

$class = ' col-sm-12 ';
if ( $footer_columns == 4 ) {
	$class = ' col-sm-3 ';
} elseif ( $footer_columns == 3 ) {
	$class = ' col-sm-4 ';
} elseif ( $footer_columns == 2 ) {
	$class = ' col-sm-6 ';
}

// If we get this far, we have widgets. Let do this.
?>
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
		<div id="first" class="widget-area footer-links <?php echo $class; ?>" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	<?php } ?>

	<?php if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
		<div id="second" class="widget-area footer-links <?php echo $class; ?>" role="complementary">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</div>
	<?php } ?>

	<?php if ( is_active_sidebar( 'sidebar-3' ) ) { ?>
		<div id="third" class="widget-area footer-links <?php echo $class; ?>" role="complementary">
			<?php dynamic_sidebar( 'sidebar-3' ); ?>
		</div>
	<?php } ?>

	<?php if ( is_active_sidebar( 'sidebar-4' ) ) { ?>
		<div id="fourth" class="widget-area footer-links <?php echo $class; ?>" role="complementary">
			<?php dynamic_sidebar( 'sidebar-4' ); ?>
		</div>
	<?php }