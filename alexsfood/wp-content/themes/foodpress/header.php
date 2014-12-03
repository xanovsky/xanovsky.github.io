<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
 
<title><?php bloginfo('name'); ?> <?php wp_title(' - ', true, 'left'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
<?php if(get_option('fp_custom_favicon')) { ?><link rel="shortcut icon" href="<?php echo get_option('fp_custom_favicon'); ?>" /><?php } ?>

<?php if ($tz_feedburner) { ?>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="http://feeds.feedburner.com/<?php echo ($fp_feedburner); ?>" />
<?php } else { ?>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php bloginfo( 'rss2_url' ); ?>" />
<?php } ?>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_enqueue_script('jquery'); ?>
<?php wp_enqueue_script('FoodPress', get_bloginfo('template_directory'). '/js/scripts.js'); ?>
<?php wp_enqueue_script('nivo', get_bloginfo('template_directory'). '/js/jquery.nivo.slider.pack.js'); ?>

<?php wp_head(); ?>

<script type="text/javascript">
jQuery(document).ready(function($) {
    jQuery('#slider').nivoSlider({
        effect:'<?php echo get_option('fp_slider_effect'); ?>', // Specify sets like: 'fold,fade,sliceDown'
        pauseTime:<?php echo get_option('fp_slider_time'); ?>, // How long each slide will show
		captionOpacity:false, // Universal caption opacity
        directionNav:false, // Next & Prev navigation
        directionNavHide:false, // Only show on hover
        controlNavThumbs:true, // Use thumbnails for Control Nav
        controlNavThumbsFromRel:true, // Use image rel for thumbs

    });
});
</script>

<style type='text/css'>
a { color:<?php echo get_option('fp_link_color'); ?>; }
#navigation-wrapper { background:<?php echo get_option('fp_navi_bg'); ?> url(<?php echo get_template_directory_uri(); ?>/images/navigation-bg.png) repeat-x;}
#navigation li.current-menu-item a {  background:<?php echo get_option('fp_navi_bg'); ?> url(<?php echo get_template_directory_uri(); ?>/images/navi-current-bg.png) repeat-x;}
#navigation li.current-menu-item .right-line { background:<?php echo get_option('fp_navi_bg'); ?> url(<?php echo get_template_directory_uri(); ?>/images/navi-line.png) repeat-y right}
#navigation li a { color:<?php echo get_option('fp_navi_link'); ?>; font-size:15px; text-shadow: 1px 1px 1px <?php echo get_option('fp_navi_shadow'); ?>; }
</style>

</head>

<body <?php body_class($class); ?>>

	

<div id="top-header-wrapper">
	
		<div id="top-header">
	
			<div id="top-navigation">
			
				<ul>
					<?php wp_nav_menu( array( 'container' => false, 'theme_location' => 'top-menu' ) ); ?>
				</ul>
			
			</div>
			
			<div id="search-wrapper">
				<?php get_search_form(); ?>
			</div>
	
		</div>
	
	</div>

	<div id="header-wrapper">
	
		<div id="header">
			
			<div id="logo">
				<?php if(get_option('fp_logo')) { ?>
				<a href="<?php echo home_url(); ?>"><img src="<?php echo get_option('fp_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
				<?php } else { ?>
				<a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" /></a>
				<?php } ?>
			</div>
			
			<?php if(get_option('fp_header_banner')) { ?>
			<div id="header-banner">
				<?php echo get_option('fp_header_banner'); ?>
			</div>
			<?php } ?>
			
		</div>
	
	</div><!-- END HEADER-WRAPPER -->
	
	<div id="navigation-wrapper">
	
		<div id="navigation">
		
			<ul>
				<?php wp_nav_menu( array( 'container' => false, 'theme_location' => 'primary-menu' ) ); ?>
			</ul>
		
		</div>
	
	</div><!-- END NAVIGATION-WRAPPER -->
	
	