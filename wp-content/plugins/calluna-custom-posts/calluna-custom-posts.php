<?php

	/**
	 * Plugin Name:			Calluna Custom Posts
	 * Plugin URI:			http://demo.themetwins.com/calluna
	 * Description:			Offer and Event Post Type for the Calluna WordPress Theme
	 * Version:				2.0
	 * Author:				Themetwins
	 * Author URI:			http://demo.themetwins.com/calluna
	 * License:				GPL-2.0+
	 * License URI:			http://www.gnu.org/licenses/gpl-2.0.txt
	 */


	if ( ! defined( 'ABSPATH' ) ) exit;


// Register Event Post Type
function calluna_event_register() {

	register_post_type( 'event', apply_filters( 'calluna_post_type_event', array(
		'labels' => array(
			"name" => esc_html__( 'Events', 'calluna-td' ),
			"singular_name" => esc_html__( 'Event', 'calluna-td' ),
			"menu_name" => esc_html__( 'Events', 'calluna-td' ),
			'name_admin_bar'=> esc_html__( 'Event', 'calluna-td' ),
			'add_new'   => esc_html__( 'Add New', 'calluna-td' ),
			'add_new_item'=> esc_html__( 'Add New Event', 'calluna-td' ),
			'new_item'    => esc_html__( 'New Event', 'calluna-td' ),
			'edit_item'     => esc_html__( 'Edit Event', 'calluna-td' ),
			'view_item'   => esc_html__( 'View Event', 'calluna-td' ),
			'all_items'     => esc_html__( 'All Events', 'calluna-td' ),
			'search_items'=> esc_html__( 'Search Events', 'calluna-td' ),
			'parent_item_colon' => esc_html__( 'Parent Events:', 'calluna-td' ),
			'not_found'  => esc_html__( 'No events found.', 'calluna-td' ),
			'not_found_in_trash' => esc_html__( 'No events found in trash.', 'calluna-td' )
		),
		"description" => esc_html__('Event Post Type', 'calluna-td'),
		"public" => true,
		"show_ui" => true,
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "event", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 5,
		"supports" => array( "title", "editor", "excerpt", "thumbnail" )
	) ) );


	
	register_taxonomy('event_category', 'event',
		array(
			'labels'            => array(
				'name'              => esc_html__('Event Categories', 'calluna-td'),
				'singular_name'     => esc_html__('Event Categories', 'calluna-td'),
				'search_items'      => esc_html__('Search Event Categories', 'calluna-td'),
				'popular_items'     => esc_html__('Popular Event Categories', 'calluna-td'),
				'all_items'         => esc_html__('All Event Categories', 'calluna-td'),
				'parent_item'       => esc_html__('Parent Event Category', 'calluna-td'),
				'parent_item_colon' => esc_html__('Parent Event Category:', 'calluna-td'),
				'edit_item'         => esc_html__('Edit Event Category', 'calluna-td'),
				'update_item'       => esc_html__('Update Event Category', 'calluna-td'),
				'add_new_item'      => esc_html__('Add New Event Category', 'calluna-td'),
				'new_item_name'     => esc_html__('New Event Category', 'calluna-td'),
			),
			'hierarchical'      => TRUE,
			'show_ui'           => TRUE,
			'show_tagcloud'     => FALSE,
			'public'            => FALSE,
			'rewrite'           => FALSE,
			'show_in_nav_menus' => FALSE,
			'public'            => TRUE
		)
	);

}
	add_action('init', 'calluna_event_register');
	
	/**
 * Add date column to admin UI
 *
 * @param array $columns
 * @return array
 */
function calluna_add_event_columns($columns) {
	$date = $columns['date'];
	unset($columns['date']);
	$columns['event_date'] = esc_html__('Event Date', 'calluna-td');
	$columns['event_time'] = esc_html__('Event Time', 'calluna-td');
	$columns['date'] = $date;
	return $columns;
}
add_action('manage_edit-event_columns', 'calluna_add_event_columns');


/**
 * Render the date column in admin UI
 *
 * @param string $column_name
 * @param int $post_id
 */
function calluna_event_columns($column_name, $post_id) {
	if ($column_name == 'event_date') {
		echo date('Y/m/d', strtotime(get_post_meta($post_id, '_calluna_event_date', TRUE)));
	}
	if ($column_name == 'event_time') {
		echo date('g:i a', strtotime(get_post_meta($post_id, '_calluna_event_time', TRUE)));
	}
}
add_action('manage_event_posts_custom_column', 'calluna_event_columns', 10, 2);

/**
 * Add CSS for custom column in admin UI
 */
function calluna_event_columns_css() {
	echo '<style>th#event_date { width: 10%; } </style>';
	echo '<style>th#event_time { width: 10%; } </style>';
}
add_action('admin_head', 'calluna_event_columns_css');

	
	// Register Offer Post Type
function calluna_offer_register() {
    register_post_type( 'offer', apply_filters( 'calluna_post_type_offer', array(
        'labels' => array(
            "name" => esc_html__( 'Offers', 'calluna-td' ),
            "singular_name" => esc_html__( 'Offer', 'calluna-td' ),
            "menu_name" => esc_html__( 'Offers', 'calluna-td' ),
            'name_admin_bar'=> esc_html__( 'Offer', 'calluna-td' ),
            'add_new'   => esc_html__( 'Add New', 'calluna-td' ),
            'add_new_item'=> esc_html__( 'Add New Offer', 'calluna-td' ),
            'new_item'    => esc_html__( 'New Offer', 'calluna-td' ),
            'edit_item'     => esc_html__( 'Edit Offer', 'calluna-td' ),
            'view_item'   => esc_html__( 'View Offer', 'calluna-td' ),
            'all_items'     => esc_html__( 'All Offers', 'calluna-td' ),
            'search_items'=> esc_html__( 'Search Offers', 'calluna-td' ),
            'parent_item_colon' => esc_html__( 'Parent Offers:', 'calluna-td' ),
            'not_found'  => esc_html__( 'No offers found.', 'calluna-td' ),
            'not_found_in_trash' => esc_html__( 'No offers found in trash.', 'calluna-td' )
        ),
        "description" => esc_html__('Offer Post Type', 'calluna-td'),
        "public" => true,
        "show_ui" => true,
        "has_archive" => false,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "offer", "with_front" => true ),
        "query_var" => true,
        "menu_position" => 5,
        "supports" => array( "title", "editor", "excerpt", "thumbnail" )
    ) ) );
		
		register_taxonomy('offer_category', 'offer',
		array(
			'labels'            => array(
				'name'              => esc_html__('Offer Categories', 'calluna-td'),
				'singular_name'     => esc_html__('Offer Categories', 'calluna-td'),
				'search_items'      => esc_html__('Search Offer Categories', 'calluna-td'),
				'popular_items'     => esc_html__('Popular Offer Categories', 'calluna-td'),
				'all_items'         => esc_html__('All Offer Categories', 'calluna-td'),
				'parent_item'       => esc_html__('Parent Offer Category', 'calluna-td'),
				'parent_item_colon' => esc_html__('Parent Offer Category:', 'calluna-td'),
				'edit_item'         => esc_html__('Edit Offer Category', 'calluna-td'),
				'update_item'       => esc_html__('Update Offer Category', 'calluna-td'),
				'add_new_item'      => esc_html__('Add New Offer Category', 'calluna-td'),
				'new_item_name'     => esc_html__('New Offer Category', 'calluna-td'),
			),
			'hierarchical'      => TRUE,
			'show_ui'           => TRUE,
			'show_tagcloud'     => FALSE,
			'public'            => FALSE,
			'rewrite'           => FALSE,
			'show_in_nav_menus' => FALSE,
			'public'            => TRUE
		)
	);

}
	add_action('init', 'calluna_offer_register');
	
	/**
 * Add price column to admin UI
 *
 * @param array $columns
 * @return array
 */
function calluna_add_offer_columns($columns) {
	$date = $columns['date'];
	unset($columns['date']);
	$columns['offer_price'] = esc_html__('Price', 'calluna-td');
	$columns['date'] = $date;
	return $columns;
}
add_action('manage_edit-offer_columns', 'calluna_add_offer_columns');


/**
 * Render the price column in admin UI
 *
 * @param string $column_name
 * @param int $post_id
 */
function calluna_offer_columns($column_name, $post_id) {
	if ($column_name == 'offer_price') {
		echo (get_post_meta($post_id, '_calluna_offer_price', TRUE));
	}
}
add_action('manage_offer_posts_custom_column', 'calluna_offer_columns', 10, 2);

/**
 * Add CSS for custom column in admin UI
 */
function calluna_offer_columns_css() {
	echo '<style>th#offer_price { width: 10%; } </style>';
}
add_action('admin_head', 'calluna_offer_columns_css');

?>