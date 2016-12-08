<?php
/**
 * Calluna functions and definitions
 *
 * @package calluna
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1140; /* pixels */
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
if ( ! function_exists( 'calluna_setup' ) ) {
	function calluna_setup() {
		
		//Add support for localization
		load_theme_textdomain( 'calluna-td', get_template_directory() . '/languages' );
	
		//Add Theme support options
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'menus' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'gallery', 'image', 'video', 'quote', 'link' ) );
		add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', 'gallery', 'caption' ) );
		add_theme_support('woocommerce');

		update_option('thumbnail_size_w', 815);
		update_option('thumbnail_size_h', 458);
		
		add_image_size('calluna_normal', 320, 218, TRUE);
		
		// Register Custom Navigation Walker
		include_once( get_template_directory() . '/inc/nav-menu/custom-menu.php');
		register_nav_menus( array(
			'main_menu' => esc_html__( 'Main Menu', 'calluna-td' ),
			'responsive_menu' => esc_html__( 'Mobile Menu', 'calluna-td' ),
		) );
		
		//Overwrite next and prev post link
		function calluna_add_class_next_post_link($html){
		$html = str_replace('</a>','<i class="icon-right"></i></a>',$html);
		return $html;
		}
		add_filter('next_post_link','calluna_add_class_next_post_link',10,1);
		
		function calluna_add_class_previous_post_link($html){
		$html = str_replace('">','"><i class="icon-left"></i>',$html);
		return $html;
		}
		add_filter('previous_post_link','calluna_add_class_previous_post_link',10,1);
	}
}
add_action( 'after_setup_theme', 'calluna_setup' );

/**
 * Register widget area.
 */
if ( ! function_exists( 'calluna_widgets_init' ) ) {
	function calluna_widgets_init() {
		register_sidebar( array(
			'name'          => esc_html__( 'Blog sidebar', 'calluna-td' ),
			'id'            => 'blog',
			'description'   => esc_html__( 'Add widgets here to appear in the blog sidebar.', 'calluna-td' ),
			'before_widget' => '<div class="widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="title">',
			'after_title'   => '</h2>',
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Page sidebar', 'calluna-td' ),
			'id'            => 'page-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in the page sidebar.', 'calluna-td' ),
			'before_widget' => '<div class="widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="title">',
			'after_title'   => '</h2>',
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Logo', 'calluna-td' ),
			'id'            => 'footer-logo',
			'description'   => esc_html__( 'Add the footer logo here.', 'calluna-td' ),
			'before_widget' => '<div class="widget footer-logo">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			  'name'          => esc_html__( 'Footer Content One', 'calluna-td' ),
			  'id'            => 'footer-1',
			  'description'   => esc_html__( 'Add content for the footer.', 'calluna-td' ),
			  'before_widget' => '<div class="widget footer-1">',
			  'after_widget'  => '</div>',
			  'before_title'  => '<h3>',
			  'after_title'   => '</h3>',
		  ) );
		register_sidebar( array(
			  'name'          => esc_html__( 'Footer Content Two', 'calluna-td' ),
			  'id'            => 'footer-2',
			  'description'   => esc_html__( 'Add content for the footer.', 'calluna-td' ),
			  'before_widget' => '<div class="widget footer-2">',
			  'after_widget'  => '</div>',
			  'before_title'  => '<h3>',
			  'after_title'   => '</h3>',
		  ) );
		register_sidebar( array(
			  'name'          => esc_html__( 'Footer Content Three', 'calluna-td' ),
			  'id'            => 'footer-3',
			  'description'   => esc_html__( 'Add content for the footer', 'calluna-td' ),
			  'before_widget' => '<div class="widget footer-3">',
			  'after_widget'  => '</div>',
			  'before_title'  => '<h3>',
			  'after_title'   => '</h3>',
		  ) );
	  
	}
}
add_action( 'widgets_init', 'calluna_widgets_init' );

/*
Register Fonts
*/
function calluna_fonts_url() {
   $fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by Lora, translate this to 'off'. Do not translate
    * into your own language.
    */
    $lato = esc_html_x( 'on', 'Lato font: on or off', 'calluna-td' );
 
    /* Translators: If there are characters in your language that are not
    * supported by Open Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $raleway = esc_html_x( 'on', 'Raleway font: on or off', 'calluna-td' );
 
    if ( 'off' !== $lato || 'off' !== $raleway ) {
        $font_families = array();
 
        if ( 'off' !== $lato ) {
            $font_families[] = 'Lato:400,300,700,900,300italic,400italic,700italic';
        }
 
        if ( 'off' !== $raleway ) {
            $font_families[] = 'Raleway:400,300,500,600,700,800,200';
        }
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }
 
    return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles.
 */
if ( ! function_exists( 'calluna_scripts' ) ) {
	function calluna_scripts() {
	    wp_enqueue_style( 'calluna-fonts', calluna_fonts_url(), array(), null );
	    
		/* Visual Composer CSS - Load now to avoid delay during page load */
		wp_enqueue_style('js_composer_front');
		
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css');
		wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array('jquery'), '', true );
		
		wp_enqueue_script('jquery-ui-core', '', true);
		wp_enqueue_script('jquery-ui-position', '', true);
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script( 'easing', get_template_directory_uri() . '/js/jquery.easing.js', 'jquery','1.3', true);
		wp_enqueue_style( 'calluna-main', get_stylesheet_uri());
		wp_enqueue_script( 'calluna-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
		wp_enqueue_script( 'calluna-classie', get_template_directory_uri() . '/js/classie.js', array(), '', true );
		wp_enqueue_script( 'calluna-animated-header', get_template_directory_uri() . '/js/cbpAnimatedHeader.js', array('calluna-classie'), '', true );
		wp_enqueue_script( 'calluna-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
		wp_enqueue_script( 'calluna-main-js', get_template_directory_uri() . '/js/calluna-main.min.js', array('jquery'), '1.0', true );
		wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr.min.js', array('jquery'), '', true);
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'calluna_scripts' );

// Register Font Awesome
if ( ! function_exists( 'calluna_font_awesome' ) ) {
	function calluna_font_awesome() {
		wp_deregister_style( 'font-awesome' );
		wp_deregister_style( 'wpe-common' );
		wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
		wp_enqueue_style( 'font-awesome' );
	}
}
// Hook into the 'wp_enqueue_scripts' action
add_action( 'wp_print_styles', 'calluna_font_awesome' );

/** Include the TGM_Plugin_Activation class. */
require_once get_template_directory() . '/inc/plugins/class-tgm.php';
require_once get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';

/* Include activation for plugins */
include_once get_template_directory() . '/inc/plugins/plugin-setup.php';
	
/* Custom template tags for this theme. */
require get_template_directory() . '/inc/template-tags.php';

/* Custom functions that act independently of the theme templates. */
require get_template_directory() . '/inc/extras.php';

//Custom Metaboxes
require_once get_template_directory() . '/metabox-functions.php';

/* Add Theme Customizer additions. */
require get_template_directory() . '/inc/theme-customizer.php';

/* Add Google Fonts for Theme Customizer*/
require_once get_template_directory() . '/inc/customizer/fonts.php';
require_once get_template_directory() . '/inc/customizer/typography.php';

/* Load Jetpack compatibility file. */
require get_template_directory() . '/inc/jetpack.php';

/* Load Custom Widgets */
include_once get_template_directory() . '/inc/widgets/widgets.php';	

//Custom Ajax Callbacks
require_once get_template_directory() . '/inc/calluna-ajax.php';

//Extend Contact Form 7
require_once get_template_directory() . '/inc/extend-contact-form-7.php';
	
/* Require some files only when in admin */
if ( is_admin() ) {
    require_once get_template_directory() . '/inc/content-import.php';
}
if ( class_exists( 'SitePress' ) ) {
	require_once get_template_directory() . '/inc/wpml.php';
}

if (! function_exists('calluna_filter_change_room_type_slug')) {
	function calluna_filter_change_room_type_slug( $args ) {
		$args['rewrite'] = array( 'slug' => get_theme_mod('room_type_slug', 'apb-room-type') );

		return $args;
	}
}

add_filter( 'awe_post_type_room_type', 'calluna_filter_change_room_type_slug' );

if (! function_exists('calluna_filter_change_event_type_slug')) {
	function calluna_filter_change_event_type_slug( $args ) {
		$args['rewrite'] = array( 'slug' => get_theme_mod('event_type_slug', 'event') );

		return $args;
	}
}

add_filter( 'calluna_post_type_event', 'calluna_filter_change_event_type_slug' );

if (! function_exists('calluna_filter_change_offer_type_slug')) {
    function calluna_filter_change_offer_type_slug( $args ) {
        $args['rewrite'] = array( 'slug' => get_theme_mod('offer_type_slug', 'offer') );

        return $args;
    }
}

add_filter( 'calluna_post_type_offer', 'calluna_filter_change_offer_type_slug' );