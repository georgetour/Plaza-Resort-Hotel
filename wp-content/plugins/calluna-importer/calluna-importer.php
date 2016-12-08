<?php
/**
 * Plugin Name:			Calluna Importer
 * Plugin URI:			http://demo.themetwins.com/calluna
 * Description:			Importer for the calluna demo content
 * Version:				1.2
 * Author:				Themetwins
 * Author URI:			http://demo.themetwins.com
 * License:				GPL-2.0+
 * License URI:			http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: calluna-importer
 */

class Calluna_Importer {

    public $theme_options_file;

    public $widgets;

    public $content_demo;

    /**
     * Flag imported to prevent duplicates
     */
    public $flag_as_imported = array();

    private static $instance;

    /**
     * Constructor. Hooks all interactions to initialize the class.
     */
    public function __construct() {

        self::$instance = $this;

        $this->theme_options_file = $this->demo_files_path . $this->theme_options_file_name;
        $this->widgets = $this->demo_files_path . $this->widgets_file_name;
        $this->content_demo = $this->demo_files_path . $this->content_demo_file_name;

		add_action( 'plugins_loaded', 'calluna_importer_init' );
        add_action( 'admin_menu', array($this, 'add_admin') );

    }

	 /**
     * Load text domain
     */
    public function calluna_importer_init() {

        load_plugin_textdomain( 'calluna-importer', false, dirname(plugin_basename( __FILE__ )) . '/languages' );

    }
    /**
     * Add Panel Page
     */
    public function add_admin() {
        load_plugin_textdomain( 'calluna-importer', false, dirname(plugin_basename( __FILE__ )) . '/languages' );
        add_theme_page("Calluna Demo Import", "Calluna Demo Import", 'switch_themes', 'calluna_demo_installer', array($this, 'demo_installer'));

    }

    /**
     * demo installer text
     */
    public function demo_installer() {
        ?>
        <div class="wrap">
            <h2><span class="dashicons dashicons-update" style="color:#0f2453; line-height: 29px;"></span> Calluna Demo Import</h2>
            <div style="background-color: #FFFFFF; margin:10px 0;padding: 10px;color: #444;border: 1px solid #d2d2d2; clear:both; width:90%; line-height:18px;">
                <p class="tie_message_hint">Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme. It will allow you to quickly edit everything instead of creating content from scratch. When you import the data following things will happen:</p>

                <ul style="padding-left: 20px; list-style-position: inside; list-style-type: square;">
                    <li>No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified .</li>
                    <li>No WordPress settings will be modified .</li>
                    <li>Posts, pages, some images, some widgets and menus will get imported .</li>
                    <li>Images will be downloaded from our server, these images are copyrighted and are for demo use only .</li>
                    <li>Please click import only once and wait, it can take a couple of minutes</li>
                </ul>
            </div>

            <div style="background-color: #FFFFFF; margin:10px 0; padding: 10px; color: #444; border: 1px solid #D2D2D2; clear:both; width:90%; line-height:18px;">
                <p class="tie_message_hint">Before you begin, make sure all the required plugins are activated.</p>
            </div>
            <form method="post" class="js-one-click-import-form">
                <input type="hidden" name="demononce" value="<?php echo wp_create_nonce('calluna-demo-code'); ?>" />
                <input type="hidden" name="action" value="demo-data" />
				<p>
                Demo Style :
                <select name="import-file">
                    <option value="<?php echo esc_attr('content.xml'); ?>"><?php esc_html_e('Calluna', 'calluna-importer'); ?></option>
                    <option value="<?php echo esc_attr('calluna-city-content.xml'); ?>"><?php esc_html_e('Calluna City', 'calluna-importer'); ?></option>
					<option value="<?php echo esc_attr('calluna-snow-content.xml'); ?>"><?php esc_html_e('Calluna Snowvalley', 'calluna-importer'); ?></option>
                </select>
				<p>
				<input name="reset" class="panel-save button-primary" type="submit" value="Import Demo Data" />
            </form>

            <script>
                jQuery( function ( $ ) {
                    $( '.js-one-click-import-form' ).on( 'submit', function () {
                        $( this ).append( '<p style="font-width: bold; font-size: 1.5em;"><span class="spinner" style="display: inline-block; float: none;"></span> Importing now, please wait!</p>' );
                        $( this ).find( '.panel-save' ).attr( 'disabled', true );
                    } );
                } );
            </script>

            <br />
            <br />
        </div>

        <?php

        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

        if( 'demo-data' == $action && check_admin_referer('calluna-demo-code' , 'demononce')){
            $this->content_demo = $this->demo_files_path . $_POST['import-file'];

            $this->set_demo_data( $this->content_demo );

            $this->set_demo_theme_options( $this->theme_options_file ); //import before widgets incase we need more sidebars

            $this->set_demo_menus();

            $this->process_widget_import_file( $this->widgets );

        }

    }

    /**
     * add_widget_to_sidebar Import sidebars
     * @param  string $sidebar_slug    Sidebar slug to add widget
     * @param  string $widget_slug     Widget slug
     * @param  string $count_mod       position in sidebar
     * @param  array  $widget_settings widget settings
     *
     */
    public function add_widget_to_sidebar($sidebar_slug, $widget_slug, $count_mod, $widget_settings = array()){

        $sidebars_widgets = get_option('sidebars_widgets');

        if(!isset($sidebars_widgets[$sidebar_slug]))
            $sidebars_widgets[$sidebar_slug] = array('_multiwidget' => 1);

        $newWidget = get_option('widget_'.$widget_slug);

        if(!is_array($newWidget))
            $newWidget = array();

        $count = count($newWidget)+1+$count_mod;
        $sidebars_widgets[$sidebar_slug][] = $widget_slug.'-'.$count;

        $newWidget[$count] = $widget_settings;

        update_option('sidebars_widgets', $sidebars_widgets);
        update_option('widget_'.$widget_slug, $newWidget);

    }

    public function set_demo_data( $file ) {

        if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

        require_once ABSPATH . 'wp-admin/includes/import.php';

        $importer_error = false;

        if ( !class_exists( 'WP_Importer' ) ) {

            $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';

            if ( file_exists( $class_wp_importer ) ){

                require_once($class_wp_importer);

            } else {

                $importer_error = true;

            }

        }

        if ( !class_exists( 'WP_Import' ) ) {

            $class_wp_import = plugin_dir_path( __FILE__ ) .'importer/wordpress-importer.php';

            if ( file_exists( $class_wp_import ) )
                require_once($class_wp_import);
            else
                $importer_error = true;

        }

        if($importer_error){

            die("Error on import");

        } else {

            if(!is_file( $file )){
				echo "The XML file containing the dummy content is not available or could not be read .. You might want to try to set the file permission to chmod 755.<br/>If this doesn't work please use the Wordpress importer and import the XML file (should be located in your download .zip: Sample Content folder) manually ";

            } else {

                $wp_import = new WP_Import();
                $wp_import->fetch_attachments = true;
                $wp_import->import( $file );

            }

        }

    }

    public function set_demo_menus() {}

    public function set_demo_theme_options( $file ) {

        // File exists?
        if ( ! file_exists( $file ) ) {
            wp_die(
                esc_html__( 'Theme options Import file could not be found. Please try again.', 'calluna-importer' ),
                '',
                array( 'back_link' => true )
            );
        }

        // Get file contents and decode
        $data = file_get_contents( $file );

        $data = unserialize( trim($data, '###') );

        // Have valid data?
        // If no data or could not decode
        if ( empty( $data ) || ! is_array( $data ) ) {
            wp_die(
                esc_html__( 'Theme options import data could not be read. Please try a different file.', 'calluna-importer' ),
                '',
                array( 'back_link' => true )
            );
        }

        // Hook before import
        $data = apply_filters( 'calluna_theme_import_theme_options', $data );

        update_option($this->theme_option_name, $data);

    }

    /**
     * Available widgets
     *
     * Gather site's widgets into array with ID base, name, etc.
     * Used by export and import functions.
     *
     * @global array $wp_registered_widget_updates
     * @return array Widget information
     */
    function available_widgets() {

        global $wp_registered_widget_controls;

        $widget_controls = $wp_registered_widget_controls;

        $available_widgets = array();

        foreach ( $widget_controls as $widget ) {

            if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

                $available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
                $available_widgets[$widget['id_base']]['name'] = $widget['name'];

            }

        }

        return apply_filters( 'calluna_theme_import_widget_available_widgets', $available_widgets );

    }


    /**
     * Process import file
     *
     * This parses a file and triggers importation of its widgets.
     *
     * @param string $file Path to .wie file uploaded
     * @global string $widget_import_results
     */
    function process_widget_import_file( $file ) {

        // File exists?
        if ( ! file_exists( $file ) ) {
            wp_die(
                esc_html__( 'Widget Import file could not be found. Please try again.', 'calluna-importer' ),
                '',
                array( 'back_link' => true )
            );
        }

        // Get file contents and decode
        $data = file_get_contents( $file );
        $data = json_decode( $data );

        // Delete import file
        //unlink( $file );

        // Import the widget data
        // Make results available for display on import/export page
        $this->widget_import_results = $this->import_widgets( $data );

    }


    /**
     * Import widget JSON data
     *
     * @global array $wp_registered_sidebars
     * @param object $data JSON widget data from .wie file
     * @return array Results array
     */
    public function import_widgets( $data ) {

        global $wp_registered_sidebars;

        // Have valid data?
        // If no data or could not decode
        if ( empty( $data ) || ! is_object( $data ) ) {
            wp_die(
                esc_html__( 'Widget import data could not be read. Please try a different file.', 'calluna-importer' ),
                '',
                array( 'back_link' => true )
            );
        }

        // Hook before import
        $data = apply_filters( 'calluna_theme_import_widget_data', $data );

        // Get all available widgets site supports
        $available_widgets = $this->available_widgets();

        // Get all existing widget instances
        $widget_instances = array();
        foreach ( $available_widgets as $widget_data ) {
            $widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
        }

        // Begin results
        $results = array();

        // Loop import data's sidebars
        foreach ( $data as $sidebar_id => $widgets ) {

            // Skip inactive widgets
            // (should not be in export file)
            if ( 'wp_inactive_widgets' == $sidebar_id ) {
                continue;
            }

            // Check if sidebar is available on this site
            // Otherwise add widgets to inactive, and say so
            if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
                $sidebar_available = true;
                $use_sidebar_id = $sidebar_id;
                $sidebar_message_type = 'success';
                $sidebar_message = '';
            } else {
                $sidebar_available = false;
                $use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
                $sidebar_message_type = 'error';
                $sidebar_message = esc_html__( 'Sidebar does not exist in theme (using Inactive)', 'calluna-importer' );
            }

            // Result for sidebar
            $results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
            $results[$sidebar_id]['message_type'] = $sidebar_message_type;
            $results[$sidebar_id]['message'] = $sidebar_message;
            $results[$sidebar_id]['widgets'] = array();

            // Loop widgets
            foreach ( $widgets as $widget_instance_id => $widget ) {

                $fail = false;

                // Get id_base (remove -# from end) and instance ID number
                $id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
                $instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

                // Does site support this widget?
                if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
                    $fail = true;
                    $widget_message_type = 'error';
                    $widget_message = esc_html__( 'Site does not support widget', 'calluna-importer' ); // explain why widget not imported
                }

                // Filter to modify settings before import
                // Do before identical check because changes may make it identical to end result (such as URL replacements)
                $widget = apply_filters( 'calluna_theme_import_widget_settings', $widget );

                // Does widget with identical settings already exist in same sidebar?
                if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

                    // Get existing widgets in this sidebar
                    $sidebars_widgets = get_option( 'sidebars_widgets' );
                    $sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

                    // Loop widgets with ID base
                    $single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
                    foreach ( $single_widget_instances as $check_id => $check_widget ) {

                        // Is widget in same sidebar and has identical settings?
                        if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

                            $fail = true;
                            $widget_message_type = 'warning';
                            $widget_message = esc_html__( 'Widget already exists', 'calluna-importer' ); // explain why widget not imported

                            break;

                        }

                    }

                }

                // No failure
                if ( ! $fail ) {

                    // Add widget instance
                    $single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
                    $single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
                    $single_widget_instances[] = (array) $widget; // add it

                    // Get the key it was given
                    end( $single_widget_instances );
                    $new_instance_id_number = key( $single_widget_instances );

                    // If key is 0, make it 1
                    // When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
                    if ( '0' === strval( $new_instance_id_number ) ) {
                        $new_instance_id_number = 1;
                        $single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
                        unset( $single_widget_instances[0] );
                    }

                    // Move _multiwidget to end of array for uniformity
                    if ( isset( $single_widget_instances['_multiwidget'] ) ) {
                        $multiwidget = $single_widget_instances['_multiwidget'];
                        unset( $single_widget_instances['_multiwidget'] );
                        $single_widget_instances['_multiwidget'] = $multiwidget;
                    }

                    // Update option with new widget
                    update_option( 'widget_' . $id_base, $single_widget_instances );

                    // Assign widget instance to sidebar
                    $sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
                    $new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
                    $sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
                    update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

                    // Success message
                    if ( $sidebar_available ) {
                        $widget_message_type = 'success';
                        $widget_message = esc_html__( 'Imported', 'calluna-importer' );
                    } else {
                        $widget_message_type = 'warning';
                        $widget_message = esc_html__( 'Imported to Inactive', 'calluna-importer' );
                    }

                }

                // Result for widget instance
                $results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
                $results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = ! empty( $widget->title ) ? $widget->title : esc_html__( 'No Title', 'calluna-importer' ); // show "No Title" if widget instance is untitled
                $results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
                $results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

            }

        }

        // Hook after import
        do_action( 'calluna_theme_import_widget_after_import' );

        // Return results
        return apply_filters( 'calluna_theme_import_widget_results', $results );

    }

}