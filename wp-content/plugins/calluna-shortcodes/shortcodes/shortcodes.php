<?php
/**
 * Register all shortcodes
 *
 * @package   Calluna Shortcodes
 * @author    Themetwins
 * @link      http://www.themetwins.com
 */

// Widget Support -------------------------------------------------------------------------- >
add_filter( 'widget_text', 'do_shortcode' );

// "Fix" Shortcodes -------------------------------------------------------------------------- >
function calluna_fix_shortcodes($content){
	$array = array (
		'<p>['    => '[',
		']</p>'   => ']',
		']<br />' => ']'
	);
	$content = strtr($content, $array);
	return $content;
}
add_filter( 'the_content', 'calluna_fix_shortcodes' );


// output function
	function vc_calluna_room_price_render() {
		$currency_symbol = get_theme_mod('currency', '$');
		$pre_text = get_theme_mod( 'room_price_text', 'starting at');
		// WPML translations
        $pre_text = calluna_translate_theme_mod( 'room_price_text', $pre_text );
	  	$pre_text .= ' ';

		if (get_theme_mod('currency_pos', 'before') == 'before') {
									return '<div class="vc_gitem-post-meta-field-_calluna_room_price room_grid_price vc_gitem-align-center"><span class="vc_gitem-post-meta-label">'. esc_attr($pre_text) . '</span>' . esc_attr($currency_symbol) . '{{ post_data:base_price }}</div>';
									}
									else {
									  return '<div class="vc_gitem-post-meta-field-_calluna_room_price room_grid_price vc_gitem-align-center"><span class="vc_gitem-post-meta-label">'. esc_attr($pre_text) . '</span>{{ post_data:base_price}}' . esc_attr($currency_symbol) .'</div>';
									}
	}
	add_shortcode( 'vc_calluna_room_price', 'vc_calluna_room_price_render' );

	// output function
	function vc_calluna_offer_price_render() {
		$currency_symbol = get_theme_mod('currency', '$');
		$pre_text = get_theme_mod( 'offer_price_text', 'Price per person');
		// WPML translations
        $pre_text = calluna_translate_theme_mod( 'offer_price_text', $pre_text );
	  	$pre_text .= ' ';

		if (get_theme_mod('currency_pos', 'before') == 'before') {
									return '<div class="offer_price"><span>'. esc_attr($pre_text) . '</span>' . esc_attr($currency_symbol) . '{{ post_data:_calluna_offer_price }}</div>';
									}
									else {
										return '<div class="offer_price"><span>'. esc_attr($pre_text) . '</span>{{ post_data:_calluna_offer_price }}'. esc_attr($currency_symbol) . '</div>';
									}
	}

	add_shortcode( 'vc_calluna_offer_price', 'vc_calluna_offer_price_render' );


// Booking Calendar ------------------------------------------------------------------------ >
function calluna_booking_calendar_shortcode() {

        $form_method = 'POST';
        $awebooking = get_theme_mod( 'awebooking', 'yes' );
		$button_text = get_theme_mod( 'button_text', 'Make a reservation' );
		$reservation_header = get_theme_mod( 'reservation_header', '' );
		$reservation_text = get_theme_mod( 'reservation_text', '' );
		$reservation_hint = get_theme_mod( 'reservation_hint', '' );
		// WPML translations
        $button_text = calluna_translate_theme_mod( 'button_text', $button_text );
        $reservation_header = calluna_translate_theme_mod( 'reservation_header', $reservation_header );
        $reservation_text = calluna_translate_theme_mod( 'reservation_text', $reservation_text );
        $reservation_hint = calluna_translate_theme_mod( 'reservation_hint', $reservation_hint );

		$button_link = esc_url( get_permalink( get_theme_mod( 'button_link', '0') ) );
		$external_link = get_theme_mod('external_link');
		if ($external_link) {
		    $button_link = $external_link;
		    $form_method = get_theme_mod('booking_form_method', 'GET');
		}
		$arrow_top = get_theme_mod('picker_arrows', 'yes');
		$button_style = get_theme_mod('button_style', 'style-1');

		/* Enqueue Scripts and styles */
		wp_enqueue_script('jquery-ui-datepicker');
	    wp_enqueue_script('calluna-booking');
		wp_enqueue_style( 'datepicker' );

		// Code
		?>

		<?php ob_start(); ?>

        <?php if ($awebooking == 'yes') { ?>
            <form method="get" action="<?php echo esc_url( AWE_function::get_check_available_page() ); ?>" class="apb-single-check-avb-form">
			<input type="hidden" name="from" id="from">
			<input type="hidden" name="to" id="to">
			<input type="hidden" name="room_num" value="1">
			<input type="hidden" name="room_type_id" value="0">
			<input type="hidden" name="room_adult[]" id="hfAdults" value="1">
			<input type="hidden" name="room_child[]" value="0">
			<input type="hidden" name="check_from" value="shortcode">
        <?php } else { ?>
            <form action="<?php echo $button_link; ?>" method="<?php echo esc_attr($form_method) ?>" id="calluna-booking-form">
			<?php if ($external_link) {
			    $from = get_theme_mod('external_param_from');
                $to = get_theme_mod('external_param_to');
                $guests = get_theme_mod('external_param_guests');
                $add1_name = get_theme_mod('external_param_add1_name');
                $add2_name = get_theme_mod('external_param_add2_name');
                $add1_value = get_theme_mod('external_param_add1_value');
                $add2_value = get_theme_mod('external_param_add2_value');
                ?>

			    <input type="hidden" name="<?php echo esc_attr($from);?>" id="from">
                <input type="hidden" name="<?php echo esc_attr($to);?>" id="to">
                <input type="hidden" name="<?php echo esc_attr($guests);?>" id="hfAdults" value="1">
                <?php if($add1_name != '') { ?>
                    <input type="hidden" name="<?php echo esc_attr($add1_name);?>" id="add1" value="<?php echo esc_attr($add1_value);?>">
                <?php } ?>
                <?php if($add2_name != '') { ?>
                    <input type="hidden" name="<?php echo esc_attr($add2_name);?>" id="add2" value="<?php echo esc_attr($add2_value);?>">
                <?php } ?>
			<?php }else { ?>
			    <input type="hidden" name="from" id="from">
                <input type="hidden" name="to" id="to">
                <input type="hidden" name="hfAdults" id="hfAdults" value="1">
                <input type="hidden" name="hfRoom" id="hfRoom" value="<?php echo get_the_ID(); ?>">
                <input type="hidden" name="hfType" id="hfType" value="<?php echo get_post_type(get_the_ID()); ?>">
			<?php }
        } ?>
        <!--Right column after welcome-->
		<div id="datePicker" class="arr_row ">

            <!--Availability section-->
            <div class="booking-column ">
                <div class="row">
		        <div  class="col-xs-4 column1">
							<p class="title"><span><?php esc_html_e( 'ARRIVING', 'calluna-shortcodes' ); ?></span></p>
                            <?php if ($arrow_top == 'yes') { ?>
							<div class="arrow-up"></div>
                            <?php } ?>
                	<div id="von" class="dateField">
                        <div class="text-center centerPicking"><span class="day">09</span> <span class="month"></span></div>
                        <div class="border">
								<span class="arrow"></span>
							</div>


                        <div id="vondatepicker"></div>
                    </div>

                </div>
                <div  class="col-xs-4 dep_row column2">
                		<p class="title"><span><?php esc_html_e( 'DEPARTING', 'calluna-shortcodes' ); ?></span></p>
                        <?php if ($arrow_top == 'yes') { ?>
							<div class="arrow-up"></div>
                            <?php } ?>
					<div id="bis" class="dateField">

                        <div class="text-center centerPicking"><span class="day">09</span> <span class="month"></span></div>
                        <div class="border">
								<span class="arrow"></span>
							</div>
                        <div id="bisdatepicker"></div>
                  </div>
                </div>
                <div  class="col-xs-4 guest_row column3 ">
					<p class="title"><span><?php esc_html_e( 'GUESTS', 'calluna-shortcodes' ); ?></span></p>
					<?php if ($arrow_top == 'yes') { ?>
							<div class="arrow-up"></div>
                            <?php } ?>
                	<div  id="gaste" class="dateField ">
						<div id="gasteCount" class="text-center centerPicking"><span class="day">1</span></div>

                        <div class="border">
								<span class="arrow"></span>
						</div>

					  		<div class="guests">
							  <div class="title"><?php esc_html_e( 'Guests', 'calluna-shortcodes' ); ?></div>
							  <ul id="gasteSelect">
							  <?php
							  $guest_num = get_theme_mod('guest_count', 4);
							  if ($guest_num >= 5) {
								  $count = 0;
								  for ($i = 1; $i <= $guest_num; $i++) {
								  	$count++;
								  	if ($i == 1) { ?>
								  		<li class="active col-<?php echo esc_attr($count); ?>"><?php echo esc_attr($i); ?></li>
								  	<?php } else { ?>
									    <li class="col-<?php echo esc_attr($count); ?>"><?php echo esc_attr($i); ?></li>
									<?php }
									if($count == 2) {
										$count = 0;
									}
								  }
							  } else {
								  for ($i = 1; $i <= $guest_num; $i++) {
								  	if ($i == 1) { ?>
								  		<li class="active"><?php echo esc_attr($i); ?></li>
								  	<?php } else { ?>
									    <li><?php echo esc_attr($i); ?></li>
									<?php }

								  }
							  }?>
					  		</ul>
					  		</div>
                            </div>

                	</div>
                    </div>

                    <!--Second row check availability-->
                    <div class="row second-row-booking">
                    <div class="col-xs-4">
                    <div class="weather text-center">Athens</div>
                            <div class="weather-availability">
                             <?php echo do_shortcode('[simple-weather location="Athens, GR" units="metric" days="3"]')?>
                             </div>
                    </div>
					<div class="col-xs-8">
                    <div class="col-xs-12 booking-button">
					        <div class="booking-button_wrapper">
						  		<div class="btn-primary-container calendar" style="position:relative;">
								  <input type="submit" class="btn-primary check-avb-js <?php echo esc_attr($button_style); ?>" value="<?php echo esc_attr($button_text );?>">
								</div>
						  	</div>
						  	<div class="reservation_wrapper">
						  		<span class="reservation_header">
									<?php if ($reservation_header) { ?><?php echo esc_attr($reservation_header); ?><?php } ?>
								</span>
								<span class="reservation_text">
									<?php if ($reservation_text) { ?><?php echo esc_attr($reservation_text); ?><?php } ?>
								</span>
								<span class="reservation_hint">
									<?php if ($reservation_hint) { ?><?php echo esc_attr($reservation_hint); ?><?php } ?>
								</span>
						  	</div>

                    </div>

					   <?php $availability_info = get_field('availability_info');
                               $info_text =get_field('info_text');
                        ?>
                        <div><p><strong><?php echo $availability_info?></strong></p></div>
                        <div><p><?php echo $info_text?></p></div>

                    </div>
                    </div><!--End Second row check availability-->


                </div><!--End Availability section-->

            </div>

			</form>


		<?php
		$calluna_calendar_output = ob_get_contents();
		ob_end_clean();
		return $calluna_calendar_output;
	}
	add_shortcode( 'cl_booking_calendar', 'calluna_booking_calendar_shortcode' );

// Booking Calendar Single Room ------------------------------------------------------------------------ >
function calluna_booking_calendar_single_shortcode() {
        $form_method = 'POST';
		$awebooking = get_theme_mod( 'awebooking', 'yes' );
		$show_picker = get_theme_mod( 'show_date_picker', 'yes' );
		$button_text = get_theme_mod( 'button_text', 'Make a reservation' );
		$reservation_header = get_theme_mod( 'reservation_header', '' );
		$reservation_text = get_theme_mod( 'reservation_text', '' );
		$reservation_hint = get_theme_mod( 'reservation_hint', '' );
		// WPML translations
        $button_text = calluna_translate_theme_mod( 'button_text', $button_text );
        $reservation_header = calluna_translate_theme_mod( 'reservation_header', $reservation_header );
        $reservation_text = calluna_translate_theme_mod( 'reservation_text', $reservation_text );
        $reservation_hint = calluna_translate_theme_mod( 'reservation_hint', $reservation_hint );

		$button_link = esc_url( get_permalink( get_theme_mod( 'button_link', '0') ) );
		$external_link = get_theme_mod('external_link');
		if ($external_link) {
		    $button_link = $external_link;
		    $form_method = get_theme_mod('booking_form_method', 'get');
		}
		$arrow_top = get_theme_mod('picker_arrows', 'yes');
		$button_style = get_theme_mod('button_style', 'style-1');

		/* Enqueue Scripts and styles */
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('calluna-booking');
		wp_enqueue_style( 'datepicker' );

		// Code
		?>

		<?php ob_start(); ?>

	 <?php if ($awebooking == 'yes') { ?>
             <form method="get" action="<?php echo esc_url( AWE_function::get_check_available_page() ); ?>" class="apb-check-avb-form non-ajax">
			<input type="hidden" name="from" id="from">
			<input type="hidden" name="to" id="to">
			<input type="hidden" name="room_num" value="1">
			<input type="hidden" name="room_type_id" value="0">
			<input type="hidden" name="room_adult[]" id="hfAdults" value="1">
			<input type="hidden" name="room_child[]" value="0">
			<input type="hidden" name="check_from" value="other">
        <?php }else { ?>
            <form action="<?php echo $button_link; ?>" method="<?php echo esc_attr($form_method) ?>" id="calluna-booking-form">
			<?php if ($external_link) {
			    $from = get_theme_mod('external_param_from');
                $to = get_theme_mod('external_param_to');
                $guests = get_theme_mod('external_param_guests');
                $add1_name = get_theme_mod('external_param_add1_name');
                $add2_name = get_theme_mod('external_param_add2_name');
                $add1_value = get_theme_mod('external_param_add1_value');
                $add2_value = get_theme_mod('external_param_add2_value');
                ?>

			    <input type="hidden" name="<?php echo esc_attr($from);?>" id="from">
                <input type="hidden" name="<?php echo esc_attr($to);?>" id="to">
                <input type="hidden" name="<?php echo esc_attr($guests);?>" id="hfAdults" value="1">
                <?php if($add1_name != '') { ?>
                    <input type="hidden" name="<?php echo esc_attr($add1_name);?>" id="add1" value="<?php echo esc_attr($add1_value);?>">
                <?php } ?>
                <?php if($add2_name != '') { ?>
                    <input type="hidden" name="<?php echo esc_attr($add2_name);?>" id="add2" value="<?php echo esc_attr($add2_value);?>">
                <?php } ?>
			<?php }else { ?>
			    <input type="hidden" name="from" id="from">
                <input type="hidden" name="to" id="to">
                <input type="hidden" name="hfAdults" id="hfAdults" value="1">
                <input type="hidden" name="hfRoom" id="hfRoom" value="<?php echo get_the_ID(); ?>">
                <input type="hidden" name="hfType" id="hfType" value="<?php echo get_post_type(get_the_ID()); ?>">
			<?php }
        }
		if ( $show_picker == 'yes' ) { ?>
		<div id="datePicker" class="row arr_row">
                    		<div class="col-xs-4">
							<p class="title"><?php esc_html_e( 'ARRIVING', 'calluna-shortcodes' ); ?></p>
                            <?php if ($arrow_top == 'yes') { ?>
							<div class="arrow-up"></div>
                            <?php } ?>
                	<div id="von" class="dateField">
                    	  <p class="month">11</p>
                        <p class="day">09</p>
                        <div class="border">
								<span class="arrow"></span>
							</div>
                        <div id="vondatepicker"></div>
                  </div>
                </div>
                <div class="col-xs-4 dep_row">
                		<p class="title"><?php esc_html_e( 'DEPARTING', 'calluna-shortcodes' ); ?></p>
                        <?php if ($arrow_top == 'yes') { ?>
							<div class="arrow-up"></div>
                            <?php } ?>
					<div id="bis" class="dateField">
                    	<p class="month">11</p>
                        <p class="day">09</p>
                        <div class="border">
								<span class="arrow"></span>
							</div>
                        <div id="bisdatepicker"></div>
                  </div>
                </div>
                <div class="col-xs-4 guest_row">
					<p class="title"><?php esc_html_e( 'GUESTS', 'calluna-shortcodes' ); ?></p>
					<?php if ($arrow_top == 'yes') { ?>
							<div class="arrow-up"></div>
                            <?php } ?>
                	<div id="gaste" class="dateField">
						<div class="topborder">
								<span class="arrow"></span>
							</div>
						<p id="gasteCount" class="day">1</p>
						<div class="bottomborder">
								<span class="arrow"></span>
							</div>
					  		<div class="guests">
							  <div class="title"><?php esc_html_e( 'Guests', 'calluna-shortcodes' ); ?></div>
							  <ul id="gasteSelect">
								<?php
							  $guest_num = get_theme_mod('guest_count', 4);
							  if ($guest_num >= 5) {
						  		  $columns = 2;
								  $count = 0;
								  for ($i = 1; $i <= $guest_num; $i++) {
								  	$count++;
								  	if ($i == 1) { ?>
								  		<li class="active col-<?php echo esc_attr($count); ?>"><?php echo esc_attr($i); ?></li>
								  	<?php } else { ?>
									    <li class="col-<?php echo esc_attr($count); ?>"><?php echo esc_attr($i); ?></li>
									<?php }
									if($count == 2) {
										$count = 0;
									}
								  }
							  } else {
								  for ($i = 1; $i <= $guest_num; $i++) {
								  	if ($i == 1) { ?>
								  		<li class="active"><?php echo esc_attr($i); ?></li>
								  	<?php } else { ?>
									    <li><?php echo esc_attr($i); ?></li>
									<?php }

								  }
							  }?>
					  		</ul>
					  		</div>

						</div>
                	</div>
                    </div>
		<?php } ?>
		<div class="booking-price_wrapper">
			<?php loop_price_single(get_post_meta(get_the_ID(),"base_price",true)); ?>
		</div>
                   <div class="booking-button row">
					  	<div class="col-xs-12">
						  	<div class="booking-button_wrapper">

						  		<div class="btn-primary-container calendar" style="position:relative;">
						  		    <?php if(!$external_link){ ?>
						  		        <input type="hidden" name="room_id" value="<?php echo get_the_ID(); ?>">
						  		    <?php } ?>
								    <button class="btn-primary apb-single-checkavb-js <?php echo esc_attr($button_style); ?>"><?php echo esc_attr($button_text );?></button>
								</div>
						  	</div>
						  	<div class="reservation_wrapper">
						  		<span class="reservation_header">
									<?php if ($reservation_header) { ?><?php echo esc_attr($reservation_header); ?><?php } ?>
								</span>
								<span class="reservation_text">
									<?php if ($reservation_text) { ?><?php echo esc_attr($reservation_text); ?><?php } ?>
								</span>
								<span class="reservation_hint">
									<?php if ($reservation_hint) { ?><?php echo esc_attr($reservation_hint); ?><?php } ?>
								</span>
						  	</div>
					  	</div>
                    </div>
			</form>


		<?php
		$calluna_calendar_output = ob_get_contents();
		ob_end_clean();
		return $calluna_calendar_output;
	}
	add_shortcode( 'cl_booking_calendar_single', 'calluna_booking_calendar_single_shortcode' );
// Google Maps ---------------------------------------------------------------------- >
function calluna_google_map_shortcode($atts, $content = NULL) {

		extract(shortcode_atts(array(
				"height"   => "300",
				"map_type" => "ROADMAP",
				"style"     => "1",
				"lat"      => "51.4946416",
				"lng"      => "-0.172699",
				"zoom"     => "12",
				"marker"   => "yes"
			),
			$atts
		));

		/* Enqueue Scripts */
		$google_map_string = 'https://maps.google.com/maps/api/js';
		$api_key = get_theme_mod('google_maps_api_key', 'AIzaSyAczvbMZbgbPjgBbwEB-yxX4_TkREfUuxM');
		$google_map_string .= '?key=' . $api_key;
		wp_register_script("googlemapapi", $google_map_string);
		wp_enqueue_script("googlemapapi");
		?>
		<?php ob_start(); ?>
		<?php $map_id = rand(); ?>
		<script type="text/javascript">
			jQuery(document).ready(function () {
				function initialize() {
					var mapDiv = jQuery('#map-canvas-<?php echo esc_js($map_id) ?>'),
					mapStyle = (mapDiv.data('map-style')) ? (mapDiv.data('map-style')) : 1;
					//we define here the style of the map
		if (mapStyle=='1') {
			var style= [{"featureType": "all", "elementType": "labels.text.fill", "stylers": [{"saturation": 36},{"color": "#000000"},{"lightness": 40}]},{"featureType": "all", "elementType": "labels.text.stroke", "stylers": [{"visibility": "on"},{"color": "#000000"},{"lightness": 16}]},{"featureType": "all", "elementType": "labels.icon", "stylers": [{"visibility": "off"}]},{"featureType": "administrative", "elementType": "geometry.fill", "stylers": [{"color": "#000000"},{"lightness": 20}]},{"featureType": "administrative", "elementType": "geometry.stroke", "stylers": [{"color": "#000000"},{"lightness": 17},{"weight": 1.2}]},{"featureType": "landscape", "elementType": "geometry", "stylers": [{"color": "#000000"},{"lightness": 20}]},{"featureType": "poi", "elementType": "geometry", "stylers": [{"color": "#000000"},{"lightness": 21}]},{"featureType": "road.highway", "elementType": "geometry.fill", "stylers": [{"color": "#000000"},{"lightness": 17}]},{"featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{"color": "#000000"},{"lightness": 29},{"weight": 0.2}]},{"featureType": "road.arterial", "elementType": "geometry", "stylers": [{"color": "#000000"},{"lightness": 18}]},{"featureType": "road.local", "elementType": "geometry", "stylers": [{"color": "#000000"},{"lightness": 16}]},{"featureType": "transit", "elementType": "geometry", "stylers": [{"color": "#000000"},{"lightness": 19}]},{"featureType": "water", "elementType": "geometry", "stylers": [{"color": "#000000"},{"lightness": 17}]}];
		} if (mapStyle=='2') {
			var style= [{"featureType": "all", "elementType": "all", "stylers": [{"saturation": -100},{"gamma": 0.5}]}];
		} if (mapStyle=='3') {
			var style= [{"featureType": "water", "elementType": "geometry.fill", "stylers": [{"color": "#d3d3d3"}]},{"featureType": "transit", "stylers": [{"color": "#808080"},{"visibility": "off"}]},{"featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{"visibility": "on"},{"color": "#b3b3b3"}]},{"featureType": "road.highway", "elementType": "geometry.fill", "stylers": [{"color": "#ffffff"}]},{"featureType": "road.local", "elementType": "geometry.fill", "stylers": [{"visibility": "on"},{"color": "#ffffff"},{"weight": 1.8}]},{"featureType": "road.local", "elementType": "geometry.stroke", "stylers": [{"color": "#d7d7d7"}]},{"featureType": "poi", "elementType": "geometry.fill", "stylers": [{"visibility": "on"},{"color": "#ebebeb"}]},{"featureType": "administrative", "elementType": "geometry", "stylers": [{"color": "#a7a7a7"}]},{"featureType": "road.arterial", "elementType": "geometry.fill", "stylers": [{"color": "#ffffff"}]},{"featureType": "road.arterial", "elementType": "geometry.fill", "stylers": [{"color": "#ffffff"}]},{"featureType": "landscape", "elementType": "geometry.fill", "stylers": [{"visibility": "on"},{"color": "#efefef"}]},{"featureType": "road", "elementType": "labels.text.fill", "stylers": [{"color": "#696969"}]},{"featureType": "administrative", "elementType": "labels.text.fill", "stylers": [{"visibility": "on"},{"color": "#737373"}]},{"featureType": "poi", "elementType": "labels.icon", "stylers": [{"visibility": "off"}]},{"featureType": "poi", "elementType": "labels", "stylers": [{"visibility": "off"}]},{"featureType": "road.arterial", "elementType": "geometry.stroke", "stylers": [{"color": "#d6d6d6"}]},{"featureType": "road", "elementType": "labels.icon", "stylers": [{"visibility": "off"}]},{},{"featureType": "poi", "elementType": "geometry.fill", "stylers": [{"color": "#dadada"}]}];
		} if (mapStyle=='4') {
			var style= [{"featureType": "all", "elementType": "labels.text.fill", "stylers": [{"color": "#ffffff"}]},{"featureType": "all", "elementType": "labels.text.stroke", "stylers": [{"color": "#000000"},{"lightness": 13}]},{"featureType": "administrative", "elementType": "geometry.fill", "stylers": [{"color": "#000000"}]},{"featureType": "administrative", "elementType": "geometry.stroke", "stylers": [{"color": "#144b53"},{"lightness": 14},{"weight": 1.4}]},{"featureType": "landscape", "elementType": "all", "stylers": [{"color": "#08304b"}]},{"featureType": "poi", "elementType": "geometry", "stylers": [{"color": "#0c4152"},{"lightness": 5}]},{"featureType": "road.highway", "elementType": "geometry.fill", "stylers": [{"color": "#000000"}]},{"featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{"color": "#0b434f"},{"lightness": 25}]},{"featureType": "road.arterial", "elementType": "geometry.fill", "stylers": [{"color": "#000000"}]},{"featureType": "road.arterial", "elementType": "geometry.stroke", "stylers": [{"color": "#0b3d51"},{"lightness": 16}]},{"featureType": "road.local", "elementType": "geometry", "stylers": [{"color": "#000000"}]},{"featureType": "transit", "elementType": "all", "stylers": [{"color": "#146474"}]},{"featureType": "water", "elementType": "all", "stylers": [{"color": "#021019"}]}];
		} if (mapStyle=='5') {
			var style= [{"featureType": "administrative", "elementType": "labels.text.fill", "stylers": [{"color": "#444444"}]},{"featureType": "landscape", "elementType": "all", "stylers": [{"color": "#f2f2f2"}]},{"featureType": "poi", "elementType": "all", "stylers": [{"visibility": "off"}]},{"featureType": "road", "elementType": "all", "stylers": [{"saturation": -100},{"lightness": 45}]},{"featureType": "road.highway", "elementType": "all", "stylers": [{"visibility": "simplified"}]},{"featureType": "road.arterial", "elementType": "labels.icon", "stylers": [{"visibility": "off"}]},{"featureType": "transit", "elementType": "all", "stylers": [{"visibility": "off"}]},{"featureType": "water", "elementType": "all", "stylers": [{"color": "#46bcec"},{"visibility": "on"}]}];
		} if (mapStyle=='6') {
			var style= [{"stylers": [{"hue": "#2c3e50"},{"saturation": 250}]},{"featureType": "road", "elementType": "geometry", "stylers": [{"lightness": 50},{"visibility": "simplified"}]},{"featureType": "road", "elementType": "labels", "stylers": [{"visibility": "off"}]}];
		} if (mapStyle=='7') {
			var style= [{"featureType": "water", "stylers": [{"color": "#19a0d8"}]},{"featureType": "administrative", "elementType": "labels.text.stroke", "stylers": [{"color": "#ffffff"},{"weight": 6}]},{"featureType": "administrative", "elementType": "labels.text.fill", "stylers": [{"color": "#e85113"}]},{"featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{"color": "#efe9e4"},{"lightness": -40}]},{"featureType": "road.arterial", "elementType": "geometry.stroke", "stylers": [{"color": "#efe9e4"},{"lightness": -20}]},{"featureType": "road", "elementType": "labels.text.stroke", "stylers": [{"lightness": 100}]},{"featureType": "road", "elementType": "labels.text.fill", "stylers": [{"lightness": -100}]},{"featureType": "road.highway", "elementType": "labels.icon"},{"featureType": "landscape", "elementType": "labels", "stylers": [{"visibility": "off"}]},{"featureType": "landscape", "stylers": [{"lightness": 20},{"color": "#efe9e4"}]},{"featureType": "landscape.man_made", "stylers": [{"visibility": "off"}]},{"featureType": "water", "elementType": "labels.text.stroke", "stylers": [{"lightness": 100}]},{"featureType": "water", "elementType": "labels.text.fill", "stylers": [{"lightness": -100}]},{"featureType": "poi", "elementType": "labels.text.fill", "stylers": [{"hue": "#11ff00"}]},{"featureType": "poi", "elementType": "labels.text.stroke", "stylers": [{"lightness": 100}]},{"featureType": "poi", "elementType": "labels.icon", "stylers": [{"hue": "#4cff00"},{"saturation": 58}]},{"featureType": "poi", "elementType": "geometry", "stylers": [{"visibility": "on"},{"color": "#f0e4d3"}]},{"featureType": "road.highway", "elementType": "geometry.fill", "stylers": [{"color": "#efe9e4"},{"lightness": -25}]},{"featureType": "road.arterial", "elementType": "geometry.fill", "stylers": [{"color": "#efe9e4"},{"lightness": -10}]},{"featureType": "poi", "elementType": "labels", "stylers": [{"visibility": "simplified"}]}];
		} if (mapStyle=='8') {
			var style= [{"featureType": "administrative", "elementType": "all", "stylers": [{"visibility": "on"},{"lightness": 33}]},{"featureType": "landscape", "elementType": "all", "stylers": [{"color": "#f2e5d4"}]},{"featureType": "poi.park", "elementType": "geometry", "stylers": [{"color": "#c5dac6"}]},{"featureType": "poi.park", "elementType": "labels", "stylers": [{"visibility": "on"},{"lightness": 20}]},{"featureType": "road", "elementType": "all", "stylers": [{"lightness": 20}]},{"featureType": "road.highway", "elementType": "geometry", "stylers": [{"color": "#c5c6c6"}]},{"featureType": "road.arterial", "elementType": "geometry", "stylers": [{"color": "#e4d7c6"}]},{"featureType": "road.local", "elementType": "geometry", "stylers": [{"color": "#fbfaf7"}]},{"featureType": "water", "elementType": "all", "stylers": [{"visibility": "on"},{"color": "#acbcc9"}]}];
		} if (mapStyle=='9') {
			var style= [{"featureType": "administrative", "elementType": "all", "stylers": [{"visibility": "off"}]},{"featureType": "landscape", "elementType": "all", "stylers": [{"visibility": "simplified"},{"hue": "#0066ff"},{"saturation": 74},{"lightness": 100}]},{"featureType": "poi", "elementType": "all", "stylers": [{"visibility": "simplified"}]},{"featureType": "road", "elementType": "all", "stylers": [{"visibility": "simplified"}]},{"featureType": "road.highway", "elementType": "all", "stylers": [{"visibility": "off"},{"weight": 0.6},{"saturation": -85},{"lightness": 61}]},{"featureType": "road.highway", "elementType": "geometry", "stylers": [{"visibility": "on"}]},{"featureType": "road.arterial", "elementType": "all", "stylers": [{"visibility": "off"}]},{"featureType": "road.local", "elementType": "all", "stylers": [{"visibility": "on"}]},{"featureType": "transit", "elementType": "all", "stylers": [{"visibility": "simplified"}]},{"featureType": "water", "elementType": "all", "stylers": [{"visibility": "simplified"},{"color": "#5f94ff"},{"lightness": 26},{"gamma": 5.86}]}];
		} if (mapStyle=='10') {
			var style= [{"featureType": "landscape.natural", "elementType": "geometry.fill", "stylers": [{"visibility": "on"},{"color": "#e0efef"}]},{"featureType": "poi", "elementType": "geometry.fill", "stylers": [{"visibility": "on"},{"hue": "#1900ff"},{"color": "#c0e8e8"}]},{"featureType": "road", "elementType": "geometry", "stylers": [{"lightness": 100},{"visibility": "simplified"}]},{"featureType": "road", "elementType": "labels", "stylers": [{"visibility": "off"}]},{"featureType": "transit.line", "elementType": "geometry", "stylers": [{"visibility": "on"},{"lightness": 700}]},{"featureType": "water", "elementType": "all", "stylers": [{"color": "#7dcdcd"}]}];
		} if (mapStyle=='11') {
			var style= [{"featureType": "landscape.man_made", "elementType": "geometry", "stylers": [{"color": "#f7f1df"}]},{"featureType": "landscape.natural", "elementType": "geometry", "stylers": [{"color": "#d0e3b4"}]},{"featureType": "landscape.natural.terrain", "elementType": "geometry", "stylers": [{"visibility": "off"}]},{"featureType": "poi", "elementType": "labels", "stylers": [{"visibility": "off"}]},{"featureType": "poi.business", "elementType": "all", "stylers": [{"visibility": "off"}]},{"featureType": "poi.medical", "elementType": "geometry", "stylers": [{"color": "#fbd3da"}]},{"featureType": "poi.park", "elementType": "geometry", "stylers": [{"color": "#bde6ab"}]},{"featureType": "road", "elementType": "geometry.stroke", "stylers": [{"visibility": "off"}]},{"featureType": "road", "elementType": "labels", "stylers": [{"visibility": "off"}]},{"featureType": "road.highway", "elementType": "geometry.fill", "stylers": [{"color": "#ffe15f"}]},{"featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{"color": "#efd151"}]},{"featureType": "road.arterial", "elementType": "geometry.fill", "stylers": [{"color": "#ffffff"}]},{"featureType": "road.local", "elementType": "geometry.fill", "stylers": [{"color": "black"}]},{"featureType": "transit.station.airport", "elementType": "geometry.fill", "stylers": [{"color": "#cfb2db"}]},{"featureType": "water", "elementType": "geometry", "stylers": [{"color": "#a2daf2"}]}];
		} if (mapStyle=='12') {
			var style= [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}];
		} if (mapStyle=='13') {
			var style= [{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"simplified"}]},{"featureType":"transit","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"visibility":"off"}]},{"featureType":"road.local","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"water","stylers":[{"color":"#84afa3"},{"lightness":52}]},{"stylers":[{"saturation":-17},{"gamma":0.36}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#3f518c"}]}];
		} if (mapStyle=='14') {
			var style= [{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#165c64"},{"saturation":34},{"lightness":-69},{"visibility":"on"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"hue":"#b7caaa"},{"saturation":-14},{"lightness":-18},{"visibility":"on"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"hue":"#cbdac1"},{"saturation":-6},{"lightness":-9},{"visibility":"on"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#8d9b83"},{"saturation":-89},{"lightness":-12},{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"hue":"#d4dad0"},{"saturation":-88},{"lightness":54},{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"hue":"#bdc5b6"},{"saturation":-89},{"lightness":-3},{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#bdc5b6"},{"saturation":-89},{"lightness":-26},{"visibility":"on"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"hue":"#c17118"},{"saturation":61},{"lightness":-45},{"visibility":"on"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"hue":"#8ba975"},{"saturation":-46},{"lightness":-28},{"visibility":"on"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"hue":"#a43218"},{"saturation":74},{"lightness":-51},{"visibility":"simplified"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":0},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"administrative.neighborhood","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":0},{"lightness":100},{"visibility":"off"}]},{"featureType":"administrative.locality","elementType":"labels","stylers":[{"hue":"#ffffff"},{"saturation":0},{"lightness":100},{"visibility":"off"}]},{"featureType":"administrative.land_parcel","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":0},{"lightness":100},{"visibility":"off"}]},{"featureType":"administrative","elementType":"all","stylers":[{"hue":"#3a3935"},{"saturation":5},{"lightness":-57},{"visibility":"off"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"hue":"#cba923"},{"saturation":50},{"lightness":-46},{"visibility":"on"}]}];
		} if (mapStyle=='15') {
			var style= [{"stylers":[{"hue":"#dd0d0d"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]}];
		} if (mapStyle=='16') {
			var style= [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}];
		} if (mapStyle=='17') {
			var style= [{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-68},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}];
		} if (mapStyle=='18') {
			var style= [{"featureType":"landscape","stylers":[{"hue":"#FFBB00"},{"saturation":43.400000000000006},{"lightness":37.599999999999994},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#FFC200"},{"saturation":-61.8},{"lightness":45.599999999999994},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FF0300"},{"saturation":-100},{"lightness":51.19999999999999},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#FF0300"},{"saturation":-100},{"lightness":52},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#0078FF"},{"saturation":-13.200000000000003},{"lightness":2.4000000000000057},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#00FF6A"},{"saturation":-1.0989010989011234},{"lightness":11.200000000000017},{"gamma":1}]}];
		} if (mapStyle=='19') {
			var style= [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]}];
		} if (mapStyle=='20') {
			var style= [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}];
		}
		var myLatlng = new google.maps.LatLng(<?php echo esc_js($lat); ?>, <?php echo esc_js($lng); ?>);
		var mapOptions = {
			center     : myLatlng,
			scrollwheel: false,
			map        : map,
			mapTypeId  : google.maps.MapTypeId.<?php echo esc_js($map_type); ?>,
			zoom       : <?php echo esc_js($zoom); ?>,
			styles: style
		};
		var map = new google.maps.Map(document.getElementById("map-canvas-<?php echo esc_js($map_id); ?>"), mapOptions);
		var marker = new google.maps.Marker({position: myLatlng});
		<?php if ($marker == 'yes') { ?>marker.setMap(map);
		<?php } ?>
	}

				google.maps.event.addDomListener(window, 'load', initialize);
			});
		</script>

		<div class="calluna-map wpb_content_element" data-map-style="<?php echo esc_attr($style); ?>" style="<?php if ($height) { ?>height: <?php echo esc_attr($height); ?><?php } ?>px" id="map-canvas-<?php echo esc_attr($map_id) ?>"></div>
		<?php
		$google_map_output = ob_get_contents();
		ob_end_clean();
		return $google_map_output;
		?>
	<?php
	}

	add_shortcode('cl_google_map', 'calluna_google_map_shortcode');

// Image Gallery -------------------------------------------------------------------- >
function calluna_image_gallery_shortcode($atts, $content = NULL) {

		extract(shortcode_atts(array(
				'images'      => '',
				'link_images' => 'none',
				'uniqid'      => uniqid()
			),
			$atts
		));

		wp_enqueue_script('prettyphoto'); // Already registered with Visual Composer
		wp_enqueue_style('prettyphoto'); // Already registered with Visual Composer

		?>
		<?php ob_start(); ?>
        <div class="image-gallery">
                <div id="<?php echo esc_attr($uniqid); ?>-carousel" class="carousel slide" data-ride="carousel">
                	<?php
						$args = array(
							'post_type'      => array('attachment'),
							'post_status'    => 'inherit',
							'posts_per_page' => -1,
							'orderby'        => 'post__in',
							'post__in'       => explode(',', $images)
						);
						$custom_loop = new WP_Query($args);
						$number = 0;
					?>
                    <?php if ($custom_loop->have_posts()) { ?>
                    	<div class="carousel-inner">
								<?php while ($custom_loop->have_posts()) {
									$custom_loop->the_post(); ?>
									<?php $bonk = get_the_ID(); ?>
                                    <div class="item <?php echo esc_attr($number) == 0 ? 'active' : ''; ?>">
										<?php if ($link_images == 'none') { ?>
											<!-- Image -->
											<?php echo wp_get_attachment_image(get_the_ID(), 'full'); ?>
										<?php } ?>
										<?php if ($link_images == 'prettyphoto') { ?>
											<!-- Image -->
											<a href="<?php echo esc_url( wp_get_attachment_url(get_the_ID()) ); ?>" class="link_image prettyphoto" rel="prettyPhoto"><?php echo wp_get_attachment_image(get_the_ID(), 'full'); ?></a>
										<?php } ?>
										<?php if ($link_images == 'newtab') { ?>
											<!-- Image -->
											<a href="<?php echo esc_url( wp_get_attachment_url(get_the_ID())); ?>" target="_blank" class="link_image"><?php echo wp_get_attachment_image(get_the_ID(), 'full'); ?></a>
										<?php } ?>
                                    </div>

								<?php $number++; } // End while ?>
								<?php wp_reset_query(); ?>
                         </div>
                         <div class="gallery_button_wrapper">
                        <a class="left carousel-control" href="#<?php echo esc_attr($uniqid) ?>-carousel" data-slide="prev">
                        <span class="icon-left"></span>
                    </a>
                    </div>
                    <div class="gallery_button_wrapper">
                        <a class="right carousel-control" href="#<?php echo esc_attr($uniqid) ?>-carousel" data-slide="next">
                        <span class="icon-right"></span>
                    </a>
                    </div>
						<?php } else { // No posts published
                        		esc_html_e( 'No data to display.', 'calluna-shortcodes' );
							} // End if ?>

               </div>
	  		  </div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
		?>
	<?php
	}

	add_shortcode('cl_gallery', 'calluna_image_gallery_shortcode');

// Event Carousel -------------------------------------------------------------------- >
function calluna_event_carousel_shortcode($atts, $content = NULL) {

		extract(shortcode_atts(array(
            'items'			=> '3',
            'order'			=> 'DESC',
            'orderby'		=> 'date',
            'max_items'       => '8',
			'categories' 	=> 'all',
			'featured_images' => 'yes',
			'img_crop'		=> 'true',
			'img_width'		=> '420',
			'img_height'	=> '171',
			'excerpt_length' => '30'
		), $atts));

		global $post;

        $post_ID = get_the_ID();
		$args = array(
			'post_type' => 'event',
			'posts_per_page' => $max_items,
			'post__not_in' => array( $post_ID ),
			'order'          => $order,
			'orderby'        => $orderby,
			'post_status'    => 'publish',

		);
        if($orderby == 'date') {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_calluna_event_date';
        }
		if($categories != 'all'){
			$str = $categories;
			$arr = explode(',', $str); // string to array

			$args['tax_query'][] = array(
				'taxonomy'  => 'category',
				'field'   => 'slug',
				'terms'   => $arr
			);
		}

        wp_enqueue_style('calluna-carousel-style');
		wp_enqueue_script('calluna-carousel');

        ob_start();

		$wp_query = new WP_Query($args); ?>
		<?php if( $wp_query->have_posts() ) : ?>
			<div class="calluna-event2-carousel">
			<div class="event2-carousel owl-carousel owl-theme" data-items="<?php echo esc_attr( $items ); ?>">

            <?php
			while ( $wp_query->have_posts() ) : $wp_query->the_post();

                $event_month = date_i18n('F', strtotime(get_post_meta(get_the_ID(), "_calluna_event_date", true)));
                $event_day = date('d', strtotime(get_post_meta(get_the_ID(), "_calluna_event_date", true)));

		  		$featured_img_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
				$featured_img     = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

	  			if ( has_excerpt( $post->ID ) ) {
                    $custom_excerpt = $post->post_excerpt;
                }
                else {
                    $custom_excerpt = wp_trim_words( strip_shortcodes( $post->post_content ), $excerpt_length);
                }

				// Crop featured images if necessary
				if ( $img_crop == 'true' ) {
					$thumbnail_hard_crop = $img_height == '9999' ? false : true;
					$featured_img = calluna_shortcodes_img_resize( $featured_img_url, $img_width, $img_height, $thumbnail_hard_crop );
				}
                ?>
				<div class="event-item">
                    <?php
                    if ( has_post_thumbnail( $post->ID ) && $featured_images != 'no' ) { ?>
                    <div class="event-image-button-wrapper">
                        <a href="<?php echo esc_url(get_permalink()) ?>" title="<?php echo esc_attr(get_the_title()) ?>" class="event-pic">
                            <img src="<?php echo esc_url($featured_img)?>" alt="" />
                        </a>
                        <div class="event-image-button-wrapper">
                            <div class="event-image-arrow"></div>
                            <a href="<?php echo esc_url(get_permalink()) ?>" class="event-image-button"><i class="icon-forward"></i></a>
                        </div>
                    </div>

                    <?php } ?>
                    <div class="event-title-wrapper clearfix">
                        <div class="event-date-wrapper">
                            <div class="inner-wrapper">
                                <div class="event-month"> <?php  echo esc_attr($event_month); ?>
                                </div>
                                <div class="event-day">
                                    <?php  echo esc_attr($event_day); ?>
                                </div>
                            </div>
                        </div>

                        <div class="event-title">
                            <h3>
                                <a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a>
                            </h3>
                        </div>
                    </div>
                    <div class="event-excerpt">
                        <p><?php echo esc_attr($custom_excerpt) ?></p>
                    </div>
				</div>

			<?php endwhile; ?>

			</div>

			</div><div class="clearfix"></div>

		    <?php
		    wp_reset_postdata();

		endif;

        $calluna_event_carousel_output = ob_get_contents();
		ob_end_clean();
		return $calluna_event_carousel_output;

	}

add_shortcode('cl_event_carousel', 'calluna_event_carousel_shortcode');

// Offer Carousel ------------------------------------------------------------------- >
function calluna_offer_carousel_shortcode($atts, $content = NULL) {

		extract(shortcode_atts(array(
				'parent_cat'     => '',
		  		'items'			=> '3',
				'wrap'           => 'circular',
				'max_items'       => '8',
				'featured_images' => 'yes',
				'uniqid'          => uniqid()
			),
			$atts
		));

		/* Enqueue Scripts */
		wp_enqueue_script('jcarousel');
		wp_enqueue_script('touchSwipe');
		?>
		<?php ob_start(); ?>

		<div>

        <?php
		$post_ID = get_the_ID();
		if ($parent_cat) {
			$custom_loop = new WP_Query(array(
				'post_type'      => 'offer',
				'posts_per_page' => $max_items,
				'order'		 => 'ASC',
				'orderby'   => 'meta_value_num',
				'meta_key'  => '_calluna_offer_price',
				'post__not_in' => array( $post_ID ),
				'tax_query'      => array(
					array(
						'taxonomy' => 'offer_category',
						'field'    => 'id',
						'terms'    => array($parent_cat)
					)
				)
			));
		} else {
			$custom_loop = new WP_Query(array(
				'post_type'      => 'offer',
				'posts_per_page' => $max_items,
				'order'		 => 'ASC',
				'orderby'   => 'meta_value_num',
				'meta_key'  => '_calluna_offer_price',
				'post__not_in' => array( $post_ID ),
			));
		}
	?>

		<?php if ($custom_loop->have_posts()) { ?>
			<?php
			/* Generate Random ID */
			$offer_carousel_id = 'offer_carousel_' . rand();
			?>
			<div class="carousel-holder offer-carousel">
				<script>
					(function ($) {
						$(function () {

							/* Check for Mobile */
							if (Modernizr.touch) {
								var _transforms3d = true;
							} else {
								var _transforms3d = false;
							}
							var item_count = <?php echo esc_js($items); ?>;
							var jcarousel = $('.jcarousel-<?php echo esc_js($offer_carousel_id) ?>');
							jcarousel.on('jcarousel:reload jcarousel:create', function () {
								var width = jcarousel.innerWidth();
								//var containerwidth = jQuery('.content-width').width();

								if (width >= 1440) {
									width = width / item_count + 2;
								}
							  	else if (width >= 1025) {
									if (item_count < 3) {
									width = width / item_count + 2;
								  } else {
									width = width / 3 + 2;
								  }
								}
							  	else if (width >= 600) {
									if (item_count < 2) {
									width = width / item_count + 2;
								  } else {
									width = width / 2 + 2;
								  }
								}
								jcarousel.jcarousel('items').css('width', width + 'px');
							})
							.jcarousel({
								wrap       : 'circular',
								transitions: {
									transoforms : true,
									transforms3d: _transforms3d,
									easing      : 'swing'
									}
							});
							/* Auto height */
							var maxHeight = "400";
							jcarousel.jcarousel('visible').each(function () {
							  maxHeight = maxHeight > $(this).height() ? maxHeight + 1 : $(this).height() + 1;
							});

							/* Reset on window load for safari */
							$(window).load(function () {
								jcarousel.jcarousel('reload');
							});

							/* Reset on window resize */
							$(window).resize(function () {
								jcarousel.jcarousel('reload');
							});

							/* Auto height on animate and reload */
							jcarousel.on('jcarousel:animate jcarousel:reload', function (event, carousel, target, animate) {
								var maxHeight = "400";
								jcarousel.jcarousel('visible').each(function () {
								  maxHeight = maxHeight > $(this).height() ? maxHeight + 1 : $(this).height() + 1;
								});
								jcarousel.animate({height: maxHeight}, 300);
							});
						  	jcarousel.height(maxHeight);
							/* End auto height */
							$('.jcarousel-<?php echo esc_js($offer_carousel_id) ?>-control-prev')
							.jcarouselControl({
								target: '-=1'
							});
							$('.jcarousel-<?php echo esc_js($offer_carousel_id) ?>-control-next')
							.jcarouselControl({
								target: '+=1'
							});
							/* Mobile Pagination */
							$('.jcarousel-<?php echo esc_js($offer_carousel_id) ?>-pagination')
							.on('jcarouselpagination:active', 'li', function () {
								$(this).addClass('active');
							})
							.on('jcarouselpagination:inactive', 'li', function () {
								$(this).removeClass('active');
							})
							.jcarouselPagination({
								'item': function (page, carouselItems) {
									return '<li><a href="#' + page + '"></a></li>';
								}
							});
							/* Swipe */
							jcarousel.swipe({
								excludedElements     : "",
								fallbackToMouseEvents: false,
							  	allowPageScroll:"auto",
								swipeLeft            : function (event, direction, distance, duration, fingerCount) {
									jcarousel.jcarousel('scroll', '+=1');
								},
								swipeRight           : function (event, direction, distance, duration, fingerCount) {
									jcarousel.jcarousel('scroll', '-=1');
								}
							});
						});
					})(jQuery);
				</script>

				<!-- Carousel -->
				<div class="jcarousel-outer">
				<h1>HELOEEE</h1>
					<div class="jcarousel-wrapper">
						<div class="jcarousel-<?php echo esc_attr($offer_carousel_id) ?> jcarousel">
							<ul>
								<?php while ($custom_loop->have_posts()) {
									$custom_loop->the_post(); ?>
									<li class="jcarousel-item">
											<div class="jcarousel-item_inner">
                                            	<!--Image -->
                                            <?php if ($featured_images == 'yes') { ?>
											<?php	$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large' ); ?>
                                            <div>
                                            	<div class="event_grid">
                               <a href="<?php esc_url(the_permalink()); ?>">
                                                <img src="<?php echo esc_attr($thumbnail[0]); ?>" alt="<?php esc_html_e( 'Event image', 'calluna-shortcodes' );?>" class="img-responsive"></a>
                                            	</div>
                                            </div>
                                            <?php } //end image ?>
                                            <div>
	<div>
		<div class="row">
	<div class="col-sm-12 col-xs-12">
    	<div class="offer_title"><h3><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h3></div>
        </div>
        </div>
        <div class="row"><div class="col-sm-12 item_text_wrapper">
        <div class="item_text"><?php the_excerpt(); ?>
        </div>
        <?php // WPML translations
            $pre_text = get_theme_mod( 'offer_price_text', 'Price per person');
            $pre_text = calluna_translate_theme_mod( 'offer_price_text', $pre_text );
        ?>
        <div class="offer_price"><span><?php echo esc_attr($pre_text); ?></span>
        <?php
			$currency_symbol = get_theme_mod( 'currency', '$');
			$price = get_post_meta( get_the_ID(), '_calluna_offer_price', true );
			if (get_theme_mod('currency_pos', 'before') == 'before') {
				echo esc_attr($currency_symbol) . esc_attr($price);
			}
			else {
				echo esc_attr($price) . esc_attr($currency_symbol);
			}
		?>
	</div>
        </div>
        </div>
        </div>
</div>
											</div>
										</li>
								<?php } // End while ?>
								<?php wp_reset_query(); ?>
							</ul>
						</div>
					</div>
                    <!-- Desktop Nav -->
                    <div class="jcarousel-nav">
                    	<a href="#" class="jcarousel-<?php echo esc_attr($offer_carousel_id) ?>-control-prev jcarousel-prev"><i class="icon-left"></i></a>
                            <a href="#" class="jcarousel-<?php echo esc_attr($offer_carousel_id) ?>-control-next jcarousel-next"><i class="icon-right"></i></a>
                    </div>
					<!-- Mobile Pager -->
					<div class="jcarousel-<?php echo esc_attr($offer_carousel_id) ?>-pagination mobile-pagination"></div>
				</div>
			</div>
		<?php } ?>
		</div>
		<?php
		$offer_carousel_output = ob_get_contents();
		ob_end_clean();
		return $offer_carousel_output;
		?>






<h1>HFGDAGADF</h1>



// Room price -------------------------------------------------------------------------- >
function calluna_room_price_shortcode( $atts, $content = null ) {
  	?>

	<?php ob_start(); ?>
       		<?php $price = AWE_function::apb_price(get_post_meta(get_the_ID(),"base_price",true));?>
                        <?php if (! empty( $price )) { ?>
                            <div class="offer_price">
                            	<?php $pre_text = get_theme_mod( 'room_price_text', 'starting at');
                            	// WPML translations
                                $pre_text = calluna_translate_theme_mod( 'room_price_text', $pre_text );
								$pre_text .= ' ';
							  	?>
                            	<span><?php echo esc_attr($pre_text) ?></span>
                                <?php
									echo esc_attr($price);
								?>
                            </div>
                        <?php }?>
		<?php
		$calluna_room_price_output = ob_get_contents();
		ob_end_clean();
		return $calluna_room_price_output;

}
add_shortcode( 'cl_room_price', 'calluna_room_price_shortcode' );

// Offer price -------------------------------------------------------------------------- >
function calluna_offer_price_shortcode( $atts, $content = null ) {
  	?>

	<?php ob_start(); ?>
       		<?php $price = get_post_meta(get_the_ID(),'_calluna_offer_price',true);?>
                        <?php if (! empty( $price )) { ?>
                            <div class="offer_price">
							  	<?php $pre_text = get_theme_mod( 'offer_price_text', 'Price per person');
							  	// WPML translations
                                $pre_text = calluna_translate_theme_mod( 'offer_price_text', $pre_text );
							  	$pre_text .= ' '; ?>
                            	<span><?php echo esc_attr($pre_text) ?></span>
                                <?php
									$currency_symbol = get_theme_mod( 'currency', '$');
									if (get_theme_mod('currency_pos', 'before') == 'before') {
										echo esc_attr($currency_symbol). esc_attr($price);
									}
									else {
										echo esc_attr($price) . esc_attr($currency_symbol);
									}
								?>
                            </div>
                        <?php }?>
		<?php
		$calluna_offer_price_output = ob_get_contents();
		ob_end_clean();
		return $calluna_offer_price_output;

}
add_shortcode( 'cl_offer_price', 'calluna_offer_price_shortcode' );

// Time ----------------------------------------------------------------------------- >
function calluna_time_shortcode($atts, $content = NULL) {

		extract(shortcode_atts(array(
				'icon' => 'yes',
				'icon_color'       => '',
				'text_color' => '',
				'time_format' => 'h:i A'
			),
			$atts
		));
		?>
		<?php ob_start(); ?>
       		<?php if ($icon == 'yes') { ?>
            <div class="calluna-time">
            	<span class="icon-clock" <?php if ($icon_color) { ?>style="color: <?php echo esc_attr($icon_color); ?>;"<?php } ?>></span>
                <span class="time" <?php if ($text_color) { ?> style="color: <?php echo esc_attr($text_color); ?>;"<?php } ?>>
           	<?php echo current_time( esc_attr($time_format) ); ?>
           </span>
            </div>
		<?php } ?>
        <?php if ($icon == 'no') { ?>
			<span class="time" <?php if ($text_color) { ?>style="color: <?php echo esc_attr($text_color) ?>;"<?php } ?>>
           	<?php echo current_time( esc_attr($time_format) ); ?>
           </span>
		<?php } ?>
		<?php
		$calluna_time_output = ob_get_contents();
		ob_end_clean();
		return $calluna_time_output;
		?>
	<?php
	}

	add_shortcode('cl_time', 'calluna_time_shortcode');

// Callout -------------------------------------------------------------------------- >
function calluna_callout_shortcode( $atts, $content = null  ) {
	extract( shortcode_atts( array(
		'caption'				=> '',
		'button_text'			=> '',
		'fade_in'				=> '',
		'button_style'			=> 'style-1',
		'button_size'			=> '',
		'button_url'			=> '#',
		'button_rel'			=> 'nofollow',
		'button_target'			=> 'blank',
		'button_title'			=> esc_html__( 'Callout button', 'calluna-shortcodes' ),
		'class'					=> '',
		'button_icon_left'		=> '',
		'button_icon_right'		=> '',
	), $atts ) );

	// Sanitize
	$button_icon_left  = calluna_shortcodes_font_icon_class( $button_icon_left );
	$button_icon_right = calluna_shortcodes_font_icon_class( $button_icon_right );
	$button_url        = esc_url( $button_url );
	$button_title      = esc_attr( $button_title );

	// Load required scripts
	if ( $button_icon_left || $button_icon_right ) {
		wp_enqueue_style( 'font-awesome' );
	}

	// Fade in
	$fade_in_class = null;
	if ( $fade_in == 'true' ) {
		wp_enqueue_script( 'calluna-scroll-fade' );
		$fade_in_class = 'calluna-fadein';
	}

	// Display Callout
	$output = '<div class="calluna-callout calluna-clearfix '. $class .' '. $fade_in_class .'">';
	$output .= '<div class="calluna-callout-caption">';
		$output .= do_shortcode ( $content );
	$output .= '</div>';
	if ( $button_text && $button_url ) {
		$button_rel    = 'nofollow' == $button_rel ? ' rel="nofollow"' : null;
		$button_target = ( strpos( $button_target, 'blank' ) !== false ) ? ' target="_blank"' : null;
		$output .= '<div class="calluna-callout-button">';
			$output .= '<a href="' . $button_url .'" class="calluna-button btn btn-primary '. $button_size .' ' . $button_style . '" title="'. $button_title .'" ' . $button_rel . $button_target .'>';
				$output .= '<span class="calluna-button-inner">';
					if ( $button_icon_left ) {
						$output .= '<span class="calluna-button-icon-left '. $button_icon_left .'"></span>';
					}
					$output .= $button_text;
					if ( $button_icon_right ) {
						$output .= '<span class="calluna-button-icon-right '. $button_icon_right .'"></span>';
					}
				$output .= '</span>';
			$output .= '</a>';
		$output .= '</div>';
	}
	$output .= '</div>';

	return $output;
}
add_shortcode( 'cl_callout', 'calluna_callout_shortcode' );

// Heading -------------------------------------------------------------------------- >
function calluna_heading_shortcode( $atts ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'title'			=> esc_html__( 'Sample Heading', 'calluna-shortcodes' ),
		'type'			=> 'h2',
		'style'			=> 'none',
		'margin_top'	=> '',
		'margin_bottom'	=> '',
		'text_align'	=> '',
		'font_size'		=> '',
		'color'			=> '',
		'class'			=> '',
		'span_bg'       => '',
		'icon_left'		=> '',
		'icon_right'	=> ''
	  ),
	  $atts ) );

	// Sanitize icons
	$icon_right  = calluna_shortcodes_font_icon_class( $icon_right );
	$icon_left = calluna_shortcodes_font_icon_class( $icon_left );
  	$title = esc_attr($title);

	// Load required scripts
	if ( $icon_left || $icon_right) {
		wp_enqueue_style( 'font-awesome' );
	}

	// Inline styles
	$style_attr = '';
	if ( $font_size ) {
		$style_attr .= 'font-size: '. $font_size .';';
	}
	if ( $color ) {
		$style_attr .= 'color: '. $color .';';
	}
	if ( $margin_bottom ) {
		$style_attr .= 'margin-bottom: '. intval( $margin_bottom ) .'px;';
	}
	if ( $margin_top ) {
		$style_attr .= 'margin-top: '. intval( $margin_top ) .'px;';
	}
	if ( $style_attr ) {
		$style_attr = 'style="'. $style_attr .'"';
	}
	if ( $span_bg ) {
		$span_bg = ' style="background-color:'. $span_bg .';"';
	}

	// Text aligns
	if ( $text_align ) {
		$text_align = 'text-align-'. $text_align;
	} else {
		$text_align = 'text-align-left';
	}

	// Output
	$output = '<'.$type.' class="calluna-heading calluna-heading-'. $style .' '. $text_align .' '. $class .'" '. $style_attr .'>';
		$output .= '<span'. $span_bg .'>';
			if ( $icon_left ) {
				$output .= '<i class="calluna-heading-icon-left '. $icon_left .'"></i>';
			}
				$output .= $title;
			if ( $icon_right ) {
				$output .= '<i class="calluna-heading-icon-right '. $icon_right .'"></i>';
			}
		$output .= '</span>';
	$output .= '</'.$type.'>';

	// Return output
	return $output;

}
add_shortcode( 'cl_heading', 'calluna_heading_shortcode' );

// Highlights -------------------------------------------------------------------------- >
function calluna_highlight_shortcode( $atts, $content = null ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'color'	=> 'blue',
		'class'	=> '',
	  ),
	  $atts ) );

	// Return output
	return '<div class="calluna-highlight calluna-highlight-'. $color .' '. $class .'">' . do_shortcode( $content ) . '</div>';

}
add_shortcode( 'cl_highlight', 'calluna_highlight_shortcode' );

// Buttons -------------------------------------------------------------------------- >
function calluna_button_shortcode( $atts, $content = null ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'style'         => 'style-1',
		'url'           => '#',
		'title'         => esc_html__( 'Button', 'calluna-shortcodes' ),
		'target'        => 'self',
		'size'          => 'normal',
		'rel'           => '',
		'class'         => '',
		'icon_left'     => '',
		'icon_right'    => '',
		'fade_in'       => '',
		'align'         => '',
	), $atts ) );

	//Set Vars
	$fade_in_class = null;
	if ( $fade_in == 'true' ) {
		wp_enqueue_script( 'calluna-scroll-fade' );
		$fade_in_class = 'calluna-fadein';
	}

	// Sanitize
	$url        = esc_url($url);
	$title      = $title ? esc_attr( $title ) : '';
	$rel        = ( $rel !== 'none' ) ? ' rel="'.$rel.'"' : null;
	$icon_left  = calluna_shortcodes_font_icon_class( $icon_left );
	$icon_right = calluna_shortcodes_font_icon_class( $icon_right );

	// Load required scripts
	if ( $icon_left || $icon_right ) {
		wp_enqueue_style( 'font-awesome' );
	}
	// Display Button
	if ( $url && $title ) {

		$output= null;
		$output .= '<a href="' . $url . '" class="calluna-button btn btn-primary '. $size .' ' . $style . ' '. $class .' '. $fade_in_class .' '. $align .'" target="_'.$target.'" title="'. $title .'"'. $rel .'>';
			$output .= '<span class="calluna-button-inner">';
				if ( $icon_left ) {
					$output .= '<span class="calluna-button-icon-left '. $icon_left .'"></span>';
				}
				$output .= $title;
				if ( $icon_right ) {
					$output .= '<span class="calluna-button-icon-right '. $icon_right .'"></span>';
				}
			$output .= '</span>';
		$output .= '</a>';
		return $output;

	} else {

		return '<p>'. esc_html__( 'Please enter a valid URL and title for your button.', 'calluna-shortcodes' ) .'</p>';

	}

}
add_shortcode( 'cl_button', 'calluna_button_shortcode' );

// Toggle -------------------------------------------------------------------------- >
function calluna_toggle_shortcode( $atts, $content = null ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'title'	=> 'Toggle Title',
		'class'	=> '',
		'state'	=> 'closed',
	), $atts ) );

	$title = esc_attr($title);
	// Enque scripts
	wp_enqueue_script( 'calluna-toggle' );

	// Active Class
	$active_class = ( $state == 'open' ) ? 'active' : null;

	// Return output
	return '<div class="calluna-toggle state-'. $state .' '. $class .'"><h4 class="calluna-toggle-trigger '. $active_class .'"><i class="calluna-toggle-icon"></i>'. $title .'</h4><div class="calluna-toggle-container calluna-clearfix"><p>' . do_shortcode($content) . '</p></div></div>';

}
add_shortcode( 'cl_toggle', 'calluna_toggle_shortcode' );

// Accordion -------------------------------------------------------------------------- >

// Main
function calluna_accordion_main_shortcode( $atts, $content = null  ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'class'	=> ''
	), $atts ) );

	// Enque scripts
	wp_enqueue_script( 'jquery-ui-accordion' );
	wp_enqueue_script( 'calluna-accordion' );

	// Return output
	return '<div class="calluna-accordion '. $class .'">' . do_shortcode($content) . '</div>';

}
add_shortcode( 'cl_accordion', 'calluna_accordion_main_shortcode' );


// Section
function calluna_accordion_section_shortcode( $atts, $content = null  ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'title'	=> 'Title',
		'class'	=> '',
	), $atts ) );

	$title = esc_attr($title);

	// Return output
	return '<h4 class="calluna-accordion-trigger '. $class .'"><a href="#"><span class="title">'. $title .'</span></a></h4><div class="calluna-clearfix"><p>' . do_shortcode($content) . '</p></div>';

}

add_shortcode( 'cl_accordion_section', 'calluna_accordion_section_shortcode' );


// Tabs -------------------------------------------------------------------------- >
function calluna_tabgroup_shortcode( $atts, $content = null ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(), $atts ) );

	//Enque scripts
	wp_enqueue_script( 'jquery-ui-tabs' );
	//wp_enqueue_script( 'calluna-tabs' );

	preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
	$tab_titles = array();
	if ( isset($matches[1]) ){ $tab_titles = $matches[1]; }
	$output = '';
	if ( count($tab_titles) ){
		$output .= '<div id="calluna-tab-'. rand( 1, 10000 ) .'" class="callu calluna-tabs">';
		$output .= '<ul class="ui-tabs-nav">';
		foreach( $tab_titles as $tab ){
			$output .= '<li><a href="#calluna-tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
		}
		$output .= '</ul>';
		$output .= do_shortcode( $content );
		$output .= '</div>';
	} else {
		$output .= do_shortcode( $content );
	}
	// Return output
	return $output;

}
add_shortcode( 'cl_tabgroup', 'calluna_tabgroup_shortcode' );

function calluna_tab_shortcode( $atts, $content = null ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'title'	=> 'Tab',
		'class'	=> ''
	), $atts ) );

	// Return output
	return '<div id="calluna-tab-'. sanitize_title( $title ) .'" class="tab-content calluna-clearfix '. $class .'"><p>'. do_shortcode( $content ) .'</p></div>';

}
add_shortcode( 'cl_tab', 'calluna_tab_shortcode' );

// Font Awesome Icons -------------------------------------------------------------------------- >
function calluna_fa_icon_shortcode( $atts, $content = null ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
			'unique_id'     => '',
			'icon'          => 'cloud',
			'style'         => 'circle',
			'float'         => 'left',
			'size'          => 'normal',
			'color'         => '',
			'background'    => '',
			'border_radius' => '',
			'fade_in'       => 'false',
			'url'           => '',
			'url_title'     => '',
	), $atts ) );

	// Load font awesome
	wp_enqueue_style( 'font-awesome' );

	$output = '';

	// FadeOut
	$fade_in_class = null;
	if ( $fade_in == 'true' ) {
		wp_enqueue_script( 'calluna-scroll-fade' );
		$fade_in_class = 'calluna-fadein';
	}

	// Sanitize icon
	$url       = esc_url( $url );
	$url_title = esc_attr( $url_title );
	$icon      = $icon == 'none' ? 'remove' : $icon;

	// Inline style
	$style_attr = '';

	if ( $color ) {
		$style_attr .= 'color:'. $color .';';
	}
	if ( $background ) {
		$style_attr .= 'background-color:'. $background .';';
	}
	if ( $border_radius ) {
		$style_attr .= 'border-radius:'. $border_radius .';';
	}
	if ( $style_attr ) {
		$style_attr = ' style="'. $style_attr .'"';
	}

	// Unique ID
	$unique_id = $unique_id ? ' id="'. $unique_id .'"' : null;

	if ( $url ) {
		$output .= '<a href="'. $url .'" title="'. $url_title .'" class="calluna-icon calluna-icon-'. $style.' calluna-icon-'. $size .' calluna-icon-float-'. $float .' '. $fade_in_class .'" '. $unique_id . $style_attr .' >';
		$output .= '<span class="'. calluna_shortcodes_font_icon_class( $icon ) .'"></span>';
		$output .= '</a>';
	} else {
		$output .= '<span class="calluna-icon calluna-icon-'. $style.' calluna-icon-'. $size .' calluna-icon-float-'. $float .' '. calluna_shortcodes_font_icon_class( $icon ) .' '. $fade_in_class .'"'. $unique_id . $style_attr .'"></span>';
	}

	// Return output
	return $output;

}
add_shortcode( 'cl_fa_icon', 'calluna_fa_icon_shortcode' );

// Skillbars -------------------------------------------------------------------------- >
function calluna_skillbar_shortcode( $atts ) {

	// Parse and extract shortcode attributes
	extract( shortcode_atts( array(
		'title'        => '',
		'percentage'   => '100',
		'color'        => '#967a50',
		'class'        => '',
		'show_percent' => 'true'
	), $atts ) );

	$title = esc_attr($title);

	// Define output var
	$output = '';

	// Enque scripts
	wp_enqueue_script( 'calluna-skillbar' );

	// Inline js
	if ( function_exists( 'vc_is_inline' ) && vc_is_inline() ) {

		$output .= '<script>
			jQuery(function($){
				$(document).ready(function(){
					$(".calluna-skillbar").each(function(){
						$(this).find(".calluna-skillbar-bar").animate({ width: $(this).attr("data-percent") }, 800 );
					});
				});
			});</script>';

	}

	// Open skillbar main wrapper
	$output .= '<div class="calluna-skillbar calluna-clearfix '. $class .'" data-percent="'. $percentage .'%">';

		// Display title
		if ( $title ) {
			$output .= '<div class="calluna-skillbar-title" style="background: '. $color .';"><span>'. $title .'</span></div>';
		}

		// Display bar
		$output .= '<div class="calluna-skillbar-bar" style="background: '. $color .';"></div>';

		// Display percentage
		if ( $show_percent == 'true' ) {
			$output .= '<div class="calluna-skill-bar-percent">'.$percentage.'%</div>';
		}

	// Close main wrapper
	$output .= '</div>';

	// Return output
	return $output;
}

add_shortcode( 'cl_skillbar', 'calluna_skillbar_shortcode' );

// Testimonial -------------------------------------------------------------------------- >
function calluna_testimonial_shortcode( $atts, $content = null  ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'by'      => '',
		'position' => '',
		'image' => '',
		'class'   => '',
		'fade_in' => 'false',
	), $atts ) );

	// Fade In
	$fade_in_class = null;
	if ( $fade_in == 'true' ) {
		wp_enqueue_script( 'calluna-scroll-fade' );
		$fade_in_class = 'calluna-fadein';
	}

	// Output
	$output = '';
	$output .= '<div class="calluna-testimonial '. $class .' '. $fade_in_class .'">';
	if ( $image ) {
		$output .= '<div class="calluna-testimonial-author-image">' . wp_get_attachment_image( $image , 'thumbnail') . '</div>';
	}
		$output .= '<div class="calluna-testimonial-content calluna-clearfix">'. wpautop( do_shortcode( $content ) );
		if ( $by ) {
			$output .= '<div class="calluna-testimonial-author">';
			$output .= $by;
			if ( $position ) {
			$separator = ', ';
			$output .= '<span>' . $separator . $position . '</span>';
			}
			$output .= '</div>';
		}
	$output .= '</div></div>';

	// Return output
	return $output;

}
add_shortcode( 'cl_testimonial', 'calluna_testimonial_shortcode' );

// WPML -------------------------------------------------------------------------- >
function calluna_wpml_shortcode( $atts, $content = null ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'lang'	=> '',
	), $atts));

	// Translate
	if ( ! defined( 'ICL_LANGUAGE_CODE' ) ) {
		return esc_html__( 'WPML ICL_LANGUAGE_CODE constant does not exist. If you want to translate something please first install the WPML plugin.', 'calluna-shortcodes' );
	}

	// Return string
	if ( $lang == ICL_LANGUAGE_CODE ) {
		return do_shortcode($content);
	}

}
add_shortcode( 'cl_wpml', 'calluna_wpml_shortcode' );


// Pricing Table -------------------------------------------------------------------------- >

/*main*/
function calluna_pricing_table_shortcode( $atts, $content = null  ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'class'	=> ''
	), $atts ) );

	// Return output
	return '<div class="calluna-pricing-table '. $class .'">' . do_shortcode($content) . '</div><div class="calluna-clear-floats"></div>';

}
add_shortcode( 'cl_pricing_table', 'calluna_pricing_table_shortcode' );

/*section*/
function calluna_pricing_shortcode( $atts, $content = null  ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'featured'				=> 'no',
		'plan'					=> 'Basic',
		'cost'					=> '$20',
		'per'					=> 'month',
		'button_url'			=> '',
		'button_text'			=> '',
		'button_style'			=> 'style-1',
		'button_size'			=> '',
		'button_target'			=> 'self',
		'button_rel'			=> 'nofollow',
		'class'					=> '',
		'button_icon_left'		=> '',
		'button_icon_right'		=> '',
	), $atts ) );

	// Sanitize data
	$featured_pricing    = $featured == 'yes' ? ' featured' : null;
	$button_url          = esc_url( $button_url );
  	$button_text = esc_attr($button_text);

	// Output
	$output ='';
	$output .= '<div class="calluna-pricing calluna-'. $featured_pricing .' calluna-column-'. $class .'">';

		// Heading
		if ( $plan || $cost || $per ) {

			$output .= '<div class="calluna-pricing-header">';

			// Plan
			if ( $plan ) {
				$output .= '<h4>'. $plan .'</h4>';
			}

			// Cost
			if ( $cost ) {
				$output .= '<div class="calluna-pricing-cost">'. $cost .'</div>';
			}

			// Per
			if ( $per ) {
				$output .= '<div class="calluna-pricing-per">'. $per .'</div>';
			}

			$output .= '</div>';

		}

		// Features/Content
		if ( $content ) {
			$output .= '<div class="calluna-pricing-content">';
				$output .= $content;
			$output .= '</div>';
		}

		// Button
		if ( $button_url && $button_text ) {

		    $button_target     = ( strpos( $button_target, 'blank' !== false ) ) ? ' target="_blank"' : null;
			$button_rel        = 'nofollow' == $button_rel ? ' rel="nofollow"' : null;
			$button_icon_left  = calluna_shortcodes_font_icon_class( $button_icon_left );
			$button_icon_right = calluna_shortcodes_font_icon_class( $button_icon_right );

			// Load required scripts
			if ( $button_icon_left || $button_icon_right ) {
				wp_enqueue_style( 'font-awesome' );
			}

			$output .= '<div class="calluna-pricing-button"><a href="'. $button_url .'" class="calluna-button btn btn-primary '. $button_size .' ' . $button_style . '" '. $button_target . $button_rel .'><span class="calluna-button-inner">';
				if ( $button_icon_left ) {
					$output .= '<span class="calluna-button-icon-left '. $button_icon_left .'"></span>';
				}
				$output .= $button_text;
				if ( $button_icon_right ) {
					$output .= '<span class="calluna-button-icon-right '. $button_icon_right .'"></span>';
				}
			$output .= '</span></a></div>';

		}

	$output .= '</div>';

	// Return output
	return $output;

}
add_shortcode( 'cl_pricing', 'calluna_pricing_shortcode' );

// Recent Posts -------------------------------------------------------------------------- >
function calluna_posts_grid_shortcode($atts) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
			'unique_id'			=> '',
			'post_type'			=> 'post',
			'taxonomy'			=> '',
			'term_slug'			=> '',
			'count'				=> '12',
			'style'				=> 'default', // Maybe add more styles in the future?
			'fade_in'			=> 'false',
			'columns'			=> '3',
			'order'				=> 'DESC',
			'orderby'			=> 'date',
			'thumbnail_link'	=> 'post',
			'img_crop'			=> 'true',
			'img_width'			=> '9999',
			'img_height'		=> '9999',
			'title'				=> 'true',
			'meta'				=> 'true',
			'excerpt'			=> 'true',
			'excerpt_length'	=> '15',
			'read_more'			=> 'true',
			'read_more_text'	=> esc_html__( 'read more', 'calluna-shortcodes' ),
			'pagination'		=> 'false',
			'filter_content'	=> 'false',
			'taxonomy'			=> '',
			'terms'				=> '',
		), $atts));

	// Post Type doesn't exist, get me out of here!
	if ( ! post_type_exists( $post_type ) ) {
		return esc_html__( 'Sorry the post type you have selected does not exist', 'calluna-shortcodes' );
	}

	// FadeIn Class
	$fade_in_class = null;
	if ( $fade_in == 'true' ) {
		wp_enqueue_script( 'calluna-scroll-fade' );
		$fade_in_class = 'calluna-fadein';
	}

	// Start Tax Query
	$tax_query = '';
	if ( $taxonomy !== '' && $term_slug !== '' ) {
		if ( ! taxonomy_exists($taxonomy) ) return esc_html__( 'Your selected taxonomy does not exist', 'calluna-shortcodes' );
		if ( ! term_exists( $term_slug, $taxonomy ) ) return esc_html__( 'Your selected term does not exist', 'calluna-shortcodes' );
		$tax_query = array(
			array(
				'taxonomy'	=> $taxonomy,
				'field'		=> 'slug',
				'terms'		=> $term_slug,
			),
		);
	}

	// Pagination var
	if ( $pagination == 'true' ) {
		global $paged;
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	} else {
		$paged = null;
	}

	// The Query
	$calluna_post_grid_query = new WP_Query(
		array(
			'post_type'			=> $post_type,
			'posts_per_page'	=> $count,
			'order'				=> $order,
			'orderby'			=> $orderby,
			'tax_query'			=> $tax_query,
			'filter_content'	=> $filter_content,
			'paged'				=> $paged
		)
	);

	$output = '';

	//Output posts
	if ( $calluna_post_grid_query->posts ) :

		$unique_id = $unique_id ? ' id="'. $unique_id .'"' : null;

		// Main wrapper div
		$output .= '<div class="calluna-recent-posts"'. $unique_id .'><div class="calluna-grid calluna-clearfix">';

		// Loop through posts
		$count=0;
		foreach ( $calluna_post_grid_query->posts as $post ) :
		$count++;

			// Post VARS
			$post_id          = $post->ID;
			$featured_img_url = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
			$featured_img     = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
			$post_date		  = sprintf(wp_kses(__( '<span class="calluna-recent-posts-entry-posted-on">posted on %1$s</span>', 'calluna-shortcodes'), array( 'span' => array( 'class' => array() ) ) ),esc_html( get_the_date('Y/m/d') ) );
			$url              = get_permalink($post_id);
			$post_title       = get_the_title($post_id);
			$post_excerpt     = $post->post_excerpt;
			$custom_excerpt   = wp_trim_words( strip_shortcodes( $post->post_content ), $excerpt_length);

			// Load scripts
			if ( $thumbnail_link == 'lightbox' ) {
				wp_enqueue_script( 'magnific-popup' );
				wp_enqueue_script( 'calluna-lightbox' );
			}

			// Crop featured images if necessary
			if ( $img_crop == 'true' ) {
				$thumbnail_hard_crop = $img_height == '9999' ? false : true;
				$featured_img = calluna_shortcodes_img_resize( $featured_img_url, $img_width, $img_height, $thumbnail_hard_crop );
			}

			// Recent post article start
			$output .= '<article id="post-'. $post_id .'" class="calluna-recent-posts-entry calluna-col calluna-count-'. $count .' calluna-col-'. $columns .' fitvids '. $fade_in_class .' calluna-grid-'. $post_type .'">';

				// Media Wrap
				if ( has_post_thumbnail( $post_id ) ) {
					$output .= '<div class="calluna-recent-posts-entry-media">';

						if ( $thumbnail_link == 'none' ) {
							$output .= '<img class="img-responsive" src="'. $featured_img .'" alt="'. $post_title .'" />';
						} elseif ( $thumbnail_link == 'lightbox' ) {
							$output .= '<a href="'. esc_url($featured_img_url) .'" title="'. $post_title .'" class="calluna-recent-posts-entry-img calluna-shortcodes-lightbox">';
								$output .= '<img class="img-responsive" src="'. $featured_img .'" alt="'. $post_title .'" />';
							$output .= '</a><!-- .calluna-recent-posts-entry-img -->';
						} else {
							$output .= '<a href="'. esc_url($url) .'" title="'. $post_title .'" class="calluna-recent-posts-entry-img">';
								$output .= '<img class="img-responsive" src="'. $featured_img .'" alt="'. $post_title .'" />';
							$output .= '</a><!-- .calluna-recent-posts-entry-img -->';
						}

					$output .= '</div>';
				}

				// Open details div
				if ( $title == 'true' || $excerpt == 'true' ) {

					$output .= '<div class="calluna-recent-posts-entry-details">';
						//Post Date
						$output .='<p>' .  $post_date . '</p>';

						// Title
						if ( $title == 'true' ) {
							$output .= '<header class="calluna-recent-posts-entry-heading entry-header">';
								$output .= '<h3 class="calluna-recent-posts-entry-title"><a href="'. esc_url($url) .'" title="'. $post_title .'">'. $post_title .'</a></h3>';
							$output .= '</header><!-- .calluna-recent-posts-entry-heading -->';
						}

						// Excerpt
						if ( $excerpt == 'true' ) {
							$output .= '<div class="calluna-recent-posts-entry-excerpt"><p>';
								if ( $post_excerpt ) {
									$output .= $post_excerpt;
								} else {
									$output .= $custom_excerpt;
								}
							$output .= '</p>';
								if ( $read_more == 'true' && ( $post_excerpt || $custom_excerpt ) ) {
									$output .= '<span class="calluna-recent-posts-entry-readmore-wrap"><a href="'. esc_url($url) .'" title="'. $post_title .'" class="calluna-recent-posts-entry-readmore calluna-button btn btn-primary small style-1">'. $read_more_text .'</a></span>';
								}
							$output .= ' </div><!-- /calluna-recent-posts-entry-excerpt -->';
						}

					// Close details div
					$output .= '</div><!-- .calluna-recent-posts-entry-details -->';
				}

			// Close main wrap
			$output .= '</article>';

			// Reset counter
			if ( $count == $columns ) {
				$count = '0';
			}

		// End foreach loop
		endforeach;

		// Close main wrap
		$output .= '</div></div><div class="calluna-clear-floats"></div>';

		// Paginate Posts
		if ( $pagination == 'true' ) {

			$output .= '<nav class="navigation pagination">';

				$total = $calluna_post_grid_query->max_num_pages;

				$big = 999999999; // need an unlikely integer

				if ( $total > 1 )  {
				    if ( ! $current_page = get_query_var( 'paged' ) )
						 $current_page = 1;
					 if ( get_option( 'permalink_structure' ) ) {
						 $format = 'page/%#%/';
					 } else {
						 $format = '&paged=%#%';
					 }

					 $output .= paginate_links(array(
						'base'		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'	=> $format,
						'current'   => max( 1, $current_page ),
						'total'		=> $total,
						'mid_size'	=> 2,
						'type'		=> 'plain',
						'prev_text' => '<i class="icon-left"></i>',
		                'next_text' => '<i class="icon-right"></i>'
					 ));
				}

			$output .= '</nav>';
		}

	endif; // End has posts check

	// Set things back to normal
	$calluna_post_grid_query = null;
	wp_reset_postdata();

	// Return output
	return $output;

}
add_shortcode("cl_posts_grid", "calluna_posts_grid_shortcode");

// Teaser -------------------------------------------------------------------------- >
function calluna_teaser_shortcode( $atts, $content = null ) {

	// Parse and extract shortcode attributes
	extract( shortcode_atts( array(
		'color'        => '',
		'text_align'		   => 'left',
	), $atts ) );
	// Return output
	if (!empty($color)) {
		return '<p class="teaser" style="color:' . esc_attr($color) . '; text-align:' . esc_attr($text_align) . ';">' . do_shortcode( $content ) .'</p>';
	} else {
		return '<p class="teaser">' . do_shortcode( $content ) .'</p>';
	}

}
add_shortcode( 'cl_teaser', 'calluna_teaser_shortcode' );

// Icon Box -------------------------------------------------------------------------- >
function calluna_icon_box_shortcode( $atts, $content = NULL ) {
        extract( shortcode_atts( array(
            'unique_id'                 => '',
            'font_size'                 => '',
            'background'                => '',
            'font_color'                => '',
            'border_radius'             => '',
            'style'                     => 'one',
            'image'                     => '',
            'image_width'               => '',
            'icon'                      => '',
            'icon_color'                => '',
            'icon_width'                => '',
            'icon_height'               => '',
            'icon_alternative_classes'  => '',
            'icon_size'                 => '',
            'icon_background'           => '',
            'icon_border_radius'        => '',
            'icon_bottom_margin'        => '',
            'heading'                   => '',
            'heading_type'              => 'h2',
            'heading_color'             => '',
            'heading_size'              => '',
            'heading_weight'            => '',
            'heading_letter_spacing'    => '',
            'heading_transform'         => '',
            'heading_bottom_margin'     => '',
            'container_left_padding'    => '',
            'container_right_padding'   => '',
            'url'                       => '',
            'url_target'                => '',
            'url_rel'                   => '',
            'css_animation'             => '',
            'padding'                   => '',
            'margin_bottom'             => '',
            'el_class'                  => '',
            'alignment'                 => '',
            'background'                => '',
            'background_image'          => '',
            'background_image_style'    => 'strech',
            'border_color'              => '',
        ), $atts ) );

        // Turn output buffer on
        ob_start();

        // Set default vars
        $output = $container_background = '';

        // Seperate icons into a couple groups for styling/html purposes
        $standard_boxes = array( 'one', 'two', 'three', 'seven' );
        $clickable_boxes = array( 'four', 'five', 'six' );

        // Main Classes
        $add_classes = 'calluna-icon-box clr calluna-icon-box-'. $style;
        if ( $css_animation ) {
            $css_animation_class = 'wpb_animate_when_almost_visible wpb_'. $css_animation .'';
            $add_classes .= ' '. $css_animation_class;
        }
        if ( $url ) {
            $add_classes .= ' calluna-icon-box-with-link';
        }
        if ( $el_class ) {
            $add_classes .= ' '. $el_class;
        }
        if ( $alignment ) {
            $add_classes .= ' align-'. $alignment;
        } else {
            $add_classes .= ' align-center';
        }
        if ( $icon_background ) {
            $add_classes .= ' with-background';
        }

        // Container Style
        $inline_style = '';
        if ( $border_radius && in_array( $style, array( 'four', 'five', 'six' ) ) ) {
            $inline_style .= 'border-radius:'. $border_radius .';';
        }
        if ( $font_size ) {
            $inline_style .= 'font-size:'. intval( $font_size ).'px;';
        }
        if ( $font_color ) {
            $inline_style .= 'color:'. $font_color .';';
        }
        if ( 'four' == $style && $border_color ) {
            $inline_style .= 'border-color:'. $border_color .';';
        }
        if ( 'six' == $style && $icon_background && '' === $background ) {
            $inline_style .= 'background-color:'. $icon_background .';';
        }
        if ( $background && in_array( $style, $clickable_boxes ) ) {
            $inline_style .= 'background-color:'. $background .';';
        }
        if ( $background_image && in_array( $style, $clickable_boxes ) ) {
            $background_image = wp_get_attachment_url( $background_image );
            $inline_style .= 'background-image:url('. $background_image .');';
            $add_classes .= ' calluna-background-'. $background_image_style;
        }
        if ( 'six' == $style && $icon_color ) {
            $inline_style .= 'color:'. $icon_color .';';
        }
        if ( 'one' == $style && $container_left_padding ) {
            $inline_style .= 'padding-left:'. intval( $container_left_padding ) .'px;';
        }
        if ( 'seven' == $style && $container_right_padding ) {
            $inline_style .= 'padding-right:'. intval( $container_right_padding ) .'px;';
        }
        if ( $margin_bottom ) {
            $inline_style .= 'margin-bottom:'. intval( $margin_bottom ) .'px;';
        }
        if ( $padding && in_array( $style, array( 'four', 'five', 'six' ) ) ) {
            $inline_style .= 'padding:'. $padding .'';
        }
        if ( '' != $inline_style ) {
            $inline_style = ' style="' . $inline_style . '"';
        } ?>

        <div class="<?php echo $add_classes ?>"<?php echo $inline_style ?>>
            <?php
            /*** URL ***/
            if ( $url ) {
                // Link classes
                $add_classes = 'calluna-icon-box-'. $style .'-link';
                //Link Style
                $inline_style = '';
                if ( 'six' == $style ) {
                    $inline_style .= 'color:'. $icon_color .'';
                }
                if ( '' != $inline_style ) {
                    $inline_style = ' style="' . esc_attr( $inline_style ) . '"';
                }
                // Link target
                if ( 'local' == $url_target ) {
                    $url_target = '';
                    $add_classes .= ' local-scroll-link';
                } elseif ( '_blank' == $url_target ) {
                    $url_target = 'target="_blank"';
                } else {
                    $url_target = '';
                }
                if ( $url_rel ) {
                    $url_rel = ' rel="'. $url_rel .'"';
                } ?>
                <a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr($heading); ?>" class="<?php echo $add_classes ?>" <?php echo esc_attr($url_target); ?> <?php echo esc_attr($url_rel); ?><?php echo $inline_style ?>>
            <?php }
            /*** Image ***/
            if ( $image ){
                $image_url = wp_get_attachment_url( $image );
                if ( $image_width ) {
                    $image_width = 'style="width:'. intval( $image_width ) .'px;"';
                } ?>
                <img class="calluna-icon-box-<?php echo esc_attr($style); ?>-img-alt" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($heading); ?>" <?php echo $image_width; ?> />
            <?php
            }
            /*** Icon ***/
            elseif ( $icon ) {
                // Icon Style
                $inline_style = '';
                if( $icon_bottom_margin && in_array( $style, array( 'two', 'three', 'four', 'five', 'six' ) ) ) {
                    $inline_style .= 'margin-bottom:' . intval( $icon_bottom_margin ) .'px;';
                }
                if ( $icon_color ) {
                    $inline_style .= 'color:' . $icon_color . ';';
                }
                if ( $icon_width ) {
                    $inline_style .= 'width:'. intval( $icon_width ) .'px;';
                }
                if ( $icon_height ) {
                    $inline_style .= 'height:'.  intval( $icon_height ) .'px;line-height:'.  intval( $icon_height ) .'px;';
                }
                if ( $icon_size ) {
                    $inline_style .= 'font-size:' . intval( $icon_size ) . 'px;';
                }
                if ( $icon_border_radius ) {
                    $inline_style .= 'border-radius:' . $icon_border_radius . ';';
                }
                if ( $icon_background ) {
                    $inline_style .= 'background-color: ' . $icon_background . ';';
                }
                if ( '' != $inline_style ) {
                    $inline_style = ' style="' . $inline_style . '"';
                }
                // Icon Classes
                $add_classes = 'calluna-icon-box-'. $style .'-icon calluna-icon-box-icon';
                if ( $icon_background ) {
                    $add_classes .= ' calluna-icon-box-icon-with-bg';
                }
                if ( $icon_width || $icon_height ) {
                    $add_classes .= ' no-padding';
                } ?>
                <div class="<?php echo $add_classes ?>" <?php echo $inline_style ?>>
                    <?php
                    // Custom icon
                    if ( '' != $icon_alternative_classes ) { ?>
                        <span class="<?php echo $icon_alternative_classes ?>"></span>
                    <?php } else { ?>
                        <span class="fa fa-<?php echo esc_attr($icon); ?>"></span>
                    <?php } ?>
                </div>
            <?php }
            /** Heading ***/
            if ( $heading ) {
                // Heading Classes
                $add_classes ='';
                if ( $heading_weight ) {
                    $add_classes .= 'font-weight-'. $heading_weight . ' ';
                }
                if ( $heading_transform ) {
                    $add_classes .= 'text-transform-'. $heading_transform;
                }
                // Heading Style
                $inline_style = '';
                if ( '' != $heading_color ) {
                    $inline_style .= 'color:'. $heading_color .';';
                }
                if ( '' != $heading_size ) {
                    $heading_size = intval( $heading_size );
                    $inline_style .= 'font-size:'. $heading_size .'px;';
                }
                if ( '' != $heading_letter_spacing ) {
                    $inline_style .= 'letter-spacing:'. $heading_letter_spacing .';';
                }
                if ( $heading_bottom_margin ) {
                    $inline_style .= 'margin-bottom:'. intval( $heading_bottom_margin ) .'px;';
                }
                if ( '' != $inline_style ) {
                    $inline_style = ' style=' . $inline_style . '';
                } ?>
                <<?php echo esc_attr($heading_type); ?> class="calluna-icon-box-<?php echo esc_attr($style); ?>-heading <?php echo $add_classes ?>"<?php echo $inline_style ?>>
                    <?php echo esc_attr($heading); ?>
                </<?php echo esc_attr($heading_type); ?>>
            <?php
            }
            // Close link
            if ( $url && in_array( $style, $standard_boxes ) ) { ?>
                </a>
            <?php }
            // Display if content isn't empty
            if ( $content ) { ?>
                <div class="calluna-icon-box-<?php echo esc_attr($style); ?>-content clr">
                    <?php echo apply_filters( 'the_content', $content ); ?>
                </div>
            <?php }
            // Close link
            if ( $url && in_array( $style, $clickable_boxes ) ) { ?>
                </a>
            <?php } ?>
        </div>

        <?php
        // Return outbut buffer
        return ob_get_clean();
    }
add_shortcode( 'cl_icon_box', 'calluna_icon_box_shortcode' );

function calluna_content_image_shortcode( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'image' => '',
				'layout' => 'box-left'
			), $atts
		)
	);

	if( 'offscreen-left' == $layout ){

		$output = '
			<section class="image-edge">
			    <div class="col-md-6 col-sm-4 p0">
			    	'. wp_get_attachment_image( $image, 'full', 0, array('class' => 'mb-xs-24') ) .'
			    </div>
			    <div class="container">
			        <div class="col-md-5 col-md-offset-1 col-sm-7 col-sm-offset-1 v-align-transform right">
			            '. do_shortcode($content) .'
			        </div>
			    </div>
			</section>
		';

	} elseif( 'offscreen-right' == $layout ) {

		$output = '
			<section class="image-edge">
			    <div class="col-md-6 col-sm-4 p0 col-md-push-6 col-sm-push-8">
			        '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'mb-xs-24') ) .'
			    </div>
			    <div class="container">
			        <div class="col-md-5 col-md-pull-0 col-sm-7 col-sm-pull-4 v-align-transform">
			            '. do_shortcode($content) .'
			        </div>
			    </div>
			</section>
		';

	} elseif( 'shadow-left' == $layout ) {

		$output = '
			<section>
			    <div class="container">
			        <div class="row v-align-children">
			            <div class="col-md-7 col-sm-6 text-center mb-xs-24">
			                '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'cast-shadow') ) .'
			            </div>
			            <div class="col-md-4 col-md-offset-1 col-sm-5 col-sm-offset-1">
			                '. do_shortcode($content) .'
			            </div>
			        </div>
			    </div>
			</section>
		';

	} elseif( 'shadow-right' == $layout ) {

		$output = '
			<section>
			    <div class="container">
			        <div class="row v-align-children">
			            <div class="col-md-4 col-sm-5 mb-xs-24">
			                '. do_shortcode($content) .'
			            </div>
			            <div class="col-md-7 col-md-offset-1 col-sm-6 col-sm-offset-1 text-center">
			                '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'cast-shadow') ) .'
			            </div>
			        </div>
			    </div>
			</section>
		';

	} elseif( 'box-left' == $layout ) {

		$output = '
			<section class="image-square left">
			    <div class="col-md-6 image">
			        <div class="background-image-holder">
			            '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .'
			        </div>
			    </div>
			    <div class="col-md-6 col-md-offset-1 content">
			        '. do_shortcode($content) .'
			    </div>
			</section>
		';

	} elseif( 'box-right' == $layout ) {

		$output = '
			<section class="image-square right">
			    <div class="col-md-6 image">
			        <div class="background-image-holder">
			            '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .'
			        </div>
			    </div>
			    <div class="col-md-6 content">
			        '. do_shortcode($content) .'
			    </div>
			</section>
		';

	}

	return $output;
}
add_shortcode( 'cl_content_image', 'calluna_content_image_shortcode' );