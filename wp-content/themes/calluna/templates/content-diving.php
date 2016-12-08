<?php

//Variables to store our fields
$diving_heading = get_field('diving_heading');
$diving_text = get_field('diving_text')

?>

<!-- Diving Template-->
<div class="big-row container custom-container">

            <section class="row">
                <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 zero-padding">
                    <div class="">
                        <?php masterslider(18); ?>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 zero-padding slider-fix">
                    <div class="centered-content">
                        <h4 class="top-header "><?php echo $diving_heading;?></h4>
                        <p><?php echo $diving_text;?></p>
                        <!--Starts the oops for testimonial post-->
                        <?php $loop = new WP_Query(array('post_type' => 'recreation',
                            'orderby' => 'post_id', 'order' => 'ASC'));?>
                        <?php while ($loop->have_posts()): $loop->the_post() ?>
                            <?php $recreation_activities  = get_field('recreation_activities');?>
                            <!----Reacreation activities------>

                                <div class="col-sm-12">
                                    <ul><li><?php echo $recreation_activities?></li></ul>
                                </div>


                        <?php endwhile; wp_reset_query()?>
                        <div class="btn-primary-container calendar text-center">
                            <input type="submit" class="btn-primary check-avb-js style-1 read-more-button" value="Read More">
                        </div>
                    </div>
                </div>
            </section><!--End top image--->

</div>
