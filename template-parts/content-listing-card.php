<?php
/**
 * Listing card — used in home trending rail + WooCommerce archive grid.
 * Renders a single product as a luxury catalog card.
 *
 * @package TFG
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $product;
if ( ! $product ) {
	$product = wc_get_product( get_the_ID() );
}
if ( ! $product ) return;

$cats = wp_get_post_terms( $product->get_id(), 'product_cat' );
$cat_name = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : '';

// Build a specs line from product attributes.
$spec_line = array();
$attrs = $product->get_attributes();
foreach ( $attrs as $attr ) {
	if ( $attr instanceof WC_Product_Attribute ) {
		$name = wc_attribute_label( $attr->get_name() );
		$val  = $product->get_attribute( $attr->get_name() );
		if ( $val ) $spec_line[] = $val;
	}
}
?>
<a href="<?php the_permalink(); ?>" class="tfg-listing-card" data-magnetic>
	<div class="tfg-listing-card__media">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'tfg-listing', array( 'class' => 'tfg-listing-card__img', 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<div class="tfg-listing-card__placeholder"><?php esc_html_e( 'Image coming soon', 'tfg' ); ?></div>
		<?php endif; ?>
		<?php if ( $product->is_on_sale() ) : ?>
			<span class="tfg-listing-card__badge"><?php esc_html_e( 'Reduced', 'tfg' ); ?></span>
		<?php endif; ?>
	</div>
	<div class="tfg-listing-card__body">
		<div class="tfg-listing-card__meta">
			<?php if ( $cat_name ) : ?><span class="tfg-listing-card__cat eyebrow eyebrow--bare"><?php echo esc_html( $cat_name ); ?></span><?php endif; ?>
		</div>
		<h3 class="tfg-listing-card__title"><?php the_title(); ?></h3>
		<?php if ( $spec_line ) : ?>
			<div class="tfg-listing-card__specs"><?php echo esc_html( implode( ' · ', array_slice( $spec_line, 0, 3 ) ) ); ?></div>
		<?php endif; ?>
		<div class="tfg-listing-card__price"><?php echo tfg_price( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<span class="tfg-listing-card__cta"><?php esc_html_e( 'View', 'tfg' ); ?> <span aria-hidden="true">→</span></span>
	</div>
</a>
