<?php
/* 
Template Name: RG Journeys Experiences 
*/

get_header();

    // Template Experiences Category Hero Banner
    include(locate_template( 'template-parts/content-experiences-category-hero-banner.php', false, false));

    // Template Experiences Category Posts
    include(locate_template( 'template-parts/content-experiences-category-posts.php', false, false));

    // Template Stories Posts
    include(locate_template( 'template-parts/content-stories.php', false, false));
    
get_footer();
?>