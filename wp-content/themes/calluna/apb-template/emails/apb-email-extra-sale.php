<?php
/**
 * Email extra sale
 *
 * @package Awebooking
 */

?>

<?php
$extra_sale = get_post_meta( $room_type_id, 'extra_sale', true );
if ( ! empty( $extra_sale ) ) {
	$data_extra_sale = AWE_function::apb_get_extra_sale( $extra_sale, count( $range_date ), $item['from'] );
	?>
	<h6 style="color: #333333; display: inline-block; font-size: 14px; font-weight: bold; line-height: 1.428em; margin: 0 10px 0 0; text-transform: uppercase;"><?php esc_html_e( 'Sale', 'awebooking' ); ?></h6>

	<ul style="list-style: outside none none; margin-bottom: 0; margin-top: 5px; padding-bottom: 2px; padding-left: 0;">
		<li style="color: #333333; font-size: 12px; overflow: hidden;">
			<?php
			if ( ! empty( $data_extra_sale ) ) {
				?>
				<span class="apb-room-seleted_date">
					<?php esc_html_e( 'Sale', 'awebooking' ); ?>
				</span>
				<span style="float: right; font-weight: bold; text-transform: uppercase;" class="apb-amount">
					<?php
					if ( 'decrease' == $data_extra_sale['sale_type'] ) {
						echo '-' . esc_html( AWE_function::get_symbol_of_sale( $data_extra_sale['sale_type'] ) . $data_extra_sale['amount'] );
					} else {
						echo esc_html( AWE_function::get_symbol_of_sale( $data_extra_sale['sale_type'] ) . AWE_function::apb_price( $data_extra_sale['amount'] ) );
					}
					?>
				</span>
				<?php
			}
			?>
		</li>
	</ul>
<?php } ?>
