<?php
/**
 * Kebo functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kebo
 */

define( 'KEBO_VERSION', '1.0.1' );

/**
 * Theme Setup Function
 */
function kebo_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'kebo' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);
}
add_action( 'after_setup_theme', 'kebo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kebo_content_width() {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'kebo_content_width', 1200 );
}
add_action( 'after_setup_theme', 'kebo_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kebo_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'kebo' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'kebo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'kebo_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function kebo_scripts() {
	wp_enqueue_style( 'kebo-style', get_stylesheet_uri(), array(), KEBO_VERSION );
	wp_enqueue_script( 'kebo-script', get_template_directory_uri() . '/assets/js/theme.js', array(), KEBO_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'kebo_scripts' );

/**
 * Add Read More link to end of excerpt.
 *
 * @param string $excerpt Contains the post excerpt.
 */
function the_excerpt_more_link( $excerpt ) {
	global $post;
	$excerpt .= '<a href="' . esc_url( get_permalink( $post->ID ) ) . '" title="' . esc_attr( $post->post_title ) . '">Read More</a>';
	return $excerpt;
}
add_filter( 'the_excerpt', 'the_excerpt_more_link', 21 );

/**
 * Prevent Excerpt More from adding links.
 *
 * @param string $more Contains extra to be added to excerpt.
 */
function new_excerpt_more( $more ) {
	return '';
}
add_filter( 'excerpt_more', 'new_excerpt_more', 21 );

/**
 * Death to Emojii
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * Death to Embeds
 */
remove_action( 'rest_api_init', 'wp_oembed_register_route' );
add_filter( 'embed_oembed_discover', '__return_false' );
remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );

/**
 * Gutenberg
 */
function dequeue_assets() {
	wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'dequeue_assets', 99 );
