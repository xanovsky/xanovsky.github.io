<?php
/**
 * Plugin Name: Recent Posts
 */

add_action( 'widgets_init', 'fp_recent_posts_load_widgets' );

function fp_recent_posts_load_widgets() {
	register_widget( 'fp_recent_posts_widget' );
}

class fp_recent_posts_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function fp_recent_posts_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'fp_recent_posts_widget', 'description' => __('Recent posts widget', 'fp_recent_posts_widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'fp_recent_posts_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'fp_recent_posts_widget', __('FoodPress: Recent posts', 'fp_recent_posts_widget'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$number = $instance['number'];
		$categories = $instance['categories'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		?>
		
			<?php
			$recent_posts = new WP_Query(array(
				'showposts' => $number,
				'cat' => $categories,
			));
			?>
			
			<div class="post-block">
			
			<?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>
		
				<div class="post-item-side">
					
					<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has a thumbnail */ ?>
					<?php the_post_thumbnail('side-thumb'); ?>
					<?php } ?>
						
					<h4><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h4>
					<div class="post-item-meta">
						<span>In <?php the_category(', ') ?></span>
						<span>On <?php the_time( get_option('date_format') ); ?></span>
						<span class="comments"><?php comments_popup_link(__('0 Comments'), __('1 Comment'), __('% Comments')); ?></span>
					</div>
					
				</div>
				
			<?php endwhile; ?>
			
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
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['categories'] = $new_instance['categories'];

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Recent Posts'), 'categories' => 'all', 'number' => 5);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>
		
		<!-- Number of posts -->
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of posts to show:</label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
		</p>
		
		<!-- Category -->
		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>">Filter by Category:</label> 
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>


	<?php
	}
}

?>