<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package calluna
 */
?>

<div id="secondary" class="widget-area">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
    <!-- default sidebar -->
    <?php endif; ?>
</div>

    
