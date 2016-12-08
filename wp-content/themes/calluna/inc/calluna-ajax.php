<?php
//Add ajax callback to show the selected room on pages with the reservation form
function calluna_implement_ajax() {
if(isset($_POST['room_Id']))
            {
             $room = get_post($_POST['room_Id']);
			 $price = get_post_meta( $room->ID, 'base_price', true );
			 $currency = get_theme_mod('currency', '$');
			 $prefix_price = get_theme_mod('room_price_text', 'starting at');
                // WPML translations
				$prefix_price = calluna_translate_theme_mod( 'room_price_text', $prefix_price );
                if ( has_excerpt( $room->ID ) ) {
                    $custom_excerpt = $room->post_excerpt;
                } elseif(get_post_meta( $room->ID, 'room_desc', true ) != '') {
                    $custom_excerpt = get_post_meta( $room->ID, 'room_desc', true );
                }
                else {
                    $custom_excerpt = wp_trim_words( strip_shortcodes( $room->post_content ), 30);
                }
			 $output = '<div>';
			 $output .= get_the_post_thumbnail( $room->ID, 'large', array( 'class' => 'img-responsive' ) );
			 $output .= '<h2 class="title">' . apply_filters( 'the_title', $room->post_title ) . '</h2>';
			 $output .= '<div class="excerpt">' . apply_filters( 'the_excerpt', $custom_excerpt ) . '</div>';
			 $output .= '<div class="offer_price"><span>' . esc_attr($prefix_price) . '</span>';
			 if (get_theme_mod('currency_pos', 'before') == 'before') {
										$output .= esc_attr($currency) . esc_attr($price);	
									}
									else {
										$output .= esc_attr($price) . esc_attr($currency);	
									}
			  $output .= '</div>';
            echo $output;
            die();
            } // end if
}
add_action('wp_ajax_my_special_action', 'calluna_implement_ajax');
add_action('wp_ajax_nopriv_my_special_action', 'calluna_implement_ajax');//for users that are not logged in.

?>