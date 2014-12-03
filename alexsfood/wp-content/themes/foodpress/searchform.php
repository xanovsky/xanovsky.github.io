<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<input type="text" name="s" id="s" value="<?php _e('Search here..', 'FoodPress'); ?>" onfocus='if (this.value == "Search here..") { this.value = ""; }' onblur='if (this.value == "") { this.value = "Search here.."; }' />
	<input type="image" src="<?php echo get_template_directory_uri(); ?>/images/search-button.png" value="" id="search-button">
</form>