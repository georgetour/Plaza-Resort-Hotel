<?php
	/**
	 * Include the TGM_Plugin_Activation class.
	 */
	add_action('tgmpa_register', 'calluna_register_plugins');
	/**
	 * Register the required plugins for this theme.
	 * The variable passed to tgmpa_register_plugins() should be an array of plugin
	 * arrays.
	 * This function is hooked into tgmpa_init, which is fired within the
	 * TGM_Plugin_Activation class constructor.
	 */
	function calluna_register_plugins() {
		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		// Visual Composer
		$plugins = array(
			array(
				'name'               => 'WPBakery Visual Composer', // The plugin name
				'slug'               => 'js_composer', // The plugin slug (typically the folder name)
				'source'             => get_template_directory() . '/plugins/js_composer.zip', // The plugin source
				'required'           => TRUE, // If false, the plugin is only 'recommended' instead of required
				'version'            => '4.12.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => FALSE, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => TRUE, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '', // If set, overrides default API URL and points to an external URL
			),
			// Master Slider
			array(
				'name'               => 'masterslider', // The plugin name
				'slug'               => 'masterslider', // The plugin slug (typically the folder name)
				'source'             => get_template_directory() . '/plugins/masterslider.zip', // The plugin source
				'required'           => true, // If false, the plugin is only 'recommended' instead of required
				'version'            => '3.0.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => FALSE, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => TRUE, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '', // If set, overrides default API URL and points to an external URL
			),
			array(
            'name' 		            => 'Contact Form 7',
            'slug' 		            => 'contact-form-7'
        ),
		array(
            'name' 		            => 'Bootstrap Contact Form 7',
            'slug' 		            => 'bootstrap-for-contact-form-7'
        ),
		array(
            'name' 		            => 'Simple Weather',
            'slug' 		            => 'simple-weather',
            'source'                => get_template_directory() . '/plugins/simple-weather.zip', // The plugin source.
            'required'              => false, // If false, the plugin is only 'recommended' instead of required.
            'version'               => '2.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation'    => TRUE, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'          => '', // If set, overrides default API URL and points to an external URL.
        ),
		array(
            'name' 		            => 'Calluna Custom Posts',
            'slug' 		            => 'calluna-custom-posts',
            'source'                => get_template_directory() . '/plugins/calluna-custom-posts.zip', // The plugin source.
            'required'              => true, // If false, the plugin is only 'recommended' instead of required.
            'version'               => '2.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'          => '', // If set, overrides default API URL and points to an external URL.
        ),
		array(
            'name' 		            => 'Calluna Shortcodes',
            'slug' 		            => 'calluna-shortcodes',
            'source'                => get_template_directory() . '/plugins/calluna-shortcodes.zip', // The plugin source.
            'required'              => true, // If false, the plugin is only 'recommended' instead of required.
            'version'               => '2.2.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'          => '', // If set, overrides default API URL and points to an external URL.
        ),
		array(
            'name' 		            => 'Calluna Importer',
            'slug' 		            => 'calluna-importer',
            'source'                => get_template_directory() . '/plugins/calluna-importer.zip', // The plugin source.
            'required'              => false, // If false, the plugin is only 'recommended' instead of required.
            'version'               => '1.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'          => '', // If set, overrides default API URL and points to an external URL.
        ),
            array(
                'name' 		            => 'AWE Booking',
                'slug' 		            => 'awebooking',
                'source'                => get_template_directory() . '/plugins/awebooking.zip', // The plugin source.
                'required'              => true, // If false, the plugin is only 'recommended' instead of required.
                'version'               => '2.5.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                'external_url'          => '', // If set, overrides default API URL and points to an external URL.
            ),
        array(
            'name'      		=> 'WooCommerce',
            'slug'      		=> 'woocommerce',
            'required'  		=> false,
            'force_activation'	=> false,
        ),
		);

		$config = array(
			'domain'       		=> 'calluna-td',         
			'default_path' 		=> '',			
			'menu'         		=> 'install-required-plugins', 
			'has_notices'      	=> true,                       
			'is_automatic'    	=> false,					   
			'message' 			=> '',						
			/*
			'strings'      		=> array(
				'page_title'                       			=> esc_html__('Install Required Plugins', 'calluna-td' ),
				'menu_title'                       			=> esc_html__('Install Plugins', 'calluna-td' ),
				'installing'                       			=> esc_html__('Installing Plugin: %s', 'calluna-td' ), 
				'oops'                             			=> esc_html__('Something went wrong with the plugin API.', 'calluna-td' ),
				'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'calluna-td' ),
				'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'calluna-td' ), 
				'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'calluna-td' ), // %1$s = plugin name(s)
				'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'calluna-td' ), 
				'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'calluna-td' ), 
				'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'calluna-td' ), // %1$s = plugin name(s)
				'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'calluna-td' ), // %1$s = plugin name(s)
				'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'calluna-td' ), // %1$s = plugin name(s)
				'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'calluna-td' ),
				'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'calluna-td' ),
				'return'                           			=> esc_html__( 'Return to Required Plugins Installer', 'calluna-td' ),
				'plugin_activated'                 			=> esc_html__( 'Plugin activated successfully.', 'calluna-td' ),
				'complete' 									=> esc_html__( 'All plugins installed and activated successfully. %s', 'calluna-td' ), 
				'nag_type'									=> 'updated'
			) */
		);
		
		tgmpa($plugins, $config);
	}


	/* ------------------------------------------------------------------------------- */
	/* Initialize Visual Composer as "built into the theme".
	/* ------------------------------------------------------------------------------- */
	if (function_exists('vc_set_as_theme')) {
		//vc_set_as_theme($notifier = FALSE);
	}

	/* ------------------------------------------------------------------------------- */
	/* Visual Composer Modifications
	/* ------------------------------------------------------------------------------- */

	if (function_exists('vc_map')) {

		/*// Remove Unnecessary Elements
		vc_remove_element('vc_carousel');
		vc_remove_element('vc_images_carousel');
		vc_remove_element("vc_posts_slider");
		vc_remove_element("vc_posts_grid");
		vc_remove_element("vc_message");
		vc_remove_element("vc_flickr"); */
		//vc_remove_element('vc_custom_heading');
		vc_remove_element('vc_gmaps');
		//vc_remove_element("vc_btn");
		vc_remove_element("vc_button");
		//vc_remove_element("vc_button2");
		vc_remove_element("vc_cta");
		vc_remove_element("vc_cta_button");
		vc_remove_element("vc_cta_button2");
		vc_remove_element("vc_wp_search");
		vc_remove_element("vc_wp_meta");
		vc_remove_element("vc_wp_recentcomments");
		vc_remove_element("vc_wp_calendar");
		vc_remove_element("vc_wp_pages");
		vc_remove_element("vc_wp_text");
		vc_remove_element("vc_wp_posts");
		vc_remove_element("vc_wp_tagcloud");
		vc_remove_element("vc_wp_custommenu");
		vc_remove_element("vc_wp_links");
		vc_remove_element("vc_wp_categories");
		vc_remove_element("vc_wp_archives");
		vc_remove_element("vc_wp_rss");

	}

/* ------------------------------------------------------------------------------- */
/* Visual Composer Add Params
/* ------------------------------------------------------------------------------- */
/*-----------------------------------------------------------------------------------*/
/*	- Columns
/*-----------------------------------------------------------------------------------*/
if (function_exists('vc_add_param')) {
	vc_add_param( 'vc_column', array(
		'type'			=> 'dropdown',
		'heading'		=> esc_html__( 'Add extra style', 'calluna-td' ),
		'param_name'	=> 'style',
		'value'			=> array(
			esc_html__( 'Default', 'calluna-td' )		=> '',
			esc_html__( 'Style 1', 'calluna-td' )		=> 'column-style-1',
			esc_html__( 'Style 2', 'calluna-td' )	=> 'column-style-2'
		),
	) );
}
	
	// Custom CSS
	function load_custom_vc_wp_admin_style() {
		wp_register_style('custom_vc_wp_admin_css', get_template_directory_uri() . '/inc/plugins/css/vc_custom.css', FALSE, '');
		wp_enqueue_style('custom_vc_wp_admin_css');
	}

	add_action('admin_enqueue_scripts', 'load_custom_vc_wp_admin_style');
	
	
	/* ------------------------------------------------------------------------------- */
	/* Master Slider Calluna Skin
	/* ------------------------------------------------------------------------------- */
	 
	function calluna_masterslider_skins( $slider_skins ) {
 
    $slider_skins[] = array( 'class' => 'ms-skin-calluna', 'label' => 'Calluna' );
     
    return $slider_skins;
}
 
add_filter( 'masterslider_skins', 'calluna_masterslider_skins' );

function calluna_masterslider_enqueue_styles( $enqueue_styles ) {
 
    $enqueue_styles[] = array(
        'src'     => get_template_directory_uri() . '/css/ms-skin-calluna.css' ,
        'deps'    => array(),
        'version' => '1.0'
    );
     
    return $enqueue_styles;
}
 
add_filter( 'masterslider_enqueue_styles', 'calluna_masterslider_enqueue_styles' );

/* ------------------------------------------------------------------------------- */
/* Remove AWE Booking Gallery metabox for room post type
/* ------------------------------------------------------------------------------- */
function remove_plugin_metaboxes(){
    remove_meta_box( 'apb-gallery', 'room', 'side' );
	remove_meta_box( 'apb-gallery', 'apb_room_type', 'side' );
}

add_action( 'do_meta_boxes', 'remove_plugin_metaboxes' );
