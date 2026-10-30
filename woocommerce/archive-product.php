<?php
/**
 * The Template for displaying product archives — luxury brochure edition.
 * Category pages open with a cinematic full-bleed hero band, then present
 * listings as a refined catalog (large editorial cards, hairline rules).
 *
 * @package TFG
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header( 'shop' );

// Resolve the category (or shop) title + hero image.
$term       = is_product_category() ? get_queried_object() : null;
$title      = $term && $term->name ? $term->name : woocommerce_page_title( false );
$hero_img   = '';
$hero_copy  = array(
	'yachts'           => __( 'New and brokerage superyachts from the finest shipyards — privately held, privately traded.', 'tfg' ),
	'real-estate'      => __( 'Residential, commercial and hospitality assets across premier markets — many never publicly listed.', 'tfg' ),
	'aircraft'         => __( 'Private jets and turboprops with discreet, end-to-end transaction management.', 'tfg' ),
	'armored-vehicles' => __( 'OEM-grade ballistic protection integrated into the finest vehicles on the road.', 'tfg' ),
);

if ( $term ) {
	$cats = tfg_asset_categories();
	if ( isset( $cats[ $term->slug ] ) ) {
		$hero_img = TFG_URI . '/assets/img/category-' . str_replace( 'armored-vehicles', 'armored', $term->slug ) . '.jpg';
	}
	// Category thumbnail (uploaded in WP) takes precedence.
	$thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
	if ( $thumb_id ) {
		$src = wp_get_attachment_image_src( $thumb_id, 'tfg-hero' );
		if ( $src ) $hero_img = $src[0];
	}
}
?>

<?php if ( $hero_img ) : ?>
<!-- Cinematic category hero -->
<div class="tfg-band tfg-band--center tfg-cat-hero">
	<div class="tfg-band__media">
		<img src="<?php echo esc_url( $hero_img ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="eager">
	</div>
	<div class="tfg-band__overlay" aria-hidden="true"></div>
	<div class="tfg-band__inner">
		<span class="eyebrow tfg-band__eyebrow eyebrow--bare" style="justify-content:center;display:flex;"><?php esc_html_e( 'The Collection', 'tfg' ); ?></span>
		<h1 class="tfg-band__title" style="font-size:clamp(2.75rem,7vw,6.5rem);"><?php echo esc_html( $title ); ?></h1>
		<?php if ( $term && isset( $hero_copy[ $term->slug ] ) ) : ?>
			<p class="tfg-band__sub" data-reveal><?php echo esc_html( $hero_copy[ $term->slug ] ); ?></p>
		<?php elseif ( $term ) : ?>
			<?php $desc = term_description(); if ( $desc ) : ?>
				<p class="tfg-band__sub"><?php echo wp_kses_post( $desc ); ?></p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>

<?php
/**
 * Hook: woocommerce_before_main_content.
 * Outputs our wrapper (tfg-archive > container) via inc/woocommerce.php.
 */
do_action( 'woocommerce_before_main_content' );
?>

<header class="tfg-archive__header"<?php echo $hero_img ? ' style="padding-top:clamp(2.5rem,6vh,4rem);"' : ''; ?>>
	<span class="eyebrow" style="display:inline-flex;margin-bottom:1rem;"><?php esc_html_e( 'Listings', 'tfg' ); ?></span>
	<?php if ( ! $hero_img ) : ?>
		<h1><?php echo esc_html( $title ); ?></h1>
	<?php else : ?>
		<h2 class="tfg-archive__title"><?php esc_html_e( 'Available Now', 'tfg' ); ?></h2>
	<?php endif; ?>
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
