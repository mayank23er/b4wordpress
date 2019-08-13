<?php
/*
Template Name: Front Page*/

get_header();

//Top Banner
// $locate_banner= locate_template( 'single-templates/single-banner.php' );
// 	if ( !empty( $locate_banner ) ) {
// 	get_template_part('single-templates/single-banner');  
// }
$locate_banner= locate_template( 'template-parts/banner.php' );
	if ( !empty( $locate_banner ) ) {
	get_template_part('template-parts/banner');  
}
//Experience
//Top Banner
$locate_exp= locate_template( 'template-parts/home/experience_journeys.php' );
	if ( !empty( $locate_exp ) ) {
	get_template_part('template-parts/home/experience_journeys');  
}

//Journey with cause
$locate_cause= locate_template( 'theme/widgets/journey-cause.php' );
	if ( !empty( $locate_cause ) ) {
	get_template_part('theme/widgets/journey-cause');  
	echo do_shortcode('[journey_cause]');
}

//Peronalise
$locate_per= locate_template( 'theme/widgets/personalise-journey.php' );
	if ( !empty( $locate_per ) ) {
	get_template_part('theme/widgets/personalise-journey');  
	echo do_shortcode('[per_journey]');
}

// Template Stories Posts
include(locate_template( 'template-parts/content-stories.php'));

//About
$locate_about= locate_template( 'theme/widgets/about.php' );
	if ( !empty( $locate_about ) ) {
	get_template_part('theme/widgets/about');  
	echo do_shortcode('[icon_social]');
}



get_footer(); ?>