<?php

$post_tag=create_slug($_GET['tag']);
$post_to_be_show = 4;
$argshere = array( 
	'post_type' => array( 'photostory', 'videostory', 'post'),
	'post_status' => 'publish',
	'posts_per_page' => $post_to_be_show,
	'orderby' => 'publish_date',
	'order' => 'DESC',
	'tag' => $post_tag, 
);
$argsherecount = array( 
	'post_type' => array( 'photostory', 'videostory', 'post'),
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'publish_date',
	'order' => 'DESC',
	'tag' => $post_tag, 
);
$the_query = new WP_Query( $argshere );
$the_query_count = new WP_Query( $argsherecount );
$count = $the_query_count->post_count;
if ( $the_query->have_posts() ) {
	?>
	
	<section class="exp-main story journeys-cat-common-exp top-section-margin">
		<div class="container">
		<h1 class="normal journeys-cat-h  text-center tag-hmargin"><?php echo str_replace(array("_","-"),array(" "," "),$post_tag); ?></h1>
			<div class="row desktop-slider">
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
			$tagpost_id=get_the_ID();
			$tagpost_title=get_the_title() ?: '';
			$tagpost_link=get_the_permalink($tagpost_id);
			$tagpost_type=get_post_type( get_the_ID() ); 
			$tagpost_img=get_field("ACF_journeyhero_image",$tagpost_id) ?: '';
			$t_desc=get_field('content_0_header_text',$tagpost_id) ?: '';
			
			if($tagpost_type=='videostory'){
				
				$article_icon_html='<img class="story_icon" src="'.get_template_directory_uri() .'/images/video_story.svg">';
				
			}elseif($tagpost_type=='photostory'){
				
				$article_icon_html='<i class="story_icon fas fa-camera"></i>';
				
			}else{
				
				$article_icon_html='<img class="story_icon" src="'.get_template_directory_uri() .'/images/popular_story.svg">';
				
			}

			if(has_post_thumbnail()){
				$rightimage_cloud = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
				if(strpos($rightimage_cloud,'cloudinary.com') > 0){
					$rightimage = str_replace("image/upload/","image/upload/c_fill,ar_1.48,f_auto,q_auto,w_1920,g_auto/",$rightimage_cloud);
				}else{
					$rightimage = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
				}	
			  }
			  else{
				 $rightimage ='http://via.placeholder.com/672x454';
			  }

			
			
			if( @$exp_object ): 
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
						<a href="<?php echo $tagpost_link; ?>" class="img-wrapper-animate display-inherit;">
							<div class="icon">
								<img src="<?php echo $rightimage; ?>" alt="<?php echo $tagpost_title; ?>" />
								<?php echo $article_icon_html; ?>
							</div>	
							
						</a>
						<h5><?php echo $tagpost_title; ?></h5>	
						<p class="light dk-jndesc"><?php echo $t_desc; ?></p>
							
					</div>
				</div>
		<?php	endwhile; ?>
			</div>
			<?php 
			if($count > $post_to_be_show){
				echo do_shortcode('[ajax_load_more id="inspiring_journeys_1" button_label="Load More" container_type="div" css_classes="row loadmore-custom" repeater="template_1" post_type="post, photostory, videostory" posts_per_page="6" category="inspiring-journeys,popular-stories" tag="'.$post_tag.'" offset="4" transition_container="false" scroll_distance="50"]'); 	
			}		
			?>
		</div>
	</section>
	
	<?php }  ?>