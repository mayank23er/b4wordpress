<?php 
    $categories = get_the_category();
    $cat_slug='';
    if($categories){
      $cat_slug = $categories[0]->slug;
      $parent_cat_slug = parent_cat_slug($categories);
      
    }else{
      $cat_slug = $categories[0]->slug;
      $parent_cat_slug = parent_cat_slug($categories);
      
    }
    $args = array(
      'post__not_in' => array(get_the_ID()),
      'posts_per_page'=>8,
      'post_type'=>array(get_post_type( get_the_ID() ))
    );
    
    if($cat_slug !=""){
      $args=array(
        'post__not_in' => array(get_the_ID()),
        'posts_per_page'=>8,
        'post_type'=>array(get_post_type( get_the_ID() )),
        'category_name' => $cat_slug
      );
    }
  

    $my_query = new WP_Query($args);
    $count = $my_query->post_count;
    if($count>=4){
      $slider_ctclass="swiper-relative";  
    }
    else{
      $slider_ctclass="swiper-relative non-relative";
    }
  ?><?php
  if( $my_query->have_posts() ) {
?>
 <section class="story story-slider-inner">
    <div class="container">
      <div class="s-header semi-bold">STORIES</div>
       <h2 class="light">Travel inspiration </h2>
      <!-- Swiper -->
          
      <div class="<?php echo $slider_ctclass; ?>">
        <div class="swiper-container stories-slider">
          <div class="swiper-wrapper">
            <?php
              while ($my_query->have_posts()) : $my_query->the_post(); 
                if(has_post_thumbnail()):
                  $article_img = wp_get_attachment_url( get_post_thumbnail_id() );
                else:
                  $article_img = MAIN_DIR.'/images/placeholder-img.gif';
                endif;
                if(strpos($article_img,'cloudinary.com') > 0){ 
                  $article_img = str_replace("image/upload/","image/upload/c_fill,ar_1.5,g_auto/w_432,q_auto:best,f_auto/",$article_img);
                }
				$article_pstories_link=get_the_permalink(get_the_ID());
				$fpost_type=get_post_type( get_the_ID() ); 
						
				if($fpost_type=='videostory'){
					$article_icon_html='<img class="story_icon" src="'.get_template_directory_uri() .'/images/video_story.svg">';
					$ahtml="";
				}elseif($fpost_type=='photostory'){
					$article_icon_html='<i class="story_icon fas fa-camera"></i>';
					$ahtml="";
				}else{
					$ahtml="";
					$article_icon_html='<img class="story_icon" src="'.get_template_directory_uri() .'/images/popular_story.svg">';
				}
                ?>
                <div class="swiper-slide">
                  <div class="story-list article-story">
                    <div class="icon">
                      <a class="decoration-none" href="<?php echo get_the_permalink(); ?>">
						<div class="icon">
							<img src="<?php echo $article_img; ?>"  class="w-100">
							<?php echo $article_icon_html; ?>
						</div>	
                        
                        <?php /*if($my_query->post_type =="videos"){ ?>
                            <div class="video-icon explore-card">
                              <div class="arrow-icon-play"></div>
                              <div class="video-time"><?php echo $readTimeData; ?></div>
                          </div>
                        <?php } */ ?>
                      </a>
                    </div>
                    <h5><?php echo get_the_title(); ?></h5>
                  </div>
                </div>
             
              <?php
              endwhile;
            
            wp_reset_query();
            ?>
          </div>
          <?php if( $my_query->have_posts() ) { ?>
          <div class="swiper-pagination"></div>
          <!-- Add Arrows -->
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
          <?php } ?>
        </div>
      </div>
      
      <!-- Add Pagination -->
      
     </div>
   </section>  
   <?php
      }else{
        //do nothing
      }
      ?>