<?php
/**
 * Theme setup — supports, image sizes, menus.
 *
 * @package TFG
 */

if ( ! function_exists( 'tfg_setup' ) ) {
	function tfg_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'tfg', TFG_DIR . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

		// Custom logo — wide lockup.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 40,
				'width'       => 190,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		// Editor styles for consistent block editor typography.
		add_editor_style( 'assets/css/editor.css' );

		// Image sizes tuned to the component kit.
		add_image_size( 'tfg-hero', 2560, 1440, true );
		add_image_size( 'tfg-card', 800, 1000, true );   // 4:5 category / team
		add_image_size( 'tfg-listing', 800, 500, true ); // 16:10 listing
		add_image_size( 'tfg-wide', 1600, 900, true );
		add_image_size( 'tfg-thumb', 200, 130, true );

		// Menus.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Navigation', 'tfg' ),
				'footer'  => __( 'Footer Navigation', 'tfg' ),
				'mobile'  => __( 'Mobile Navigation', 'tfg' ),
			)
		);
	}
}
add_action( 'after_setup_theme', 'tfg_setup' );

/**
 * Content width.
 */
function tfg_content_width() {
	$GLOBALS['content_width'] = 1440;
}
add_action( 'after_setup_theme', 'tfg_content_width', 0 );

/**
 * Register widget areas (used by footer columns + sidebar).
 */
function tfg_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer Column 1 — Explore', 'tfg' ),
			'id'            => 'footer-1',
			'before_widget' => '<div class="footer-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="footer-widget__title">',
			'after_title'   => '</h4>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer Column 2 — Company', 'tfg' ),
			'id'            => 'footer-2',
			'before_widget' => '<div class="footer-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="footer-widget__title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'tfg_widgets_init' );

/**
 * Body classes.
 */
function tfg_body_class( $classes ) {
	$classes[] = 'tfg';
	// Detect preferred theme on server so first paint matches (no FOUC).
	$pref = isset( $_COOKIE['tfg-theme'] ) ? sanitize_key( $_COOKIE['tfg-theme'] ) : '';
	if ( '' === $pref ) {
		// Default to dark; respect prefers-color-scheme via JS on first visit if no cookie.
		$classes[] = 'theme-dark';
	} else {
		$classes[] = 'theme-' . $pref;
	}
	return $classes;
}
add_filter( 'body_class', 'tfg_body_class' );
