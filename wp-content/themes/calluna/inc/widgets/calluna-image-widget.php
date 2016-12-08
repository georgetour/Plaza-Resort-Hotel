<?php
	/* ------------------------------------------------------------------------------- */
	/* Calluna Image Widget
	/* ------------------------------------------------------------------------------- */

	/* Widget Class ------------------------------------------------------------------ */

	class calluna_image_widget extends WP_Widget {


		/* Constructor ---------------------------------------------------------------- */
		function calluna_image_widget() {
			parent::__construct(FALSE, $name = esc_html__('Calluna Image', 'calluna-td'), array(
				'description' => esc_html__('Add image to any sidebar', 'calluna-td')
			));
			
			add_action('admin_enqueue_scripts', array($this, 'calluna_assets'));
		}
		
		public function calluna_assets()
		{
			wp_enqueue_style('thickbox');
			wp_enqueue_style( 'wp-color-picker' ); 
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_script('calluna-media-upload', get_template_directory_uri() . '/inc/widgets/js/calluna-media-upload.js', array('jquery'));
			wp_enqueue_script( 'wp-color-picker' );  
		}

		/* Widget Output -------------------------------------------------------------- */

		function widget($args, $instance) {
			extract($args);

			$show_border      = isset($instance['show_border']) ? TRUE : FALSE;

			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
			// Rest of the widget content
			?>

		<div>
        <?php if ( ! empty( $instance['border_color'] ) && $show_border == TRUE ) { ?>
				<img style="border:1px solid <?php echo esc_attr($instance['border_color']) ?>" src='<?php echo esc_attr($instance['image']) ?>' alt="<?php esc_html_e( 'Widget image', 'calluna-td' );?>">
			<?php } 
			else { ?>
				<img src='<?php echo esc_attr($instance['image']) ?>' alt="<?php esc_html_e( 'Widget image', 'calluna-td' );?>">	
			<?php }
			 ?>
		</div>
        
        <?php
			echo $args['after_widget'];
			
		}

		/* Update & Save -------------------------------------------------------------- */

		function update($new_instance, $old_instance) {
        return $new_instance;
    }

		/* Widget Form ---------------------------------------------------------------- */

		function form($instance) {
			$image = '';
			$show_border      = isset($instance['border']) ? TRUE : FALSE;
			$defaults = array(
				'border_color' => '#193470'
			);
		
			if(isset($instance['image']))
			{
				$image = $instance['image'];
			}
			
			// Merge the user-selected arguments with the defaults
        	$instance = wp_parse_args( (array) $instance, $defaults );
			?>
            <script type='text/javascript'>
				( function( $ ){
        function initColorPicker( widget ) {
                widget.find( '.my-color-picker' ).wpColorPicker( {
                        change: _.throttle( function() { // For Customizer
                                $(this).trigger( 'change' );
                        }, 3000 )
                });
        }
            function onFormUpdate( event, widget ) {
                initColorPicker( widget );
        }
        $( document ).on( 'widget-added widget-updated', onFormUpdate );

        $( document ).ready( function() {
                $( '#widgets-right .widget:has(.my-color-picker)' ).each( function () {
                        initColorPicker( $( this ) );                                                   
                } );
        } );
}( jQuery ) );
			</script>
            <p>
            <label for="<?php echo esc_attr($this->get_field_name( 'image' )); ?>"><?php esc_html_e( 'Image:', 'calluna-td' ); ?></label>
            <input style="margin-top:10px; margin-bottom:10px;" name="<?php echo esc_attr($this->get_field_name( 'image' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'image' )); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
            
            <button class="upload_image_button btn btn-default" type="button"><?php esc_html_e('Upload', 'calluna-td'); ?></button>
				<!-- Border -->
			<p>
				<input class="checkbox" type="checkbox" <?php checked($show_border, TRUE); ?> id="<?php echo esc_attr($this->get_field_id('show_border')); ?>" name="<?php echo esc_attr($this->get_field_name('show_border')); ?>"/>
				<label for="<?php echo esc_attr($this->get_field_id('twitter')); ?>"><?php echo esc_html__('Show border', 'calluna-td') ?></label>
			</p>
				<label style="display:block; margin-top:10px; margin-bottom:10px;" for="<?php echo esc_attr($this->get_field_name( 'border_color' )); ?>"><?php esc_html_e( 'Border Color:', 'calluna-td' ); ?></label>
            <input class="my-color-picker" style="display:block;" type="text" id="<?php echo esc_attr($this->get_field_id( 'border_color' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'border_color' )); ?>" value="<?php echo esc_attr( $instance['border_color'] ); ?>" /> 
        </p>
    	<?php
		}
	}

	register_widget('calluna_image_widget');
?>