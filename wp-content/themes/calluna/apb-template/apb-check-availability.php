<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * The template for displaying check available
 *
 * Override this template by copying it to your theme
 *
 * @author  AweTeam
 * @package AweBooking/Templates
 * @version 1.0
 */
get_header() ;
do_action('apb_renderBefore');

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
?>
<div class="container-fluid apb-check-availability">
    <div class="row apb-layout">
        <div class="col-md-4 apb-widget-area">
            <!-- SIDEBAR -->
            <div class="apb-widget-area-wrapper">
                <?php
                /*
                 * Hook apb_fill_content_js
                 */
                do_action('apb_fill_content_js');

                /*
                 * Hook Form check available
                 */
                do_action("form_check_availability");

                ?>
            </div>
            <!-- END / SIDEBAR -->
        </div>
        <div class="col-md-8">
            <!-- CONTENT -->
            <div class="apb-content-area-wrapper">
                <?php
                do_action("form_step");
                /**
                 * layout_loading hook
                 */
                do_action('layout_loading');
                /*
                * Before content add data of javascript
                */
                do_action('apb_room_content_before');

                /*
                 * body content get request data or data ajax
                 */

                do_action('apb_body_check_available');

                /*
                * After content add data of javascript
                */
                do_action('apb_room_content_after');
                ?>
            </div>
            <!-- END / CONTENT -->
        </div>
    </div>
</div>
<!-- END / PAGE WRAP -->
<?php
do_action('apb_renderAfter');
get_footer()
?>