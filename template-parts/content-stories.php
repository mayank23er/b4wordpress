<?php
	$cat_id=get_cat_ID('Inspiring Journeys' );
	$argshere = array( 
		'post_type' => array( 'photostory', 'videostory', 'post'),
		'post_status' => 'publish',
		'posts_per_page' => 2,
		'orderby' => 'publish_date',
		'order' => 'DESC',
		'meta_query' => array(
			array(
			'key' => 'content_0_acf_category', // name of custom field
			'value' => $cat_id,
			'compare' => '='
			)
		)
	);
	
	$the_query = new WP_Query( $argshere );
	
	if ( $the_query->have_posts() ) : ?>
		<section class="exp-main story journeys-cat-story-sec inpiring-sec">
			<div class="container">
				<div class="s-header semi-bold">STORIES</div>
				<h2 class="light">Inspiring journeys </h2>
				<h5 class="light  gray">Stories of people who have had life changing experiences while travelling</h5>
				<div class="row">
					<?php
					while ( $the_query->have_posts() ) : $the_query->the_post();
						$stories_id=get_the_ID();
						$stories_title=get_the_title() ?: '';
						$stories_link=get_the_permalink($stories_id);
						$article_pstories_link=get_the_permalink($stories_id);
						$fpost_type=get_post_type( get_the_ID() ); 
						
						if($fpost_type=='videostory'){
							
							$article_icon_html='<img class="story_icon" src="'.get_template_directory_uri() .'/images/video_story.svg">';
							
						}elseif($fpost_type=='photostory'){
							
							$article_icon_html='<i class="story_icon fas fa-camera"></i>';
							
						}else{
							
							$article_icon_html='<img class="story_icon" src="'.get_template_directory_uri() .'/images/popular_story.svg">';
							
						}
						if(has_post_thumbnail()){
							$thumbimage_cloud = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
							if(strpos($thumbimage_cloud,'cloudinary.com') > 0){
								$thumbimage = str_replace("image/upload/","image/upload/c_fill,ar_1.48,f_auto,q_auto,w_1920,g_auto/",$thumbimage_cloud);
								}
								else{
									$thumbimage= wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
								}
						}
						else{
							$thumbimage ='http://via.placeholder.com/672x454';
						}
						?>
						<div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
							<div class="story-list">
								<a class="img-wrapper-animate" href="<?php echo $stories_link; ?>">
									<div class="icon">
										<img src="<?php echo $thumbimage; ?>" class="w-100 mh-story">
										<?php echo $article_icon_html; ?>
									</div>	
								</a>
								<h5><?php echo $stories_title; ?></h5>
							</div>
						</div>
						
					<?php
					endwhile;
					?>
				</div>
			</div>
		</section>
	<?php
	wp_reset_postdata();
	endif;	
	?>
<?php
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
		<section class="exp-main story journeys-cat-story-sec pstories">
			<div class="container">	
				<div class="popular-stories">
					<h2 class="light">Popular stories </h2>
					<h5 class="light  gray">Find travelogues, expert tips, food trails, reviews, columns & more…</h5>
					<div class="row">
						<?php	
						while ( $pop_the_query->have_posts() ) : $pop_the_query->the_post();	
							$pstories_id=get_the_ID();
							$pstories_title=get_the_title() ?: '';
							$pstories_link=get_the_permalink($pstories_id);
							$pfpost_type=get_post_type( get_the_ID() );
							if($pfpost_type=='videostory'){
								//$icon_html='<a href="'.$pstories_link.'"> <i class="fas fa-play-circle"></i></a>';
								$icon_html='<img class="story_icon" src="'.get_template_directory_uri() .'/images/video_story.svg">';
								$ahtml="";
							}elseif($pfpost_type=='photostory'){
								$icon_html='<i class="story_icon fas fa-camera"></i>';
								$ahtml="";
							}else{
								$ahtml="";
								$icon_html='<img class="story_icon" src="'.get_template_directory_uri() .'/images/popular_story.svg">';
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
						
							<div class="col-xl-4 col-md-4 col-lg-4 col-sm-12">
								<a href=<?php echo $pstories_link; ?>><div class="icon"><img src="<?php echo $pthumbimage; ?>" class="w-100 stor-height">
									<?php echo $icon_html; ?>
								</div></a>
								<h5><?php echo $pstories_title; ?></h5>
							</div>
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