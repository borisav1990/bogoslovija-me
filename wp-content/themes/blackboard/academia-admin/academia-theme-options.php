<?php
/**
 * Define our settings sections
 *
 * array key=$id, array value=$title in: add_settings_section( $id, $title, $callback, $page );
 * @return array
 */
function academia_options_page_sections() {
	
	$sections = array();
	$sections['general_section'] 	= __('General Settings', 'academia_textdomain');
	$sections['homepage_section'] 	= __('Homepage Settings', 'academia_textdomain');
	// $sections['social_section'] 	= __('Social Media', 'academia_textdomain');
	$sections['misc_section'] 		= __('Miscellaneous', 'academia_textdomain');
	// $sections['banners_section']	= __('Banners', 'academia_textdomain');
	$sections['debug_section'] 		= __('Debug Information', 'academia_textdomain');
	
	return $sections;	
} 

/**
 * Define our form fields (settings) 
 *
 * @return array
 */
function academia_options_page_fields() {

    // Load categories and static pages in two separate arrays
	$categories =  get_categories('hide_empty=0'); // load list of categories
    $pages =  get_pages(''); // load list of categories
	$options_categories = array();
	$options_pages = array();
    
    // Create associative arrays with:
    // key = category/page ID
    // value = category/page Name
    
	foreach ($categories as $category) {
    	$options_categories[] = $category->name . "|" .$category->term_id;
	}
	
	foreach ($pages as $page) {
    	$options_pages[] = $page->post_title . "|" .$page->ID; 
	}
	
	$academia_options = academia_get_global_options();
	
	$options[] = array(
		"section" => "general_section",
		"id"      => ACADEMIA_SHORTNAME . "_custom_css",
		"title"   => __( 'Load custom.css file', 'academia_textdomain' ),
		"desc"    => __( 'Check this box if you want to load the custom.css file in the header of the theme.', 'academia_textdomain' ),
		"type"    => "checkbox",
		"std"     => 0 // 0 for off
	);

	$options[] = array(
		"section" => "general_section",
		"id"      => ACADEMIA_SHORTNAME . "_footer_sidebars_display",
		"title"   => __( 'Display Footer Widget Columns', 'academia_textdomain' ),
		"desc"    => __( 'Check if you want to display the footer widget columns (sidebars).', 'academia_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "general_section",
		"id"      => ACADEMIA_SHORTNAME . "_footer_logo_display",
		"title"   => __( 'Footer Logo', 'academia_textdomain' ),
		"desc"    => __( 'Check if you want to display an alternative logo in the footer.', 'academia_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "general_section",
		"id"   => 5,
		"title"   => '',
		"desc"    => '',
		"type"    => "divider",
		"std"     => '' // 0 for off
	);

	$options[] = array(
		"section" => "general_section",
		"id"      => ACADEMIA_SHORTNAME . "_courses_perpage",
		"title"   => __( 'Number of Courses per Page', 'academia_textdomain' ),
		"desc"    => __( 'Number of courses that will be shown per archive page.', 'academia_textdomain' ),
		"type"    => "text",
		"std"     => 20,
		"class"   => "numeric"
	);

	$options[] = array(
		"section" => "general_section",
		"id"      => ACADEMIA_SHORTNAME . "_staff_perpage",
		"title"   => __( 'Number of Staff Members per Page', 'academia_textdomain' ),
		"desc"    => __( 'Number of staff members that will be shown per archive page.', 'academia_textdomain' ),
		"type"    => "text",
		"std"     => 20,
		"class"   => "numeric"
	);

	// Homepage Options 

	$options[] = array(
		"section" => "homepage_section",
		"id"      => ACADEMIA_SHORTNAME . "_gallery_page_num",
		"title"   => __( 'Number of Featured Posts to Display', 'academia_textdomain' ),
		"desc"    => __( 'How many featured posts to display in the homepage slideshow.', 'academia_textdomain' ),
		"type"    => "text",
		"std"     => 5,
		"class"   => "numeric"
	);

	$options[] = array(
		"section" => "homepage_section",
		"id"      => ACADEMIA_SHORTNAME . "_gallery_autoplay",
		"title"   => __( 'Enable Slideshow Autoplay', 'academia_textdomain' ),
		"desc"    => __( 'Check this box if you want to enable autoplay for the homepage slideshow.', 'academia_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "homepage_section",
		"id"      => ACADEMIA_SHORTNAME . "_gallery_autoplay_speed",
		"title"   => __( 'Slideshow Autoplay Speed', 'academia_textdomain' ),
		"desc"    => __( 'In miliseconds. 1 second = 1000 miliseconds.', 'academia_textdomain' ),
		"type"    => "text",
		"std"     => 5000,
		"class"   => "numeric"
	);

	$options[] = array(
		"section" => "homepage_section",
		"id"   => 20,
		"title"   => '',
		"desc"    => '',
		"type"    => "divider",
		"std"     => '' // 0 for off
	);

	$options[] = array(
		"section" => "social_section",
		"id"      => ACADEMIA_SHORTNAME . "_social_sharing_posts",
		"title"   => __( 'Social Sharing: Posts', 'academia_textdomain' ),
		"desc"    => __( 'Check this box if you want to display social sharing buttons (Facebook, Twitter, etc.) for Posts.', 'academia_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "social_section",
		"id"      => ACADEMIA_SHORTNAME . "_social_sharing_pages",
		"title"   => __( 'Social Sharing: Pages', 'academia_textdomain' ),
		"desc"    => __( 'Check this box if you want to display social sharing buttons (Facebook, Twitter, etc.) for Pages.', 'academia_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "social_section",
		"id"      => ACADEMIA_SHORTNAME . "_social_sharing_courses",
		"title"   => __( 'Social Sharing: Courses', 'academia_textdomain' ),
		"desc"    => __( 'Check this box if you want to display social sharing buttons (Facebook, Twitter, etc.) for Courses.', 'academia_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "social_section",
		"id"      => ACADEMIA_SHORTNAME . "_social_sharing_events",
		"title"   => __( 'Social Sharing: Events', 'academia_textdomain' ),
		"desc"    => __( 'Check this box if you want to display social sharing buttons (Facebook, Twitter, etc.) for Events.', 'academia_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "social_section",
		"id"      => ACADEMIA_SHORTNAME . "_social_sharing_staff",
		"title"   => __( 'Social Sharing: Staff', 'academia_textdomain' ),
		"desc"    => __( 'Check this box if you want to display social sharing buttons (Facebook, Twitter, etc.) for Staff.', 'academia_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "social_section",
		"id"      => ACADEMIA_SHORTNAME . "_social_sharing_testimonials",
		"title"   => __( 'Social Sharing: Testimonials', 'academia_textdomain' ),
		"desc"    => __( 'Check this box if you want to display social sharing buttons (Facebook, Twitter, etc.) for Testimonials.', 'academia_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "misc_section",
		"id"      => ACADEMIA_SHORTNAME . "_script_header",
		"title"   => __( 'Custom Code Before &lt;/head&gt;', 'academia_textdomain' ),
		"desc"    => __( 'Here you can add HTML/JS code that will be added right before &lt;/head&gt;. <br />For example here you can add the tracking code provided by Google Analytics.', 'academia_textdomain' ),
		"type"    => "textarea",
		"std"     => '',
		"class"   => 'allowall'
	);

	$options[] = array(
		"section" => "misc_section",
		"id"      => ACADEMIA_SHORTNAME . "_script_footer",
		"title"   => __( 'Custom Code Before &lt;/body&gt;', 'academia_textdomain' ),
		"desc"    => __( 'Here you can add HTML/JS code that will be added right before &lt;/body&gt;.', 'academia_textdomain' ),
		"type"    => "textarea",
		"std"     => '',
		"class"   => 'allowall'
	);

	$options[] = array(
		"section" => "misc_section",
		"id"      => ACADEMIA_SHORTNAME . "_breadcrumbs",
		"title"   => __( 'Display Breadcrumbs', 'academia_textdomain' ),
		"desc"    => __( 'Check this box if you want to display automatic breadcrumbs on all pages.', 'academia_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "misc_section",
		"id"      => ACADEMIA_SHORTNAME . "_page_comments",
		"title"   => __( 'Display Comments for Pages', 'academia_textdomain' ),
		"desc"    => __( 'Check this box if you want to display comments and submit comment form inside pages.', 'academia_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "misc_section",
		"id"      => ACADEMIA_SHORTNAME . "_post_comments",
		"title"   => __( 'Display Comments for Posts', 'academia_textdomain' ),
		"desc"    => __( 'Check this box if you want to display comments and submit comment form inside posts.', 'academia_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "misc_section",
		"id"      => ACADEMIA_SHORTNAME . "_misc_credit",
		"title"   => __( 'Credit AcademiaThemes in Footer', 'academia_textdomain' ),
		"desc"    => __( 'Leave this box checked if you want to keep "Designed by AcademiaThemes" in the footer. Keeping this box checked will make us very happy.', 'academia_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "debug_section",
		"id"      => ACADEMIA_SHORTNAME . "_debug",
		"title"   => __( 'Debugging information', 'academia_textdomain' ),
		"desc"    => __( '', 'academia_textdomain' ),
		"type"    => "debug"
	);
	
	return $options;	
}

/**
 * Contextual Help
 */
function academia_options_page_contextual_help() {
	
	$text 	= "<h3>" . __('Academia Theme Options - Contextual Help','academia_textdomain') . "</h3>";
	$text 	.= "<p>" . __('If you are experiencing problems with our theme, please consult our <a href="http://www.academiathemes.com/support/">Support Section</a>.','academia_textdomain') . "</p>";
	
	// must return text! NOT echo
	return $text;
} ?>