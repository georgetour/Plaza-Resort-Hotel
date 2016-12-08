<?php

//Variables
$weddings_label = get_field('weddings_label');
$weddings_text =  get_field('weddings_text');
$background_image_weddings = get_field('background_image_weddings');

?>

<!--Bottom Weddings Template-->
<div class="weddings" style="background: url('<?php echo $background_image_weddings['url'];?>')no-repeat center center fixed; background-size: cover">
 <div class="container">
    <div class="row">
        <section class=" text-center">
                <div class="col-xs-12">
                    
                    <div class="weddings-section">
                        <h1 class="top-header "><?php echo $weddings_label?></h1>
                        <p><?php echo $weddings_text?></p>
                    </div>
                </div>


        </section><!--End top image--->
    </div>
 </div>
</div>