<?php get_header(); ?>

	<div id="title-wrapper">
	
		<div id="title">
	
			<div class="title-text archive">
				<h1><?php _e('Search results for', 'FoodPress'); ?> "<?php echo get_search_query(); ?>"</h1>
			</div>
			
		</div>
	
	</div>
	
	<div id="crumbs-wrapper">
			
		<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
			
	</div>
	
	<div id="wrapper">

		<div id="main">
	
		<div class="post-block archive">
		
		<?php if (have_posts()) : ?>
		
			<?php while (have_posts()) : the_post(); ?>
				
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

			<?php endwhile; ?>
			
		</div>
		
		<?php kriesi_pagination(); ?>

	<?php else :
	
			echo(__('<p>Sorry, but no posts were found.</p></div>'));

	endif; ?>

		</div>
		<!-- END MAIN -->
		
<?php get_sidebar(); ?>

<?php get_footer(); ?>