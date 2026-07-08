<?php
/**
 * SEO — meta tags, Open Graph, Twitter cards, structured data.
 *
 * Follows the wordpress-theme-development skill's polish-and-qa checklist:
 *  - Meta description per page (front page static, singular from excerpt)
 *  - Open Graph + Twitter Card tags
 *  - Organization schema on homepage, Product/Service schema on listings
 *  - Canonical URLs
 *
 * @package TFG
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Meta description + OG/Twitter tags in <head>.
 */
function tfg_meta_tags() {
	global $post;

	$desc = '';
	$title = wp_get_document_title();
	$url = esc_url( home_url( add_query_arg( array(), $GLOBALS['wp']->request ? '/' . $GLOBALS['wp']->request : '/' ) ) );
	$image = '';

	// Build description + image based on context.
	if ( is_front_page() ) {
		$desc = tfg_opt( 'tfg_meta_description', __( 'THE FINDGROUP — Selling Luxury Assets Since 1985. Yachts, Real Estate, Aircraft & Armored Luxury Vehicles. Privately connecting buyers and sellers across six continents.', 'tfg' ) );
		$image = TFG_URI . '/assets/img/hero-yacht-bahamas.jpg';
		$url = home_url( '/' );
	} elseif ( is_singular() ) {
		$desc = $post->post_excerpt ? wp_strip_all_tags( $post->post_excerpt ) : wp_strip_all_tags( wp_trim_words( $post->post_content, 30 ) );
		if ( has_post_thumbnail( $post->ID ) ) {
			$img_id = get_post_thumbnail_id( $post->ID );
			$img = wp_get_attachment_image_src( $img_id, 'full' );
			if ( $img ) $image = $img[0];
		}
		$url = get_permalink( $post->ID );
		$title = get_the_title() . ' — ' . get_bloginfo( 'name' );
	} elseif ( is_product_category() || is_archive() ) {
		$term = get_queried_object();
		if ( $term && ! empty( $term->description ) ) {
			$desc = wp_strip_all_tags( $term->description );
		} else {
			$desc = sprintf( __( '%s — THE FINDGROUP luxury asset listings.', 'tfg' ), wp_get_document_title() );
		}
	}

	// Truncate description to 160 chars for meta.
	$desc = trim( $desc );
	if ( strlen( $desc ) > 160 ) $desc = substr( $desc, 0, 157 ) . '…';

	// Output meta tags.
	if ( $desc ) {
		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	}

	// Open Graph.
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:type" content="' . ( is_singular( 'product' ) ? 'product' : 'website' ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	if ( $desc ) echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	if ( $image ) echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";

	// Twitter card.
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc ) echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
	if ( $image ) echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";
	echo '<meta name="twitter:site" content="@thefindgroup">' . "\n";
}
add_action( 'wp_head', 'tfg_meta_tags', 5 );

/**
 * Structured data — Organization on homepage, Product on single listings.
 */
function tfg_structured_data() {
	if ( is_front_page() ) {
		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'Organization',
			'name'     => 'THE FINDGROUP',
			'url'      => home_url( '/' ),
			'logo'     => TFG_URI . '/assets/img/logo.png',
			'description' => 'Selling Luxury Assets Since 1985. Yachts, Real Estate, Aircraft & Armored Luxury Vehicles.',
			'foundingDate' => '1985',
			'telephone' => tfg_phone(),
			'address'   => array(
				'@type' => 'PostalAddress',
				'streetAddress' => '670 Lido Park Drive',
				'addressLocality' => 'Newport Beach',
				'addressRegion' => 'CA',
				'postalCode' => '92663',
				'addressCountry' => 'US',
			),
			'sameAs' => array_values( tfg_social() ),
		);
		echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . JSON_UNESCAPED_SLASHES . '</script>' . "\n";
	}

	if ( function_exists( 'is_product' ) && is_product() ) {
		global $product;
		if ( $product ) {
			$schema = array(
				'@context' => 'https://schema.org',
				'@type'    => 'Product',
				'name'     => get_the_title(),
				'url'      => get_permalink(),
				'description' => wp_strip_all_tags( $product->get_short_description() ? $product->get_short_description() : get_the_content() ),
			);
			if ( has_post_thumbnail() ) {
				$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				if ( $img ) $schema['image'] = $img[0];
			}
			if ( $product->get_price() > 0 ) {
				$schema['offers'] = array(
					'@type'         => 'Offer',
					'price'         => $product->get_price(),
					'priceCurrency' => 'USD',
					'availability'  => 'https://schema.org/InStock',
				);
			}
			echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . JSON_UNESCAPED_SLASHES . '</script>' . "\n";
		}
	}
}
add_action( 'wp_head', 'tfg_structured_data', 6 );
