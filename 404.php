<?php
/**
 * 404 — cinematic minimal.
 * Replaces the live site's 404 that dumps the entire marketing page.
 *
 * @package TFG
 */

get_header();
?>

<section class="tfg-404">
	<div class="tfg-404__bg" aria-hidden="true">
		<img src="<?php echo esc_url( TFG_URI . '/assets/img/404-yacht.jpg' ); ?>" alt="" loading="eager">
	</div>
	<div class="tfg-404__inner" data-reveal>
		<span class="eyebrow eyebrow--bare" style="justify-content:center;display:flex;margin-bottom:1.5rem;"><?php esc_html_e( 'Error 404', 'tfg' ); ?></span>
		<h1><?php esc_html_e( 'This page has set sail.', 'tfg' ); ?></h1>
		<p><?php esc_html_e( 'The page you are looking for could not be found. Let us guide you back to port.', 'tfg' ); ?></p>
		<div class="tfg-hero__actions" style="justify-content:center;">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tfg-btn tfg-btn--primary" data-magnetic><?php esc_html_e( 'Return Home', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="tfg-text-link"><?php esc_html_e( 'Contact Us', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
