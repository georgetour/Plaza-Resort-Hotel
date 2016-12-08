<?php
/**
 * The template for displaying archive room
 *
 * Override this template by copying it to your theme
 *
 * @author  AweTeam
 * @package AweBooking/Templates
 * @version 1.0
 * @deprecated 2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header() ;
do_action('apb_renderBefore');
?>
<div class="apb-container">
    <?php do_action("form_step");  ?>
    <div class="apb-layout">

        <!-- SIDEBAR -->
        <div class="apt-widget-area">
            <?php do_action("form_check_availability");  ?>
        </div>
        <!-- END / SIDEBAR -->

        <!-- CONTENT -->
        <div class="apt-content-area">
           <?php do_action("loop_data_check_availability") ?>
        </div>
        <!-- END / CONTENT -->

    </div>
</div>
<?php
do_action('apb_renderAfter');
get_footer()
?>
