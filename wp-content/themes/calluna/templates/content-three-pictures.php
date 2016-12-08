<?php

//Variables to store our fields
$left_title = get_field('left_title');
$left_picture = get_field('left_picture');
$middle_title = get_field('middle_title');
$middle_picture= get_field('middle_picture');
$right_title = get_field('right_title');
$right_picture = get_field('right_picture');

?>

<!-- Three Pictures Template -->
<div class="big-row container custom-container">

    <section class="row">
        <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 zero-padding">
            <div class="left-column">
                <img class="img-responsive" src="<?php echo $left_picture['url'];?>">
                <h3 class="absolute-center"><?php echo $left_title?></h3>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 zero-padding">
            <div class="middle-column" >
                <img class="img-responsive" src="<?php echo $middle_picture['url'];?>">
                <h3 class="absolute-center"><?php echo $middle_title?></h3>
            </div>
        </div>
<div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 zero-padding">
    <div class="right-column">
        <img class="img-responsive" src="<?php echo $right_picture['url'];?>">
        <h3 class="absolute-center"><?php echo $right_title?></h3>
    </div>
</div>
    </section><!--End top image--->

</div>
