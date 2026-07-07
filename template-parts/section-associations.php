<?php
/**
 * Home section: Associations (trust strip).
 *
 * @package TFG
 */
?>
<section class="tfg-trust" id="associations">
	<div class="container">
		<div class="text-center" style="margin-bottom:2rem;" data-reveal>
			<span class="eyebrow eyebrow--bare" style="justify-content:center;"><?php esc_html_e( 'Associations We Belong To', 'tfg' ); ?></span>
		</div>
		<div class="tfg-trust__grid" data-reveal>
			<?php foreach ( tfg_associations() as $a ) : ?>
				<div class="tfg-trust__item">
					<span class="tfg-trust__name"><?php echo esc_html( $a[0] ); ?></span>
					<span class="tfg-trust__desc"><?php echo esc_html( $a[1] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
