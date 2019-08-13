<?php
/**
* Template part for displaying posts
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package RoundGlass_Foundation
*/

	// Find all the Journeys for the selected Experience.
	$experience_id = get_the_ID(); 
	$today = date('Ymd'); 
	$journeys = array(
					'posts_per_page'   => 2,
					'post_type'        => 'journey',
					//'meta_key' => 'ACF_journey_smonth',
					'post_status'	=> 'publish',
					'orderby' => 'publish_date',
					'offset' => 1, 
					'order' => 'DESC',
					'meta_query' => array(
							array(
								'key' => 'ACF_journey_experiences',
								'value' => $experience_id,
							),
							array(
								'key' => 'ACF_journey_smonth',
								'value' => $today,
								'compare' => '>='
							)
					)
				);
		
		
		$loop = new WP_Query( $journeys ); 
		$journeys_org = array(
					'posts_per_page' => -1,
					'post_type'        => 'journey',
					//'meta_key' => 'ACF_journey_smonth',
					'post_status'	=> 'publish',
					'orderby' => 'publish_date',
					'offset' => 1, 
					'order' => 'DESC',
					'meta_query' => array(
							array(
								'key' => 'ACF_journey_experiences',
								'value' => $experience_id,
							),
							array(
								'key' => 'ACF_journey_smonth',
								'value' => $today,
								'compare' => '>='
							)
					)
				);
		
		
		$loop_org = new WP_Query( $journeys_org ); 
		if($loop->have_posts()) { 
				?>
				<section class="exp-main story journeys-cat-common-exp top-pbr-5 lmb-5">
					<div class="container">
						<div class="row">
							<?php
							while ( $loop->have_posts() ) : $loop->the_post();  
							
							$jid=get_the_ID();
							$j_title=get_the_title() ?: '';
							$journey_link=get_the_permalink($jid);
							$j_img=get_field("ACF_journeyhero_image",$jid) ?: '';
							
							if( !empty($j_img) ){
								$jurl_cloud = $j_img['url'];
								if(strpos($jurl_cloud,'cloudinary.com') > 0){
									$purl =  str_replace("image/upload/","image/upload/c_fill,ar_0.53,f_auto,q_auto,w_408,g_auto/",$jurl_cloud);
									$jurl =  str_replace("image/upload/","image/upload/c_fill,ar_1.48,f_auto,q_auto,w_1920,g_auto/",$jurl_cloud);
									
								}else{
									$jurl = $j_img['url'];
									$purl = $j_img['url'];
								}
								$jalt = $j_img['alt'] ?: '';
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
							?>
							<div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
								<div class="exp-list">
							
									<a href="<?php echo $journey_link; ?>"  class="img-wrapper-animate display-inherit;">
									<!-- style="position:relative"<span class="play" style="position: absolute;top: 50%;left: 50%;">testtttt</span> -->
									<img src="<?php echo $jurl; ?>" alt="<?php echo $jalt; ?>" />
									</a>
									<div class="sub-header hide-mb"><?php echo strtoupper($experience_name) ?></div>
									<h5><?php echo get_the_title($jid);?></h5>
							
							
									<p class="light dk-jndesc"><?php echo $j_desc; ?></p>
									<div class="location"><span class="map"><?php echo $j_city; ?></span>
										<span class="day"><?php echo $tdays; ?></span>
										<a data-image="<?php echo $purl; ?>" data-title="<?php echo $j_title; ?>" data-city="<?php echo $j_city; ?>" data-toggle="modal" data-target="#myBook" class="dk-image bkform float-right url">+ BOOK</a>
										<a style="background:none;color:#e16261;margin-right:0; padding-right:0" data-image="<?php echo $purl; ?>" data-title="<?php echo $j_title; ?>" data-city="<?php echo $j_city; ?>"  data-toggle="modal" data-target="#myBook" href="" class="mb-image bkform float-right url">+ BOOK</a>
									</div>
								</div>
							</div>
							<?php
						endwhile;	
						?>
						
						</div>
							<?php 
								if($loop_org->post_count>2){
									echo do_shortcode( '[ajax_load_more id="inspiring_journeys_cat" button_label="Load More" container_type="div" css_classes="row loadmore-custom cdiv" repeater="template_2" post_type="journey" posts_per_page="4" meta_key="ACF_journey_experiences:ACF_journey_smonth" meta_value="'.$experience_id.':'.$today.'" meta_compare="=:>=" meta_type="CHAR:CHAR" meta_relation="AND" offset="3" pause="true" scroll="false"]');
								}
								
							?>
					</div>
				
				</section>
			<?php 
	
	}
	else {
		//do nothing
	}
	?>
	<style>
	.alm-listing.alm-ajax.row.loadmore-custom.cdiv div.alm-reveal > div {
		float: left;
	}
	</style>