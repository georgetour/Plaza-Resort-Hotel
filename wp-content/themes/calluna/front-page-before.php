<?php get_header();

$booking_teaser_text = get_theme_mod('booking_teaser_text', 'Book your trip!');
// WPML translations
$booking_teaser_text = calluna_translate_theme_mod( 'booking_teaser_text', $booking_teaser_text );

?>

<div style="position:relative">
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
					    if('posts' == get_option( 'show_on_front' )) :
						    $headerImageText = esc_html__('Recent Posts', 'calluna-td');
						else :
						    $headerImageText = get_the_title();
						endif;
					}
					$shortcodeImage = '<div class="image-background" style="background: url(' . $image_attributes[0] . ');">';
				$shortcodeImage .= '<h1 class="header_text_wrapper ' . esc_attr($header_title_pos) . '">';
				$shortcodeImage .= '<span>' . esc_attr($headerImageText) . '</span><span class="separator"></span></h1></div>';
				echo do_shortcode($shortcodeImage);
				}
    elseif($header == 'color') {
					$color = get_theme_mod('header_bg_color', '#0C2149');
					$headerColorText = get_post_meta(get_the_ID(), '_calluna_header_text', true);
					if ($headerColorText == '')
					{
					    if('posts' == get_option( 'show_on_front' )) :
						    $headerColorText = esc_html__('Recent Posts', 'calluna-td');
						else :
						    $headerColorText = get_the_title();
						endif;
					}
                  $shortcodeColor = '<div class="color-background" style="background-color:';
				  	$shortcodeColor .= $color;
					$shortcodeColor.= ';">';
					$shortcodeColor .= '<h1 class="header_text_wrapper ' . esc_attr($header_title_pos) . '"><span>' . esc_attr($headerColorText) . '</span><span class="separator"></span></h1>';
					$shortcodeColor .= '</div>';
				  	echo do_shortcode($shortcodeColor);
				}?>
  <?php if ( get_theme_mod('booking_teaser_show', 'yes') == 'yes' && 'page' == get_option( 'show_on_front')) { ?>
	   <div class="container-fluid" style="position:absolute; width:100%; bottom:0;">
  	<div class="row">
      <div class="hidden-xs col-sm-12 pull-right booking">

        <span><?php echo esc_attr($booking_teaser_text); ?></span>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<?php if('posts' == get_option( 'show_on_front' )) : ?>
	<div class="no-padding container-fluid">
    <div class="row row-eq-height">
    	<?php $sidebar_pos = get_theme_mod( 'position_sidebar', 'right' );
        if($sidebar_pos == 'right')
		{ ?>
		<div class="col-xs-12 col-md-8">
        	<div id="primary" class="content-area">
                <main id="main" class="site-main main-content">
                   <?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) : the_post(); ?>

                            <?php get_template_part( 'content', get_post_format() ); ?>

                        <?php endwhile; // end of the loop. ?>

                      	<?php calluna_paging_nav();
					// If no content, include the "No posts found" template.
					else :
						get_template_part( 'content', 'none' );
					endif;
					?>

                </main><!-- #main -->
			</div><!-- #primary -->
        </div>
        <div class="col-xs-12 col-md-4 sidebar_wrapper">
        	<aside class="sidebar">
            	<?php if ( is_active_sidebar( 'blog' ) ) { ?>
					<?php dynamic_sidebar( 'blog' ); ?>
                <?php } ?>
            </aside>
        </div>

		<?php }
		else
		{ ?>
		<div class="sidebar-left_wrapper">
		<div class="col-xs-12 col-md-4 sidebar_wrapper">
        	<aside class="sidebar">
            	<?php if ( is_active_sidebar( 'blog' ) ) { ?>
					<?php dynamic_sidebar( 'blog' ); ?>
                <?php } ?>
            </aside>
        </div>
        <div class="col-xs-12 col-md-8 content_row">
        	<div id="primary" class="content-area">
                <main id="main" class="site-main main-content">
                    <?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) : the_post(); ?>

                            <?php get_template_part( 'content', get_post_format() ); ?>

                        <?php endwhile; // end of the loop. ?>

                        <?php calluna_paging_nav();
					// If no content, include the "No posts found" template.
					else :
						get_template_part( 'content', 'none' );
					endif;
					?>
                </main><!-- #main -->
			</div><!-- #primary -->
        </div>
        </div>
		<?php } ?>


    </div>
	</div>
<?php else : ?>
<div id="primary" class="content-area container-fluid">
    <main class="main-content content-width">
    	<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'front-page' ); ?>
        <?php endwhile; // end of the loop. ?>
    </main>
</div>
<?php endif; ?>



<!--Template for maps-directions-->
<?php get_template_part('templates/content','maps-directions');?>

<!--Template for photo gallery-->
<?php get_template_part('templates/content','photo-gallery');?>
	
<!--Template for diving-->
<?php get_template_part('templates/content','diving');?>

<!--Bottom Template with Weddings-->
<?php get_template_part('templates/content','weddings');?>

<?php get_footer(); ?>