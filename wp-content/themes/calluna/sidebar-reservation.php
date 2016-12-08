<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package calluna
 */
?>
<?php
  $type = 'room';
    if ( post_type_exists( 'apb_room_type' ) ) {
        $type = 'apb_room_type';
    }
  $args= array(
  	    'numberposts' => 1,
		'post_type' => $type,
		'order'		 => 'ASC',
		'orderby'   => 'meta_value_number',
		'meta_key'  => 'base_price',
        'suppress_filters' => false
	);
	$rooms = get_posts($args);
	$currency = get_theme_mod( 'currency', '$' );
	$currency_pos = get_theme_mod( 'currency_pos', 'before' ); 
    $prefix_price = get_theme_mod('room_price_text', 'starting at');
    $reservation_header = get_theme_mod( 'reservation_header', '' );
	$reservation_text = get_theme_mod( 'reservation_text', '' );
	$reservation_hint = get_theme_mod( 'reservation_hint', '' );
    // WPML translations
    $prefix_price = calluna_translate_theme_mod( 'room_price_text', $prefix_price );
    $reservation_header = calluna_translate_theme_mod( 'reservation_header', $reservation_header );
    $reservation_text = calluna_translate_theme_mod( 'reservation_text', $reservation_text );
    $reservation_hint = calluna_translate_theme_mod( 'reservation_hint', $reservation_hint );
?>
<aside id="widget-area" class="widget-area selected-room">
  <div id="room_params">
  	<?php foreach ($rooms as $room){ ?>
    	<?php $price = get_post_meta( $room->ID, 'base_price', true );
        if ( has_excerpt( $room->ID ) ) {
            $custom_excerpt = $room->post_excerpt;
        } elseif(get_post_meta( $room->ID, 'room_desc', true ) != '') {
            $custom_excerpt = get_post_meta( $room->ID, 'room_desc', true );
        }
        else {
            $custom_excerpt = wp_trim_words( strip_shortcodes( $room->post_content ), 30);
        }
        ?>
    	<?php echo get_the_post_thumbnail( $room->ID, 'large', array( 'class' => 'img-responsive' ) ); ?>
    	<h2 class="title"><?php echo esc_attr($room->post_title) ?></h2>
        <div class="excerpt"><p><?php echo wp_kses_data($custom_excerpt) ?></p></div>
        <div class="offer_price">
        	<span><?php echo esc_attr($prefix_price) ?></span>
            	<?php
            	if (get_theme_mod('currency_pos', 'before') == 'before') {
										echo esc_attr($currency) . esc_attr($price);
									}
									else {
										echo esc_attr($price) . esc_attr($currency);	
									} ?>
        </div>
	<?php }?>
  </div>
  <div class="reservation_header">
  	<?php if ($reservation_header) { ?><?php echo esc_attr($reservation_header) ?><?php } ?>
  </div>
  <div class="reservation_text">
  	<?php if ($reservation_text) { ?><?php echo esc_attr($reservation_text) ?><?php } ?>
  </div>
  <div class="reservation_hint">
  	<?php if ($reservation_hint) { ?><?php echo esc_attr($reservation_hint) ?><?php } ?>
  </div>
  
</aside><!-- .widget-area -->