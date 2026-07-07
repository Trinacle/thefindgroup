<?php
/**
 * Template Name: Aircraft
 * Stacked full-bleed panels — three aviation divisions + VP callout + form.
 * (Replaces the live site's dead /aircraft/ page.)
 *
 * @package TFG
 */

get_header();
?>

<section class="tfg-hero tfg-hero--slim">
	<div class="tfg-hero__media">
		<img src="<?php echo esc_url( TFG_URI . '/assets/img/aircraft-hero.jpg' ); ?>" alt="<?php esc_attr_e( 'Private jet', 'tfg' ); ?>" loading="eager">
	</div>
	<div class="tfg-hero__inner">
		<span class="eyebrow tfg-hero__eyebrow" data-reveal><?php esc_html_e( 'Aircraft', 'tfg' ); ?></span>
		<h1 class="tfg-hero__title" style="font-size:var(--fs-h1);" data-reveal><?php esc_html_e( 'Private & commercial aviation, brokered privately.', 'tfg' ); ?></h1>
		<p class="tfg-hero__sub" data-reveal><?php esc_html_e( 'Extensive experience with complex private and commercial aircraft transactions in both domestic and international markets.', 'tfg' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="tfg-panel-stack" data-reveal-stagger>
			<div class="tfg-panel">
				<div class="tfg-panel__img"><img src="<?php echo esc_url( TFG_URI . '/assets/img/aircraft-jets.jpg' ); ?>" alt="<?php esc_attr_e( 'Private jets', 'tfg' ); ?>" loading="lazy"></div>
				<div class="tfg-panel__content">
					<span class="eyebrow eyebrow--bare"><?php esc_html_e( 'Private Jets', 'tfg' ); ?></span>
					<h3><?php esc_html_e( 'Mid-size to long-range jets', 'tfg' ); ?></h3>
					<p><?php esc_html_e( 'Acquisition, brokerage and sale of private jets — from super-midsize to ultra-long-range. Discreet, end-to-end transaction management.', 'tfg' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/contact/?interest=aircraft' ) ); ?>" class="tfg-text-link" style="color:var(--silver-bright);margin-top:1rem;display:inline-flex;"><?php esc_html_e( 'Enquire', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
				</div>
			</div>
			<div class="tfg-panel">
				<div class="tfg-panel__img"><img src="<?php echo esc_url( TFG_URI . '/assets/img/aircraft-turboprops.jpg' ); ?>" alt="<?php esc_attr_e( 'Turboprops', 'tfg' ); ?>" loading="lazy"></div>
				<div class="tfg-panel__content">
					<span class="eyebrow eyebrow--bare"><?php esc_html_e( 'Turboprops', 'tfg' ); ?></span>
					<h3><?php esc_html_e( 'Versatile, efficient ownership', 'tfg' ); ?></h3>
					<p><?php esc_html_e( 'Turboprop acquisitions ideal for regional and short-field operations. Valuation, brokerage and delivery handled by aviation specialists.', 'tfg' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/contact/?interest=aircraft' ) ); ?>" class="tfg-text-link" style="color:var(--silver-bright);margin-top:1rem;display:inline-flex;"><?php esc_html_e( 'Enquire', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
				</div>
			</div>
			<div class="tfg-panel">
				<div class="tfg-panel__img"><img src="<?php echo esc_url( TFG_URI . '/assets/img/aircraft-fleet.jpg' ); ?>" alt="<?php esc_attr_e( 'Corporate fleet', 'tfg' ); ?>" loading="lazy"></div>
				<div class="tfg-panel__content">
					<span class="eyebrow eyebrow--bare"><?php esc_html_e( 'Corporate Fleet Services', 'tfg' ); ?></span>
					<h3><?php esc_html_e( 'Fleet acquisition & disposal', 'tfg' ); ?></h3>
					<p><?php esc_html_e( 'Strategic acquisition and disposal of corporate fleets. Tax-advantaged structures, LLC formation and coordinated multi-aircraft transactions.', 'tfg' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/contact/?interest=aircraft' ) ); ?>" class="tfg-text-link" style="color:var(--silver-bright);margin-top:1rem;display:inline-flex;"><?php esc_html_e( 'Enquire', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- VP Aviation callout + form -->
<section class="section band--surface">
	<div class="container container--narrow text-center" data-reveal>
		<span class="eyebrow eyebrow--bare" style="justify-content:center;display:flex;"><?php esc_html_e( 'VP Aviation, Corporate Fleet Services', 'tfg' ); ?></span>
		<h2 style="margin:1.5rem auto;max-width:22ch;"><?php esc_html_e( 'Led by specialists with a mastery of aeronautics.', 'tfg' ); ?></h2>
		<p class="lead" style="margin-inline:auto;color:var(--ink-soft);"><?php esc_html_e( 'Our aviation division holds advanced degrees in aeronautics, US and European pilot licenses, and fluency across international markets. Begin a confidential conversation about your aviation needs.', 'tfg' ); ?></p>
		<div style="margin-top:2.5rem;">
			<a href="<?php echo esc_url( home_url( '/contact/?interest=aircraft' ) ); ?>" class="tfg-btn tfg-btn--primary" data-magnetic><?php esc_html_e( 'Enquire About an Aircraft', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
