<?php
/**
 * Plugin Name: Tabs Widget
 */

add_action( 'widgets_init', 'fp_tabs_load_widgets' );

function fp_tabs_load_widgets() {
	register_widget( 'fp_tabs_widget' );
}

class fp_tabs_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function fp_tabs_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'fp_tabs_widget', 'description' => __('A widget that displays popular, comments and tags in tabs', 'fp_tabs_widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'fp_tabs_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'fp_tabs_widget', __('FoodPress: Tabs', 'fp_tabs_widget'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$number = $instance['number'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */

		?>
		
		<div class="tabs-wrapper">
		
			<ul class="tabs">
				<li><a href="#tab1">Popular</a></li>
				<li><a href="#tab2">Comments</a></li>
				<li><a href="#tab3">Tags</a></li>
			</ul>
			
			<div id="tab1" class="tab_content">
			
			<?php
			$popular_posts = new WP_Query('showposts=' . $number . '&orderby=comment_count&order=DESC');
			if($popular_posts->have_posts()): ?>
			
				<div class="post-block">
			
				<?php while($popular_posts->have_posts()): $popular_posts->the_post(); ?>
				
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
				
				<?php endif; ?>
			
			</div>
			
			<div id="tab2" class="tab_content">
			
				<?php
				global $wpdb;
				$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,78) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $number";
				$comments = $wpdb->get_results($sql);
				foreach ($comments as $comment) { 
			
			?>
			
				<div class="post-item-side">
									
					<?php echo get_avatar( $comment, '60' ); ?>
					<h4 class="comment-author-side"><?php echo strip_tags($comment->comment_author); ?> says:</h4><a class="comment-text-side" href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> on <?php echo $comment->post_title; ?>"><?php echo strip_tags($comment->com_excerpt); ?>...</a>
								
				</div>

			<?php } ?>
			
			</div>
			
			<div id="tab3" class="tab_content">
			
				<div class="tagcloud">
				<?php
				$tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 18));
				foreach ((array) $tags as $tag) {
				?>
				<?php echo '<a href="' . get_tag_link ($tag->term_id) . '" rel="tag">' . $tag->name . '</a>';	?>
				<?php } ?>
				</div>
			
			</div>
			
		</div>
			
		<?php

		/* After widget (defined by themes). */
		echo '</div>';
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['number'] = $new_instance['number'];

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array('number' => 5);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- number -->
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of Posts:</label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" style="width:15%;" />
		</p>

	<?php
	}
}

?>