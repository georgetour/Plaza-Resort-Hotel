<?php
/**
 * Map all shortcodes to the Visual Composer
 *
 * @package   Calluna Shortcodes
 * @author    Themetwins
 */
 
 add_filter( 'vc_grid_item_shortcodes', 'calluna_add_grid_shortcodes' );
	function calluna_add_grid_shortcodes( $shortcodes ) {
	   $shortcodes['vc_calluna_room_price'] = array(
		 'name' => esc_html__( 'Calluna Room Price', 'calluna-shortcodes' ),
		 'base' => 'vc_calluna_room_price',
		 'category' => esc_html__( 'Calluna', 'calluna_td' ),
		 'description' => esc_html__( 'Show the room price', 'calluna-shortcodes' ),
		 'post_type' => Vc_Grid_Item_Editor::postType(),
	  );
	 
	 
	   return $shortcodes;
	}
	
	
	add_filter( 'vc_grid_item_shortcodes', 'calluna_add_grid2_shortcodes' );
	function calluna_add_grid2_shortcodes( $shortcodes ) {
	   $shortcodes['vc_calluna_offer_price'] = array(
		 'name' => esc_html__( 'Calluna Offer Price', 'calluna-shortcodes' ),
		 'base' => 'vc_calluna_offer_price',
		 'category' => esc_html__( 'Calluna', 'calluna_td' ),
		 'description' => esc_html__( 'Show the offer price', 'calluna-shortcodes' ),
		 'post_type' => Vc_Grid_Item_Editor::postType(),
	  );
	 
	 
	   return $shortcodes;
	}
	
function calluna_shortcodes_vc_map() {
	
	/* ------------------------------------------------------------------------------- */
	/* VC Parameters
	/* ------------------------------------------------------------------------------- */
	
	/* Number ------------------------------------------------------------------------ */

	function calluna_shortcodes_number_settings_field($settings, $value) {
		$dependency = vc_generate_dependencies_attributes($settings);
		$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
		$type       = isset($settings['type']) ? $settings['type'] : '';
		$min        = isset($settings['min']) ? $settings['min'] : '';
		$max        = isset($settings['max']) ? $settings['max'] : '';
		$suffix     = isset($settings['suffix']) ? $settings['suffix'] : '';
		$class      = isset($settings['class']) ? $settings['class'] : '';
		$output     = '<input type="number" min="' . $min . '" max="' . $max . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" style="max-width:100px; margin-right: 10px;" />' . $suffix;
		return $output;
	}

	if (function_exists('vc_add_shortcode_param')) {
		vc_add_shortcode_param('number', 'calluna_shortcodes_number_settings_field');
	}
	
	/* Label for Booking Calendar--------------------------------------------------------- */

	function calluna_shortcodes_label_settings_field($settings, $value) {
		$dependency = vc_generate_dependencies_attributes($settings);
		$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
		$type       = isset($settings['type']) ? $settings['type'] : '';
		$output     = '<label class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '"  style="max-width:100px; margin-right: 10px;">'. esc_html__( "After adding the calendar you can change the text and link for the reservation button and some additional texts with the theme customizer in the booking calendar section.", 'calluna-shortcodes' ). '</label>';
		return $output;
	}

	if (function_exists('vc_add_shortcode_param')) {
		vc_add_shortcode_param('label', 'calluna_shortcodes_label_settings_field');
	}


	/* Offer Category Dropdown --------------------------------------------------- */

	function calluna_shortcodes_offer_cats_settings_field($settings, $value) {

		$dependency  = vc_generate_dependencies_attributes($settings);
		$cats_output = '<div class="offer_categories">'
			. '<select name="' . $settings['param_name']
			. '" class="wpb_vc_param_value wpb-select dropdown '
			. $settings['param_name'] . ' ' . $settings['type'] . '_field">'
			. '<option value="">All Categories</option>';
		/* Get categories */
		$terms = get_terms('offer_category', array(
			'orderby'    => 'name',
			'hide_empty' => TRUE
		));
		foreach ($terms as $term) {
			$cats_output .= '<option value="' . $term->term_id . '"';
			if ($term->term_id == $value) {
				$cats_output .= 'selected="selected"';
			}
			$cats_output .= '>' . $term->name . '</option>';
		}
		$cats_output .= '</select>'
			. '</div>';
		return $cats_output;
	}

	if (function_exists('vc_add_shortcode_param')) {
		vc_add_shortcode_param('offer_cats', 'calluna_shortcodes_offer_cats_settings_field');
	}
	
	/* Event Category Dropdown --------------------------------------------------- */

	function calluna_shortcodes_event_cats_settings_field($settings, $value) {

		$dependency  = vc_generate_dependencies_attributes($settings);
		$cats_output = '<div class="event_categories">'
			. '<select name="' . $settings['param_name']
			. '" class="wpb_vc_param_value wpb-select dropdown '
			. $settings['param_name'] . ' ' . $settings['type'] . '_field">'
			. '<option value="">All Categories</option>';
		/* Get categories */
		$terms = get_terms('event_category', array(
			'orderby'    => 'name',
			'hide_empty' => TRUE
		));
		foreach ($terms as $term) {
			$cats_output .= '<option value="' . $term->term_id . '"';
			if ($term->term_id == $value) {
				$cats_output .= 'selected="selected"';
			}
			$cats_output .= '>' . $term->name . '</option>';
		}
		$cats_output .= '</select>'
			. '</div>';
		return $cats_output;
	}

	if (function_exists('vc_add_shortcode_param')) {
		vc_add_shortcode_param('event_cats', 'calluna_shortcodes_event_cats_settings_field');
	}
	
	//Font Awesome Icon Param ------------------------------------------------------------- >
	function calluna_shortcodes_font_awesome_icon_field( $settings, $value ) {
			wp_enqueue_script('calluna-icon');
            $dependency = vc_generate_dependencies_attributes( $settings );
            $return = '<div class="my_param_block">
                <div class="vcex-font-awesome-icon-preview"></div>
                <input placeholder="' . esc_html__( "Type in an icon name or select one from below", 'calluna-shortcodes' ) . '" name="' . $settings['param_name'] . '"'
            . ' data-param-name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'].' '.$settings['type'].'_field" type="text" value="'. $value .'" ' . $dependency . ' style="width: 100%; vertical-align: top; margin-bottom: 10px" />';
            $return .= '<div class="vcex-font-awesome-icon-select-window">
                        <span class="fa fa-times" style="color:red;" data-name="clear"></span>';
                            $icons = calluna_shortcodes_font_icons_array();
                            foreach ( $icons as $icon ) {
                                if ( '' != $icon ) {
                                    if ( $value == $icon ) {
                                        $active = 'active';
                                    } else {
                                        $active = '';
                                    }
                                    $return .= '<span class="fa fa-'. $icon .' '. $active .'" data-name="'. $icon .'"></span>';
                                }
                            }
            $return .= '</div></div><div style="clear:both;"></div>';
            return $return;
        }
		
	
	// Store data -------------------------------------------------------------------------- >
	$order_by = array(
		 esc_html__( 'Date', 'calluna-shortcodes' )           => 'date',
		 esc_html__( 'Name', 'calluna-shortcodes' )          => 'name',
		 esc_html__( 'Modified', 'calluna-shortcodes' )       => 'modified',
		 esc_html__( 'Author', 'calluna-shortcodes' )        => 'author',
		 esc_html__( 'Random', 'calluna-shortcodes' )         => 'random',
		 esc_html__( 'Comment Count', 'calluna-shortcodes' ) => 'comment_count',
	);
	$room_order_by = array(
		 esc_html__( 'Price', 'calluna-shortcodes' )           => 'price',
		 esc_html__( 'Date', 'calluna-shortcodes' )           => 'date',
		 esc_html__( 'Name', 'calluna-shortcodes' )          => 'name',
		 esc_html__( 'Random', 'calluna-shortcodes' )         => 'random',
	);
	
	$button_sizes = array(
		esc_html__( 'Default', 'calluna-shortcodes' )  => '',
		esc_html__( 'Small', 'calluna-shortcodes' )    => 'small',
		esc_html__( 'Medium', 'calluna-shortcodes' )   => 'medium',
		esc_html__( 'Large', 'calluna-shortcodes' )    => 'large',
	);

	
	// Booking Calendar ----------------------------------------------------------------------- >
	vc_map(array(
			"name"                    => esc_html__("Calluna Booking Calendar", 'calluna-shortcodes'),
			"description"             => esc_html__("Choose dates", 'calluna-shortcodes'),
			"base"                    => "cl_booking_calendar",
			"class"                   => "",
			"controls"                => "full",
			"icon"                    => "calluna_vc_icon",
			"category"                => esc_html__("Calluna", 'calluna-shortcodes'),
			"show_settings_on_create" => TRUE,
			"params"                  => array(
				array(
					"type"        => "label",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Info", 'calluna-shortcodes'),
					"param_name"  => "calendar_label",
				))
		));

	// Google Map ----------------------------------------------------------------------------- >
	vc_map(array(
			"name"                    => esc_html__("Calluna Google Map", 'calluna-shortcodes'),
			"base"                    => "cl_google_map",
			"class"                   => "",
			"controls"                => "full",
			"icon"                    => "calluna_vc_icon",
			"category"                => esc_html__("Calluna", 'calluna-shortcodes'),
			"show_settings_on_create" => TRUE,
			"params"                  => array(
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Map Type", 'calluna-shortcodes'),
					"param_name"  => "map_type",
					"value"       => array(
						esc_html__("Road Map", 'calluna-shortcodes')   => 'ROADMAP',
						esc_html__("Satellite", 'calluna-shortcodes') => 'SATELLITE',
						esc_html__("Hybrid", 'calluna-shortcodes')    => 'HYBRID',
						esc_html__("Terrain", 'calluna-shortcodes')   => 'TERRAIN'
					),
				),
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Map Style", 'calluna-shortcodes'),
					"param_name"  => "style",
					"value"       => array(
						esc_html__( 'Shades of Grey', 'calluna-shortcodes' ) 	=> "1",
						esc_html__( 'Greyscale', 'calluna-shortcodes' ) 			=> "2",
						esc_html__( 'Light Gray', 'calluna-shortcodes' ) 		=> "3",
						esc_html__( 'Midnight Commander', 'calluna-shortcodes' ) 		=> "4",
						esc_html__( 'Blue water', 'calluna-shortcodes' ) 		=> "5",
						esc_html__( 'Icy Blue', 'calluna-shortcodes' ) 			=> "6",
						esc_html__( 'Bright and Bubbly', 'calluna-shortcodes' ) 	=> "7",
						esc_html__( 'Pale Dawn', 'calluna-shortcodes' ) 			=> "8",
						esc_html__( 'Paper', 'calluna-shortcodes' ) 				=> "9",
						esc_html__( 'Blue Essence', 'calluna-shortcodes' ) 		=> "10",
						esc_html__( 'Apple Maps-esque', 'calluna-shortcodes' ) 	=> "11",
						esc_html__( 'Subtle Grayscale', 'calluna-shortcodes' ) 	=> "12",
						esc_html__( 'Retro', 'calluna-shortcodes' ) 				=> "13",
						esc_html__( 'Hopper', 'calluna-shortcodes' ) 			=> "14",
						esc_html__( 'Red Hues', 'calluna-shortcodes' ) 			=> "15",
						esc_html__( 'Ultra Light with labels', 'calluna-shortcodes' ) 	=> "16",
						esc_html__( 'Unsaturated Browns', 'calluna-shortcodes' ) => "17",
						esc_html__( 'Light Dream', 'calluna-shortcodes' ) 		=> "18",
						esc_html__( 'Neutral Blue', 'calluna-shortcodes' ) 		=> "19",
						esc_html__( 'MapBox', 'calluna-shortcodes' ) 			=> "20",
					)
				),
				array(
					"type"        => "number",
					"holder"      => "div",
					"suffix"      => "px",
					"class"       => "",
					"heading"     => esc_html__("Height", 'calluna-shortcodes'),
					"param_name"  => "height",
					"value"       => "300"
				),
				array(
					"type"        => "textfield",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Latitude", 'calluna-shortcodes'),
					"param_name"  => "lat",
					"value"       => "51.4946416",
				),
				array(
					"type"        => "textfield",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Longitude", 'calluna-shortcodes'),
					"param_name"  => "lng",
					"value"       => "-0.172699",
				),
				array(
					"type"        => "number",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Zoom", 'calluna-shortcodes'),
					"param_name"  => "zoom",
					"value"       => "12"
				),
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Show Marker?", 'calluna-shortcodes'),
					"param_name"  => "marker",
					"value"       => array(
						esc_html__("Yes", 'calluna-shortcodes') => 'yes',
						esc_html__("No", 'calluna-shortcodes')  => 'no',
					),
				)
			),
		));
	// Image Gallery -------------------------------------------------------------------------- >
	vc_map(array(
			"name"                    => esc_html__("Calluna Gallery", 'calluna-shortcodes'),
			"base"                    => "cl_gallery",
			"class"                   => "",
			"controls"                => "full",
			"icon"                    => "calluna_vc_icon",
			"category"                => esc_html__("Calluna", 'calluna-shortcodes'),
			"show_settings_on_create" => TRUE,
			"params"                  => array(
				array(
					"type"        => "attach_images",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Select images", 'calluna-shortcodes'),
					"param_name"  => "images",
					"value"       => "",
				),
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Image Links", 'calluna-shortcodes'),
					"param_name"  => "link_images",
					"value"       => array(
						esc_html__("No Link", 'calluna-shortcodes')                    => 'none',
						esc_html__("Open Image in PrettyPhoto", 'calluna-shortcodes') => 'prettyphoto',
						esc_html__("Link Image in new tab", 'calluna-shortcodes')     => 'newtab'
					),
				),
			)
		));
	// Offer Carousel ------------------------------------------------------------------------- >
	vc_map(array(
			"name"                    => esc_html__("Calluna Offer Carousel", 'calluna-shortcodes'),
			"base"                    => "cl_offer_carousel",
			"class"                   => "",
			"controls"                => "full",
			"icon"                    => "calluna_vc_icon",
			"category"                => esc_html__("Calluna", 'calluna-shortcodes'),
			"show_settings_on_create" => TRUE,
			"params"                  => array(
				array(
					"type"        => "offer_cats",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Offer Category", 'calluna-shortcodes'),
					"param_name"  => "parent_cat",
				),
			  	array(
					"type"        => "number",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Visible Items", 'calluna-shortcodes'),
					"param_name"  => "items",
					"value"       => "3",
				),
				array(
					"type"        => "number",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Maximum Items", 'calluna-shortcodes'),
					"param_name"  => "max_items",
					"value"       => "8",
				),
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Carousel Rotation", 'calluna-shortcodes'),
					"param_name"  => "wrap",
					"value"       => array(
						esc_html__("Continuous", 'calluna-shortcodes')   => 'circular',
						esc_html__("Stop at end", 'calluna-shortcodes') => 'none'
					),
				),
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Show Featured Images?", 'calluna-shortcodes'),
					"param_name"  => "featured_images",
					"value"       => array(
						esc_html__("Yes", 'calluna-shortcodes') => 'yes',
						esc_html__("No", 'calluna-shortcodes')  => 'no',
					),
				),
			)
		));
	// Event Carousel ------------------------------------------------------------------------- >
	vc_map(array(
		"name"                    => esc_html__("Calluna Event Carousel", 'calluna-shortcodes'),
		"base"                    => "cl_event_carousel",
		"class"                   => "",
		"controls"                => "full",
		"icon"                    => "calluna_vc_icon",
		"category"                => esc_html__("Calluna", 'calluna-shortcodes'),
		"show_settings_on_create" => TRUE,
		"params"                  => array(

			array(
				"type"        => "number",
				"holder"      => "div",
				"class"       => "",
				"heading"     => esc_html__("Visible Items", 'calluna-shortcodes'),
				"param_name"  => "items",
				"value"       => "3",
			),
			array(
				"type"        => "number",
				"holder"      => "div",
				"class"       => "",
				"heading"     => esc_html__("Maximum Items", 'calluna-shortcodes'),
				"param_name"  => "max_items",
				"value"       => "8",
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> esc_html__( "Categories", 'calluna-shortcodes' ),
				"param_name"	=> "categories",
				"value"			=> "all",
				"description"	=> esc_html__( "Category Slugs - For example: sports, business, all", 'calluna-shortcodes' )
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Order', 'calluna-shortcodes' ),
				'param_name'	=> 'order',
				'description'	=> sprintf( wp_kses(__( 'Designates the ascending or descending order. More at %s.', 'calluna-shortcodes' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
				'value'			=> array(
					esc_html__( 'DESC', 'calluna-shortcodes' )	=> 'DESC',
                    esc_html__( 'ASC', 'calluna-shortcodes' )	=> 'ASC',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Order By', 'calluna-shortcodes' ),
				'param_name'	=> 'orderby',
				'description'	=> sprintf( wp_kses(__( 'Select how to sort retrieved posts. More at %s.', 'calluna-shortcodes' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
				'value'			=> $order_by,
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => esc_html__("Show Featured Images?", 'calluna-shortcodes'),
				"param_name"  => "featured_images",
				"value"       => array(
					esc_html__("Yes", 'calluna-shortcodes') => 'yes',
					esc_html__("No", 'calluna-shortcodes')  => 'no',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Thumbnail Crop', 'calluna-shortcodes' ),
				'param_name'	=> 'img_crop',
				'value'			=> array(
					esc_html__( 'Yes', 'calluna-shortcodes' )  => 'true',
					esc_html__( 'No', 'calluna-shortcodes' ) => 'false',
				),
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Thumbnail Width', 'calluna-shortcodes' ),
				'param_name'	=> 'img_width',
				'description'	=> esc_html__( 'Enter a width in pixels.', 'calluna-shortcodes' ),
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Thumbnail Height', 'calluna-shortcodes' ),
				'param_name'	=> 'img_height',
				'description'	=> esc_html__( 'Enter a height in pixels. Set to "9999" to disable vertical cropping and keep image proportions.', 'calluna-shortcodes' ),
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Excerpt Length', 'calluna-shortcodes' ),
				'param_name'	=> 'excerpt_length',
				'value'			=> '30',
				'description'	=> esc_html__( 'Excerpt Length, only used when event has no excerpt.', 'calluna-shortcodes' ),
			),
		)
	));
	// Room Carousel -------------------------------------------------------------------------- >
	vc_map(array(
			"name"                    => esc_html__("Calluna Room Carousel", 'calluna-shortcodes'),
			"base"                    => "cl_room_carousel",
			"class"                   => "",
			"controls"                => "full",
			"icon"                    => "calluna_vc_icon",
			"category"                => esc_html__("Calluna", 'calluna-shortcodes'),
			"show_settings_on_create" => TRUE,
			"params"                  => array(
				array(
					"type"        => "number",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Visible Items", 'calluna-shortcodes'),
					"param_name"  => "items",
					"value"       => "3",
				),
				array(
					"type"        => "number",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Maximum Items", 'calluna-shortcodes'),
					"param_name"  => "max_items",
					"value"       => "8",
				),
				array(
						"type"			=> "textfield",
						"admin_label"	=> true,
						"class"			=> "",
						"heading"		=> esc_html__( "Categories", 'calluna-shortcodes' ),
						"param_name"	=> "categories",
						"value"			=> "all",
						"description"	=> esc_html__( "Category Slugs - For example: sports, business, all", 'calluna-shortcodes' )
				),
				array(
                    'type'			=> 'dropdown',
                    'heading'		=> esc_html__( 'Order', 'calluna-shortcodes' ),
                    'param_name'	=> 'order',
                    'description'	=> sprintf( wp_kses(__( 'Designates the ascending or descending order. More at %s.', 'calluna-shortcodes' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
                    'value'			=> array(
                        esc_html__( 'ASC', 'calluna-shortcodes' )	=> 'ASC',
                        esc_html__( 'DESC', 'calluna-shortcodes' )	=> 'DESC',
                    ),
                ),
                array(
                    'type'			=> 'dropdown',
                    'heading'		=> esc_html__( 'Order By', 'calluna-shortcodes' ),
                    'param_name'	=> 'orderby',
                    'description'	=> sprintf( wp_kses(__( 'Select how to sort retrieved posts. More at %s.', 'calluna-shortcodes' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
                    'value'			=> $room_order_by,
                ),
                array(
                        'type'			=> 'textfield',
                        'heading'		=> esc_html__( 'Excerpt Length', 'calluna-shortcodes' ),
                        'param_name'	=> 'excerpt_length',
                        'value'			=> '30',
                        'description'	=> esc_html__( 'How many words do you want to display for your excerpt?', 'calluna-shortcodes' ),
                ),
                array(
                        'type'			=> 'dropdown',
                        'heading'		=> esc_html__( 'Thumbnail Crop', 'calluna-shortcodes' ),
                        'param_name'	=> 'img_crop',
                        'value'			=> array(
                                esc_html__( 'Yes', 'calluna-shortcodes' )  => 'true',
                                esc_html__( 'No', 'calluna-shortcodes' ) => 'false',
                        ),
                ),
                array(
                        'type'			=> 'textfield',
                        'heading'		=> esc_html__( 'Thumbnail Width', 'calluna-shortcodes' ),
                        'param_name'	=> 'img_width',
                        'description'	=> esc_html__( 'Enter a width in pixels.', 'calluna-shortcodes' ),
                ),
                array(
                        'type'			=> 'textfield',
                        'heading'		=> esc_html__( 'Thumbnail Height', 'calluna-shortcodes' ),
                        'param_name'	=> 'img_height',
                        'description'	=> esc_html__( 'Enter a height in pixels. Set to "9999" to disable vertical cropping and keep image proportions.', 'calluna-shortcodes' ),
                ),
                array(
                    'type'			=> 'textfield',
                    'heading'		=> esc_html__( 'Button Text', 'calluna-shortcodes' ),
                    'param_name'	=> 'button_text',
                    'description'	=> esc_html__( 'Enter a button text.', 'calluna-shortcodes' ),
                    'value'	        => esc_html__( 'starting at', 'calluna-shortcodes' ),

                ),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Button: Style', 'calluna-shortcodes' ),
					'param_name'	=> 'button_style',
					'description'	=> esc_html__( 'Select a button style.', 'calluna-shortcodes' ),
					'value'			=> array(
						 esc_html__( 'Style 1', 'calluna-shortcodes' )  => 'style-1',
						 esc_html__( 'Style 2', 'calluna-shortcodes' )	  => 'style-2'
					),
				),
                array(
                    'type'			=> 'dropdown',
                    'heading'		=> esc_html__( 'Button: Show Price', 'calluna-shortcodes' ),
                    'param_name'	=> 'button_price',
                    'description'	=> esc_html__( 'Show price on button.', 'calluna-shortcodes' ),
                    'value'			=> array(
                        esc_html__( 'Yes', 'calluna-shortcodes' )  => 'yes',
                        esc_html__( 'No', 'calluna-shortcodes' )	  => 'no'
                    ),
                ),
			)
		));
	// Time ----------------------------------------------------------------------------------- >
	vc_map(array(
			"name"                    => esc_html__("Calluna Local Time", 'calluna-shortcodes'),
			"description"             => esc_html__("show the local time", 'calluna-shortcodes'),
			"base"                    => "cl_time",
			"class"                   => "",
			"controls"                => "full",
			"icon"                    => "calluna_vc_icon",
			"category"                => esc_html__("Calluna", 'calluna-shortcodes'),
			"show_settings_on_create" => TRUE,
			"params"                  => array(
			
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Time icon", 'calluna-shortcodes'),
					"description" => esc_html__("show time icon", 'calluna-shortcodes'),
					"param_name"  => "icon",
					"value"       => array(
						esc_html__("yes", 'calluna-shortcodes')  => 'yes',
						esc_html__("no", 'calluna-shortcodes')  => 'no'
					),
				),
				array(
					"type"        => "colorpicker",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Icon Color", 'calluna-shortcodes'),
					"param_name"  => "icon_color",
					"value"       => ""
				),
				array(
					"type"        => "colorpicker",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Text Color", 'calluna-shortcodes'),
					"param_name"  => "text_color",
					"value"       => ""
				),
				array(
					"type"        => "textfield",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Time Format", 'calluna-shortcodes'),
					"param_name"  => "time_format",
					"value"       => "h:i A"
				),
			),
		));
		// Weather ------------------------------------------------------------------------ >
	vc_map(array(
			"name"                    => esc_html__("Calluna Weather", 'calluna-shortcodes'),
			"description"             => esc_html__("Show the weather", 'calluna-shortcodes'),
			"base"                    => "simple-weather",
			"class"                   => "",
			"controls"                => "full",
			"icon"                    => "calluna_vc_icon",
			"category"                => esc_html__("Calluna", 'calluna-shortcodes'),
			"show_settings_on_create" => TRUE,
			"params"                  => array(
				array(
					"type"        => "textfield",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Location", 'calluna-shortcodes'),
					"description" => esc_html__("Add city", 'calluna-shortcodes'),
					"param_name"  => "location",
					"value"       => "Hanover, GER"
				),
				array(
					"type"        => "textfield",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Latitude", 'calluna-shortcodes'),
					"description" => esc_html__("Add latitude", 'calluna-shortcodes'),
					"param_name"  => "latitude",
					"value"       => ""
				),
				array(
					"type"        => "textfield",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Longitude", 'calluna-shortcodes'),
					"description" => esc_html__("Add longitude", 'calluna-shortcodes'),
					"param_name"  => "longitude",
					"value"       => ""
				),
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Units", 'calluna-shortcodes'),
					"description" => esc_html__("Internal, metric or imperial", 'calluna-shortcodes'),
					"param_name"  => "units",
					"value"       => array(
						esc_html__("Internal", 'calluna-shortcodes')  => 'internal',
						esc_html__("Metric", 'calluna-shortcodes')  => 'metric',
						esc_html__("Imperial", 'calluna-shortcodes')  => 'imperial'
					),
				),
				array(
					"type"        => "textfield",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Date", 'calluna-shortcodes'),
					"description" => esc_html__("Date format according to: http://php.net/manual/ro/function.date.php", 'calluna-shortcodes'),
					"param_name"  => "date",
					"value"       => ""
				),
			),
		));
		
	// Callouts -------------------------------------------------------------------------- >
	vc_map( array(
		'name'        => esc_html__( 'Calluna Callout', 'calluna-shortcodes' ),
		'base'        => 'cl_callout',
		'description' => esc_html__( 'Call to action area', 'calluna-shortcodes' ),
		'category'    => esc_html__( 'Calluna', 'calluna-shortcodes' ),
		'icon'        => 'calluna_vc_icon',
		'params'      => array(
			array(
				'type'			=> 'textarea_html',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Callout Content', 'calluna-shortcodes' ),
				'param_name'	=> 'content',
				'value'			=> esc_html__( 'Enter your content here.', 'calluna-shortcodes' ),
				'description'	=> esc_html__( 'Callout Content', 'calluna-shortcodes' ),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Fade In', 'calluna-shortcodes' ),
				'param_name'	=> 'fade_in',
				'description'	=> esc_html__( 'Fade In Animation', 'calluna-shortcodes' ),
				'value'			=> array(
				 	esc_html__( 'No', 'calluna-shortcodes' )	=> 'false',
					esc_html__( 'Yes', 'calluna-shortcodes' )	=> 'true',
				),
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Button: URL', 'calluna-shortcodes' ),
				'param_name'	=> 'button_url',
				'value'			=> '#',
				'description'	=> esc_html__( 'Button: URL', 'calluna-shortcodes' )
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Button: Text', 'calluna-shortcodes' ),
				'param_name'	=> 'button_text',
				'value'			=> 'Button Text',
				'description'	=> esc_html__( 'Button: Text', 'calluna-shortcodes' )
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Button: Style', 'calluna-shortcodes' ),
				'param_name'	=> 'button_style',
				'description'	=> esc_html__( 'Select a button style.', 'calluna-shortcodes' ),
				'value'			=> array(
					 esc_html__( 'Style 1', 'calluna-shortcodes' )  => 'style-1',
					 esc_html__( 'Style 2', 'calluna-shortcodes' )	  => 'style-2'
				),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Button: Size', 'calluna-shortcodes' ),
				'param_name'  => 'button_size',
				'description' => esc_html__( 'Select a button size.', 'calluna-shortcodes' ),
				'value'       => $button_sizes,
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Button: Link Target', 'calluna-shortcodes' ),
				'param_name'	=> 'button_target',
				'value'			=> array(
					 esc_html__( 'Self', 'calluna-shortcodes' )		=> 'self',
					 esc_html__( 'Blank', 'calluna-shortcodes' )	=> 'blank',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Button: Rel', 'calluna-shortcodes' ),
				'param_name'	=> 'button_rel',
				'value'			=> array(
					 esc_html__( 'None', 'calluna-shortcodes' )			=> 'none',
					 esc_html__( 'Nofollow', 'calluna-shortcodes' )	=> 'nofollow',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Button: Icon Left', 'calluna-shortcodes' ),
				'param_name'	=> 'button_icon_left',
				'description'	=> sprintf( wp_kses(__( 'Icon to the left of your button text. See all the icons at %s', 'calluna-shortcodes' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome</a>' ),
				'value'			=> calluna_shortcodes_font_icons_array(),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> __( 'Button: Icon Right', 'calluna-shortcodes' ),
				'param_name'	=> 'button_icon_right',
				'description'	=> sprintf( wp_kses(__( 'Icon to the right of your button text. See all the icons at %s', 'calluna-shortcodes' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome</a>' ),
				'value'			=> calluna_shortcodes_font_icons_array(),
			),
		)
	) );
	
	// Highlights -------------------------------------------------------------------------- >
	vc_map( array(
		'name'        => esc_html__( 'Calluna Highlight', 'calluna-shortcodes' ),
		'base'        => 'cl_highlight',
		'description' => esc_html__( 'Text highlighter', 'calluna-shortcodes' ),
		'category'    => esc_html__( 'Calluna' , 'calluna-shortcodes' ),
		'icon'        => 'calluna_vc_icon',
		'params'      => array(
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Color', 'calluna-shortcodes' ),
				'param_name'	=> 'color',
				'value'			=> array(
					esc_html__( 'Blue', 'calluna-shortcodes' )   => 'blue',
					esc_html__( 'Green', 'calluna-shortcodes' )  => 'green',
					esc_html__( 'Gray', 'calluna-shortcodes' )   => 'gray',
					esc_html__( 'Red', 'calluna-shortcodes' )    => 'red',
					esc_html__( 'Yellow', 'calluna-shortcodes' ) => 'yellow',
				),
			),
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Highlighted Text', 'calluna-shortcodes' ),
				'param_name'	=> 'content',
				'value'			=> 'highlight me please',
				'description'	=> esc_html__( 'Add the text to be highlighted.', 'calluna-shortcodes' )
			),
		)
	) );
	
	// Testimonials -------------------------------------------------------------------------- >
	vc_map( array(
		'name'				=> esc_html__( 'Calluna Testimonial', 'calluna-shortcodes' ),
		'base'				=> 'cl_testimonial',
		'description'		=> esc_html__( 'Single testimonial', 'calluna-shortcodes' ),
		'category'			=> esc_html__( 'Calluna', 'calluna-shortcodes' ),
		'icon'        => 'calluna_vc_icon',
		'params'			=> array(
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Author', 'calluna-shortcodes' ),
				'param_name'	=> 'by',
				'value'			=> 'Unknown Person',
				'description'	=> esc_html__( 'Testimonial Author', 'calluna-shortcodes' )
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Author Position', 'calluna-shortcodes' ),
				'param_name'	=> 'position',
				'value'			=> 'Unknown Position',
				'description'	=> esc_html__( 'Testimonial Author Position', 'calluna-shortcodes' )
			),
			array(
					"type"        => "attach_image",
					"holder"      => "div",
					"class"       => "author_image",
					"heading"     => esc_html__("Author image", 'calluna-shortcodes'),
					"description" => "",
					"param_name"  => "image",
					"value"       => "",
				),
			array(
				'type'			=> 'textarea_html',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Testimonial Content', 'calluna-shortcodes' ),
				'param_name'	=> 'content',
				'value'			=> esc_html__( 'This product is amazing!', 'calluna-shortcodes' ),
				'description'	=> esc_html__( 'This is where your testimonial goes.', 'calluna-shortcodes' )
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Fade In', 'calluna-shortcodes' ),
				'param_name'	=> 'fade_in',
				'description'	=> esc_html__( 'Fade In Animation', 'calluna-shortcodes' ),
				'value'			=> array(
				 	esc_html__( 'No', 'calluna-shortcodes' )	=> 'false',
					esc_html__( 'Yes', 'calluna-shortcodes' )	=> 'true',
				),
			),
		)
	) );

	// WPML -------------------------------------------------------------------------- >
	/*if ( function_exists( 'icl_get_languages' ) ) {
		$ssp_wpml_type = 'dropdown';
		$ssp_wpml_value = icl_get_languages();
	} else {
		$ssp_wpml_type = 'textfield';
		$ssp_wpml_value = 'es';
	}*/

	vc_map( array(
		'name'				=> esc_html__( 'WPML', 'calluna-shortcodes' ),
		'base'				=> 'cl_wpml',
		'description'		=> esc_html__( 'WPML translatable text.', 'calluna-shortcodes' ),
		'category'			=> esc_html__( 'Calluna', 'calluna-shortcodes' ),
		'icon'        => 'calluna_vc_icon',
		'params'			=> array(
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Language', 'calluna-shortcodes' ),
				'param_name'	=> 'lang',
				'value'			=> 'es',
				'description'	=> esc_html__( 'Select a WPML language.', 'calluna-shortcodes' ),
			),
			array(
				'type'			=> 'textarea_html',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Content', 'calluna-shortcodes' ),
				'param_name'	=> 'content',
				'value'			=> 'Hola',
			),
		)
	) );
	
	// Pricing Tables -------------------------------------------------------------------------- >
	vc_map( array(
		'name'        => esc_html__( 'Calluna Pricing Table', 'calluna-shortcodes' ),
		'base'        => 'cl_pricing',
		'description' => esc_html__( 'Insert a pricing column', 'calluna-shortcodes' ),
		'category'    => esc_html__( 'Calluna', 'calluna-shortcodes' ),
		'icon'        => 'calluna_vc_icon',
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Featured Pricing', 'calluna-shortcodes' ),
				'param_name' => 'featured',
				'value'      => array(
					esc_html__( 'No', 'calluna-shortcodes' )	=> 'no',
					esc_html__( 'Yes', 'calluna-shortcodes' )	=> 'yes'
				),
			),
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Plan', 'calluna-shortcodes' ),
				'param_name'	=> 'plan',
				'value'			=> 'Basic',
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Cost', 'calluna-shortcodes' ),
				'param_name'	=> 'cost',
				'value'			=> '$20',
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Per (optional)', 'calluna-shortcodes' ),
				'param_name'	=> 'per',
				'value'			=> 'month',
			),
			array(
				'type'			=> 'textarea_html',
				'heading'		=> esc_html__( 'Features', 'calluna-shortcodes' ),
				'param_name'	=> 'content',
				'value'			=> '<ul>
										<li>30GB Storage</li>
										<li>512MB Ram</li>
										<li>10 databases</li>
										<li>1,000 Emails</li>
										<li>25GB Bandwidth</li>
									</ul>',
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Button: Text', 'calluna-shortcodes' ),
				'param_name'	=> 'button_text',
				'value'			=> 'Button Text',
				'description'	=> esc_html__( 'Button: Text', 'calluna-shortcodes' )
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Button: URL', 'calluna-shortcodes' ),
				'param_name'	=> 'button_url',
				'value'			=> '#',
				'description'	=> esc_html__( 'Button: URL', 'calluna-shortcodes' )
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Button: Style', 'calluna-shortcodes' ),
				'param_name'  => 'button_style',
				'description' => esc_html__( 'Select a button style.', 'calluna-shortcodes' ),
				'value'       => array(
					 esc_html__( 'Style 1', 'calluna-shortcodes' )  => 'style-1',
					 esc_html__( 'Style 2', 'calluna-shortcodes' )   => 'style-2'
				),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Button: Size', 'calluna-shortcodes' ),
				'param_name'  => 'button_size',
				'description' => esc_html__( 'Select a button size.', 'calluna-shortcodes' ),
				'value'       => $button_sizes,
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button: Link Target', 'calluna-shortcodes' ),
				'param_name' => 'button_target',
				'value'      => array(
					 esc_html__( 'Self', 'calluna-shortcodes' )  => 'self',
					 esc_html__( 'Blank', 'calluna-shortcodes' ) => 'blank',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button: Rel', 'calluna-shortcodes' ),
				'param_name' => 'button_rel',
				'value'      => array(
					 esc_html__( 'None', 'calluna-shortcodes' )     => 'none',
					 esc_html__( 'Nofollow', 'calluna-shortcodes' ) => 'nofollow',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button: Icon Left', 'calluna-shortcodes' ),
				'param_name' => 'button_icon_left',
				'value'      => calluna_shortcodes_font_icons_array(),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button: Icon Right', 'calluna-shortcodes' ),
				'param_name' => 'button_icon_right',
				'value'      => calluna_shortcodes_font_icons_array(),
			),
		)
	) );
	// Icons -------------------------------------------------------------------------- >
	vc_map( array(
		'name'        => esc_html__( 'Calluna Font Awesome Icon', 'calluna-shortcodes' ),
		'base'        => 'cl_fa_icon',
		'description' => esc_html__( 'Font Awesome Icon', 'calluna-shortcodes' ),
		'category'    => esc_html__( 'Calluna', 'calluna-shortcodes' ),
		'icon'        => 'calluna_vc_icon',
		'params'      => array(
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Icon', 'calluna-shortcodes' ),
				'param_name'  => 'icon',
				'admin_label' => true,
				'value'       => calluna_shortcodes_font_icons_array(),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Size', 'calluna-shortcodes' ),
				'param_name' => 'size',
				'std'        => 'normal',
				'value'      => array(
					 esc_html__( 'Extra Large', 'calluna-shortcodes' ) => 'xlarge',
					 esc_html__( 'Large', 'calluna-shortcodes' )       => 'large',
					 esc_html__( 'Normal', 'calluna-shortcodes' )      => 'normal',
					 esc_html__( 'Small', 'calluna-shortcodes' )       => 'small',
					 esc_html__( 'Tiny', 'calluna-shortcodes' )        => 'tiny',
				),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Fade In', 'calluna-shortcodes' ),
				'param_name'  => 'fade_in',
				'value'       => array(
					 esc_html__( 'No', 'calluna-shortcodes' ) => 'false',
					 esc_html__( 'Yes', 'calluna-shortcodes' )  => 'true',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Float', 'calluna-shortcodes' ),
				'param_name' => 'float',
				'value'      => array(
					 esc_html__( 'Center', 'calluna-shortcodes' ) => 'center',
					 esc_html__( 'Left', 'calluna-shortcodes' )   => 'left',
					 esc_html__( 'Right', 'calluna-shortcodes' )  => 'right',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => __( 'Icon Color', 'calluna-shortcodes' ),
				'param_name' => 'color',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'calluna-shortcodes' ),
				'param_name' => 'background',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Border Radius', 'calluna-shortcodes' ),
				'param_name' => 'border_radius',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'URL', 'calluna-shortcodes' ),
				'param_name' => 'url',
			  	'value'			=> '#',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'URL Title', 'calluna-shortcodes' ),
				'param_name' => 'url_title',
			),
		)
	) );
	// Buttons -------------------------------------------------------------------------- >
	vc_map( array(
		'name'        => esc_html__( 'Calluna Button', 'calluna-shortcodes' ),
		'base'        => 'cl_button',
		'description' => esc_html__( 'Calluna Shortcode Button', 'calluna-shortcodes' ),
		'category'    => esc_html__( 'Calluna', 'calluna-shortcodes' ),
		'icon'        => 'calluna_vc_icon',
		'params'      => array(
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'URL', 'calluna-shortcodes' ),
				'param_name'	=> 'url',
			  	'value'			=> '#',
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Button Title', 'calluna-shortcodes' ),
				'param_name'	=> 'title',
				'value'			=> esc_html__( 'Button', 'calluna-shortcodes' ) ,
			),
			array(
				'type'			=> 'dropdown',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Button Style', 'calluna-shortcodes' ),
				'param_name'	=> 'style',
				'value'			=> array(
					esc_html__( 'Style 1', 'calluna-shortcodes' )  => 'style-1',
					esc_html__( 'Style 2', 'calluna-shortcodes' )   => 'style-2'
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Size', 'calluna-shortcodes' ),
				'param_name' => 'size',
				'value'      => $button_sizes,
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Align', 'calluna-shortcodes' ),
				'param_name' => 'align',
				'value'      => array(
					esc_html__( 'Default', 'calluna-shortcodes' ) => '',
					esc_html__( 'Inline', 'calluna-shortcodes' )  => 'aligninline',
					esc_html__( 'Left', 'calluna-shortcodes' )    => 'alignleft',
					esc_html__( 'Right', 'calluna-shortcodes' )   => 'alignright',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Link Target', 'calluna-shortcodes' ),
				'param_name' => 'target',
				'value'      => array(
					 esc_html__( 'Self', 'calluna-shortcodes' )   => 'self',
					 esc_html__( 'Blank', 'calluna-shortcodes' ) => 'blank',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Link Rel', 'calluna-shortcodes' ),
				'param_name' => 'rel',
				'value'      => array(
					 esc_html__( 'None', 'calluna-shortcodes' )      => 'none',
					 esc_html__( 'Nofollow', 'calluna-shortcodes' ) => 'nofollow',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Left', 'calluna-shortcodes' ),
				'param_name' => 'icon_left',
				'value'      => calluna_shortcodes_font_icons_array(),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Right', 'calluna-shortcodes' ),
				'param_name' => 'icon_right',
				'value'      => calluna_shortcodes_font_icons_array(),
			),
		)
	) );
	
	// Skillbars -------------------------------------------------------------------------- >
	vc_map( array(
		'name'				=> esc_html__( 'Calluna Skillbar', 'calluna-shortcodes' ),
		'base'				=> 'cl_skillbar',
		'description'		=> esc_html__( 'Animated percentage bar', 'calluna-shortcodes' ),
		'category'			=> esc_html__( 'Calluna' , 'calluna-shortcodes' ),
		'icon'        => 'calluna_vc_icon',
		'params'			=> array(
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Title', 'calluna-shortcodes' ),
				'param_name'	=> 'title',
				'value'			=> '',
				'description'	=> esc_html__( 'Add your skillbar title.', 'calluna-shortcodes' )
			),
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Percentage', 'calluna-shortcodes' ),
				'param_name'	=> 'percentage',
				'value'			=> '70',
				'description'	=> esc_html__( 'Add a percentage value.', 'calluna-shortcodes' )
			),
			array(
				'type'			=> 'colorpicker',
				'heading'		=> esc_html__( 'Background', 'calluna-shortcodes' ),
				'param_name'	=> 'color',
				'value'			=> '#967a50',
				'description'	=> esc_html__( 'Choose your custom background color (Hex value).', 'calluna-shortcodes' ),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Display % Number', 'calluna-shortcodes' ),
				'param_name'	=> 'show_percent',
				'value'			=> array(
					 esc_html__( 'Yes', 'calluna-shortcodes' )	=> 'true',
					 esc_html__( 'No', 'calluna-shortcodes' )	=> 'false',
				),
			),
		)
	) );

	// Posts Grid -------------------------------------------------------------------------- >
	vc_map( array(
		'name'        => esc_html__( 'Post Grid', 'calluna-shortcodes' ),
		'base'        => 'cl_posts_grid',
		'description' => esc_html__( 'Custom post type grid', 'calluna-shortcodes' ),
		'category'    => esc_html__( 'Calluna', 'calluna-shortcodes' ),
		'icon'        => 'calluna_vc_icon',
		'params'      => array(
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Unique Id', 'calluna-shortcodes' ),
				'param_name'	=> 'unique_id',
				'description'	=> esc_html__( 'You can enter a unique ID here for styling purposes.', 'calluna-shortcodes' ),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Post Type', 'calluna-shortcodes' ),
				'param_name'  => 'post_type',
				'value'       => calluna_shortcodes_get_post_types(),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Taxonomy', 'calluna-shortcodes' ),
				'param_name'  => 'taxonomy',
				'value'       => calluna_shortcodes_get_taxonomies(),
			),
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Term Slug', 'calluna-shortcodes' ),
				'param_name'	=> 'term_slug',
				'description'	=> esc_html__( 'Enter the Term slug to get your posts from. This term must be a part of the taxonomy above. You can find your slug on your taxonomy dashboard. For regular posts that would be the Categories page.', 'calluna-shortcodes' ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Post Count', 'calluna-shortcodes' ),
				'param_name'  => 'count',
				'value'       => '10',
				'description' => esc_html__( 'How many items do you wish to show.', 'calluna-shortcodes' ),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Pagination', 'calluna-shortcodes' ),
				'param_name'	=> 'pagination',
				'description'	=> esc_html__( 'Note: Pagination will not work on your homepage.', 'calluna-shortcodes' ),
				'value'			=> array(
					 esc_html__( 'No', 'calluna-shortcodes' ) => 'false',
					 esc_html__( 'Yes', 'calluna-shortcodes' )  => 'true',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Columns', 'calluna-shortcodes' ),
				'param_name'	=> 'columns',
				'std'           => '3',
				'value'			=> array(
					 esc_html__( '1', 'calluna-shortcodes' )	=> '1',
					 esc_html__( '2', 'calluna-shortcodes' )	=> '2',
					 esc_html__( '3', 'calluna-shortcodes' )	=> '3',
					 esc_html__( '4', 'calluna-shortcodes' )	=> '4',
					 esc_html__( '5', 'calluna-shortcodes' )	=> '5',
					 esc_html__( '6', 'calluna-shortcodes' )	=> '6',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Order', 'calluna-shortcodes' ),
				'param_name'	=> 'order',
				'description'	=> sprintf( wp_kses(__( 'Designates the ascending or descending order. More at %s.', 'calluna-shortcodes' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
				'value'			=> array(
					 esc_html__( 'DESC', 'calluna-shortcodes' )	=> 'DESC',
					 esc_html__( 'ASC', 'calluna-shortcodes' )	=> 'ASC',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Order By', 'calluna-shortcodes' ),
				'param_name'	=> 'orderby',
				'description'	=> sprintf( wp_kses(__( 'Select how to sort retrieved posts. More at %s.', 'calluna-shortcodes' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
				'value'			=> $order_by,
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Thumbnail Link', 'calluna-shortcodes' ),
				'param_name'	=> 'thumbnail_link',
				'value'			=> array(
					 esc_html__( 'Post', 'calluna-shortcodes' )     => 'post',
					 esc_html__( 'None', 'calluna-shortcodes' )		=> 'none',
					 esc_html__( 'Lightbox', 'calluna-shortcodes' ) => 'lightbox',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Thumbnail Crop', 'calluna-shortcodes' ),
				'param_name'	=> 'img_crop',
				'value'			=> array(
					 esc_html__( 'Yes', 'calluna-shortcodes' )  => 'true',
					 esc_html__( 'No', 'calluna-shortcodes' ) => 'false',
				),
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Thumbnail Width', 'calluna-shortcodes' ),
				'param_name'	=> 'img_width',
				'description'	=> esc_html__( 'Enter a width in pixels.', 'calluna-shortcodes' ),
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Thumbnail Height', 'calluna-shortcodes' ),
				'param_name'	=> 'img_height',
				'description'	=> esc_html__( 'Enter a height in pixels. Set to "9999" to disable vertical cropping and keep image proportions.', 'calluna-shortcodes' ),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Display Title', 'calluna-shortcodes' ),
				'param_name'	=> 'title',
				'value'			=> array(
					 esc_html__( 'Yes', 'calluna-shortcodes' )  => 'true',
					 esc_html__( 'No', 'calluna-shortcodes' ) => 'false',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Display Excerpt', 'calluna-shortcodes' ),
				'param_name'	=> 'excerpt',
				'value'			=> array(
					 esc_html__( 'Yes', 'calluna-shortcodes' )  => 'true',
					 esc_html__( 'No', 'calluna-shortcodes' ) => 'false',
				),
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Excerpt Length', 'calluna-shortcodes' ),
				'param_name'	=> 'excerpt_length',
				'value'			=> '30',
				'description'	=> esc_html__( 'How many words do you want to display for your excerpt?', 'calluna-shortcodes' ),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Read More Link?', 'calluna-shortcodes' ),
				'param_name'	=> 'read_more',
				'value'			=> array(
					 esc_html__( 'Yes', 'calluna-shortcodes' )  => 'true',
					 esc_html__( 'No', 'calluna-shortcodes' ) => 'false',
				),
			),	
		)
	) );
	
	// Headings -------------------------------------------------------------------------- >
	vc_map( array(
		'name'        => esc_html__( 'Calluna Heading', 'calluna-shortcodes' ),
		'base'        => 'cl_heading',
		'description' => esc_html__( 'Styled heading', 'calluna-shortcodes' ),
		'category'    => esc_html__( 'Calluna', 'calluna-shortcodes' ),
		'icon'        => 'calluna_vc_icon',
		'params'      => array(
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Title', 'calluna-shortcodes' ),
				'param_name'	=> 'title',
				'value'			=> 'This is a Heading',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Type', 'calluna-shortcodes' ),
				'param_name' => 'type',
				'std'        => 'h2',
				'default'    => 'h2',
				'value'      => array(
					'h1'   => 'h1',
					'h2'   => 'h2',
					'h3'   => 'h3',
					'h4'   => 'h4',
					'h5'   => 'h5',
					'h6'   => 'h6',
					'div'  => 'div',
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Margin Top', 'calluna-shortcodes' ),
				'param_name' => 'margin_top',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Margin Bottom', 'calluna-shortcodes' ),
				'param_name' => 'margin_bottom',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Font Size', 'calluna-shortcodes' ),
				'param_name' => 'font_size',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Heading Color', 'calluna-shortcodes' ),
				'param_name' => 'color',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Span Background', 'calluna-shortcodes' ),
				'param_name' => 'span_bg',
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Heading Style', 'calluna-shortcodes' ),
				'param_name'	=> 'style',
				'value'			=> array(
					 esc_html__( 'None', 'calluna-shortcodes' )	=> '',
					 esc_html__( 'Underline', 'calluna-shortcodes' )	=> 'single-line'
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Text Alignment', 'calluna-shortcodes' ),
				'param_name'	=> 'text_align',
				'value'			=> array(
					 esc_html__( 'Left', 'calluna-shortcodes' )		=> 'left',
					 esc_html__( 'Center', 'calluna-shortcodes' )	=> 'center',
					 esc_html__( 'Right', 'calluna-shortcodes' )	=> 'right',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Left', 'calluna-shortcodes' ),
				'param_name' => 'icon_left',
				'value'      => calluna_shortcodes_font_icons_array(),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Right', 'calluna-shortcodes' ),
				'param_name' => 'icon_right',
				'value'      => calluna_shortcodes_font_icons_array(),
			),
		)
	) );
	// Teaser -------------------------------------------------------------------------- >
	vc_map(array(
			'name'                    => esc_html__('Calluna Teaser', 'calluna-shortcodes'),
			'base'                    => 'cl_teaser',
			'class'                   => '',
			'controls'                => 'full',
			'icon'                    => 'calluna_vc_icon',
			'category'                => esc_html__('Calluna', 'calluna-shortcodes'),
			'show_settings_on_create' => TRUE,
			'params'				  => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Text Color', 'calluna-shortcodes' ),
				'param_name' => 'color',
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Text Alignment', 'calluna-shortcodes' ),
				'param_name'	=> 'text_align',
				'value'			=> array(
					 esc_html__( 'Left', 'calluna-shortcodes' )		=> 'left',
					 esc_html__( 'Center', 'calluna-shortcodes' )	=> 'center',
					 esc_html__( 'Right', 'calluna-shortcodes' )	=> 'right',
				),
			),
			array(
				'type'			=> 'textarea_html',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Content', 'calluna-shortcodes' ),
				'param_name'	=> 'content',
				'value'			=> esc_html__( 'Enter your content here.', 'calluna-shortcodes' ),
				'description'	=> esc_html__( 'Teaser Content', 'calluna-shortcodes' ),
			),
		)
		));
	// Icon Box ----------------------------------------------------------------------- >
	vc_map( array(
            'name'                  => esc_html__( 'Calluna Icon Box', 'calluna-shortcodes' ),
            'base'                  => 'cl_icon_box',
            'category'                => esc_html__('Calluna', 'calluna-shortcodes'),
            'icon'                  => 'calluna_vc_icon',
            'description'           => esc_html__( 'Content box with icon', 'calluna-shortcodes' ),
            'params'                => array(
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Extra class name', 'calluna-shortcodes' ),
                    'param_name'    => 'el_class',
                    'description'   => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'calluna-shortcodes' ),
                ),

                // Icon
                array(
                    'type'          => 'attach_image',
                    'heading'       => esc_html__( 'Icon Image Alternative', 'calluna-shortcodes' ),
                    'param_name'    => 'image',
                    'group'         => esc_html__( 'Icon', 'calluna-shortcodes' ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Icon Image Alternative Width', 'calluna-shortcodes' ),
                    'param_name'    => 'image_width',
                    'group'         => esc_html__( 'Icon', 'calluna-shortcodes' ),
					'dependency'    => Array(
                        'element'   => 'image',
                        'not_empty' => true,
                    ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Icon', 'calluna-shortcodes' ),
                    'param_name'    => 'icon',
                    'value'         => calluna_shortcodes_font_icons_array(),
                    'group'         => esc_html__( 'Icon', 'calluna-shortcodes' ),
                    
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Icon Font Alternative Classes', 'calluna-shortcodes' ),
                    'param_name'    => 'icon_alternative_classes',
                    'group'         => esc_html__( 'Icon', 'calluna-shortcodes' ),
                    
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Icon Color', 'calluna-shortcodes' ),
                    'param_name'    => 'icon_color',
                    'value'         => '',
                    'group'         => esc_html__( 'Icon', 'calluna-shortcodes' ),
                    
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Icon Background', 'calluna-shortcodes' ),
                    'param_name'    => 'icon_background',
                    'group'         => esc_html__( 'Icon', 'calluna-shortcodes' ),
                    
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Icon Border Radius', 'calluna-shortcodes' ),
                    'param_name'    => 'icon_border_radius',
                    'group'         => esc_html__( 'Icon', 'calluna-shortcodes' ),
                    
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Icon Size In Pixels', 'calluna-shortcodes' ),
                    'param_name'    => 'icon_size',
                    'value'         => '',
                    'group'         => esc_html__( 'Icon', 'calluna-shortcodes' ),
                    
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Fixed Icon Width', 'calluna-shortcodes' ),
                    'param_name'    => 'icon_width',
                    'value'         => '',
                    'group'         => esc_html__( 'Icon', 'calluna-shortcodes' ),
                    
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Fixed Icon Height', 'calluna-shortcodes' ),
                    'param_name'    => 'icon_height',
                    'value'         => '',
                    'group'         => esc_html__( 'Icon', 'calluna-shortcodes' ),
                    
                ),

                // Design
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('CSS Animation', 'calluna-shortcodes'),
                    'param_name'    => 'css_animation',
                    'value'         => array(
                        esc_html__( 'No', 'calluna-shortcodes' )                  => '',
                        esc_html__( 'Top to bottom', 'calluna-shortcodes' )       => 'top-to-bottom',
                        esc_html__( 'Bottom to top', 'calluna-shortcodes' )       => 'bottom-to-top',
                        esc_html__( 'Left to right', 'calluna-shortcodes' )       => 'left-to-right',
                        esc_html__( 'Right to left', 'calluna-shortcodes' )       => 'right-to-left',
                        esc_html__( 'Appear from center', 'calluna-shortcodes' )  => 'appear'
                    ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Icon Box Style', 'calluna-shortcodes' ),
                    'param_name'    => 'style',
                    'value'         => array(
                        esc_html__( 'Left Icon', 'calluna-shortcodes')                    => 'one',
                        esc_html__( 'Right Icon', 'calluna-shortcodes')                   => 'seven',
                        esc_html__( 'Top Icon', 'calluna-shortcodes' )                    => 'two',
                        esc_html__( 'Top Icon Style 2 (legacy)', 'calluna-shortcodes' )   => 'three',
                        esc_html__( 'Outlined & Top Icon', 'calluna-shortcodes' )         => 'four',
                        esc_html__( 'Boxed & Top Icon', 'calluna-shortcodes' )            => 'five',
                        esc_html__( 'Boxed & Top Icon Style 2', 'calluna-shortcodes' )    => 'six',
                    ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Alignment', 'calluna-shortcodes' ),
                    'param_name'    => 'alignment',
                    'dependency'    => Array(
                        'element'   => 'style',
                        'value'     => array( 'two' ),
                    ),
                    'value'         => array(
                        esc_html__( 'Default', 'calluna-shortcodes')  => '',
                        esc_html__( 'Center', 'calluna-shortcodes')   => 'center',
                        esc_html__( 'Left', 'calluna-shortcodes' )    => 'left',
                        esc_html__( 'Right', 'calluna-shortcodes' )   => 'right',
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Icon Bottom Margin', 'calluna-shortcodes' ),
                    'param_name'    => 'icon_bottom_margin',
                    'dependency'    => Array(
                        'element'   => 'style',
                        'value'     => array( 'two', 'three', 'four', 'five', 'six' ),
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Container Left Padding', 'calluna-shortcodes' ),
                    'param_name'    => 'container_left_padding',
                    'dependency'    => Array(
                        'element'   => 'style',
                        'value'     => array( 'one' )
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Container Right Padding', 'calluna-shortcodes' ),
                    'param_name'    => 'container_right_padding',
                    'dependency'    => Array(
                        'element'   => 'style',
                        'value'     => array( 'seven' )
                    ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Background Color', 'calluna-shortcodes' ),
                    'param_name'    => 'background',
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'four', 'five', 'six' ),
                    ),
                ),
                array(
                    'type'          => 'attach_image',
                    'heading'       => esc_html__( 'Background Image', 'calluna-shortcodes' ),
                    'param_name'    => 'background_image',
                    'value'         => '',
                    'description'   => esc_html__( 'Select image from media library.', 'calluna-shortcodes' ),
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'four', 'five', 'six' ),
                    ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Background Image Style', 'calluna-shortcodes' ),
                    'param_name'    => 'background_image_style',
                    'value'         => array(
                        esc_html__( 'Default', 'calluna-shortcodes' )     => '',
                        esc_html__( 'Stretched', 'calluna-shortcodes' )   => 'stretch',
                        esc_html__( 'Fixed', 'calluna-shortcodes' )       => 'fixed',
                        esc_html__( 'Repeat', 'calluna-shortcodes' )      => 'repeat',
                    ),
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'four', 'five', 'six' ),
                    ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Border Color', 'calluna-shortcodes' ),
                    'param_name'    => 'border_color',
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'four' ),
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Padding', 'calluna-shortcodes' ),
                    'param_name'    => 'padding',
                    'dependency'    => Array(
                        'element'   => 'style',
                        'value'     => array( 'four', 'five', 'six' )
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Border Radius', 'calluna-shortcodes' ),
                    'param_name'    => 'border_radius',
                    'dependency'    => Array(
                        'element'   => 'style',
                        'value'     => array( 'four', 'five', 'six' )
                    ),
                ),

                // Heading
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Heading', 'calluna-shortcodes' ),
                    'param_name'    => 'heading',
                    'value'         => 'Sample Heading',
                    'group'         => esc_html__( 'Heading', 'calluna-shortcodes' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Heading Type', 'calluna-shortcodes' ),
                    'param_name'    => 'heading_type',
                    'value'     => array(
                        'h2'    => 'h2',
                        'h3'    => 'h3',
                        'h4'    => 'h4',
                        'h5'    => 'h5',
                        'div'   => 'div',
                        'span'  => 'span',
                    ),
                    'group'         => esc_html__( 'Heading', 'calluna-shortcodes' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Heading Font Color', 'calluna-shortcodes' ),
                    'param_name'    => 'heading_color',
                    'group'         => esc_html__( 'Heading', 'calluna-shortcodes' ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Heading Font Size', 'calluna-shortcodes' ),
                    'param_name'    => 'heading_size',
                    'group'         => esc_html__( 'Heading', 'calluna-shortcodes' ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Heading Font Weight', 'calluna-shortcodes' ),
                    'param_name'    => 'heading_weight',
                    'group'         => esc_html__( 'Heading', 'calluna-shortcodes' ),
                    'value'         => '',
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Heading Letter Spacing', 'calluna-shortcodes' ),
                    'param_name'    => 'heading_letter_spacing',
                    'group'         => esc_html__( 'Heading', 'calluna-shortcodes' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Heading Text Transform', 'calluna-shortcodes' ),
                    'param_name'    => 'heading_transform',
                    'group'         => esc_html__( 'Heading', 'calluna-shortcodes' ),
                    'value'         => array(
                        esc_html__( 'Default', 'calluna-shortcodes' )     => '',
                        esc_html__( 'None', 'calluna-shortcodes' )        => 'none',
                        esc_html__( 'Capitalize', 'calluna-shortcodes' )  => 'capitalize',
                        esc_html__( 'Uppercase', 'calluna-shortcodes' )   => 'uppercase',
                        esc_html__( 'Lowercase', 'calluna-shortcodes' )   => 'lowercase',
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Heading Bottom Margin', 'calluna-shortcodes' ),
                    'param_name'    => 'heading_bottom_margin',
                    'group'         => esc_html__( 'Heading', 'calluna-shortcodes' ),
                ),


                // Content
                array(
                    'type'          => 'textarea_html',
                    'holder'        => 'div',
                    'heading'       => esc_html__( 'Content', 'calluna-shortcodes' ),
                    'param_name'    => 'content',
                    'value'         => esc_html__( 'Don\'t forget to change this dummy text in your page editor for this lovely icon box.', 'calluna-shortcodes' ),
                    'group'         => esc_html__( 'Content', 'calluna-shortcodes' ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Content Font Size', 'calluna-shortcodes' ),
                    'param_name'    => 'font_size',
                    'group'         => esc_html__( 'Content', 'calluna-shortcodes' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Content Font Color', 'calluna-shortcodes' ),
                    'param_name'    => 'font_color',
                    'group'         => esc_html__( 'Content', 'calluna-shortcodes' ),
                ),

                // URL
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'URL', 'calluna-shortcodes' ),
                    'param_name'    => 'url',
                    'group'         => esc_html__( 'URL', 'calluna-shortcodes' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'URL Target', 'calluna-shortcodes' ),
                    'param_name'    => 'url_target',
                     'value'        => array(
                        esc_html__( 'Self', 'calluna-shortcodes' )    => '',
                        esc_html__( 'Blank', 'calluna-shortcodes' )   => '_blank',
                        esc_html__( 'Local', 'calluna-shortcodes' )   => 'local',
                    ),
                    'group'         => esc_html__( 'URL', 'calluna-shortcodes' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'URL Rel', 'calluna-shortcodes' ),
                    'param_name'    => 'url_rel',
                    'value'         => array(
                        esc_html__( 'None', 'calluna-shortcodes' )        => '',
                        esc_html__( 'Nofollow', 'calluna-shortcodes' )    => 'nofollow',
                    ),
                    'group'         => esc_html__( 'URL', 'calluna-shortcodes' ),
                ),

                // Margin
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Bottom Margin', 'calluna-shortcodes' ),
                    'param_name'    => 'margin_bottom',
                    'group'         => esc_html__( 'Margin', 'calluna-shortcodes' ),
                ),
            )
        ) );
	// Text Image Block
	vc_map(
			array(
					"icon" => 'calluna_vc_icon',
					'name'                    => esc_html__( 'Calluna Image with content' , 'calluna-shortcodes' ),
					'base'                    => 'cl_content_image',
					'description'             => esc_html__( 'Create images with content', 'calluna-shortcodes' ),
					"category" => esc_html__('Calluna', 'calluna-shortcodes'),
					'params' => array(
							array(
									"type" => "attach_image",
									"heading" => esc_html__("Choose Image", 'calluna-shortcodes'),
									"param_name" => "image"
							),
							array(
									"type" => "dropdown",
									"heading" => esc_html__("Image & Content Layout", 'calluna-shortcodes'),
									"param_name" => "layout",
									"value" => array(
											'Image with inner Content Left' => 'offscreen-left',
											'Image with inner Content Right' => 'offscreen-right',
											'Image with shadow Left' => 'shadow-left',
											'Image with shadow Right' => 'shadow-right',
											'Boxed Image Left' => 'box-left',
											'Boxed Image Right' => 'box-right'
									)
							),
                        // Content
                        array(
                            'type'          => 'textarea_html',
                            'holder'        => 'div',
                            'heading'       => esc_html__( 'Content', 'calluna-shortcodes' ),
                            'param_name'    => 'content',
                            'value'         => esc_html__( 'Don\'t forget to change this dummy text in your page editor.', 'calluna-shortcodes' ),
                            'group'         => esc_html__( 'Content', 'calluna-shortcodes' ),
                        ),
					)
			)
	);
}
add_action( 'vc_before_init', 'calluna_shortcodes_vc_map' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_cl_content_image extends WPBakeryShortCodesContainer {

    }
}

function calluna_shortcodes_vc_admin_css() {
	if ( class_exists( 'Vc_Manager' ) ) {
		wp_enqueue_style( 'calluna-shortcodes-vc', plugin_dir_url( __FILE__ ) . 'css/calluna-shortcodes-vc.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'calluna_shortcodes_vc_admin_css' );