<?php
/**
 * Home section: Authorized Dealer strip (9 brands).
 *
 * @package TFG
 */
?>
<section class="section--sm band--border-top band--border-bottom" id="brands">
	<div class="container">
		<div class="text-center" style="margin-bottom:2rem;" data-reveal>
			<span class="eyebrow eyebrow--bare" style="justify-content:center;"><?php esc_html_e( 'Authorized Dealer for Prestigious Brands', 'tfg' ); ?></span>
		</div>
		<div class="tfg-brands" data-reveal>
			<?php foreach ( tfg_brands() as $brand ) : ?>
				<span class="tfg-brand-logo"><?php echo esc_html( $brand ); ?></span>
			<?php endforeach; ?>
		</div>
		<div class="text-center" style="margin-top:2.5rem;display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;" data-reveal>
			<a href="<?php echo esc_url( home_url( '/product-category/yachts/?condition=new' ) ); ?>" class="tfg-text-link"><?php esc_html_e( 'New Yachts', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
			<a href="<?php echo esc_url( home_url( '/product-category/yachts/?condition=pre-owned' ) ); ?>" class="tfg-text-link"><?php esc_html_e( 'Pre-Owned', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
</section>
