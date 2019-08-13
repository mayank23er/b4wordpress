<?php get_header(); ?>

  <?php 
    $locate_article = locate_template( 'single-article.php' );
    if ( !empty( $locate_article ) ):
        get_template_part( 'single-article' );  
    endif; 

    //stories slider    
    $locate_journeys = locate_template( 'theme/widgets/stories-slider.php' );
    if ( !empty( $locate_journeys ) ):
        include(locate_template( 'theme/widgets/stories-slider.php'));
    endif; 

   $locate_journeys = locate_template( 'theme/widgets/related-journeys.php' );
    if ( !empty( $locate_journeys ) ):
        include(locate_template( 'theme/widgets/related-journeys.php'));
    endif; 
   
  ?>
<?php
	//Footer include
	wp_enqueue_script( 'fancy-js', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js');
	wp_enqueue_style( 'fancy-css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css');

?>
<?php get_footer(); ?>
<script>
 jQuery(function(){
	 jQuery('[data-fancybox]').fancybox({
            keyboard: true,
            loop: false,
            image: {
                preload: false
            },
            buttons: [
                "thumbs",
                "close"
            ]

        });
 });
 </script>