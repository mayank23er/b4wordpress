<?php 
/*Template Name: Experience Template
*/
$exp_title = get_field('ACF_exptitle', 'option');
$exp_subtitle = get_field('ACF_expsubtitle', 'option');
add_shortcode( 'upcoming_journey', 'display_upcoming_journey' );
function display_upcoming_journey(){ 
	// Find all the Journeys
	$today = date('Ymd'); 
	$journeysargs = array(
		'posts_per_page' => 4,
		'orderby' => 'publish_date',
		'order' => 'DESC',
		'post_type' => 'journey',
		'post_status'	=> 'publish',
		'meta_query' => array(
			array(
				'key' => 'ACF_journey_smonth',
				'value' => $today,
				'compare' => '>='
				)
				)
			);
			$loop = new WP_Query( $journeysargs );  
			while ( $loop->have_posts() ) : $loop->the_post();  
			$jid=get_the_ID();
			$j_title=get_the_title() ?: '';
			$journey_link=get_the_permalink($jid);
			$j_img=get_field("ACF_journeyhero_image",$jid) ?: '';
			

			if( !empty($j_img) ){
				$cloud_jurl = $j_img['url'];
				$jalt = $j_img['alt'] ?: '';
				if(strpos($cloud_jurl,'cloudinary.com') > 0){
					$purl = str_replace("image/upload/","image/upload/c_fill,ar_0.53,f_auto,q_auto,w_408,g_auto/",$cloud_jurl);
					$jurl = str_replace("image/upload/","image/upload/c_fill,ar_1.48,f_auto,q_auto,w_1920,g_auto/",$cloud_jurl);
					
				}else{
					$jurl = $cloud_jurl; 
					$purl = $cloud_jurl; 
				}	
			}else{
				$jurl='http://via.placeholder.com/672x454'; 
				$purl='http://via.placeholder.com/408x766'; 
				$jalt= '';
			}
			
			$j_desc=get_field("ACF_journey_description",$jid) ?: '';
			$j_city=get_field("ACF_journeycity",$jid) ?: '';
			$exp_object = get_field('ACF_journey_experiences',$jid);
			$total_nights=get_field( 'total_nights',$jid ); 
			$total_days=get_field( 'total_days',$jid );
			$tdays=$total_nights." Nights ".$total_days. " Days";
			if( $exp_object ): 
				// override $post
				$exppost = $exp_object;
				setup_postdata($exppost); 
				$expId=$exppost->ID;
				$experience_name=get_the_title($expId); 
				wp_reset_postdata(); 
			endif;
			@$html .='<div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
			<div class="exp-list">
			<a href="'.$journey_link.'" class="img-wrapper-animate display-inherit;"><img src="'.$jurl.'" alt="'.$jalt.'" /></a>
			<div class="sub-header">'.strtoupper($experience_name).'</div>
			<h5>'.$j_title.'</h5>
			<p class="light dk-jndesc">'.$j_desc.'</p>
			<div class="location">
			<span class="map">'.$j_city.'</span>
			<span class="day">'.$tdays.'</span>
			<a href="" data-toggle="modal" data-target="#myBook" data-image="'.$purl.'" data-title="'.$j_title.'" data-city="'.$j_city.'" class="bkform float-right url">+ BOOK</a>
			</div>
			</div>
			</div>';
		endwhile;	  
		return $html;
	}
	?>
	
	<?php 
	add_shortcode( 'upcoming_journey_mobile', 'display_upcoming_journey_mobile' );
	function display_upcoming_journey_mobile(){ 
		// Find all the Journeys
		$today = date('Ymd'); 
		$journeysargs = array(
			'posts_per_page' => -1,
			'meta_key' => 'ACF_journey_smonth',
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'post_type' => 'journey',
			'post_status'	=> 'publish',
			'meta_query' => array(
				array(
					'key' => 'ACF_journey_smonth',
					'value' => $today,
					'compare' => '>='
				)
			)
		);
				$loop = new WP_Query( $journeysargs );  
				while ( $loop->have_posts() ) : $loop->the_post();  
				$jid=get_the_ID();
				$j_title=get_the_title() ?: '';
				$j_img=get_field("ACF_journeyhero_image",$jid) ?: '';
				$journey_link=get_the_permalink($jid);
				if( !empty($j_img) ){
					$cloud_jurl = $j_img['url'];
					$jalt = $j_img['alt'] ?: '';
					if(strpos($cloud_jurl,'cloudinary.com') > 0){
						$purl = str_replace("image/upload/","image/upload/c_fill,ar_1.48,f_auto,q_auto,w_408,g_auto/",$cloud_jurl);
						$jurl = str_replace("image/upload/","image/upload/c_fill,ar_1.48,f_auto,q_auto,w_1920,g_auto/",$cloud_jurl);
						
					}else{
						$jurl = $cloud_jurl; 
						$purl = $cloud_jurl; 
					}	
				}else{
					$jurl='http://via.placeholder.com/672x454'; 
					$purl='http://via.placeholder.com/672x454'; 
					$jalt= '';
				}
				
				$j_desc=get_field("ACF_journey_description",$jid) ?: '';
				$j_city=get_field("ACF_journeycity",$jid) ?: '';
				$exp_object = get_field('ACF_journey_experiences',$jid);
				$total_nights=get_field( 'total_nights',$jid ); 
				$total_days=get_field( 'total_days',$jid );
				$tdays=$total_nights." Nights ".$total_days. " Days";
				if( $exp_object ): 
					// override $post
					$exppost = $exp_object;
					setup_postdata($exppost); 
					$expId=$exppost->ID;
					$experience_name=get_the_title($expId); 
					wp_reset_postdata(); 
				endif;
				@$html .='<div class="swiper-slide">
				<div class="exp-list">
				<a href="'.$journey_link.'" class="img-wrapper-animate display-inherit;"><img src="'.$jurl.'" alt="'.$jalt.'" /></a>
				<div class="sub-header swiper-slide-exp-mobile">'.strtoupper($experience_name).'</div>
				<h5 class="swiper-slide-exp-mobile">'.$j_title.'</h5>
				<p class="light swiper-slide-exp-mobile">'.$j_desc.'</p>
				<div class="location swiper-slide-exp-mobile">
				<span class="map">'.$j_city.'</span>
				<span class="day">'.$tdays.'</span>
				<a href="" data-toggle="modal" data-target="#myBook" data-image="'.$purl.'" data-title="'.$j_title.'" data-city="'.$j_city.'" class="bkform float-right url">+ BOOK</a>
				</div>
				</div>
				</div>';
			endwhile;	  
			return $html;
		}
		?>
		<section class="exp-main">
		<div class="container">
		<div class="s-header semi-bold">EXPERIENCES</div>
		<h2 class="light"><?php echo $exp_title; ?>
		</h2>
		<h5 class="light gray"><?php echo $exp_subtitle; ?></h5>
		
		<div class="mobile-slider">
		<div class="swiper-container swiper-container-experience" >
		<div class="swiper-wrapper">
		<?php 
		$count_posts_mb = wp_count_posts( 'journey' )->publish; 
		if($count_posts_mb!=0){
			echo do_shortcode('[upcoming_journey_mobile]'); 
		}
		?>
		</div>
		</div>
		</div>
		<!-- desktop journeys-->
		<?php  $count_posts = wp_count_posts( 'journey' )->publish; 
		if($count_posts!=0){
			?>
			<div class="row desktop-slider"><?php echo do_shortcode('[upcoming_journey]'); ?></div><div class="text-center mr-top-40">
			<a href="<?php echo site_url(); ?>/filter_journey" class="btn btn-default view-all">VIEW ALL</a>
			</div> <?php } ?>
			</div>
			</section>