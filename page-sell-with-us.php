<?php
/**
 * Template Name: Sell With Us
 * Stacked reason panels (8) + single-column form (primary CTA).
 *
 * @package TFG
 */

get_header();
?>

<section class="tfg-hero tfg-hero--slim">
	<div class="tfg-hero__media">
		<img src="<?php echo esc_url( TFG_URI . '/assets/img/sell-hero.jpg' ); ?>" alt="<?php esc_attr_e( 'Luxury asset', 'tfg' ); ?>" loading="eager">
	</div>
	<div class="tfg-hero__inner">
		<span class="eyebrow tfg-hero__eyebrow" data-reveal><?php esc_html_e( 'Sell With Us', 'tfg' ); ?></span>
		<h1 class="tfg-hero__title" style="font-size:var(--fs-h1);" data-reveal><?php esc_html_e( 'Sell your luxury assets with confidence.', 'tfg' ); ?></h1>
		<p class="tfg-hero__sub" data-reveal><?php esc_html_e( 'Reach buyers from around the globe across multiple networks. Reach a database of over 16,000 luxury enthusiasts.', 'tfg' ); ?></p>
		<div class="tfg-hero__actions" data-reveal>
			<a href="#enquire" class="tfg-btn tfg-btn--inverse" data-magnetic><?php esc_html_e( 'Start Your Enquiry', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
</section>

<!-- 8 reasons -->
<section class="section">
	<div class="container">
		<div class="section__head" data-reveal>
			<span class="eyebrow"><?php esc_html_e( 'Why Work With Us', 'tfg' ); ?></span>
			<h2><?php esc_html_e( 'Eight reasons sellers choose THE FINDGROUP.', 'tfg' ); ?></h2>
		</div>
		<div class="tfg-reasons" data-reveal-stagger>
			<?php
			$reasons = array(
				array( 'Expertise & Experience', 'Seasoned professionals with a wealth of knowledge across yachts, real estate, aviation and armored vehicles. Decades of experience work in your favor.' ),
				array( 'Personalized Service', 'Every asset is unique, just as every owner has individual preferences. A tailored approach to selling — your satisfaction is our priority.' ),
				array( 'Global Reach', 'An extensive network with connections to prospective buyers worldwide. Miami, the Mediterranean, the Caribbean — we find the right buyer.' ),
				array( 'Marketing Mastery', 'Captivating listings, high-quality photography and engaging promotional materials across print, email and social media.' ),
				array( 'Seamless Transactions', 'From valuation to negotiation, paperwork to handover — we simplify every step of a complex process.' ),
				array( 'Exceptional Service', 'Answering questions, addressing concerns and keeping you informed at every step. Your peace of mind is our driving force.' ),
				array( 'Maximized Value', 'Negotiation skills, market insights and commitment to your interests lead to favorable outcomes.' ),
				array( 'Integrity & Trust', 'A reputation built on honesty and transparency. Full confidence in our services and recommendations.' ),
			);
			foreach ( $reasons as $i => $r ) :
				$num = str_pad( $i + 1, 2, '0', STR_PAD_LEFT );
				?>
				<div class="tfg-reason">
					<div class="tfg-reason__num"><?php echo esc_html( $num ); ?></div>
					<div class="tfg-reason__body">
						<h3><?php echo esc_html( $r[0] ); ?></h3>
						<p><?php echo esc_html( $r[1] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Closing callout -->
<section class="section--sm band--surface" id="enquire">
	<div class="container container--narrow text-center" data-reveal>
		<span class="eyebrow eyebrow--bare" style="justify-content:center;display:flex;"><?php esc_html_e( 'Choose Excellence', 'tfg' ); ?></span>
		<h2 style="margin:1.5rem auto;max-width:20ch;"><?php esc_html_e( 'Trust the experts who understand the value of your investment.', 'tfg' ); ?></h2>
		<p class="lead" style="margin-inline:auto;color:var(--ink-soft);"><?php esc_html_e( 'Call us or complete the form below to find out why working with us is beneficial.', 'tfg' ); ?></p>
	</div>
</section>

<!-- Form (primary CTA) -->
<section class="section">
	<div class="container container--narrow" data-reveal>
		<?php if ( isset( $_GET['submitted'] ) ) : ?>
			<div class="tfg-form__success">
				<h3><?php esc_html_e( 'Thank you.', 'tfg' ); ?></h3>
				<p><?php esc_html_e( 'Your message has been received. A specialist will respond within one business day.', 'tfg' ); ?></p>
			</div>
		<?php else : ?>
			<span class="eyebrow" style="margin-bottom:2rem;display:inline-flex;"><?php esc_html_e( 'Contact Us', 'tfg' ); ?></span>
			<?php tfg_contact_form(); ?>
		<?php endif; ?>

		<div class="text-center" style="margin-top:3rem;padding-top:2rem;border-top:1px solid var(--line);">
			<p class="muted" style="font-size:var(--fs-eyebrow);letter-spacing:var(--tk-eyebrow);text-transform:uppercase;margin-bottom:0.75rem;"><?php esc_html_e( 'Call Us Today', 'tfg' ); ?></p>
			<a href="<?php echo esc_url( tfg_phone_link() ); ?>" class="tfg-text-link" style="font-family:var(--font-display);font-size:1.75rem;"><?php echo esc_html( tfg_phone() ); ?></a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
