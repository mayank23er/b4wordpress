<?php
/* 
Template Name: Popular Stories
*/
get_header();
//header white js
wp_register_script('experience-js', get_template_directory_uri() . '/theme/js/experience.js',array('jquery'), null, true);
wp_enqueue_script('experience-js');
$cat_id=get_cat_ID('Inspiring Journeys' );
$args = array( 
	'post_type' => array( 'photostory', 'videostory', 'post'),
	'post_status' => 'publish',
	'posts_per_page' => 4,
	'orderby' => 'publish_date',
	'order' => 'DESC',
	'meta_query' => array(
		array(
			'key' => 'content_0_acf_category', // name of custom field
			'value' => $cat_id,
			'compare' => '!='
		)
	)
);
$loop = new WP_Query( $args );


$args_org = array( 
	'post_type' => array( 'photostory', 'videostory', 'post'),
	'post_status' => 'publish',
	'orderby' => 'publish_date',
	'posts_per_page' => -1,
	'order' => 'DESC',
	'meta_query' => array(
		array(
			'key' => 'content_0_acf_category', // name of custom field
			'value' => $cat_id,
			'compare' => '!='
		)
	)
);
$loop_org = new WP_Query( $args_org );
if ( $loop->have_posts() ) :
?>
<section class="exp-main story top-mb-5 top-section-margin popStory-margin">
        <div class="container">
        <h1 class="normal journeys-cat-h text-center"><?php the_title(); ?></h1>
        <h5 class="light gray text-center subTitle-spacing">
            <?php
            $desc=get_field( 'stories_description' ) ?: ''; 
            if(!empty($desc)){
                echo $desc;
            }
            ?>
        </h5>
        <div class="row">
            <?php
            while ( $loop->have_posts() ) : $loop->the_post();  
			$jid=get_the_ID();
			$jtitle=get_the_title() ?: '';
            $jlink=get_the_permalink($jid);
            $pfpost_type=get_post_type( get_the_ID() ); 
			
			if($pfpost_type=='videostory'){
				$icon_html='<img class="story_icon" src="'.get_template_directory_uri() .'/images/video_story.svg">';
				$ahtml="";
			}elseif($pfpost_type=='photostory'){
				$icon_html='<i class="story_icon fas fa-camera"></i>';
				$ahtml="";
			}else{
				$ahtml="";
				$icon_html='<img class="story_icon" src="'.get_template_directory_uri() .'/images/popular_story.svg">';
			}
            $jdesc=get_field("content_0_header_text",$jid) ?: '';
            if(has_post_thumbnail()){
                $timage_cloud = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
                if(strpos($timage_cloud,'cloudinary.com') > 0){
                $timage = str_replace("image/upload/","image/upload/c_fill,ar_1.48,f_auto,q_auto,w_1920,g_auto/",$timage_cloud);
                }
                else{
                    $timage= wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
                }
              }
              else{
                  $timage ='http://via.placeholder.com/672x454';
              }
            ?>
            <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
				<div class="exp-list">
					<a href="<?php echo $jlink; ?>" class="img-wrapper-animate display-inherit;">
						<div class="icon">
							<img src="<?php echo $timage; ?>" alt="" />
							<?php echo $icon_html; ?>
						</div>	
						
					</a>
					<h5><?php echo $jtitle; ?></h5>	
					<p class="light dk-jndesc"><?php echo $jdesc; ?></p>
						
				</div>
            </div>
			
            <?php
            endwhile;	
            ?>
        </div>   
        <?php 
			if($loop_org->post_count>4){
				echo do_shortcode( '[ajax_load_more id="inspiring_journeys_1"  button_label="Load More" container_type="div" css_classes="row" repeater="template_1" post_type="post, photostory, videostory" posts_per_page="8" category="popular-stories" category__not_in="5" offset="4"  transition_container="false" scroll_distance="50"]' );
			}
		
		 ?>
        </div>   
</section>       

<?php
endif;
get_footer();
?>