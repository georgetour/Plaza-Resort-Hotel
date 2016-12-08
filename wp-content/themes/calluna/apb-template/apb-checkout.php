<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The template for displaying cbheck out
 *
 * Override this template by copying it to your theme
 *
 * @author  AweTeam
 * @package AweBooking/Templates
 * @version 1.0
 */
get_header() ;
do_action('apb_renderBefore');
?>
<?php
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
}?>

	<!-- PAGE WRAP -->
	<div class="container-fluid">
		<div class="row">

			<!-- SIDEBAR -->
			<div class="col-md-4">
				<div class="apb-room-selected apb-top-padding">
					<!-- HEADING -->
					<h5><?php esc_html_e('Your booking', "awebooking") ?></h5>
					<!-- END / HEADING -->

					<div class="apb-room-selected_content">
						<?php do_action('apb_loop_item_cart_info'); ?>
					</div>
				</div>
			</div>
			<!-- END / SIDEBAR -->
			<!-- CONTENT -->
			<div class="col-md-8 apb-content-wraper">
				<?php
				do_action("form_step",3);
				/**
				 * layout_loading hook
				 */
				do_action('layout_loading');
				/*
                * Before content add data of javascript
                */
				do_action('apb_room_content_before');
				?>
				<?php
				$apb_cart = AWE_function::get_cart();
				if(!empty($apb_cart)){
					while ( have_posts() ) : the_post();
					?>
					<section class="section-checkout">
						<div class="container">
							<div class="checkout">
								<div class="row">

									<div class="col-md-10">
										<div class="checkout_head">
											<h2><?php the_title(); ?></h2>
										</div>
										<?php the_content(); ?>
									</div>
								</div>
							</div>
						</div>
					</section>
                    <?php
					endwhile;
					wp_reset_postdata();
					?>
				<?php } else { ?>
					<a href="<?php echo esc_url( AWE_function::get_check_available_page() ) ?>"><?php esc_html_e( 'No Item. Return to Check Availability form!', 'awebooking' ); ?></a>
				<?php } ?>
				<?php
				/*
                * After content add data of javascript
                */
				do_action('apb_room_content_after');
				?>
			</div>
			<!-- END / CONTENT -->
		</div>
	</div>
	<!-- END / PAGE WRAP -->
<?php
do_action('apb_renderAfter');
get_footer();
?>