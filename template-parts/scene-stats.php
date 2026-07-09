<?php
/**
 * SCENE 5: THE NUMBERS — count-up stats on full-bleed dark band.
 * Numbers animate from 0 to final value via cinema.js IntersectionObserver.
 *
 * @package TFG
 */
?>
<div class="band--dark" style="width:100%;">
	<div class="container section">
		<div class="section__head text-center" data-reveal style="justify-items:center;margin-bottom:clamp(2.5rem,5vh,4rem);">
			<span class="eyebrow eyebrow--bare" style="justify-content:center;"><?php esc_html_e( '04 — By the Numbers', 'tfg' ); ?></span>
			<h2 style="margin-inline:auto;max-width:18ch;"><?php esc_html_e( 'Four decades. Six continents. One standard.', 'tfg' ); ?></h2>
		</div>
		<div class="tfg-stats" data-reveal-stagger>
			<?php foreach ( tfg_stats() as $stat ) : ?>
				<div class="tfg-stat">
					<div class="tfg-stat__num" data-countup="<?php echo esc_attr( $stat[0] ); ?>"><?php echo esc_html( $stat[0] ); ?></div>
					<div class="tfg-stat__label"><?php echo esc_html( $stat[1] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
