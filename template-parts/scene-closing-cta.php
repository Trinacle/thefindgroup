<?php
/**
 * SCENE 9: CLOSING — full-bleed CTA. The exit moment.
 *
 * @package TFG
 */
?>
<div class="tfg-band tfg-band--center">
	<div class="tfg-band__media" data-parallax="0.2">
		<img src="<?php echo esc_url( TFG_URI . '/assets/img/cta-yacht-dusk.jpg' ); ?>" alt="" loading="lazy">
	</div>
	<div class="tfg-band__overlay" aria-hidden="true"></div>
	<div class="tfg-band__inner">
		<span class="eyebrow tfg-band__eyebrow eyebrow--bare" style="justify-content:center;display:flex;" data-reveal><?php esc_html_e( 'Selling Luxury Assets Since 1985', 'tfg' ); ?></span>
		<h2 class="tfg-band__title" data-reveal style="--reveal-delay:150ms"><?php esc_html_e( 'Sell your assets at true market value.', 'tfg' ); ?></h2>
		<p class="tfg-band__sub" data-reveal style="--reveal-delay:300ms"><?php esc_html_e( 'A specialist will respond within one business day. No obligation, complete discretion.', 'tfg' ); ?></p>
		<div class="tfg-band__actions" data-reveal style="--reveal-delay:450ms">
			<a href="<?php echo esc_url( home_url( '/sell-with-us/' ) ); ?>" class="tfg-btn tfg-btn--primary"><?php esc_html_e( 'Sell With Us', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
			<a href="<?php echo esc_url( tfg_phone_link() ); ?>" class="tfg-text-link" style="color:rgba(255,255,255,0.9);"><?php esc_html_e( 'Call', 'tfg' ); ?> <?php echo esc_html( tfg_phone() ); ?></a>
		</div>
	</div>
</div>
