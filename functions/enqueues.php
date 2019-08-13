<?php
/**!
 * Enqueues
 */

if ( ! function_exists('b4st_enqueues') ) {
	function b4st_enqueues() {

		// Styles

		wp_register_style('bootstrap-css', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css', false, '4.1.1', null);
		wp_enqueue_style('bootstrap-css');
		
		wp_register_style('rg-journey-desktop', get_template_directory_uri() . '/css/custom/custom.css', false, null);
		wp_enqueue_style('rg-journey-desktop');
		
		wp_register_style('rg-journey-mobile', get_template_directory_uri() . '/css/custom/style-responsive.css', false, null);
		wp_enqueue_style('rg-journey-mobile');
		
		wp_register_style('rg-journey-fonts', get_template_directory_uri() . '/theme/css/webfonts.css', false, null);
		wp_enqueue_style('rg-journey-fonts');
		
		wp_register_style('rg-journey-typography', get_template_directory_uri() . '/theme/css/typography.css', false, null);
		wp_enqueue_style('rg-journey-typography');

		wp_register_style('b4st-css', get_template_directory_uri() . '/theme/css/b4st.css', false, null);
		wp_enqueue_style('b4st-css');

		// MAIN CUSTOM STYLE
		wp_enqueue_style( 'main-custom', get_stylesheet_directory_uri() . '/theme/css/main-custom.css' , array(), filemtime( get_stylesheet_directory() . '/theme/css/main-custom.css' ));
		
		wp_register_style('swiper-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/css/swiper.css', false, '4.3.3', null);
		wp_enqueue_style('swiper-css');

		// Scripts

		wp_register_script('jquery-3.3.1', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js', false, '3.3.1', null);
		wp_enqueue_script('jquery-3.3.1');
		
		wp_register_script('font-awesome-config-js', get_template_directory_uri() . '/theme/js/font-awesome-config.js', false, null, null);
		wp_enqueue_script('font-awesome-config-js');

		wp_register_script('font-awesome', 'https://use.fontawesome.com/releases/v5.0.13/js/all.js', false, '5.0.13', null);
		wp_enqueue_script('font-awesome');

		wp_register_script('modernizr',  'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', false, '2.8.3', null);
		wp_enqueue_script('modernizr');

		
		wp_register_script('popper',  'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', false, '1.14.3', null);
		wp_enqueue_script('popper');

		wp_register_script('bootstrap-js', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js', false, '4.1.1', true);
		wp_enqueue_script('bootstrap-js');
		
		wp_register_script('swiper-js', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/js/swiper.js', false, '4.3.3', null);
		wp_enqueue_script('swiper-js');

		wp_register_script('b4st-js', get_template_directory_uri() . '/theme/js/b4st.js', false, null, null);
		wp_enqueue_script('b4st-js');

		wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/theme/js/main-custom.js' , array(), filemtime( get_stylesheet_directory() . '/theme/js/main-custom.js' ));

		
		wp_enqueue_script( 'ajaxhelper-script', get_stylesheet_directory_uri() . '/theme/js/ajaxhelper.js' , array(), filemtime( get_stylesheet_directory() . '/theme/js/ajaxhelper.js' ) ,$in_footer = true);
		wp_enqueue_script( 'home-script', get_stylesheet_directory_uri() . '/theme/js/home.js' , array(), filemtime( get_stylesheet_directory() . '/theme/js/home.js' ));

		
		wp_enqueue_style( 'search-result.min', get_stylesheet_directory_uri() . '/css/custom/search-result.css', array(), true ); 
		wp_enqueue_style( 'header-search.min', get_stylesheet_directory_uri() . '/css/custom/header-search.css', array(), true );
		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}
}
add_action('wp_enqueue_scripts', 'b4st_enqueues', 100);

//admin-css
add_action( 'admin_enqueue_scripts', 'load_admin_style' );
      function load_admin_style() {
     wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/theme/css/style-admin.css', false, '1.0.0' );
 }