<?php
/**
 * Home section: Brand statement — full-bleed cinematic image band.
 * Image fills the viewport; text overlays at the bottom-left.
 *
 * @package TFG
 */
?>
<section class="tfg-fullbleed-band" id="statement">
	<div class="tfg-fullbleed-band__media">
		<img src="<?php echo esc_url( TFG_URI . '/assets/img/statement-yacht-profile.jpg' ); ?>" alt="<?php esc_attr_e( 'Luxury yacht at profile', 'tfg' ); ?>" loading="lazy">
	</div>
	<div class="tfg-fullbleed-band__overlay" aria-hidden="true"></div>
	<div class="tfg-fullbleed-band__inner">
		<span class="eyebrow tfg-fullbleed-band__eyebrow"><?php esc_html_e( '03 — The FindGroup', 'tfg' ); ?></span>
		<h2 class="tfg-fullbleed-band__title"><?php esc_html_e( 'Privately connecting buyers and sellers, since 1985.', 'tfg' ); ?></h2>
		<p class="tfg-fullbleed-band__sub"><?php esc_html_e( 'A full-service luxury brokerage merging yachting, real estate, aviation and armored vehicle specialists into one organization. Some assets never reach the open market — we connect buyers and sellers privately and confidentially through an exclusive international network curated over four decades.', 'tfg' ); ?></p>
		<div class="tfg-fullbleed-band__actions">
			<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="tfg-btn tfg-btn--primary"><?php esc_html_e( 'Our Story', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
			<a href="<?php echo esc_url( home_url( '/sell-with-us/' ) ); ?>" class="tfg-text-link" style="color:rgba(255,255,255,0.9);"><?php esc_html_e( 'Sell With Us', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
</section>
