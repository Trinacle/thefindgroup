<?php
/**
 * SCENE 1: HERO — full-screen cinematic.
 * Massive kinetic headline. The headline IS the hero.
 *
 * @package TFG
 */
?>
<div class="tfg-hero">
	<div class="tfg-hero__media" data-parallax="0.15">
		<video autoplay muted loop playsinline poster="<?php echo esc_url( TFG_URI . '/assets/img/hero-yacht-bahamas.jpg' ); ?>">
			<source src="<?php echo esc_url( TFG_URI . '/assets/video/hero-loop.mp4' ); ?>" type="video/mp4">
			<img src="<?php echo esc_url( TFG_URI . '/assets/img/hero-yacht-bahamas.jpg' ); ?>" alt="<?php esc_attr_e( 'Luxury yacht', 'tfg' ); ?>">
		</video>
	</div>
	<div class="tfg-hero__inner">
		<div class="eyebrow tfg-hero__eyebrow" data-reveal><?php esc_html_e( 'Est. 1985 — Luxury Asset Brokerage', 'tfg' ); ?></div>
		<h1 class="tfg-hero__title">
			<span class="tfg-kinetic" style="--kinetic-delay:200ms"><span class="tfg-kinetic__inner"><?php esc_html_e( 'Selling', 'tfg' ); ?></span></span>
			<span class="tfg-kinetic" style="--kinetic-delay:380ms"><span class="tfg-kinetic__inner"><?php esc_html_e( 'Luxury Assets', 'tfg' ); ?></span></span>
			<span class="tfg-kinetic" style="--kinetic-delay:560ms"><span class="tfg-kinetic__inner"><?php esc_html_e( 'Since 1985', 'tfg' ); ?></span></span>
		</h1>
		<p class="tfg-hero__sub" data-reveal style="--reveal-delay:700ms"><?php esc_html_e( 'Yachts, Real Estate, Aircraft & Armored Luxury Vehicles — privately connecting buyers and sellers across six continents.', 'tfg' ); ?></p>
		<div class="tfg-hero__actions" data-reveal style="--reveal-delay:900ms">
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="tfg-btn tfg-btn--inverse"><?php esc_html_e( 'Explore the Collection', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
			<a href="<?php echo esc_url( home_url( '/sell-with-us/' ) ); ?>" class="tfg-text-link" style="color:rgba(255,255,255,0.9);"><?php esc_html_e( 'Sell With Us', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
	<div class="tfg-hero__scroll" aria-hidden="true"><?php esc_html_e( 'Scroll', 'tfg' ); ?></div>
</div>
