<?php
/**
 * The Template for displaying product archives, including the main shop page.
 * Overrides WooCommerce's default archive to use our luxury layout.
 *
 * @package TFG
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 * Outputs our wrapper (tfg-archive > container) via inc/woocommerce.php.
 */
do_action( 'woocommerce_before_main_content' );

?>

<header class="tfg-archive__header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<?php
		// Refined title — strip "Products" generic and use category name if available.
		$title = woocommerce_page_title( false );
		$term  = is_product_category() ? get_queried_object() : null;
		if ( $term && $term->name ) $title = $term->name;
		?>
		<span class="eyebrow" style="display:inline-flex;margin-bottom:1rem;"><?php esc_html_e( 'Listings', 'tfg' ); ?></span>
		<h1><?php echo esc_html( $title ); ?></h1>
	<?php endif; ?>

	<?php
	// Category description.
	if ( is_product_category() ) {
		$desc = term_description();
		if ( $desc ) echo '<p class="lead">' . wp_kses_post( $desc ) . '</p>';
	}
	?>
</header>

<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 * Renders our refined toolbar (count + sort) via inc/woocommerce.php.
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();
			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );
			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 */
	do_action( 'woocommerce_after_shop_loop' );

} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 */
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
