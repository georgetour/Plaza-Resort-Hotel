<?php
/**
 * Email subtotal
 *
 * @package Awebooking
 */

?>

<div class="apb-room-seleted_total-room" style="color:#333333;font-size:14px;font-weight:bold;border-top: 1px solid #e4e4e4;padding-top: 15px;">
	<?php esc_html_e( 'Subtotal', 'awebooking' ); ?>
	<span class="apb-amount" style="color:#46598b;float:right;font-weight:bold;"><?php echo wp_kses_post( AWE_function::apb_price( $subtotal ) ); ?></span>
</div>
