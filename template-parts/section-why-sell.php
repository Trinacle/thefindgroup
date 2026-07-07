<?php
/**
 * Home section: Why Sell With Us (magazine spread, 3-col with center image).
 *
 * @package TFG
 */
?>
<section class="section band--surface" id="why-sell">
	<div class="container">
		<div class="section__head text-center" data-reveal style="justify-items:center;">
			<span class="eyebrow eyebrow--bare" style="justify-content:center;"><?php esc_html_e( '04 — Why Sell With Us', 'tfg' ); ?></span>
			<h2 style="margin-inline:auto;max-width:20ch;"><?php esc_html_e( 'A brokerage built on reach, mastery and trust.', 'tfg' ); ?></h2>
		</div>

		<div class="tfg-magazine" data-reveal>
			<div class="tfg-magazine__col">
				<div class="tfg-magazine__num">01</div>
				<h3><?php esc_html_e( 'Global Reach', 'tfg' ); ?></h3>
				<p><?php esc_html_e( 'Our network extends across six continents. Whether your vessel is docked in Miami, anchored in the Mediterranean, or cruising the Caribbean, we have the reach to find the right buyer.', 'tfg' ); ?></p>
			</div>

			<div class="tfg-magazine__feature" data-reveal-img>
				<img src="<?php echo esc_url( TFG_URI . '/assets/img/why-sell-interior.jpg' ); ?>" alt="<?php esc_attr_e( 'Luxury yacht interior', 'tfg' ); ?>" loading="lazy">
			</div>

			<div class="tfg-magazine__col" style="grid-column:3;">
				<div class="tfg-magazine__num">02</div>
				<h3><?php esc_html_e( 'Marketing Mastery', 'tfg' ); ?></h3>
				<p><?php esc_html_e( 'Captivating listings, high-quality photography, and promotional materials across print, email and social — reaching a database of over 16,000 luxury enthusiasts.', 'tfg' ); ?></p>
				<div class="tfg-magazine__num" style="margin-top:2.5rem;">03</div>
				<h3><?php esc_html_e( 'Integrity & Trust', 'tfg' ); ?></h3>
				<p><?php esc_html_e( 'Our reputation is built on honesty and transparency. We operate with integrity, ensuring full confidence in our services and recommendations.', 'tfg' ); ?></p>
			</div>
		</div>

		<div class="text-center" style="margin-top:clamp(3rem,6vh,5rem);" data-reveal>
			<a href="<?php echo esc_url( home_url( '/sell-with-us/' ) ); ?>" class="tfg-btn tfg-btn--primary" data-magnetic><?php esc_html_e( 'Sell Your Assets With Us', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
</section>
