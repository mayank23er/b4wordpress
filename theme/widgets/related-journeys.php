<?php 
/*Template Name: Related Journeys Template
*/
 if ( get_field( 'show_relatedjourneys' ) == 1 ) {
    ?>
    <section class="exp-main related-main">
      <div class="container">
        <div class="s-header semi-bold">RELEATED JOURNEY</div>
        <h2 class="light">You may like</h2>
        <div class="row">
       
            <?php if ( have_rows( 'acfselect_related_journeys' ) ) : ?>
              <?php while ( have_rows( 'acfselect_related_journeys' ) ) : the_row(); ?>
                <?php $post_object = get_sub_field( 'select_related_journeys' ); ?>
                <?php if ( $post_object ): ?>
                  <?php $post = $post_object; ?>
                  <?php setup_postdata( $post );
                  $similarid=$post->ID;
                  $tsdays=get_field('ACF_total_days',$similarid) ?: '';
                  $titlej=get_the_title($similarid);
                  $sj_city=get_field("ACF_journeycity",$similarid) ?: '';
                  $js_desc=get_field("ACF_journey_description",$similarid) ?: '';
                  $js_img=get_field("ACF_journeyhero_image",$similarid) ?: '';
                  if( !empty($js_img) ){
                    $jsurl = $js_img['url'];
                    $jsalt = $js_img['alt'] ?: '';
                    if(strpos($jsurl,'cloudinary.com') > 0){ 
                      $jsurl = str_replace("image/upload/","image/upload/c_fill,w_672,ar_1.48,q_auto:best,f_auto/",$jsurl);
                  }
                  }else{
                    $jsurl='http://via.placeholder.com/672x454';
                    $jsalt= '';
                  }
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
                    <a href="<?php the_permalink(); ?>"><img src="<?php echo $jsurl; ?>" alt="<?php echo  $jsalt; ?>" /></a>
                    <div class="sub-header"><?php echo strtoupper($experience_name); ?></div>
                    <h5><?php echo $titlej; ?></h5>
                    <p class="light"><?php echo $js_desc; ?></p>
                    <div class="location"><span class="map"><?php echo $sj_city; ?></span><span class="day"><?php echo $tsdays; ?></span><a href="" class="float-right url bkform"  data-toggle="modal" data-target="#myBook">+ BOOK</a></div>
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