<?php
/**!
 * Setup
 */
define( 'MAIN_DIR', get_template_directory_uri() );
define( 'SITEURL', site_url() );
define( 'rgfacebook', 'https://www.facebook.com/rg1journeys/' );
add_filter('show_admin_bar', '__return_false');

add_action('get_header', 'remove_admin_login_header');
function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}

//check if mobile
function rg_wp_is_mobile() {
	static $is_mobile;

	if ( isset($is_mobile) )
		return $is_mobile;

	if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
		$is_mobile = false;
	} elseif (
		strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false ) {
			$is_mobile = true;
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false && strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') == false) {
			$is_mobile = true;
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) {
		$is_mobile = false;
	} else {
		$is_mobile = false;
	}

	return $is_mobile;
}

if ( ! function_exists('b4st_setup') ) {
	function b4st_setup() {
		add_editor_style('theme/css/editor-style.css');

		add_theme_support('title-tag');

		add_theme_support('post-thumbnails');

		update_option('thumbnail_size_w', 285); /* internal max-width of col-3 */
		update_option('small_size_w', 350); /* internal max-width of col-4 */
		update_option('medium_size_w', 730); /* internal max-width of col-8 */
		update_option('large_size_w', 1110); /* internal max-width of col-12 */

		if ( ! isset($content_width) ) {
			$content_width = 1100;
		}

		add_theme_support( 'post-formats', array(
			'aside',
			'gallery',
			'link',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat'
		) );

		add_theme_support('automatic-feed-links');
	}
}
add_action('init', 'b4st_setup');

if ( ! function_exists( 'b4st_avatar_attributes' ) ) {
	function b4st_avatar_attributes($avatar_attributes) {
		$display_name = get_the_author_meta( 'display_name' );
		$avatar_attributes = str_replace('alt=\'\'', 'alt=\'Avatar for '.$display_name.'\' title=\'Gravatar for '.$display_name.'\'',$avatar_attributes);
		return $avatar_attributes;
	}
}
add_filter('get_avatar','b4st_avatar_attributes');

if ( ! function_exists( 'b4st_author_avatar' ) ) {
	function b4st_author_avatar() {

		echo get_avatar('', $size = '96');
	}
}

if ( ! function_exists( 'b4st_author_description' ) ) {
	function b4st_author_description() {
		echo get_the_author_meta('user_description');
	}
}

if ( ! function_exists( 'b4st_post_date' ) ) {
	function b4st_post_date() {
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <time class="updated" datetime="%3$s">(updated %4$s)</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				get_the_date(),
				esc_attr( get_the_modified_date( 'c' ) ),
				get_the_modified_date()
			);

			echo $time_string;
		}
	}
}

if ( ! function_exists('b4st_excerpt_more') ) {
	function b4st_excerpt_more() {
		return '&hellip;</p><p><a class="btn btn-primary" href="'. get_permalink() . '">' . __('Continue reading', 'b4st') . ' <i class="fas fa-arrow-right"></i>' . '</a></p>';
	}
}
add_filter('excerpt_more', 'b4st_excerpt_more');


function get_id_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) {
	  return $page->ID;
	} else {
	  return null;
	}
  }