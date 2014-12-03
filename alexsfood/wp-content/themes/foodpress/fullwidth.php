<?php

	/* Template Name: Full Width Page */

	get_header(); 

?>

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
	
	<div class="wrapper-full">
	
		<div class="main-full">
		
			<div id="post">
				
				<div class="post-content full">
				
					<?php the_content(); ?>
					
				</div>
		
			</div>

			<?php endwhile; endif; ?>
		
		</div><!-- END MAIN -->
		
<?php include('footer.php'); ?>