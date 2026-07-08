<?php
/**
 * Header — fixed transparent→solid, mega-menu, mobile overlay, search.
 *
 * @package TFG
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="dark">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link sr-only" href="#main"><?php esc_html_e( 'Skip to content', 'tfg' ); ?></a>

<header class="tfg-header" id="masthead">
	<div class="tfg-header__inner">

		<!-- Wordmark -->
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tfg-brand" aria-label="<?php esc_attr_e( 'THE FINDGROUP home', 'tfg' ); ?>">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				echo '<span>THE FINDGROUP<sup>™</sup></span>';
			}
			?>
		</a>

		<!-- Primary nav -->
		<nav class="tfg-nav" aria-label="<?php esc_attr_e( 'Primary', 'tfg' ); ?>">
			<div class="tfg-nav__item">
				<a href="<?php echo esc_url( home_url( '/product-category/real-estate/' ) ); ?>" class="tfg-nav__link"><?php esc_html_e( 'Real Estate', 'tfg' ); ?> <span class="tfg-nav__chev" aria-hidden="true">▾</span></a>
				<div class="tfg-mega">
					<a href="<?php echo esc_url( home_url( '/product-category/real-estate/?type=residential' ) ); ?>"><?php esc_html_e( 'Residential', 'tfg' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/product-category/real-estate/?type=commercial' ) ); ?>"><?php esc_html_e( 'Commercial', 'tfg' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/product-category/real-estate/?type=auctions' ) ); ?>"><?php esc_html_e( 'Auctions', 'tfg' ); ?></a>
				</div>
			</div>

			<div class="tfg-nav__item">
				<a href="<?php echo esc_url( home_url( '/product-category/yachts/' ) ); ?>" class="tfg-nav__link"><?php esc_html_e( 'Yachts', 'tfg' ); ?> <span class="tfg-nav__chev" aria-hidden="true">▾</span></a>
				<div class="tfg-mega">
					<a href="<?php echo esc_url( home_url( '/product-category/yachts/?condition=pre-owned' ) ); ?>"><?php esc_html_e( 'Pre-Owned Yachts', 'tfg' ); ?></a>
					<div class="tfg-mega__group">
						<a href="<?php echo esc_url( home_url( '/product-category/yachts/?brand=gulf-craft' ) ); ?>"><?php esc_html_e( 'Gulf Craft', 'tfg' ); ?></a>
						<div class="tfg-mega__sub">
							<a href="<?php echo esc_url( home_url( '/product-category/yachts/?brand=majesty' ) ); ?>"><?php esc_html_e( 'Majesty Yachts', 'tfg' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/product-category/yachts/?brand=nomad' ) ); ?>"><?php esc_html_e( 'Nomad Yachts', 'tfg' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/product-category/yachts/?brand=silvercat' ) ); ?>"><?php esc_html_e( 'SilverCat', 'tfg' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/product-category/yachts/?brand=silvercraft' ) ); ?>"><?php esc_html_e( 'Silvercraft', 'tfg' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/product-category/yachts/?brand=oryx' ) ); ?>"><?php esc_html_e( 'ORYX Sport Cruisers', 'tfg' ); ?></a>
						</div>
					</div>
					<a href="<?php echo esc_url( home_url( '/product-category/yachts/?brand=silent-yachts' ) ); ?>"><?php esc_html_e( 'Silent Yachts', 'tfg' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/product-category/yachts/?type=charter' ) ); ?>"><?php esc_html_e( 'Yacht Charters', 'tfg' ); ?></a>
				</div>
			</div>

			<div class="tfg-nav__item">
				<a href="<?php echo esc_url( home_url( '/product-category/aircraft/' ) ); ?>" class="tfg-nav__link"><?php esc_html_e( 'Aircraft', 'tfg' ); ?></a>
			</div>

			<div class="tfg-nav__item">
				<a href="<?php echo esc_url( home_url( '/product-category/armored-vehicles/' ) ); ?>" class="tfg-nav__link"><?php esc_html_e( 'Armored Vehicles', 'tfg' ); ?></a>
			</div>

			<div class="tfg-nav__item">
				<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="tfg-nav__link"><?php esc_html_e( 'About', 'tfg' ); ?></a>
			</div>

			<div class="tfg-nav__item">
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="tfg-nav__link"><?php esc_html_e( 'Contact', 'tfg' ); ?></a>
			</div>
		</nav>

		<!-- Utilities -->
		<div class="tfg-header__utils">
			<button class="tfg-search-btn" aria-label="<?php esc_attr_e( 'Search', 'tfg' ); ?>" data-search-open>
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
			</button>

			<div class="tfg-header__cta">
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="tfg-text-link"><?php esc_html_e( 'Contact', 'tfg' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/sell-with-us/' ) ); ?>" class="tfg-btn tfg-btn--primary" data-magnetic><?php esc_html_e( 'Sell With Us', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
			</div>

			<button class="tfg-burger" aria-label="<?php esc_attr_e( 'Menu', 'tfg' ); ?>" aria-expanded="false">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>

<!-- Mobile overlay menu -->
<div class="tfg-mobile-menu" aria-hidden="true">
	<nav class="tfg-mobile-menu__nav">
		<div class="tfg-mobile-menu__item">
			<a href="<?php echo esc_url( home_url( '/product-category/real-estate/' ) ); ?>" class="tfg-mobile-menu__link"><?php esc_html_e( 'Real Estate', 'tfg' ); ?> <span class="tfg-mobile-menu__toggle">+</span></a>
			<div class="tfg-mobile-menu__sub">
				<a href="<?php echo esc_url( home_url( '/product-category/real-estate/?type=residential' ) ); ?>"><?php esc_html_e( 'Residential', 'tfg' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/product-category/real-estate/?type=commercial' ) ); ?>"><?php esc_html_e( 'Commercial', 'tfg' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/product-category/real-estate/?type=auctions' ) ); ?>"><?php esc_html_e( 'Auctions', 'tfg' ); ?></a>
			</div>
		</div>
		<div class="tfg-mobile-menu__item">
			<a href="<?php echo esc_url( home_url( '/product-category/yachts/' ) ); ?>" class="tfg-mobile-menu__link"><?php esc_html_e( 'Yachts', 'tfg' ); ?> <span class="tfg-mobile-menu__toggle">+</span></a>
			<div class="tfg-mobile-menu__sub">
				<a href="<?php echo esc_url( home_url( '/product-category/yachts/?condition=pre-owned' ) ); ?>"><?php esc_html_e( 'Pre-Owned Yachts', 'tfg' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/product-category/yachts/?brand=gulf-craft' ) ); ?>"><?php esc_html_e( 'Gulf Craft', 'tfg' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/product-category/yachts/?brand=majesty' ) ); ?>"><?php esc_html_e( 'Majesty', 'tfg' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/product-category/yachts/?brand=nomad' ) ); ?>"><?php esc_html_e( 'Nomad', 'tfg' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/product-category/yachts/?brand=silent-yachts' ) ); ?>"><?php esc_html_e( 'Silent Yachts', 'tfg' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/product-category/yachts/?type=charter' ) ); ?>"><?php esc_html_e( 'Charters', 'tfg' ); ?></a>
			</div>
		</div>
		<a href="<?php echo esc_url( home_url( '/product-category/aircraft/' ) ); ?>" class="tfg-mobile-menu__link"><?php esc_html_e( 'Aircraft', 'tfg' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/product-category/armored-vehicles/' ) ); ?>" class="tfg-mobile-menu__link"><?php esc_html_e( 'Armored Vehicles', 'tfg' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="tfg-mobile-menu__link"><?php esc_html_e( 'About', 'tfg' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="tfg-mobile-menu__link"><?php esc_html_e( 'Contact', 'tfg' ); ?></a>
	</nav>
	<div class="tfg-mobile-menu__cta">
		<a href="<?php echo esc_url( home_url( '/sell-with-us/' ) ); ?>" class="tfg-btn tfg-btn--primary tfg-btn--block"><?php esc_html_e( 'Sell With Us', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
		<a href="<?php echo esc_url( tfg_phone_link() ); ?>" class="tfg-btn tfg-btn--ghost tfg-btn--block"><?php echo esc_html( tfg_phone() ); ?></a>
	</div>
	<div class="tfg-mobile-menu__phone"><?php echo esc_html( tfg_phone() ); ?></div>
</div>

<!-- Search overlay -->
<div class="tfg-search-overlay" aria-hidden="true">
	<button class="tfg-search-overlay__close"><?php esc_html_e( 'Close', 'tfg' ); ?> ✕</button>
	<div class="tfg-search-overlay__inner">
		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="sr-only" for="tfg-search-input"><?php esc_html_e( 'Search', 'tfg' ); ?></label>
			<input type="search" id="tfg-search-input" name="s" placeholder="<?php esc_attr_e( 'Search listings, locations, brands…', 'tfg' ); ?>" autocomplete="off">
			<input type="hidden" name="post_type" value="product">
		</form>
		<p class="tfg-search-overlay__hint"><?php esc_html_e( 'Press enter to search across all listings and pages.', 'tfg' ); ?></p>
	</div>
</div>

<main id="main">
