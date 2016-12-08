<?php
/**
 * The template for displaying single room
 *
 * Override this template by copying it to your theme
 *
 * @author  AweTeam
 * @package AweBooking/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header() ;

do_action('apb_renderBefore');

?>
<?php
/* get revolution slider from shortcode in custom field*/
$header = get_post_meta($post->ID, '_calluna_header_select', true);
$header_title_pos = get_theme_mod('header_title_pos', 'text-left');
if($header == 'slider') {
	$slider = get_post_meta($post->ID, '_calluna_header_slider', true);
	echo do_shortcode($slider);
}
elseif($header == 'image') {
	$image = get_post_meta($post->ID, '_calluna_header_image_id', true);
	$image_attributes = wp_get_attachment_image_src( $image, 'full' );
	$headerImageText = get_the_title( $post->ID );
	if ($headerImageText == '')
	{
		$headerImageText = get_the_title();
	}
	$shortcodeImage = '<div class="image-background" style="background: url(' . $image_attributes[0] . ');">';
	$shortcodeImage .= '<h1 class="header_text_wrapper ' . esc_attr($header_title_pos) . '">';
	$shortcodeImage .= '<span>' . esc_attr($headerImageText) . '</span><span class="separator"></span></h1></div>';
	echo do_shortcode($shortcodeImage);
}
else {
	$color = get_theme_mod('header_bg_color', '#0C2149');
	$headerColorText = get_the_title( $post->ID );
	if ($headerColorText == '')
	{
		$headerColorText = get_the_title();
	}
	$shortcodeColor = '<div class="color-background" style="background-color:';
	$shortcodeColor .= $color;
	$shortcodeColor.= ';">';
	$shortcodeColor .= '<h1 class="header_text_wrapper ' . esc_attr($header_title_pos) . '"><span>' . esc_attr($headerColorText) . '</span><span class="separator"></span></h1></div>';
	echo do_shortcode($shortcodeColor);
}?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main content content-width room">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="room-content no-padding container-fluid">
						<!-- Content + booking -->
						<div class="row row-eq-height">
							<div class="col-sm-12 col-lg-6 col-md-12 col-xs-12 container-left">
								<?php
								$header_title = get_theme_mod( 'room_header_title', 'Information');
								// WPML translations
								$header_title = calluna_translate_theme_mod( 'room_header_title', $header_title ); ?>
								<h2 class="header"><?php esc_html_e($header_title) ?></h2>
								<div class="apb-product_tab">
									<?php
									/**
									 * Handler active tabs and content-tabs.
									 */

									//$date_available_need_active = ! empty( $_GET['apb_mon'] );
									$date_available_need_active =  false;
									if ( AWE_function::show_single_calendar() ) {
										$date_available_need_active =  true;
									}
									?>

									<?php if ( AWE_function::show_single_calendar() || ! empty ($package) ) { ?>
										<ul class="apb-product_tab-header">
											<li class="<?php echo $date_available_need_active ? '' : 'active'; ?>">
												<?php $details_tab_title = get_theme_mod( 'room_details_tab_title', 'Details');
												// WPML translations
												$details_tab_title = calluna_translate_theme_mod( 'room_details_tab_title', $details_tab_title ); ?>
												<a href="#information" data-toggle="tab"><?php esc_html_e( $details_tab_title ) ?></a>
											</li>

											<?php
											$package = AWE_function::get_room_option( get_the_ID(), 'apb_room_type' );
											if ( ! empty( $package ) ) :
												?>
												<li>
													<?php $extras_tab_title = get_theme_mod( 'room_extras_tab_title', 'Optional Extras');
													// WPML translations
													$extras_tab_title = calluna_translate_theme_mod( 'room_extras_tab_title', $extras_tab_title ); ?>
													<a href="#package" data-toggle="tab"><?php esc_html_e( $extras_tab_title ) ?></a>
												</li>
											<?php endif; ?>

											<?php if ( AWE_function::show_single_calendar() ) : ?>
												<li class="<?php echo $date_available_need_active ? 'active' : ''; ?>">
													<?php $availability_tab_title = get_theme_mod( 'room_availability_tab_title', 'Date Available');
													// WPML translations
													$availability_tab_title = calluna_translate_theme_mod( 'room_availability_tab_title', $availability_tab_title ); ?>
													<a href="#date-available" data-toggle="tab"><?php esc_html_e( $availability_tab_title ) ?></a>
												</li>
											<?php endif; ?>
										</ul>
									<?php } ?>
									<div class="apb-product_tab-panel tab-content">
										<div class="tab-pane text-column fade <?php echo $date_available_need_active ? '' : 'active in'; ?>" id="information">
											<?php the_content() ?>
										</div>

										<?php if ( AWE_function::show_single_calendar() ) : ?>
											<div class="tab-pane fade <?php echo $date_available_need_active ? 'active in' : ''; ?>" id="date-available">
												<?php
												/**
												 * @hooked apb_room_type_availability_calendar() - 10
												 */
												do_action( 'apb_room_type_availability_calendar', AWE_function::wpml_get_default_room_type( get_the_ID() ) );
												?>
											</div>
										<?php endif; ?>

										<div class="tab-pane fade" id="package">
											<?php
											/**
											 * Hook : apb_loop_single_package
											 * Get list package for room.
											 * @hooked loop_single_package
											 */
											do_action( 'apb_loop_single_package' );
											?>
										</div>

									</div>



								</div>
							</div>
							<div class="col-sm-12 col-lg-6 col-md-12 col-xs-12 container-right accent-background">
								<div class="booking-column">
									<?php echo do_shortcode('[cl_booking_calendar_single]'); ?>
								</div>
							</div>
						</div>
						<!-- Amenities -->
						<?php $amenities = get_post_meta($post->ID,'_calluna_room_amenities',true);?>
						<?php if ( ! empty( $amenities ) ) { ?>
							<div class="row row-eq-height">
								<div class="col-sm-12 col-lg-6 col-md-12 col-xs-12 vertical-align column-style-2" <?php if ( get_theme_mod( 'column_style2_background_img' ) ) { ?>
									style="background-image: url(<?php echo esc_url( get_theme_mod( 'column_style2_background_img')); ?>);"
								<?php } ?>>

									<div class="amenities_wrapper">
										<?php
										$amenities_title = get_theme_mod( 'room_amenities_title', 'Amenities');
										// WPML translations
										$amenities_title = calluna_translate_theme_mod( 'room_amenities_title', $amenities_title ); ?>
										<h2><?php esc_html_e( $amenities_title ); ?></h2>
										<p class="teaser">
											<?php echo get_post_meta($post->ID,'_calluna_room_amenities_description',true);?>
										</p>
									</div>
								</div>
								<div class="col-sm-12 col-lg-6 col-md-12 col-xs-12">
									<div class="amenities_items_wrapper">
										<?php foreach (array_chunk($amenities, 2, true) as $array)
										{?>
											<div class="row">
												<?php foreach($array as $item)
												{ ?>
													<div class="col-sm-6">
														<label>
															<?php echo esc_attr($item['title']);?>
														</label>
														<p class="item-text">
															<?php echo do_shortcode($item['description']);?>
														</p>
													</div>
												<?php }?>
											</div>
										<?php }?>
									</div>

								</div>
							</div>
						<?php }?>
						<!-- Gallery -->
						<?php $gallery_images = get_post_meta( $post->ID, '_calluna_gallery_select', true ); ?>
						<?php if ( ! empty( $gallery_images ) ) { ?>
							<div class="row row-eq-height">
								<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 vertical-align column-style-1" <?php if ( get_theme_mod( 'column_style1_background_img' ) ) { ?>
									style="background-image: url(<?php echo esc_url( get_theme_mod( 'column_style1_background_img')); ?>);"
								<?php } ?>>

									<div class="desc_wrapper_left">
										<?php
										$gallery_title = get_theme_mod( 'room_gallery_title', 'Gallery');
										// WPML translations
										$gallery_title = calluna_translate_theme_mod( 'room_gallery_title', $gallery_title ); ?>
										<h2><?php esc_html_e( $gallery_title ); ?></h2>
										<p class="teaser">
											<?php echo esc_attr(get_post_meta($post->ID,'_calluna_gallery_description',true));?>
										</p>
									</div>
								</div>
								<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 content_row">
									<div class="wpb_wrapper">
										<div id="bootstrap-carousel" class="carousel slide" data-ride="carousel">
											<div class="carousel-inner">
												<?php foreach ($gallery_images as $key=>$image) : ?>
													<div class="item <?php echo esc_attr($key) == 0 ? 'active' : ''; ?>">
                                                        <?php $image_big_src = wp_get_attachment_image_src($image, 'full'); ?>
														<a href="<?php echo esc_url( $image_big_src[0] ); ?>" class="link_image lightbox" data-lightbox-gallery="gallery-<?php esc_attr_e($image); ?>"><?php echo wp_get_attachment_image($image, 'full'); ?></a>
													</div>
												<?php endforeach; ?>
											</div>

											<div class="gallery_button_wrapper">
												<a class="left carousel-control" href="#bootstrap-carousel" data-slide="prev">
													<span class="icon-left"></span>
												</a>
											</div>
											<div class="gallery_button_wrapper">
												<a class="right carousel-control" href="#bootstrap-carousel" data-slide="next">
													<span class="icon-right"></span>
												</a>
											</div>
										</div>
									</div>

								</div>
							</div>
						<?php }?>
						<!-- Related Rooms -->

						<?php
						$post_ID = get_the_ID();
						$custom_loop = new WP_Query(array(
							'post_type'      => 'apb_room_type',
							'post__not_in' => array( $post_ID ),
						));
						?>
						<?php if ($custom_loop->have_posts() && get_theme_mod('related_rooms', 'yes') != 'no') { ?>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 content_row">
									<div>
										<?php echo do_shortcode('[cl_room_carousel img_height="510" img_width="420"]'); ?>
									</div>
								</div>
							</div>
						<?php } ?>
                        <?php
                            $map_lat = get_post_meta($post->ID, '_calluna_room_map_lat', true);
                            $map_lng = get_post_meta($post->ID, '_calluna_room_map_lng', true);
                        ?>
                        <?php if (get_theme_mod('show_room_map', 'yes') != 'no' && $map_lat != '' && $map_lng != ''){ ?>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 content_row">
                                    <div>
                                        <?php
                                            $map_type = get_post_meta($post->ID, '_calluna_room_map_type', true);
                                            $map_style = get_post_meta($post->ID, '_calluna_room_map_style', true);
                                            $map_height = get_post_meta($post->ID, '_calluna_room_map_height', true);
                                            $map_zoom = get_post_meta($post->ID, '_calluna_room_map_zoom', true);
                                            $map_marker = get_post_meta($post->ID, '_calluna_room_map_marker', true);

                                            $shortcode = '[cl_google_map';
                                            $shortcode .= ' map_type="' . $map_type . '"';
                                            $shortcode .= ' style="' . $map_style . '"';
                                            $shortcode .= ' height="' . $map_height . '"';
                                            $shortcode .= ' lat="' . $map_lat . '"';
                                            $shortcode .= ' lng="' . $map_lng . '"';
                                            $shortcode .= ' zoom="' . $map_zoom . '"';
                                            $shortcode .= ' marker="' . $map_marker . '"';
                                            $shortcode .= ']';
                                            echo do_shortcode($shortcode);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
						<?php if (get_post_meta($post->ID, '_calluna_room_custom_content', true)) { ?>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 content_row">
									<div>
										<?php echo wp_kses(get_post_meta($post->ID, '_calluna_room_custom_content', true),calluna_allowed_tags()); ?>
									</div>
								</div>
							</div>
						<?php } ?>

					</div><!-- .entry-content -->

				</div><!-- #post-## -->

				<?php //do_action('apb_single_message'); ?>
			<?php endwhile; endif; ?>
		</main><!-- #main -->
	</div><!-- #primary -->
	<!-- END / PAGE WRAP -->
<?php
do_action('apb_renderAfter');
get_footer();
?>