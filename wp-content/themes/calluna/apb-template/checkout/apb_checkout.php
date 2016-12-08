<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The template for displaying check out cf7
 *
 * Override this template by copying it to your theme
 *
 * @author  AweTeam
 * @package AweBooking/Templates
 * @version 1.0
 */

?>
<section class="section-checkout">
	<?php do_action('layout_loading'); ?>
	<div class="container-fluid">
		<div class="checkout">
			<div class="row">

				<div class="col-md-10">
					<h2><?php esc_html_e('Booking Checkout'."calluna-td") ?></h2>
					<?php echo do_shortcode(apply_filters("the_content",stripslashes(get_option('shortcode_form')))) ?>
				</div>
			</div>
		</div>
	</div>
</section>