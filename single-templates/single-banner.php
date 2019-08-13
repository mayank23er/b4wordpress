<?php
/*Template Name: Single Banner Template
 */
 //get_header(); ?>

<?php
 add_shortcode( 'show_banner', 'display_banner' );
 if( class_exists('acf') ) {
	 function display_banner() { 
		//Banner post
		$bannerargs = array( 'post_type' => 'banner','post_status'	=> 'publish');
		$bannerloop = new WP_Query( $bannerargs );
		//echo '<pre>';
		//print_r($bannerloop);
		while ( $bannerloop->have_posts() ) : $bannerloop->the_post();
		$bannerid=get_the_ID(); 
		endwhile; 
		$title=get_the_title() ?: ''; 
		 $acf_bannersubtitle=get_field("ACF_banner_sub_title") ?: '';
		 $acf_bannertype = get_field_object('ACF_bannertype');
		 $acf_bannertype_value = $acf_bannertype['value']; 
		 if($acf_bannertype_value=='image'):
			$acf_banner_image=get_field('ACF_bannerimage');
				if($acf_banner_image):
					$acf_banner_image_url = $acf_banner_image['url'];
					$acf_banner_image_alt = $acf_banner_image['alt'];
						if(strpos($acf_banner_image_url,'cloudinary.com') > 0){
							$banner_url = str_replace("image/upload/","image/upload/c_fill,ar_3:2,f_auto,q_auto,w_auto,g_auto/",$acf_banner_image_url);
							$topcode='<img src="'.$banner_url.'" alt="" class="w-100 dk-image">';
						}else{
							$banner_url = $acf_banner_image_url; 
							$topcode = '<img src="'.$banner_url.'" alt="" class="w-100 dk-image">';
						}
				endif;
		 else:
			if($acf_bannertype_value=='video'):
			    $banner_url = get_field('ACF_bannervideo')."?controls=0";
				$topcode = '<iframe width="100%" height="100%" src="//www.youtube.com/embed/-w-58hQ9dLk?controls=0" frameborder="0" allowfullscreen=""></iframe>';
			endif;
		 endif;
		 $html='<section class="main-banner">'.$topcode.'
		 <img src="'.MAIN_DIR.'/images/mobile.jpg" alt="" class="w-100 mb-image">
   			 <div class="caption"><p class="p1 light baskerville">'.$title.'</p>
			 <h5 class="light">'.$acf_bannersubtitle.'</h5>
			 </div>
		 </section>';
		 return $html;
	 }
	
	 echo do_shortcode('[show_banner]');
 }
 else{
 }
 wp_reset_query();

 
?>