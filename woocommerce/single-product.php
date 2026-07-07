<?php
/**
 * The Template for displaying all single products.
 * Overrides WooCommerce's default single-product to use our luxury layout.
 *
 * @package TFG
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header( 'shop' );

while ( have_posts() ) :
	the_post();
	global $product;
	?>

	<div class="tfg-single">
		<div class="container">

			<!-- Breadcrumb (slim) -->
			<nav class="tfg-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'tfg' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'tfg' ); ?></a>
				<span class="tfg-breadcrumb__sep">/</span>
				<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>"><?php esc_html_e( 'Listings', 'tfg' ); ?></a>
				<?php
				$terms = wp_get_post_terms( get_the_ID(), 'product_cat' );
				if ( $terms && ! is_wp_error( $terms ) ) {
					echo '<span class="tfg-breadcrumb__sep">/</span>';
					echo '<a href="' . esc_url( get_term_link( $terms[0] ) ) . '">' . esc_html( $terms[0]->name ) . '</a>';
				}
				?>
			</nav>

			<!-- Title block -->
			<div class="tfg-single__top" data-reveal>
				<?php
				$cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
				if ( $cats && ! is_wp_error( $cats ) ) {
					echo '<span class="eyebrow">' . esc_html( $cats[0]->name ) . '</span>';
				}
				?>
				<h1 class="tfg-single__title"><?php the_title(); ?></h1>
				<div class="tfg-single__price"><?php echo tfg_price( $product ); // phpcs:ignore ?></div>
			</div>

			<!-- Gallery + Summary grid -->
			<div class="tfg-single__grid">

				<!-- Gallery (left) -->
				<div class="tfg-single__gallery" data-reveal-img>
					<?php
					/**
					 * Hook: woocommerce_before_single_product_summary.
					 *
					 * @hooked tfg_woo_single_gallery_wrap_open - 5
					 * @hooked woocommerce_show_product_images - 20
					 * @hooked tfg_woo_single_gallery_wrap_close - 25
					 */
					do_action( 'woocommerce_before_single_product_summary' );
					?>
				</div>

				<!-- Summary (right) -->
				<div class="tfg-single__summary">
					<?php
					/**
					 * Hook: woocommerce_single_product_summary.
					 * Customized in inc/woocommerce.php:
					 *   - Removed rating, meta, sharing, add-to-cart
					 *   - Price repositioned (15)
					 *   - tfg_woo_single_enquiry (30) — Enquire CTA + phone
					 */
					do_action( 'woocommerce_single_product_summary' );
					?>

					<!-- Spec table (from product attributes) -->
					<?php
					$attrs = $product->get_attributes();
					if ( $attrs ) :
						?>
						<dl class="tfg-single__specs">
							<?php foreach ( $attrs as $attr ) :
								if ( ! ( $attr instanceof WC_Product_Attribute ) ) continue;
								$name = wc_attribute_label( $attr->get_name() );
								$val  = $product->get_attribute( $attr->get_name() );
								if ( ! $val ) continue;
								?>
								<div class="tfg-single__spec">
									<dt><?php echo esc_html( $name ); ?></dt>
									<dd><?php echo esc_html( $val ); ?></dd>
								</div>
							<?php endforeach; ?>
						</dl>
					<?php endif; ?>
				</div>
			</div>

			<!-- Tabs (description, broker) -->
			<div class="tfg-single__tabs" data-reveal>
				<?php
				/**
				 * Hook: woocommerce_after_single_product_summary.
				 *
				 * @hooked woocommerce_output_product_data_tabs - 10
				 * @hooked woocommerce_upsell_display - 15
				 * @hooked woocommerce_output_related_products - 20
				 */
				do_action( 'woocommerce_after_single_product_summary' );
				?>
			</div>

		</div>
	</div>

	<?php
endwhile;

get_footer( 'shop' );
