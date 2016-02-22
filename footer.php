<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Nickel
 * @since Nickel 1.0
 */
?>

		</div><!-- #main -->
	</div><!-- #page -->
	<div class="footer-wrapper">
		<div class="top-footer">
			<?php
				// How many footer columns to show?
				$footer_columns = get_option( 'vh_footer_columns' );
				if ( $footer_columns == false ) {
					$footer_columns = 4;
				}
			?>
			<div class="footer-links-container columns_count_<?php echo $footer_columns; ?>">
				<?php get_sidebar( 'footer' ); ?>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="bottom-footer">
			<div class="bottom-footer-inner">
				<div class="copyright">Theme by <a href="https://cohhe.com/">Cohhe</a></div>
				<div class="social-icons">
					<?php
						$facebook = get_theme_mod('nickel_header_facebook_icon', '');
						$twitter = get_theme_mod('nickel_header_twitter_icon', '');
						$gplus = get_theme_mod('nickel_header_gplus_icon', '');
					?>
					<?php if ( $facebook ) { ?>
						<a href="<?php echo $facebook; ?>" class="footer-social icon-facebook"></a>
					<?php } ?>
					<?php if ( $twitter ) { ?>
						<a href="<?php echo $twitter; ?>" class="footer-social icon-twitter"></a>
					<?php } ?>
					<?php if ( $gplus ) { ?>
						<a href="<?php echo $gplus; ?>" class="footer-social icon-gplus"></a>
					<?php } ?>
				</div>
				<nav id="bottom-navigation" class="bottom-navigation" role="navigation">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'bottom',
								'menu_class'     => 'nav-menu',
								'depth'          => 1,
								'walker'         => new Nickel_Header_Menu_Walker
							)
						);
					?>
				</nav>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<?php wp_footer(); ?>
</body>
</html>