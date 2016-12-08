<?php
/**
 * Email guest info
 *
 * @package Awebooking
 */

?>

<span style="display: inline-block; font-size: 12px; line-height: 1.428em; vertical-align: middle;" class="apb-option">
	<?php printf( esc_html__( '%s Adult', 'awebooking' ), absint( $item['room_adult'] ) ); ?>, <?php printf( esc_html__( '%s Child', 'awebooking' ), absint( $item['room_child'] ) ); ?>
</span>
