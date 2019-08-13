<?php
/**
* Displays content for front page
*
* @package WordPress
* @subpackage Twenty_Seventeen
* @since 1.0
* @version 1.0
*/
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
            @$banner_url = str_replace("image/upload/","image/upload/c_fill,ar_2.33,f_auto,q_auto,w_auto,g_auto/",$acf_banner_image_url);
            $topcode='<img src="'.$banner_url.'" alt="" class="w-100 dk-image">';
        }else{
            @$banner_url = $acf_banner_image_url; 
            $topcode = '<img src="'.$banner_url.'" alt="" class="w-100 dk-image">';
        }
} 
}elseif($acf_bannertype_value=='video'){
  @$banner_url = get_field('ACF_bannervideo');
    $topcode = '<video playsinline preload autoplay loop webkit-playsinline muted class="vid" style="width:100%;height:auto;object-fit:cover" id="mp" autobuffer>
    <source type="video/mp4" id="video-src" src="'.$banner_url.'">
    <source type="video/ogv" src="'.$banner_url.'">
    <source type="video/webm"  src="'.$banner_url.'">
</video>';
}else {

}
if(strpos(@$acf_banner_image_url,'cloudinary.com') > 0){
    $banner_urlmb = str_replace("image/upload/","image/upload/c_fill,ar_0.66,f_auto,q_auto,w_auto/",$acf_banner_image_url);
}else{
    $banner_urlmb = @$acf_banner_image_url; 
}
?>
<section class="main-banner <?php echo $ban_custom; ?>"><?php echo $topcode; ?>
<img src="<?php echo $banner_urlmb; ?>" alt="" class="w-100 mb-image">
<div class="caption"><p class="p1 light baskerville"><?php echo $sub_title; ?></p>


<?php if(!empty($acf_bannertext)) {
    ?>
	<h5 class="light width75Per"><?php echo $acf_bannertext; ?></h5>
    <!--<p class="light"><?php echo $acf_bannertext; ?></p>-->
<?php } ?>
</div>
</section>