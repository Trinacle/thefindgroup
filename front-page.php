<?php
/**
 * Front page — cinematic hero + alternating bands.
 * Composed of template-parts for maintainability.
 *
 * @package TFG
 */

get_header();
?>

<!-- 1. HERO -->
<section class="tfg-hero">
	<div class="tfg-hero__media">
		<?php
		// Use the homepage featured image or a default cinematic image.
		if ( has_post_thumbnail( get_the_ID() ) ) {
			echo get_the_post_thumbnail( get_the_ID(), 'tfg-hero', array( 'class' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ) );
		} else {
			echo '<img src="' . esc_url( TFG_URI . '/assets/img/hero-yacht-bahamas.jpg' ) . '" alt="' . esc_attr__( 'Luxury yacht at dusk', 'tfg' ) . '" loading="eager" fetchpriority="high">';
		}
		?>
	</div>
	<div class="tfg-hero__inner">
		<div class="eyebrow tfg-hero__eyebrow" data-hero-anim><?php esc_html_e( 'Est. 1985 — Luxury Asset Brokerage', 'tfg' ); ?></div>
		<h1 class="tfg-hero__title" data-hero-anim><?php echo esc_html( tfg_opt( 'tfg_tagline', __( 'Selling Luxury Assets Since 1985', 'tfg' ) ) ); ?></h1>
		<p class="tfg-hero__sub" data-hero-anim><?php esc_html_e( 'Yachts, Real Estate, Aircraft & Armored Luxury Vehicles — privately connecting buyers and sellers across six continents.', 'tfg' ); ?></p>
		<div class="tfg-hero__actions" data-hero-anim>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="tfg-btn tfg-btn--inverse" data-magnetic><?php esc_html_e( 'Explore the Collection', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
			<a href="<?php echo esc_url( home_url( '/sell-with-us/' ) ); ?>" class="tfg-text-link" style="color:var(--silver-bright)"><?php esc_html_e( 'Sell With Us', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
	<div class="tfg-hero__scroll" aria-hidden="true"><?php esc_html_e( 'Scroll', 'tfg' ); ?></div>
</section>

<!-- 2. FEATURED CATEGORIES -->
<?php get_template_part( 'template-parts/section', 'categories' ); ?>

<!-- 3. TRENDING LISTINGS -->
<?php get_template_part( 'template-parts/section', 'trending' ); ?>

<!-- 4. BRAND STATEMENT (editorial split) -->
<?php get_template_part( 'template-parts/section', 'statement' ); ?>

<!-- 5. AUTHORIZED DEALER STRIP -->
<?php get_template_part( 'template-parts/section', 'brands' ); ?>

<!-- 6. STATS -->
<?php get_template_part( 'template-parts/section', 'stats' ); ?>

<!-- 7. WHY SELL (magazine spread) -->
<?php get_template_part( 'template-parts/section', 'why-sell' ); ?>

<!-- 8. TEAM TEASER (diptych) -->
<?php get_template_part( 'template-parts/section', 'team-teaser' ); ?>

<!-- 9. ASSOCIATIONS -->
<?php get_template_part( 'template-parts/section', 'associations' ); ?>

<!-- 10. CLOSING CTA -->
<?php get_template_part( 'template-parts/section', 'closing-cta' ); ?>

<?php
get_footer();
