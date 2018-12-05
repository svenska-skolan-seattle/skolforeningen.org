<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function svenskaskolaniseattle_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/svenskaskolaniseattle
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'svenskaskolaniseattle' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'svenskaskolaniseattle' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'svenskaskolaniseattle-featured-image', 2000, 1200, true );

	add_image_size( 'svenskaskolaniseattle-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus(
		array(
			'top'    => __( 'Top Menu', 'svenskaskolaniseattle' )
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support(
		'post-formats', array(
			'aside',
			'image',
			'quote',
			'link',
			'gallery',
		)
	);

	// Add theme support for Custom Logo.
	add_theme_support(
		'custom-logo', array(
			'width'      => 250,
			'height'     => 250,
			'flex-width' => true,
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'svenskaskolaniseattle_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function svenskaskolaniseattle_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( svenskaskolaniseattle_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'svenskaskolaniseattle_content_width', $content_width );
}
add_action( 'template_redirect', 'svenskaskolaniseattle_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function svenskaskolaniseattle_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'svenskaskolaniseattle' ),
			'id'            => 'sidebar',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'svenskaskolaniseattle' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Site Info', 'svenskaskolaniseattle' ),
			'id'            => 'site-info',
			'description'   => __( 'Add widgets here to appear in your footer.', 'svenskaskolaniseattle' )
		)
	);
}
add_action( 'widgets_init', 'svenskaskolaniseattle_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function svenskaskolaniseattle_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf(
		'<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'svenskaskolaniseattle' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'svenskaskolaniseattle_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function svenskaskolaniseattle_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'svenskaskolaniseattle_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function svenskaskolaniseattle_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'svenskaskolaniseattle_pingback_header' );

// add_action( 'wp_head', 'svenskaskolaniseattlen_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function svenskaskolaniseattle_scripts() {
	// Add custom fonts, used in the main stylesheet.
	// wp_enqueue_style( 'svenskaskolaniseattle-fonts', svenskaskolaniseattle_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'svenskaskolaniseattle-style', get_stylesheet_uri() );

	// Load the dark colorscheme.
	// if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
	// 	wp_enqueue_style( 'svenskaskolaniseattle-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'svenskaskolaniseattle-style' ), '1.0' );
	// }

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	// if ( is_customize_preview() ) {
	// 	wp_enqueue_style( 'svenskaskolaniseattle-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'svenskaskolaniseattle-style' ), '1.0' );
	// 	wp_style_add_data( 'svenskaskolaniseattle-ie9', 'conditional', 'IE 9' );
	// }

	// // Load the Internet Explorer 8 specific stylesheet.
	// wp_enqueue_style( 'svenskaskolaniseattle-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'svenskaskolaniseattle-style' ), '1.0' );
	// wp_style_add_data( 'svenskaskolaniseattle-ie8', 'conditional', 'lt IE 9' );

	// // Load the html5 shiv.
	// wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	// wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	// wp_enqueue_script( 'svenskaskolaniseattle-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	// $svenskaskolaniseattle_l10n = array(
	// 	'quote' => svenskaskolaniseattle_get_svg( array( 'icon' => 'quote-right' ) ),
	// );

	// if ( has_nav_menu( 'top' ) ) {
	// 	wp_enqueue_script( 'svenskaskolaniseattle-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '1.0', true );
	// 	$svenskaskolaniseattle_l10n['expand']   = __( 'Expand child menu', 'svenskaskolaniseattle' );
	// 	$svenskaskolaniseattle_l10n['collapse'] = __( 'Collapse child menu', 'svenskaskolaniseattle' );
	// 	$svenskaskolaniseattle_l10n['icon']     = svenskaskolaniseattle_get_svg(
	// 		array(
	// 			'icon'     => 'angle-down',
	// 			'fallback' => true,
	// 		)
	// 	);
	// }

	// wp_enqueue_script( 'svenskaskolaniseattle-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	// wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	// wp_localize_script( 'svenskaskolaniseattle-skip-link-focus-fix', 'svenskaskolaniseattleScreenReaderText', $svenskaskolaniseattle_l10n );

	// if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	// 	wp_enqueue_script( 'comment-reply' );
	// }
}
add_action( 'wp_enqueue_scripts', 'svenskaskolaniseattle_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function svenskaskolaniseattle_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			$sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'svenskaskolaniseattle_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function svenskaskolaniseattle_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'svenskaskolaniseattle_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function svenskaskolaniseattle_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'svenskaskolaniseattle_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function svenskaskolaniseattle_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template', 'svenskaskolaniseattle_front_page_template' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );
