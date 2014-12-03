<?php include('header.php'); ?>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div id="title-wrapper">
	
		<div id="title">
	
			<div class="title-text archive">
				<h1><?php the_title(); ?></h1>
			</div>
			
		</div>
	
	</div>

	<div id="crumbs-wrapper">
			
		<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
			
	</div>
	
	<div id="wrapper">
	
		<div id="main">
		
			<div id="post">
				
				<div class="post-content">
				
					<?php the_content(); ?>
					
				</div>
		
			</div>

			<?php endwhile; endif; ?>
		
		</div><!-- END MAIN -->

<?php include('sidebar.php'); ?>
		
<?php include('footer.php'); ?>