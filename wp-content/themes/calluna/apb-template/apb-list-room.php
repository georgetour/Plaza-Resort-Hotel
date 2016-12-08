<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The template for displaying list room
 *
 * Override this template by copying it to your theme
 *
 * @author  AweTeam
 * @package AweBooking/Templates
 * @version 1.0
 */
get_header() ;
/* get revolution slider from shortcode in custom field*/
$header = get_post_meta(get_the_ID(), '_calluna_header_select', true);
$header_title_pos = get_theme_mod('header_title_pos', 'text-left');
if($header == 'slider') {
    $slider = get_post_meta(get_the_ID(), '_calluna_header_slider', true);
    echo do_shortcode($slider);
}
elseif($header == 'image') {
    $image = get_post_meta(get_the_ID(), '_calluna_header_image_id', true);
    $image_attributes = wp_get_attachment_image_src( $image, 'full' );
    $headerImageText = get_post_meta(get_the_ID(), '_calluna_header_text', true);
    if ($headerImageText == '')
    {
        $headerImageText = get_the_title();
    }
    $shortcodeImage = '<div class="image-background small-height" style="background: url(' . $image_attributes[0] . ');">';
    $shortcodeImage .= '<h1 class="header_text_wrapper ' . esc_attr($header_title_pos) . '">';
    $shortcodeImage .= '<span>' . esc_attr($headerImageText) . '</span><span class="separator"></span></h1></div>';
    echo do_shortcode($shortcodeImage);
}
else {
    $color = get_theme_mod('header_bg_color', '#0C2149');
    $headerColorText = get_post_meta(get_the_ID(), '_calluna_header_text', true);
    if ($headerColorText == '')
    {
        $headerColorText = get_the_title();
    }
    $shortcodeColor = '<div class="color-background small-height" style="background-color:';
    $shortcodeColor .= $color;
    $shortcodeColor.= ';">';
    $shortcodeColor .= '<h1 class="header_text_wrapper ' . esc_attr($header_title_pos) . '"><span>' . esc_attr($headerColorText) . '</span><span class="separator"></span></h1>';
    $shortcodeColor .= '</div>';
    echo do_shortcode($shortcodeColor);
}
do_action('apb_renderBefore');
?>
<!-- PAGE WRAP -->
<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-md-4">
            <div class="apb-top-padding">
            <?php
            // Hook apb_fill_content_js.
            do_action( 'apb_fill_content_js' );

            // Hook form check available.
            do_action( 'form_check_availability' );
            ?>
            </div>
        </div>
        <!-- END / SIDEBAR -->
        <!-- CONTENT -->
        <div class="col-md-8 apb-content-wraper">
            <?php
            /**
             * layout_loading hook
             */
            do_action('layout_loading')
            ?>
            <?php printf('<div class="apb-content %s">', apply_filters('apb_content_room_js','apb-content-js')) ?>
            <div class="apb-room">
                <?php
                /*
                 * hook : apb_loop_content_list_room
                 */
                do_action('apb_loop_content_list_room');
                wp_reset_query()
                ?>
            </div>
            <?php printf('</div>') ?>
        </div>
    </div>
    <!-- END / CONTENT -->
</div>
<!-- END / PAGE WRAP -->
<?php
do_action('apb_renderAfter');
get_footer();
?>
