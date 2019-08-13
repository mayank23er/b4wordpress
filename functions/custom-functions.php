<?php
// Replace Posts label as Articles in Admin Panel 

function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Articles';
    $submenu['edit.php'][5][0] = 'Articles';
    $submenu['edit.php'][10][0] = 'Add Articles';
    echo '';
}
function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Articles';
        $labels->singular_name = 'Article';
        $labels->add_new = 'Add Article';
        $labels->add_new_item = 'Add Article';
        $labels->edit_item = 'Edit Article';
        $labels->new_item = 'Article';
        $labels->view_item = 'View Article';
        $labels->search_items = 'Search Articles';
        $labels->not_found = 'No Articles found';
        $labels->not_found_in_trash = 'No Articles found in Trash';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );


//remove post type support
add_action( 'init', function() {
    remove_post_type_support( 'post', 'editor' );
    remove_post_type_support( 'post', 'revisions' );
}, 99);

//Sample Article 
//change slug
function create_slug($string){ 
    $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string); 
    return $slug; 
} 


// hook to change slug
add_action( 'save_post', 'wpse105926_save_post_callback' );
function wpse105926_save_post_callback( $post_id ) {
   if( get_post_type() === 'photostory' || get_post_type() === 'videostory' || get_post_type() === 'post'  ){
     $newslug=create_slug(get_the_title( $post_id ));
     //urldecode(sanitize_title_with_dashes(get_the_title( $post_id ))); die;
    // verify post is not a revision
    if ( ! wp_is_post_revision( $post_id ) ) {

        // unhook this function to prevent infinite looping
        remove_action( 'save_post', 'wpse105926_save_post_callback' );

        // update the post slug
        wp_update_post( array(
            'ID' => $post_id,
            'post_name' =>  $newslug // do your thing here
        ));

        // re-hook this function
        add_action( 'save_post', 'wpse105926_save_post_callback' );
    }
    }
}

add_filter( 'post_row_actions', 'remove_row_actions', 10, 1 );
function remove_row_actions( $actions )
{
   // if (current_user_can( 'manage_options' ) ) {
    if( get_post_type() === 'photostory' || get_post_type() === 'videostory' || get_post_type() === 'post'  || get_post_type() === 'journey'  )
    $restricted_posts = array('Sample Article 1','Sample Article 2', 'Sample Video Article', 'Sample Photo Story');
    if(in_array(get_the_title(), $restricted_posts)){
        unset( $actions['edit'] );
        unset( $actions['view'] );
        unset( $actions['trash'] );
        unset( $actions['inline hide-if-no-js'] );
        echo '<a href="'.get_the_permalink().'" style="color: #ffffff;
        background: #181816;
        padding-left: 10px;
        padding-right: 10px;
        padding-top: 2px;
        padding-bottom: 4px;">View Sample Article</a>';
    }
    return $actions;
   // }
}

//remove Bulk box actions
//if (current_user_can( 'manage_options' ) ) {
add_filter( 'bulk_actions-' . 'edit-post', '__return_empty_array' );
add_filter( 'bulk_actions-' . 'upload', '__return_empty_array' );
//}

function is_custom_post_type( $post = NULL )
{
    $all_custom_post_types = get_post_types( array ( '_builtin' => FALSE ) );

    // there are no custom post types
    if ( empty ( $all_custom_post_types ) )
        return FALSE;

    $custom_types      = array_keys( $all_custom_post_types );
    $current_post_type = get_post_type( $post );

    // could not detect current type
    if ( ! $current_post_type )
        return FALSE;

    return in_array( $current_post_type, $custom_types );
}


//get author page link
function get_author_page_link_by_article_id($article_id) {
    $article_author_id = get_post_field ('post_author', $article_id);
    $author_link = site_url().'/author/?authorname='.get_the_author_meta( 'user_login', $article_author_id );
    return $author_link;
}

/* Get the parent cateogory name of the given category.
	 if the parent doesn't exist the name of the child category is returned.
*/
function get_parent_category_name($child_category) {
		$parent = get_cat_name($child_category->category_parent);
		if (!empty($parent)) {
			$parent_category = $parent;
		} else {
			$parent_category = $child_category->cat_name;
		}
		$parent_category = strtolower($parent_category);
		return $parent_category;
}

function parent_cat_slug($category){
		
    if(!empty($category)){
        $category_parent_id = $category[0]->category_parent;
        if ( $category_parent_id != 0 ) {
            $category_parent = get_term( $category_parent_id, 'category' );
            $css_slug = $category_parent->slug;
        } else {
            $css_slug = $category[0]->slug;
        }
    }else{
        $css_slug='';
    }
    return $css_slug;
}

/* Get the child categories of the parent category */
function get_child_categories($parentCategory) {
    $args = array('parent' => $parentCategory);
    $childCategories = get_categories( $args );
    return $childCategories;
}

//get category link
function get_cat_link($category) {
    $blog_id = get_current_blog_id();
    $site_url = get_site_url($blog_id);
    $base_filter_url = $site_url.'/filter-page';
    
    $parent = get_cat_name($category->category_parent);

    if (!empty($parent)) {
        $parent_category = $category->category_parent;
        $parent_category_slug = get_category($parent_category)->slug;

        $filter_page_link = $base_filter_url.'?cat='.$parent_category_slug.'&sub_cat='.$category->slug;
    } else {
        $filter_page_link = $base_filter_url.'?cat='.$category->slug;

    }

    return $filter_page_link;
}

//Remove WPAUTOP from ACF TinyMCE Editor
// function acf_wysiwyg_remove_wpautop() {
//     remove_filter('acf_the_content', 'wpautop' );
// }
// add_action('acf/init', 'acf_wysiwyg_remove_wpautop');

function build_js(){
    if( get_post_type()=='videostory' ){ 
        wp_register_script('experience-js', get_template_directory_uri() . '/theme/js/experience.js',array('jquery'), null, true);
        wp_enqueue_script('experience-js');
    }
}
add_action('wp_enqueue_scripts', 'build_js');

/* Function to get the summary of the article to be displayed on the article card */
function get_card_excerpt_of_article($article_id) {
    $post_type = get_post_type($article_id);
    $article_excerpt = '';
    // Keeping this default
    
    $article_excerpt = str_replace('" font_container="tag:h3|text_align:left" use_theme_fonts="yes" css=".vc_custom','',get_the_content($article_id)); 
    if(empty($article_excerpt)) { // Sometime get_the_content returns blank so added post_content logic too to handle the scenario.
        $article_excerpt = get_post_field('social_media_share_description', $article_id,true);
    }
    if ($post_type == 'videostory' ) {
        $article_excerpt = preg_replace('#\[[^\]]+\]#', '',$article_excerpt);
        return strip_tags($article_excerpt);
    }
    if ($post_type == 'photostory' ) {
        $article_excerpt = preg_replace('#\[[^\]]+\]#', '',$article_excerpt);
        //replacing substr with mb_substr since the former counts bytes and the latter actually counts character
        $article_excerpt = mb_substr(strip_tags($article_excerpt), 68, 150);
        //$article_excerpt = trim($article_excerpt, '[vc_row content_placement="top"][vc_column][vc_custom_heading text="Your photo story heading will come here" use_theme_fonts="yes"][vc_tta_pageable no_fill_content_area="1" active_section="1" pagination_style=""][vc_tta_section title="Slide 1" tab_id="1499340669421-c53871c0-5b7e"][vc_row_inner content_placement="middle"][vc_column_inner el_class="photostoryimg" width="2/3"][vc_raw_html]JTNDc3BhbiUyMGNsYXNzJTNEJTIybW92ZS1sZWZ0JTIyJTNFJTNDJTJGc3BhbiUzRSUwQSUzQ3NwYW4lMjBjbGFzcyUzRCUyMm1vdmUtcmlnaHQlMjIlM0UlM0MlMkZzcGFuJTNF[/vc_raw_html][vc_single_image image="1288" img_size="large" alignment="center" onclick="link_image" css_animation="appear" el_class="photostory"][/vc_column_inner][vc_column_inner width="1/3"][vc_column_text]1 of');
        return $article_excerpt;
    }else{
    $article_excerpt = preg_replace('#\[[^\]]+\]#', '',$article_excerpt);
    $article_excerpt = str_replace('" font_container="tag:h3|text_align:left" use_theme_fonts="yes" css=".vc_custom','',$article_excerpt); }
    //replacing substr with mb_substr since the former counts bytes and the latter actually counts character
    $article_excerpt = mb_substr(strip_tags($article_excerpt), 0, 100)."... ";
    return $article_excerpt;
}
//remove WYSWYG editor
add_action( 'admin_init', 'hide_editor' );
function hide_editor() {
  remove_post_type_support('page', 'editor');
}

//assign tag template
add_action('init', function() {
    $request_uri = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
      $post_type = $post_slug ='';
      if(!empty($request_uri)){
          $explodedRequestURI = explode("/",$request_uri);
          
           @$post_type = $explodedRequestURI[0];
           @$post_slug = $explodedRequestURI[1]; 
      }
      if ( $post_slug === 'search_term' ) {
         
          // load the file if exists
          $load = locate_template('page-templates/search-term.php', true);
          if ($load) {
              exit(); // just exit if template was found and loaded
          }
     }
     if ( $post_slug === 'author' ) {
         
        // load the file if exists
        $load = locate_template('author.php', true);
        if ($load) {
            exit(); // just exit if template was found and loaded
        }
    }
	if ( $post_slug === 'journey-with-a-cause' ) {
         
        // load the file if exists
        $load = locate_template('cause.php', true);
        if ($load) {
            exit(); // just exit if template was found and loaded
        }
    }
  });

    // define the ninja_forms_after_submission callback 
    // function action_ninja_forms_after_submission( $this_data ) { 
    //    echo "hello"; die;
    // }
             
    // // add the action 
    // add_action( 'ninja_forms_after_submission', 'action_ninja_forms_after_submission', 10, 1 ); 

    add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
	function add_loginout_link( $items, $args ) {
		
			$items .= '<li class="nav-custom-search"><div class="pull-right">';
			
			$items .= '<div class="search_mag col-xs-12 col-sm-10 col-md-3 col-lg-3">
			<span class="srch_icn">
				<img alt="RoundGlass" class="w-search" src="'.get_stylesheet_directory_uri().'/images/search-white.svg" />
				<img alt="RoundGlass" class="b-search" src="'.get_stylesheet_directory_uri().'/images/search.svg" />
			</span>
			<form autocomplete="off">
				<input type="text" name="search" id="suggestiveSearchInput" class="js-show-help" placeholder="Search">
				<input type="" name="submit search" class="searchHeaderIcon">
				

				  <div class="located-content js-help-content" id="suggestiveSearchDropDown" style="display: none;">
				   <!-- Suggestive search start -->     
			  <div class="suggestiveOuter">
				<div class="suggestiveSinner">
					<span class="dropHeading" id="elasticSearchKeyword"></span>
					<span class="arrow-icon01"><a class="suggestive-search-arrow"></a></span>
					
				</div>
				<div class="clearfix"></div>
				  <div class="suggestiveContent" id="suggestiveSearchContentWrapper">
					<div class="suggestiveHeaderStoriesWrapper">
					<div class="suggestiveHeader">
					  <div class="pull-left sugg-heading">Stories</div>
					  <div class="pull-right" id="storiesShowMoreHideText"><a href="" class="storiesShowMoreText">More</a></div>
					</div>
					<ul id="elasticSearchStoriesResult">
				 
					</ul>
				</div>
				<div class="suggestiveHeaderCollectionWrapper">
					<div class="suggestiveHeader">
					  <div class="pull-left sugg-heading">JOURNEYS</div>
					  <div class="pull-right" id="collectionShowMoreHideText"><a href=""  class="collectionShowMoreText">More</a></div>
					</div>
					<ul id="elasticSearchCollectionResult">
				
					</ul>
				</div>
				<div class="suggestiveHeaderAuthorsWrapper">
					<div class="suggestiveHeader">
					  <div class="pull-left sugg-heading">AUTHORS</div>
					  <div class="pull-right" id="authorShowMoreHideText"><a href="" class="authorShowMoreText">More</a></div>
					</div>
					<ul class="onlyAuthours" id="elasticSearchAuthorsResult">
						<!--Related Authors through Ajax-->

					</ul>
				</div>
				  </div>
				  <div class="related-tags">
					<h4>RELATED TAGS</h4>
					<div id="relatedTagsElasticSearch">
					   
					</div>
				  </div>
			  </div>
				<div class="popover-arrow"></div> 
			</div>
			<!-- Suggestive search start -->
			</form>';
			
			
		
			$items .= '</div></li><li id="menu-item-15" class="nav-item dropdown"><a href="'.site_url().'/personalised-trips/" class="nav-link nav-btn ptrip">PERSONALISED TRIPS</a></li>';
		
		return $items;
	}