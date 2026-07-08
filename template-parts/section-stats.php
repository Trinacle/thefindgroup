<?php
/**
 * Home section: Stats (7-up grid).
 *
 * @package TFG
 */
?>
<section class="section--sm band--dark" id="stats">
	<div class="container">
		<div class="tfg-stats" data-reveal-stagger>
			<?php foreach ( tfg_stats() as $stat ) : ?>
				<div class="tfg-stat">
					<div class="tfg-stat__num"><?php echo esc_html( $stat[0] ); ?></div>
					<div class="tfg-stat__label"><?php echo esc_html( $stat[1] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
