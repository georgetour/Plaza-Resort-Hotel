<?php
/**
 * Calluna Demo Import, uses Calluna Importer Plugin
 */


if ( class_exists( 'Calluna_Importer' ) && ! class_exists( 'Calluna_Theme_Demo_Data_Importer' ) ) {
	class Calluna_Theme_Demo_Data_Importer extends Calluna_Importer {

		private static $instance;

		/**
		 * Set the key to be used to store theme options
		 */
		public $theme_option_name       = '__ignored__';
		public $theme_options_file_name = '__ignored__';
		public $widgets_file_name       = 'widgets.json';
		public $content_demo_file_name  = 'content.xml';

		public $widget_import_results;

		/**
		 * Constructor. Hooks all interactions to initialize the class.
		 */
		public function __construct() {

			$this->demo_files_path = get_template_directory() . '/demo-content/';

			self::$instance = $this;
			parent::__construct();

		}

		/**
		 * Add menus
		 * ... and many more
		 */
		public function set_demo_menus(){

			// Set imported menus to registered theme locations
			$locations = get_theme_mod( 'nav_menu_locations' );
			$menus = wp_get_nav_menus();
			if($menus) {
				foreach($menus as $menu) {
					if( $menu->name == 'Main Menu' ) {
						$locations['main_menu'] = $menu->term_id;
					} else if( $menu->name == 'Mobile Menu' ) {
						$locations['responsive_menu'] = $menu->term_id;
					}
				}
			}
			set_theme_mod( 'nav_menu_locations', $locations );

			// Set options for front page and blog page
			$front_page_id = get_page_by_title( 'Homepage 1' )->ID;
			$blog_page_id  = get_page_by_title( 'Blog' )->ID;

			update_option( 'page_on_front', $front_page_id );
			update_option( 'show_on_front', 'page' );
			update_option( 'page_for_posts', $blog_page_id );
		}

		/**
		 * Ignore the theme options import
		 */
		public function set_demo_theme_options( $file ) {}
	}

	new Calluna_Theme_Demo_Data_Importer;
}