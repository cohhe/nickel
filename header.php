<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Nickel
 * @since Nickel 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<?php
global $nickel_site_width, $nickel_layout_type, $withcomments;
$withcomments = 1;

$form_class    = '';
$class         = '';
$nickel_site_width    = 'col-sm-12 col-md-12 col-lg-12';
$layout_type   = get_post_meta(get_the_id(), 'layouts', true);

if ( !isset($search_string) ) {
	$search_string = '';
}

if ( is_archive() || is_search() || is_404() ) {
	$layout_type = 'full';
} elseif (empty($layout_type)) {
	$layout_type = get_theme_mod('nickel_layout', 'full');
}

$header_display = get_theme_mod('nickel_header_presentation', 'text');

switch ($layout_type) {
	case 'right':
		define('MAGAZINE_LAYOUT', 'sidebar-right');
		break;
	case 'full':
		define('MAGAZINE_LAYOUT', 'sidebar-no');
		break;
	case 'left':
		define('MAGAZINE_LAYOUT', 'sidebar-left');
		break;
}

if ( ( MAGAZINE_LAYOUT != 'sidebar-no' && is_active_sidebar( 'sidebar-5' ) ) || ( MAGAZINE_LAYOUT != 'sidebar-no' && is_active_sidebar( 'sidebar-6' ) ) ) {
	$nickel_site_width = 'col-sm-9 col-md-9 col-lg-9';
}

$logo = get_custom_header();
$logo = $logo->url;

if (get_search_query() == '') {
	$search_string = esc_html__('Search', 'nickel');
} else {
	$search_string = get_search_query();
}

$title_color_style = '';
$title_color = get_theme_mod('header_textcolor', false);
if ( $title_color ) {
	$title_color_style = 'style="color: #'.$title_color.'"';
}

?>
<body <?php body_class(); ?>>
<?php do_action('ase_theme_body_inside_top'); ?>
<div id="page" class="hfeed site">
	<header class="main-header">
		<div class="header-wrapper">
			<div class="logo-wrapper">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-logo">
					<?php if ( $header_display == 'logo' && $logo ) { ?>
						<img src="<?php echo esc_url($logo); ?>" alt="<?php esc_html_e('Site logo', 'nickel'); ?>">
					<?php } else { ?>
						<span class="blog-name" <?php echo $title_color_style; ?>><?php bloginfo( 'name' ); ?></span>
						<span class="blog-description"><?php bloginfo( 'description' ); ?></span>
					<?php } ?>
				</a>
			</div>		
			<nav id="primary-navigation" class="primary-navigation" role="navigation">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_class'     => 'nav-menu',
							'depth'          => 4,
							'walker'         => new Nickel_Header_Menu_Walker
						)
					);
				?>
			</nav>
			<nav id="mobile-navigation" class="mobile-navigation" role="navigation">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_class'     => 'nav-mobile-menu',
							'depth'          => 4,
							'walker'         => new Nickel_Header_Menu_Walker
						)
					);
				?>
			</nav>
			<div class="bottom-header">
				<div class="header-search-container">
					<span class="header-search icon-search"></span>
					<?php get_search_form( true ); ?>
				</div>
				<?php if ( function_exists('nickel_get_social_icons') ) { nickel_get_social_icons(); } ?>
				<a href="javascript:void(0)" class="mobile-menu-button icon-menu"></a>
			</div>
			<div class="clearfix"></div>
		</div>
	</header>
	<div id="main" class="site-main container">