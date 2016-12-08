<?php
/**
 * The Template for displaying all single posts.
 *
 * @package calluna
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
				elseif($header == 'color') {
					$color = get_theme_mod('header_bg_color', '#0C2149');
					$headerColorText = get_the_title( $post->ID );
					if ($headerColorText == '')
					{
						$headerColorText = get_the_title();	
					}
                  $shortcodeColor = '<div class="color-background" style="background-color:' . $color . ';">';
					$shortcodeColor .= '<h1 class="header_text_wrapper ' . esc_attr($header_title_pos) . '"><span>' . esc_attr($headerColorText) . '</span><span class="separator"></span></h1></div>';
				  	echo do_shortcode($shortcodeColor); 
				}?>
	<div class="no-padding container-fluid">
    <div class="row-eq-height row">
    	<?php $sidebar_pos = get_theme_mod( 'position_sidebar', 'right' );
        if($sidebar_pos == 'right')
		{ ?>
		<div class="col-xs-12 col-md-8">
        	<div id="primary" class="content-area">
                <main id="main" class="site-main">
				<?php while ( have_posts() ) : the_post(); ?>
				  <?php if( get_post_format() == 'quote' ) : ?>
				  <?php get_template_part( 'content', 'quote'); ?>
				  <?php elseif( get_post_format() == 'gallery' ) : ?>
				  <?php get_template_part( 'content', 'gallery' ); ?>
                  <?php elseif( get_post_format() == 'link' ) : ?>
				  <?php get_template_part( 'content', 'link' ); ?>
                  <?php elseif( get_post_format() == 'video' ) : ?>
				  <?php get_template_part( 'content', 'video' ); ?>
				  <?php else : ?>
				  <?php get_template_part( 'content', 'single' ); ?>
				  <?php endif; ?>
                <?php endwhile; // end of the loop. ?>
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
		<div class="col-xs-12 col-md-4 sidebar-left_wrapper">
        	<aside class="sidebar">
            	<?php if ( is_active_sidebar( 'blog' ) ) { ?>
					<?php dynamic_sidebar( 'blog' ); ?>
                <?php } ?>   
            </aside>
        </div>
        <div class="col-xs-12 col-md-8 content_row">
        	<div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
				  <?php if( get_post_format() == 'quote' ) : ?>
				  <?php get_template_part( 'content', 'quote'); ?>
				  <?php elseif( get_post_format() == 'gallery' ) : ?>
				  <?php get_template_part( 'content', 'gallery' ); ?>
                  <?php elseif( get_post_format() == 'link' ) : ?>
				  <?php get_template_part( 'content', 'link' ); ?>
                  <?php elseif( get_post_format() == 'video' ) : ?>
				  <?php get_template_part( 'content', 'video' ); ?>
				  <?php else : ?>
				  <?php get_template_part( 'content', 'single' ); ?>
				  <?php endif; ?>
                <?php endwhile; // end of the loop. ?>
            </main><!-- #main -->
			</div><!-- #primary -->
        </div>
		<?php } ?>
    </div>
	</div>
<?php get_footer(); ?>