<?php
/**
 * Pagination — slim hairline style.
 *
 * @package TFG
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}
?>
<nav class="tfg-pagination" aria-label="<?php esc_attr_e( 'Listings pagination', 'tfg' ); ?>">
	<?php
	echo paginate_links( array( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'base'      => $base,
		'format'    => $format,
		'total'     => $total,
		'current'   => max( 1, $current ),
		'prev_text' => '←',
		'next_text' => '→',
		'type'      => 'list',
	) );
	?>
</nav>
