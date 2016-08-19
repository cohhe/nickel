<?php
/**
 * Nickel 1.0 functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Nickel
 * @since Nickel 1.0
 */

/**
 * Set up the content width value based on the theme's design.
 *
 * @see nickel_content_width()
 *
 * @since Nickel 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 800;
}

/**
 * Nickel 1.0 only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'nickel_setup' ) ) :
	/**
	 * Nickel 1.0 setup.
	 *
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support post thumbnails.
	 *
	 * @since Nickel 1.0
	 */
	function nickel_setup() {
		require(get_template_directory() . '/inc/metaboxes/layouts.php');

		/**
		 * Required: include TGM.
		 */
		require_once( get_template_directory() . '/functions/tgm-activation/class-tgm-plugin-activation.php' );

		/*
		 * Make Nickel 1.0 available for translation.
		 *
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on Nickel 1.0, use a find and
		 * replace to change 'nickel' to the name of your theme in all
		 * template files.
		 */
		load_theme_textdomain( 'nickel', get_template_directory() . '/languages' );

		// This theme styles the visual editor to resemble the theme style.
		add_editor_style( array( 'css/editor-style.css' ) );

		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails, and declare two sizes.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 672, 372, true );
		add_image_size( 'nickel-full-width', 1170, 700, true );
		add_image_size( 'nickel-small-thumb', 280, 220, true );
		add_image_size( 'nickel-horizontal-thumb', 190, 190, true );
		add_image_size( 'nickel-latest-news', 500, 300, true );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list',
		) );

		// This theme allows users to set a custom background.
		add_theme_support( 'custom-background', apply_filters( 'nickel_custom_background_args', array(
			'default-color' => 'fff',
		) ) );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'   => __( 'Primary menu', 'nickel' ),
			'bottom'    => __( 'Bottom menu', 'nickel' )
		) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'quote'
		) );

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-header' );
	}
endif; // nickel_setup
add_action( 'after_setup_theme', 'nickel_setup' );

// Admin CSS
function nickel_admin_css() {
	wp_enqueue_style( 'nickel-admin-css', get_template_directory_uri() . '/css/wp-admin.css' );
}
add_action('admin_head','nickel_admin_css');

function nickel_getTextBetweenTags($string, $tagname) {
    $pattern = "/<$tagname>([\w\W]*?)<\/$tagname>/";
    preg_match($pattern, $string, $matches);
    if ( isset($matches[1]) ) {
    	return $matches[1];
    } else {
    	return '';
    }
}

function nickel_tag_list( $post_id, $return = false ) {
	$entry_utility = '';
	$posttags = get_the_tags( $post_id );
	if ( $posttags ) {
		$entry_utility .= '
		<div class="tag-link">
			<span class="icon-tags"></span>';
				foreach( $posttags as $tag ) {
					$entry_utility .= $tag->name . ' '; 
				}
			$entry_utility .= '
		</div>';
	}

	if ( $return ) {
		return $entry_utility;
	} else {
		echo $entry_utility;
	}
}

function nickel_get_pagination( $post_count ) {
	$pagination = '';
	for ($i=0; $i < $post_count; $i++) {
		$extra = '';
		if ( $i == 0 ) {
			$extra = ' active';
		}
		$pagination .= '<a href="javascript:void(0)" class="post-pagination-item' . $extra . '"></a>';
	}

	return $pagination;
}

function nickel_category_list( $post_id, $return = false ) {
	$category_list = get_the_category_list( '', '', $post_id );
	$entry_utility = '';
	if ( $category_list ) {
		$entry_utility .= '
		<span class="post-category">
			in: ' . $category_list . '
		</span>';
	}

	if ( $return ) {
		return $category_list;
	} else {
		echo $category_list;
	}
}

function nickel_post_category_list( $post_id, $return = false ) {
	$category_list = get_the_category_list( ', ', '', $post_id );
	$entry_utility = '';
	if ( $category_list ) {
		$entry_utility .= '
		<span class="entry-content-category icon-folder-open-empty">
			' . $category_list . '
		</span>';
	}

	if ( $return ) {
		return $entry_utility;
	} else {
		echo $entry_utility;
	}
}

function nickel_post_tag_list( $post_id, $return = false ) {
	$entry_utility = '';
	$posttags = get_the_tags( $post_id );
	if ( $posttags ) {
		$entry_utility .= '<span class="entry-content-tags icon-tags">';
			foreach( $posttags as $tag ) {

				$entry_utility .= '<a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a>, '; 
			}
			$entry_utility = rtrim( $entry_utility, ', ');
		$entry_utility .= '</span>';
	}

	if ( $return ) {
		return $entry_utility;
	} else {
		echo $entry_utility;
	}
}

function nickel_comment_count( $post_id ) {
	$comments = wp_count_comments($post_id); 
	return $comments->approved;
}

/**
 * Register one Nickel 1.0 widget area.
 *
 * @since Nickel 1.0
 *
 * @return void
 */
function vh_widgets_init() {

	register_sidebar(array(
		'name' => __('Footer Area One', 'nickel'),
		'id' => 'sidebar-1',
		'description' => __('', 'nickel'),
		'before_widget' => '<div id="%1$s" class="widget %2$s row-fluid">',
		'after_widget' => '<div class="clearfix"></div></div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => __('Footer Area Two', 'nickel'),
		'id' => 'sidebar-2',
		'description' => __('', 'nickel'),
		'before_widget' => '<div id="%1$s" class="widget %2$s row-fluid">',
		'after_widget' => '<div class="clearfix"></div></div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => __('Footer Area Three', 'nickel'),
		'id' => 'sidebar-3',
		'description' => __('', 'nickel'),
		'before_widget' => '<div id="%1$s" class="widget %2$s row-fluid">',
		'after_widget' => '<div class="clearfix"></div></div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => __('Footer Area Four', 'nickel'),
		'id' => 'sidebar-4',
		'description' => __('', 'nickel'),
		'before_widget' => '<div id="%1$s" class="widget %2$s row-fluid">',
		'after_widget' => '<div class="clearfix"></div></div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => __('Post sidebar', 'nickel'),
		'id' => 'sidebar-5',
		'description' => __('', 'nickel'),
		'before_widget' => '<div id="%1$s" class="widget %2$s row-fluid">',
		'after_widget' => '<div class="clearfix"></div></div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => __('Page sidebar', 'nickel'),
		'id' => 'sidebar-6',
		'description' => __('', 'nickel'),
		'before_widget' => '<div id="%1$s" class="widget %2$s row-fluid">',
		'after_widget' => '<div class="clearfix"></div></div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));

}
add_action('widgets_init', 'vh_widgets_init');

/**
 * Custom template tags for nickel 1.0
 *
 * @package WordPress
 * @subpackage nickel
 * @since nickel 1.0
 */

if ( ! function_exists( 'nickel_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since nickel 1.0
 *
 * @return void
 */
function nickel_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => '',
		'next_text' => '',
	) );

	if ( $links ) :

	?>
	<div class="clearfix"></div>
	<nav class="navigation paging-navigation" role="navigation">
		<div class="pagination loop-pagination">
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;

/**
 * Adjust content_width value for image attachment template.
 *
 * @since Nickel 1.0
 *
 * @return void
 */
function nickel_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'nickel_content_width' );

/**
 * Register Lato Google font for Nickel 1.0.
 *
 * @since Nickel 1.0
 *
 * @return string
 */
function nickel_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	$font_url = add_query_arg( 'family', urlencode( 'Domine:100,300,400' ), "//fonts.googleapis.com/css" );

	return $font_url;
}

function nickel_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'nickel_excerpt_length', 999 );

function nickel_excerpt_more( $more ) {
	return '..';
}
add_filter('excerpt_more', 'nickel_excerpt_more');

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Nickel 1.0
 *
 * @return void
 */
function nickel_scripts() {

	if ( get_theme_mod('nickel_gmap_key', '') ) {
		wp_enqueue_script('googlemap', '//maps.googleapis.com/maps/api/js?sensor=false&key='.get_theme_mod('nickel_gmap_key', ''), array(), '3', false);
	}

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array() );

	// Add Google fonts
	wp_register_style('googleFonts', '//fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,500,600,700|Roboto:100,300,400,500,600,700|Open+Sans:100,300,400,500,600,700|Oswald:100,300,400,500,600,700|Satisfy:100,300,400,500,600,700&subset=latin');
	wp_enqueue_style( 'googleFonts');

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'nickel-style', get_stylesheet_uri(), array( 'genericons' ) );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'nickel-ie', get_template_directory_uri() . '/css/ie.css', array( 'nickel-style', 'genericons' ), '20131205' );
	wp_style_add_data( 'nickel-ie', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'comment-reply' );

	wp_enqueue_script( 'nickel-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20131209', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '20131209', true );

	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css', array() );

	wp_enqueue_script( 'jquery-ui-draggable' );

	wp_enqueue_script( 'jquery.bxslider', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'jquery.jcarousel', get_template_directory_uri() . '/js/jquery.jcarousel.pack.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'jquery.isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'jquery' ), '', true );

	// Add html5
	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5.js' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'nickel_scripts' );

// Admin Javascript
add_action( 'admin_enqueue_scripts', 'nickel_admin_scripts' );
function nickel_admin_scripts() {
	wp_register_script('master', get_template_directory_uri() . '/inc/js/admin-master.js', array('jquery'));
	wp_enqueue_script('master');
}

if ( ! function_exists( 'nickel_the_attached_image' ) ) :
	/**
	 * Print the attached image with a link to the next attached image.
	 *
	 * @since Nickel 1.0
	 *
	 * @return void
	 */
	function nickel_the_attached_image() {
		$post                = get_post();
		/**
		 * Filter the default Nickel 1.0 attachment size.
		 *
		 * @since Nickel 1.0
		 *
		 * @param array $dimensions {
		 *     An array of height and width dimensions.
		 *
		 *     @type int $height Height of the image in pixels. Default 810.
		 *     @type int $width  Width of the image in pixels. Default 810.
		 * }
		 */
		$attachment_size     = apply_filters( 'nickel_attachment_size', array( 810, 810 ) );
		$next_attachment_url = wp_get_attachment_url();

		/*
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => -1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID',
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id ) {
				$next_attachment_url = get_attachment_link( $next_id );
			}

			// or get the URL of the first image attachment.
			else {
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
			}
		}

		printf( '<a href="%1$s" rel="attachment">%2$s</a>',
			esc_url( $next_attachment_url ),
			wp_get_attachment_image( $post->ID, $attachment_size )
		);
	}
endif;

function nickel_prev_next_links() {
	$output = '<nav class="nav-single blog vc_col-sm-12">';
		$prev_post = get_previous_post();
		$next_post = get_next_post();

		if (!empty( $prev_post )) {
			$img = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_post->ID ), 'nickel-horizontal-thumb' );
			$output .= '
			<div class="nav_button left">
				<h4 class="prev-post-text">'. __('Previous story', 'nickel').'</h4>';
				if ( !empty($img) ) {
					$output .= '<img src="'.$img['0'].'" class="prev-post-img" alt="Post with image">';
				}
				$output .= '<div class="prev-post-link">
					<a href="'. get_permalink( $prev_post->ID ).'" class="prev-blog-post">'.get_the_title( $prev_post->ID ).'</a>
					<div class="prev-post-meta">' . nickel_category_list( $prev_post->ID, true ) . '<span class="prev-date icon-clock">' . human_time_diff(get_the_time('U',$prev_post->ID),current_time('timestamp')) .  ' '.__('ago', 'nickel') . '</span></div>
				</div>
			</div>';
		}

		if (!empty( $next_post )) {
			$img = wp_get_attachment_image_src( get_post_thumbnail_id( $next_post->ID ), 'nickel-horizontal-thumb' );
			$output .= '
			<div class="nav_button right">
				<h4 class="next-post-text">'.__('Next story', 'nickel').'</h4>';
				if ( !empty($img) ) {
					$output .= '<img src="'.$img['0'].'" class="next-post-img" alt="Post with image">';
				}
				$output .= '<div class="next-post-link">
					<a href="'. get_permalink( $next_post->ID ).'" class="next-blog-post">'. get_the_title( $next_post->ID ).'</a>
					<div class="next-post-meta">' . nickel_category_list( $next_post->ID, true ) . '<span class="next-date icon-clock">' . human_time_diff(get_the_time('U',$next_post->ID),current_time('timestamp')) .  ' '.__('ago', 'nickel') . '</span></div>
				</div>
			</div>';
		}
		$output .= '
		<div class="clearfix"></div>
	</nav>';

	echo $output;
}

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image.
 * 3. Index views.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since Nickel 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function nickel_body_classes( $classes ) {
	global $post;

	if ( ( is_single() || is_page() ) && has_shortcode( get_post_field( 'post_content', get_the_ID() ), 'nickel_main_slider' ) ) {
		$classes[] = 'nickel-slider-active';
	}

	$classes[] = MAGAZINE_LAYOUT;

	return $classes;
}
add_filter( 'body_class', 'nickel_body_classes' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Nickel 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function nickel_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'nickel' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'nickel_wp_title', 10, 2 );

/**
 * Create HTML list of nav menu items.
 * Replacement for the native Walker, using the description.
 *
 * @see    http://wordpress.stackexchange.com/q/14037/
 * @author toscho, http://toscho.de
 */
class Nickel_Header_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$classes         = empty ( $item->classes ) ? array () : (array) $item->classes;
		$has_description = '';

		$class_names = join(
			' '
		,   apply_filters(
				'nav_menu_css_class'
			,   array_filter( $classes ), $item
			)
		);

		// insert description for top level elements only
		// you may change this
		$description = ( ! empty ( $item->description ) )
			? '<small>' . esc_attr( $item->description ) . '</small>' : '';

		$has_description = ( ! empty ( $item->description ) )
			? 'has-description ' : '';

		! empty ( $class_names )
			and $class_names = ' class="' . $has_description . esc_attr( $class_names ) . ' depth-' . $depth . '"';

		$output .= "<li id='menu-item-$item->ID' $class_names>";

		$attributes  = '';

		if ( !isset($item->target) ) {
			$item->target = '';
		}

		if ( !isset($item->attr_title) ) {
			$item->attr_title = '';
		}

		if ( !isset($item->xfn) ) {
			$item->xfn = '';
		}

		if ( !isset($item->url) ) {
			$item->url = '';
		}

		if ( !isset($item->title) ) {
			$item->title = '';
		}

		if ( !isset($item->ID) ) {
			$item->ID = '';
		}

		if ( !isset($args->link_before) ) {
			$args = new stdClass();
			$args->link_before = '';
		}

		if ( !isset($args->before) ) {
			$args->before = '';
		}

		if ( !isset($args->link_after) ) {
			$args->link_after = '';
		}

		if ( !isset($args->after) ) {
			$args->after = '';
		}

		! empty( $item->attr_title )
			and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';
		! empty( $item->target )
			and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';
		! empty( $item->xfn )
			and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';
		! empty( $item->url )
			and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

		$title = apply_filters( 'the_title', $item->title, $item->ID );

		if ( $item->type == 'taxonomy' ) {
			$item_output = $args->before
				. "<a $attributes>"
				. $args->link_before
				. $title
				. $description
				. '</a> '
				. nickel_get_menu_category( $item->object_id )
				. $args->link_after
				. $args->after;
		} else {
			$item_output = $args->before
				. "<a $attributes>"
				. $args->link_before
				. $title
				. $description
				. '</a> '
				. $args->link_after
				. $args->after;
		}

		// Since $output is called by reference we don't need to return anything.
		$output .= apply_filters(
			'walker_nav_menu_start_el'
		,   $item_output
		,   $item
		,   $depth
		,   $args
		);
	}
}

function nickel_get_menu_category( $category_id ) {
	query_posts(array(
		'post_type' => 'post',
		'posts_per_page' => '4',
		'cat' => $category_id

	));

	if ( !have_posts() ) {
		wp_reset_query();
		wp_reset_postdata();
		return;
	}

	$output = '<div class="menu-category-container">';

	while(have_posts()) {
		the_post();

		$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'nickel-small-thumb');

		$output .= '<div class="menu-category-item">';
			if ( !empty($img['0']) ) {
				$output .= '<a href="'.get_the_permalink( get_the_ID() ).'" class="category-img-link"><img src="' . $img['0'] . '" class="menu-post-img"></a>';
			}
			$output .= '<span class="menu-post-date">' . get_the_date( get_option( 'date_format' ), get_the_ID() ) . '</span>';
			$output .= '<a href="#" class="menu-post-title">' . get_the_title() . '</a>';
		$output .= '</div>';
	}

	$output .= '</div>';

	wp_reset_query();
	wp_reset_postdata();

	return $output;
}

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Add Theme Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

function get_depth($postid) {
	$depth = ($postid==get_option('page_on_front')) ? -1 : 0;
	while ($postid > 0) {
	$postid = get_post_ancestors($postid);
	$postid = $postid[0];
	$depth++;
	}
	return $depth;
}

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function vh_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'     				=> 'Bootstrap 3 Shortcodes', // The plugin name
			'slug'     				=> 'bootstrap-3-shortcodes', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '3.3.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Contact Form 7', // The plugin name
			'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '4.4.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Functionality for Nickel theme', // The plugin name
			'slug'     				=> 'functionality-for-nickel-theme', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		)
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'nickel',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'nickel' ),
			'menu_title'                       			=> __( 'Install Plugins', 'nickel' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'nickel' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'nickel' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'nickel' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'nickel' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'nickel' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'nickel' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'nickel' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'nickel' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'nickel' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'nickel' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'nickel' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'nickel' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'nickel' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'nickel' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'nickel' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'vh_register_required_plugins' );

function nickel_allowed_tags() {
	global $allowedposttags;
	$allowedposttags['script'] = array(
		'type' => true,
		'src' => true
	);
}
add_action( 'init', 'nickel_allowed_tags' );