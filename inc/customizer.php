<?php
/**
 * Theme customizer — contact details, social, live-chat snippet.
 *
 * @package TFG
 */

function tfg_customize_register( $wp_customize ) {

	// ===== Panel =====
	$wp_customize->add_panel( 'tfg_options', array(
		'title'    => __( 'THE FINDGROUP', 'tfg' ),
		'priority' => 1,
	) );

	// ===== Section: Contact =====
	$wp_customize->add_section( 'tfg_contact', array(
		'title' => __( 'Contact Details', 'tfg' ),
		'panel' => 'tfg_options',
	) );

	$fields = array(
		'tfg_phone'         => array( __( 'Main Phone', 'tfg' ), '(949) 229-1733', 'sanitize_text_field', 'text' ),
		'tfg_contact_email' => array( __( 'Enquiries Email', 'tfg' ), '', 'sanitize_email', 'email' ),
		'tfg_facebook'      => array( __( 'Facebook URL', 'tfg' ), 'https://www.facebook.com/thefindgroup/', 'esc_url_raw', 'url' ),
		'tfg_instagram'     => array( __( 'Instagram URL', 'tfg' ), 'https://instagram.com/thefindgroup', 'esc_url_raw', 'url' ),
		'tfg_twitter'       => array( __( 'Twitter / X URL', 'tfg' ), 'https://twitter.com/thefindgroup', 'esc_url_raw', 'url' ),
		'tfg_youtube'       => array( __( 'YouTube URL', 'tfg' ), 'https://youtube.com/@thefindgroup', 'esc_url_raw', 'url' ),
	);
	foreach ( $fields as $key => $f ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $f[1],
			'sanitize_callback' => $f[2],
			'transport'         => 'refresh',
			'type'              => 'theme_mod',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $f[0],
			'section' => 'tfg_contact',
			'type'    => $f[3],
		) );
	}

	// ===== Section: Live Chat =====
	$wp_customize->add_section( 'tfg_chat', array(
		'title' => __( 'Live Chat', 'tfg' ),
		'panel' => 'tfg_options',
	) );

	$wp_customize->add_setting( 'tfg_livechat_snippet', array(
		'default'           => '',
		'sanitize_callback' => 'tfg_sanitize_snippet',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'tfg_livechat_snippet', array(
		'label'       => __( 'Live Chat Embed Snippet', 'tfg' ),
		'description' => __( 'Paste the script tag from your live-chat provider (Tawk.to, Intercom, Crisp, HubSpot, etc.). It will be injected before </body>.', 'tfg' ),
		'section'     => 'tfg_chat',
		'type'        => 'textarea',
	) );

	$wp_customize->add_setting( 'tfg_livechat_label', array(
		'default'           => __( 'Live Chat', 'tfg' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'tfg_livechat_label', array(
		'label'   => __( 'Chat Button Label (fallback)', 'tfg' ),
		'section' => 'tfg_chat',
		'type'    => 'text',
	) );

	// ===== Section: Brand =====
	$wp_customize->add_section( 'tfg_brand', array(
		'title' => __( 'Brand', 'tfg' ),
		'panel' => 'tfg_options',
	) );

	$wp_customize->add_setting( 'tfg_tagline', array(
		'default'           => __( 'Selling Luxury Assets Since 1985', 'tfg' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'tfg_tagline', array(
		'label'   => __( 'Hero Tagline', 'tfg' ),
		'section' => 'tfg_brand',
		'type'    => 'text',
	) );

	// SEO meta description (homepage).
	$wp_customize->add_setting( 'tfg_meta_description', array(
		'default'           => __( 'THE FINDGROUP — Selling Luxury Assets Since 1985. Yachts, Real Estate, Aircraft & Armored Luxury Vehicles.', 'tfg' ),
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'tfg_meta_description', array(
		'label'       => __( 'Homepage Meta Description (SEO)', 'tfg' ),
		'description' => __( 'Shown in search results and social shares. Keep under 160 characters.', 'tfg' ),
		'section'     => 'tfg_brand',
		'type'        => 'textarea',
	) );
}
add_action( 'customize_register', 'tfg_customize_register' );

/**
 * Allow only script/iframe snippets for the live-chat field.
 * Strips PHP and dangerous tags but permits <script> and provider iframes.
 */
function tfg_sanitize_snippet( $input ) {
	// Remove PHP tags.
	$input = preg_replace( '/<\?(php|=)?/i', '', $input );
	// Remove event handlers like onerror=, onload=.
	$input = preg_replace( '/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $input );
	return trim( $input );
}

/**
 * Inject live-chat snippet before </body>.
 */
function tfg_inject_livechat() {
	$snippet = tfg_opt( 'tfg_livechat_snippet' );
	if ( $snippet ) {
		echo "\n<!-- TFG Live Chat -->\n" . $snippet . "\n";
	}
}
add_action( 'wp_footer', 'tfg_inject_livechat', 100 );
