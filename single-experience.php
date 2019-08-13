<?php
	function journey_script() {
        wp_register_script('experience-js', get_template_directory_uri() . '/theme/js/experience.js', false, null, null);
        wp_enqueue_script('experience-js');
    }
    add_action( 'wp_enqueue_scripts', 'journey_script', 101 );
    include(locate_template( 'page-templates/rg-journeys-experiences.php', false, false));
?>