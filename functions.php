<?php
/**
 * Events Insider theme bootstrap.
 *
 * @package eventsinsider
 */

defined( 'ABSPATH' ) || exit;

define( 'EI_VERSION', '1.0.0' );
define( 'EI_DIR', get_template_directory() );
define( 'EI_URI', get_template_directory_uri() );

require EI_DIR . '/inc/helpers.php';
require EI_DIR . '/inc/icons.php';
require EI_DIR . '/inc/post-types.php';
require EI_DIR . '/inc/customizer.php';
require EI_DIR . '/inc/template-tags.php';

/**
 * Theme supports, menus and image sizes.
 */
function ei_setup() {
	load_theme_textdomain( 'eventsinsider', EI_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 212,
			'width'       => 420,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// "custom-menu" is the location the previous theme used, so WordPress maps the existing menu over on theme switch.
	register_nav_menus(
		array(
			'custom-menu'  => __( 'Header menu', 'eventsinsider' ),
			'article-tabs' => __( 'Article filter tabs', 'eventsinsider' ),
			'footer-1'     => __( 'Footer column 1', 'eventsinsider' ),
			'footer-2'     => __( 'Footer column 2', 'eventsinsider' ),
		)
	);

	add_image_size( 'ei-card', 768, 520, true );
	add_image_size( 'ei-hero', 1920, 780, true );
	add_image_size( 'ei-side', 640, 530, true );

	add_editor_style( 'assets/css/editor.css' );
}
add_action( 'after_setup_theme', 'ei_setup' );

/**
 * Content width for embeds.
 */
function ei_content_width() {
	$GLOBALS['content_width'] = 760;
}
add_action( 'after_setup_theme', 'ei_content_width', 0 );

/**
 * Front-end assets.
 */
function ei_enqueue_assets() {
	wp_enqueue_style( 'ei-fonts', 'https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap', array(), null );
	wp_enqueue_style( 'ei-main', EI_URI . '/assets/css/main.css', array( 'ei-fonts' ), ei_asset_version( 'assets/css/main.css' ) );
	wp_enqueue_script( 'ei-main', EI_URI . '/assets/js/main.js', array(), ei_asset_version( 'assets/js/main.js' ), array( 'strategy' => 'defer', 'in_footer' => true ) );
	wp_localize_script(
		'ei-main',
		'eiSettings',
		array(
			'popupEnabled' => (bool) get_theme_mod( 'ei_popup_enabled', true ),
			'popupDelay'   => absint( get_theme_mod( 'ei_popup_delay', 12 ) ),
			'popupDays'    => absint( get_theme_mod( 'ei_popup_days', 14 ) ),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// WP-PageNavi ships its own stylesheet; ours replaces it.
	wp_dequeue_style( 'wp-pagenavi' );
}
add_action( 'wp_enqueue_scripts', 'ei_enqueue_assets', 20 );

/**
 * Preconnect to Google Fonts.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array
 */
function ei_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		$urls[] = 'https://fonts.googleapis.com';
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'ei_resource_hints', 10, 2 );

/**
 * Six cards per page in the article grids (2 x 3 like the design), unless the site setting is lower.
 *
 * @param WP_Query $query Main query.
 */
function ei_pre_get_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_home() || $query->is_archive() || $query->is_search() ) {
		$query->set( 'posts_per_page', ei_grid_per_page() );
	}
	if ( $query->is_search() && ! $query->get( 'post_type' ) ) {
		$query->set( 'post_type', array( 'post', 'events' ) );
	}
}
add_action( 'pre_get_posts', 'ei_pre_get_posts' );

/**
 * Shorter excerpts with a plain ellipsis.
 */
add_filter( 'excerpt_length', fn() => 40 );
add_filter( 'excerpt_more', fn() => '&hellip;' );
