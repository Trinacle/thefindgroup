<?php
/**
 * Empty category / no results — luxury version.
 *
 * @package TFG
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="tfg-archive__empty" style="text-align:center;padding:clamp(3rem,8vh,6rem) 0;">
	<span class="eyebrow eyebrow--bare" style="justify-content:center;display:flex;margin-bottom:1.5rem;"><?php esc_html_e( 'No Listings', 'tfg' ); ?></span>
	<h2 style="font-family:var(--font-display);font-size:var(--fs-h2);margin-bottom:1rem;"><?php esc_html_e( 'No listings are currently available in this category.', 'tfg' ); ?></h2>
	<p class="lead" style="margin-inline:auto;color:var(--ink-soft);"><?php esc_html_e( 'New assets are added regularly. Contact our specialists — we may have something suitable off-market.', 'tfg' ); ?></p>
	<div class="tfg-hero__actions" style="justify-content:center;margin-top:2rem;">
		<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="tfg-btn tfg-btn--primary" data-magnetic><?php esc_html_e( 'Speak to a Specialist', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="tfg-text-link"><?php esc_html_e( 'Browse all listings', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
	</div>
</div>
