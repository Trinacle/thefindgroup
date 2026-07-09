<?php
/**
 * SCENE 3: TRENDING — full-bleed horizontal carousel of featured listings.
 *
 * @package TFG
 */
$listings = tfg_listings( array( 'posts_per_page' => 6, 'featured' => true ) );
if ( ! $listings ) {
	$listings = tfg_listings( array( 'posts_per_page' => 6 ) );
}
if ( ! $listings ) return;
?>
<div class="band--dark" style="width:100%;">
	<div class="container section section--sm">
		<div class="section__head" data-reveal style="display:flex;justify-content:space-between;align-items:flex-end;gap:2rem;flex-wrap:wrap;margin-bottom:0;">
			<div>
				<span class="eyebrow"><?php esc_html_e( '02 — Trending Now', 'tfg' ); ?></span>
				<h2><?php esc_html_e( 'Currently in demand', 'tfg' ); ?></h2>
			</div>
			<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="tfg-text-link"><?php esc_html_e( 'View all listings', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>

	<div class="tfg-trending__rail" data-reveal>
		<?php foreach ( $listings as $post ) : setup_postdata( $post ); global $product; $product = wc_get_product( $post->ID ); ?>
			<div class="tfg-trending__item">
				<?php get_template_part( 'template-parts/content', 'listing-card' ); ?>
			</div>
		<?php endforeach; wp_reset_postdata(); ?>
	</div>
</div>
