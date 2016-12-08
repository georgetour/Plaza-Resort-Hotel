<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package calluna
 */

$copyright = get_theme_mod( 'footer_txt', 'Copyright 2015 by themetwins. Calluna Hotel Theme crafted with love.');

// WPML translations
$copyright = calluna_translate_theme_mod( 'footer_txt', $copyright );
?>

	</div>
	    <footer id="colophon" class="site-footer">
    	<div class="footer-image-wrapper">
        	<div class="top-footer-container">
            	<div class="container">
                	<div class="row ">

                    	<div class="col-xs-12 col-sm-4 col-lg-4">

                            <?php if ( is_active_sidebar( 'footer-1' ) ) { ?>
                                <?php dynamic_sidebar( 'footer-1' ); ?>
                            <?php } ?>

                      </div>
                      <div class="col-xs-12 col-sm-4 col-lg-4">

                          <?php if ( is_active_sidebar( 'footer-2' ) ) { ?>
                              <?php dynamic_sidebar( 'footer-logo' ); ?>
                          <?php } ?>
                      </div>
                      <div class="col-xs-12 col-sm-4 col-lg-4">
                          
                        <?php if ( is_active_sidebar( 'footer-3' ) ) { ?>
    						<?php dynamic_sidebar( 'footer-3' ); ?>
                        <?php } ?>
                      </div>
                    </div>
                </div>
            </div>
            
        	<div class="container">
                <div class="row" style="padding:35px 0px;">
                    <div class="col-xs-12">
                        <div class="site-info">
                        <?php echo $copyright ?>
                    </div><!-- .site-info -->
                    </div>
              </div>
            </div>
        </div>
	</footer><!-- #colophon -->
    <!-- Go Top Links -->
	<a href="#" id="go-top"><i class="fa fa-angle-up"></i></a>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
