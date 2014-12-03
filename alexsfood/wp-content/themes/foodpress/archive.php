<?php get_header(); ?>

	<div id="title-wrapper">
	
		<div id="title">
	
			<div class="title-text archive">
				<?php if (have_posts()) : ?>
	
				<?php /* Get author data */
				if(get_query_var('author_name')) :
				$curauth = get_userdatabylogin(get_query_var('author_name'));
				else :
				$curauth = get_userdata(get_query_var('author'));
				endif;
				?>

				<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
				<?php /* If this is a category archive */ if (is_category()) { ?>
				<h1>Category: &nbsp;<?php single_cat_title(); ?></h1>
				<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
				<h1>Tagged: &nbsp;<?php single_tag_title(); ?></h1>
				<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
				<h1>Archive: &nbsp;<?php the_time('F jS, Y'); ?></h1>
				<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<h1>Archive: &nbsp;<?php the_time('F, Y'); ?></h1>
				<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<h1>Archive: &nbsp;<?php the_time('Y'); ?></h1>
				<?php /* If this is an author archive */ } elseif (is_author()) { ?>
				<h1>All Posts By: <?php echo $curauth->display_name; ?></h1>
				
				<?php } ?>
			</div>
			
		</div>
	
	</div>
	
	<div id="crumbs-wrapper">
			
		<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
			
	</div>
	
	<div id="wrapper">

		<div id="main">
	
		<div class="post-block archive">
		
			<?php while (have_posts()) : the_post(); ?>
			
				<?php if(get_option('fp_archive_layout') == 'small-items') { ?>
			
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
				
				<?php } elseif(get_option('fp_archive_layout') == 'big-items') { ?>
				
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
				
				<?php } elseif(get_option('fp_archive_layout') == 'grid-items') { ?>
				
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

		</div>
		<!-- END MAIN -->
		
<?php get_sidebar(); ?>

<?php get_footer(); ?>