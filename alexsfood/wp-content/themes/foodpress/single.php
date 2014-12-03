<?php include('header.php'); ?>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div id="title-wrapper">
	
		<div id="title">
	
			<div class="title-text<?php $title = get_the_title(); $title_length = strlen($title); if($title_length >= 56) { echo ' big'; } ?>">
				<h1><?php the_title(); ?></h1>
				<span><?php _e('By', 'FoodPress'); ?> <?php the_author_posts_link(); ?>, <?php the_time( get_option('date_format') ); ?>, <?php _e('In', 'FoodPress'); ?> <?php the_category(', ') ?></span>
			</div>
			
			<?php if(get_post_meta($post->ID, "foodpress_servings", true) || get_post_meta($post->ID, "foodpress_cooking_time", true)) { ?>
			<div id="recipe-info">
				<?php if(get_post_meta($post->ID, "foodpress_servings", true)) { ?>
				<span class="persons"><?php echo get_post_meta($post->ID, "foodpress_servings", true); ?> Servings</span>
				<?php } ?>
				<?php if(get_post_meta($post->ID, "foodpress_cooking_time", true)) { ?>
				<span class="time">~ <?php echo get_post_meta($post->ID, "foodpress_cooking_time", true); ?></span>
				<?php } ?>
			</div>
			<?php } ?>
			
		</div>
	
	</div>

	<div id="crumbs-wrapper">
			
		<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
			
	</div>
	
	<div id="wrapper">
	
		<div id="main">
		
			<div id="post">
		
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has a thumbnail */ ?>
				<?php the_post_thumbnail('post-thumb', array('class' => 'post-thumb')); ?>
				<?php } ?>
				
				<div class="post-content">
				
					<?php if(get_post_meta($post->ID, "foodpress_ingredients", true)) { ?>
					<div class="note-wrapper">
					
						<div class="note-top"></div>
						
						<div class="note-content">
						
							<ul>
								<?php
									
									$get_ingredients = get_post_meta($post->ID, "foodpress_ingredients", true);
									$ingredients = explode("\r", $get_ingredients);
									
									foreach($ingredients as $ingredient) {
									
										echo '<li>' . $ingredient . '</li>';
										
									}
								
								?>
							</ul>
						
						</div>
						
						<div class="note-bottom"></div>
					
					</div>
					<?php } ?>
				
					<?php the_content(); ?>
					<?php wp_link_pages('before=<span class="page-links"><strong>Pages:</strong> &after=</span>'); ?>
					
				</div>
				
				<div class="post-tags">
					<?php the_tags('', ''); ?> 
				</div>
		
			</div>
			
			<?php if(get_option('fp_share_post') == "false" || get_option('fp_share_post') == "") { ?>
			<div class="share-box">
			
				<?php if (get_option('fp_share_post_twitter') == "true") { ?>
				<div class="share-widget">
					<a href="http://twitter.com/share" class="twitter-share-button" data-text='<?php the_title(); ?>' data-count="vertical">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
				</div>
				<?php } ?>
				
				<?php if (get_option('fp_share_post_facebook') == "true") { ?>
				<div class="share-widget">
					<iframe src="http://www.facebook.com/plugins/like.php?app_id=149766198425277&amp;href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;send=false&amp;layout=box_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=90" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:50px; height:60px;" allowTransparency="true"></iframe>
				</div>
				<?php } ?>
				
				<?php if (get_option('fp_share_post_google') == "true") { ?>
				<div class="share-widget">
					<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
					<g:plusone size="tall"></g:plusone>
				</div>
				<?php } ?>
				
				<?php if (get_option('fp_share_post_email') == "true") { ?>
				<div class="share-widget">
					<a href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>"><img src='<?php bloginfo('template_url'); ?>/images/email-share.png' alt='Email Share' /></a>
				</div>
				<?php } ?>
				
				<?php if (get_option('fp_share_post_digg') == "true") { ?>
				<div class="share-widget">
					<script type="text/javascript">
					(function() {
					var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
					s.type = 'text/javascript';
					s.async = true;
					s.src = 'http://widgets.digg.com/buttons.js';
					s1.parentNode.insertBefore(s, s1);
					})();
					</script>
					<a class="DiggThisButton DiggMedium" href="http://digg.com/submit?url=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>"></a>
				</div>
				<?php } ?>
				
				<?php if (get_option('fp_share_post_stumbleupon') == "true") { ?>
				<div class="share-widget">
					<script src="http://www.stumbleupon.com/hostedbadge.php?s=5"></script>
				</div>
				<?php } ?>
				
				<?php if (get_option('fp_share_post_reddit') == "true") { ?>
				<div class="share-widget">
					<script type="text/javascript" src="http://www.reddit.com/static/button/button2.js"></script>
				</div>
				<?php } ?>
				
				<?php if (get_option('fp_share_post_tumblr') == "true") { ?>
				<div class="share-widget">
					<a href="http://www.tumblr.com/share" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:62px; height:20px; background:url('http://platform.tumblr.com/v1/share_2.png') top left no-repeat transparent;">Share on Tumblr</a>
				</div>
				<?php } ?>
			
			</div>
			<?php } ?>
			
			<?php if(get_option('fp_author_box') == "false" || get_option('fp_author_box') == "") { ?>
			<div class="post-block">
			
				<h3>About the Author: <?php the_author_posts_link(); ?></h3>
				
				<?php echo get_avatar( get_the_author_meta('email'), '75' ); ?>
				
				<p class="about-author-text"><?php the_author_meta("description"); ?></p>
			
			</div>
			<?php } ?>
			
			<?php if(get_option('fp_related_posts') == "false" || get_option('fp_related_posts') == "") { ?>
			<?php $tags = get_the_tags(); ?>
			<?php if($tags): ?>
			<?php $related = get_related_posts($post->ID, $tags); ?>
			<?php if($related->have_posts()) : ?>
			<div class="post-block">
			
				<h3>Related Posts</h3>
				
				<?php while($related->have_posts()): $related->the_post(); ?>
				<div class="post-item-grid">
				
					<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has a thumbnail */ ?>
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_post_thumbnail('grid-thumb'); ?></a>
					<?php } ?>
					
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
					
					<div class="post-item-meta">
						<span>In <?php the_category(', ') ?></span>
						<span>On <?php the_time( get_option('date_format') ); ?></span>
					</div>
					
				</div>
				<?php endwhile; ?>
			
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<?php wp_reset_query(); ?>
			<?php } ?>
			
			<div class="post-block">
				
				<?php comments_template(); ?>
			
			</div>
			
			<?php endwhile; endif; ?>
		
		</div><!-- END MAIN -->

<?php include('sidebar.php'); ?>
		
<?php include('footer.php'); ?>