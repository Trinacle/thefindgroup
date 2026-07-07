<?php
/**
 * Home section: Closing CTA band (full-bleed, form-forward).
 * Form is the primary CTA; phone is the backup.
 *
 * @package TFG
 */
?>
<section class="tfg-cta-band" id="closing-cta">
	<div class="tfg-cta-band__bg" aria-hidden="true">
		<img src="<?php echo esc_url( TFG_URI . '/assets/img/cta-yacht-dusk.jpg' ); ?>" alt="" loading="lazy">
	</div>
	<div class="tfg-cta-band__inner container container--narrow" data-reveal>
		<span class="eyebrow eyebrow--bare" style="justify-content:center;display:flex;"><?php esc_html_e( 'Selling Luxury Assets Since 1985', 'tfg' ); ?></span>
		<h2 class="text-center"><?php esc_html_e( 'Sell your assets at true market value.', 'tfg' ); ?></h2>
		<p class="lead text-center" style="margin-inline:auto;color:var(--silver-bright);"><?php esc_html_e( 'A specialist will respond within one business day. No obligation, complete discretion.', 'tfg' ); ?></p>
		<div class="tfg-cta-band__actions">
			<a href="<?php echo esc_url( home_url( '/sell-with-us/' ) ); ?>" class="tfg-btn tfg-btn--primary" data-magnetic><?php esc_html_e( 'Sell With Us', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
			<a href="<?php echo esc_url( tfg_phone_link() ); ?>" class="tfg-btn tfg-btn--ghost" data-magnetic><?php esc_html_e( 'Call', 'tfg' ); ?> <?php echo esc_html( tfg_phone() ); ?></a>
		</div>
	</div>
</section>
