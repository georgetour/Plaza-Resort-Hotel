<?php
/**
 *  Tempalte setting form check available
 *
 * @version   1.0
 * @package   AweBooking/admin/
 * @author    AweTeam
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="form-elements">
	<p><?php esc_html_e( 'Checkout presentation style', 'awebooking' ); ?></p>
	<div class="form-radios">
		<div class="form-elements">
			<input id="rooms_checkout_style_1" type="radio" <?php checked( 1, get_option( 'rooms_checkout_style' ) ); ?> value="1" name="rooms_checkout_style">
			<label for="rooms_checkout_style_1"><?php esc_html_e( 'WooCommerce checkout', 'awebooking' ) ?> </label><br/>
			<span class="description"><?php esc_html_e( 'Checkout and payment with plugin woocommerce. With checkout woocommerce function, you have to install page checkout of woocommerce', 'awebooking' ); ?></span>
		</div>
		<div class="form-elements">
			<input id="rooms_checkout_style_2" type="radio" <?php checked( 2, get_option( 'rooms_checkout_style' ) ); ?> value="2" name="rooms_checkout_style">
			<label for="rooms_checkout_style_2"><?php esc_html_e( 'Contact form 7 checkout', 'awebooking' ); ?> </label><br/>
			<span class="description"><?php esc_html_e( 'Use CF7 to finish the checkout step and recevie your guest information. NOTE: Required [email* apb-email] and [text* apb-name] in form, then copy CF7 shortcode and insert into Awe Checkout Page.', 'awebooking' ); ?></span>
		</div>

	</div>
</div>
