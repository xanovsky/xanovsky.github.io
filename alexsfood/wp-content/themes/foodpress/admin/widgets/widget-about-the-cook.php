<?php
/**
 * Plugin Name: About Widget
 */

add_action( 'widgets_init', 'fp_about_load_widgets' );

function fp_about_load_widgets() {
	register_widget( 'fp_about_widget' );
}

class fp_about_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function fp_about_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'fp_about_widget', 'description' => __('An about the cook/your site widget', 'fp_about_widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'fp_about_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'fp_about_widget', __('FoodPress: About the Cook', 'fp_about_widget'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$text = $instance['text'];
		$image = $instance['image'];
		$twitter = $instance['twitter'];
		$facebook = $instance['facebook'];
		$flickr = $instance['flickr'];
		$rss = $instance['rss'];
		$subscribe = $instance['subscribe'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		?>
				<div class="about-cook-text">
					<?php if($image) { ?><img src="<?php echo $image; ?>" alt="" class="about-cook-image" /><?php } ?>
					<?php echo $text; ?>
				</div>
				
				<div class="about-cook-social">
					<?php if($twitter) { ?><a href="http://www.twitter.com/<?php echo get_option('fp_twitter'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter.png" alt="Twitter" /></a><?php } ?>
					<?php if($facebook) { ?><a href="http://www.facebook.com/<?php echo get_option('fp_facebook'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" alt="Facebook" /></a><?php } ?>
					<?php if($flickr) { ?><a href="<?php echo get_option('fp_flickr'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/flickr.png" alt="Flickr" /></a><?php } ?>
					<?php if($rss) { ?><a href="<?php echo get_option('fp_feedburner'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/rss.png" alt="RSS" /></a><?php } ?>
					
					<?php if($subscribe) { ?>
					<div class="about-email">
					<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo ($fp_feedburner); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"><input type="text" value="Enter Email" name="email"/></p><input type="hidden" value="<?php echo ($fp_feedburner); ?>" name="uri"/><input type="hidden" name="loc" value="en_US"/><input type="submit" value="GO" class="email-button" /></form>
					</div>
					<?php } ?>
					
				</div>
		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['image'] = strip_tags( $new_instance['image'] );
		$instance['text'] = $new_instance['text'];
		$instance['twitter'] = $new_instance['twitter'];
		$instance['facebook'] = $new_instance['facebook'];
		$instance['subscribe'] = $new_instance['subscribe'];
		$instance['flickr'] = $new_instance['flickr'];
		$instance['rss'] = $new_instance['rss'];

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('About the Cook'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>

		<!-- About text -->
		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>">About text:</label>
			<textarea id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" style="width:96%;" rows="6"><?php echo $instance['text']; ?></textarea>
			<small>Note: Wrap your text in &lt;p&gt;&lt;/p&gt; tags</small>
		</p>
		
		<!-- Image -->
		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>">Image URL:</label>
			<input id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo $instance['image']; ?>" style="width:90%;" />
			<small>EG. http://yoursite.com/portrait.jpg (keep the image around 90x120px)</small>
		</p>
		
		<!-- include twitter -->
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>">Include Twitter icon:</label>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" <?php checked( (bool) $instance['twitter'], true ); ?> />
		</p>
		
		<!-- include facebook -->
		<p>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>">Include Facebook icon:</label>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" <?php checked( (bool) $instance['facebook'], true ); ?> />
		</p>
		
		<!-- include flickr -->
		<p>
			<label for="<?php echo $this->get_field_id( 'flickr' ); ?>">Include Flickr icon:</label>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'flickr' ); ?>" name="<?php echo $this->get_field_name( 'flickr' ); ?>" <?php checked( (bool) $instance['flickr'], true ); ?> />
		</p>
		
		<!-- include rss -->
		<p>
			<label for="<?php echo $this->get_field_id( 'rss' ); ?>">Include RSS icon:</label>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" <?php checked( (bool) $instance['rss'], true ); ?> />
		</p>
		
		<!-- include email -->
		<p>
			<label for="<?php echo $this->get_field_id( 'subscribe' ); ?>">Include Email Subscribe:</label>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'subscribe' ); ?>" name="<?php echo $this->get_field_name( 'subscribe' ); ?>" <?php checked( (bool) $instance['subscribe'], true ); ?> />
		</p>
		<small>Note: Enter your social links in the theme options</small>


	<?php
	}
}

?>