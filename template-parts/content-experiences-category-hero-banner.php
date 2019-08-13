<?php
/**
* Template part for displaying posts
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package RoundGlass_Journeys
*/
?>
<?php
// Find all the Journeys for the selected Experience.
$experience_id = get_the_ID(); 
$today = date('Ymd'); 
$firstjourney = array(
    //'posts_per_page'   => -1,
    'numberposts'   => 1,
    'post_type'        => 'journey',
    'meta_key' => 'ACF_journey_smonth',
    'post_status'	=> 'publish',
    'orderby' => 'publish_date',
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
        $recent_posts = wp_get_recent_posts( $firstjourney );
        if(!empty($recent_posts)) {
            $first_jid=$recent_posts[0]["ID"];
            $fj_title=get_the_title() ?: '';
			$dkrtitle=get_the_title($first_jid) ?: '';
            $fjourney_link=get_the_permalink($first_jid);
            $fj_img=get_field("ACF_journeyhero_image",$first_jid) ?: '';
            if( !empty($fj_img) ){
             $fjurl_cloud = $fj_img['url'];
             if(strpos($fjurl_cloud,'cloudinary.com') > 0){
                $pjurl =  str_replace("image/upload/","image/upload/c_fill,ar_0.53,f_auto,q_auto,w_408/",$fjurl_cloud);
                $fjurl =  str_replace("image/upload/","image/upload/c_fill,ar_2.32,f_auto,q_auto,w_auto/",$fjurl_cloud);
               }else{
                $fjurl = $fj_img['url'];
                $pjurl = $fj_img['url'];
                }
                $fjalt = $fj_img['alt'] ?: '';
            }else{
                $fjurl='http://via.placeholder.com/672x454'; 
                $pjurl='http://via.placeholder.com/408x766'; 
                $fjalt= '';
            }
            $fj_desc=get_field("ACF_journey_description",$first_jid) ?: '';
            $fj_city=get_field("ACF_journeycity",$first_jid) ?: '';
            $fexp_object = get_field('ACF_journey_experiences',$first_jid);
            $total_nights=get_field( 'total_nights',$first_jid ); 
            $total_days=get_field( 'total_days',$first_jid );
            $ftdays=$total_nights." Nights ".$total_days. " Days";

            if( $fexp_object ): 
                // override $post
                $fexppost = $fexp_object;
                setup_postdata($fexppost); 
                $fexpId=$fexppost->ID;
                $fexperience_name=get_the_title($fexpId); 
                wp_reset_postdata(); 
            endif;
            
        
        ?>
        <?php $experiences_category_banner_image = get_field( 'experiences_category_banner_image' ); ?>
        <section class="exp-main journeys-cat-common-banner-sec articles-marginT">
			<div class="container">
				<h2 class="normal journeys-cat-h  text-center"><?php the_title(); ?></h2>
				<?php if(!empty(get_field( 'ACF_experience_description' ))){ ?>
					<h5 class="light gray  text-center"><?php the_field( 'ACF_experience_description' );  ?></h5>
				<?php } ?>
				<div class="exp-list journeys-cat-cover-img journeys-cat-cover-img-desk cstm-anchor cpointer" data-href='<?php echo $fjourney_link; ?>' style="background-image: url(<?php echo $fjurl; ?>);">
					<div class="exp-list journeys-cat-exp-list">
						<h3 class="dk-image cstm-anchor" data-href='<?php echo $fjourney_link; ?>'><?php echo $dkrtitle; ?></h3>
						<h5 class="mb-image hide-mb cstm-anchor" data-href='<?php echo $fjourney_link; ?>'><?php echo $dkrtitle; ?></h5>
						<h5 class="light dk-image"><?php echo $fj_desc; ?></h5>
						<p class="light mb-image"><?php echo $fj_desc; ?></p>
						<div class="location mbackloc"><span class="map"><?php echo $fj_city; ?></span>
							<span class="day"><?php echo $ftdays; ?></span>
							<a href="<?php echo $fjourney_link; ?>" style="background:none;color:#e16261;margin-right:0; padding-right:0" class="mb-image bkform float-right url">MORE</a>
							
						</div>
					</div>
					<div class="float-right journeys-cat-cover-img-cta-wrap">
							<a href="<?php echo $fjourney_link; ?>" class="dk-image bkform float-right url journeys-cat-cover-img-cta">MORE</a>
					</div>
				</div>
			</div>
        </section>
<?php
  }
  else{
      ?>
<section class="exp-main journeys-cat-common-banner-sec">
        <div class="container">
        <h2 class="normal journeys-cat-h  text-center">NO JOURNEYS</h2>

        </div>
        </section>
      <?php
  }
?>                