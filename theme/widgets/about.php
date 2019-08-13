<?php 
/*Template Name: About Template
*/
if( class_exists('acf') ) {
    add_shortcode( 'icon_social', 'display_social' );
    function display_social(){ 
        $abt_title = get_field('ACF_abouttitle') ?: '';
        $ab_form ='[ninja_form id=22]';
        $htmlicon='<section class="about">
        <div class="container">
        <div class="s-header semi-bold">ABOUT</div>
        <h2 class="light">'.$abt_title.'</h2>
        <div class="subscribe">
        <div class="row">
        <div class="col-xl-7 col-md-6 col-lg-6 col-sm-12">
        <h5>Subscribe to our newsletter for updates</h5>';
        $htmlicon.=do_shortcode($ab_form).'
        </div><div class="col-xl-5 col-md-6 col-lg-6 col-sm-12">
        <div class="social"> 
        <div class="stay-left">
        &nbsp;
        </div><div class="stay-main"><h5>Stay connected</h5>
        </div>
        <ul class="list-inline">';
        if( have_rows('soical_icons') ):
            while ( have_rows('soical_icons') ) : the_row();
            $ACF_social_icon=get_sub_field('ACF_socialicon');
            $ACF_social_url=get_sub_field('ACF_socialurl');
            if($ACF_social_icon=='fa-envelope') {
                $htmlicon.='<li class="list-inline-item"><a href="'.$ACF_social_url.'"><i class="fa '.$ACF_social_icon.'"></i></a></li>';    
            }else{
            $htmlicon.='<li class="list-inline-item"><a href="'.$ACF_social_url.'"><i class="fab '.$ACF_social_icon.'"></i></a></li>';
            }
        endwhile;
        endif;
        $htmlicon.='</ul>
        </div>
        </div>
        </div>
        </div>       
        </div>
        </section>';
        return $htmlicon;
    }
}