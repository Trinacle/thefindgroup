<?php
/**
 * SCENE 6: WHY SELL — editorial split with pinned image + parallax.
 *
 * @package TFG
 */
?>
<div class="band--light" style="width:100%;">
	<div class="container section">
		<div class="section__head" data-reveal>
			<span class="eyebrow"><?php esc_html_e( '05 — Why Sell With Us', 'tfg' ); ?></span>
			<h2><?php esc_html_e( 'A brokerage built on reach, mastery and trust.', 'tfg' ); ?></h2>
		</div>

		<div class="tfg-why">
			<div class="tfg-why__reasons" data-reveal-stagger>
				<div class="tfg-why__reason">
					<div class="tfg-why__num">01</div>
					<div class="tfg-why__body">
						<h3><?php esc_html_e( 'Global Reach', 'tfg' ); ?></h3>
						<p><?php esc_html_e( 'Our network extends across six continents. Whether your vessel is docked in Miami, anchored in the Mediterranean, or cruising the Caribbean, we find the right buyer.', 'tfg' ); ?></p>
					</div>
				</div>
				<div class="tfg-why__reason">
					<div class="tfg-why__num">02</div>
					<div class="tfg-why__body">
						<h3><?php esc_html_e( 'Marketing Mastery', 'tfg' ); ?></h3>
						<p><?php esc_html_e( 'Captivating listings, high-quality photography, and promotional materials across print, email and social — reaching a database of over 16,000 luxury enthusiasts.', 'tfg' ); ?></p>
					</div>
				</div>
				<div class="tfg-why__reason">
					<div class="tfg-why__num">03</div>
					<div class="tfg-why__body">
						<h3><?php esc_html_e( 'Integrity & Trust', 'tfg' ); ?></h3>
						<p><?php esc_html_e( 'Our reputation is built on honesty and transparency. We operate with integrity, ensuring full confidence in our services and recommendations.', 'tfg' ); ?></p>
					</div>
				</div>
			</div>

			<div class="tfg-why__media" data-reveal-img data-parallax="0.15">
				<img src="<?php echo esc_url( TFG_URI . '/assets/img/why-sell-interior.jpg' ); ?>" alt="<?php esc_attr_e( 'Luxury yacht interior', 'tfg' ); ?>" loading="lazy">
			</div>
		</div>

		<div class="text-center" style="margin-top:clamp(3rem,6vh,5rem);" data-reveal>
			<a href="<?php echo esc_url( home_url( '/sell-with-us/' ) ); ?>" class="tfg-btn tfg-btn--primary"><?php esc_html_e( 'Sell Your Assets With Us', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
</div>
