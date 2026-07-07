<?php
/**
 * Footer — brandmark, newsletter, columns, social, theme toggle, live chat FAB.
 *
 * @package TFG
 */
?>
</main><!-- #main -->

<footer class="tfg-footer" id="colophon">

	<!-- Top: brandmark + newsletter -->
	<div class="container">
		<div class="tfg-footer__top">
			<div>
				<div class="tfg-footer__brandmark">THE FINDGROUP<sup style="font-size:0.4em;color:var(--silver-bright)">™</sup></div>
				<p class="tfg-footer__tag"><?php esc_html_e( 'Selling Luxury Assets Since 1985. Yachts, Real Estate, Aircraft & Armored Luxury Vehicles — privately connecting buyers and sellers across six continents.', 'tfg' ); ?></p>
			</div>
			<div>
				<h4 class="eyebrow eyebrow--bare" style="margin-bottom:1.25rem;"><?php esc_html_e( 'Weekly Luxury Newsletter', 'tfg' ); ?></h4>
				<p style="font-size:var(--fs-small);color:var(--ink-soft);margin-bottom:1.25rem;max-width:32ch;"><?php esc_html_e( 'A curated selection of what is trending in luxury — listings, inside stories and tips from our specialists.', 'tfg' ); ?></p>
				<form class="tfg-newsletter" data-newsletter>
					<label class="sr-only" for="tfg-newsletter-email"><?php esc_html_e( 'Email address', 'tfg' ); ?></label>
					<input type="email" id="tfg-newsletter-email" name="email" placeholder="<?php esc_attr_e( 'Your email address', 'tfg' ); ?>" required>
					<button type="submit" aria-label="<?php esc_attr_e( 'Subscribe', 'tfg' ); ?>">
						<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
					</button>
				</form>
				<p class="tfg-newsletter__msg" style="display:none;"></p>
			</div>
		</div>

		<!-- Columns -->
		<div class="tfg-footer__cols">
			<div class="tfg-footer__col">
				<h4><?php esc_html_e( 'Explore', 'tfg' ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/product-category/yachts/' ) ); ?>"><?php esc_html_e( 'Yachts', 'tfg' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/product-category/real-estate/' ) ); ?>"><?php esc_html_e( 'Real Estate', 'tfg' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/product-category/aircraft/' ) ); ?>"><?php esc_html_e( 'Aircraft', 'tfg' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/product-category/armored-vehicles/' ) ); ?>"><?php esc_html_e( 'Armored Vehicles', 'tfg' ); ?></a></li>
				</ul>
			</div>
			<div class="tfg-footer__col">
				<h4><?php esc_html_e( 'Company', 'tfg' ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About', 'tfg' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/sell-with-us/' ) ); ?>"><?php esc_html_e( 'Sell With Us', 'tfg' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'tfg' ); ?></a></li>
				</ul>
			</div>
			<div class="tfg-footer__col">
				<h4><?php esc_html_e( 'Offices', 'tfg' ); ?></h4>
				<ul>
					<?php
					$offices = tfg_offices();
					foreach ( $offices as $o ) :
						$phone = get_post_meta( $o->ID, '_tfg_phone', true );
						?>
						<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( $o->post_title ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="tfg-footer__col">
				<h4><?php esc_html_e( 'Connect', 'tfg' ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url( tfg_phone_link() ); ?>"><?php echo esc_html( tfg_phone() ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Send us a message', 'tfg' ); ?></a></li>
				</ul>
				<div class="tfg-footer__social" style="margin-top:1.25rem;">
					<?php $social = tfg_social(); ?>
					<a href="<?php echo esc_url( $social['facebook'] ); ?>" aria-label="<?php esc_attr_e( 'Facebook', 'tfg' ); ?>" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 9h3l1-4h-4V3c0-1 .3-2 2-2h2V-3h-3c-3 0-5 2-5 5v3H7v4h3v9h4z"/></svg></a>
					<a href="<?php echo esc_url( $social['instagram'] ); ?>" aria-label="<?php esc_attr_e( 'Instagram', 'tfg' ); ?>" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="4"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.8" fill="currentColor"/></svg></a>
					<a href="<?php echo esc_url( $social['twitter'] ); ?>" aria-label="<?php esc_attr_e( 'X', 'tfg' ); ?>" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 3h3l-7 8 8 10h-6l-5-6-5 6H3l7-9L2 3h6l4 5z"/></svg></a>
					<a href="<?php echo esc_url( $social['youtube'] ); ?>" aria-label="<?php esc_attr_e( 'YouTube', 'tfg' ); ?>" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 8c0-2-1-3-3-3H5C3 5 2 6 2 8v8c0 2 1 3 3 3h14c2 0 3-1 3-3zm-12 7V9l5 3z"/></svg></a>
				</div>
			</div>
		</div>

		<!-- Bottom -->
		<div class="tfg-footer__bottom">
			<div class="tfg-footer__copy"><?php esc_html_e( '© THE FINDGROUP, INC. — All Rights Reserved', 'tfg' ); ?></div>
			<?php tfg_theme_toggle(); ?>
			<div class="tfg-footer__legal">
				<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy', 'tfg' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms', 'tfg' ); ?></a>
			</div>
		</div>
	</div>
</footer>

<!-- Live chat FAB (fallback; hidden if a real chat snippet is injected) -->
<button class="tfg-chat-fab" aria-label="<?php esc_attr_e( 'Open live chat', 'tfg' ); ?>">
	<span class="tfg-chat-fab__dot" aria-hidden="true"></span>
	<span><?php esc_html_e( 'Live Chat', 'tfg' ); ?></span>
</button>

<?php wp_footer(); ?>
</body>
</html>
