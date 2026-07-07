<?php
/**
 * Template Name: Real Estate
 * Editorial split — featured listing as magazine spread + grid + valuation CTA.
 *
 * @package TFG
 */

get_header();

// Featured listing = most recent featured real-estate product, else latest.
$featured = tfg_listings( array( 'posts_per_page' => 1, 'category' => 'real-estate', 'featured' => true ) );
if ( ! $featured ) {
	$featured = tfg_listings( array( 'posts_per_page' => 1, 'category' => 'real-estate' ) );
}
$featured = $featured ? $featured[0] : null;

$grid = tfg_listings( array( 'posts_per_page' => 6, 'category' => 'real-estate' ) );
if ( $featured ) {
	// Exclude featured from grid.
	$grid = array_filter( $grid, function( $p ) use ( $featured ) { return $p->ID !== $featured->ID; } );
}
?>

<section class="tfg-hero tfg-hero--slim">
	<div class="tfg-hero__media">
		<img src="<?php echo esc_url( TFG_URI . '/assets/img/realestate-hero.jpg' ); ?>" alt="<?php esc_attr_e( 'Luxury estate', 'tfg' ); ?>" loading="eager">
	</div>
	<div class="tfg-hero__inner">
		<span class="eyebrow tfg-hero__eyebrow" data-reveal><?php esc_html_e( 'Luxury Real Estate', 'tfg' ); ?></span>
		<h1 class="tfg-hero__title" style="font-size:var(--fs-h1);" data-reveal><?php esc_html_e( 'Premier properties, on and off market.', 'tfg' ); ?></h1>
		<p class="tfg-hero__sub" data-reveal><?php esc_html_e( 'Delivering large networks of premier real estate and attracting a global audience in luxury residential, commercial and hospitality opportunities.', 'tfg' ); ?></p>
	</div>
</section>

<!-- Featured listing (magazine spread) -->
<?php if ( $featured ) : $fproduct = wc_get_product( $featured->ID ); ?>
	<section class="section">
		<div class="container">
			<div class="tfg-split tfg-split--reverse" data-reveal>
				<div class="tfg-split__media" data-reveal-img>
					<?php echo get_the_post_thumbnail( $featured->ID, 'tfg-wide', array( 'alt' => esc_attr( $featured->post_title ) ) ); ?>
				</div>
				<div class="tfg-split__content">
					<span class="eyebrow"><?php esc_html_e( 'Featured Listing', 'tfg' ); ?></span>
					<h2 style="margin-bottom:0.5rem;"><?php echo esc_html( $featured->post_title ); ?></h2>
					<?php if ( $fproduct ) : ?><div style="font-size:1.5rem;font-weight:600;margin-bottom:1.5rem;"><?php echo tfg_price( $fproduct ); // phpcs:ignore ?></div><?php endif; ?>
					<p class="soft"><?php echo wp_kses_post( wp_trim_words( $featured->post_excerpt ? $featured->post_excerpt : $featured->post_content, 40, '…' ) ); ?></p>
					<div class="tfg-split__actions">
						<a href="<?php echo esc_url( get_permalink( $featured->ID ) ); ?>" class="tfg-btn tfg-btn--primary" data-magnetic><?php esc_html_e( 'View Property', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
						<a href="<?php echo esc_url( home_url( '/contact/?interest=residential' ) ); ?>" class="tfg-text-link"><?php esc_html_e( 'Enquire', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- Grid -->
<?php if ( $grid ) : ?>
	<section class="section band--surface">
		<div class="container">
			<div class="section__head" data-reveal style="display:flex;justify-content:space-between;align-items:flex-end;gap:2rem;flex-wrap:wrap;">
				<div>
					<span class="eyebrow"><?php esc_html_e( 'Available Properties', 'tfg' ); ?></span>
					<h2><?php esc_html_e( 'Currently on the market.', 'tfg' ); ?></h2>
				</div>
				<a href="<?php echo esc_url( home_url( '/product-category/real-estate/' ) ); ?>" class="tfg-text-link"><?php esc_html_e( 'View all', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
			</div>
			<div class="tfg-products-grid" data-reveal-stagger>
				<?php foreach ( $grid as $post ) : setup_postdata( $post ); ?>
					<?php get_template_part( 'template-parts/content', 'listing-card' ); ?>
				<?php endforeach; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- Valuation CTA -->
<section class="tfg-cta-band">
	<div class="tfg-cta-band__bg" aria-hidden="true"><img src="<?php echo esc_url( TFG_URI . '/assets/img/realestate-cta.jpg' ); ?>" alt="" loading="lazy"></div>
	<div class="tfg-cta-band__inner container container--narrow" data-reveal>
		<h2 class="text-center"><?php esc_html_e( 'Submit your property for a private valuation.', 'tfg' ); ?></h2>
		<div class="tfg-cta-band__actions">
			<a href="<?php echo esc_url( home_url( '/contact/?interest=residential' ) ); ?>" class="tfg-btn tfg-btn--primary" data-magnetic><?php esc_html_e( 'Request a Valuation', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
