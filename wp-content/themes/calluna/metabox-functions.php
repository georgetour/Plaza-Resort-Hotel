<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category calluna
 * @package  calluna
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( get_template_directory() . '/inc/cmb2/init.php' ) ) {
	require_once get_template_directory() . '/inc/cmb2/init.php';
	require_once get_template_directory() . '/inc/cmb-field-gallery/cmb-field-gallery.php';
} elseif ( file_exists( get_template_directory() . '/inc/CMB2/init.php' ) ) {
	require_once get_template_directory() . '/inc/CMB2/init.php';
	require_once get_template_directory() . '/inc/cmb-field-gallery/cmb-field-gallery.php';
}

/**
 * Gets a number of terms and displays them as options
 * @param  CMB2_Field $field
 * @return array An array of options that matches the CMB2 options array
 */
function cmb2_get_term_options( $field ) {
    $args = $field->args( 'get_terms_args' );
    $args = is_array( $args ) ? $args : array();

    $args = wp_parse_args( $args, array( 'taxonomy' => 'category' ) );

    $taxonomy = $args['taxonomy'];

    $terms = (array) cmb2_utils()->wp_at_least( '4.5.0' )
        ? get_terms( $args )
        : get_terms( $taxonomy, $args );

    // Initate an empty array
    $term_options = array();
    if ( ! empty( $terms ) ) {
        foreach ( $terms as $term ) {
            $term_options[ $term->term_id ] = $term->name;
        }
    }

    return $term_options;
}

function calluna_show_if_is_page( $cmb ) {
	$page = get_post( $cmb->object_id );
	// Don't show this metabox if it's not the shop page
	return 'page' == $page->post_type;
}
function calluna_taxonomy_show_on_filter( $display, $meta_box ) {
    if ( ! isset( $meta_box['show_on']['key'], $meta_box['show_on']['value'] ) ) {
        return $display;
    }

    if ( 'taxonomy' !== $meta_box['show_on']['key'] ) {
        return $display;
    }

    $post_id = 0;

    // If we're showing it based on ID, get the current ID
    if ( isset( $_GET['post'] ) ) {
        $post_id = $_GET['post'];
    } elseif ( isset( $_POST['post_ID'] ) ) {
        $post_id = $_POST['post_ID'];
    }

    if ( ! $post_id ) {
        return $display;
    }

    foreach( (array) $meta_box['show_on']['value'] as $taxonomy => $slugs ) {
        if ( ! is_array( $slugs ) ) {
            $slugs = array( $slugs );
        }

        $display = false;
        $terms = wp_get_object_terms( $post_id, $taxonomy );
        foreach( $terms as $term ) {
            if ( in_array( $term->slug, $slugs ) ) {
                $display = true;
                break;
            }
        }

        if ( $display ) {
            break;
        }
    }

    return $display;
}
add_filter( 'cmb2_show_on', 'calluna_taxonomy_show_on_filter', 10, 2 );

add_action( 'cmb2_init', 'calluna_register_header_metabox');
/**
 * Hook in and add a header metabox. Can only happen on the 'cmb2_init' hook.
 */
function calluna_register_header_metabox() {
	
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_calluna_header_';	
	
	/**
	 * Header settings metabox
	 */
	$cmb_header = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Header settings', 'calluna-td' ),
		'object_types'  => array( 'page', 'post', 'offer', 'event', 'apb_room_type'), // Post type
	) );
	
	$cmb_header->add_field( array(
		'name'             => esc_html__( 'Header options', 'calluna-td' ),
		'id'               => $prefix . 'select',
		'type'             => 'select',
		'show_option_none' => false,
		'default'	   => 'color',
		'options'          => array(
			'slider' => esc_html__( 'Master slider', 'calluna-td' ),
			'image'   => esc_html__( 'Image', 'calluna-td' ),
			'color'     => esc_html__( 'Color', 'calluna-td' ),
			'none'     => esc_html__( 'No Header', 'calluna-td' ),
		),
	) );
	
	$cmb_header->add_field( array(
		'name' => esc_html__( 'Master slider shortcode', 'calluna-td' ),
		'desc' => esc_html__( '[masterslider id="sliderId"]', 'calluna-td' ),
		'id'   => $prefix . 'slider',
		'type' => 'text_medium',
	) );
	
	$cmb_header->add_field( array(
		'name' => esc_html__( 'Chose image', 'calluna-td' ),
		'desc' => esc_html__( 'Header background image', 'calluna-td' ),
		'id'   => $prefix . 'image',
		'type' => 'file',
	) );
	
	$cmb_header->add_field( array(
		'name' => esc_html__( 'Header text', 'calluna-td' ),
		'desc' => esc_html__( 'Add a text to show in the header', 'calluna-td' ),
		'id'   => $prefix . 'text',
		'type' => 'text_medium',
		'show_on_cb' => 'calluna_show_if_is_page',
	) );
	
	$cmb_header->add_field( array(
		'name'             => esc_html__( 'Overwrite global navigation style', 'calluna-td' ),
		'desc'             => esc_html__( 'Change the navigation style for this page.', 'calluna-td' ),
		'id'               => $prefix . 'nav_radio',
		'type'             => 'radio_inline',
		'show_option_none' => 'No',
		'options'          => array(
			'left-nav' => esc_html__( 'Top transparent navigation', 'calluna-td' ),
			'top-nav'   => esc_html__( 'Top navigation', 'calluna-td' ),
			'top-full-nav'     => esc_html__( 'Top full width navigation', 'calluna-td' ),
		),
	) );

    $cmb_header->add_field( array(
        'name'     => __( 'Individual Page Menu', 'calluna-td' ),
        'desc'     => __( 'Set a different menu for this page.', 'calluna-td' ),
        'id'       => $prefix . 'custom_menu',
        'type'           => 'select',
        // Use a callback to avoid performance hits on pages where this field is not displayed (including the front-end).
        'options_cb'     => 'cmb2_get_term_options',
        // Same arguments you would pass to `get_terms`.
        'get_terms_args' => array(
            'taxonomy'   => 'nav_menu',
            'hide_empty' => false,
        ),
    ) );
	
}
add_action( 'cmb2_init', 'calluna_register_page_metabox');
/**
 * Hook in and add a page metabox. Can only happen on the 'cmb2_init' hook.
 */
function calluna_register_page_metabox() {
	
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_calluna_page_';	
	
	/**
	 * Page settings metabox
	 */
	$cmb_page = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Page settings', 'calluna-td' ),
		'object_types'  => array( 'page'), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );
	
	$cmb_page->add_field( array(
		'name'             => esc_html__( 'Content Top Padding', 'calluna-td' ),
		'id'               => $prefix . 'top_padding_select',
		'type'             => 'select',
		'show_option_none' => false,
		'default'	   => 'top-35',
		'options'          => array(
			'top-35' => '35px',
			'top-25' => '25px',
			'top-15' => '15px',
			'top-5' => '5px',
			'top-0' => '0'
		),
	) );
	
    $cmb_page->add_field( array(
		'name'             => esc_html__( 'Content Bottom Padding', 'calluna-td' ),
		'id'               => $prefix . 'bottom_padding_select',
		'type'             => 'select',
		'show_option_none' => false,
		'default'	   => 'bottom-35',
		'options'          => array(
			'bottom-35' => '35px',
			'bottom-25' => '25px',
			'bottom-15' => '15px',
			'bottom-5' => '5px',
			'bottom-0' => '0'
		),
	) );
	
}

add_action( 'cmb2_init', 'calluna_register_gallery_metabox');

/**
 * Hook in and add a gallery metabox. Can only happen on the 'cmb2_init' hook.
 */
function calluna_register_gallery_metabox() {
	
	// Start with an underscore to hide fields from custom fields list
	$prefix_gallery = '_calluna_gallery_';	
	
	/**
	 * Gallery settings metabox
	 */
	$cmb_gallery = new_cmb2_box( array(
		'id'            => $prefix_gallery . 'metabox',
		'title'         => esc_html__( 'Gallery', 'calluna-td' ),
		'object_types'  => array('post', 'event', 'offer', 'apb_room_type'), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		'priority'   => 'low',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );
	
	$cmb_gallery->add_field( array(
		'name' => esc_html__( 'Gallery Images', 'calluna-td' ),
		'desc' => esc_html__( 'Upload and manage gallery images', 'calluna-td' ),
		'button' => esc_html__( 'Manage gallery', 'calluna-td' ),  // Optionally set button label
		'id'   => $prefix_gallery . 'select',
		'type' => 'pw_gallery',
		'sanitization_cb' => 'pw_gallery_field_sanitise',
	) );
	
	$cmb_gallery->add_field( array(
		'name' => esc_html__( 'Gallery Description', 'calluna-td' ),
		'desc' => esc_html__( 'Only for room, event and offer.', 'calluna-td' ),
		'id'   => $prefix_gallery . 'description',
		'type' => 'textarea_small',
	) );
	
}
add_action( 'cmb2_init', 'calluna_register_video_metabox');
/**
 * Hook in and add a gallery metabox. Can only happen on the 'cmb2_init' hook.
 */
function calluna_register_video_metabox() {
	
	// Start with an underscore to hide fields from custom fields list
	$prefix_video = '_calluna_video_';	
	
	/**
	 * Gallery settings metabox
	 */
	$cmb_video = new_cmb2_box( array(
		'id'            => $prefix_video . 'metabox',
		'title'         => esc_html__( 'Video', 'calluna-td' ),
		'object_types'  => array('post'), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		'priority'   => 'low',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );
	
	$cmb_video->add_field( array(
		'name' => esc_html__( 'Video URL (extern)', 'calluna-td' ),
		'desc' => esc_html__( 'Enter an embedded video url like youtube or vimeo. Only for the video post format.', 'calluna-td' ),
		'id'   => $prefix_video . 'embed',
		'type' => 'oembed',
	) );
	
}

add_action( 'cmb2_init', 'calluna_register_events_metabox');
/**
 * Hook in and add a event information metabox. Can only happen on the 'cmb2_init' hook.
 */
function calluna_register_events_metabox() {
	
	// Start with an underscore to hide fields from custom fields list
	$prefix_event = '_calluna_event_';	
	
	/**
	 * Event informations metabox
	 */
	$cmb_event = new_cmb2_box( array(
		'id'            => $prefix_event . 'metabox',
		'title'         => esc_html__( 'Event information', 'calluna-td' ),
		'object_types'  => array( 'event'), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );
	
	$cmb_event->add_field( array(
		'name' => esc_html__( 'Event Date', 'calluna-td' ),
		'id'   => $prefix_event . 'date',
		'type' => 'text_date',
	) );
	
	$cmb_event->add_field( array(
		'name' => esc_html__( 'Event Time', 'calluna-td' ),
		'id'   => $prefix_event . 'time',
		'type' => 'text_time',
		'time_format' => 'H:i'
		// 'timezone_meta_key' => $prefix . 'timezone', // Optionally make this field honor the timezone selected in the select_timezone specified above
	) );
	
	$cmb_event->add_field( array(
		'name' => esc_html__( 'Event Location', 'calluna-td' ),
		'id'   => $prefix_event . 'location',
		'type' => 'text_medium',
	) );
	
	/**
	 * Event informations metabox
	 */
	$cmb_event_includes = new_cmb2_box( array(
		'id'            => $prefix_event . 'includes_metabox',
		'title'         => esc_html__( 'Included Details', 'calluna-td' ),
		'object_types'  => array( 'event'), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );
	
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_event_includes_id = $cmb_event_includes->add_field( array(
		'id'          => $prefix_event . 'includes',
		'type'        => 'group',
		'description' => esc_html__( 'Generates reusable form entries', 'calluna-td' ),
		'options'     => array(
			'group_title'   => esc_html__( 'Included detail {#}', 'calluna-td' ), // {#} gets replaced by row number
			'add_button'    => esc_html__( 'Add Another Entry', 'calluna-td' ),
			'remove_button' => esc_html__( 'Remove Entry', 'calluna-td' ),
			'sortable'      => true, // beta
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_event_includes->add_group_field( $group_field_event_includes_id, array(
		'name'        => esc_html__( 'Description', 'calluna-td' ),
		'description' => esc_html__( 'Write the included detail', 'calluna-td' ),
		'id'          => 'detail',
		'type'        => 'textarea_small',
	) );
}

add_action( 'cmb2_init', 'calluna_register_offers_metabox');
/**
 * Hook in and add a offer information metabox. Can only happen on the 'cmb2_init' hook.
 */
function calluna_register_offers_metabox() {
	
	// Start with an underscore to hide fields from custom fields list
	$prefix_offer = '_calluna_offer_';
	$currency_symbol = get_theme_mod( 'currency', '$');	
	
	/**
	 * Offer informations metabox
	 */
	$cmb_offer = new_cmb2_box( array(
		'id'            => $prefix_offer . 'metabox',
		'title'         => esc_html__( 'Offer information', 'calluna-td' ),
		'object_types'  => array( 'offer'), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );
	
	$cmb_offer->add_field( array(
		'name' => esc_html__( 'Price', 'calluna-td' ),
		'id'   => $prefix_offer . 'price',
		'type' => 'text_money',
		'before_field' => $currency_symbol, // override '$' symbol if needed
		// 'repeatable' => true,
	) );

    $cmb_offer->add_field( array(
        'name' => esc_html__( 'Individual Link to Offer Reservation', 'calluna-td' ),
        'id'   => $prefix_offer . 'link',
        'type' => 'text_url',
        // 'repeatable' => true,
    ) );
	
	/**
	 * Event informations metabox
	 */
	$cmb_offer_includes = new_cmb2_box( array(
		'id'            => $prefix_offer . 'includes_metabox',
		'title'         => esc_html__( 'Included Details', 'calluna-td' ),
		'object_types'  => array( 'offer'), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );
	
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_includes_id = $cmb_offer_includes->add_field( array(
		'id'          => $prefix_offer . 'includes',
		'type'        => 'group',
		'description' => esc_html__( 'Generates reusable form entries', 'calluna-td' ),
		'options'     => array(
			'group_title'   => esc_html__( 'Included detail {#}', 'calluna-td' ), // {#} gets replaced by row number
			'add_button'    => esc_html__( 'Add Another Entry', 'calluna-td' ),
			'remove_button' => esc_html__( 'Remove Entry', 'calluna-td' ),
			'sortable'      => true, // beta
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_offer_includes->add_group_field( $group_field_includes_id, array(
		'name'        => esc_html__( 'Description', 'calluna-td' ),
		'description' => esc_html__( 'Write the included detail', 'calluna-td' ),
		'id'          => 'detail',
		'type'        => 'textarea_small',
	) );
	
}

add_action( 'cmb2_init', 'calluna_register_rooms_metabox');
/**
 * Hook in and add a offer information metabox. Can only happen on the 'cmb2_init' hook.
 */
function calluna_register_rooms_metabox() {
	
	// Start with an underscore to hide fields from custom fields list
	$prefix_room = '_calluna_room_';
	
	/**
	 * Repeatable Field Groups for Amenities
	 */
	$cmb_room_amenities = new_cmb2_box( array(
		'id'           => $prefix_room . 'metabox_amenities',
		'title'        => esc_html__( 'Amenities', 'calluna-td' ),
		'object_types' => array( 'apb_room_type', ),
	) );
	
	$cmb_room_amenities->add_field( array(
		'name' => esc_html__( 'Amenities Description', 'calluna-td' ),
		'id'   => $prefix_room . 'amenities_description',
		'type' => 'textarea_small',
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_room_amenities->add_field( array(
		'id'          => $prefix_room . 'amenities',
		'type'        => 'group',
		'description' => esc_html__( 'Generates reusable form entries', 'calluna-td' ),
		'options'     => array(
			'group_title'   => esc_html__( 'Amenity {#}', 'calluna-td' ), // {#} gets replaced by row number
			'add_button'    => esc_html__( 'Add Another Entry', 'calluna-td' ),
			'remove_button' => esc_html__( 'Remove Entry', 'calluna-td' ),
			'sortable'      => true, // beta
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_room_amenities->add_group_field( $group_field_id, array(
		'name'       => esc_html__( 'Name', 'calluna-td' ),
		'id'         => 'title',
		'type'       => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$cmb_room_amenities->add_group_field( $group_field_id, array(
		'name'        => esc_html__( 'Description', 'calluna-td' ),
		'description' => esc_html__( 'Write a short description for this entry', 'calluna-td' ),
		'id'          => 'description',
		'type'        => 'wysiwyg',
		'repeatable'  => true
	) );

    $cmb_room_map = new_cmb2_box( array(
        'id'            => $prefix_room . 'metabox_map',
        'title'         => esc_html__( 'Room Google Maps', 'calluna-td' ),
        'object_types'  => array( 'apb_room_type'), // Post type

    ) );
    $cmb_room_map->add_field( array(
        'name'             => esc_html__( 'Map Type', 'calluna-td' ),
        'id'               => $prefix_room . 'map_type',
        'type'             => 'select',
        'show_option_none' => false,
        'default'	   => 'ROADMAP',
        'options'          => array(
            'ROADMAP' => esc_html__("Road Map", 'calluna-td'),
            'SATELLITE' => esc_html__("Satellite", 'calluna-td'),
            'HYBRID' => esc_html__("Hybrid", 'calluna-td'),
            'TERRAIN' => esc_html__("Terrain", 'calluna-shortcodes')
        ),
    ) );
    $cmb_room_map->add_field( array(
        'name'             => esc_html__( 'Map Style', 'calluna-td' ),
        'id'               => $prefix_room . 'map_style',
        'type'             => 'select',
        'show_option_none' => false,
        'default'	   => 'ROADMAP',
        'options'          => array(
            '1' => esc_html__( 'Shades of Grey', 'calluna-td' ),
            '2' => esc_html__( 'Greyscale', 'calluna-td' ),
            '3' => esc_html__( 'Light Gray', 'calluna-td' ),
            '4' => esc_html__( 'Midnight Commander', 'calluna-td' ),
            '5' => esc_html__( 'Blue water', 'calluna-td' ),
            '6' => esc_html__( 'Icy Blue', 'calluna-td' ),
            '7' => esc_html__( 'Bright and Bubbly', 'calluna-td' ),
            '8' => esc_html__( 'Pale Dawn', 'calluna-td' ),
            '9' => esc_html__( 'Paper', 'calluna-td' ),
            '10' => esc_html__( 'Blue Essence', 'calluna-td' ),
            '11' => esc_html__( 'Apple Maps-esque', 'calluna-td' ),
            '12' => esc_html__( 'Subtle Grayscale', 'calluna-td' ),
            '13' => esc_html__( 'Retro', 'calluna-td' ),
            '14' => esc_html__( 'Hopper', 'calluna-td' ),
            '15' => esc_html__( 'Red Hues', 'calluna-td' ),
            '16' => esc_html__( 'Ultra Light with labels', 'calluna-td' ),
            '17' => esc_html__( 'Unsaturated Browns', 'calluna-td' ),
            '18' => esc_html__( 'Light Dream', 'calluna-td' ),
            '19' => esc_html__( 'Neutral Blue', 'calluna-td' ),
            '20' => esc_html__( 'MapBox', 'calluna-td' )
        ),
    ) );
    $cmb_room_map->add_field( array(
        'name' => __( 'Height', 'calluna-td' ),
        'id'   => $prefix_room . 'map_height',
        'default'	   => '300',
        'type' => 'text'
    ) );
    $cmb_room_map->add_field( array(
        'name' => __( 'Latitude', 'calluna-td' ),
        'id'   => $prefix_room . 'map_lat',
        'type' => 'text'
    ) );
    $cmb_room_map->add_field( array(
        'name' => __( 'Longitude', 'calluna-td' ),
        'id'   => $prefix_room . 'map_lng',
        'type' => 'text'
    ) );
    $cmb_room_map->add_field( array(
        'name' => __( 'Zoom', 'calluna-td' ),
        'id'   => $prefix_room . 'map_zoom',
        'default'	   => '12',
        'type' => 'text'
    ) );
    $cmb_room_map->add_field( array(
        'name'             => esc_html__( 'Show Marker', 'calluna-td' ),
        'id'               => $prefix_room . 'map_marker',
        'type'             => 'select',
        'show_option_none' => false,
        'default'	   => 'yes',
        'options'          => array(
            'yes' => esc_html__("Yes", 'calluna-td'),
            'no' => esc_html__("No", 'calluna-td')
        ),
    ) );

	$cmb_custom_content = new_cmb2_box( array(
		'id'            => $prefix_room . 'metabox_custom',
		'title'         => esc_html__( 'Room Custom Content', 'calluna-td' ),
		'object_types'  => array( 'apb_room_type'), // Post type

	) );
    $cmb_custom_content->add_field( array(
        'name' => esc_html__( 'Custom Content', 'calluna-td' ),
        'id'   => $prefix_room . 'custom_content',
        'type' => 'textarea',
        'sanitization_cb' => false
    ) );
	
}
