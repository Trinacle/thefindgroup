<?php
/**
 * Front page — Scroll-Cinema.
 * A sequence of full-screen scenes that snap into place as you scroll.
 *
 * @package TFG
 */

get_header();
?>

<!-- Scroll progress bar -->
<div class="tfg-scroll-progress" aria-hidden="true"></div>

<!-- Scene navigation dots (desktop) -->
<nav class="tfg-scene-dots" aria-label="<?php esc_attr_e( 'Scene navigation', 'tfg' ); ?>">
	<button class="tfg-scene-dot is-active" data-scene-target="hero" aria-label="<?php esc_attr_e( 'Hero', 'tfg' ); ?>"></button>
	<button class="tfg-scene-dot" data-scene-target="collection" aria-label="<?php esc_attr_e( 'Collection', 'tfg' ); ?>"></button>
	<button class="tfg-scene-dot" data-scene-target="trending" aria-label="<?php esc_attr_e( 'Trending', 'tfg' ); ?>"></button>
	<button class="tfg-scene-dot" data-scene-target="statement" aria-label="<?php esc_attr_e( 'Statement', 'tfg' ); ?>"></button>
	<button class="tfg-scene-dot" data-scene-target="numbers" aria-label="<?php esc_attr_e( 'Numbers', 'tfg' ); ?>"></button>
	<button class="tfg-scene-dot" data-scene-target="why" aria-label="<?php esc_attr_e( 'Why Sell', 'tfg' ); ?>"></button>
	<button class="tfg-scene-dot" data-scene-target="closing" aria-label="<?php esc_attr_e( 'Contact', 'tfg' ); ?>"></button>
</nav>

<main class="tfg-cinema">

	<!-- SCENE 1: HERO -->
	<section class="cinema-scene cinema-scene--hero" data-scene="hero">
		<?php get_template_part( 'template-parts/scene', 'hero' ); ?>
	</section>

	<!-- SCENE 2: THE COLLECTION -->
	<section class="cinema-scene" data-scene="collection" id="collection">
		<?php get_template_part( 'template-parts/scene', 'categories' ); ?>
	</section>

	<!-- SCENE 3: TRENDING -->
	<section class="cinema-scene" data-scene="trending" id="trending">
		<?php get_template_part( 'template-parts/scene', 'trending' ); ?>
	</section>

	<!-- SCENE 4: THE STATEMENT -->
	<section class="cinema-scene" data-scene="statement" id="statement">
		<?php get_template_part( 'template-parts/scene', 'statement' ); ?>
	</section>

	<!-- SCENE 5: THE NUMBERS -->
	<section class="cinema-scene" data-scene="numbers" id="numbers">
		<?php get_template_part( 'template-parts/scene', 'stats' ); ?>
	</section>

	<!-- SCENE 6: WHY SELL -->
	<section class="cinema-scene" data-scene="why" id="why">
		<?php get_template_part( 'template-parts/scene', 'why-sell' ); ?>
	</section>

	<!-- SCENE 7: THE TEAM -->
	<section class="cinema-scene" data-scene="team" id="team">
		<?php get_template_part( 'template-parts/scene', 'team-teaser' ); ?>
	</section>

	<!-- SCENE 8: ASSOCIATIONS -->
	<section class="cinema-scene cinema-scene--sm" id="associations">
		<?php get_template_part( 'template-parts/scene', 'associations' ); ?>
	</section>

	<!-- SCENE 9: CLOSING CTA -->
	<section class="cinema-scene cinema-scene--hero" data-scene="closing" id="closing">
		<?php get_template_part( 'template-parts/scene', 'closing-cta' ); ?>
	</section>

</main>

<?php
get_footer();
