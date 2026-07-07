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
	// 3. Components.
	wp_enqueue_style( 'tfg-components', TFG_URI . '/assets/css/components.css', array( 'tfg-base' ), $ver );
	// 4. Layouts / pages.
	wp_enqueue_style( 'tfg-layout', TFG_URI . '/assets/css/layout.css', array( 'tfg-components' ), $ver );
	// 5. WooCommerce overrides.
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'tfg-woo', TFG_URI . '/assets/css/woocommerce.css', array( 'tfg-layout' ), $ver );
	}
	// 6. Forminator overrides (loaded late so they win specificity).
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

	// GSAP core + ScrollTrigger (CDN, deferred).
	wp_enqueue_script( 'gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js', array(), $ver, true );
	wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js', array( 'gsap' ), $ver, true );

	// Lenis smooth scroll.
	wp_enqueue_script( 'lenis', 'https://cdn.jsdelivr.net/npm/lenis@1.1.13/dist/lenis.min.js', array(), $ver, true );

	// SplitText is a GSAP bonus plugin; use the public-splitText fallback (class-based) in main.js.
	// Our main script splits via a small inline helper rather than the paid SplitText.

	wp_enqueue_script( 'tfg-main', TFG_URI . '/assets/js/main.js', array( 'gsap', 'lenis' ), $ver, true );

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
 * Dequeue plugins' default styles that conflict with our restyle.
 * Forminator CSS is heavy; we keep its grid but override visuals.
 */
function tfg_dequeue_styles() {
	// Elementor front-end is not used; remove if a previous install left it active.
	if ( class_exists( '\Elementor\Plugin' ) ) {
		wp_dequeue_style( 'elementor-frontend' );
		wp_dequeue_style( 'elementor-post-1' );
	}
}
add_action( 'wp_enqueue_scripts', 'tfg_dequeue_styles', 100 );

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
