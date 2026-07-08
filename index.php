<?php
/**
 * The main template file — the fallback for any query that doesn't match a
 * more specific template (front-page.php, page-{slug}.php, single.php, etc.).
 *
 * REQUIRED by WordPress — without index.php the theme is marked "incomplete".
 * In practice this theme uses front-page.php for the home view and a suite of
 * page-{name}.php templates for the inner pages. This file catches anything
 * else (e.g. a blog posts index, an unknown page slug) and renders it cleanly
 * using the luxury design system.
 *
 * @package TFG
 */

get_header();
?>

<section class="section" style="padding-top:calc(var(--header-h) + clamp(3rem,8vh,6rem));">
	<div class="container">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header class="tfg-page-header" style="border-bottom:0;padding:0 0 2.5rem;" data-reveal>
					<span class="eyebrow"><?php esc_html_e( 'Journal', 'tfg' ); ?></span>
					<h1><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<div class="tfg-products-grid" data-reveal-stagger>
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<a href="<?php the_permalink(); ?>" class="tfg-listing-card">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="tfg-listing-card__media">
								<?php the_post_thumbnail( 'tfg-listing', array( 'class' => 'tfg-listing-card__img', 'loading' => 'lazy' ) ); ?>
							</div>
						<?php endif; ?>
						<div class="tfg-listing-card__body">
							<span class="tfg-listing-card__cat eyebrow eyebrow--bare"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
							<h3 class="tfg-listing-card__title"><?php the_title(); ?></h3>
							<div class="tfg-listing-card__specs"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18, '…' ) ); ?></div>
							<span class="tfg-listing-card__cta"><?php esc_html_e( 'View', 'tfg' ); ?> <span aria-hidden="true">→</span></span>
						</div>
					</a>
					<?php
				endwhile;
				?>
			</div>

			<div class="tfg-pagination">
				<?php
				echo paginate_links( array( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'prev_text' => '←',
					'next_text' => '→',
				) );
				?>
			</div>

		<?php else : ?>

			<header class="section__head" data-reveal>
				<span class="eyebrow"><?php esc_html_e( 'Nothing Found', 'tfg' ); ?></span>
				<h2><?php esc_html_e( 'No content matches this view.', 'tfg' ); ?></h2>
				<p class="lead"><?php esc_html_e( 'Try the search, or browse our categories below.', 'tfg' ); ?></p>
			</header>

			<?php get_search_form(); ?>

			<div class="tfg-categories" style="margin-top:3rem;">
				<?php foreach ( tfg_categories() as $cat ) : ?>
					<a href="<?php echo esc_url( $cat['link'] ); ?>" class="tfg-cat-card" data-magnetic>
						<img src="<?php echo esc_url( $cat['img'] ); ?>" alt="<?php echo esc_attr( $cat['name'] ); ?>" class="tfg-cat-card__img" loading="lazy">
						<span class="tfg-cat-card__overlay" aria-hidden="true"></span>
						<span class="tfg-cat-card__label">
							<span class="tfg-cat-card__name"><?php echo esc_html( $cat['name'] ); ?></span>
						</span>
					</a>
				<?php endforeach; ?>
			</div>

		<?php endif; ?>

	</div>
</section>

<?php
get_footer();
