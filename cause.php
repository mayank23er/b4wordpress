<?php 
function journey_script() {
  wp_register_script('experience-js', get_template_directory_uri() . '/theme/js/experience.js', false, null, null);
  wp_enqueue_script('experience-js');
}
add_action( 'wp_enqueue_scripts', 'journey_script', 101 );
get_header(); ?>
<?php
	/*
	Template Name: Cause Journey Page
	*/
	$today = date('Ymd'); 
	$journeys = array(
		'posts_per_page'   => -1,
		'post_type'        => 'journey',
		'meta_key' => 'ACF_journey_smonth',
		'post_status'	=> 'publish',
		'orderby' => 'publish_date',
		'offset' => 1, 
		'order' => 'DESC',
		'meta_query'    => array(
			array(
				'key'       => 'journeys_with_a_cause',
				'value'     => 1
			)
		)
	);
	$loop = new WP_Query( $journeys );
	if($loop->have_posts()) { 
			?>
			<section class="exp-main articles-marginT story">
				<div class="container">
					<h1 class="normal journeys-cat-h  text-center">Journeys with a Cause</h1>
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
									$jurl =  str_replace("image/upload/","image/upload/c_fill,ar_1.48,f_auto,q_auto,w_1920,g_auto/",$jurl_cloud);
								}else{
									$jurl = $j_img['url'];
								}
								$jalt = $j_img['alt'] ?: '';
							}else{
								$jurl='http://via.placeholder.com/672x454'; 
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
									
									<a href="<?php echo $journey_link; ?>" class="img-wrapper-animate display-inherit;">
										<img src="<?php echo $jurl; ?>" alt="<?php echo $jalt; ?>" />
									</a>
									<h5><?php the_title();?></h5>
									<p class="light"><?php echo $j_desc; ?></p>
									<div class="location">
										<span class="map"><?php echo $j_city; ?></span>
										<span class="day"><?php echo $tdays; ?></span>
										<a data-toggle="modal" data-target="#myBook" class="dk-image bkform float-right url">+ BOOK</a>
										<a style="background:none;color:#e16261;margin-right:0; padding-right:0"  data-toggle="modal" data-target="#myBook" href="" class="mb-image bkform float-right url">+ BOOK</a>
									</div>
								</div>
							</div>
						<?php
						endwhile;	
						?>
					</div>
				</div>
			</section>
		<?php 
	}
get_footer(); 
?>
