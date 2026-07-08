<?php
/**
 * Home section: Team teaser (diptych — two portraits + CTA).
 *
 * @package TFG
 */
$team = tfg_team();
$leaders = array_slice( $team, 0, 2 );
if ( ! $leaders ) return;
?>
<section class="section band--dark" id="team">
	<div class="container">
		<div class="section__head" data-reveal>
			<span class="eyebrow"><?php esc_html_e( '05 — The Specialists', 'tfg' ); ?></span>
			<h2><?php esc_html_e( 'Decades of experience. One dedicated team.', 'tfg' ); ?></h2>
		</div>

		<div class="tfg-diptych" data-reveal>
			<?php foreach ( $leaders as $m ) : $role = get_post_meta( $m->ID, '_tfg_role', true ); ?>
				<div class="tfg-diptych__panel">
					<?php if ( has_post_thumbnail( $m->ID ) ) echo get_the_post_thumbnail( $m->ID, 'tfg-card', array( 'alt' => esc_attr( $m->post_title ) ) ); ?>
					<div class="tfg-diptych__caption">
						<span class="eyebrow eyebrow--bare"><?php echo esc_html( $role ); ?></span>
						<h3><?php echo esc_html( $m->post_title ); ?></h3>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="text-center" style="margin-top:clamp(2.5rem,5vh,4rem);" data-reveal>
			<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="tfg-text-link"><?php esc_html_e( 'Meet the full team', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
</section>
