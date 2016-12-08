<?php
/* 
Template Name: Page with Left Sidebar
*/


get_header(); ?>
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
					$headerImageText = get_post_meta(get_the_ID(), '_calluna_header_text', true);
					if ($headerImageText == '')
					{
						$headerImageText = get_the_title();	
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
						$headerColorText = get_the_title();	
					}
                  $shortcodeColor = '<div class="color-background" style="background-color:';
				  	$shortcodeColor .= $color;
					$shortcodeColor.= ';">';
					$shortcodeColor .= '<h1 class="header_text_wrapper ' . esc_attr($header_title_pos) . '"><span>' . esc_attr($headerColorText) . '</span><span class="separator"></span></h1></div>';
				  	echo do_shortcode($shortcodeColor); 
				}?>
		<div class="sidebar-left_wrapper">
            <div class="no-padding container-fluid">
            	<div class="row-eq-height row">
                	<div class="col-sm-12 col-md-4 col-lg-4 sidebar_wrapper">
                        <aside class="sidebar">
                        	<?php if ( is_active_sidebar( 'page-sidebar' ) ) { ?>
								<?php dynamic_sidebar( 'page-sidebar' ); ?>
                            <?php } ?>  
                        </aside>
                    </div>	
        			<div class="col-sm-12 col-md-8 col-lg-8">
                        <div id="primary" class="content-area">
                            <main id="main" class="site-main">
                            <?php while ( have_posts() ) : the_post(); ?>
                              <?php get_template_part( 'content', 'page-sidebar' ); ?>
                            <?php endwhile; // end of the loop. ?>
                
                        	</main><!-- #main -->
                        </div><!-- #primary -->
            		</div>
        		</div>
            </div>
        </div>
<?php get_footer(); ?>