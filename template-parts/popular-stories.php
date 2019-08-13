<?php
	$cat_id=get_cat_ID('Inspiring Journeys' );
	

	$popargs = array( 
		'post_type' => array( 'photostory', 'videostory', 'post'),
		'post_status' => 'publish',
		'posts_per_page' => 3,
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
	$pop_the_query = new WP_Query( $popargs );	
	if ( $pop_the_query->have_posts() ) : 	
?>
		<section class="exp-main journeys-cat-story-sec pstories">
			<div class="container">	
				<div class="popular-stories">
				<div class="s-header semi-bold">STORIES</div>
					<h2 class="light">Popular stories </h2>
					<!-- <h5 class="light  gray">Find travelogues, expert tips, food trails, reviews, columns & more…</h5> -->
					<div class="row">
						<?php	
						while ( $pop_the_query->have_posts() ) : $pop_the_query->the_post();	
							$pstories_id=get_the_ID();
							$pstories_title=get_the_title() ?: '';
							$pstories_link=get_the_permalink($pstories_id);
							$pfpost_type=get_post_type( get_the_ID() );
							if($pfpost_type=='videostory'){
							
								$article_icon_html='<img class="story_icon" src="'.get_template_directory_uri() .'/images/video_story.svg">';
								
							}elseif($pfpost_type=='photostory'){
								
								$article_icon_html='<i class="story_icon fas fa-camera"></i>';
								
							}else{
								
								$article_icon_html='<img class="story_icon" src="'.get_template_directory_uri() .'/images/popular_story.svg">';
								
							}
							if(has_post_thumbnail()){
								$pthumbimage_cloud = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
								if(strpos($pthumbimage_cloud,'cloudinary.com') > 0){
									$pthumbimage =  str_replace("image/upload/","image/upload/c_fill,ar_1.44,f_auto,q_auto,w_1920,g_auto/",$pthumbimage_cloud);
								}else{
									$pthumbimage = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );	
								}
							}
							else{
								$pthumbimage ='http://via.placeholder.com/672x454';
							} 
							if(has_post_thumbnail()){
								$pthumbimagecld = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
								if(strpos($pthumbimagecld,'cloudinary.com') > 0){
									$pthumbimage =  str_replace("image/upload/","image/upload/c_fill,ar_1.44,f_auto,q_auto,w_1920,g_auto/",$pthumbimagecld);
								}else{
									$pthumbimage = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );	
								}
							}
							else{
								$pthumbimage ='http://via.placeholder.com/432x298';
							}
						?>
						<?php //if(!empty($ahtml)){
							//echo $ahtml;
						//}
						?>
							<div class="col-xl-4 col-md-4 col-lg-4 col-sm-12">
								<a href=<?php echo $pstories_link; ?>>
									<div class="icon">
										<img src="<?php echo $pthumbimage; ?>" class="w-100 stor-height">
										<?php echo $article_icon_html; ?>
									</div>	
									
								</a>
								<h5><?php echo $pstories_title; ?></h5>
							</div><?php //if(!empty($html)){
							//echo '</a>';
						//} ?>
						<?php
						endwhile;
						?>
					</div>
				</div>
			</div>
		</section>
<?php
wp_reset_postdata();
endif;	
?>