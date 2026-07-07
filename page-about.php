<?php
/**
 * Template Name: About
 * Magazine narrative — three-act editorial + 3-col + full team grid.
 *
 * @package TFG
 */

get_header();
?>

<!-- Hero -->
<section class="tfg-hero tfg-hero--slim">
	<div class="tfg-hero__media">
		<img src="<?php echo esc_url( TFG_URI . '/assets/img/about-hero.jpg' ); ?>" alt="<?php esc_attr_e( 'THE FINDGROUP', 'tfg' ); ?>" loading="eager">
	</div>
	<div class="tfg-hero__inner">
		<span class="eyebrow tfg-hero__eyebrow" data-reveal><?php esc_html_e( 'About The FindGroup', 'tfg' ); ?></span>
		<h1 class="tfg-hero__title" style="font-size:var(--fs-h1);" data-reveal><?php esc_html_e( 'Privately connecting buyers & sellers.', 'tfg' ); ?></h1>
		<p class="tfg-hero__sub" data-reveal><?php esc_html_e( 'A full-service luxury brokerage merging yachting, real estate, aviation and armored vehicle specialists into one organization since 1985.', 'tfg' ); ?></p>
	</div>
</section>

<!-- Three-act editorial -->
<section class="section">
	<div class="container">

		<div class="tfg-act" data-reveal>
			<div class="tfg-act__media" data-reveal-img>
				<img src="<?php echo esc_url( TFG_URI . '/assets/img/about-who.jpg' ); ?>" alt="<?php esc_attr_e( 'Luxury yacht', 'tfg' ); ?>" loading="lazy">
			</div>
			<div class="tfg-act__content">
				<span class="eyebrow"><?php esc_html_e( 'Who We Are', 'tfg' ); ?></span>
				<h3><?php esc_html_e( 'A high level of experience, on and off market.', 'tfg' ); ?></h3>
				<p><?php esc_html_e( 'THE FINDGROUP offers a high level of experience in marketing, listing, selling and closing both off- and on-market luxury assets. As our clients demanded additional services and assets, the vision developed into merging luxury industry experts into one full-service organization offering clients access to one Group.', 'tfg' ); ?></p>
			</div>
		</div>

		<div class="tfg-act" data-reveal>
			<div class="tfg-act__media" data-reveal-img>
				<img src="<?php echo esc_url( TFG_URI . '/assets/img/about-experts.jpg' ); ?>" alt="<?php esc_attr_e( 'Luxury real estate', 'tfg' ); ?>" loading="lazy">
			</div>
			<div class="tfg-act__content">
				<span class="eyebrow"><?php esc_html_e( 'Experts in Luxury', 'tfg' ); ?></span>
				<h3><?php esc_html_e( 'Founded by entrepreneurs with 40 years of experience.', 'tfg' ); ?></h3>
				<p><?php esc_html_e( 'THE FINDGROUP was founded by a group of entrepreneurs with experience dating back 35 years in their respective industries — selling, brokering and delivering yachts, luxury and commercial real estate, jets and armored luxury vehicles.', 'tfg' ); ?></p>
			</div>
		</div>

		<div class="tfg-act" data-reveal>
			<div class="tfg-act__media" data-reveal-img>
				<img src="<?php echo esc_url( TFG_URI . '/assets/img/about-private.jpg' ); ?>" alt="<?php esc_attr_e( 'Private consultation', 'tfg' ); ?>" loading="lazy">
			</div>
			<div class="tfg-act__content">
				<span class="eyebrow"><?php esc_html_e( 'Private & Confidential', 'tfg' ); ?></span>
				<h3><?php esc_html_e( 'An exclusive international network, curated over decades.', 'tfg' ); ?></h3>
				<p><?php esc_html_e( 'Some assets are unique and not available in the mainstream marketplace. THE FINDGROUP privately and confidentially connects buyers and sellers through an expansive international network curated throughout our years of experience — including industry expert attorneys and tax specialists.', 'tfg' ); ?></p>
			</div>
		</div>

	</div>
</section>

<!-- 3-column: Real Estate Sales / Global Media / Intl Marketing -->
<section class="section band--surface">
	<div class="container">
		<div class="section__head" data-reveal>
			<span class="eyebrow"><?php esc_html_e( 'Capabilities', 'tfg' ); ?></span>
			<h2><?php esc_html_e( 'Reach that spans markets and media.', 'tfg' ); ?></h2>
		</div>
		<div class="tfg-three-col" data-reveal-stagger>
			<div class="tfg-three-col__item">
				<h3><?php esc_html_e( 'Real Estate Sales', 'tfg' ); ?></h3>
				<p><?php esc_html_e( 'Delivering large networks of premier real estate — on and off market — and attracting a global audience in luxury residential, hotels and commercial opportunities. Over 25 years of real estate experience with in-depth knowledge and connections across investments.', 'tfg' ); ?></p>
			</div>
			<div class="tfg-three-col__item">
				<h3><?php esc_html_e( 'Global Media Partnerships', 'tfg' ); ?></h3>
				<p><?php esc_html_e( 'A brand marketing strategy built on quality content across multiple platforms — brand exclusivity, cutting-edge advertising technologies, strategic positioning, social traffic drivers and video content integration with media powerhouses of international impact.', 'tfg' ); ?></p>
			</div>
			<div class="tfg-three-col__item">
				<h3><?php esc_html_e( 'International Marketing', 'tfg' ); ?></h3>
				<p><?php esc_html_e( 'Properties distributed to the most influential publications in the world — The New York Times, Wall Street Journal, Financial Times, Ocean Home, Bloomberg Markets, Robb Report, Reside and more.', 'tfg' ); ?></p>
			</div>
		</div>
	</div>
</section>

<!-- Team grid -->
<section class="section" id="team">
	<div class="container">
		<div class="section__head" data-reveal>
			<span class="eyebrow"><?php esc_html_e( 'Dedicated Team', 'tfg' ); ?></span>
			<h2><?php esc_html_e( 'Meeting client needs with excellence.', 'tfg' ); ?></h2>
			<p class="lead"><?php esc_html_e( 'Our marketing achievements stem from a dedicated and hardworking team committed to excellence. We hire the best talent, foster reliability, and consistently deliver on promises.', 'tfg' ); ?></p>
		</div>

		<div class="tfg-team-grid" data-reveal-stagger>
			<?php foreach ( tfg_team() as $m ) : $role = get_post_meta( $m->ID, '_tfg_role', true ); $creds = get_post_meta( $m->ID, '_tfg_credentials', true ); ?>
				<div class="tfg-team-card">
					<div class="tfg-team-card__media">
						<?php if ( has_post_thumbnail( $m->ID ) ) echo get_the_post_thumbnail( $m->ID, 'tfg-card', array( 'alt' => esc_attr( $m->post_title ) ) ); ?>
					</div>
					<div class="tfg-team-card__name"><?php echo esc_html( $m->post_title ); ?></div>
					<div class="tfg-team-card__role"><?php echo esc_html( $role ); ?></div>
					<?php if ( $creds ) : ?><div class="tfg-team-card__creds"><?php echo esc_html( $creds ); ?></div><?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Associations -->
<?php get_template_part( 'template-parts/section', 'associations' ); ?>

<!-- CTA -->
<section class="tfg-cta-band">
	<div class="tfg-cta-band__bg" aria-hidden="true"><img src="<?php echo esc_url( TFG_URI . '/assets/img/cta-yacht-dusk.jpg' ); ?>" alt="" loading="lazy"></div>
	<div class="tfg-cta-band__inner container container--narrow" data-reveal>
		<h2 class="text-center"><?php esc_html_e( 'Sell your assets with us.', 'tfg' ); ?></h2>
		<div class="tfg-cta-band__actions">
			<a href="<?php echo esc_url( home_url( '/sell-with-us/' ) ); ?>" class="tfg-btn tfg-btn--primary" data-magnetic><?php esc_html_e( 'Sell With Us', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="tfg-btn tfg-btn--ghost" data-magnetic><?php esc_html_e( 'Contact', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
