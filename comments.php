<?php
/**
 * Comments template — minimal luxury styling.
 * Most pages on this site have comments disabled; this exists for completeness.
 *
 * @package TFG
 */

if ( post_password_required() ) {
	return;
}
?>

<section class="section--sm" id="comments">
	<div class="container container--narrow">

		<?php if ( have_comments() ) : ?>
			<h2 class="tfg-section-num" style="margin-bottom:2rem;">
				<?php
				printf(
					/* translators: number of comments */
					esc_html( _n( '%s Comment', '%s Comments', get_comments_number(), 'tfg' ) ),
					esc_html( number_format_i18n( get_comments_number() ) )
				);
				?>
			</h2>

			<ul class="tfg-offices">
				<?php
				wp_list_comments( array(
					'style'      => 'ul',
					'short_ping' => true,
					'avatar_size'=> 0,
				) );
				?>
			</ul>

			<?php the_comments_pagination( array(
				'prev_text' => '←',
				'next_text' => '→',
			) ); ?>

		<?php endif; ?>

		<?php
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
			<p class="muted"><?php esc_html_e( 'Comments are closed.', 'tfg' ); ?></p>
			<?php
		endif;

		comment_form( array(
			'class_form'    => 'tfg-form',
			'class_submit'  => 'tfg-btn tfg-btn--primary',
			'title_reply'   => __( 'Leave a comment', 'tfg' ),
			'label_submit'  => __( 'Post Comment', 'tfg' ) . ' →',
		) );
		?>
	</div>
</section>
