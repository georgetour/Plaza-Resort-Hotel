<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The template for displaying layout complated select room
 *
 * Override this template by copying it to your theme
 *
 * @author  AweTeam
 * @package AweBooking/Templates
 * @version 1.0
 */

?>
<?php $button_style = get_theme_mod('button_style', 'style-1'); ?>

<h5><?php esc_html_e("ALL ROOMS ARE SELECTED", "calluna-td") ?></h5>
<?php
do_action('apb_layout_list_review_book');
?>
<div class="apb-room-select-footer">
    <a href="#" class="link-other-room change-all-room-btn"><i class="icon-left"></i><?php esc_html_e( 'Change all rooms', 'awebooking' ); ?></a>
    <a href="<?php echo esc_url( AWE_function::get_checkout_page_url() ); ?>" class="pull-right btn-primary"><?php esc_html_e( 'Go to checkout', 'awebooking' ); ?></a>
</div>
