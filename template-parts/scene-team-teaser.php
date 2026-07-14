<?php
/**
 * SCENE 7: THE TEAM — diptych teaser + roster link.
 *
 * @package TFG
 */
$team = tfg_team();
$leaders = array_slice( $team, 0, 2 );
if ( ! $leaders ) return;
?>
<div class="band--dark" style="width:100%;">
	<div class="container section">
		<div class="section__head" data-reveal>
			<span class="eyebrow"><?php esc_html_e( '06 — The Specialists', 'tfg' ); ?></span>
			<h2><?php esc_html_e( 'Decades of experience. One dedicated team.', 'tfg' ); ?></h2>
		</div>

		<div class="tfg-diptych" data-reveal-stagger>
			<?php foreach ( $leaders as $m ) :
				$role = get_post_meta( $m->ID, '_tfg_role', true );
				// Map known leaders to their headshot assets (until WP media library is wired).
				$photo = '';
				$slug  = sanitize_title( $m->post_title );
				if ( file_exists( TFG_DIR . '/assets/team/' . $slug . '.jpg' ) ) {
					$photo = TFG_URI . '/assets/team/' . $slug . '.jpg';
				}
			?>
				<div class="tfg-diptych__panel">
					<?php if ( $photo ) : ?>
						<img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $m->post_title ); ?>" loading="lazy">
					<?php elseif ( has_post_thumbnail( $m->ID ) ) : ?>
						<?php echo get_the_post_thumbnail( $m->ID, 'tfg-card', array( 'alt' => esc_attr( $m->post_title ) ) ); ?>
					<?php endif; ?>
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
</div>
