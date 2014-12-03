	
	</div><!-- END WRAPPER -->
	
	<div id="footer-wrapper">
	
		<div id="footer">
		
			<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 1') ) ?>
			
			<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 2') ) ?>
			
			<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 3') ) ?>
			
			<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 4') ) ?>
		
		</div>
	
	</div><!-- END FOOTER-WRAPPER -->
	
	<div id="footer-bottom-wrapper">
	
		<div id="footer-bottom">
		
			<span class="footer-left"><?php echo get_option('fp_footer-text-left'); ?></span>
			<span class="footer-right"><?php echo get_option('fp_footer-text-right'); ?></span>
		
		</div>
	
	</div>
	
	<?php wp_footer(); ?>
	<?php $google_analytics = get_option('fp_google_analytics'); if ($google_analytics) { echo stripslashes($google_analytics); } ?>
</body>

</html>