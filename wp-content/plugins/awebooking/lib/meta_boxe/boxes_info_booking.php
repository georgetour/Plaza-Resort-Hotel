<?php
/**
 * Handle booking.
 *
 * @package Function
 */

/**
 * Description of Boxes_info_booking
 *
 * @author Letrungha
 */
class Boxes_info_booking {

	/**
	 * Display meta box for order.
	 *
	 * @param  WP_Post $post Post object.
	 * @return void
	 */
	public static function output( $post ) {
		global $wpdb;
		$currency       = AWE_function::get_option( 'woocommerce_currency' ) ? AWE_function::get_option( 'woocommerce_currency' ) : '$';
		$from           = get_post_meta( $post->ID, 'from', true );
		$to             = get_post_meta( $post->ID, 'to', true );
		$custommer      = get_post_meta( $post->ID, 'custommer', true );
		$order_data     = get_post_meta( $post->ID, 'apb_data_order', true );

		$order_status   = get_post_status( $post->ID );

		switch ( $order_status ) {
			case 'wc-pending':
			case 'wc-processing':
			case 'wc-on-hold':
				$booking_status = 'apb-pending';
				break;

			case 'wc-completed':
				$booking_status = 'apb-completed';
				break;

			case 'wc-cancelled':
			case 'wc-refunded':
			case 'wc-failed':
				$booking_status = 'apb-cancelled';
				break;

			default:
				$booking_status = $order_status;
		}

		$room_adult = array();
		$room_child = array();
		if ( ! empty( $order_data ) ) {
			foreach ( $order_data as $_num_people ) {
				$room_adult[] = $_num_people['room_adult'];
				$room_child[] = $_num_people['room_child'];
			}
		}

		$total_item_price = 0;
		$total_ex_tax = get_post_meta( $post->ID, 'total_ex_tax', true );
		$order_total_price = get_post_meta( $post->ID, '_order_total', true );
		$tax_amount = get_post_meta( $post->ID, 'tax_amount', true );
		$tax_type = get_post_meta( $post->ID, 'tax_type', true );
		$total_night = AWE_function::get_number_of_nights( $from, $to );
		?>

		<div class="rooms-management-form rooms-unit-type-edit-form">
			<div class="form-item form-type-textfield form-item-label">
				<fieldset class="rooms-unit-type-defaults form-wrapper">
					<div class="fieldset-wrapper">
						<div class="form-elements">
							<label for="apb-select-customer"><?php esc_html_e( 'Customer', 'awebooking' ); ?> <span class="form-required">*</span></label>
							<select class="form-select awe-select" name="custommer" id="apb-select-customer">
								<option value="0"><?php esc_html_e( 'Guest', 'awebooking' ); ?></option>

								<?php foreach ( get_users() as $user ) : ?>
									<option <?php selected( $custommer, $user->data->ID ); ?> value="<?php echo absint( $user->data->ID ); ?>"><?php echo esc_html( $user->data->display_name . ' - ' . $user->data->user_email ); ?></option>
								<?php endforeach; ?>
							</select>
							<?php AWE_function::awe_help( 'Customer who books this order.' ) ?>
						</div>

						<div class="form-elements" id="apb-customer-name-email" <?php echo ( 'auto-draft' != $post->post_status ) ? 'style="display: none"' : ''; ?>>
							<p>
								<label for="apb-customer-name"><?php esc_html_e( 'Customer name', 'awebooking' ); ?></label>
								<input type="text" name="apb_customer_name" id="apb-customer-name">
							</p>

							<p>
								<label for="apb-customer-email"><?php esc_html_e( 'Customer email', 'awebooking' ); ?></label>
								<input type="text" name="apb_customer_email" id="apb-customer-email">
							</p>
						</div>
					</div>
				</fieldset>

				<fieldset class="rooms-unit-type-defaults form-wrapper">
					<div class="fieldset-wrapper">
						<div class="form-item form-type-textfield form-item-data-base-price">
							<div class="form-elements">
								<label><?php esc_html_e( 'Adult', 'awebooking' ); ?> </label>
								<?php
								/**
								 * General selected.
								 */
								AWE_function::apb_get_option_to_selected( array(
									'name'      => 'room_adult',
									'count_num' => 10,
									'data'      => array( 'class' => 'form-select awe-select' ),
									'select'    => ! empty( $room_adult[0] ) ? $room_adult[0] : '',
								) );
								AWE_function::awe_help( 'Number of adults.' );
								?>
							</div>
						</div>

						<div class="form-item form-type-textfield form-item-data-base-price">
							<div class="form-elements">
								<label><?php esc_html_e( 'Children', 'awebooking' ); ?></label>
								<?php
								/**
								 * General selected.
								 */
								AWE_function::apb_get_option_to_selected( array(
									'name'      => 'room_child',
									'start_num' => 0,
									'count_num' => 10,
									'data'      => array( 'class' => 'form-select awe-select' ),
									'select'    => ! empty( $room_child[0] ) ? $room_child[0] : '',
								) );
								?>
								<?php AWE_function::awe_help( 'Number of children.' ); ?>
							</div>
						</div>

						<div class="form-item form-type-textfield form-item-data-base-price">
							<div class="form-elements">
								<label><?php esc_html_e( 'Order status', 'awebooking' ); ?></label>
								<select class="form-select ajax-processed awe-select" name="apb_order_status">
									<?php
									$apb_get_order_statuses = AWE_function::apb_get_order_statuses();
									foreach ( $apb_get_order_statuses as $key_status => $val_status ) :
									?>
										<option <?php selected( $booking_status, $key_status ); ?> value="<?php echo esc_attr( $key_status ); ?>"><?php echo esc_html( $val_status ) ?></option>
									<?php endforeach; ?>
								</select>
								<?php AWE_function::awe_help( 'The status of order booking.' ); ?>
							</div>
						</div>
					</div>
				</fieldset>

				<fieldset class="rooms-unit-type-defaults form-wrapper">
					<div class="fieldset-wrapper">
						<div class="form-item form-type-textfield form-item-data-base-price">
							<div class="form-elements">
								<label><?php esc_html_e( 'Arrival Date', 'awebooking' ); ?> <span class="form-required">*</span></label>
								<input name="from" placeholder="<?php esc_html_e( 'Arrival Date', 'awebooking' ); ?>" name="" type="text" <?php if ( ! empty( $order_data ) ) { echo 'readonly'; } ?> class="form-text <?php if ( empty( $order_data ) ) { echo 'date-start-js'; } ?>" value="<?php echo ! empty( $from ) ? esc_attr( date( AWE_function::get_current_date_format(), strtotime( $from ) ) ) : ''; ?>">
							</div>
						</div>
						<div class="form-item form-type-textfield form-item-data-base-price">
							<div class="form-elements">
								<label><?php esc_html_e( 'Departure Date', 'awebooking' ); ?> <span class="form-required">*</span></label>
								<input id="awe_datepicker_end" name="to" placeholder="<?php esc_html_e( 'Departure Date', 'awebooking' ); ?>" type="text" <?php if ( ! empty( $order_data ) ) { echo 'readonly'; } ?> class="form-text <?php if ( empty( $order_data ) ) { echo 'date-end-js'; } ?>" value="<?php echo ! empty( $to ) ? esc_attr( date( AWE_function::get_current_date_format(), strtotime( $to ) ) ) : ''; ?>">
							</div>
						</div>

						<?php if ( empty( $order_data ) ) : ?>
							<div class="form-item form-type-textfield form-item-data-base-price">
								<div class="form-elements">
									<label>&nbsp;</label>
									<button type="button" class="button check-avb-js"><?php esc_html_e( 'Check availability', 'awebooking' ); ?>&nbsp;<span class="spinner is-active" style="display: none;"></span></button>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</fieldset>

				<div class="awe-plugin">
					<fieldset class="rooms-unit-type-defaults form-wrapper">
						<div class="fieldset-wrapper">
							 <div class="form-item">
								<div class="form-elements">
									<div class="<?php echo empty( $order_data ) ? 'apb-list-room-js' : ''; ?>">
										<?php if ( ! empty( $order_data ) ) : ?>
											<table class="sticky-header">
												<thead>
													<tr>
														<th><input id="apb-check" type="checkbox"></th>

														<th><?php esc_html_e( 'Image', 'awebooking' ); ?></th>

														<th><?php esc_html_e( 'Room', 'awebooking' ); ?></th>

														<th><?php esc_html_e( 'Price/Night', 'awebooking' ); ?></th>

														<th><?php esc_html_e( 'Extra price', 'awebooking' ); ?></th>

														<th><?php esc_html_e( 'Discount', 'awebooking' ); ?></th>

														<th><?php esc_html_e( 'Package', 'awebooking' ); ?></th>

														<th><?php esc_html_e( 'Total price', 'awebooking' ); ?></th>
													</tr>
												</thead>
												<tbody>
													<?php
													if ( ! empty( $order_data ) ) {
														foreach ( $order_data as $room_info ) {
															$total_item_price += $room_info['total_price'];

															$order_item_id = $room_info['id'];
															$room_id = absint( $room_info['order_room_id'] );
															$room_type_id = wp_get_post_parent_id( $room_id );
															$get_room_current = get_post( $room_id );

															$image_thumb  = get_the_post_thumbnail( $room_type_id, array( 50, 50 ) );
															$room_price   = get_post_meta( $room_type_id, 'base_price', true );
															$extra_sale   = get_post_meta( $room_type_id, 'extra_sale', true );

															$adult = $room_info['room_adult'];
															$child = $room_info['room_child'];
															$base_price_for = get_post_meta( $room_type_id, 'base_price_for', true );
															$extra_guess_data = AWE_function::get_extra_guest_data( $base_price_for, $adult, $child );
															$extra_price_data = AWE_function::get_extra_price_data( $room_type_id, $adult, $child );

															if ( ! empty( $extra_sale ) ) {
																$sale_icon = ' <img class="apb-sale-icon" src="' . esc_url( AWE_BK_BASE_URL_PLUGIN . '/assets/backend/images/sale-icon.png' ) . '">';
															} else {
																$sale_icon = '';
															}

															?>
															<tr class="even item-order-<?php echo esc_attr( $order_item_id ) ?>">
																<!-- checkbox -->
																<td>
																	<input value="<?php echo esc_attr( $order_item_id ) ?>" class="apb-check" data-id="<?php echo absint( $order_item_id ) ?>" type="checkbox">
																</td>
																<!-- End checkbox -->

																<!-- Image -->
																<td class="img-desc-room-book">
																	<span>
																		<?php echo wp_kses_post( $sale_icon ); ?>
																		<?php echo wp_kses_post( $image_thumb ) ?>
																	</span>
																</td>
																<!-- End image -->

																<!-- Room name -->
																<td>
																	<a href="<?php echo esc_url( get_permalink( $room_type_id ) ); ?>"><?php echo esc_html( $get_room_current->post_title ); ?></a>
																</td>
																<!-- End room name -->

																<!-- Price/night -->
																<td><?php echo AWE_function::apb_price( $room_price ) ?>×<?php echo count( AWE_function::range_date( $from, $to ) ) - 1; ?></td>
																<!-- Price/night -->

																<!-- Extra price -->
																<td>
																	<?php
																	if ( ! empty( $extra_price_data['adult'] ) ) {
																		printf( esc_html__( '%s Adult', 'awebooking' ), absint( $extra_guess_data['adult'] ) );
																		echo ' + ';
																		printf( esc_html__( '%s/night', 'awebooking' ), wp_kses_post( AWE_function::apb_price( $extra_price_data['adult'] ) ) );
																		echo '<br>';
																	}

																	if ( ! empty( $extra_price_data['child'] ) ) {
																		printf( esc_html__( '%s Child', 'awebooking' ), absint( $extra_guess_data['child'] ) );
																		echo ' + ';
																		printf( esc_html__( '%s/night', 'awebooking' ), wp_kses_post( AWE_function::apb_price( $extra_price_data['child'] ) ) );
																	}
																	?>
																</td>
																<!-- End extra price -->

																<td>
																	<?php
																	if ( ! empty( $extra_sale ) ) {
																		$data_extra_sale = AWE_function::apb_get_extra_sale( $extra_sale, $total_night + 1, $from );
																		if ( ! empty( $data_extra_sale ) ) {
																			if ( 'Before-Day' == $data_extra_sale['type_duration'] ) {
																				echo '<span class="list-price-item">';
																				printf( __( 'Booking %s upwards: ', 'awebooking' ), str_replace( '-', '&nbsp;', $data_extra_sale['type_duration'] ) . $data_extra_sale['total'] );
																			} else {
																				echo '<span class="list-price-item">';
																				printf( __( 'From %s upwards: ', 'awebooking' ), $data_extra_sale['total'] . ' ' . $data_extra_sale['type_duration'] );
																			}
																			switch ( $data_extra_sale['sale_type'] ) {
																				case 'sub':
																					echo '-<span>' . wp_kses_post( AWE_function::apb_price( $data_extra_sale['amount'] ) ) . ' </span>';
																					break;
																				case 'decrease':
																					echo '-<span>' . (float) $data_extra_sale['amount'] . '%</span>';
																					break;
																			}
																			echo '</span>';
																		}
																	}
																	?>
																</td>

																<!-- Package -->
																<td>
																	<?php if ( ! empty( $room_info['package_data'] ) ) { ?>
																		<ul>
																			<?php
																			foreach ( maybe_unserialize( $room_info['package_data'] ) as $info_package ) { ?>
																				<li>-
																					<?php
																					$get_room_option = AWE_function::get_room_option( $room_type_id, 'apb_room_type' );
																					foreach ( $get_room_option as $item_package ) {
																						if ( $item_package->id == $info_package['package_id'] ) {
																							echo $item_package->option_name . ' x ' . $info_package['total'] . ' / ' . AWE_function::apb_price( $item_package->option_value );
																						}
																					}
																					?>
																				</li>
																				<?php
																			}
																			?>
																		</ul>
																	<?php } ?>
																</td>
																<!-- End pakage -->

																<!-- Total price -->
																<td><?php echo wp_kses_post( AWE_function::apb_price( $room_info['total_price'] ) );  ?></td>
																<!-- End total price -->
															</tr>

															<?php
														}
													}
													?>
												</tbody>
											</table>
										<?php endif; ?>
									</div>

									<div class="booking-total">
										<table>
											<tr>
												<th><?php esc_html_e( 'Subtotal:', 'awebooking' ); ?></th>
												<td><?php echo $total_ex_tax ? wp_kses_post( AWE_function::apb_price( $total_ex_tax ) ) : wp_kses_post( AWE_function::apb_price( $total_item_price ) ); ?></td>
											</tr>

											<?php if ( $tax_amount ) : ?>
												<tr>
													<th><?php esc_html_e( 'Tax:', 'awebooking' ); ?></th>
													<td><?php echo wp_kses_post( AWE_function::get_displayed_tax( $total_item_price, $tax_amount, $tax_type ) ); ?></td>
												</tr>
											<?php endif; ?>

											<tr>
												<th><?php esc_html_e( 'Total:', 'awebooking' ); ?></th>
												<td><?php echo wp_kses_post( AWE_function::apb_price( $order_total_price ) ); ?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>

							<?php
							if ( empty( $order_data ) ) {
								echo '<div class="list-option-room-js"></div><br/>
									<input type="submit" style="display:none" value="' . esc_attr__( 'Save Bookings', 'awebooking' ) . '" name="save" class="button save_order button-primary">';
							} else {
								?>
								<div class="fieldset-wrapper apb-add-new-item">
									<h2><?php esc_html_e( 'New Room Item', 'awebooking' ); ?></h2>
									<div class="apb-list-room-js"> </div>
									<div class="list-option-room-js"></div>
									<br/>
									<input type="submit" value="<?php esc_attr_e( 'Save Bookings', 'awebooking' ); ?>" name="save" class="button save_order button-primary">
								</div>
							<?php } ?>
						</div>
					</fieldset>

				</div>
			</div>
		</div>

		<input type="hidden" name="_order_total" value="<?php echo esc_attr( $order_total_price ); ?>">
		<input type="hidden" name="order_status" value="apb-pending">

		<?php if ( ! empty( $order_data ) ) : ?>
			<div class="apb-order-data-row apb-order-bulk-actions">
				<p class="bulk-actions">
					<select name="apb-booking-bulk-actions">
						<option><?php esc_html_e( 'Actions', 'awebooking' ); ?></option>
						<optgroup label='Edit'>
							<option value="remove"><?php esc_html_e( 'Remove Item', 'awebooking' ); ?></option>
						</optgroup>
						<optgroup label='Add'>
							<option value="newitem"><?php esc_html_e( 'Add New Item', 'awebooking' ); ?></option>
						</optgroup>
					</select>
					<button data-id="<?php echo esc_attr( $post->ID ) ?>" class="button do_bulk_action apb-reload-action" type="button">
						<span><?php esc_html_e( 'Apply', 'awebooking' ); ?></span>&nbsp;
						<span class="spinner is-active apb-get_action" style="display: none;"></span>
					</button>

					<button title="Apply" class="button apb-action-cancel" type="button"><span><?php esc_html_e( 'Cancel', 'awebooking' ); ?></span></button>
				</p>
			</div>
			<?php
		endif;
	}


	/**
	 * Add new order.
	 *
	 * @param  int   $post_id Post ID.
	 * @param  array $args    Args.
	 * @return int            Order ID.
	 * @since 1.0
	 */
	static public function apb_add_order( $post_id, $args ) {
		$from = $args['from'];
		$to = $args['to'];
		global $wpdb;

		$_apb_order_id = wp_insert_post( array(
			'post_type'      => 'apb_order',
			'post_status'    => 'apb-pending',
			'ping_status'    => 1,
			'post_author'    => 1,
			'post_password'  => uniqid( 'order_' ),
			'post_title'     => '#' . $post_id,
		) );

		if ( isset( $args['custommer'] ) ) {
			update_post_meta( $_apb_order_id, 'custommer', $args['customer_id'] );
		}
		if ( isset( $args['room_adult'] ) ) {
			update_post_meta( $_apb_order_id, 'room_adult', wp_kses( $args['room_adult'], array() ) );
		}
		if ( isset( $args['room_child'] ) ) {
			update_post_meta( $_apb_order_id, 'room_child', wp_kses( $args['room_child'], array() ) );
		}
		if ( isset( $args['from'] ) ) {
			update_post_meta( $_apb_order_id, 'from', $from );
		}
		if ( isset( $args['to'] ) ) {
			update_post_meta( $_apb_order_id, 'to', $to );
		}
		update_post_meta( $_apb_order_id, 'order_room_id', $args['room_id'], '' );
		update_post_meta( $_apb_order_id, 'posttype_shop_order_id', $post_id, '' );
		update_post_meta( $_apb_order_id, 'package_data', $args['package_data'], '' );

		AWE_function::update_available( $from, $to, $args['room_id'], $args['status'] );

		if ( function_exists( 'wc_add_order_item' ) ) {
			$order_item_id = wc_add_order_item( $post_id, array( 'order_item_name' => get_the_title( $args['room_id'] ) ) );

			$wpdb->insert(
				$wpdb->prefix . 'woocommerce_order_itemmeta',
				array(
					'order_item_id'	=> $order_item_id,
					'meta_key'		=> '_qty',
					'meta_value'	=> 1,
				),
				array(
					'%d', '%s', '%s',
				)
			);

			$wpdb->insert(
				$wpdb->prefix . 'woocommerce_order_itemmeta',
				array(
					'order_item_id'	=> $order_item_id,
					'meta_key'		=> '_tax_class',
					'meta_value'	=> '',
				),
				array(
					'%d', '%s', '%s',
				)
			);

			$wpdb->insert(
				$wpdb->prefix . 'woocommerce_order_itemmeta',
				array(
					'order_item_id'	=> $order_item_id,
					'meta_key'		=> '_product_id',
					'meta_value'	=> $args['room_id'],
				),
				array(
					'%d', '%s', '%s',
				)
			);

			$wpdb->insert(
				$wpdb->prefix . 'woocommerce_order_itemmeta',
				array(
					'order_item_id'	=> $order_item_id,
					'meta_key'		=> '_variation_id',
					'meta_value'	=> 0,
				),
				array(
					'%d', '%s', '%s',
				)
			);

			$wpdb->insert(
				$wpdb->prefix . 'woocommerce_order_itemmeta',
				array(
					'order_item_id'	=> $order_item_id,
					'meta_key'		=> '_line_subtotal',
					'meta_value'	=> $args['price'],
				),
				array(
					'%d', '%s', '%s',
				)
			);

			$wpdb->insert(
				$wpdb->prefix . 'woocommerce_order_itemmeta',
				array(
					'order_item_id'	=> $order_item_id,
					'meta_key'		=> '_line_total',
					'meta_value'	=> $args['price'],
				),
				array(
					'%d', '%s', '%s',
				)
			);

			$wpdb->insert(
				$wpdb->prefix . 'woocommerce_order_itemmeta',
				array(
					'order_item_id'	=> $order_item_id,
					'meta_key'		=> '_line_subtotal_tax',
					'meta_value'	=> 0,
				),
				array(
					'%d', '%s', '%s',
				)
			);

			$wpdb->insert(
				$wpdb->prefix . 'woocommerce_order_itemmeta',
				array(
					'order_item_id'	=> $order_item_id,
					'meta_key'		=> '_line_tax',
					'meta_value'	=> 0,
				),
				array(
					'%d', '%s', '%s',
				)
			);

			$wpdb->insert(
				$wpdb->prefix . 'woocommerce_order_itemmeta',
				array(
					'order_item_id'	=> $order_item_id,
					'meta_key'		=> '_line_tax_data',
					'meta_value'	=> array(
						'total'		=> array(),
						'subtotal'	=> array(),
					),
				),
				array(
					'%d', '%s', '%s',
				)
			);
		}

		return $_apb_order_id;
	}


	/**
	 * Save post data.
	 *
	 * @param  int $post_id Post ID.
	 * @return void
	 * @since 1.0
	 */
	static public function save( $post_id ) {
		global $wpdb;
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['post_type'] ) && 'shop_order' == $_POST['post_type'] && ( isset( $_POST['save'] ) || isset( $_POST['publish'] ) ) ) {
			remove_action( 'save_post', 'Boxes_info_booking::save' );

			wp_update_post( array(
				'ID'            => $post_id,
				'post_title'    => '#' . $post_id,
			) );

			$from = AWE_function::convert_date_to_mdY( sanitize_text_field( wp_unslash( $_POST['from'] ) ) );
			$to = AWE_function::convert_date_to_mdY( sanitize_text_field( wp_unslash( $_POST['to'] ) ) );
			$total_date = count( AWE_function::range_date( $from, $to ) );
			$_order_data = get_post_meta( $post_id, 'apb_data_order', true ) ? get_post_meta( $post_id, 'apb_data_order', true ) : array();
			$order_status = isset( $_POST['apb_order_status'] ) ? sanitize_text_field( wp_unslash( $_POST['apb_order_status'] ) ) : 'apb-pending';

			if ( empty( $_POST['custommer'] ) || ! absint( $_POST['custommer'] ) ) {
				$customer_id = AWE_function::maybe_create_customer( $_POST['apb_customer_name'], $_POST['apb_customer_email'] );
			} else {
				$customer_id = absint( $_POST['custommer'] );
			}

			update_post_meta( $post_id, 'custommer', $customer_id );

			switch ( $order_status ) {
				case 'apb-pending':
					$avt_stt = 3;
					break;
				case 'apb-completed':
					$avt_stt = 0;
					break;
				case 'apb-processing':
					$avt_stt = 3;
					break;
				case 'apb-cancelled':
					$avt_stt = 2;
					break;
			}

			if ( empty( $_order_data ) ) {

				if ( isset( $_POST['data']['room_id'] ) ) {
					// Add new order by admin.
					$package_data = array();
					if ( isset( $_POST['package_data']['id'] ) ) {
						for ( $i = 0; $i < count( $_POST['package_data']['id'] ); $i++ ) {
							$package_data[] = array(
								'package_id' => $_POST['package_data']['id'][ $i ],
								'type'       => 'add',
								'total'      => $_POST['package_data']['total'][ $i ],
							);
						}
					}

					$room_type_id = absint( $_POST['data']['room_id'] );

					/**
					 * Add new order to system awebooking.
					 */
					self::update_status( $post_id, $order_status );

					if ( isset( $_POST['room_adult'] ) ) {
						$args['room_adult'] = $_POST['room_adult'];
					}

					if ( isset( $_POST['room_child'] ) ) {
						$args['room_child'] = $_POST['room_child'];
					}

					$args['customer_id'] = $customer_id;

					$args['from'] = $from;
					$args['to'] = $to;

					$room_id = AWE_function::get_room_available_from_room_type( $room_type_id, $from, $to );
					$args['room_id'] = $room_id;
					$args['status'] = $avt_stt;
					$args['package_data'] = $package_data;
					$args['price'] = (float) $_POST['data']['price'];

					$_apb_order_id = self::apb_add_order( $post_id, $args );
					self::update_status( $_apb_order_id, $order_status );

					/**
					 * Meta data post type shop_order.
					 */
					$args_order[] = array(
						'id'              => $_apb_order_id,
						'custommer'       => $customer_id,
						'room_adult'      => $args['room_adult'],
						'room_child'      => $args['room_child'],
						'from'            => $from,
						'to'              => $to,
						'order_room_id'   => $room_id,
						'package_data'    => serialize( $package_data ),
						'total_price'     => $args['price'],
					);

					update_post_meta( $post_id, 'custommer', $customer_id );
					update_post_meta( $post_id, 'from', $args_order[0]['from'] );
					update_post_meta( $post_id, 'to', $args_order[0]['to'] );
					update_post_meta( $post_id, 'apb_data_order', $args_order );
					update_post_meta( $post_id, 'total_ex_tax', $args['price'] );
					update_post_meta( $post_id, '_order_total', AWE_function::calculate_tax( $args['price'] ) );
					update_post_meta( $post_id, 'tax_amount', get_option( 'apb_tax_amount' ) );
					update_post_meta( $post_id, 'tax_type', get_option( 'apb_tax_type' ) );
					update_post_meta( $post_id, 'apb_order_id', array( $_apb_order_id ) );
					update_post_meta( $post_id, 'order_type', 2 );

				} else {

					$_apb_order_id = wp_insert_post( array(
						'post_type'      => 'apb_order',
						'post_status'    => 'apb-pending',
						'ping_status'    => 1,
						'post_author'    => 1,
						'post_password'  => uniqid( 'order_' ),
						'post_title'     => '#' . $post_id,
					) );

					self::update_status( $_apb_order_id, $order_status );
					self::update_status( $post_id, $order_status );

					update_post_meta( $post_id, 'apb_order_id', array( $_apb_order_id ) );
					update_post_meta( $post_id, 'order_type', 2 );

				}
			} else {
				$order_total_item = get_post_meta( $post_id, 'apb_order_id', true );

				// Add new item to order.
				if ( isset( $_POST['order_current'] ) ) {
					// Get package data.
					$package_data = array();
					if ( isset( $_POST['package_data']['id'] ) ) {
						for( $i = 0; $i <= count( $_POST['package_data']['id'] ) - 1; $i++ ) {
							$package_data[] = array(
								'package_id' => $_POST['package_data']['id'][ $i ],
								'type' => 'add',
								'total' => $_POST['package_data']['total'][ $i ]
							);
						}
					}

					$room_type_id = absint( $_POST['data']['room_id'] );
					// $from = sanitize_text_field( wp_unslash( $_POST['from'] ) );
					// $to = sanitize_text_field( wp_unslash( $_POST['to'] ) );
					$room_id = AWE_function::get_room_available_from_room_type( $room_type_id, $from, $to );
					$adult = absint( $_POST['room_adult'] );
					$child = absint( $_POST['room_child'] );
					$price = ( float ) $_POST['data']['price'];

					$extra_price_data = AWE_function::get_extra_price_data( $room_type_id, $adult, $child );

					$_price = 0;

					if ( ! empty( $extra_price_data['adult'] ) ) {
						$_price += $total_date * $extra_price_data['adult'];
					}

					if ( ! empty( $extra_price_data['child'] ) ) {
						$_price += $total_date * $extra_price_data['child'];
					}

					self::update_status( $post_id, $order_status );

					$args['custommer'] = $customer_id;

					$args['room_adult'] = $adult;

					$args['room_child'] = $child;

					$args['from'] = $from;

					$args['to'] = $to;

					$args['room_id'] = $room_id;
					$args['status']  = $avt_stt;
					$args['package_data']  = $package_data;
					$args['price'] = $_price + $price;

					$_apb_order_id = self::apb_add_order( $post_id, $args );
					self::update_status( $_apb_order_id, $order_status );
					$_order_data[] = array(
						'id'              => $_apb_order_id,
						'custommer'       => $customer_id,
						'room_adult'      => $adult,
						'room_child'      => $child,
						'from'            => $from,
						'to'              => $to,
						'order_room_id'   => $room_id,
						'package_data'    => $package_data,
						'total_price'     => $price + $_price,
					);

					update_post_meta( $post_id, 'apb_data_order', $_order_data );
					update_post_meta( $post_id, 'custommer', $customer_id );

					$order_total = get_post_meta( $post_id, '_order_total', true );
					update_post_meta( $post_id, '_order_total', ( float ) ( $order_total + $price ) );
					update_post_meta( $post_id, 'apb_order_id', array( $_apb_order_id ) );

				} else {
					self::update_status( $post_id, $order_status );
					$_id_order = array();

					// Save order status not add item.
					if ( ! empty( $order_total_item ) ) {
						foreach ( $order_total_item as $item_order ) {
							$room_id = get_post_meta( $item_order, 'order_room_id', true );
							$check_available = AWE_function::check_room_available( $from, $to, $room_id, true );
							if ( ! empty( $check_available ) ) {
								$_id_order[] = $item_order;
							}
						}
					}
				}
			}

			add_action( 'save_post', 'Boxes_info_booking::save' );
		}

	}


	/**
	 * Update post status.
	 *
	 * @param  int    $id     Post ID.
	 * @param  string $status Status.
	 * @return void
	 * @since 1.0
	 */
	static public function update_status( $id, $status ) {
		wp_update_post( array(
			'ID'    => $id,
			'post_title'    => '#' . $id,
			'post_status'   => $status,
		) );
	}


	static public function get_room_available( $from, $to, $room_id ) {
		$check = AWE_function::check_room_available( $from, $to, $room_id, true );
		$id = array();
		if ( ! empty( $check ) ) {
			foreach ( $check as $getid_available ) {
				$id[] = $getid_available->unit_id;
			}
		}

		return $id;
	}
}
