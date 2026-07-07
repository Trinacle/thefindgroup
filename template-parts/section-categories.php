<?php
/**
 * Home section: Featured Categories (4-up grid).
 *
 * @package TFG
 */
?>
<section class="section band--border-bottom" id="categories">
	<div class="container">
		<div class="section__head" data-reveal>
			<span class="eyebrow"><?php esc_html_e( '01 — The Collection', 'tfg' ); ?></span>
			<h2><?php esc_html_e( 'Four disciplines. One standard.', 'tfg' ); ?></h2>
			<p class="lead"><?php esc_html_e( 'From superyachts to private aviation, each division is led by specialists with decades of experience and a network that spans the globe.', 'tfg' ); ?></p>
		</div>

		<div class="tfg-categories" data-reveal-stagger>
			<?php foreach ( tfg_categories() as $cat ) : ?>
				<a href="<?php echo esc_url( $cat['link'] ); ?>" class="tfg-cat-card" data-magnetic>
					<img src="<?php echo esc_url( $cat['img'] ); ?>" alt="<?php echo esc_attr( $cat['name'] ); ?>" class="tfg-cat-card__img" loading="lazy">
					<span class="tfg-cat-card__overlay" aria-hidden="true"></span>
					<span class="tfg-cat-card__arrow" aria-hidden="true">↗</span>
					<span class="tfg-cat-card__label">
						<span class="tfg-cat-card__name"><?php echo esc_html( $cat['name'] ); ?></span>
						<?php if ( ! empty( $cat['count'] ) ) : ?>
							<span class="tfg-cat-card__count"><?php printf( esc_html( _n( '%s listing', '%s listings', $cat['count'], 'tfg' ) ), esc_html( number_format_i18n( $cat['count'] ) ) ); ?></span>
						<?php endif; ?>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
