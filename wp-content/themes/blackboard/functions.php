<?php			

if ( ! isset( $content_width ) ) $content_width = 460;

/* Disable PHP error reporting for notices, leave only the important ones 
================================== */

// error_reporting(E_ERROR | E_PARSE);

/**
 * Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 */

if ( ! function_exists( 'academia_setup' ) ) :
/**
 * Theme setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 */
function academia_setup() {
    // This theme styles the visual editor to resemble the theme style.
    add_editor_style( array( 'css/editor-style.css' ) );

	add_image_size( 'thumb-academia-slideshow', 710, 350, true );
	add_image_size( 'thumb-loop-gallery', 217, 135, true );
	add_image_size( 'thumb-loop-main', 100, 60, true );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );

	/* Add support for Custom Background 
	==================================== */
	
	add_theme_support( 'custom-background' );
	
	/* Add support for post and comment RSS feed links in <head>
	==================================== */
	
	add_theme_support( 'automatic-feed-links' ); 

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

	/* Add support for Localization
	==================================== */
	
	load_theme_textdomain( 'academia_textdomain', get_template_directory() . '/languages' );
	
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable($locale_file) )
		require_once($locale_file);

	// Register nav menus
    register_nav_menus( array(
        'primary' => __( 'Main Menu', 'academia_textdomain' ),
		'secondary' => __( 'Secondary (Top) Menu', 'academia_textdomain' )
    ) );
}
endif;
add_action( 'after_setup_theme', 'academia_setup' );

/* Add javascripts and CSS used by the theme 
================================== */

function academia_js_scripts() {

	// Theme stylesheet.
	wp_enqueue_style( 'blackboard-style', get_stylesheet_uri() );

	if (! is_admin()) {

		wp_enqueue_script(
			'superfish',
			get_template_directory_uri() . '/js/superfish.js',
			array('jquery'),
			null
		);
		wp_enqueue_script(
			'slicknav',
			get_template_directory_uri() . '/js/jquery.slicknav.min.js',
			array('jquery'),
			null
		);
		wp_enqueue_script(
			'flexslider',
			get_template_directory_uri() . '/js/jquery.flexslider-min.js',
			array('jquery'),
			null
		);
		wp_enqueue_script(
			'scripts',
			get_template_directory_uri() . '/js/scripts.js',
			array('jquery'),
			null
		);

		wp_enqueue_script('thickbox', null,  array('jquery'), null);
		wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, null);
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

		// Loads our default Google Webfont
		wp_enqueue_style( 'academia-webfonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,700', array(), null, null );
		
	}

}
add_action('wp_enqueue_scripts', 'academia_js_scripts');

if ( ! function_exists( 'academia_get_the_archive_title' ) ) :
/* Custom Archives titles.
=================================== */
function academia_get_the_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    }

    return $title;
}
endif;
add_filter( 'get_the_archive_title', 'academia_get_the_archive_title' );

/* Enable Excerpts for Static Pages
==================================== */

add_action( 'init', 'academia_excerpts_for_pages' );

function academia_excerpts_for_pages() {
	add_post_type_support( 'page', 'excerpt' );
}

/* Custom Excerpt Length
==================================== */

function new_excerpt_length($length) {
	return 25;
}
add_filter('excerpt_length', 'new_excerpt_length');

/* Replace invalid ellipsis from excerpts
==================================== */

function academia_excerpt( $more ) {
	return '...';
}
add_filter('excerpt_more', 'academia_excerpt');

/* Reset [gallery] shortcode styles						
==================================== */

add_filter('gallery_style', create_function('$a', 'return "<div class=\'gallery\'>";'));

/* Include WordPress Theme Customizer
================================== */

require_once('academia-admin/academia-customizer.php');

/* Include Additional Options and Components
================================== */

require_once('academia-admin/components/get-the-image.php');
require_once('academia-admin/components/wpml.php'); // enables support for WPML plug-in
require_once('academia-admin/custom-post-types.php'); // important to load this before post-options.php
require_once('academia-admin/post-options.php');
require_once('academia-admin/sidebars.php');

require_once('academia-admin/widgets/contacts.php');
require_once('academia-admin/widgets/custommenu.php');
require_once('academia-admin/widgets/recent-comments.php');
require_once('academia-admin/widgets/recent-events.php');
require_once('academia-admin/widgets/recent-posts.php');
require_once('academia-admin/widgets/testimonials.php');

/*----------------------------------*/
/* Breadcrumbs						*/
/*----------------------------------*/

function academia_breadcrumbs() {
 
  $delimiter = '<span class="separator"> / </span>';
  $name = __('Home','academia_textdomain'); //text for the 'Home' link
  $currentBefore = '<span class="current">';
  $currentAfter = '</span>';
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    global $post;
    $home = home_url( '/' );
    echo '<a href="' . esc_url($home) . '">' . $name . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore . '';
      single_cat_title();
      echo '' . $currentAfter;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;
 
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
 
    } elseif ( is_single() && get_post_type( get_the_ID() ) == 'post' ) {
      if (!is_attachment()) {
      $cat = get_the_category(); $cat = $cat[0];
      if ($cat) {
	  	echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
	  }
      echo $currentBefore;
      the_title();
      echo $currentAfter; }

    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_search() ) {
      echo $currentBefore . __('Search results for &#39;', 'academia_textdomain') . get_search_query() . '&#39;' . $currentAfter;
 
    } elseif ( is_tag() ) {
      echo $currentBefore . __('Posts tagged &#39;', 'academia_textdomain');
      single_tag_title();
      echo '&#39;' . $currentAfter;
      
    } elseif ( is_tax() ) {
      echo $currentBefore;
      single_cat_title();
      echo $currentAfter;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . __('Articles posted by ', 'academia_textdomain') . $userdata->display_name . $currentAfter;
 
    } elseif ( is_404() ) {
      echo $currentBefore . __('Error 404', 'academia_textdomain') . $currentAfter;
    }
 
    if ( get_query_var('paged') && get_query_var('paged') > 1 ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_tax() ) echo ' (';
      echo __('Page', 'academia_textdomain') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_tax() ) echo ')';
    }
  
  }
}

/* Comments Custom Template						
==================================== */

function academia_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>">
				
					<div class="comment-author vcard">
						<?php echo get_avatar( $comment, 50 ); ?>

						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div><!-- .reply -->

					</div><!-- .comment-author .vcard -->
	
					<div class="comment-body">
	
						<?php printf( __( '%s', 'academia_textdomain' ), sprintf( '<cite class="comment-author-name">%s</cite>', get_comment_author_link() ) ); ?>
						<span class="comment-timestamp"><?php printf( __('%s at %s', 'academia_textdomain'), get_comment_date(), get_comment_time()); ?></span><?php edit_comment_link( __( 'Edit', 'academia_textdomain' ), ' <span class="comment-bullet">&#8226;</span> ' ); ?>
	
						<div class="comment-content">
						<?php if ( $comment->comment_approved == '0' ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'academia_textdomain' ); ?></p>
						<?php endif; ?>
	
						<?php comment_text(); ?>
						</div><!-- .comment-content -->

					</div><!-- .comment-body -->
	
					<div class="cleaner">&nbsp;</div>
				
				</div><!-- #comment-<?php comment_ID(); ?> -->
		
			</li><!-- #li-comment-<?php comment_ID(); ?> -->
		
			<?php
		break;

		case 'pingback'  :
		case 'trackback' :
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<p><?php _e( 'Pingback:', 'academia_textdomain' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'academia_textdomain' ), ' ' ); ?></p>
			</li>
			<?php
		break;
	
	endswitch;
}

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function academia_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'academia_textdomain' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'academia_wp_title', 10, 2 );

/* Display a separate search results template for custom post type searches
================================== */

function academia_custom_search($template) {
	global $wp_query;   
	$post_type = get_query_var('post_type');
	
	if ( $wp_query->is_search && $post_type == 'course' ) {
		return locate_template('search-courses.php'); // redirect to search-courses.php
	} elseif ( $wp_query->is_search && $post_type == 'staff' ) {
		return locate_template('search-staff.php'); // redirect to search-staff.php
	}
	return $template;   
}
add_filter('template_include', 'academia_custom_search');

/* Include Theme Options Page for Admin
================================== */

//require only in admin!
if(is_admin()){	
	require_once('academia-admin/academia-theme-settings.php');
}

/**
 * Collects our theme options
 *
 * @return array
 */
function academia_get_global_options(){
	
	$academia_option = array();

	// collect option names as declared in academia_get_settings()
	$academia_option_name = 'academia_options';

	// loop for get_option
	if (get_option($academia_option_name)!= FALSE) {
		$option = get_option($academia_option_name);
		
		// now merge in main $academia_option array!
		$academia_option = array_merge($academia_option, $option);
	}

	
return $academia_option;
}

/**
 * Call the function and collect in variable
 *
 * Should be used in template files like this:
 * echo $academia_option['academia_txt_input'];
 *
 * Note: Should you notice that the variable ($academia_option) is empty when used in certain templates such as header.php, sidebar.php and footer.php
 * you will need to call the function (copy the line below and paste it) at the top of those documents (within php tags)!
 */ 
$academia_option = academia_get_global_options();