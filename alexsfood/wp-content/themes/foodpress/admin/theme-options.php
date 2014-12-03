<?php

add_action('init','of_options');

if (!function_exists('of_options')) {
function of_options(){
	
// VARIABLES
$themename = get_theme_data(STYLESHEETPATH . '/style.css');
$themename = $themename['Name'];
$shortname = "fp";

// Populate OptionsFramework option in array for use in theme
global $of_options;
$of_options = get_option('of_options');

$GLOBALS['template_path'] = OF_DIRECTORY;

//Access the WordPress Categories via an Array
$of_categories = array();  
$of_categories_obj = get_categories('hide_empty=0');
foreach ($of_categories_obj as $of_cat) {
    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
$categories_tmp = array_unshift($of_categories, "Select a category:");    
       
//Access the WordPress Pages via an Array
$of_pages = array();
$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($of_pages_obj as $of_page) {
    $of_pages[$of_page->ID] = $of_page->post_name; }
$of_pages_tmp = array_unshift($of_pages, "Select a page:");       

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

// Image Links to Options
$options_image_link_to = array("image" => "The Image","post" => "The Post"); 

//Testing 
$options_select = array("one","two","three","four","five"); 
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 

//Stylesheets Reader
$alt_stylesheet_path = OF_FILEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//More Options
$uploads_arr = wp_upload_dir();
$all_uploads_path = $uploads_arr['path'];
$all_uploads = get_option('of_uploads');
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

$imagepath =  get_bloginfo('stylesheet_directory') . '/admin/images/';

// Set the Options Array
$options = array();

$options[] = array( "name" => "General Settings",
                    "type" => "heading");

$options[] = array( "name" => "Custom Logo",
					"desc" => "Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)",
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload"); 
					
$options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload"); 
                                               
$options[] = array( "name" => "Tracking Code",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");
				
$options[] = array( "name" => "Header Banner",
					"desc" => "Enter your banner code (Eg. Google Adsense) - Best ad size 468x60px.",
					"id" => $shortname."_header_banner",
					"std" => "",
					"type" => "textarea");
					
$options[] = array( "name" => "Feedburner URL",
					"desc" => "Enter your FeedBurner ID",
					"id" => $shortname."_feedburner",
					"std" => "",
					"type" => "text");
				
$options[] = array( "name" => "Homepage Settings",
                    "type" => "heading");
					
$options[] = array( "name" => "Featured slider tags",
					"desc" => "Posts with tags in this field will show up on homepage featured posts slider. Separate tags by comma.",
					"id" => $shortname."_slider_tags",
					"std" => "",
					"type" => "text");
				
$options[] = array( "name" => "Slider Effect",
					"desc" => "Choose the effect you want the slider to use.",
					"id" => $shortname."_slider_effect",
					"std" => "random",
					"type" => "select",
					"options" => array("random","sliceDown","sliceDownLeft","sliceUp","sliceUpLeft","sliceUpDown","sliceUpDownLeft","fold","fade","slideInRight","slideInLeft","boxRandom","boxRain","boxRainReverse","boxRainGrow","boxRainGrowReverse"));
				
$options[] = array( "name" => "Slider Pause Time",
					"desc" => "Set the time for how long each slide will show (in milliseconds)",
					"id" => $shortname."_slider_time",
					"std" => "4000",
					"type" => "text");
				
$options[] = array( "name" => "Homepage Layout",
						"desc" => "Choose the layout for your homepage",
						"id" => $shortname."_homepage_layout",
						"std" => "small-items",
						"type" => "images",
						"options" => array(
							'small-items' => $imagepath . 'small-items.png',
							'big-items' => $imagepath . 'big-items.png',
							'grid-items' => $imagepath . 'grid-items.png')
						);
						
$options[] = array( "name" => "Appearance Options",
					"type" => "heading");
					
$options[] = array( "name" => "Navigation Background",
						"desc" => "Enter a color for the main navigation background",
						"id" => $shortname."_navi_bg",
						"std" => "#f8560e",
						"type" => "color");
						
$options[] = array( "name" => "Navigation Link Color",
						"desc" => "Enter a color for the main navigation link color",
						"id" => $shortname."_navi_link",
						"std" => "#FFFFFF",
						"type" => "color");
						
$options[] = array( "name" => "Navigation Link Text-Shadow",
						"desc" => "Enter a color for the main navigation link text-shadow",
						"id" => $shortname."_navi_shadow",
						"std" => "#9e3709",
						"type" => "color");
						
$options[] = array( "name" => "Link Color",
						"desc" => "Enter a color for the link color",
						"id" => $shortname."_link_color",
						"std" => "#f8560e",
						"type" => "color");
						
$options[] = array( "name" => "Archive Options",
					"type" => "heading");
					
$options[] = array( "name" => "Archive Layout",
						"desc" => "Choose the layout for your archive pages (eg. categories, tags)",
						"id" => $shortname."_archive_layout",
						"std" => "small-items",
						"type" => "images",
						"options" => array(
							'small-items' => $imagepath . 'small-items.png',
							'big-items' => $imagepath . 'big-items.png',
							'grid-items' => $imagepath . 'grid-items.png')
						);
    
$options[] = array( "name" => "Footer Options",
					"type" => "heading");
					
$options[] = array( "name" => "Footer Text Left",
					"desc" => "Here you can enter any text you want (eg. copyright text)",
					"id" => $shortname."_footer-text-left",
					"std" => "Copyright &copy; 2011 - FoodPress. All rights reserved.",
					"type" => "text");
				
$options[] = array( "name" => "Footer Text Right",
					"desc" => "Here you can enter any text you want",
					"id" => $shortname."_footer-text-right",
					"std" => "Web design by Sebastian Rosenkvist",
					"type" => "text");
				
$options[] = array( "name" => "Post Options",
					"type" => "heading");
				
$options[] = array( "name" => "Disable Author Box",
					"desc" => "Check to disable the author box",
					"id" => $shortname."_author_box",
					"std" => "false",
					"type" => "checkbox");
					
$options[] = array( "name" => "Disable Related Posts",
					"desc" => "Check to disable the related posts",
					"id" => $shortname."_related_posts",
					"std" => "false",
					"type" => "checkbox");
		
$options[] = array( "name" => "Disable Share Post Box",
					"desc" => "Check to disable the Share Post box",
					"id" => $shortname."_share_post",
					"std" => "false",
					"type" => "checkbox");
				
$options[] = array( "name" => "Share Facebook",
					"desc" => "Uncheck to disable Facebook in the Share Post box",
					"id" => $shortname."_share_post_facebook",
					"std" => "true",
					"type" => "checkbox"); 
				
$options[] = array( "name" => "Share Twitter",
					"desc" => "Uncheck to disable Twitter in the Share Post box",
					"id" => $shortname."_share_post_twitter",
					"std" => "true",
					"type" => "checkbox");
				
$options[] = array( "name" => "Share Google",
					"desc" => "Uncheck to disable Google in the Share Post box",
					"id" => $shortname."_share_post_google",
					"std" => "true",
					"type" => "checkbox");
				
$options[] = array( "name" => "Share Reddit",
					"desc" => "Uncheck to disable Reddit in the Share Post box",
					"id" => $shortname."_share_post_reddit",
					"std" => "false",
					"type" => "checkbox");
				
$options[] = array( "name" => "Share Stumbleupon",
					"desc" => "Uncheck to disable Stumbleupon in the Share Post box",
					"id" => $shortname."_share_post_stumbleupon",
					"std" => "false",
					"type" => "checkbox");
				
$options[] = array( "name" => "Share Digg",
					"desc" => "Uncheck to disable Digg in the Share Post box",
					"id" => $shortname."_share_post_digg",
					"std" => "false",
					"type" => "checkbox");
					
$options[] = array( "name" => "Share Tumblr",
					"desc" => "Uncheck to disable Tumblr in the Share Post box",
					"id" => $shortname."_share_post_tumblr",
					"std" => "false",
					"type" => "checkbox");
				
$options[] = array( "name" => "Share Email",
					"desc" => "Uncheck to disable Email in the Share Post box",
					"id" => $shortname."_share_post_email",
					"std" => "true",
					"type" => "checkbox");
					
$options[] = array( "name" => "Social Media Options",
					"type" => "heading");      

$options[] = array( "name" => "Twitter",
					"desc" => "Enter your Twitter username here.",
					"id" => $shortname."_twitter",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Facebook",
					"desc" => "Enter your Facebook username here.",
					"id" => $shortname."_facebook",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Flickr",
					"desc" => "Enter the full URL to your flickr profile",
					"id" => $shortname."_flickr",
					"std" => "",
					"type" => "text");

update_option('of_template',$options); 					  
update_option('of_themename',$themename);   
update_option('of_shortname',$shortname);

}
}
?>
