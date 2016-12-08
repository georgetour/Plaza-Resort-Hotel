<?php
	/* ------------------------------------------------------------------------------- */
	/* Calluna Social Widget
	/* ------------------------------------------------------------------------------- */

	/* Widget Class ------------------------------------------------------------------ */

	class calluna_social_widget extends WP_Widget {


		/* Constructor ---------------------------------------------------------------- */
		function calluna_social_widget() {
			parent::__construct(FALSE, $name = esc_html__('Calluna Social Links', 'calluna-td'), array(
				'description' => esc_html__('Social profile links with icons.', 'calluna-td')
			));
		}

		/* Widget Output -------------------------------------------------------------- */

		function widget($args, $instance) {
			global $calluna_options;
			extract($args);

			/* Get the options into variables */
			$widget_title = isset($instance['title']) ? apply_filters('widget_title', $instance['title']) : "";
			$twitter      = isset($instance['twitter']) ? TRUE : FALSE;
			$facebook     = isset($instance['facebook']) ? TRUE : FALSE;
			$google       = isset($instance['google']) ? TRUE : FALSE;
			$instagram       = isset($instance['instagram']) ? TRUE : FALSE;
			$pinterest       = isset($instance['pinterest']) ? TRUE : FALSE;
			$tumblr       = isset($instance['tumblr']) ? TRUE : FALSE;
			$linkedin       = isset($instance['linkedin']) ? TRUE : FALSE;
			$youtube       = isset($instance['youtube']) ? TRUE : FALSE;
			$yelp       = isset($instance['yelp']) ? TRUE : FALSE;
			$tripadvisor       = isset($instance['tripadvisor']) ? TRUE : FALSE;

			/* Unique ID */
			$unique_id = $args['widget_id'];

			echo $before_widget;
			if ($widget_title) {
				echo $before_title;
				echo $widget_title;
				echo $after_title;
			}

			/* Front End Output */
			?>
			<ul class="footer-social">
				<?php if (get_theme_mod('twitter_account') !== '' && $twitter == TRUE) { ?>
					<li>
						<a href="<?php echo esc_url( get_theme_mod('twitter_account') ); ?>">
							<i class="icon-twitter"></i>
						</a>
					</li>
				<?php } ?>
				<?php if (get_theme_mod('facebook_account') !== '' && $facebook == TRUE) { ?>
					<li>
						<a href="<?php echo esc_url( get_theme_mod('facebook_account') ); ?>">
							<i class="icon-facebook"></i>
						</a>
					</li>
				<?php } ?>
				<?php if (get_theme_mod('google_account')!== '' && $google == TRUE) { ?>
					<li>
						<a href="<?php echo esc_url( get_theme_mod('google_account') ); ?>">
							<i class="icon-google_plus"></i>
						</a>
					</li>
				<?php } ?>
				<?php if (get_theme_mod('instagram_account')!== '' && $instagram == TRUE) { ?>
					<li>
						<a href="<?php echo esc_url( get_theme_mod('instagram_account') ); ?>">
							<i class="icon-instagram"></i>
						</a>
					</li>
				<?php } ?>
                <?php if (get_theme_mod('pinterest_account')!== '' && $pinterest == TRUE) { ?>
					<li>
						<a href="<?php echo esc_url( get_theme_mod('pinterest_account') ); ?>">
							<i class="icon-pinterest"></i>
						</a>
					</li>
				<?php } ?>
                <?php if (get_theme_mod('tumblr_account')!== '' && $tumblr == TRUE) { ?>
					<li>
						<a href="<?php echo esc_url( get_theme_mod('tumblr_account') ); ?>">
							<i class="icon-tumblr"></i>
						</a>
					</li>
				<?php } ?>
                <?php if (get_theme_mod('linkedin_account')!== '' && $linkedin == TRUE) { ?>
					<li>
						<a href="<?php echo esc_url( get_theme_mod('linkedin_account') ); ?>">
							<i class="icon-linkedin"></i>
						</a>
					</li>
				<?php } ?>
				<?php if (get_theme_mod('youtube_account')!== '' && $youtube == TRUE) { ?>
					<li>
						<a href="<?php echo esc_url( get_theme_mod('youtube_account') ); ?>">
							<i class="fa fa-youtube"></i>
						</a>
					</li>
				<?php } ?>
				<?php if (get_theme_mod('yelp_account')!== '' && $yelp == TRUE) { ?>
					<li>
						<a href="<?php echo esc_url( get_theme_mod('yelp_account') ); ?>">
							<i class="fa fa-yelp"></i>
						</a>
					</li>
				<?php } ?>
				<?php if (get_theme_mod('tripadvisor_account')!== '' && $tripadvisor == TRUE) { ?>
					<li>
						<a href="<?php echo esc_url( get_theme_mod('tripadvisor_account') ); ?>">
							<i class="fa fa-tripadvisor"></i>
						</a>
					</li>
				<?php } ?>
			</ul>
			<?php
			echo $after_widget;
		}

		/* Update & Save -------------------------------------------------------------- */

		function update($new_instance, $old_instance) {
			return $new_instance;
		}

		/* Widget Form ---------------------------------------------------------------- */

		function form($instance) {
			global $calluna_options;

			/* Get the options into variables */
			$widget_title = isset($instance['title']) ? apply_filters('widget_title', $instance['title']) : "";
			$twitter      = isset($instance['twitter']) ? TRUE : FALSE;
			$facebook     = isset($instance['facebook']) ? TRUE : FALSE;
			$google       = isset($instance['google']) ? TRUE : FALSE;
			$pinterest    = isset($instance['pinterest']) ? TRUE : FALSE;
			$tumblr       = isset($instance['tumblr']) ? TRUE : FALSE;
			$linkedin     = isset($instance['linkedin']) ? TRUE : FALSE;
			$instagram     = isset($instance['instagram']) ? TRUE : FALSE;
			$youtube     = isset($instance['youtube']) ? TRUE : FALSE;
			$yelp     = isset($instance['yelp']) ? TRUE : FALSE;
			$tripadvisor     = isset($instance['tripadvisor']) ? TRUE : FALSE;
			?>
			<!-- Widget Title -->
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_html__("Widget Title:", 'calluna-td'); ?></label>
				<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($widget_title); ?>"/>
			</p>
			<p><?php esc_html_e("Select the social profiles you would like to display in this widget:", 'calluna-td'); ?></p>
			<!-- Facebook -->
			<p>
				<input class="checkbox" type="checkbox" <?php checked($facebook, TRUE); ?> id="<?php echo esc_attr($this->get_field_id('facebook')); ?>" name="<?php echo esc_attr($this->get_field_name('facebook')); ?>"/>
				<label for="<?php echo esc_attr($this->get_field_id('facebook')); ?>"><?php echo esc_html__('Facebook', 'calluna-td') ?></label>
			</p>
            <!-- Twitter -->
			<p>
				<input class="checkbox" type="checkbox" <?php checked($twitter, TRUE); ?> id="<?php echo esc_attr($this->get_field_id('twitter')); ?>" name="<?php echo esc_attr($this->get_field_name('twitter')); ?>"/>
				<label for="<?php echo esc_attr($this->get_field_id('twitter')); ?>"><?php echo esc_html__('Twitter', 'calluna-td') ?></label>
			</p>
			<!-- Google+ -->
			<p>
				<input class="checkbox" type="checkbox" <?php checked($google, TRUE); ?> id="<?php echo esc_attr($this->get_field_id('google')); ?>" name="<?php echo esc_attr($this->get_field_name('google')); ?>"/>
				<label for="<?php echo esc_attr($this->get_field_id('google')); ?>"><?php echo esc_html__('Google+', 'calluna-td') ?></label>
			</p>
			<!-- Instagram -->
			<p>
				<input class="checkbox" type="checkbox" <?php checked($instagram, TRUE); ?> id="<?php echo esc_attr($this->get_field_id('instagram')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram')); ?>"/>
				<label for="<?php echo esc_attr($this->get_field_id('instagram')); ?>"><?php echo esc_html__('Instagram', 'calluna-td') ?></label>
			</p>
            <!-- Pinterest -->
			<p>
				<input class="checkbox" type="checkbox" <?php checked($pinterest, TRUE); ?> id="<?php echo esc_attr($this->get_field_id('pinterest')); ?>" name="<?php echo esc_attr($this->get_field_name('pinterest')); ?>"/>
				<label for="<?php echo esc_attr($this->get_field_id('pinterest')); ?>"><?php echo esc_html__('Pinterest', 'calluna-td') ?></label>
			</p>
			<!-- Tumblr -->
			<p>
				<input class="checkbox" type="checkbox" <?php checked($tumblr, TRUE); ?> id="<?php echo esc_attr($this->get_field_id('tumblr')); ?>" name="<?php echo esc_attr($this->get_field_name('tumblr')); ?>"/>
				<label for="<?php echo esc_attr($this->get_field_id('tumblr')); ?>"><?php echo esc_html__('Tumblr', 'calluna-td') ?></label>
			</p>
            <!-- LinkedIn -->
			<p>
				<input class="checkbox" type="checkbox" <?php checked($linkedin, TRUE); ?> id="<?php echo esc_attr($this->get_field_id('linkedin')); ?>" name="<?php echo esc_attr($this->get_field_name('linkedin')); ?>"/>
				<label for="<?php echo esc_attr($this->get_field_id('linkedin')); ?>"><?php echo esc_html__('LinkedIn', 'calluna-td') ?></label>
			</p>
			<!-- Youtube -->
			<p>
				<input class="checkbox" type="checkbox" <?php checked($youtube, TRUE); ?> id="<?php echo esc_attr($this->get_field_id('youtube')); ?>" name="<?php echo esc_attr($this->get_field_name('youtube')); ?>"/>
				<label for="<?php echo esc_attr($this->get_field_id('youtube')); ?>"><?php echo esc_html__('Youtube', 'calluna-td') ?></label>
			</p>
			<!-- Yelp -->
			<p>
				<input class="checkbox" type="checkbox" <?php checked($yelp, TRUE); ?> id="<?php echo esc_attr($this->get_field_id('yelp')); ?>" name="<?php echo esc_attr($this->get_field_name('yelp')); ?>"/>
				<label for="<?php echo esc_attr($this->get_field_id('yelp')); ?>"><?php echo esc_html__('Yelp', 'calluna-td') ?></label>
			</p>
			<!-- Tripadvisor -->
			<p>
				<input class="checkbox" type="checkbox" <?php checked($tripadvisor, TRUE); ?> id="<?php echo esc_attr($this->get_field_id('tripadvisor')); ?>" name="<?php echo esc_attr($this->get_field_name('tripadvisor')); ?>"/>
				<label for="<?php echo esc_attr($this->get_field_id('tripadvisor')); ?>"><?php echo esc_html__('Tripadvisor', 'calluna-td') ?></label>
			</p>
		<?php
		}
	}

	register_widget('calluna_social_widget');
?>