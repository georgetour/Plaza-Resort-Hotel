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

$_date_curent = date_create( date( 'Y-m-d' ) );
date_add( $_date_curent, date_interval_create_from_date_string( ( isset( $_GET['apb_mon'] ) ? $_GET['apb_mon'] : '0' ) . ' month' ) );
$new_date = date_format( $_date_curent, 'Y-m-d' );
$month_current = isset( $_GET['apb_mon'] ) ? $_GET['apb_mon'] + 2 : 2;
$month_sub = isset( $_GET['apb_mon'] ) ? $_GET['apb_mon'] - 2 : '-2';
if ( date( 'm', strtotime( $new_date ) ) == 12 ) {
	$_year = date( 'Y', strtotime( $new_date ) ) + 1;
} else {
	$_year = date( 'Y', strtotime( $new_date ) );
}
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
								<h2 class="header"><?php esc_html_e('Information', 'calluna-td') ?></h2>
								<div class="apb-product_tab">
									<?php
									/**
									 * Handler active tabs and content-tabs.
									 */
									$date_available_need_active = ! empty( $_GET['apb_mon'] );

									?>

									<ul class="apb-product_tab-header">
										<li>
											<a href="#information" data-toggle="tab"><?php esc_html_e( 'Details', 'awebooking' ) ?></a>
										</li>

										<?php
										$package = AWE_function::get_room_option( get_the_ID(), 'apb_room_type' );
										if ( ! empty( $package ) ) :
											?>
											<li>
												<a href="#package" data-toggle="tab"><?php esc_html_e( 'Optional extras', 'awebooking' ) ?></a>
											</li>
										<?php endif; ?>

										<?php if ( AWE_function::show_single_calendar() ) : ?>
											<li class="active">
												<a href="#date-available" data-toggle="tab"><?php esc_html_e( 'Date Available', 'awebooking' ) ?></a>
											</li>
										<?php endif; ?>
									</ul>

									<div class="apb-product_tab-panel tab-content">
										<div class="tab-pane text-column fade" id="information">
											<?php the_content() ?>
										</div>

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
										<h2><?php esc_html_e( 'Amenities', 'calluna-td' ); ?></h2>
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
															<?php echo esc_attr($item['description']);?>
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
										<h2><?php esc_html_e( 'Gallery', 'calluna-td' ); ?></h2>
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
														<?php echo wp_get_attachment_image( $image, 'large' ); ?>
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
						<!-- Availability Calendar -->
                        <?php if ( AWE_function::show_single_calendar() ) : ?>
                            <div class="row row-eq-height">
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 text-column">
                                    <div id="date-available">
                                        <?php
                                        $next = add_query_arg(
                                            array(
                                                'apb_mon'	=> $month_current,
                                                'apb_year'	=> date( 'Y', strtotime( $new_date ) ),
                                                'room_id'	=> get_the_ID(),
                                            ),
                                            get_permalink()
                                        );
                                        $prev = add_query_arg(
                                            array(
                                                'apb_mon'	=> $month_sub,
                                                'apb_year'	=> date( 'Y', strtotime( $new_date ) ),
                                                'room_id'	=> get_the_ID(),
                                            ),
                                            get_permalink()
                                        );
                                        ?>
                                        <script>
                                            var awe_date_curent_1  = '<?php echo date( 'Y', strtotime( $new_date ) ); ?>-<?php echo date( 'm', strtotime( $new_date ) ); ?>';
                                            var awe_date_curent_2  = '<?php echo $_year; ?>-<?php echo date( 'm', strtotime( date( 'Y', strtotime( $new_date ) ) . '-' . ( date( 'm', strtotime( $new_date ) ) + 1 ) ) ); ?>';
                                            var room_id = <?php the_ID() ?>
                                        </script>
                                        <div class="apb-month">
                                            <a href="<?php echo esc_html( $prev ); ?>#date-available" class="apb-fc-nav apb-fc-prev" type="button"><?php esc_html_e( 'Prev', 'awebooking' ); ?></a>
                                            <div id="calendar"> </div>
                                        </div>
                                        <div class="apb-month">
                                            <a href="<?php echo esc_html( $next ); ?>#date-available" class="apb-fc-nav apb-fc-next" type="button"><?php esc_html_e( 'Next', 'awebooking' ); ?></a>
                                            <div id="calendar2"> </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 vertical-align column-style-2">
                                    <div class="desc_wrapper_right">
                                        <h2><?php esc_html_e( 'Availability', 'calluna-td' ); ?></h2>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
						<!-- Related Rooms -->

						<?php
						$post_ID = get_the_ID();
						$custom_loop = new WP_Query(array(
								'post_type'      => 'apb_room_type',
								'post__not_in' => array( $post_ID ),
						));
						?>
						<?php if ($custom_loop->have_posts() && get_theme_mod('related_rooms', 'yes') == 'yes') { ?>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 content_row">
									<div>
										<?php echo do_shortcode('[cl_room_carousel img_height="510" img_width="420"]'); ?>
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