<?php
/**!
 * Schema
 */

/**
 * Check if a post is a custom post type.
 * @param  mixed $post Post object or ID
 * @return boolean
 */

//function to get schema
function getschenma(){
	$buffy = array();
	if ( is_custom_post_type() ) { 
		if ( is_single() ) {
			$post_id=get_the_ID();
			$args = array(
				'numberposts'   => -1,
				'order' =>'asc',
				'p' => $post_id, 
				'post_type'     => get_post_type()
			); 
			$loop = new WP_Query($args); 
			if ( $loop->have_posts() ) :
				setup_postdata( $loop ); 

				while ( $loop->have_posts() ) : $loop->the_post();
					$author_id= $loop->posts[0]->post_author;
					$metainfo = get_userdata( $author_id );
					$postdate=get_the_date();
					$modifiedDate=get_the_modified_date();
					$posturl=get_permalink(); 
					$contexturl="http://schema.org/";
					$logosch="https://res.cloudinary.com/roundglass/image/upload/v1521616309/rg_logo.png";
					$buffy["@context"]=$contexturl;
					$buffy["@type"]='BlogPosting';
					$buffy["mainEntityOfPage"]['@type']='WebPage';
					$buffy["mainEntityOfPage"]['@id']=get_the_permalink();
					$buffy["headline"]=get_the_title();
					$buffy["name"]=get_the_title();
					$buffy["description"]=get_the_content();
					$buffy["datePublished"]=$postdate;
					$buffy["dateModified"]=$modifiedDate;
					$buffy['author']['@type']='Person';
					$buffy['author']['name']=(isset($metainfo->user_nicename) && $metainfo->user_nicename!='') ? $metainfo->user_nicename :'user' ;
					$buffy['author']['url']= get_avatar_url( $author_id );
					$buffy['author']['description']=get_the_author_meta('description', $author_id );
					$buffy['author']['image']=1;
					@$buffy['author']['image']['@type']='ImageObject';
					@$buffy['author']['image']['url']=get_the_author_link();
					@$buffy['author']['image']['height']=96;
					@$buffy['author']['image']['width']=96;
					$buffy['publisher']['@type']='Organization';
					$buffy['publisher']['name']='Round Glass';
					$buffy['publisher']['logo']['@type']='ImageObject';
					$buffy['publisher']['logo']['url']=$logosch;
					$buffy['publisher']['logo']['width']='600';
					$buffy['publisher']['logo']['height']='60';
					$buffy['image']['@type']='ImageObject';
					$buffy['image']['url']='https://res.cloudinary.com/roundglass/image/upload/v1521616309/rg_logo.png';
					$buffy['image']['height']='60';
					$buffy['image']['width']='60';
					$buffy['about']=get_the_title();
					$buffy['url']=$posturl;
					$buffy['keywords']= array("Roundglass Journeys", "Journeys",get_the_title());
					$buffy['commentCount']='0';


				endwhile;
				echo '<script type="application/ld+json">'.json_encode($buffy,true).'</script>'; 
		    wp_reset_query(); //Restore global post data stomped by the_post(). 
		endif;
	}
}
}
add_action('wp_head', 'getschenma');