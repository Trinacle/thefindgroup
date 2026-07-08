<?php
/**
 * The template for displaying archive pages (categories, tags, custom tax,
 * author, date, or CPT archives like team_member/office).
 *
 * @package TFG
 */

get_header();
?>

<section class="section" style="padding-top:calc(var(--header-h) + clamp(3rem,8vh,6rem));">
	<div class="container">

		<?php if ( have_posts() ) : ?>

			<header class="section__head" data-reveal>
				<?php
				the_archive_title( '<span class="eyebrow">', '</span>' );
				the_archive_description( '<p class="lead" style="margin-top:1.5rem;">', '</p>' );
				?>
			</header>

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
				<h2><?php esc_html_e( 'No content in this archive.', 'tfg' ); ?></h2>
			</header>

		<?php endif; ?>

	</div>
</section>

<?php
get_footer();
