<?php
/**
 * Helper functions — content queries, stats, listings, formatting.
 *
 * @package TFG
 */

/**
 * Theme mod helper with default.
 */
function tfg_opt( $key, $default = '' ) {
	return get_theme_mod( $key, $default );
}

/**
 * Main phone number.
 */
function tfg_phone() {
	return tfg_opt( 'tfg_phone', '(949) 229-1733' );
}

/**
 * Tel: link (digits only).
 */
function tfg_phone_link() {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', tfg_phone() );
}

/**
 * Social profiles.
 */
function tfg_social() {
	return array(
		'facebook'  => tfg_opt( 'tfg_facebook', 'https://www.facebook.com/thefindgroup/' ),
		'instagram' => tfg_opt( 'tfg_instagram', 'https://instagram.com/thefindgroup' ),
		'twitter'   => tfg_opt( 'tfg_twitter', 'https://twitter.com/thefindgroup' ),
		'youtube'   => tfg_opt( 'tfg_youtube', 'https://youtube.com/@thefindgroup' ),
	);
}

/**
 * Brand stats (rendered in the stat block).
 */
function tfg_stats() {
	return array(
		array( '1985',    __( 'Established', 'tfg' ) ),
		array( '40',      __( 'Years of experience', 'tfg' ) ),
		array( '16,000+', __( 'Enthusiast database', 'tfg' ) ),
		array( '6',       __( 'Global offices', 'tfg' ) ),
		array( '11',      __( 'Languages spoken', 'tfg' ) ),
		array( '19',      __( 'Specialists', 'tfg' ) ),
		array( '8',       __( 'Associations', 'tfg' ) ),
	);
}

/**
 * Associations (name + description) — used in the trust strip.
 */
function tfg_associations() {
	return array(
		array( 'IYBA',     __( 'International Yacht Brokers Association', 'tfg' ), 'iyba.png' ),
		array( 'MYBA',     __( 'The Worldwide Yachting Association', 'tfg' ),      'myba.jpg' ),
		array( 'NMMA',     __( 'National Marine Manufacturers Association', 'tfg' ), 'nmma.png' ),
		array( 'YBAA',     __( 'Yacht Brokers Association of America', 'tfg' ),    'ybaa.png' ),
		array( 'MLS',      __( 'Realtor MLS', 'tfg' ),                             'mls.jpg' ),
		array( 'Real',     __( 'Real Broker', 'tfg' ),                             'real.jpg' ),
		array( 'JUWAI',    __( 'Juwai', 'tfg' ),                                   'juwai.jpg' ),
		array( 'YATCO',    __( 'YATCO', 'tfg' ),                                   'yatco.png' ),
	);
}

/**
 * Authorized dealer brands.
 */
function tfg_brands() {
	return array(
		'Gulf Craft', 'Majesty Yachts', 'Nomad Yachts', 'ORYX',
		'SilverCat', 'Silvercraft', 'Silent Yachts',
		'Aron Flying Ship', 'FAB Dock',
	);
}

/**
 * Featured categories for home.
 */
function tfg_categories() {
	return array(
		array(
			'slug'  => 'yachts',
			'name'  => __( 'Yachts', 'tfg' ),
			'img'   => TFG_URI . '/assets/img/category-yachts.jpg',
			'link'  => home_url( '/product-category/yachts/' ),
			'count' => tfg_listings_count( 'yachts' ),
		),
		array(
			'slug'  => 'real-estate',
			'name'  => __( 'Real Estate', 'tfg' ),
			'img'   => TFG_URI . '/assets/img/category-real-estate.jpg',
			'link'  => home_url( '/product-category/real-estate/' ),
			'count' => tfg_listings_count( 'real-estate' ),
		),
		array(
			'slug'  => 'aircraft',
			'name'  => __( 'Aircraft', 'tfg' ),
			'img'   => TFG_URI . '/assets/img/category-aircraft.jpg',
			'link'  => home_url( '/product-category/aircraft/' ),
			'count' => tfg_listings_count( 'aircraft' ),
		),
		array(
			'slug'  => 'armored-vehicles',
			'name'  => __( 'Armored Vehicles', 'tfg' ),
			'img'   => TFG_URI . '/assets/img/category-armored.jpg',
			'link'  => home_url( '/product-category/armored-vehicles/' ),
			'count' => tfg_listings_count( 'armored-vehicles' ),
		),
	);
}

/**
 * Count listings (WooCommerce products) in a product_cat.
 */
function tfg_listings_count( $cat_slug ) {
	if ( ! class_exists( 'WooCommerce' ) ) return 0;
	$term = get_term_by( 'slug', $cat_slug, 'product_cat' );
	if ( ! $term || is_wp_error( $term ) ) return 0;
	return (int) $term->count;
}

/**
 * Get featured / trending listings (WooCommerce products).
 */
function tfg_listings( $args = array() ) {
	if ( ! class_exists( 'WooCommerce' ) ) return array();
	$defaults = array(
		'posts_per_page' => 6,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'category'       => '',
		'featured'       => false,
	);
	$args = wp_parse_args( $args, $defaults );
	$q    = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => $args['posts_per_page'],
		'orderby'        => $args['orderby'],
		'order'          => $args['order'],
	);
	$tax_query = array();
	if ( $args['category'] ) {
		$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $args['category'],
		);
	}
	if ( $args['featured'] ) {
		$tax_query[] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => 'featured',
		);
	}
	if ( $tax_query ) {
		$tax_query['relation'] = 'AND';
		$q['tax_query']        = $tax_query;
	}
	return get_posts( $q );
}

/**
 * Format a listing price with no decimals — luxury catalog style.
 */
function tfg_price( $product = null ) {
	if ( ! $product ) {
		global $product;
	}
	if ( ! $product ) return '';
	if ( method_exists( $product, 'get_price' ) && $product->get_price() > 0 ) {
		$price = $product->get_price();
		$formatted = '$' . number_format( $price, 0, '.', ',' );
		// Strike-through original if on sale.
		if ( $product->is_on_sale() ) {
			$regular = '$' . number_format( $product->get_regular_price(), 0, '.', ',' );
			return '<span class="tfg-price__was">' . esc_html( $regular ) . '</span> <span class="tfg-price__is">' . esc_html( $formatted ) . '</span>';
		}
		return '<span class="tfg-price__is">' . esc_html( $formatted ) . '</span>';
	}
	// "Price on request" for unpriced luxury assets.
	return '<span class="tfg-price__poa">' . esc_html__( 'Price on request', 'tfg' ) . '</span>';
}

/**
 * Get all team members (ordered by menu_order, title).
 */
function tfg_team( $division = '' ) {
	$args = array(
		'post_type'      => 'team_member',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	);
	if ( $division ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'division',
				'field'    => 'slug',
				'terms'    => $division,
			),
		);
	}
	return get_posts( $args );
}

/**
 * Get all offices (ordered by menu_order).
 */
function tfg_offices() {
	return get_posts( array(
		'post_type'      => 'office',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	) );
}

/**
 * Get the Forminator contact form ID.
 */
function tfg_contact_form_id() {
	if ( ! class_exists( 'Forminator_API' ) ) return 0;
	// Look up the "Send Us a Message" form by published forms.
	$forms = Forminator_API::get_forms();
	foreach ( $forms as $form ) {
		if ( false !== stripos( $form->post_title, 'send us a message' ) || false !== stripos( $form->post_title, 'contact' ) ) {
			return $form->id;
		}
	}
	// Fallback: first form.
	return ! empty( $forms ) ? $forms[0]->id : 0;
}

/**
 * Contact form shortcode (Forminator).
 * If Forminator isn't active, render a styled fallback HTML form that posts to admin-post.
 */
function tfg_contact_form( $echo = true ) {
	$id    = tfg_contact_form_id();
	$html  = '';
	if ( $id ) {
		$html = do_shortcode( '[forminator_form id="' . intval( $id ) . '"]' );
	} else {
		// Fallback form — same fields, posted to admin-post.php → tfg_handle_fallback_form.
		$html = tfg_fallback_form_html();
	}
	if ( $echo ) echo $html;
	return $html;
}

/**
 * Fallback form HTML (used if Forminator is unavailable).
 */
function tfg_fallback_form_html() {
	ob_start();
	?>
	<form class="tfg-form tfg-form--fallback" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="tfg_contact">
		<?php wp_nonce_field( 'tfg_contact', 'tfg_contact_nonce' ); ?>
		<div class="tfg-form__row tfg-form__row--2">
			<div class="tfg-field">
				<label for="tfg-first"><?php esc_html_e( 'First Name', 'tfg' ); ?> <span class="req">*</span></label>
				<input type="text" id="tfg-first" name="first_name" required>
			</div>
			<div class="tfg-field">
				<label for="tfg-last"><?php esc_html_e( 'Last Name', 'tfg' ); ?> <span class="req">*</span></label>
				<input type="text" id="tfg-last" name="last_name" required>
			</div>
		</div>
		<div class="tfg-form__row tfg-form__row--2">
			<div class="tfg-field">
				<label for="tfg-email"><?php esc_html_e( 'Email Address', 'tfg' ); ?> <span class="req">*</span></label>
				<input type="email" id="tfg-email" name="email" required>
			</div>
			<div class="tfg-field">
				<label for="tfg-phone"><?php esc_html_e( 'Phone Number', 'tfg' ); ?> <span class="req">*</span></label>
				<input type="tel" id="tfg-phone" name="phone" required>
			</div>
		</div>
		<div class="tfg-form__row">
			<div class="tfg-field tfg-field--select">
				<label for="tfg-reason"><?php esc_html_e( 'Select Reason', 'tfg' ); ?></label>
				<select id="tfg-reason" name="reason">
					<option value=""><?php esc_html_e( 'Select…', 'tfg' ); ?></option>
					<option value="buying"><?php esc_html_e( 'Buying', 'tfg' ); ?></option>
					<option value="selling"><?php esc_html_e( 'Selling', 'tfg' ); ?></option>
					<option value="partnership"><?php esc_html_e( 'Partnership', 'tfg' ); ?></option>
					<option value="other"><?php esc_html_e( 'Other', 'tfg' ); ?></option>
				</select>
			</div>
		</div>
		<div class="tfg-form__row">
			<div class="tfg-field tfg-field--select">
				<label for="tfg-interest"><?php esc_html_e( 'Select Interest', 'tfg' ); ?></label>
				<select id="tfg-interest" name="interest">
					<option value=""><?php esc_html_e( 'Select…', 'tfg' ); ?></option>
					<option value="yachts"><?php esc_html_e( 'Yachts', 'tfg' ); ?></option>
					<option value="residential"><?php esc_html_e( 'Residential Real Estate', 'tfg' ); ?></option>
					<option value="commercial"><?php esc_html_e( 'Commercial Real Estate', 'tfg' ); ?></option>
					<option value="aron"><?php esc_html_e( 'Aron Flying Ship', 'tfg' ); ?></option>
					<option value="gulf-craft"><?php esc_html_e( 'Gulf Craft', 'tfg' ); ?></option>
					<option value="aircraft"><?php esc_html_e( 'Aircraft', 'tfg' ); ?></option>
					<option value="other"><?php esc_html_e( 'Other', 'tfg' ); ?></option>
				</select>
			</div>
		</div>
		<div class="tfg-form__row">
			<div class="tfg-field">
				<label for="tfg-message"><?php esc_html_e( 'Message', 'tfg' ); ?></label>
				<textarea id="tfg-message" name="message" maxlength="180" data-counter></textarea>
				<span class="tfg-counter"><span class="cur">0</span> / 180</span>
			</div>
		</div>
		<div class="tfg-form__row tfg-form__actions">
			<button type="submit" class="tfg-btn tfg-btn--primary"><?php esc_html_e( 'Submit Message', 'tfg' ); ?> <span aria-hidden="true">→</span></button>
		</div>
	</form>
	<?php
	return ob_get_clean();
}

/**
 * Handle fallback form submission.
 */
function tfg_handle_fallback_form() {
	if ( ! isset( $_POST['tfg_contact_nonce'] ) || ! wp_verify_nonce( $_POST['tfg_contact_nonce'], 'tfg_contact' ) ) {
		wp_die( esc_html__( 'Security check failed.', 'tfg' ) );
	}
	$data = array(
		'first_name' => sanitize_text_field( wp_unslash( $_POST['first_name'] ?? '' ) ),
		'last_name'  => sanitize_text_field( wp_unslash( $_POST['last_name'] ?? '' ) ),
		'email'      => sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ),
		'phone'      => sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) ),
		'reason'     => sanitize_text_field( wp_unslash( $_POST['reason'] ?? '' ) ),
		'interest'   => sanitize_text_field( wp_unslash( $_POST['interest'] ?? '' ) ),
		'message'    => sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) ),
	);

	$to      = tfg_opt( 'tfg_contact_email', get_option( 'admin_email' ) );
	$subject = sprintf( __( 'New enquiry from %s %s', 'tfg' ), $data['first_name'], $data['last_name'] );
	$body    = '';
	foreach ( $data as $k => $v ) {
		$body .= ucfirst( str_replace( '_', ' ', $k ) ) . ": $v\n";
	}
	$headers = array( 'Reply-To: ' . $data['email'] );
	wp_mail( $to, $subject, $body, $headers );

	// Redirect back with success flag.
	$redirect = isset( $_POST['_wp_http_referer'] ) ? wp_get_referer() : home_url( '/contact/' );
	wp_safe_redirect( add_query_arg( 'submitted', '1', $redirect ) );
	exit;
}
add_action( 'admin_post_tfg_contact', 'tfg_handle_fallback_form' );
add_action( 'admin_post_nopriv_tfg_contact', 'tfg_handle_fallback_form' );

/**
 * Newsletter subscription handler.
 */
function tfg_handle_newsletter() {
	check_ajax_referer( 'tfg-nonce', 'nonce' );
	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please enter a valid email.', 'tfg' ) ) );
	}
	// Save to a simple option array (or hook a CRM here later).
	$list   = get_option( 'tfg_newsletter', array() );
	$list[] = $email;
	update_option( 'tfg_newsletter', array_unique( $list ) );

	$to      = tfg_opt( 'tfg_contact_email', get_option( 'admin_email' ) );
	wp_mail( $to, __( 'New newsletter subscription', 'tfg' ), $email );
	wp_send_json_success( array( 'message' => __( 'Thank you — you are subscribed.', 'tfg' ) ) );
}
add_action( 'wp_ajax_tfg_newsletter', 'tfg_handle_newsletter' );
add_action( 'wp_ajax_nopriv_tfg_newsletter', 'tfg_handle_newsletter' );

/**
 * Theme toggle link markup (rendered in footer).
 */
function tfg_theme_toggle() {
	?>
	<button class="tfg-theme-toggle" aria-label="<?php esc_attr_e( 'Toggle light or dark mode', 'tfg' ); ?>" data-theme-toggle>
		<span class="tfg-theme-toggle__track">
			<span class="tfg-theme-toggle__thumb"></span>
		</span>
		<span class="tfg-theme-toggle__label">
			<span class="label-dark"><?php esc_html_e( 'Dark', 'tfg' ); ?></span>
			<span class="label-light"><?php esc_html_e( 'Light', 'tfg' ); ?></span>
		</span>
	</button>
	<?php
}

/**
 * Excerpt length & read-more.
 */
function tfg_excerpt_length() {
	return 22;
}
add_filter( 'excerpt_length', 'tfg_excerpt_length' );

function tfg_excerpt_more() {
	return '…';
}
add_filter( 'excerpt_more', 'tfg_excerpt_more' );
