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
            $container_aspectratio=0.68;
            $w=w_799;
            wp_register_script('experience-js', get_template_directory_uri() . '/theme/js/experience.js',array('jquery'), null, true);
            wp_enqueue_script('experience-js');
            $acf_category_term = get_sub_field( 'acf_category' ) ?: '';    
            ?>
            <section class="community articles-marginT">
            <div class="container">
            <div class="row">
            <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12"> 
            <div class="s-header semi-bold uppercase top-cat-style"><?php echo @$acf_category_term->name; ?></div>
            <h2 class="semi-bold top3"><?php the_title(); ?></h2>
            <h5 class="video-para light vtext-style"><?php the_sub_field( 'header_text' ); ?></h5>
            </div> 
            </div>
            </div>
            </section>
            <?php } elseif (get_sub_field( 'header_style' )==MAIN_DIR.'/images/Header_style1.jpg') { 
                   $acf_category_term = get_sub_field( 'acf_category' ) ?: ''; 
                   $container_aspectratio=1.33;   
                   @$w=w_1149;
                   echo "<script type='text/javascript'>jQuery('body').addClass('transparent-head')</script>";
                ?> 
                <section class="journey-banner" >
                <div class="row row-eq-height ">
                <div class="col-xl-5 col-md-6 col-lg-6 col-sm-12 journey-left">
                <div class="journey-wrap">
                <div class="container">
                <div class="row" >  <div class="col-xl-4 col-md-6 col-lg-5 col-sm-12">  <p class="uppercase"><?php echo @$acf_category_term->name; ?></p>
                <h1 class="semi-bold"><?php the_title(); ?></h1>
                <h5 class="light"><?php the_sub_field( 'header_text' ); ?></h5></div></div>
                </div>
                </div>
                </div>
                <div class="col-xl-7 col-md-6 col-lg-6 col-sm-12">
                <?php
                if(has_post_thumbnail()){
                  $rightimage = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
                if($rightimage):
                      $rightimage = $rightimage;
                  else:
                      $rightimage = 'http://via.placeholder.com/1104x1080';
                  endif;
                  if(strpos($rightimage,'cloudinary.com') > 0){ 
                      $rightimage = str_replace("image/upload/","image/upload/c_fill,ar_1.09,q_auto:best,f_auto/",$rightimage);
                  }
                }
                else{
                    $rightimage ='http://via.placeholder.com/1104x1080';
                }
                ?>
                <img src="<?php echo $rightimage; ?>" class="w-100"></div>
                </div>
                </section>
                <?php 
                }
                //paragarph text
            ?>
            <?php
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
                <?php
                $bimage = $image['url'];
                if($bimage):
                    $bimage = $bimage;
                else:
                    $bimage = 'http://via.placeholder.com/1920x1020';
                endif;
                if(strpos($bimage,'cloudinary.com') > 0){ 
                    $bimage = str_replace("image/upload/","image/upload/c_fill,w_1920,ar_2.00,q_auto:best,f_auto/",$bimage);
                }
                  
                    ?>
            <section class="image-article-section community paddTopBottomArticleSection paddTopBottomZero">
                <a href="<?php echo $bimage; ?>" data-fancybox="images" data-caption="<?php the_sub_field( 'caption' ); ?>"> 
                    <img src="<?php echo $bimage; ?>" alt="<?php echo $image['alt']; ?>" />
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
                            <?php $twocol_mas_image = get_sub_field( 'twocol_mas_image' ); 
                            $ACF_container_fit_image_url2 = $twocol_mas_image['url'];
                            if($ACF_container_fit_image_url2):
                                $ACF_container_fit_image_url2 = $ACF_container_fit_image_url2;
                            else:
                                $ACF_container_fit_image_url2 = 'https://res.cloudinary.com/dlqwlpgdx/image/upload/v1536932214/557x510_jxw1hj.png';
                            endif;
                            if(strpos($ACF_container_fit_image_url2,'cloudinary.com') > 0){ 
                                $ACF_container_fit_image_url2 = str_replace("image/upload/","image/upload/c_fill,ar_1.09,q_auto:best,f_auto/",$ACF_container_fit_image_url2);
                            }
                            if ( get_sub_field( 'ACF_individual_select' ) == 1 ) {
                                $two_icaption=get_sub_field( 'ACF_individual_caption' );     
                            } else{
                                $two_icaption=get_sub_field( '2_col_caption' );
                            }
                            ?>
                            <?php if ( $twocol_mas_image ) { ?>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                    <a href="<?php echo $ACF_container_fit_image_url2; ?>"  data-caption="<?php echo $two_icaption;  ?>" data-fancybox="images">
                                        <img src="<?php echo $ACF_container_fit_image_url2;  ?>" alt="<?php echo $twocol_mas_image['alt']; ?>" />
                                        </a>
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
                            if($i==1){
                                $ACF1_container_fit_image_url = $ACF_3image_repeat['url'];
                                if($ACF1_container_fit_image_url):
                                    $ACF1_container_fit_image_url = $ACF1_container_fit_image_url;
                                else:
                                    $ACF1_container_fit_image_url = 'https://res.cloudinary.com/dlqwlpgdx/image/upload/v1536932214/1151x680_jxw1hj.png';
                                endif;
                                if(strpos($ACF1_container_fit_image_url,'cloudinary.com') > 0){ 
                                    $ACF1_container_fit_image_url = str_replace("image/upload/","image/upload/c_fill,ar_1.5,q_auto:best,f_auto/",$ACF1_container_fit_image_url);
                                }
                                 ?>
                                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                <a href="<?php echo $ACF1_container_fit_image_url; ?>" data-fancybox="images" data-caption="<?php echo $ACF_3image_repeat['alt']; ?>">
                                <img src="<?php echo $ACF1_container_fit_image_url; ?>" class="w-100">
                                </a>
                                
                                </div> 
                                <?php 
                            }
                            else {  
                                $ACF3_container_fit_image_url = $ACF_3image_repeat['url'];
                                if($ACF3_container_fit_image_url):
                                    $ACF3_container_fit_image_url = $ACF3_container_fit_image_url;
                                else:
                                    $ACF3_container_fit_image_url = 'https://res.cloudinary.com/dlqwlpgdx/image/upload/v1536932214/573x380_jxw1hj.png';
                                endif;
                                if(strpos($ACF3_container_fit_image_url,'cloudinary.com') > 0){ 
                                    $ACF3_container_fit_image_url = str_replace("image/upload/","image/upload/c_fill,ar_1.5,q_auto:best,f_auto/",$ACF3_container_fit_image_url);
                                }
                                
                                ?>
                                <div class="col-xl-6 col-md-12 col-lg-12 col-6">
                                <a href="<?php echo $ACF3_container_fit_image_url; ?>" data-fancybox="images" data-caption="<?php echo $ACF_3image_repeat['alt']; ?>">
                                <img src="<?php echo $ACF3_container_fit_image_url; ?>" class="w-100">
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
                        <?php if ( $ACF_container_fit_image ) {  ?>
                            <section class="container_fit_single_image community paddTopBottomArticleSection paddTopBottomZero">
                            <div class="container">
                            <div class="community-wrap">
                            <?php
                            if($container_aspectratio==0.68) {
                                ?>
                                    <div class="photogallery">
                                        <div class="row justify-content-center align-items-center">
                                        <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                    <?php
                                 }
                                $ACF_container_fit_image_url = $ACF_container_fit_image['url'];
								if($ACF_container_fit_image_url):
									$ACF_container_fit_image_url = $ACF_container_fit_image_url;
								else:
									$ACF_container_fit_image_url = 'https://res.cloudinary.com/dlqwlpgdx/image/upload/v1536932214/1138x855_jxw1hj.png';
                                endif;
                                
								if(strpos($ACF_container_fit_image_url,'cloudinary.com') > 0){ 
									$ACF_container_fit_image_url = str_replace("image/upload/","image/upload/c_fill,ar_".$container_aspectratio.",$w,q_auto:best,f_auto/",$ACF_container_fit_image_url);
								}
                                ?>
                            <a href="<?php echo $ACF_container_fit_image_url; ?>" data-fancybox="images" data-caption="<?php the_sub_field( 'Conatiner_Image_caption' );  ?>">
                            <img src="<?php echo $ACF_container_fit_image_url; ?>" alt="<?php echo $ACF_container_fit_image['alt']; ?>" />
                            </a>
                            <div class="comunity-content-wrap">
                            <p class="img-caption"><?php the_sub_field( 'Conatiner_Image_caption' );  ?></p>
                            <?php
                            if($container_aspectratio==0.68) {
                                ?>
                                        
                            </div>
                            </div>
                            </div>
                                    <?php
                                 }      
                                 
                                 ?>


                            </div>
                            </div>
                            </div>
                            </section>
                            <?php } ?>
                            
                            <?php elseif ( get_row_layout() == 'video_full_width' ) : ?>
                            <?php $youtube_embed_code_full_width = get_sub_field( 'youtube_embed_code_full_width' );
                            // var_dump( $youtube_embed_code_full_width ); 
                        endif; 
                    endwhile; 
                else: 
                    // no layouts found 
                endif;
                
                //Author section starts
                $locate_author_info = locate_template( 'template-parts/content-author_info.php' );
                if ( !empty( $locate_author_info ) ):
                    get_template_part( 'template-parts/content-author_info' );  
                endif; 
                
                
              ?>

 <style>
.community {
    padding: 50px 0 0;
}
</style>
