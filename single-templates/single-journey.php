<?php
/*Template Name: Single Banner Template
*/
get_header(); ?>
<section class="journey-banner" >
  <div class="row row-eq-height ">
    <div class="col-xl-7 col-md-6 col-lg-6 col-sm-12 order-sm-12 main-journy-right">
      <?php 
			
			$journeys_id = get_the_ID();
	  		$ACF_journeyhero_image = get_field( 'ACF_journeyhero_image' );
		
			if ( $ACF_journeyhero_image ) { 
				if($ACF_journeyhero_image):
					$ACF_journeyhero_image = $ACF_journeyhero_image['url'];
					//$purl = $ACF_journeyhero_image['url'];
				else:
					$ACF_journeyhero_image = 'http://via.placeholder.com/1056x702';
					$purl = 'http://via.placeholder.com/408x766'; 
				endif;
				if(strpos($ACF_journeyhero_image,'cloudinary.com') > 0){ 
					$purl = str_replace("image/upload/","image/upload/c_fill,ar_0.53,q_auto:best,f_auto/",$ACF_journeyhero_image);
					$ACF_journeyhero_image = str_replace("image/upload/","image/upload/c_fill,ar_1.5,q_auto:best,f_auto/",$ACF_journeyhero_image);
				}
        
        ?>
        <img  class="w-100" src="<?php echo $ACF_journeyhero_image; ?>" alt="<?php echo $ACF_journeyhero_image['alt']; ?>" />
      <?php } ?>
    </div>
    <div class="col-xl-5 col-md-6 col-lg-6 col-sm-12 order-sm-1 journey-left main-journy-left">
      <div class="journey-wrap">
        <div class="container">
          <div class="row">  <div class="col-xl-4 col-md-6 col-lg-5 col-sm-12 ">
            <div class="s-header semi-bold">HOME > <?php $post_object = get_field( 'ACF_journey_experiences' );
            if ( $post_object ):
              $post = $post_object;
              setup_postdata( $post );
              $cat=get_the_title();
              echo strtoupper($cat);
              
              wp_reset_postdata();
              endif; ?></div>
              <h1 class="p1 baskerville"><?php the_title(); ?> </h1>
              <div class="location"><span class="map"><?php the_field('ACF_journeycity')  ?: ''; ?></span></div>
              <h5 class="light"><?php the_field('ACF_journey_description')  ?: ''; ?></h5></div></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="about-journey">
      <div class="container">
        <div class="row">
          <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
            <div class="s-header semi-bold">ABOUT</div>
            <h2 class="light"><?php the_field( 'ACF_journey_ableft' ); ?></h2>
          </div>
          <?php 
         
          //  $sdate=date_create(get_field( 'ACF_journey_smonth' ));
          //  $sdate=date_format($sdate,"d F Y "); 
              $sdate=get_field( 'ACF_journey_smonth' );
          //  $edate=date_create(get_field( 'ACF_journey_emonth' ));
               $edate=get_field( 'ACF_journey_emonth' );
           
          //  $edate=date_format($edate,"d F Y "); 
            
            ?>
          <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12 right-about-journey">
            <p class="light"><?php the_field( 'ACF_right_description' ); ?> </p>
            <h5 class="light"><strong>When</strong> <?php echo $sdate; ?> - <?php echo $edate; ?></h5>

            
          </div>
        </div>
      </div>
    </section>
	
    <?php 
	if (have_rows( 'gallery_images')) :  
		 ?>
		<section class="journey-gallery">
			<div class="container">
				<div class="s-header semi-bold">GALLERY</div>
				<div class="row">
					<?php 
					$gallery_count = count(get_field('gallery_images')); 
					if($gallery_count >= 1 && $gallery_count <= 6){
						
						//if image count is three on gallery
						$locate_cause= locate_template( 'template-parts/gallery/content-gallery'.$gallery_count.'.php' );
						if ( !empty( $locate_cause ) ) {
							get_template_part('template-parts/gallery/content-gallery'.$gallery_count);  
						}
					}	
					?>
				</div>
			</div>
		</section>
    <?php endif; ?>    

    <section class="itierary light">
      <div class="container post_wrap">
        <div class="s-header semi-bold">ITINERARY</div>
        <?php if ( have_rows( 'acf_itinerary_repeater' ) ) : 
          $countdays=1;
          ?>
          <?php while ( have_rows( 'acf_itinerary_repeater' ) ) : the_row(); ?>
          <div class="day-list pst">
          <div class="row">
            <div class="col-xl-2 col-md-3 col-lg-3 col-sm-12"><h5>Day <?php echo $countdays; ?></h5></div>
            <div class="col-xl-8 col-md-8 col-lg-8 col-sm-12">
              <p>  <?php the_sub_field( 'itinerary_description' ); ?></p></div>
          </div> 
        </div>
          <?php  $countdays=$countdays+1; endwhile; 
          ?>
        <?php else : ?>
          <?php // no rows found ?>
        <?php endif; ?>
        <span class="message url loadMore cpointer"></span>
          <!-- <a href="#" class="url loadMore"></a> -->
          <!-- <a href="#" class="url showLess">LESS</a> -->
        </div>
      </section>


      <section class="where light">
        <div class="container">
          <div class="row ">
            <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
              <div class="s-header semi-bold">WHERE</div>
              <h5><?php the_field( 'ACF_journeys_location' ); ?></h5>
              <p><?php the_field( 'ACF_wheredescription' ); ?></p>
              <?php if(!empty(get_field( 'ACF_wheredistance' ))){ ?>
              <strong>Distance </strong>
              <p><?php the_field( 'ACF_wheredistance' ); ?></p>
              <?php } ?>
            </div>
            <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
            <?php
            if ( get_field( 'show_map' ) == 1 ) {
              //$mapcode=get_field( 'map_shortcode' ); 
             // echo do_shortcode($mapcode);
            }else{
              //do nothing
            }
            ?>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1732.8520387038975!2d79.70117549924394!3d29.69935806572562!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39a0b5ae1e479f0d%3A0x97df21d93270636f!2sClub+Mahindra+Binsar+Valley%2C+Uttarakhand!5e0!3m2!1sen!2sin!4v1531583721375" width="100%" height="339" frameborder="0" style="border:0" allowfullscreen></iframe> 
              <a target='_blank' href="https://www.google.com/maps/search/<?php echo the_field('ACF_journeycity'); ?>"  class="url ">VIEW MAP</a>
            </div>
          </div>
        </div>
      </section>

      <section class="highlights light">
        <div class="container">
          <div class="s-header semi-bold">HIGHLIGHTS</div>
          <?php 
			if ( have_rows( 'ACF_journey_highlights' ) ){
			  $counterli=1;?>
				<div class="row ">
					<div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
						<ul>
						<?php 
						while ( have_rows( 'ACF_journey_highlights' ) ) : the_row(); ?>
							<li> <?php the_sub_field( 'acf_highlights' ); ?> </li>
							<?php 
							if($counterli%4==0) { 
								echo '</ul></div>  <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12"><ul>';  
							} 
							?>
							<?php  
							$counterli++; 
							endwhile; 
							?>
						</ul>
					</div>
              </div>
			<?php 
			} ?>  


              <div class="inclusion">
                <div class="s-header semi-bold">INCLUSIONS</div>
                <?php 
				if ( have_rows( 'ACF_inclusions_text' ) ){
				  $counterli=1;?>
					<div class="row ">
						<div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
							<ul>
							<?php 
							while ( have_rows( 'ACF_inclusions_text' ) ) : the_row(); ?>
								<li> <?php the_sub_field( 'ACF_inclusions_text_highlights' ); ?> </li>
								<?php 
								if($counterli%4==0) { 
									echo '</ul></div>  <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12"><ul>';  
								} 
								?>
								<?php  
								$counterli++; 
								endwhile; 
								?>
							</ul>
						</div>
				  </div>
				<?php 
				} ?>  
              </div>
              <div class="exclusion">
                <div class="s-header semi-bold">EXCLUSIONS</div>
                <?php 
				if ( have_rows( 'ACF_exclusionstext' ) ){
				  $counterli=1;?>
					<div class="row ">
						<div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
							<ul>
							<?php 
							while ( have_rows( 'ACF_exclusionstext' ) ) : the_row(); ?>
								<li> <?php the_sub_field( 'ACF_exclusionstext_highlights' ); ?> </li>
								<?php 
								if($counterli%4==0) { 
									echo '</ul></div>  <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12"><ul>';  
								} 
								?>
								<?php  
								$counterli++; 
								endwhile; 
								?>
							</ul>
						</div>
				  </div>
				<?php 
				} ?>  
              </div>
            </div>
          </section>

          <?php
          $fetchhomeid=get_id_by_slug('home');
          if ( get_field( 'journeys_with_a_cause' ) == 1 ) { ?>
            <section class="jouney-vocation">
              <div class="container">
                <div class="row">
                  <div class="col-xl-4 col-md-4 col-lg-4 col-sm-12">
                    <div class="text-abo">
                      <div class="s-header semi-bold"><?php the_field( 'ACF_causesection_title',$fetchhomeid ); ?> </div>
                      <h2 class="light"><?php the_field( 'ACF_causetitle',$fetchhomeid); ?></h2>
                      <h5 class="light"><?php the_field( 'ACF_jcause_description',$fetchhomeid ); ?></h5>
                      <!--<a href="" class="btn btn-default view-jou">VIEW JOURNEYS</a>-->
                      <?php
                      if ( get_field( 'ACF_causeshow_button',$fetchhomeid ) ){
                        $btn_cta=get_field("ACF_causebutton_cta",$fetchhomeid) ?: '';
                        $btn_cta_url=get_field("ACF_causebutton_url",$fetchhomeid) ?: '';
                        $btn_cta_target=get_field("ACF_button_target",$fetchhomeid) ?: '';
                        echo '<a href="'.$btn_cta_url.'" target="'.$btn_cta_target.'" class="btn btn-default view-jou">'.$btn_cta.'</a>
                        ';
                      }
                      ?>
                    </div>
                  </div>
                  <div class="col-xl-8 col-md-8 col-lg-8 col-sm-12">
                    <?php $ACF_cause_inner_image = get_field( 'ACF_cause_inner_image',$fetchhomeid );
                    if ( $ACF_cause_inner_image ) { ?>
                      <img  class="w-100" src="<?php echo $ACF_cause_inner_image['url']; ?>" alt="<?php echo $ACF_cause_inner_image['alt']; ?>" />
                    <?php } ?>
                  </div>
                </div>
              </div>
            </section>
          <?php } ?>
          <?php if ( get_field( 'ACF_show_journeys' ) == 1 ) {
            ?>
            <section class="exp-main related-main">
              <div class="container">
                <div class="s-header semi-bold">SIMILAR JOURNEY</div>
                <h2 class="light">You may like</h2>
                <div class="row">
               
                    <?php if ( have_rows( 'ACF_similar_journeys' ) ) : ?>
                      <?php while ( have_rows( 'ACF_similar_journeys' ) ) : the_row(); ?>
                        <?php $post_object = get_sub_field( 'ACF_selected_journeys' ); ?>
                        <?php if ( $post_object ): ?>
                          <?php $post = $post_object; ?>
                          <?php setup_postdata( $post );
                          $similarid=$post->ID;
                          $tsdays=get_field('ACF_total_days',$similarid) ?: '';
                          $sj_city=get_field("ACF_journeycity",$similarid) ?: '';
                          $js_desc=get_field("ACF_journey_description",$similarid) ?: '';
                          $js_img=get_field("ACF_journeyhero_image",$similarid) ?: '';
                          if( !empty($js_img) ){
                            $jsurl = $js_img['url'];
                            $jsalt = $js_img['alt'] ?: '';
							if(strpos($jsurl,'cloudinary.com') > 0){
                $mpurl = str_replace("image/upload/","image/upload/c_fill,ar_0.53,w_408,q_auto:best,f_auto/",$jsurl);
								$jsurl = str_replace("image/upload/","image/upload/c_fill,ar_1.48,f_auto,q_auto,w_1920,g_auto/",$jsurl);
								
							}	
                          }else{
                            $jsurl='https://via.placeholder.com/672x454';
                            $jsalt= '';
                          }
                          $mtitle=get_the_title($similarid);
                          $exp_object = get_field('ACF_journey_experiences',$similarid);
                          if( $exp_object ): 
                            // override $post
                            $exppost = $exp_object;
                            setup_postdata($exppost); 
                            $expId=$exppost->ID;
                            $experience_name=get_the_title($expId); 
                            wp_reset_postdata(); 
                          endif;
                          ?> <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
                          <div class="exp-list">
                            <a class="img-wrapper-animate display-inherit;" href="<?php the_permalink($similarid); ?>"><img src="<?php echo $jsurl; ?>" alt="<?php echo  $jsalt; ?>" /></a>
                            <div class="sub-header"><?php echo strtoupper($experience_name); ?></div>
                            <h5><?php echo $mtitle; ?></h5>
                            <p class="light dk-jndesc"><?php echo $js_desc; ?></p>
                            <div class="location"><span class="map"><?php echo $sj_city; ?></span><span class="day"><?php echo $tsdays; ?></span>
                            <a href=""  data-toggle="modal" data-target="#myBook" data-image="<?php echo $mpurl; ?>" data-title="<?php echo $mtitle; ?>" data-city="<?php echo $sj_city; ?>" class="bkform float-right url">+ BOOK</a></div>
                          </div>
                        </div>
                        <?php wp_reset_postdata(); 
                      endif;
                    endwhile; 
                  else : 
                  // no rows found 
                  endif; ?>
                
              </div>
            </section>
          <?php } ?>

        <?php          
  // Template Stories Posts
    include(locate_template( 'template-parts/popular-stories.php'));
	$total_duration=get_field( 'total_nights',$journeys_id )." Nights ".get_field( 'total_days',$journeys_id )." Days";
?>

          <section class="sticky-book" style="padding-bottom:15px !important;">
            <div class="container">
              <div class="row">
                <div class="col-xl-6 col-md-6 col-lg-6 col-7">
                  <h6><?php echo $total_duration; ?></h6>
                  <h5><?php the_field('ACF_jprice'); ?> </h5>
                </div>
                <div class="col-xl-6 col-md-6 col-lg-6 col-5">
                  <a  data-toggle="modal" data-target="#myBook" data-image="<?php echo $purl; ?>" data-title="<?php echo the_title(); ?>" data-city="<?php the_field('ACF_journeycity'); ?>" class=" bkform btn btn-default book-now ">BOOK</a>
                  
                </div>
              </div>
            </section>
            <?php
            wp_enqueue_script( 'fancy-js', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js');
            wp_enqueue_style( 'fancy-css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css');
            get_footer();
            ?>
<script>
$ShowHideMore = $('.post_wrap');
$ShowHideMore.each(function() {
    var $times = $(this).children('.pst');
    if ($times.length > 2) {
        $ShowHideMore.children(':nth-of-type(n+4)').addClass('moreShown').hide();
        $(this).find('span.message').addClass('more-times').html('MORE');
    }
});

$(document).on('click', '.post_wrap > span', function() {
  var that = $(this);
  var thisParent = that.closest('.post_wrap');
  if (that.hasClass('more-times')) {
    thisParent.find('.moreShown').show();
    that.toggleClass('more-times', 'less-times').html('LESS');
  } else {
    thisParent.find('.moreShown').hide();
    that.toggleClass('more-times', 'less-times').html('MORE');
  }  
});
    
</script>
<script>
 jQuery(function(){
	 jQuery('[data-fancybox]').fancybox({
            keyboard: true,
            loop: false,
            image: {
                preload: false
            },
            buttons: [
                "thumbs",
                "close"
            ]

        });
 });
 </script>
 <style>
 .icon{
   z-index:98;
 }
 </style>
