<?php 
/*Template Name: Jorueny with cause Template
*/
if( class_exists('acf') ) {
    add_shortcode( 'journey_cause', 'display_cause' );
    function display_cause(){ 
        $cause_stitle = get_field('ACF_causesection_title') ?: '';
        $cause_ctitle = get_field('ACF_causetitle') ?: '';
        $cause_cdesc= get_field('ACF_jcause_description') ?: '';
        $html='<div class="container"><hr/></div><section class="vocation">
        <div class="container">
        <div class="vocation-wrap">
        <div class="s-header semi-bold text-center">'.$cause_stitle.'</div>
        <h2 class="light text-center">'.$cause_ctitle.'</h2>
        <h5 class="light text-center gray">'.$cause_cdesc.'</h5>';
        if ( get_field( 'ACF_causeshow_button' ) ){
            $btn_cta=get_field("ACF_causebutton_cta") ?: '';
            $btn_cta_url=get_field("ACF_causebutton_url") ?: '';
            $btn_cta_target=get_field("ACF_button_target") ?: '';
            $html.='  <div class="text-center mr-b-30">
            <a href="'.$btn_cta_url.'" target="_'.$btn_cta_target.'" class="btn btn-default">'.$btn_cta.'</a>
            </div>';
        }
        
        $html.='<div class="mobile-slider "> 
        <div class="swiper-container swiper-container-cause">
        <div class="swiper-wrapper">';
        if( have_rows('ACF_cause_image') ):
            while ( have_rows('ACF_cause_image') ) : the_row();
            $ACF_cjimage=get_sub_field('acf_homecause_image');
            $ACF_cjimage_url=$ACF_cjimage['url'] ?: '';
            $ACF_cjimage_alt=$ACF_cjimage['alt'] ?: 'JOURNEYS WITH A CAUSE';
            if(strpos($ACF_cjimage_url,'cloudinary.com') > 0){
                $ACFmb_cjimage_url =  str_replace("image/upload/","image/upload/c_fill,ar_1.19,f_auto,q_auto,w_auto,g_auto/",$ACF_cjimage_url);
            }else{
                $ACFmb_cjimage_url=$ACF_cjimage['url'];
            }
       $html.=' <div class="swiper-slide"><a class="img-wrapper-animate" href="'.$btn_cta_url.'" target="_'.$btn_cta_target.'"><img src="'. $ACFmb_cjimage_url.'" alt="'.$ACF_cjimage_alt.'" class="w-100"></a></div>';
            endwhile;
            endif;
        $html.='</div>
        </div>
        </div>
        <div class="row desktop-slider">';
        if( have_rows('ACF_cause_image') ):
            while ( have_rows('ACF_cause_image') ) : the_row();
            $ACF_cjimage=get_sub_field('acf_homecause_image');
            $ACF_cjimage_url_cloud=$ACF_cjimage['url'] ?: '';
            if(strpos($ACF_cjimage_url_cloud,'cloudinary.com') > 0){
                $ACF_cjimage_url =  str_replace("image/upload/","image/upload/c_fill,ar_1.18,f_auto,q_auto,w_auto,g_auto/",$ACF_cjimage_url_cloud);
            }else{
                $ACF_cjimage_url=$ACF_cjimage['url'];
            }
            $ACF_cjimage_alt=$ACF_cjimage['alt'] ?: 'JOURNEYS WITH A CAUSE';
        $html.='<div class="col-xl-4 col-md-4 col-lg-4 col-sm-12"><a class="img-wrapper-animate" href="'.$btn_cta_url.'" target="_'.$btn_cta_target.'"><img src="'. $ACF_cjimage_url.'" alt="'.$ACF_cjimage_alt.'" class="w-100"></a></div>';
    endwhile;
endif;
        $html.='</div>
        </div>
        </div>
        </section>';
        return $html;
    }
}