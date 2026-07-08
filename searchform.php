<?php
/**
 * Custom search form — hairline-styled to match the design system.
 *
 * @package TFG
 */
?>
<form role="search" method="get" class="tfg-newsletter" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="max-width:480px;margin-top:1.5rem;">
	<label class="sr-only" for="tfg-search-<?php echo esc_attr( uniqid() ); ?>"><?php esc_html_e( 'Search', 'tfg' ); ?></label>
	<input type="search" id="tfg-search-<?php echo esc_attr( uniqid() ); ?>" class="tfg-field" placeholder="<?php esc_attr_e( 'Search…', 'tfg' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
	<button type="submit" aria-label="<?php esc_attr_e( 'Search', 'tfg' ); ?>">
		<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
	</button>
</form>
