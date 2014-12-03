<?php
/**
 * Plugin Name: Flickr widget
 */

add_action( 'widgets_init', 'fp_flickr_load_widgets' );

function fp_flickr_load_widgets() {
	register_widget( 'fp_flickr_widget' );
}

class fp_flickr_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function fp_flickr_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'fp_flickr_widget', 'description' => __('Flickr widget', 'fp_flickr_widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'fp_flickr_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'fp_flickr_widget', __('FoodPress: Flickr', 'fp_flickr_widget'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$flickrID = $instance['flickrID'];
		$postcount = $instance['postcount'];
		$type = $instance['type'];
		$display = $instance['display'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		?>
		
			<div id="flickr_badge_wrapper">
				<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>
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
		$instance['flickrID'] = strip_tags( $new_instance['flickrID'] );
		$instance['postcount'] = $new_instance['postcount'];
		$instance['type'] = $new_instance['type'];
		$instance['display'] = $new_instance['display'];

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('My Photostream'), 'postcount' => 6, 'type' => 'user', 'display' => 'random',);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>
		
		<!-- Flickr ID -->
		<p>
			<label for="<?php echo $this->get_field_id( 'flickrID' ); ?>">Flickr ID (<a href="http://idgettr.com/">idGettr</a>):</label>
			<input id="<?php echo $this->get_field_id( 'flickrID' ); ?>" name="<?php echo $this->get_field_name( 'flickrID' ); ?>" value="<?php echo $instance['flickrID']; ?>" style="width:90%;" />
		</p>
		
		<!-- Number of posts -->
		<p>
			<label for="<?php echo $this->get_field_id( 'postcount' ); ?>">Number of photos</label>
			<select id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>">
				<option <?php if ( '3' == $instance['postcount'] ) echo 'selected="selected"'; ?>>3</option>
				<option <?php if ( '6' == $instance['postcount'] ) echo 'selected="selected"'; ?>>6</option>
				<option <?php if ( '9' == $instance['postcount'] ) echo 'selected="selected"'; ?>>9</option>
			</select>
		</p>
		
		<!-- Type -->
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>">Type (user or group):</label>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>">
				<option <?php if ( 'user' == $instance['type'] ) echo 'selected="selected"'; ?>>user</option>
				<option <?php if ( 'group' == $instance['type'] ) echo 'selected="selected"'; ?>>group</option>
			</select>
		</p>
		
		<!-- Display -->
		<p>
			<label for="<?php echo $this->get_field_id( 'display' ); ?>">Display (random or latest):</label>
			<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>">
				<option <?php if ( 'random' == $instance['display'] ) echo 'selected="selected"'; ?>>random</option>
				<option <?php if ( 'latest' == $instance['display'] ) echo 'selected="selected"'; ?>>latest</option>
			</select>
		</p>


	<?php
	}
}

?>