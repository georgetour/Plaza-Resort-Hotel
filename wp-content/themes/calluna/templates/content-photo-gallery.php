<?php

//Variables to store our fields
$photo_gallery_heading = get_field('photo_gallery_heading');
$photo_gallery_text = get_field('photo_gallery_text')

?>

<!-- Photo Gallery Template-->
<div class="big-row container custom-container">

    <section class="row">

        <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 zero-padding slider-fix">
            <div class="centered-content">
                <h4 class="top-header "><?php echo $photo_gallery_heading;?></h4>
                <p><?php echo $photo_gallery_text;?></p>

                <div class="btn-primary-container calendar text-center">
                    <input type="submit" class="btn-primary check-avb-js style-1 read-more-button" value="Read More">
                </div>
            </div>
        </div>

        <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 zero-padding">
            <div class="">
                <?php masterslider(19); ?>
            </div>
        </div>
    </section><!--End top image--->

</div>