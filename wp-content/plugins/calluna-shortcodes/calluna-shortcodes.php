<?php
/*
Plugin Name: Calluna Shortcodes
Plugin URI: http://demo.themetwins.com/calluna
Description: Shortcodes for the Calluna WP theme
Author: Themetwins
Author URI: http://demo.themetwins.com/calluna
Version: 2.2.4
*/

if ( ! class_exists( 'Calluna_Shortcodes' ) ) {

	class Calluna_Shortcodes {

		/**
		 * Main Constructor
		 */
		function __construct() {

			// Define path
			$this->dir_path = plugin_dir_path( __FILE__ );

			// Register de-activation hook
			register_deactivation_hook( __FILE__, array( $this, 'calluna_shortcodes_on_deactivation' ) );

			// Actions
            add_action('init', array($this, 'load_plugin_textdomain'));
			add_action( 'admin_head', array( $this, 'calluna_shortcodes_add_mce_button' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'calluna_shortcodes_load_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'calluna_shortcodes_mce_css' ) );

			// Includes (useful functions and classes)
			require_once( $this->dir_path .'/inc/commons.php' );
			require_once( $this->dir_path .'/inc/image-resizer.php' );
			
			// The actual shortcodes
			require_once( $this->dir_path .'/shortcodes/shortcodes.php' );
			
			// Map shortcodes to the Visual Composer
			require_once( $this->dir_path .'/visual-composer/map.php' );

			// Admin notices
			add_action( 'admin_init', array( $this, 'calluna_shortcodes_admin_notice_init' ) );

			// Add responsive tag to body
			add_filter( 'body_class', array( $this, 'calluna_shortcodes_body_class' ) );

		}

        /**
         * Load text domain
         */
        public function load_plugin_textdomain() {
            load_plugin_textdomain('calluna-shortcodes', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');

        }

		/**
		 * Add filters for the TinyMCE buttton
		 *
		 * @since  2.0.0
		 * @access public
		 */
		function calluna_shortcodes_add_mce_button() {

			// Check user permissions
			if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
				return;
			}

			// Check if WYSIWYG is enabled
			if ( 'true' == get_user_option( 'rich_editing' ) ) {
				add_filter( 'mce_external_plugins', array( $this, 'calluna_shortcodes_add_tinymce_plugin' ) );
				add_filter( 'mce_buttons', array( $this, 'calluna_shortcodes_register_mce_button' ) );
			}

		}

		/**
		 * Loads the TinyMCE button js file
		 */
		function calluna_shortcodes_add_tinymce_plugin( $plugin_array ) {
			$plugin_array['calluna_shortcodes_mce_button'] = plugins_url( '/tinymce/calluna-shortcodes-tinymce.js', __FILE__ );
			return $plugin_array;
		}

		/**
		 * Adds the TinyMCE button to the post editor buttons
		 */
		function calluna_shortcodes_register_mce_button( $buttons ) {
			array_push( $buttons, 'calluna_shortcodes_mce_button' );
			return $buttons;
		}

		/**
		 * Loads custom CSS for the TinyMCE editor button
		 */
		function calluna_shortcodes_mce_css() {
			wp_enqueue_style('calluna-shortcodes-tc', plugins_url( '/tinymce/calluna-shortcodes-tinymce-style.css', __FILE__ ) );
		}

		/**
		 * Registers/Enqueues all scripts and styles
		 */
		function calluna_shortcodes_load_scripts() {

			// Define js directory
			$js_dir = plugin_dir_url( __FILE__ ) . 'shortcodes/js/';

			// Define CSS directory
			$css_dir = plugin_dir_url( __FILE__ ) . 'shortcodes/css/';

			// JS
			wp_enqueue_script( 'jquery' );
			wp_register_script( 'calluna-skillbar', $js_dir . 'calluna-skillbar.js', array ( 'jquery' ));
			wp_register_script( 'magnific-popup', $js_dir . 'magnific-popup.min.js', array ( 'jquery' ));
			wp_register_script( 'calluna-lightbox', $js_dir . 'calluna-lightbox.js', array ( 'jquery', 'magnific-popup' ));
			wp_register_script( 'jcarousel', $js_dir . 'jquery.jcarousel.min.js', array ( 'jquery' ) );
			wp_register_script( 'touchSwipe', $js_dir . 'jquery.touchSwipe.min.js', array ( 'jquery' ));
			wp_register_script( 'calluna-booking', $js_dir . 'calluna-booking.js', array ( 'jquery') );
			wp_register_script( 'calluna-tabs', $js_dir . 'calluna-tabs.js', array ( 'jquery', 'jquery-ui-tabs' ) );
			wp_register_script( 'calluna-toggle', $js_dir . 'calluna-toggle.js', 'jquery' );
			wp_register_script( 'calluna-accordion', $js_dir . 'calluna-accordion.js', array ( 'jquery', 'jquery-ui-accordion' ) );
			wp_register_script( 'calluna-scroll-fade', $js_dir . 'calluna-scroll-fade.js', array ( 'jquery' ) );
			wp_register_script( 'calluna-icon', $js_dir . 'calluna-icon-type.js', array ( 'jquery' ) );
			wp_register_script( 'calluna-carousel', $js_dir . 'calluna-carousel.js', array ( 'jquery' ) );

			// CSS
			wp_register_style( 'font-awesome', $css_dir . 'font-awesome.min.css' );
            wp_register_style( 'calluna-carousel-style', $css_dir . 'owl.carousel.min.css' );
			wp_enqueue_style( 'datepicker', $css_dir . 'jquery-ui.custom.css' );
			wp_enqueue_style( 'calluna-shortcode-styles', $css_dir . 'calluna-shortcodes-styles.css' );
		}

		/**
		 * Add admin notice to enable the Visual Composer
		 */
		function calluna_shortcodes_admin_notice_init() {

			// $this->vc_notice_dismiss_delete(); // For testing

			// If dismiss meta is saved bail
			if ( get_user_meta( get_current_user_id(), 'calluna_shortcodes_vc_notice_dismiss', true ) ) {
				return;
			}

			// If the dimiss notice icon is clicked update user meta
			if ( isset( $_GET['calluna-vc-dismiss'] ) ) {
				$this->calluna_shortcodes_vc_notice_dismiss();
				return;
			}

			// Apply filters so you can disable the notice via the theme
			$show_vc_notice = apply_filters( 'calluna_shortcodes_vc_notice', true );

			// Show notice
			if ( $show_vc_notice ) {
				add_action( 'admin_notices', array( $this, 'calluna_shortcodes_vc_notice' ) );
			}

		}

		/**
		 * Display admin notice for the VC
		 */
		function calluna_shortcodes_vc_notice() { ?>
			
			<div class="updated notice is-dismissable calluna-vc-notice">
				<a href="<?php echo esc_url( add_query_arg( 'calluna-vc-dismiss', '1' ) ); ?>" class="dismiss-notice" target="_parent"><span class="dashicons dashicons-no-alt" style="display:block;float:right;margin:10px 0 10px 10px;"></span></a>
				<p><?php esc_html_e( 'Calluna Shortcodes includes support for the Visual Composer so you can use most of the modules via drag and drop.', 'calluna-td' ); ?></p><p><a href="http://vc.wpbakery.com/" class="button button-primary" title="<?php esc_html_e( 'Visual Composer', 'calluna-td' ); ?>" target="_blank"><?php esc_html_e( 'Learn More', 'calluna-td' ); ?></a></p>
			</div>

		<?php }

		/**
		 * Update user meta for dismissing the notice
		 */
		public function calluna_shortcodes_vc_notice_dismiss() {
			update_user_meta( get_current_user_id(), 'calluna_shortcodes_vc_notice_dismiss', 1 );
		}

		/**
		 * Delete notice dismiss
		 */
		public function calluna_shortcodes_vc_notice_dismiss_delete() {
			delete_user_meta( get_current_user_id(), 'calluna_shortcodes_vc_notice_dismiss' );
		}

		/**
		 * Run on plugin de-activation
		 */
		public function calluna_shortcodes_on_deactivation() {

			// Remove user meta for the Visual Composer notice
			$this->calluna_shortcodes_vc_notice_dismiss_delete();

		}
		
		/**
		 * Adds classes to the body tag
		 */
		public function calluna_shortcodes_body_class( $classes ) {
			$classes[] = 'calluna-shortcodes ';
			$responsive = apply_filters( 'calluna_shortcodes_responsive', true );
			if ( $responsive ) {
				$classes[] = 'calluna-shortcodes-responsive';
			}
			return $classes;
		}
		
	}

	// Start things up
	$calluna_shortcodes = new Calluna_Shortcodes();

}