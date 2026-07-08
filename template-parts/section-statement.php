<?php
/**
 * Home section: Brand statement (editorial split 7/5).
 *
 * @package TFG
 */
?>
<section class="section band--dark" id="statement">
	<div class="container">
		<div class="tfg-split">
			<div class="tfg-split__media" data-reveal-img>
				<img src="<?php echo esc_url( TFG_URI . '/assets/img/statement-yacht-profile.jpg' ); ?>" alt="<?php esc_attr_e( 'Luxury yacht at profile', 'tfg' ); ?>" loading="lazy">
			</div>
			<div class="tfg-split__content" data-reveal>
				<span class="eyebrow"><?php esc_html_e( '03 — The FindGroup', 'tfg' ); ?></span>
				<h2><?php esc_html_e( 'Privately connecting buyers and sellers, since 1985.', 'tfg' ); ?></h2>
				<p><?php esc_html_e( 'THE FINDGROUP is a full-service luxury brokerage merging yachting, real estate, aviation and armored vehicle specialists into one organization. Some assets are unique and not available in the mainstream marketplace — we connect buyers and sellers privately and confidentially through an exclusive international network curated over four decades.', 'tfg' ); ?></p>
				<p><?php esc_html_e( 'Our team is affiliated with DRE, MLS, IYBA, MYBA, NMMA and YBAA, and collaborates with attorneys specialized in LLC and tax implications across every transaction.', 'tfg' ); ?></p>
				<div class="tfg-split__actions">
					<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="tfg-btn tfg-btn--ghost" data-magnetic><?php esc_html_e( 'Our Story', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
					<a href="<?php echo esc_url( home_url( '/sell-with-us/' ) ); ?>" class="tfg-text-link"><?php esc_html_e( 'Sell With Us', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
				</div>
			</div>
		</div>
	</div>
</section>
