<?php
/**
 * Custom Post Types: team_member, office.
 *
 * Team members are populated from the live site's roster (19 people).
 * Placeholder/lorem-ipsum slots are intentionally NOT migrated.
 *
 * @package TFG
 */

/**
 * Register CPTs.
 */
function tfg_register_post_types() {

	// Team Member
	register_post_type(
		'team_member',
		array(
			'labels'        => array(
				'name'               => __( 'Team', 'tfg' ),
				'singular_name'      => __( 'Team Member', 'tfg' ),
				'add_new_item'       => __( 'Add Team Member', 'tfg' ),
				'edit_item'          => __( 'Edit Team Member', 'tfg' ),
				'new_item'           => __( 'New Team Member', 'tfg' ),
				'view_item'          => __( 'View Team Member', 'tfg' ),
				'search_items'       => __( 'Search Team', 'tfg' ),
				'not_found'          => __( 'No team members found', 'tfg' ),
				'menu_name'          => __( 'Team', 'tfg' ),
			),
			'public'        => true,
			'has_archive'   => false,
			'menu_icon'     => 'dashicons-groups',
			'menu_position' => 21,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'rewrite'       => array( 'slug' => 'team', 'with_front' => false ),
			'show_in_rest'  => true,
		)
	);

	// Division taxonomy for team filtering.
	register_taxonomy(
		'division',
		'team_member',
		array(
			'labels'            => array(
				'name'          => __( 'Divisions', 'tfg' ),
				'singular_name' => __( 'Division', 'tfg' ),
				'menu_name'     => __( 'Divisions', 'tfg' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
		)
	);

	// Office
	register_post_type(
		'office',
		array(
			'labels'        => array(
				'name'               => __( 'Offices', 'tfg' ),
				'singular_name'      => __( 'Office', 'tfg' ),
				'add_new_item'       => __( 'Add Office', 'tfg' ),
				'edit_item'          => __( 'Edit Office', 'tfg' ),
				'menu_name'          => __( 'Offices', 'tfg' ),
			),
			'public'        => true,
			'has_archive'   => false,
			'menu_icon'     => 'dashicons-location-alt',
			'menu_position' => 22,
			'supports'      => array( 'title', 'editor', 'page-attributes' ),
			'rewrite'       => array( 'slug' => 'office', 'with_front' => false ),
			'show_in_rest'  => true,
		)
	);
}
add_action( 'init', 'tfg_register_post_types' );

/**
 * Team member meta: role, credentials, phone, email, division.
 */
function tfg_team_meta() {
	add_meta_box(
		'tfg_team_details',
		__( 'Team Member Details', 'tfg' ),
		'tfg_team_meta_cb',
		'team_member',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'tfg_team_meta' );

function tfg_team_meta_cb( $post ) {
	wp_nonce_field( 'tfg_team_meta', 'tfg_team_nonce' );
	$role       = get_post_meta( $post->ID, '_tfg_role', true );
	$creds      = get_post_meta( $post->ID, '_tfg_credentials', true );
	$phone      = get_post_meta( $post->ID, '_tfg_phone', true );
	$email      = get_post_meta( $post->ID, '_tfg_email', true );
	?>
	<p>
		<label><strong><?php esc_html_e( 'Role / Title', 'tfg' ); ?></strong></label><br>
		<input type="text" name="tfg_role" value="<?php echo esc_attr( $role ); ?>" style="width:100%" placeholder="e.g. President / Co-Founder">
	</p>
	<p>
		<label><strong><?php esc_html_e( 'Credentials', 'tfg' ); ?></strong></label><br>
		<input type="text" name="tfg_credentials" value="<?php echo esc_attr( $creds ); ?>" style="width:100%" placeholder="e.g. DRE #01217865">
	</p>
	<p>
		<label><strong><?php esc_html_e( 'Phone', 'tfg' ); ?></strong></label><br>
		<input type="text" name="tfg_phone" value="<?php echo esc_attr( $phone ); ?>" style="width:100%">
	</p>
	<p>
		<label><strong><?php esc_html_e( 'Email', 'tfg' ); ?></strong></label><br>
		<input type="email" name="tfg_email" value="<?php echo esc_attr( $email ); ?>" style="width:100%">
	</p>
	<?php
}

function tfg_save_team_meta( $post_id ) {
	if ( ! isset( $_POST['tfg_team_nonce'] ) || ! wp_verify_nonce( $_POST['tfg_team_nonce'], 'tfg_team_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	$keys = array( 'tfg_role', 'tfg_credentials', 'tfg_phone', 'tfg_email' );
	foreach ( $keys as $k ) {
		if ( isset( $_POST[ $k ] ) ) {
			$field = '_' . $k;
			$val   = 'tfg_email' === $k ? sanitize_email( wp_unslash( $_POST[ $k ] ) ) : sanitize_text_field( wp_unslash( $_POST[ $k ] ) );
			update_post_meta( $post_id, $field, $val );
		}
	}
}
add_action( 'save_post_team_member', 'tfg_save_team_meta' );

/**
 * Office meta: address, phone, map link.
 */
function tfg_office_meta() {
	add_meta_box(
		'tfg_office_details',
		__( 'Office Details', 'tfg' ),
		'tfg_office_meta_cb',
		'office',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'tfg_office_meta' );

function tfg_office_meta_cb( $post ) {
	wp_nonce_field( 'tfg_office_meta', 'tfg_office_nonce' );
	$address = get_post_meta( $post->ID, '_tfg_address', true );
	$phone   = get_post_meta( $post->ID, '_tfg_phone', true );
	$map     = get_post_meta( $post->ID, '_tfg_map', true );
	?>
	<p><label><strong><?php esc_html_e( 'Address', 'tfg' ); ?></strong></label><br>
		<textarea name="tfg_address" style="width:100%" rows="2"><?php echo esc_textarea( $address ); ?></textarea></p>
	<p><label><strong><?php esc_html_e( 'Phone', 'tfg' ); ?></strong></label><br>
		<input type="text" name="tfg_phone" value="<?php echo esc_attr( $phone ); ?>" style="width:100%"></p>
	<p><label><strong><?php esc_html_e( 'Map URL', 'tfg' ); ?></strong></label><br>
		<input type="url" name="tfg_map" value="<?php echo esc_attr( $map ); ?>" style="width:100%" placeholder="https://maps.google.com/?q=..."></p>
	<?php
}

function tfg_save_office_meta( $post_id ) {
	if ( ! isset( $_POST['tfg_office_nonce'] ) || ! wp_verify_nonce( $_POST['tfg_office_nonce'], 'tfg_office_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	if ( isset( $_POST['tfg_address'] ) ) update_post_meta( $post_id, '_tfg_address', sanitize_textarea_field( wp_unslash( $_POST['tfg_address'] ) ) );
	if ( isset( $_POST['tfg_phone'] ) )   update_post_meta( $post_id, '_tfg_phone', sanitize_text_field( wp_unslash( $_POST['tfg_phone'] ) ) );
	if ( isset( $_POST['tfg_map'] ) )     update_post_meta( $post_id, '_tfg_map', esc_url_raw( wp_unslash( $_POST['tfg_map'] ) ) );
}
add_action( 'save_post_office', 'tfg_save_office_meta' );

/**
 * Default seed data: 6 offices + 19 team members on theme activation.
 * Placeholder slots (Maldives Director unnamed, lorem-ipsum card) are excluded.
 */
function tfg_seed_content() {
	if ( get_option( 'tfg_seeded' ) ) return;

	// Offices (ordered by menu_order).
	$offices = array(
		array( 'Newport Beach',     "670 Lido Park Drive\nNewport Beach, CA 92663",       '(949) 229-1733' ),
		array( 'Miami',             "701 Brickell Ave, Suite 1550\nMiami, FL 33131",     '(949) 229-1733' ),
		array( 'Vancouver',         "555 W 12th Ave\nVancouver, BC V5Z 3X7, Canada",     '+1 604 218-3548' ),
		array( 'Malé, Maldives',    "7th Floor, Hazaarumaage, Fareedhee Magu\nMalé, Republic of Maldives", '+960 736 2030' ),
		array( 'Colombo',           "04, Elibank Road\nColombo 05, 00500, Sri Lanka",    '+947 77-763-7076' ),
		array( 'San Francisco',     "San Francisco, CA, USA",                            '(949) 229-1733' ),
	);
	foreach ( $offices as $i => $o ) {
		$id = wp_insert_post( array(
			'post_type'   => 'office',
			'post_title'  => $o[0],
			'post_status' => 'publish',
			'menu_order'  => $i,
		) );
		if ( $id ) {
			update_post_meta( $id, '_tfg_address', $o[1] );
			update_post_meta( $id, '_tfg_phone', $o[2] );
		}
	}

	// Team (19 confirmed members — placeholders excluded).
	$team = array(
		array( 'Joel Romero',         'CEO / Co-Founder',                       'Yachts' ),
		array( 'Edward Rodriguez',    'President / Co-Founder',                 'Real Estate' ),
		array( 'Johanna Stratton',    'Executive Administrative Assistant',     'Operations' ),
		array( 'David Foley',         'Vice President, Sales',                  'Yachts' ),
		array( 'Mahlon Adaman',       'Director of Real Estate — Sri Lanka',    'Real Estate' ),
		array( 'Ara Kachadourian',    'VP Real Estate Investments',             'Real Estate' ),
		array( 'Subra Sahadevan',     'Malaysia & Indonesia Business Dev. Director', 'Real Estate' ),
		array( 'Shaun Zelber',        'Real Estate Advisor & Marketing Director — Sri Lanka', 'Marketing' ),
		array( 'Tobias D. Kleff',     'VP Aviation, Corporate Fleet Services',  'Aviation' ),
		array( 'Mike Singh',          'Real Estate & Yacht Sales Director — Vancouver', 'Real Estate' ),
		array( 'Richard Haro',        'TFGSV Director of Sales',                'Sales' ),
		array( 'Frank Natoli',        'Director, Business Development',         'Business Development' ),
		array( 'Jeff Schilling',      'West Coast Yacht Sales',                 'Yachts' ),
		array( 'Ana Rothwell',        'Strategic Business Development Director', 'Business Development' ),
		array( 'Kevin Treman',        'Director, Online Marketing',             'Marketing' ),
		array( 'Barclay Tuck',        'Yacht Broker',                           'Yachts' ),
		array( 'Luis Obelmejias',     'Marine Electrical & Electronic Services', 'Yachts' ),
		array( 'Shirley Anthony',     'Asset Manager',                          'Operations' ),
	);
	// Edward Rodriguez credentials.
	$creds_map = array(
		'Edward Rodriguez' => 'DRE #01217865',
	);
	foreach ( $team as $t ) {
		$id = wp_insert_post( array(
			'post_type'   => 'team_member',
			'post_title'  => $t[0],
			'post_status' => 'publish',
			'post_content'=> '',
		) );
		if ( $id ) {
			update_post_meta( $id, '_tfg_role', $t[1] );
			if ( isset( $creds_map[ $t[0] ] ) ) update_post_meta( $id, '_tfg_credentials', $creds_map[ $t[0] ] );
			// Assign division term.
			if ( ! term_exists( $t[2], 'division' ) ) {
				wp_insert_term( $t[2], 'division' );
			}
			wp_set_object_terms( $id, $t[2], 'division' );
		}
	}

	update_option( 'tfg_seeded', 1 );
}
add_action( 'after_switch_theme', 'tfg_seed_content' );
