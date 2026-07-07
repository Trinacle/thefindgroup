<?php
/**
 * Template Name: Armored Vehicles
 * Diptych hero + capability list + form.
 * (Replaces the live site's dead /armored-vehicles/ page.)
 *
 * @package TFG
 */

get_header();
?>

<!-- Diptych hero -->
<section class="section" style="padding-top:calc(var(--header-h) + 2rem);">
	<div class="container">
		<div class="section__head" data-reveal>
			<span class="eyebrow"><?php esc_html_e( 'Armored Luxury Vehicles', 'tfg' ); ?></span>
			<h1 style="font-size:var(--fs-h1);"><?php esc_html_e( 'Protection without compromise. Luxury without question.', 'tfg' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'OEM-grade ballistic protection integrated into the world’s finest vehicles — discreet, certified and finished to factory standards.', 'tfg' ); ?></p>
		</div>

		<div class="tfg-diptych" data-reveal>
			<div class="tfg-diptych__panel">
				<img src="<?php echo esc_url( TFG_URI . '/assets/img/armored-1.jpg' ); ?>" alt="<?php esc_attr_e( 'Armored luxury vehicle', 'tfg' ); ?>" loading="eager">
				<div class="tfg-diptych__caption">
					<span class="eyebrow eyebrow--bare"><?php esc_html_e( 'Cadillac Escalade', 'tfg' ); ?></span>
					<h3><?php esc_html_e( 'B6 Armor', 'tfg' ); ?></h3>
				</div>
			</div>
			<div class="tfg-diptych__panel">
				<img src="<?php echo esc_url( TFG_URI . '/assets/img/armored-2.jpg' ); ?>" alt="<?php esc_attr_e( 'Armored luxury SUV', 'tfg' ); ?>" loading="lazy">
				<div class="tfg-diptych__caption">
					<span class="eyebrow eyebrow--bare"><?php esc_html_e( 'Range Rover', 'tfg' ); ?></span>
					<h3><?php esc_html_e( 'B4 Armor', 'tfg' ); ?></h3>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Editorial -->
<section class="section--sm">
	<div class="container container--narrow" data-reveal>
		<p class="tfg-pullquote"><?php esc_html_e( 'Discretion is the ultimate luxury. Our vehicles deliver it at 2,500 feet per second.', 'tfg' ); ?></p>
	</div>
</section>

<!-- Capability list -->
<section class="section band--surface">
	<div class="container">
		<div class="section__head" data-reveal>
			<span class="eyebrow"><?php esc_html_e( 'Capabilities', 'tfg' ); ?></span>
			<h2><?php esc_html_e( 'Engineered to certified standards.', 'tfg' ); ?></h2>
		</div>
		<div class="tfg-cap-list" data-reveal>
			<?php
			$caps = array(
				array( '01', 'B4 / B5 / B6 Armor Levels', 'Certified ballistic protection from handguns to high-velocity rifle fire.' ),
				array( '02', 'OEM Integration', 'Armoring integrated during build — factory finish, no compromise to fit or finish.' ),
				array( '03', 'Privacy Glass', 'Electrically opaque partition glass for rear-cabin privacy.' ),
				array( '04', 'Run-Flat Tires', 'Continued mobility after tire deflation — up to 80km at speed.' ),
				array( '05', 'Reinforced Suspension', 'Upgraded suspension and braking systems to handle added weight.' ),
				array( '06', 'Emergency Systems', 'Optional sirens, PA systems, and redundant battery and fuel cutoffs.' ),
			);
			foreach ( $caps as $c ) :
				?>
				<div class="tfg-cap-row">
					<span class="tfg-cap-row__num"><?php echo esc_html( $c[0] ); ?></span>
					<span class="tfg-cap-row__title"><?php echo esc_html( $c[1] ); ?></span>
					<span class="tfg-cap-row__desc"><?php echo esc_html( $c[2] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="text-center" style="margin-top:clamp(3rem,6vh,5rem);" data-reveal>
			<a href="<?php echo esc_url( home_url( '/contact/?interest=armored-vehicles' ) ); ?>" class="tfg-btn tfg-btn--primary" data-magnetic><?php esc_html_e( 'Enquire About a Vehicle', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
