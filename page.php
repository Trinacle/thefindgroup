<?php
/**
 * Default page template — generic long-form on a narrow column.
 *
 * @package TFG
 */

get_header();
?>

<section class="section" style="padding-top:calc(var(--header-h) + clamp(3rem,8vh,6rem));">
	<div class="container container--narrow">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<header class="tfg-page-header" style="border-bottom:0;padding:0 0 2rem;" data-reveal>
				<h1><?php the_title(); ?></h1>
			</header>
			<div class="tfg-legal__content" data-reveal>
				<?php the_content(); ?>
			</div>
		<?php endwhile; endif; ?>
	</div>
</section>

<?php get_footer(); ?>
