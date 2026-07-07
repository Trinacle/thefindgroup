<?php
/**
 * Search results.
 *
 * @package TFG
 */

get_header();
?>

<section class="section" style="padding-top:calc(var(--header-h) + clamp(3rem,8vh,6rem));">
	<div class="container">
		<header class="section__head" data-reveal>
			<span class="eyebrow"><?php esc_html_e( 'Search Results', 'tfg' ); ?></span>
			<h1><?php printf( esc_html__( 'Results for “%s”', 'tfg' ), esc_html( get_search_query() ) ); ?></h1>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="tfg-products-grid" data-reveal-stagger>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
					if ( 'product' === get_post_type() ) {
						get_template_part( 'template-parts/content', 'listing-card' );
					} else {
						?>
						<a href="<?php the_permalink(); ?>" class="tfg-listing-card">
							<div class="tfg-listing-card__body">
								<span class="tfg-listing-card__cat eyebrow eyebrow--bare"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
								<h3 class="tfg-listing-card__title"><?php the_title(); ?></h3>
								<div class="tfg-listing-card__specs"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18, '…' ) ); ?></div>
								<span class="tfg-listing-card__cta"><?php esc_html_e( 'View', 'tfg' ); ?> <span aria-hidden="true">→</span></span>
							</div>
						</a>
						<?php
					}
					?>
				<?php endwhile; ?>
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
			<p class="lead"><?php esc_html_e( 'No results found. Try a different search term, or browse our categories.', 'tfg' ); ?></p>
			<div class="tfg-hero__actions">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tfg-btn tfg-btn--primary" data-magnetic><?php esc_html_e( 'Return Home', 'tfg' ); ?> <span aria-hidden="true">→</span></a>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
