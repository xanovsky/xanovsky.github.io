<?php include('header.php'); ?>
	
	<div id="title-wrapper">
	
		<div id="title">
	
			<div class="title-text archive">
				<h1>Page Not Found</h1>
			</div>
			
		</div>
	
	</div>

	<div id="crumbs-wrapper">
			
		<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
			
	</div>
	
	<div id="wrapper">
	
		<div id="main">
		
			<div id="post">
				
				<div class="entry404">
					<img src="<?php echo get_template_directory_uri(); ?>/images/404.png" alt="404" />
					<div class="text404">
						<p>Sorry, the page you are looking for could not be found</p>
					</div>
				</div>
		
			</div>
		
		</div><!-- END MAIN -->

<?php include('sidebar.php'); ?>
		
<?php include('footer.php'); ?>