<?php
/**
 * WooCommerce integration — template overrides, product category mapping,
 * listing-style product rendering.
 *
 * All listings (Yachts, Real Estate, Aircraft, Armored Vehicles) are
 * WooCommerce products. We map each asset type to a product_cat slug and
 * override the archive + single templates to match the luxury design.
 *
 * @package TFG
 */

/**
 * Declare WooCommerce support so our theme controls templates.
 */
function tfg_woocommerce_support() {
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 800,
		'single_image_width'    => 1600,
		'product_grid'          => array(
			'default_rows'    => 3,
			'min_rows'        => 1,
			'default_columns' => 3,
			'min_columns'     => 1,
			'max_columns'     => 4,
		),
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'tfg_woocommerce_support' );

/**
 * Remove WooCommerce default wrappers; use ours.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );

function tfg_woo_wrapper_start() {
	echo '<div class="tfg-archive"><div class="tfg-archive__inner container">';
}
add_action( 'woocommerce_before_main_content', 'tfg_woo_wrapper_start', 10 );

function tfg_woo_wrapper_end() {
	echo '</div></div>';
}
add_action( 'woocommerce_after_main_content', 'tfg_woo_wrapper_end', 10 );

/**
 * Remove default WooCommerce breadcrumbs (we render our own slim hairline breadcrumb).
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Remove the default result-count + ordering clutter; replace with a refined toolbar.
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

function tfg_woo_archive_toolbar() {
	?>
	<div class="tfg-toolbar">
		<div class="tfg-toolbar__count">
			<?php
			global $wp_query;
			$total = isset( $wp_query->found_posts ) ? $wp_query->found_posts : 0;
			printf(
				/* translators: number of listings */
				esc_html( _n( '%s listing', '%s listings', $total, 'tfg' ) ),
				'<span class="num">' . esc_html( number_format_i18n( $total ) ) . '</span>'
			);
			?>
		</div>
		<div class="tfg-toolbar__sort">
			<?php woocommerce_catalog_ordering(); ?>
		</div>
	</div>
	<?php
}
add_action( 'woocommerce_before_shop_loop', 'tfg_woo_archive_toolbar', 20 );

/**
 * Re-style the catalog ordering select via our own wrapper (CSS handles the rest).
 */
function tfg_woo_ordering_wrap_open() {
	echo '<div class="tfg-sort">';
}
function tfg_woo_ordering_wrap_close() {
	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop', 'tfg_woo_ordering_wrap_open', 29 );
add_action( 'woocommerce_before_shop_loop', 'tfg_woo_ordering_wrap_close', 31 );
// Wrap the existing ordering function output.
add_filter( 'woocommerce_catalog_ordering', function( $html ) {
	return '<div class="tfg-sort__inner">' . $html . '</div>';
} );

/**
 * Trim WooCommerce product loop hooks to a refined card.
 */
remove_action( 'woocommerce_before_shop_loop_item',       'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title',        'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title',  'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item',        'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item',        'woocommerce_template_loop_add_to_cart', 10 );

/**
 * Custom product card.
 */
function tfg_woo_card_open() {
	echo '<a href="' . esc_url( get_the_permalink() ) . '" class="tfg-listing-card" data-magnetic>';
	echo '<div class="tfg-listing-card__media">';
}
add_action( 'woocommerce_before_shop_loop_item', 'tfg_woo_card_open', 10 );

function tfg_woo_card_thumb() {
	global $product;
	if ( has_post_thumbnail() ) {
		echo get_the_post_thumbnail( $product->get_id(), 'tfg-listing', array( 'class' => 'tfg-listing-card__img', 'loading' => 'lazy' ) );
	} else {
		echo '<div class="tfg-listing-card__placeholder">' . esc_html__( 'Image coming soon', 'tfg' ) . '</div>';
	}
	// Sale flash — custom slim pill.
	if ( $product->is_on_sale() ) {
		echo '<span class="tfg-listing-card__badge">' . esc_html__( 'Reduced', 'tfg' ) . '</span>';
	}
}
add_action( 'woocommerce_before_shop_loop_item_title', 'tfg_woo_card_thumb', 10 );

function tfg_woo_card_body() {
	global $product;
	echo '</div>'; // .media
	echo '<div class="tfg-listing-card__body">';
	echo '<div class="tfg-listing-card__meta">';
	// Category (yachts / real-estate / etc.) as the eyebrow.
	$cats = wp_get_post_terms( $product->get_id(), 'product_cat' );
	if ( $cats && ! is_wp_error( $cats ) ) {
		echo '<span class="tfg-listing-card__cat eyebrow">' . esc_html( $cats[0]->name ) . '</span>';
	}
	echo '</div>';
	echo '<h3 class="tfg-listing-card__title">' . esc_html( get_the_title() ) . '</h3>';
	// Short attributes line (location · specs) if available.
	$attrs = $product->get_attributes();
	$spec_line = array();
	foreach ( $attrs as $attr ) {
		if ( $attr instanceof WC_Product_Attribute ) {
			$spec_line[] = wc_attribute_label( $attr->get_name() ) . ' ' . $product->get_attribute( $attr->get_name() );
		}
	}
	if ( $spec_line ) {
		echo '<div class="tfg-listing-card__specs">' . esc_html( implode( ' · ', array_slice( $spec_line, 0, 3 ) ) ) . '</div>';
	}
	echo '<div class="tfg-listing-card__price">' . tfg_price( $product ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '<span class="tfg-listing-card__cta">' . esc_html__( 'View', 'tfg' ) . ' <span aria-hidden="true">→</span></span>';
	echo '</div>'; // .body
}
add_action( 'woocommerce_shop_loop_item_title', 'tfg_woo_card_body', 10 );

function tfg_woo_card_close() {
	echo '</a>';
}
add_action( 'woocommerce_after_shop_loop_item', 'tfg_woo_card_close', 10 );

/**
 * Single product page — remove the default Add-to-Cart (luxury brokerage
 * has no cart; the CTA is an enquiry form). Replace price display with ours.
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

// Reposition price below title, before excerpt.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );

// Replace the Add to Cart button with an enquiry CTA.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary', 'tfg_woo_single_enquiry', 30 );

function tfg_woo_single_enquiry() {
	?>
	<div class="tfg-single-enquiry">
		<a href="<?php echo esc_url( add_query_arg( 'interest', sanitize_title( get_the_title() ), home_url( '/contact/' ) ) ); ?>" class="tfg-btn tfg-btn--primary" data-magnetic>
			<?php esc_html_e( 'Enquire about this asset', 'tfg' ); ?> <span aria-hidden="true">→</span>
		</a>
		<a href="<?php echo esc_url( tfg_phone_link() ); ?>" class="tfg-btn tfg-btn--ghost"><?php echo esc_html( tfg_phone() ); ?></a>
	</div>
	<?php
}

/**
 * Price filter for single product — use our luxury formatting.
 */
remove_filter( 'woocommerce_get_price_html', 'tfg_woo_single_price_html' );
function tfg_woo_single_price_html( $html, $product ) {
	if ( $product->get_price() > 0 ) {
		return tfg_price( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	return '<span class="tfg-price__poa">' . esc_html__( 'Price on request', 'tfg' ) . '</span>';
}
add_filter( 'woocommerce_get_price_html', 'tfg_woo_single_price_html', 10, 2 );

/**
 * Wrap single product gallery in our container.
 */
function tfg_woo_single_gallery_wrap_open() {
	echo '<div class="tfg-single-gallery">';
}
function tfg_woo_single_gallery_wrap_close() {
	echo '</div>';
}
add_action( 'woocommerce_before_single_product_summary', 'tfg_woo_single_gallery_wrap_open', 5 );
add_action( 'woocommerce_before_single_product_summary', 'tfg_woo_single_gallery_wrap_close', 25 );

/**
 * Disable cart/checkout redirects — luxury brokerage is enquiry-based.
 * We keep WooCommerce for the product architecture but the "cart" is never used.
 */
function tfg_disable_cart() {
	if ( is_cart() || is_checkout() ) {
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}
}
add_action( 'template_redirect', 'tfg_disable_cart' );

/**
 * Add enquiry text in place of "Add to cart" on the global button filter.
 */
add_filter( 'woocommerce_product_add_to_cart_text', function() {
	return __( 'Enquire', 'tfg' );
} );
add_filter( 'woocommerce_product_single_add_to_cart_text', function() {
	return __( 'Enquire', 'tfg' );
} );

/**
 * Remove WooCommerce default styles — we ship our own.
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Posts-per-page for listings archives.
 */
function tfg_woo_per_page( $cols ) {
	return 12;
}
add_filter( 'loop_shop_columns', 'tfg_woo_per_page', 99 );

/**
 * Product category → asset-type mapping for nav mega-menu links.
 */
function tfg_asset_categories() {
	return array(
		'yachts'           => array( 'name' => __( 'Yachts', 'tfg' ),           'img' => 'category-yachts.jpg' ),
		'real-estate'      => array( 'name' => __( 'Real Estate', 'tfg' ),      'img' => 'category-real-estate.jpg' ),
		'aircraft'         => array( 'name' => __( 'Aircraft', 'tfg' ),         'img' => 'category-aircraft.jpg' ),
		'armored-vehicles' => array( 'name' => __( 'Armored Vehicles', 'tfg' ), 'img' => 'category-armored.jpg' ),
	);
}

/**
 * Ensure the four core product categories exist on activation.
 */
function tfg_ensure_product_categories() {
	if ( get_option( 'tfg_woo_cats_seeded' ) ) return;
	if ( ! function_exists( 'wc_create_product_category' ) ) return;
	$cats = array_keys( tfg_asset_categories() );
	$labels = tfg_asset_categories();
	foreach ( $cats as $slug ) {
		if ( ! term_exists( $slug, 'product_cat' ) ) {
			wp_insert_term( $labels[ $slug ]['name'], 'product_cat', array( 'slug' => $slug ) );
		}
	}
	update_option( 'tfg_woo_cats_seeded', 1 );
}
add_action( 'after_switch_theme', 'tfg_ensure_product_categories' );

/**
 * Add a "broker" product data tab — links a listing to a team_member.
 */
function tfg_broker_tab( $tabs ) {
	$tabs['tfg_broker'] = array(
		'title'    => __( 'Broker', 'tfg' ),
		'priority' => 50,
		'callback' => 'tfg_broker_tab_content',
	);
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'tfg_broker_tab' );

function tfg_broker_tab_content() {
	global $product;
	$broker_id = get_post_meta( $product->get_id(), '_tfg_broker_id', true );
	if ( $broker_id && get_post( $broker_id ) ) {
		$broker = get_post( $broker_id );
		$role   = get_post_meta( $broker_id, '_tfg_role', true );
		?>
		<div class="tfg-broker-card">
			<?php if ( has_post_thumbnail( $broker_id ) ) echo get_the_post_thumbnail( $broker_id, 'thumbnail', array( 'class' => 'tfg-broker-card__img' ) ); ?>
			<div class="tfg-broker-card__info">
				<h4 class="tfg-broker-card__name"><?php echo esc_html( $broker->post_title ); ?></h4>
				<p class="tfg-broker-card__role"><?php echo esc_html( $role ); ?></p>
				<a href="<?php echo esc_url( add_query_arg( 'broker', $broker_id, home_url( '/contact/' ) ) ); ?>" class="tfg-text-link"><?php esc_html_e( 'Contact this broker', 'tfg' ); ?> →</a>
			</div>
		</div>
		<?php
	} else {
		echo '<p>' . esc_html__( 'Contact our team to learn more about this asset.', 'tfg' ) . '</p>';
	}
}

/**
 * Broker meta box on products.
 */
function tfg_broker_meta_box() {
	add_meta_box( 'tfg_broker_mb', __( 'Assigned Broker', 'tfg' ), 'tfg_broker_mb_cb', 'product', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'tfg_broker_meta_box' );

function tfg_broker_mb_cb( $post ) {
	$current = get_post_meta( $post->ID, '_tfg_broker_id', true );
	$team    = tfg_team();
	?>
	<select name="tfg_broker_id" style="width:100%">
		<option value=""><?php esc_html_e( '— None —', 'tfg' ); ?></option>
		<?php foreach ( $team as $m ) : ?>
			<option value="<?php echo esc_attr( $m->ID ); ?>" <?php selected( $current, $m->ID ); ?>><?php echo esc_html( $m->post_title ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

function tfg_save_broker_meta( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	if ( isset( $_POST['tfg_broker_id'] ) ) {
		update_post_meta( $post_id, '_tfg_broker_id', intval( $_POST['tfg_broker_id'] ) );
	}
}
add_action( 'save_post_product', 'tfg_save_broker_meta' );
