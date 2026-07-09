<?php
/**
 * SCENE 4: THE STATEMENT — full-bleed cinematic image band.
 * Text overlays bottom-left over a gradient.
 *
 * @package TFG
 */
?>
<div class="tfg-band">
	<div class="tfg-band__media" data-parallax="0.18">
		<img src="<?php echo esc_url( TFG_URI . '/assets/img/statement-yacht-profile.jpg' ); ?>" alt="<?php esc_attr_e( 'Luxury yacht at profile', 'tfg' ); ?>" loading="lazy">
	</div>
	<div class="tfg-band__overlay" aria-hidden="true"></div>
	<div class="tfg-band__inner">
		<span class="eyebrow tfg-band__eyebrow" data-reveal><?php esc_html_e( '03 — The FindGroup', 'tfg' ); ?></span>
		<h2 class="tfg-band__title" data-reveal style="--reveal-delay:150ms"><?php esc_html_e( 'Privately connecting buyers and sellers, since 1985.', 'tfg' ); ?></h2>
		<p class="tfg-band__sub" data-reveal style="--reveal-delay:300ms"><?php esc_html_e( 'A full-service luxury brokerage merging yachting, real estate, aviation and armored vehicle specialists into one organization. Some assets never reach the open market — we connect buyers and sellers privately and confidentially through an exclusive international network curated over four decades.', 'tfg' ); ?></p>
		<div class="tfg-band__actions" data-reveal style="--reveal-delay:450ms">
			<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="tfg-btn tfg-btn--primary"><?php esc_html_e( 'Our Story', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
			<a href="<?php echo esc_url( home_url( '/sell-with-us/' ) ); ?>" class="tfg-text-link" style="color:rgba(255,255,255,0.9);"><?php esc_html_e( 'Sell With Us', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
</div>
