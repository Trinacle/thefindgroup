<?php
/**
 * Asset enqueuing — fonts, stylesheets, scripts.
 *
 * @package TFG
 */

/**
 * Google Fonts: Cormorant Garamond (display) + Inter (body/UI).
 */
function tfg_fonts() {
	$families = array(
		'Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500',
		'Inter:wght@400;500;600;700',
	);
	$src = 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', $families ) . '&display=swap';

	wp_enqueue_style( 'tfg-fonts', $src, array(), null );
}
add_action( 'wp_enqueue_scripts', 'tfg_fonts' );

/**
 * Preconnects for fonts.
 */
function tfg_resource_hints( $hints, $relation ) {
	if ( 'preconnect' === $relation ) {
		$hints[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		$hints[] = array( 'href' => 'https://fonts.googleapis.com' );
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'tfg_resource_hints', 10, 2 );

/**
 * Stylesheets.
 */
function tfg_styles() {
	$ver = TFG_VERSION;

	// 1. Design tokens (CSS variables, light/dark themes).
	wp_enqueue_style( 'tfg-tokens', TFG_URI . '/assets/css/tokens.css', array(), $ver );
	// 2. Base / typography.
	wp_enqueue_style( 'tfg-base', TFG_URI . '/assets/css/base.css', array( 'tfg-tokens' ), $ver );
	// 3. Cinema system (scroll-snap scenes, reveals, count-up, parallax).
	wp_enqueue_style( 'tfg-cinema', TFG_URI . '/assets/css/cinema.css', array( 'tfg-base' ), $ver );
	// 4. Components.
	wp_enqueue_style( 'tfg-components', TFG_URI . '/assets/css/components.css', array( 'tfg-cinema' ), $ver );
	// 5. Layouts / pages.
	wp_enqueue_style( 'tfg-layout', TFG_URI . '/assets/css/layout.css', array( 'tfg-components' ), $ver );
	// 6. WooCommerce overrides.
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'tfg-woo', TFG_URI . '/assets/css/woocommerce.css', array( 'tfg-layout' ), $ver );
	}
	// 7. Forminator overrides (loaded late so they win specificity).
	if ( class_exists( 'Forminator_API' ) ) {
		wp_enqueue_style( 'tfg-forminator', TFG_URI . '/assets/css/forminator.css', array(), $ver );
	}
}
add_action( 'wp_enqueue_scripts', 'tfg_styles' );

/**
 * Scripts.
 */
function tfg_scripts() {
	$ver = TFG_VERSION;

	// Cinema engine: reveals, count-up, parallax, scroll progress.
	wp_enqueue_script( 'tfg-cinema', TFG_URI . '/assets/js/cinema.js', array(), $ver, true );
	// Main theme script (UI: toggle, nav, search, newsletter, form, chat).
	wp_enqueue_script( 'tfg-main', TFG_URI . '/assets/js/main.js', array(), $ver, true );

	// Pass server-side data to JS.
	wp_localize_script(
		'tfg-main',
		'TFG',
		array(
			'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
			'nonce'     => wp_create_nonce( 'tfg-nonce' ),
			'phone'     => get_theme_mod( 'tfg_phone', '(949) 229-1733' ),
			'liveChat'  => get_theme_mod( 'tfg_livechat_snippet', '' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'tfg_scripts' );

/**
 * Strip page-builder assets that fight our bespoke theme.
 * Elementor + Ultimate Elementor (UAEL) + Astra enqueue ~26 CSS/JS files
 * AFTER our stylesheet, overriding fonts, colors, and spacing.
 * This is the #1 cause of "the design looks wrong."
 * Per the wordpress-theme-development skill: killlist on every page load.
 */
function tfg_dequeue_builder_assets() {
	// CSS killlist — page builder + framework styles we don't use.
	$css_kill = array(
		// Elementor core.
		'elementor-frontend',
		'elementor-post-1',
		'elementor-post',
		'elementor-pro',
		'elementor-icons',
		'elementor-common',
		// Ultimate Addons for Elementor (UAEL).
		'uael-frontend',
		'uael-woocommerce',
		// Swiper / Slick (Elementor carousels — we have our own).
		'swiper',
		'e-swiper',
		'slick',
		// Astra theme + addon (if parent theme is active).
		'astra-theme-css',
		'astra-addon-css',
		'astra-woocommerce-css',
		// Font Awesome (Elementor's version — we use inline SVG).
		'elementor-icons-fa-solid',
		'elementor-icons-fa-brands',
		'elementor-icons-fa-regular',
		'font-awesome',
		'font-awesome-5-all',
		'font-awesome-4-shim',
		// Slider Revolution.
		'rs-plugin-settings',
		'rs-icon-set-fa-icon-merged',
		// Other bloat.
		'google-fonts-1',
		'elementor-globe',
		'elementor-post-pro-css',
	);
	foreach ( $css_kill as $handle ) {
		wp_dequeue_style( $handle );
		wp_deregister_style( $handle );
	}

	// JS killlist — page builder scripts.
	$js_kill = array(
		'elementor-frontend',
		'elementor-frontend-modules',
		'elementor-frontend-script',
		'elementor-webpack-runtime',
		'uael-frontend',
		'uael-woocommerce',
		'uael-particles',
		'swiper',
		'e-swiper',
		'slick',
		'particles',
		'elementor-pro-frontend',
		'rs-plugin-main',
	);
	foreach ( $js_kill as $handle ) {
		wp_dequeue_script( $handle );
		wp_deregister_script( $handle );
	}
}
add_action( 'wp_enqueue_scripts', 'tfg_dequeue_builder_assets', 100 );

/**
 * Also strip Elementor's body classes and meta tags for a clean DOM.
 */
function tfg_clean_body_classes( $classes ) {
	$remove = array( 'elementor-default', 'elementor-kit', 'elementor-page', 'elementor-page-' );
	foreach ( $classes as $i => $c ) {
		foreach ( $remove as $r ) {
			if ( strpos( $c, $r ) !== false ) {
				unset( $classes[ $i ] );
				break;
			}
		}
	}
	return $classes;
}
add_filter( 'body_class', 'tfg_clean_body_classes', 20 );

/**
 * Inline critical-path CSS to prevent dark/light flash on first paint.
 */
function tfg_no_fouc_script() {
	?>
	<script>
	(function() {
		try {
			var p = localStorage.getItem('tfg-theme');
			if (!p) {
				p = window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
			}
			document.documentElement.setAttribute('data-theme', p);
		} catch (e) {
			document.documentElement.setAttribute('data-theme', 'dark');
		}
	})();
	</script>
	<?php
}
add_action( 'wp_head', 'tfg_no_fouc_script', 1 );
