<?php
/**
 * Home section: Featured Categories — redesigned editorial layout.
 * A large featured card + 3 smaller cards, more magazine-like than a flat grid.
 *
 * @package TFG
 */

$cats = tfg_categories();
if ( ! $cats ) return;

// Split: first category is the hero card, rest are side cards.
$hero  = $cats[0];
$sides = array_slice( $cats, 1 );
?>

<section class="section band--dark band--border-bottom" id="categories">
	<div class="container">

		<div class="section__head" style="display:flex;justify-content:space-between;align-items:flex-end;gap:2rem;flex-wrap:wrap;">
			<div>
				<span class="eyebrow"><?php esc_html_e( '01 — The Collection', 'tfg' ); ?></span>
				<h2><?php esc_html_e( 'Four disciplines. One standard.', 'tfg' ); ?></h2>
			</div>
			<p class="lead" style="max-width:42ch;margin:0;"><?php esc_html_e( 'From superyachts to private aviation, each division is led by specialists with decades of experience and a network that spans the globe.', 'tfg' ); ?></p>
		</div>

		<div class="tfg-cats-feature">
			<!-- Hero card (Yachts) -->
			<a href="<?php echo esc_url( $hero['link'] ); ?>" class="tfg-cat-feature">
				<img src="<?php echo esc_url( $hero['img'] ); ?>" alt="<?php echo esc_attr( $hero['name'] ); ?>" class="tfg-cat-feature__img" loading="lazy">
				<span class="tfg-cat-feature__overlay" aria-hidden="true"></span>
				<span class="tfg-cat-feature__arrow" aria-hidden="true">↗</span>
				<span class="tfg-cat-feature__label">
					<span class="tfg-cat-feature__num">01</span>
					<span class="tfg-cat-feature__name"><?php echo esc_html( $hero['name'] ); ?></span>
					<?php if ( ! empty( $hero['count'] ) ) : ?>
						<span class="tfg-cat-feature__count"><?php printf( esc_html( _n( '%s listing', '%s listings', $hero['count'], 'tfg' ) ), esc_html( number_format_i18n( $hero['count'] ) ) ); ?></span>
					<?php endif; ?>
				</span>
			</a>

			<!-- Side cards -->
			<div class="tfg-cats-side">
				<?php foreach ( $sides as $i => $cat ) : $num = str_pad( $i + 2, 2, '0', STR_PAD_LEFT ); ?>
					<a href="<?php echo esc_url( $cat['link'] ); ?>" class="tfg-cat-card">
						<img src="<?php echo esc_url( $cat['img'] ); ?>" alt="<?php echo esc_attr( $cat['name'] ); ?>" class="tfg-cat-card__img" loading="lazy">
						<span class="tfg-cat-card__overlay" aria-hidden="true"></span>
						<span class="tfg-cat-card__arrow" aria-hidden="true">↗</span>
						<span class="tfg-cat-card__label">
							<span class="tfg-cat-card__num"><?php echo esc_html( $num ); ?></span>
							<span class="tfg-cat-card__name"><?php echo esc_html( $cat['name'] ); ?></span>
							<?php if ( ! empty( $cat['count'] ) ) : ?>
								<span class="tfg-cat-card__count"><?php printf( esc_html( _n( '%s listing', '%s listings', $cat['count'], 'tfg' ) ), esc_html( number_format_i18n( $cat['count'] ) ) ); ?></span>
							<?php endif; ?>
						</span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>

	</div>
</section>
