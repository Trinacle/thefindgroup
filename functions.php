<?php
/**
 * THE FINDGROUP — Luxury Theme
 * Core functions and theme setup.
 *
 * @package TFG
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TFG_VERSION', '1.0.0' );
define( 'TFG_DIR', get_template_directory() );
define( 'TFG_URI', get_template_directory_uri() );

/**
 * Theme setup: theme supports, image sizes, menus.
 */
require_once TFG_DIR . '/inc/setup.php';

/**
 * Asset enqueuing: fonts, CSS, JS.
 */
require_once TFG_DIR . '/inc/assets.php';

/**
 * Custom post types: team_member, office.
 */
require_once TFG_DIR . '/inc/cpt.php';

/**
 * WooCommerce: template overrides + product category mapping.
 */
require_once TFG_DIR . '/inc/woocommerce.php';

/**
 * Helper functions: content queries, stats, offices, team, listings.
 */
require_once TFG_DIR . '/inc/helpers.php';

/**
 * Customizer: theme settings (phone, social, live-chat snippet).
 */
require_once TFG_DIR . '/inc/customizer.php';
