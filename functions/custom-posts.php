<?php
/**!
 * Custom Post type
 */

// Register Custom Post Type Journey
// Post Type Key: journey
function create_journey_cpt() {

	$labels = array(
		'name' => __( 'Journeys', 'Post Type General Name', 'Roundglass Journeys' ),
		'singular_name' => __( 'Journey', 'Post Type Singular Name', 'Roundglass Journeys' ),
		'menu_name' => __( 'Journeys', 'Roundglass Journeys' ),
		'name_admin_bar' => __( 'Journey', 'Roundglass Journeys' ),
		'archives' => __( 'Journey Archives', 'Roundglass Journeys' ),
		'attributes' => __( 'Journey Attributes', 'Roundglass Journeys' ),
		'parent_item_colon' => __( 'Parent Journey:', 'Roundglass Journeys' ),
		'all_items' => __( 'All Journeys', 'Roundglass Journeys' ),
		'add_new_item' => __( 'Add New Journey', 'Roundglass Journeys' ),
		'add_new' => __( 'Add New', 'Roundglass Journeys' ),
		'new_item' => __( 'New Journey', 'Roundglass Journeys' ),
		'edit_item' => __( 'Edit Journey', 'Roundglass Journeys' ),
		'update_item' => __( 'Update Journey', 'Roundglass Journeys' ),
		'view_item' => __( 'View Journey', 'Roundglass Journeys' ),
		'view_items' => __( 'View Journeys', 'Roundglass Journeys' ),
		'search_items' => __( 'Search Journey', 'Roundglass Journeys' ),
		'not_found' => __( 'Not found', 'Roundglass Journeys' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'Roundglass Journeys' ),
		'featured_image' => __( 'Featured Image', 'Roundglass Journeys' ),
		'set_featured_image' => __( 'Set featured image', 'Roundglass Journeys' ),
		'remove_featured_image' => __( 'Remove featured image', 'Roundglass Journeys' ),
		'use_featured_image' => __( 'Use as featured image', 'Roundglass Journeys' ),
		'insert_into_item' => __( 'Insert into Journey', 'Roundglass Journeys' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Journey', 'Roundglass Journeys' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Journey', 'Roundglass Journeys' ),
		'items_list' => __( 'Journeys list', 'Roundglass Journeys' ),
		'items_list_navigation' => __( 'Journeys list navigation', 'Roundglass Journeys' ),
		'filter_items_list' => __( 'Filter Journeys list', 'Roundglass Journeys' ),
	);
	$args = array(
		'label' => __( 'Journey', 'Roundglass Journeys' ),
		'description' => __( 'Roundglass Journeys', 'Roundglass Journeys' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-filter',
		'supports' => array('title' ),
		'taxonomies' => array(),
		//'taxonomies' => array('post_tag'),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		//'menu_position' => 2,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		//'taxonomies'  => array( 'category' ),
		'capability_type' => 'post',
	);
	register_post_type( 'journey', $args );

}
add_action( 'init', 'create_journey_cpt', 0 );

// Post Type Key: experience
function create_experience_cpt() {

	$labels = array(
		'name' => __( 'Experiences', 'Post Type General Name', 'Roundglass Journeys' ),
		'singular_name' => __( 'Experience', 'Post Type Singular Name', 'Roundglass Journeys' ),
		'menu_name' => __( 'Experiences', 'Roundglass Journeys' ),
		'name_admin_bar' => __( 'Experience', 'Roundglass Journeys' ),
		'archives' => __( 'Experience Archives', 'Roundglass Journeys' ),
		'attributes' => __( 'Experience Attributes', 'Roundglass Journeys' ),
		'parent_item_colon' => __( 'Parent Experience:', 'Roundglass Journeys' ),
		'all_items' => __( 'All Experiences', 'Roundglass Journeys' ),
		'add_new_item' => __( 'Add New Experience', 'Roundglass Journeys' ),
		'add_new' => __( 'Add New', 'Roundglass Journeys' ),
		'new_item' => __( 'New Experience', 'Roundglass Journeys' ),
		'edit_item' => __( 'Edit Experience', 'Roundglass Journeys' ),
		'update_item' => __( 'Update Experience', 'Roundglass Journeys' ),
		'view_item' => __( 'View Experience', 'Roundglass Journeys' ),
		'view_items' => __( 'View Experiences', 'Roundglass Journeys' ),
		'search_items' => __( 'Search Experience', 'Roundglass Journeys' ),
		'not_found' => __( 'Not found', 'Roundglass Journeys' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'Roundglass Journeys' ),
		'featured_image' => __( 'Featured Image', 'Roundglass Journeys' ),
		'set_featured_image' => __( 'Set featured image', 'Roundglass Journeys' ),
		'remove_featured_image' => __( 'Remove featured image', 'Roundglass Journeys' ),
		'use_featured_image' => __( 'Use as featured image', 'Roundglass Journeys' ),
		'insert_into_item' => __( 'Insert into Experience', 'Roundglass Journeys' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Experience', 'Roundglass Journeys' ),
		'items_list' => __( 'Experiences list', 'Roundglass Journeys' ),
		'items_list_navigation' => __( 'Experiences list navigation', 'Roundglass Journeys' ),
		'filter_items_list' => __( 'Filter Experiences list', 'Roundglass Journeys' ),
	);
	$args = array(
		'label' => __( 'Experience', 'Roundglass Journeys' ),
		'description' => __( 'Roundglass Journeys', 'Roundglass Journeys' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-location',
		'supports' => array('title', 'revisions' ),
		//'supports' => array('title', 'thumbnail', 'revisions', 'author', 'page-attributes', ),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		//'menu_position' => 4,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => true,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'experience', $args );

}
add_action( 'init', 'create_experience_cpt', 0 );

// Register Custom Post Type Banner
// Post Type Key: banner
// function create_banner_cpt() {

// 	$labels = array(
// 		'name' => __( 'Banners', 'Post Type General Name', 'Roundglass Journeys' ),
// 		'singular_name' => __( 'Banner', 'Post Type Singular Name', 'Roundglass Journeys' ),
// 		'menu_name' => __( 'Banners', 'Roundglass Journeys' ),
// 		'name_admin_bar' => __( 'Banner', 'Roundglass Journeys' ),
// 		'archives' => __( 'Banner Archives', 'Roundglass Journeys' ),
// 		'attributes' => __( 'Banner Attributes', 'Roundglass Journeys' ),
// 		'parent_item_colon' => __( 'Parent Banner:', 'Roundglass Journeys' ),
// 		'all_items' => __( 'All Banners', 'Roundglass Journeys' ),
// 		'add_new_item' => __( 'Add New Banner', 'Roundglass Journeys' ),
// 		'add_new' => __( 'Add New', 'Roundglass Journeys' ),
// 		'new_item' => __( 'New Banner', 'Roundglass Journeys' ),
// 		'edit_item' => __( 'Edit Banner', 'Roundglass Journeys' ),
// 		'update_item' => __( 'Update Banner', 'Roundglass Journeys' ),
// 		'view_item' => __( 'View Banner', 'Roundglass Journeys' ),
// 		'view_items' => __( 'View Banners', 'Roundglass Journeys' ),
// 		'search_items' => __( 'Search Banner', 'Roundglass Journeys' ),
// 		'not_found' => __( 'Not found', 'Roundglass Journeys' ),
// 		'not_found_in_trash' => __( 'Not found in Trash', 'Roundglass Journeys' ),
// 		'featured_image' => __( 'Featured Image', 'Roundglass Journeys' ),
// 		'set_featured_image' => __( 'Set featured image', 'Roundglass Journeys' ),
// 		'remove_featured_image' => __( 'Remove featured image', 'Roundglass Journeys' ),
// 		'use_featured_image' => __( 'Use as featured image', 'Roundglass Journeys' ),
// 		'insert_into_item' => __( 'Insert into Banner', 'Roundglass Journeys' ),
// 		'uploaded_to_this_item' => __( 'Uploaded to this Banner', 'Roundglass Journeys' ),
// 		'items_list' => __( 'Banners list', 'Roundglass Journeys' ),
// 		'items_list_navigation' => __( 'Banners list navigation', 'Roundglass Journeys' ),
// 		'filter_items_list' => __( 'Filter Banners list', 'Roundglass Journeys' ),
// 	);
// 	$args = array(
// 		'label' => __( 'Banner', 'Roundglass Journeys' ),
// 		'description' => __( 'Roundglass Journeys Banner', 'Roundglass Journeys' ),
// 		'labels' => $labels,
// 		'menu_icon' => 'dashicons-category',
// 		//'supports' => array('title', 'thumbnail', 'revisions', 'author', 'page-attributes', ),
// 		'supports' => array('title'),
// 		'taxonomies' => array(),
// 		'public' => false,
// 		'show_ui' => true,
// 		'show_in_menu' => true,
// 		//'menu_position' => 5,
// 		'show_in_admin_bar' => true,
// 		'show_in_nav_menus' => true,
// 		'can_export' => true,
// 		'has_archive' => true,
// 		'hierarchical' => false,
// 		'exclude_from_search' => false,
// 		'show_in_rest' => true,
// 		'publicly_queryable' => true,
// 		/*'capabilities' => array(
// 			'create_posts' => 'do_not_allow', 
// 	   ),*/
// 		'capability_type' => 'post',
// 	);
// 	register_post_type( 'banner', $args );

// }
// add_action( 'init', 'create_banner_cpt', 0 );

// add_filter( 'template_include', 'include_banner_function', 1 );
// //Banner template 
// function include_banner_function( $template_path ) {   
// 	if ( get_post_type() == 'banner' ) {
// 		if ( is_single() ) {  
// 		   if ( $theme_file = locate_template( array ( 'single-templates/single-banner.php' ) ) ) { 
// 			   $template_path = $theme_file; 
// 		   } 
// 		}
// 				$theme_file = locate_template( array ( 'single-templates/single-banner.php' ) );
// 			  	$template_path = $theme_file;
// 	}
// 	return $template_path;
// }

/* Journey template */
add_filter( 'template_include', 'include_journey_function', 1 );
function include_journey_function( $template_path ) {
     if ( get_post_type() == 'journey' ) { 
         if ( is_single() ) {  
			function journey_script() {
				wp_register_script('journey-js', get_template_directory_uri() . '/theme/js/journey.js', false, null, null);
				wp_enqueue_script('journey-js');
			}
		add_action( 'wp_enqueue_scripts', 'journey_script', 101 );
            if ( $theme_file = locate_template( array ( 'single-templates/single-journey.php' ) ) ) { 
                $template_path = $theme_file; 
            } else { 
	            $template_path = get_template_directory_uri() . 'single-templates/single-journey.php';
            }
         }
	 }
     return $template_path;
}


//Add option pages
// Add Options Page
function add_my_options_page() {
	if( function_exists('acf_add_options_page') ) {
	  acf_add_options_page();
	}
  }
add_action( 'plugins_loaded', 'add_my_options_page' );

if( function_exists('acf_add_options_page') ) {
	/*acf_add_options_page(array(
	 'page_title'  => 'Header Settings',
	 'menu_title'  => 'Header',
	 'menu_slug'   => 'header-settings'
	));
   acf_add_options_page(array(
	 'page_title'  => 'General Settings',
	 'menu_title'  => 'General',
	 'menu_slug'   => 'general-settings'
	));
   acf_add_options_page(array(
	 'page_title'  => 'Footer Settings',
	 'menu_title'  => 'Footer',
	 'menu_slug'   => 'footer-settings'
	));*/
	acf_add_options_page(array(
		'page_title' 	=> 'Experience Details',
		'menu_title' 	=> 'Experience Details',
		'menu_slug' 	=> 'options_experience',
		'capability' 	=> 'edit_posts', 
		'parent_slug'	=> 'edit.php?post_type=experience',
		'position'	=> false,
		'icon_url' 	=> 'dashicons-images-alt2',
		'redirect'	=> false,
	   ));
}

// Register Custom Post Type PhotoStory
// Post Type Key: photostory
function create_photostory_cpt() {

	$labels = array(
		'name' => __( 'PhotoStories', 'Post Type General Name', 'Journeys' ),
		'singular_name' => __( 'PhotoStory', 'Post Type Singular Name', 'Journeys' ),
		'menu_name' => __( 'PhotoStories', 'Journeys' ),
		'name_admin_bar' => __( 'PhotoStory', 'Journeys' ),
		'archives' => __( 'PhotoStory Archives', 'Journeys' ),
		'attributes' => __( 'PhotoStory Attributes', 'Journeys' ),
		'parent_item_colon' => __( 'Parent PhotoStory:', 'Journeys' ),
		'all_items' => __( 'All PhotoStories', 'Journeys' ),
		'add_new_item' => __( 'Add New PhotoStory', 'Journeys' ),
		'add_new' => __( 'Add New', 'Journeys' ),
		'new_item' => __( 'New PhotoStory', 'Journeys' ),
		'edit_item' => __( 'Edit PhotoStory', 'Journeys' ),
		'update_item' => __( 'Update PhotoStory', 'Journeys' ),
		'view_item' => __( 'View PhotoStory', 'Journeys' ),
		'view_items' => __( 'View PhotoStories', 'Journeys' ),
		'search_items' => __( 'Search PhotoStory', 'Journeys' ),
		'not_found' => __( 'Not found', 'Journeys' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'Journeys' ),
		'featured_image' => __( 'Featured Image', 'Journeys' ),
		'set_featured_image' => __( 'Set featured image', 'Journeys' ),
		'remove_featured_image' => __( 'Remove featured image', 'Journeys' ),
		'use_featured_image' => __( 'Use as featured image', 'Journeys' ),
		'insert_into_item' => __( 'Insert into PhotoStory', 'Journeys' ),
		'uploaded_to_this_item' => __( 'Uploaded to this PhotoStory', 'Journeys' ),
		'items_list' => __( 'PhotoStories list', 'Journeys' ),
		'items_list_navigation' => __( 'PhotoStories list navigation', 'Journeys' ),
		'filter_items_list' => __( 'Filter PhotoStories list', 'Journeys' ),
	);
	$args = array(
		'label' => __( 'PhotoStory', 'Journeys' ),
		'description' => __( 'Journey Photostory', 'Journeys' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-tablet',
		'supports' => array('title', 'thumbnail'),
		'taxonomies' => array('post_tag'),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 6,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'photostory', $args );

}
add_action( 'init', 'create_photostory_cpt', 0 );

// Register Custom Post Type VideoStory
// Post Type Key: videostory
function create_videostory_cpt() {

	$labels = array(
		'name' => __( 'VideoStories', 'Post Type General Name', 'Journeys' ),
		'singular_name' => __( 'VideoStory', 'Post Type Singular Name', 'Journeys' ),
		'menu_name' => __( 'VideoStories', 'Journeys' ),
		'name_admin_bar' => __( 'VideoStory', 'Journeys' ),
		'archives' => __( 'VideoStory Archives', 'Journeys' ),
		'attributes' => __( 'VideoStory Attributes', 'Journeys' ),
		'parent_item_colon' => __( 'Parent VideoStory:', 'Journeys' ),
		'all_items' => __( 'All VideoStories', 'Journeys' ),
		'add_new_item' => __( 'Add New VideoStory', 'Journeys' ),
		'add_new' => __( 'Add New', 'Journeys' ),
		'new_item' => __( 'New VideoStory', 'Journeys' ),
		'edit_item' => __( 'Edit VideoStory', 'Journeys' ),
		'update_item' => __( 'Update VideoStory', 'Journeys' ),
		'view_item' => __( 'View VideoStory', 'Journeys' ),
		'view_items' => __( 'View VideoStories', 'Journeys' ),
		'search_items' => __( 'Search VideoStory', 'Journeys' ),
		'not_found' => __( 'Not found', 'Journeys' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'Journeys' ),
		'featured_image' => __( 'Featured Image', 'Journeys' ),
		'set_featured_image' => __( 'Set featured image', 'Journeys' ),
		'remove_featured_image' => __( 'Remove featured image', 'Journeys' ),
		'use_featured_image' => __( 'Use as featured image', 'Journeys' ),
		'insert_into_item' => __( 'Insert into VideoStory', 'Journeys' ),
		'uploaded_to_this_item' => __( 'Uploaded to this VideoStory', 'Journeys' ),
		'items_list' => __( 'VideoStories list', 'Journeys' ),
		'items_list_navigation' => __( 'VideoStories list navigation', 'Journeys' ),
		'filter_items_list' => __( 'Filter VideoStories list', 'Journeys' ),
	);
	$args = array(
		'label' => __( 'VideoStory', 'Journeys' ),
		'description' => __( 'Journey Video Stories', 'Journeys' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-format-video',
		'supports' => array('title', 'thumbnail' ),
		'taxonomies' => array('post_tag'),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 7,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'videostory', $args );

}
add_action( 'init', 'create_videostory_cpt', 0 );




