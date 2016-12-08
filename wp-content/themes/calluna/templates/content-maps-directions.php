<?php

//Variables to store our fields
$maps_label = get_field('maps_label');
$maps_info = get_field('maps_info')

?>

<!-- Maps Directions Template-->
<div class="big-row container custom-container">

    <section class="row">
        <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 zero-padding">
            <div class="">
                <?php masterslider(20); ?>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 zero-padding slider-fix">
            <div class="centered-content">
                <h4 class="top-header "><?php echo $maps_label;?></h4>
                <p><?php echo $maps_info;?></p>

                <div class="btn-primary-container calendar text-center">
                    <input type="submit" class="btn-primary check-avb-js style-1 read-more-button" value="Read More">
                </div>
            </div>
        </div>
    </section><!--End top image--->

</div>
