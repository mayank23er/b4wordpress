<?php 
/*Template Name: Personalise Journey Template
*/
add_shortcode( 'per_journey', 'display_per_journey' );
if( class_exists('acf') ) {
    function display_per_journey() { 
        $section_title=get_field("ACF_per_section_title") ?: '';
        $per_title=get_field("ACF_per_title") ?: '';
        $per_desc=get_field("ACF_per_description") ?: '';
        if ( get_field( 'ACF_pershowcta' ) ){
            $per_btn=get_field("ACF_percta") ?: '';
        }
        else{
            //do nothing
        }

        
        $html='<div class="container"><hr/></div>
        <section class="vocation">
        <div class="container">
        <div class="vocation-wrap">
        <div class="s-header semi-bold text-center">'.$section_title.'</div>
        <h2 class="light text-center">'.$per_title.'</h2>
        <h5 class="light text-center gray">'.$per_desc.'</h5>
        <div class="text-center mr-b-30">';
        if( get_field('ACF_pershowcta') ): 
        $per_btn=get_field("ACF_percta") ?: '';    
        $html.='<a href="/journeys/personalised-trips/" class="btn btn-default">'.$per_btn.'</a>';
        endif;
        $html.='</div>
        <div class="mobile-slider "> 
        <div class="swiper-container swiper-container-personalise">
        <div class="swiper-wrapper">';
        if( have_rows('per_images') ):
            // loop through the rows of data
            while ( have_rows('per_images') ) : the_row();
            $ACF_pimg_mb=get_sub_field('ACF_inper_images');
            $purl_mb=$ACF_pimg_mb['url'];
			if(strpos($purl_mb,'cloudinary.com') > 0){
                $purl_mb =  str_replace("image/upload/","image/upload/c_fill,ar_1.19,f_auto,q_auto,w_auto,g_auto/",$purl_mb);
            }else{
                $purl_mb=$ACF_pimg_mb['url'];
            }
            $html.='<div class="swiper-slide"><a class="img-wrapper-animate" href="/journeys/personalised-trips/"><img  src="'.$purl_mb.'" alt="'.$ACF_pimg_mb['alt'].'" class="w-100"></a></div>';
        endwhile;
        else :
            // no rows found
        endif;
        $html.='</div>
        </div>
        </div>  
        <div class="row desktop-slider">';
        if( have_rows('per_images') ):
            // loop through the rows of data
            while ( have_rows('per_images') ) : the_row();
            // display a sub field value
            $ACF_pimg=get_sub_field('ACF_inper_images');
            $purl_cloud=$ACF_pimg['url'];
            if(strpos($purl_cloud,'cloudinary.com') > 0){
                $purl =  str_replace("image/upload/","image/upload/c_fill,ar_1.18,f_auto,q_auto,w_auto,g_auto/",$purl_cloud);
            }else{
                $purl=$ACF_pimg['url'];
            }
            $html.='<div class="col-xl-4 col-md-4 col-lg-4 col-sm-12"><a class="img-wrapper-animate" href="/journeys/personalised-trips/"><img src="'.$purl.'" alt="'.$ACF_pimg['alt'].'" class="w-100"></a></div>';
        endwhile;
        else :
            // no rows found
        endif;
        
        $html.='</div>
        </div>
        </div>
        </section>';
        return $html;
    }
}
?>