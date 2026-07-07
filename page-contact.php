<?php
/**
 * Template Name: Contact
 * Two-column: sticky offices (left) + Forminator form (right, primary CTA).
 *
 * @package TFG
 */

get_header();
?>

<!-- Slim hero -->
<section class="tfg-hero tfg-hero--slim" style="min-height:auto;">
	<div class="tfg-hero__media">
		<img src="<?php echo esc_url( TFG_URI . '/assets/img/contact-hero.jpg' ); ?>" alt="<?php esc_attr_e( 'THE FINDGROUP office', 'tfg' ); ?>" loading="eager">
	</div>
	<div class="tfg-hero__inner">
		<span class="eyebrow tfg-hero__eyebrow" data-reveal><?php esc_html_e( 'Contact', 'tfg' ); ?></span>
		<h1 class="tfg-hero__title" style="font-size:var(--fs-h1);" data-reveal><?php esc_html_e( 'Let’s begin a conversation.', 'tfg' ); ?></h1>
		<p class="tfg-hero__sub" data-reveal><?php esc_html_e( 'For any request, use the form below — a specialist will respond within one business day. Prefer to talk? Call us directly.', 'tfg' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="tfg-contact">

			<!-- LEFT: offices (backup CTA) -->
			<div class="tfg-contact__offices" data-reveal>
				<span class="eyebrow" style="margin-bottom:1.5rem;display:inline-flex;"><?php esc_html_e( 'Talk With Us', 'tfg' ); ?></span>
				<p class="lead" style="margin-bottom:2rem;"><?php esc_html_e( 'Choose a time that suits you and tell us more about your needs. Our specialists advise on buying or selling luxury assets across every division.', 'tfg' ); ?></p>

				<a href="<?php echo esc_url( tfg_phone_link() ); ?>" class="tfg-btn tfg-btn--primary" data-magnetic style="margin-bottom:2.5rem;">
					<?php esc_html_e( 'Call', 'tfg' ); ?> <?php echo esc_html( tfg_phone() ); ?>
				</a>

				<h4 class="eyebrow eyebrow--bare" style="margin-bottom:1.5rem;display:block;"><?php esc_html_e( 'Our Offices', 'tfg' ); ?></h4>
				<div class="tfg-offices">
					<?php foreach ( tfg_offices() as $o ) : $phone = get_post_meta( $o->ID, '_tfg_phone', true ); $addr = get_post_meta( $o->ID, '_tfg_address', true ); $map = get_post_meta( $o->ID, '_tfg_map', true ); ?>
						<div class="tfg-office">
							<div>
								<div class="tfg-office__city"><?php echo esc_html( $o->post_title ); ?></div>
								<?php if ( $addr ) : ?><div class="tfg-office__addr"><?php echo esc_html( $addr ); ?></div><?php endif; ?>
								<?php if ( $map ) : ?><a href="<?php echo esc_url( $map ); ?>" class="tfg-office__map" target="_blank" rel="noopener"><?php esc_html_e( 'View on map', 'tfg' ); ?> →</a><?php endif; ?>
							</div>
							<?php if ( $phone ) : ?><div class="tfg-office__phone"><a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></div><?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- RIGHT: form (primary CTA) -->
			<div class="tfg-contact__form" data-reveal>
				<?php if ( isset( $_GET['submitted'] ) ) : // fallback form success ?>
					<div class="tfg-form__success">
						<h3><?php esc_html_e( 'Thank you.', 'tfg' ); ?></h3>
						<p><?php esc_html_e( 'Your message has been received. A specialist will respond within one business day.', 'tfg' ); ?></p>
					</div>
				<?php endif; ?>

				<span class="eyebrow" style="margin-bottom:1.5rem;display:inline-flex;"><?php esc_html_e( 'Send Us a Message', 'tfg' ); ?></span>
				<?php tfg_contact_form(); ?>
			</div>

		</div>
	</div>
</section>

<?php get_footer(); ?>
