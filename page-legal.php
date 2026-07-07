<?php
/**
 * Template Name: Legal (Privacy / Terms)
 * Long-form narrow column with sticky table of contents.
 *
 * @package TFG
 */

get_header();

// Auto-generate a TOC from the page's H2s.
$content = get_the_content();
$toc = array();
if ( preg_match_all( '/<h2[^>]*>(.*?)<\/h2>/i', $content, $m ) ) {
	foreach ( $m[1] as $i => $title ) {
		$slug = 'section-' . ( $i + 1 );
		$toc[ $slug ] = wp_strip_all_tags( $title );
	}
}
?>

<section class="tfg-legal">
	<div class="container">
		<div class="tfg-legal__layout">

			<?php if ( $toc ) : ?>
				<aside class="tfg-legal__toc">
					<h4><?php esc_html_e( 'On this page', 'tfg' ); ?></h4>
					<ul>
						<?php foreach ( $toc as $slug => $title ) : ?>
							<li><a href="#<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $title ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</aside>
			<?php endif; ?>

			<div class="tfg-legal__content">
				<span class="eyebrow" style="margin-bottom:1.5rem;display:inline-flex;"><?php echo esc_html( get_the_title() ); ?></span>
				<?php
				// Inject IDs into H2s for TOC anchors.
				$content = get_the_content();
				$i = 0;
				$content = preg_replace_callback( '/<h2([^>]*)>(.*?)<\/h2>/i', function( $m ) use ( &$i ) {
					$i++;
					return '<h2' . $m[1] . ' id="section-' . $i . '">' . $m[2] . '</h2>';
				}, $content );
				echo apply_filters( 'the_content', $content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</div>

		</div>
	</div>
</section>

<?php get_footer(); ?>
