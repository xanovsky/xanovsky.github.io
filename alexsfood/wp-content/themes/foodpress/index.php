<?php include('header.php'); ?>

	<div id="wrapper">

		<div id="main">
		
			<?php if(get_option('fp_slider_tags')) { 
			
			$featured_posts = new WP_Query(array(
			'showposts' => 4,
			'tag' => get_option('fp_slider_tags')
			));
			
			?>
			<div id="featured-wrapper">
			
				<div id="slider" class="featured-item">
					<?php while($featured_posts->have_posts()): $featured_posts->the_post(); ?>
					
					<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'slider-image'); ?>
					<?php $image_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'slider-thumb'); ?>
					
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" title="#htmlcaption_<?php the_ID(); ?>" rel="<?php echo $image_thumb[0]; ?>" width="620" height="300" /></a>
					
					<?php endwhile; ?>
				</div>
				
				<?php while($featured_posts->have_posts()): $featured_posts->the_post(); ?>
				<div class="nivo-html-caption" id="htmlcaption_<?php the_ID(); ?>">
					<div class="featured-text">
						<span>BY <?php the_author(); ?>, <?php the_time( get_option('date_format') ); ?>, IN <?php the_category(', ') ?></span>
						<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
					</div>
				</div>
				<?php endwhile; ?>
			
			</div><!-- END FEATURED-WRAPPER -->
			<?php } ?>
			
			<?php if (have_posts()) : ?>
			
			<div class="post-block latest">
			
				<h3>Latest</h3>
			
			<?php while (have_posts()) : the_post(); ?>
			
				<?php if(get_option('fp_homepage_layout') == 'small-items') { ?>
			
				<div class="post-item-small">
				
					<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has a thumbnail */ ?>
						<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_post_thumbnail('small-thumb'); ?></a>
					<?php } ?>
					
					<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
					
					<div class="post-item-meta">
						<span>In <?php the_category(', ') ?></span>
						<span>On <?php the_time( get_option('date_format') ); ?></span>
						<span class="comments"><?php comments_popup_link(__('0 Comments'), __('1 Comment'), __('% Comments')); ?></span>
					</div>
					
					<?php the_excerpt(); ?>
					
				</div>
				
				<?php } elseif(get_option('fp_homepage_layout') == 'big-items') { ?>
				
				<div class="post-item-big">
				
					<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has a thumbnail */ ?>
						<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_post_thumbnail('big-thumb'); ?></a>
					<?php } ?>
					<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
					
					<div class="post-item-meta">
						<span>In <?php the_category(', ') ?></span>
						<span>On <?php the_time( get_option('date_format') ); ?></span>
						<span class="comments"><?php comments_popup_link(__('0 Comments'), __('1 Comment'), __('% Comments')); ?></span>
					</div>
					
					<div class="post-content">
						<?php the_content(); ?>
					</div>
					
				</div>
				
				<?php } elseif(get_option('fp_homepage_layout') == 'grid-items') { ?>
				
				<div class="post-item-grid">
				
					<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has a thumbnail */ ?>
						<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_post_thumbnail('grid-thumb'); ?></a>
					<?php } ?>
					
					<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
					
					<div class="post-item-meta">
						<span>In <?php the_category(', ') ?></span>
						<span>On <?php the_time( get_option('date_format') ); ?></span>
					</div>
					
				</div>
				
				<?php } else { ?>
				
				<div class="post-item-small">
				
					<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has a thumbnail */ ?>
						<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_post_thumbnail('small-thumb'); ?></a>
					<?php } ?>
					
					<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
					
					<div class="post-item-meta">
						<span>In <?php the_category(', ') ?></span>
						<span>On <?php the_time( get_option('date_format') ); ?></span>
						<span class="comments"><?php comments_popup_link(__('0 Comments'), __('1 Comment'), __('% Comments')); ?></span>
					</div>
					
					<?php the_excerpt(); ?>
					
				</div>
				
				<?php } ?>
			
			<?php endwhile; ?>
			
			</div>

			<?php kriesi_pagination(); ?>
			
			<?php endif; ?>
		
		</div><!-- END MAIN -->

<?php include('sidebar.php'); ?>
		
<?php include('footer.php'); ?>