<section class="exp-main">
	<div class="container">
		<div class="s-header semi-bold">EXPERIENCES</div>
		
		<?php 
		$exp_title 		= get_field('ACF_exptitle', 	'option');
		$exp_subtitle 	= get_field('ACF_expsubtitle', 	'option');
		$post_objects	= get_field( 'experience_articles' ); ?>
		<h2 class="light"><?php echo $exp_title; ?></h2>
		<h5 class="light gray"><?php echo $exp_subtitle; ?></h5>
	
		<div class="mobile-slider">
			<div class="swiper-container swiper-container-experience" >
			
				<div class="swiper-wrapper">
				<?php 
					if ( $post_objects )
					{
						$totalPostCount = count( $post_objects );
						foreach ( $post_objects as $post ){ 
							
							setup_postdata( $post ); 
							
							$jid=get_the_ID();
							$j_title=get_the_title() ?get_the_title():'';
							$journey_link=get_the_permalink($jid);
							$j_img=get_field("ACF_journeyhero_image",$jid) ?get_field("ACF_journeyhero_image",$jid):'';
							

							if( !empty($j_img) ){
								$cloud_jurl = $j_img['url'];
								$jalt = $j_img['alt']?$j_img['alt']:'';
								
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
							if( $exp_object ){
								// override $post
								$exppost = $exp_object;
								setup_postdata($exppost); 
								$expId=$exppost->ID;
								$experience_name=get_the_title($expId); 
								wp_reset_postdata(); 
							}
							?>
							<div class="swiper-slide">
								<div class="exp-list">
									<a href="<?php echo $journey_link; ?>" class="img-wrapper-animate display-inherit;">
										<img src="<?php echo $jurl; ?>" alt="<?php echo $jalt; ?>" />
									</a>
									<div class="sub-header swiper-slide-exp-mobile"><a class="tdec" href="<?php echo SITEURL; ?>/experience/<?php echo $experience_name; ?>"><?php echo strtoupper($experience_name); ?></a></div>
									<a class="textdecnone" href="<?php echo $journey_link; ?>"><h5 class="swiper-slide-exp-mobile"><?php echo $j_title; ?></h5></a>
									<p class="light swiper-slide-exp-mobile"><?php echo $j_desc; ?></p>
									<div class="location swiper-slide-exp-mobile">
										<span class="map"><?php echo $j_city; ?></span>
										<span class="day"><?php echo $tdays; ?></span>
										<a href="" data-toggle="modal" data-target="#myBook" data-image="<?php echo $purl; ?>" data-title="<?php echo $j_title; ?>" data-city="<?php echo $j_city; ?>" class="bkform float-right url">+ BOOK</a>
									</div>
								</div>
							</div>
							<?php
						}
						wp_reset_postdata();
					} 
				?>
				</div>
			</div>
		</div>
		
		<!-- desktop journeys-->
		<div class="row desktop-slider">
			<?php 
			if ( $post_objects )
			{
				$totalPostCount = count( $post_objects );
				foreach ( $post_objects as $post ){ 
					
					setup_postdata( $post ); 
					
					$jid=get_the_ID();
					$j_title=get_the_title() ?get_the_title():'';
					$journey_link=get_the_permalink($jid);
					$j_img=get_field("ACF_journeyhero_image",$jid) ?get_field("ACF_journeyhero_image",$jid):'';
					

					if( !empty($j_img) ){
						$cloud_jurl = $j_img['url'];
						$jalt = $j_img['alt']?$j_img['alt']:'';
						
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
					if( $exp_object ){
						// override $post
						$exppost = $exp_object;
						setup_postdata($exppost); 
						$expId=$exppost->ID;
						$experience_name=get_the_title($expId); 
						wp_reset_postdata(); 
					}
					?>
					<div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
						<div class="exp-list">
							<a href="<?php echo $journey_link; ?>" class="img-wrapper-animate display-inherit;">
								<img src="<?php echo $jurl; ?>" alt="<?php echo $jalt; ?>" />
							</a>
							<div class="sub-header swiper-slide-exp-mobile"><a class="tdec" href="<?php echo SITEURL; ?>/experience/<?php echo $experience_name; ?>"><?php echo strtoupper($experience_name); ?></a></div>
							<a class="textdecnone" href="<?php echo $journey_link; ?>"><h5 style="margin-bottom:0" class="swiper-slide-exp-mobile"><?php echo $j_title; ?></h5></a>
							<p class="light swiper-slide-exp-mobile"><?php echo $j_desc; ?></p>
							<div class="location swiper-slide-exp-mobile">
								<span class="map"><?php echo $j_city; ?></span>
								<span class="day"><?php echo $tdays; ?></span>
								<a href="" data-toggle="modal" data-target="#myBook" data-image="<?php echo $purl; ?>" data-title="<?php echo $j_title; ?>" data-city="<?php echo $j_city; ?>" class="bkform float-right url">+ BOOK</a>
							</div>
						</div>
					</div>
					<?php
				}
				wp_reset_postdata();
			} 
			?>
		</div>
		<div class="text-center mr-top-40">
			<a href="<?php echo site_url(); ?>/filter_journey" class="btn btn-default view-all">VIEW ALL</a>
		</div> 
		
	</div>
</section>