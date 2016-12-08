<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package calluna
 */

get_header(); ?>

<?php
	/* get revolution slider from shortcode in custom field*/
	$header = get_post_meta(get_queried_object_id(), '_calluna_header_select', true);
	$header_title_pos = get_theme_mod('header_title_pos', 'text-left');
	if($header == 'slider') {
		$slider = get_post_meta(get_queried_object_id(), '_calluna_header_slider', true);
		echo do_shortcode($slider); 
	} 
	elseif($header == 'image') {
					$image = get_post_meta(get_queried_object_id(), '_calluna_header_image_id', true);
					$image_attributes = wp_get_attachment_image_src( $image, 'full' );
					$headerImageText = get_post_meta(get_queried_object_id(), '_calluna_header_text', true);
					if ($headerImageText == '')
					{
						$headerImageText = get_the_title( get_option('page_for_posts', true) );	
					}
					$shortcodeImage = '<div class="image-background" style="background: url(' . $image_attributes[0] . ');">';
				$shortcodeImage .= '<h1 class="header_text_wrapper ' . esc_attr($header_title_pos) . '">';
				$shortcodeImage .= '<span>' . esc_attr($headerImageText) . '</span><span class="separator"></span></h1></div>';
				echo do_shortcode($shortcodeImage); 
				}
	elseif($header == 'color') {
					$color = get_theme_mod('header_bg_color', '#0C2149');
					$headerColorText = get_post_meta(get_queried_object_id(), '_calluna_header_text', true);
					if ($headerColorText == '')
					{
						$headerColorText = get_the_title( get_option('page_for_posts', true) );
					}
					
                  $shortcodeColor = '<div class="color-background" style="background-color:';
				  	$shortcodeColor .= $color;
					$shortcodeColor.= ';">';
					$shortcodeColor .= '<h1 class="header_text_wrapper ' . esc_attr($header_title_pos) . '"><span>' . esc_attr($headerColorText) . '</span><span class="separator"></span></h1>';
					$shortcodeColor .= '</div>';
				  	echo do_shortcode($shortcodeColor); 
				}?>
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

<?php get_footer(); ?>
