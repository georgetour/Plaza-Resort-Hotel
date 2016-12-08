<?php
/**
 * WPML Configuration Class
 *
 */

if ( ! class_exists( 'Calluna_WPML_Config' ) ) {

    class Calluna_WPML_Config {


        public function __construct() {

            // Register strings for translation
            add_action( 'admin_init', array( $this, 'register_strings' ) );
            add_action( 'admin_init', array( $this, 'wpml_fix_ajax_install' ) );

            // Fix for when users have the Language URL Option on "different domains"
            add_filter( 'upload_dir', array( $this, 'convert_base_url' ) );

        }

        /**
         * Registers theme_mod strings into WPML
         */
        public function register_strings() {

            if ( function_exists( 'icl_register_string' ) && $strings = calluna_register_theme_mod_strings() ) {
                foreach( $strings as $string => $default ) {
                    icl_register_string( 'Theme Mod', $string, get_theme_mod( $string, $default ) );
                }
            }

        }

        public function wpml_fix_ajax_install(){
            global $sitepress;
            if(defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) && isset($_REQUEST['lang']) ){
                // remove WPML legacy filter, as it is not doing its job for ajax calls
                remove_filter('locale', array($sitepress, 'locale'));
                add_filter('locale', 'wpml_ajax_fix_locale');
                function wpml_ajax_fix_locale($locale){
                    global $sitepress;
                    // simply return the locale corresponding to the "lang" parameter in the request
                    return $sitepress->get_locale($_REQUEST['lang']);
                }
            }
        }

        /**
         * Fix for when users have the Language URL Option on "different domains"
         * which causes cropped images to fail.
         * Runs if 'WPML_SUNRISE_MULTISITE_DOMAINS' constant is defined
         *
         * @since 1.6.0
         */
        public function convert_base_url( $param ) {

            // Check if WPML is set to multisite domains
            if ( defined( 'WPML_SUNRISE_MULTISITE_DOMAINS' ) ) {
                global $sitepress;
                if ( $sitepress ) {
                    // Convert upload directory base URL to correct language
                    $param['baseurl'] = $sitepress->convert_url( $param['baseurl'] );
                }
            }

            // Return param
            return $param;

        }


    }

}
new Calluna_WPML_Config();