<?php
/* 
Template Name: Tag Page
*/
get_header();
//header white js
wp_register_script('experience-js', get_template_directory_uri() . '/theme/js/experience.js',array('jquery'), null, true);
wp_enqueue_script('experience-js');
?>
<?php
 // Template Experiences Category Posts
 include(locate_template( 'template-parts/content-tags.php', false, false));
get_footer();
?>