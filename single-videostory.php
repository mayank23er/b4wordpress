<?php get_header(); ?>
<?php
$categories = get_the_category();
if($categories){
    $cat_slug = $categories[0]->slug;
    $parent_cat_slug = parent_cat_slug($categories);
    $permalink = home_url()."/category/".$parent_cat_slug."/".$cat_slug;
}else{
    $cat_slug = $categories[0]->slug;
    $parent_cat_slug = parent_cat_slug($categories);
    $permalink = home_url();
}


if ( ! empty( $categories ) ) {
    $cat_url = $permalink; 
    $cat_text = esc_html( $categories[0]->name );
}

$postAuthorIDHere = $post->post_author;
$postAuthorHere = ucwords(get_the_author_meta('display_name', $postAuthorIDHere));
$author_url = get_author_page_link_by_article_id(get_the_ID());

//Add Flexible content if statement
if ( have_rows( 'content' ) ): 
 while ( have_rows( 'content' ) ) : the_row(); 
     if ( get_row_layout() == 'article_header' ) : 
         if(get_sub_field( 'header_style' )==MAIN_DIR.'/images/Header_style2.jpg'){
            $acf_category_term = get_sub_field( 'acf_category' ) ?: '';    
            ?>
    <section class="community articles-marginT">
    <div class="container video-article">
     <div class="row">
      <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12"> 
         <div class="s-header semi-bold uppercase top-cat-style"><?php echo $acf_category_term->name; ?></div>
         <h2 class="semi-bold top3"><?php the_title(); ?></h2>
             <h5 class="video-para light vtext-style"><?php the_sub_field( 'header_text' ); ?></h5>
         </div> 
       
     </div>
 </div>
</section>
    <?php } ?>  
    <?php 
//paragarph text
elseif ( get_row_layout() == 'text' ) : 
    $para=get_sub_field('text');
    ?>
    <section class="community">
        <div class="container">
            <div class="community-wrap">
                <div class="comunity-content-wrap">
                    <?php
                    if ( get_sub_field( 'ACF_showtitle' ) == 1 ) { 
                        echo '<h5>'.the_sub_field( 'title' ).'</h5>';
                    }
                    ?>

                    <div class="pstyle3"><?php echo $para; ?></div>
                </div>
            </div>
        </div>
    </section>
    <?php 
//full width image
    elseif ( get_row_layout() == 'image' ) : ?>
        <?php $image = get_sub_field( 'image' ); ?>
        <?php if ( $image ) : ?>
            <section class="image-article-section community paddTopBottomArticleSection paddTopBottomZero">
                <a href="<?php echo $image['url']; ?>" data-fancybox="images" data-caption="<?php the_sub_field( 'caption' ); ?>"> 
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                </a>
                <p class="img-caption community-wrap"><?php the_sub_field( 'caption' ); ?></p>
            </section>  
        <?php endif;
    elseif ( get_row_layout() == 'two_column_masonary' ) :
        //echo 'mayank';
        if ( have_rows( 'twocol_image_masonary' ) )  :   ?>
        <section class="2_column_masonary community paddTopBottomArticleSection paddTopBottomZero">
            <div class="container">
              <div class="community-wrap">
                 <div class="photogallery">  
                    <div class="row">
                        <?php while ( have_rows( 'twocol_image_masonary' ) ) : the_row(); ?>
                            <?php $twocol_mas_image = get_sub_field( 'twocol_mas_image' ); ?>
                            <?php if ( $twocol_mas_image ) { ?>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                    <a href="<?php echo $twocol_mas_image['url']; ?>" data-fancybox="images">
                                        <img src="<?php echo $twocol_mas_image['url']; ?>" alt="<?php echo $twocol_mas_image['alt']; ?>" />
                                    <?php } ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>   
            </div>     
        </section>  
        <?php else : ?>
            <?php // no rows found ?>
        <?php endif; ?>
        <?php 
    //Quote
        elseif ( get_row_layout() == 'quote' ) : ?>
            <section class="quote-article-section community paddTopBottomArticleSection paddTopBottomZero">
                <div class="container">
                    <div class="community-wrap">
                        <div class="comunity-content-wrap">
                            <hr/>
                            <h2 class="text-center light">
                                <?php the_sub_field( 'quote' ); ?>
                            </h2>
                            <hr/>
                        </div>
                    </div>
                </div>
            </section>
            <?php 
        //3 Image Grid
            elseif ( get_row_layout() == '3_image_masonary' ) : ?>
                <?php if ( have_rows( 'ACF_image_masnoary' ) ) : ?>
                 <section class="3_image_masonary community paddTopBottomArticleSection paddTopBottomZero">
                    <div class="container mr-b-30 mr-top-40  "> 
                        <div class="comunity-content-wrap">
                            <div class="row">
                                <?php 
                                $i=1;
                                while ( have_rows( 'ACF_image_masnoary' ) ) : the_row(); 
                                   $ACF_3image_repeat = get_sub_field( 'ACF_3image_repeat' ); 
                                   if ( $ACF_3image_repeat ) { 
                                    if($i==1){ ?>
                                     <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                        <a href="<?php echo $ACF_3image_repeat['url']; ?>" data-fancybox="images" data-caption="<?php echo $ACF_3image_repeat['alt']; ?>">
                                            <img src="<?php echo $ACF_3image_repeat['url']; ?>" class="w-100">
                                        </a>

                                    </div> 
                                    <?php 
                                }
                                else {  ?>
                                    <div class="col-xl-6 col-md-12 col-lg-12 col-6">
                                        <a href="<?php echo $ACF_3image_repeat['url']; ?>" data-fancybox="images" data-caption="<?php echo $ACF_3image_repeat['alt']; ?>">
                                            <img src="<?php echo $ACF_3image_repeat['url']; ?>" class="w-100">
                                        </a>

                                    </div>                   

                                <?php } 

                            } 
                            $i++;

                        endwhile; ?>
                    </div>
                </div>
                <div class="comunity-content-wrap"><p class="img-caption"><?php the_sub_field('3_col_caption');  ?></p></div>
            </div>
        </section>
        <?php else : ?>
            <?php // no rows found ?>
        <?php endif; ?>
        <?php 
                // Container Fit image
        elseif ( get_row_layout() == 'container_fit_single_image' ) : ?>
            <?php $ACF_container_fit_image = get_sub_field( 'ACF_container_fit_image' ); ?>
            <?php if ( $ACF_container_fit_image ) { ?>
                <section class="container_fit_single_image community paddTopBottomArticleSection paddTopBottomZero">
                    <div class="container">
                        <div class="community-wrap">
                            <a href="<?php echo $ACF_container_fit_image_url; ?>" data-fancybox="images" data-caption="<?php the_sub_field( 'Conatiner_Image_caption' );  ?>">
                                <img src="<?php echo $ACF_container_fit_image['url']; ?>" alt="<?php echo $ACF_container_fit_image['alt']; ?>" />
                            </a>
                            <div class="comunity-content-wrap">
                              <p class="img-caption"><?php the_sub_field( 'Conatiner_Image_caption' );  ?></p>
                          </div>
                      </div>
                  </div>
              </section>
          <?php } ?>

          <?php elseif ( get_row_layout() == 'video_full_width' ) : ?>
            <?php 
            $youtube_embed_code_full_width = get_sub_field( 'youtube_embed_code_full_width' );
           $video_id=$youtube_embed_code_full_width['vid']; 
         
        // var_dump( $youtube_embed_code_full_width );

         
       ?>
       	<section class="video_full_width paddTopBottomArticleSection paddTopBottomZero">
   
         <div class="videoWrapper">
		<iframe width="1200" src="<?php echo 'https://www.youtube.com/embed/'.$video_id.'?rel=0'; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen="" id="widget2"></iframe>
        </div> 
     
        </section>
       <?php
        endif; 
    endwhile; 
else: 
       // no layouts found 
endif;

//Author section starts
// $locate_author_info = locate_template( 'template-parts/content-author_info.php' );
// if ( !empty( $locate_author_info ) ):
// get_template_part( 'template-parts/content-author_info' );  
// endif; 
$postAuthorIDHere = $post->post_author;
$postAuthorHere = ucwords(get_the_author_meta('display_name', $postAuthorIDHere));
$author_url = get_author_page_link_by_article_id(get_the_ID());
?>

	<section class="community paddTopBottomArticleSection paddTopBottomZero">
		<div class="container">
			<div class="community-wrap">
				<div class="tag-comm">
					<div class="written">
						<div class="row">
							<div class="col-xl-7 col-md-6 col-lg-6 col-sm-12">
								<div class="media">
									<?php if ( get_field( 'AUTHORIMAGE' ) ) { 
										$author_img = get_field( 'AUTHORIMAGE' );
										// if(strpos($author_img,'cloudinary.com') > 0){ 
										// 	$author_img = str_replace("image/upload/","image/upload/c_fill,ar_1:1,g_auto/w_80,q_auto:best,f_auto/",$author_img);
										// }
										
									?>
										<a href="<?php echo $author_url; ?>" class="author-no-decor"><img class="mr-4 rounded-circle" src="<?php echo $author_img; ?>" /></a>
									<?php } ?>
									
									<!-- <div class="media-body">
										<h6 class="mt-0 light"><?php //the_field( 'WrittenByText' ); ?></h6>
										<h5 class="mt-0"><a href="<?php //echo $author_url; ?>" class="author-no-decor"><?php //echo $postAuthorHere;; ?></a></h5>
									</div> -->
								</div>
							</div>
							<div class="col-xl-5 col-md-6 col-lg-6 col-sm-12">
								<div class="share">
									<h5 class="light"><?php the_field( 'ShareStoryText' ); ?></h5>  
									<?php 
										$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
										
										if(has_post_thumbnail()):
											$fb_image = get_the_post_thumbnail_url();
										else:
											$fb_image =get_field('thumbnail_image_custom', $post->ID);
										endif;
										// if(strpos($fb_image,'cloudinary.com') > 0){ 
										// 	$fb_image = str_replace("image/upload/","image/upload/c_fill,ar_16:9,g_auto/w_1920,q_auto,f_auto/",$fb_image);
										// }
											?>
								
								<ul class="list-inline a2a_kit a2a_kit_size_32 a2a_default_style">
										<li class="list-inline-item">
											<a href="#" data-url="<?php echo $actual_link; ?>" data-image="<?php echo $fb_image; ?>"  data-description="<?php echo get_card_excerpt_of_article($post->ID); ?>" data-title="<?php echo get_the_title(); ?>" class="share-on-fb-article">
											<i class="fab fa-facebook-f"></i>
											</a>
										</li>
										<li class="list-inline-item">
											<a href="https://twitter.com/home?status=<?php echo esc_html( get_the_title() )." ".get_permalink(); ?>" class="twitter" title="Share on Twitter" target="_blank">
											<i class="fab fa-twitter"></i></a>
										</li>
										<li class="list-inline-item">
											<a href="https://plus.google.com/share?url=<?php echo get_permalink(); ?>" class="gplus" title="Share on Google+" target="_blank"><i class="fab fa-instagram"></i></a>		
										</li>
										<li class="list-inline-item"><a href=""><i class="fab fa-linkedin-in"></i></a></li>
									</ul>
									
								</div>
							</div>
						</div>
					</div>
					<?php 
					$post_tags = get_the_tags(); 
						if ( $post_tags ) { ?>
					<div class="tagged-in">
						<h5 class="light"><?php the_field( 'TaggsInText' ); ?>
						<?php
								foreach( $post_tags as $tag ) {
									$term_url = home_url().'/search_term/?tag='.$tag->name;	
									echo '<span><a href="'.$term_url.'" class="tag-button">'.strtoupper($tag->name).'</a></span>'; 
								}
							?>
						</h5>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>

<?php	

 //stories slider    
 $locate_journeys = locate_template( 'theme/widgets/stories-slider.php' );
 if ( !empty( $locate_journeys ) ):
     include(locate_template( 'theme/widgets/stories-slider.php'));
 endif; 
 
//Related Journeys
$locate_journeys = locate_template( 'theme/widgets/related-journeys.php' );
 if ( !empty( $locate_journeys ) ):
     include(locate_template( 'theme/widgets/related-journeys.php'));
 endif; 

get_footer(); 
?>

<style>
.community {
    padding: 50px 0 0;
}
</style>