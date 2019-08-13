<?php
/* 
Template Name: Make My Journey 
*/
get_header();
//header white js
wp_register_script('experience-js', get_template_directory_uri() . '/theme/js/experience.js',array('jquery'), null, true);
wp_enqueue_script('experience-js');
?>
<?php
$title=get_the_title() ?: ''; 
$ban_custom=get_field('ACF_bannerclass');
$sub_title=get_field( 'ACF_banner_sub_title') ?: ''; 
$acf_bannertype_value=get_field( 'ACF_bannertype' );
$acf_bannertext=get_field('acf_banner_text') ?: '';
if($acf_bannertype_value=='image'){
$acf_banner_image=get_field('ACF_bannerimage');
if($acf_banner_image) {
    $acf_banner_image_url = $acf_banner_image['url'];
    $acf_banner_image_alt = $acf_banner_image['alt'];
        if(strpos($acf_banner_image_url,'cloudinary.com') > 0){
            $banner_url = str_replace("image/upload/","image/upload/c_fill,ar_3.2,f_auto,q_auto,w_1920,g_auto/",$acf_banner_image_url);
            $topcode='<img src="'.$banner_url.'" alt="" class="dk-image">';
        }else{
            $banner_url = $acf_banner_image_url; 
            $topcode = '<img src="'.$banner_url.'" alt="" class="dk-image">';
        }
} 
}elseif($acf_bannertype_value=='video'){
    $banner_url = get_field('ACF_bannervideo')."?controls=0";
    $topcode = '<iframe width="100%" height="100%" src="//www.youtube.com/embed/-w-58hQ9dLk?controls=0" frameborder="0" allowfullscreen=""></iframe>';
}else {

}
if(strpos($acf_banner_image_url,'cloudinary.com') > 0){
    $banner_urlmb = str_replace("image/upload/","image/upload/c_fill,ar_0.66,f_auto,q_auto,w_1920/",$acf_banner_image_url);
}else{
    $banner_urlmb = $acf_banner_image_url; 
}
?>
<section class="main-banner makemy-form <?php echo $ban_custom; ?>"><?php echo $topcode; ?>
<img src="<?php echo $banner_urlmb; ?>" alt="" class="w-100 mb-image">
<div class="caption"><p class="p1 light baskerville"><?php echo "PERSONALISE YOUR JOURNEY";//echo $title; ?></p>
<h5 class="light"><?php echo $sub_title; ?></h5>

<?php if(!empty($acf_bannertext)) {
    ?>
    <p class="light trip-desc"><?php echo $acf_bannertext; ?></p>
<?php } ?>
</div>
</section>
<section class="exp-main ">

<div class="container">

<?php
$select_ninja_form = get_field( 'select_ninja_form' ) ?: ''; 
if(!empty($select_ninja_form)){
$formid=get_field( 'select_ninja_form' ); 
$ninja_code='[ninja_form id='.$formid.']';
echo do_shortcode($ninja_code);
}
?>
</div>
</section>

<?php
get_footer();
?>