<?php
/**
 * The template for displaying all single posts (blog entries, team members,
 * offices, etc. — anything not handled by single-product.php or a custom
 * page-{name}.php template).
 *
 * @package TFG
 */

get_header();

while ( have_posts() ) :
	the_post();
	$post_type = get_post_type();
	?>

	<section class="section" style="padding-top:calc(var(--header-h) + clamp(3rem,8vh,6rem));">
		<div class="container">

			<?php if ( 'team_member' === $post_type ) : ?>
				<!-- Team member detail -->
				<div class="tfg-split">
					<div class="tfg-split__media" data-reveal-img>
						<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'tfg-card', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
					</div>
					<div class="tfg-split__content" data-reveal>
						<span class="eyebrow"><?php echo esc_html( get_post_meta( get_the_ID(), '_tfg_role', true ) ); ?></span>
						<h1><?php the_title(); ?></h1>
						<?php
						$creds = get_post_meta( get_the_ID(), '_tfg_credentials', true );
						$phone = get_post_meta( get_the_ID(), '_tfg_phone', true );
						$email = get_post_meta( get_the_ID(), '_tfg_email', true );
						if ( $creds ) echo '<p class="lead" style="color:var(--silver-bright);margin-bottom:1.5rem;">' . esc_html( $creds ) . '</p>';
						?>
						<?php the_content(); ?>
						<div class="tfg-split__actions">
							<?php if ( $email ) : ?>
								<a href="mailto:<?php echo esc_attr( $email ); ?>" class="tfg-btn tfg-btn--primary" data-magnetic><?php esc_html_e( 'Contact', 'tfg' ); ?> <?php echo esc_html( get_the_title() ); ?> <span aria-hidden="true">→</span></a>
							<?php endif; ?>
							<a href="<?php echo esc_url( home_url( '/about/#team' ) ); ?>" class="tfg-text-link"><?php esc_html_e( 'Back to team', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
						</div>
					</div>
				</div>

			<?php elseif ( 'office' === $post_type ) : ?>
				<!-- Office detail -->
				<header class="section__head" data-reveal>
					<span class="eyebrow"><?php esc_html_e( 'Office', 'tfg' ); ?></span>
					<h1><?php the_title(); ?></h1>
				</header>
				<div class="tfg-offices" data-reveal>
					<div class="tfg-office">
						<div>
							<div class="tfg-office__city"><?php the_title(); ?></div>
							<?php $addr = get_post_meta( get_the_ID(), '_tfg_address', true ); if ( $addr ) echo '<div class="tfg-office__addr">' . esc_html( $addr ) . '</div>'; ?>
							<?php $map = get_post_meta( get_the_ID(), '_tfg_map', true ); if ( $map ) echo '<a href="' . esc_url( $map ) . '" class="tfg-office__map" target="_blank" rel="noopener">' . esc_html__( 'View on map', 'tfg' ) . ' →</a>'; ?>
						</div>
						<?php $phone = get_post_meta( get_the_ID(), '_tfg_phone', true ); if ( $phone ) echo '<div class="tfg-office__phone"><a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a></div>'; ?>
					</div>
				</div>

			<?php else : ?>
				<!-- Generic single (blog post etc.) -->
				<article class="tfg-legal__content" data-reveal style="max-width:720px;margin-inline:auto;">
					<header class="tfg-page-header" style="border-bottom:0;padding:0 0 2rem;">
						<span class="eyebrow"><?php echo esc_html( get_post_type_object( $post_type )->labels->singular_name ); ?></span>
						<h1><?php the_title(); ?></h1>
						<p class="muted" style="margin-top:0.75rem;font-size:var(--fs-eyebrow);letter-spacing:var(--tk-eyebrow);text-transform:uppercase;"><?php echo esc_html( get_the_date() ); ?></p>
					</header>
					<?php if ( has_post_thumbnail() ) : ?>
						<div style="margin-bottom:2.5rem;" data-reveal-img><?php the_post_thumbnail( 'tfg-wide' ); ?></div>
					<?php endif; ?>
					<?php the_content(); ?>
				</article>
			<?php endif; ?>

		</div>
	</section>

	<?php
endwhile;

get_footer();
