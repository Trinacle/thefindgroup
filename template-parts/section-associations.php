<?php
/**
 * Home section: Associations (trust strip) with logos.
 *
 * @package TFG
 */
?>
<section class="tfg-trust" id="associations">
	<div class="container">
		<div class="text-center" style="margin-bottom:2.5rem;">
			<span class="eyebrow eyebrow--bare" style="justify-content:center;"><?php esc_html_e( 'Associations We Belong To', 'tfg' ); ?></span>
		</div>
		<div class="tfg-trust__grid">
			<?php foreach ( tfg_associations() as $a ) : $img = TFG_URI . '/assets/img/associations/' . $a[2]; ?>
				<div class="tfg-trust__item">
					<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $a[0] ); ?>" class="tfg-trust__logo" loading="lazy">
					<span class="tfg-trust__name"><?php echo esc_html( $a[0] ); ?></span>
					<span class="tfg-trust__desc"><?php echo esc_html( $a[1] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
