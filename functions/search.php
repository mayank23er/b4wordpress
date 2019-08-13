<?php 
$blog_id = get_current_blog_id();
$site_url = get_site_url($blog_id);
define( 'SITEURL', site_url() );

/**Search Starts**/
function set_es_search_args_title( $ep_formatted_args, $args ) {
	
	if( isset( $args['autocomplete'] ) && $args['autocomplete'] ) {
		$titleSearchTerm = '';
		if(strpos($args['s'], ' ') > 0 && $args['s'] != '') {
			$titleSearchTerm = strtolower($args['s']);
			$ep_formatted_args['query'] = array(
				"query_string" => array(
					"query" => $titleSearchTerm,
					"fields" => array("post_title.suggest"),
					//"phrase_slop" => 0,
				),
			);
		}
		else {
			if($args['s'] != '') {
				$titleSearchTerm = strtolower($args['s']);
				$ep_formatted_args['query'] = array(
					"match_phrase_prefix" => array(
						"post_title.suggest" => array(
							"query" => $titleSearchTerm,
						),
					),
				);
			}
		}
		
	}
	return $ep_formatted_args;
}

function set_es_search_args_tags( $ep_formatted_args, $args ) {
	if( isset( $args['autocomplete'] ) && $args['autocomplete'] ) {
		$tagSearchStr = strtolower(str_replace(" ","-",$args['s'])).'*';
		$ep_formatted_args['query'] = array("wildcard"=>array("terms.post_tag.slug" => $tagSearchStr));
	}

	return $ep_formatted_args;
}

function set_es_search_args_content( $ep_formatted_args, $args ) {
	if( isset( $args['autocomplete'] ) && $args['autocomplete'] ) {
		$titleSearchTerm = '';
		if(strpos($args['s'], ' ') > 0 && $args['s'] != '') {
			$titleSearchTerm = strtolower($args['s']);
			$ep_formatted_args['query'] = array(
				"query_string" => array(
					"query" => $titleSearchTerm,
					"fields" => array("post_content",),
				),
			);
		}
		else {
			if($args['s'] != '') {
				$titleSearchTerm = strtolower($args['s']);
				$ep_formatted_args['query'] = array(
					"wildcard"=>array(
						"post_content" => $titleSearchTerm
					)
				);
			}
		}
		
	}
		
	return $ep_formatted_args;
}

function set_es_search_args_collection_summary( $ep_formatted_args, $args ) {
	if( isset( $args['autocomplete'] ) && $args['autocomplete'] ) {
		$titleSearchTerm = '';
		if(strpos($args['s'], ' ') > 0 && $args['s'] != '') {
			$titleSearchTerm = strtolower($args['s']);
			$ep_formatted_args['query'] = array(
				"query_string" => array(
					"query" => $titleSearchTerm,
					"fields" => array("meta.collection_text.value.raw",),
					//"phrase_slop" => 0,
				),
			);
		}
		else {
			if($args['s'] != '') {
				$titleSearchTerm = strtolower($args['s']);
				$ep_formatted_args['query'] = array(
					"wildcard"=>array(
						"meta.collection_text.value.raw" => $titleSearchTerm
					)
				);
			}
		}
		
	}
		
	return $ep_formatted_args;
}

function starts_with_upper_case_char($str) {
	$chr = mb_substr ($str, 0, 1, "UTF-8"); //isolates the first char
	if ( ctype_upper( $chr )) {
		// deal with 1st char of $str is uppercase
		return true;
	}
}

function set_es_search_args_author( $ep_formatted_args, $args ) {
	if( isset( $args['autocomplete'] ) && $args['autocomplete'] ) {
		$titleSearchTerm = '';
		if(strpos($args['s'], ' ') > 0 && $args['s'] != '') {
			$titleSearchTerm = str_replace(' ','* *',strtolower($args['s']));
			
		}
		else {
			if($args['s'] != '') {
				$titleSearchTerm = strtolower($args['s']);
			}
		}
		$ep_formatted_args['query'] = array(
			"query_string" => array(
				"query" => '*'.$titleSearchTerm.'*',
				"fields" => array( "post_author.display_name.raw^20", "post_author.author_bio.raw^10", "post_author.login.raw"),
			),
		); 
	}
	return $ep_formatted_args;
	//print_r($ep_formatted_args);
	
}

//add_action('init', 'suggestive_search_ajax_results');

add_action('wp_ajax_suggestive_search_ajax_results', 'suggestive_search_ajax_results');
add_action('wp_ajax_nopriv_suggestive_search_ajax_results', 'suggestive_search_ajax_results');
function suggestive_search_ajax_results() {
		//complete array
		$searchResults["matched_title"] = array(); //level1 array
		$searchResults["matched_tags"] = array(); //level2 array
		$searchResults["matched_content"] = array(); //level3 array
		$searchResults["matched_author"] = array(); //level4 array
		$suggestedPostID = isset($_REQUEST['suggested_post_id'])?$_REQUEST['suggested_post_id']:''; 
		
		$tagsReq = isset($_REQUEST['tag_req'])?$_REQUEST['tag_req']:'false'; 
			
		//if($tagsReq==true){
			///$_REQUEST['s'] = 'photo';
		if($_REQUEST['tag_req']=='true'){
			
			add_filter( 'ep_formatted_args', 'set_es_search_args_tags', 310, 2 );
			$searchResults["matched_tags"] = ep_wp_query_method($searchResults["matched_tags"], $_REQUEST['s'],true,$suggestedPostID);
		}else{
			add_filter( 'ep_formatted_args', 'set_es_search_args_title', 300, 2 );
			$searchResults["matched_title"] = ep_wp_query_method($searchResults["matched_title"], $_REQUEST['s'],true,$suggestedPostID);
			
			add_filter( 'ep_formatted_args', 'set_es_search_args_tags', 310, 2 );
			$searchResults["matched_tags"] = ep_wp_query_method($searchResults["matched_tags"], $_REQUEST['s'],true,$suggestedPostID);
			
			add_filter( 'ep_formatted_args', 'set_es_search_args_content', 330, 2 );
			$searchResults["matched_content"] = ep_wp_query_method($searchResults["matched_content"], $_REQUEST['s'],true,$suggestedPostID);
			
			add_filter( 'ep_formatted_args', 'set_es_search_args_collection_summary', 340, 2 );
			$searchResults["matched_content"] = ep_wp_query_method($searchResults["matched_content"], $_REQUEST['s'],true,$suggestedPostID);
			
			add_filter( 'ep_formatted_args', 'set_es_search_args_author', 350, 2 );
			$searchResults["matched_author"] = ep_wp_query_method($searchResults["matched_author"], $_REQUEST['s'], false,$suggestedPostID);
		}
		
		
		//$searchResultsJSONEncoded["complete_results"] = $searchResults;
		
		$arrayStories = array();
		//$arrayJourneys = array();
		$arrayCollection = array();
		$storiesAndCollectionsArraySizeFull = 9999;
		
		$arrayStories = createArray($searchResults['matched_title'], $arrayStories, false, $storiesAndCollectionsArraySizeFull); 
		$arrayCollection = createArray($searchResults['matched_title'], $arrayCollection, true, $storiesAndCollectionsArraySizeFull); 
		
		//$arrayJourneys = createArray($searchResults['matched_title'], $arrayJourneys, false, $storiesAndCollectionsArraySizeFull); 
		
		if(count($arrayStories) < $storiesAndCollectionsArraySizeFull && count($arrayCollection) < $storiesAndCollectionsArraySizeFull) {
			$arrayStories = createArray($searchResults['matched_tags'], $arrayStories, false, $storiesAndCollectionsArraySizeFull);
			$arrayCollection = createArray($searchResults['matched_tags'], $arrayCollection, true, $storiesAndCollectionsArraySizeFull);
			
			//$arrayJourneys = createArray($searchResults['matched_tags'], $arrayJourneys, false, $storiesAndCollectionsArraySizeFull);
		}
		if(count($arrayStories) < $storiesAndCollectionsArraySizeFull && count($arrayCollection) < $storiesAndCollectionsArraySizeFull) {
			$arrayStories = createArray($searchResults['matched_content'], $arrayStories, false, $storiesAndCollectionsArraySizeFull);
			$arrayCollection = createArray($searchResults['matched_content'], $arrayCollection, true, $storiesAndCollectionsArraySizeFull);
			
			//$arrayJourneys = createArray($searchResults['matched_content'], $arrayJourneys, false, $storiesAndCollectionsArraySizeFull);
		}
		if(count($arrayStories) < $storiesAndCollectionsArraySizeFull && count($arrayCollection) < $storiesAndCollectionsArraySizeFull ) {
			$arrayStories = createArray($searchResults['matched_author'], $arrayStories, false, $storiesAndCollectionsArraySizeFull);
			$arrayCollection = createArray($searchResults['matched_author'], $arrayCollection, true, $storiesAndCollectionsArraySizeFull);
			
			//$arrayJourneys = createArray($searchResults['matched_author'], $arrayJourneys, false, $storiesAndCollectionsArraySizeFull);
		}
		
		/*authors*/
		$arrayAuthors = array();
		$authorArraySizeFull = 9999;
		if(count($searchResults['matched_author']) > 0) {
			$arrayAuthors = createArray($searchResults['matched_author'], $arrayAuthors, false, $authorArraySizeFull, true);
			if(count($arrayAuthors) < $authorArraySizeFull) {
				$arrayAuthors = createArray($searchResults['matched_author'], $arrayAuthors, false, $authorArraySizeFull, true);
			}
		}
		else { 
			if(count($searchResults['matched_title']) > 0) { 
				if(count($arrayAuthors) < $authorArraySizeFull) {
					
					$arrayAuthors = createArray($searchResults['matched_title'], $arrayAuthors, false, $authorArraySizeFull, true); 
					//$arrayAuthors = createArray($searchResults['matched_title'], $arrayCollection, true, 3); 
				}
			}
			if(count($searchResults['matched_tags']) > 0) {
				if(count($arrayAuthors) < $authorArraySizeFull) {
					$arrayAuthors = createArray($searchResults['matched_tags'], $arrayAuthors, false, $authorArraySizeFull, true); 
					//$arrayAuthors = createArray($searchResults['matched_tags'], $arrayCollection, true, 3); 
				}
			}
			if(count($searchResults['matched_content']) > 0) {
				if(count($arrayAuthors) < $authorArraySizeFull) {
					$arrayAuthors = createArray($searchResults['matched_content'], $arrayAuthors, false, $authorArraySizeFull, true); 
					//$arrayAuthors = createArray($searchResults['matched_content'], $arrayCollection, true, 3); 
				}
			}
		}
		
		//$arrayAuthorsFull = makeYourAssociativeArrayUnique($arrayAuthors);
		$arrayAuthors = makeYourAssociativeArrayUnique($arrayAuthors);
		/*authors ends*/
		
		/*get related tags*/
		$relatedTags = array();
		$relatedTags = getRelatedTagsArray($searchResults);
		/*get related tags ends*/
		$all_journeys = journeys_filteration_srp();
		$searchResultsJSONEncoded["complete_results"] = array(
			"all_results"=>$searchResults,
			"stories"=>$arrayStories,
			//"journeys"=>$all_journeys,
			"collection"=>$arrayCollection,
			"authors"=>$arrayAuthors,
			"related_tags"=> $relatedTags
		);
		//echo '<pre>';
		//print_r($searchResultsJSONEncoded); echo '</pre>';	die('TEST');				
		echo json_encode($searchResultsJSONEncoded);
		wp_die();
	//}
	
}
function journeys_filteration_srp(){
	$blog_id = get_current_blog_id();
	global $wpdb; 
	$my_custom_query = $journey_time = array();
	
		$param_query = "SELECT SQL_CALC_FOUND_ROWS wp_".$blog_id."_posts.ID FROM wp_".$blog_id."_posts 
		INNER JOIN wp_".$blog_id."_postmeta ON ( wp_".$blog_id."_posts.ID = wp_".$blog_id."_postmeta.post_id ) 
		WHERE 1=1 
		AND wp_".$blog_id."_posts.post_type = 'journey' AND ((wp_".$blog_id."_posts.post_status = 'publish')) GROUP BY wp_".$blog_id."_posts.ID ORDER BY wp_".$blog_id."_posts.post_date DESC";
		
		$get_results= $wpdb->get_results($param_query);	
		wp_reset_postdata();
		$journeys_data_array = array();
		if( $get_results ) : 
			global $post;
			$count = count($get_results);
			$i=0;
			foreach ($get_results as $post) 
			{ 
				setup_postdata($post);

				$jid=get_the_ID();
				$j_title=get_the_title($jid) ?: '';
				$journey_link=get_the_permalink($jid);
				$j_img=get_field("ACF_journeyhero_image",$jid) ?: '';
				if( !empty($j_img) )
				{
					$cloud_jurl = $j_img['url'];
					$jalt = $j_img['alt'] ?: '';
					if(strpos($cloud_jurl,'cloudinary.com') > 0){
						$jurl = str_replace("image/upload/","image/upload/c_fill,ar_1.47,f_auto,q_auto,g_auto/",$cloud_jurl);
						$purl = str_replace("image/upload/","image/upload/c_fill,ar_0.53,f_auto,q_auto,w_408,g_auto/",$cloud_jurl);
					}else{
						$jurl = $cloud_jurl; 
						$purl = $cloud_jurl; 
					}	
				}else{
					$jurl='http://via.placeholder.com/672x454'; 
					$purl='http://via.placeholder.com/408x766'; 
					$jalt= '';
				}
				$j_desc=get_field("ACF_journey_description",$jid) ?: '';
				$j_city=get_field("ACF_journeycity",$jid) ?: '';
				$exp_object = get_field('ACF_journey_experiences',$jid);
				$tdays=get_field( 'total_nights',$jid )." Nights ".get_field( 'total_days',$jid )." Days";
				if( $exp_object ): 
					// override $post
					$exppost = $exp_object;
					setup_postdata($exppost); 
					$expId=$exppost->ID;
					$experience_name=get_the_title($expId); 
					wp_reset_postdata(); 
				endif;
				$journeys_data_array[$i]['jounryes_title'] = $j_title;
				$journeys_data_array[$i]['jounryes_link'] = $journey_link;
				$journeys_data_array[$i]['jounryes_image'] = $jurl;
				$journeys_data_array[$i]['jounryes_description'] = $j_desc;
				$journeys_data_array[$i]['jounryes_city'] = $j_city;
				$journeys_data_array[$i]['jounryes_experience_name'] = $experience_name;
				$journeys_data_array[$i]['jounryes_duration'] = $tdays;
				$i++;
			}
		endif;
		return $journeys_data_array;	
}


function ep_wp_query_method($searchResultsMatchedArray, $searchRequestTerm, $isWildCard=true,$suggestedPostID) {

	
	$blog_id = get_current_blog_id();
	$site_url = get_site_url($blog_id);
	
	//check if it is a blank search 
	$resultsSortDesc = false;
	if($searchRequestTerm == '*') {
	   $resultsSortDesc = true;
	}
	
	if($isWildCard==true) {
		$searchStrWithAndWithoutWildcard1 = $searchRequestTerm.'*';
	}
	else {
		$searchStrWithAndWithoutWildcard1 = $searchRequestTerm;
	}
	//echo $searchStrWithAndWithoutWildcard1;
	$es_query= ep_wp_query_get_object($searchStrWithAndWithoutWildcard1,$suggestedPostID, $resultsSortDesc);
	
	
	if($es_query->found_posts > 0) { //echo 'Im here with posts found';
		while ($es_query->have_posts()) : $es_query->the_post();
			
			if($es_query->post->post_type=='journey') {
				
				$collectionsTags = array();
				$collectionsTagsInterim = $es_query->post->terms['post_tag'];
				//print_r($collectionsTags);
				for($i=0; $i<count($collectionsTagsInterim); $i++) {
					array_push($collectionsTags, array("tag_name"=>$collectionsTagsInterim[$i]['name'],"tag_slug"=>$collectionsTagsInterim[$i]['slug'],"tag_id"=>$collectionsTagsInterim[$i]['term_id']));
				}
				
				$collectionArticlesCount = array("collection_articles_count" => $es_query->post->meta['collection_articles'][0]['value']);
				//echo '<pre>';
				//print_r($es_query->post->meta);
				//echo '</pre>';
				$collectionFirstArticleID = $es_query->post->meta['collection_articles_0_collection_article'][0]['value'];
				
				 $collectionCity =  $es_query->post->meta['ACF_journeycity'][0]['value'];
				 $collectionDesc =  $es_query->post->meta['ACF_journey_description'][0]['value'];
				 $collectionDay =  $es_query->post->meta['total_days'][0]['value'];
				 $collectionNight =  $es_query->post->meta['total_nights'][0]['value'];
				 $collectionSdate =  $es_query->post->meta['ACF_journey_smonth'][0]['value'];
				 $colletionEdate=  $es_query->post->meta['ACF_journey_emonth'][0]['value'];
				 $collectionEx=  $es_query->post->meta['ACF_journey_experiences'][0]['value'];
				 $collectionImagen = $es_query->post->meta['ACF_journeyhero_image'][0]['value'];
				 $collectionImageURL = get_post_meta($collectionImagen, '_wp_attached_file');
				 $collectionImage=$collectionImageURL[0];
				 
				if ( $collectionImage ) { 
					if($collectionImage):
						$collectionImage = $collectionImage;
						$purl = $collectionImage;
					else:
						$collectionImage = 'http://via.placeholder.com/1056x702';
					endif;
					if(strpos($collectionImage,'cloudinary.com') > 0){ 
						$collectionImage = str_replace("image/upload/","image/upload/c_fill,ar_1.1,q_auto:best,f_auto,w_312/",$collectionImage);
						$purl = str_replace("image/upload/","image/upload/c_fill,ar_0.53,q_auto:best,f_auto,w_408/",$purl);
					}
				}

			  $collectionDayClass=trim($collectionDay);
			    //$collectionDayClass=(int)$collectionDayClass;
				if($collectionDayClass=='1' || $collectionDayClass=='2' || $collectionDayClass=='3' || $collectionDayClass=='4' || $collectionDayClass=='5'){
					$collectionDayClass='45days';	
				}
				else if($collectionDayClass=='6' || $collectionDayClass=='7'){
					$collectionDayClass='67days';	
				}
				else{
					$collectionDayClass='8days';	
				}

				 $sdate=date_create($collectionSdate);
				 $sdate=date_format($sdate," F "); 
				 $sdate = trim($sdate);
				 //echo '<br/>Before chnage $sdate = '.$sdate;
				 //$sdate = (string)$sdate;
				 if($sdate=='Janurary' || $sdate=='Feburary' || $sdate=='March') {
					 $sdate = 'Janurary';
				 }
				 if($sdate=='April' || $sdate=='May' || $sdate=='June') {
					 $sdate = 'April';
				 }
				 if($sdate=='July' || $sdate=='August' || $sdate=='September') {
					 $sdate = 'July';
				 }
				 if($sdate=='October' || $sdate=='November' || $sdate=='December') {
					 $sdate = 'October';
				 }
				//echo '<br/>After chnage $sdate = '.$sdate;
				 $edate=date_create($colletionEdate);
				 $edate=date_format($edate," F "); 
				 $edate = trim($edate);
				 //echo '<br/>Before chnage $edate = '.$edate;
				 //$edate = (string)$edate;
				 if($edate=='Janurary' || $edate=='Feburary' || $edate=='March') {
					 $edate = 'March';
				 }
				 if($edate=='April' || $edate=='May' || $edate=='June') {
					 $edate = 'June';
				 }
				 if($edate=='July' || $edate=='August' || $edate=='September') {
					 $edate = 'Sepetember';
				 }
				 if($edate=='October' || $edate=='November' || $edate=='December') {
					// echo 'IN';
					 $edate = 'December';
				 }
				 //echo '<br/>After chnage $edate = '.$edate;
				 $post = get_post($collectionEx); 
				 $slugExperience = $post->post_name;
				
				//$collectionFirstArticleID = $es_query->post->meta['collection_articles_0_collection_article'][0]['value'];
				
				//$collectionFirstArticleID = $es_query->post->meta['journey_'][0]['value'];
			
				$userMetaArrayCollections = toGetAdditonalAuthorMetaInfoForPosts($collectionFirstArticleID, $blog_id, $site_url);
				
				$thumbnail16x9CloudURLFor1stArticleOfCollection = toGetThumbnailCloudURLForCollection1stArticle($collectionFirstArticleID, $blog_id, $site_url);
				
				$catAttributesArray = array();
				
				$catAttributesArray = getCatAttributesForStories($es_query, $catAttributesArray, $es_query->post->post_type);
				
				
				array_push($searchResultsMatchedArray, 
					array(	
						  "title" => $es_query->post->post_title,
						  "id" => $es_query->post->ID,                                                                         
						  "type" => $es_query->post->post_type,
						  "permalink" => get_permalink($es_query->post->ID),
						  "post_last_modified" => $es_query->post->post_modified,
						  "post_card_excerpt" => $es_query->post->meta['collection_text'][0]['value'],
						  "count_on_card" => $collectionArticlesCount,
						  "articles_count_author" => $userMetaArrayCollections['items_authored'],
						  "card_thumbnail_src" => $thumbnail16x9CloudURLFor1stArticleOfCollection,
						  //"card_thumbnail_16x9_src" => $thumbnail16x9CloudURLFor1stArticleOfCollection,
						  "post_cats" => $catAttributesArray,
						  //"author_name" => get_the_author($collectionFirstArticleID),
						  "author_name" => get_author_name((int)$userMetaArrayCollections['user_id']),
						  "author_login" => $userMetaArrayCollections['user_login'],
						  "author_id" => $userMetaArrayCollections['user_id'],
						  "author_profile_link" => get_author_page_link_by_article_id($collectionFirstArticleID),
						  "author_profile_bio" => $userMetaArrayCollections['user_meta_description'],
						  "author_profile_pic_src" => $userMetaArrayCollections['user_meta_avatar_src'],
						  "author_category" => $userMetaArrayCollections['user_category'],
						  "collection_desc" => $collectionDesc,
						  "collection_city" => $collectionCity,
						  "collection_day" => $collectionDay,  
						  "collection_night" => $collectionNight,
						  "collection_s_date" =>$sdate,
						  "colletion_e_date" => $edate,
						  "collection_e_x"	=> $slugExperience,
						  "collection_image" => $collectionImage ,
						  "purl"=>$purl, 
						  "collectionDayClass" =>$collectionDayClass,
						  
						  /*"tags" => array(
								"tag_name" => $tagsArrayForMatchedResults->slug, 
								"tag_slug" => $tagsArrayForMatchedResults['']
						  )*/
						  "tags" => $collectionsTags,
					)
				);
			}
			else {
				$storiesTags = array();
				$storiesTagsInterim = $es_query->post->terms['post_tag'];
				//print_r($storiesTags);
				for($i=0; $i<count($storiesTagsInterim); $i++) {
					array_push($storiesTags, array("tag_name"=>$storiesTagsInterim[$i]['name'],"tag_slug"=>$storiesTagsInterim[$i]['slug'],"tag_id"=>$storiesTagsInterim[$i]['term_id']));
				}
				$userMetaArray = toGetAdditonalAuthorMetaInfoForPosts($es_query->post->ID, $blog_id, $site_url);
				
				$count_on_card = '';
				if($es_query->post->post_type=='photostory') { 
					$count_on_card = array('photo_count' => $es_query->post->meta['photo_count'][0]['value']);
				} else {
					$count_on_card = array('read_time' => $es_query->post->meta['read_time'][0]['value']); 
				}
				
				//$thumbnail4x3CloudURLForStory = toGetThumbnailCloudURLForStory($es_query->post->meta['thumbnail_image_custom'][0]['value'], $blog_id, $site_url);
				$thumbnail4x3CloudURLForStory = wp_get_attachment_url( get_post_thumbnail_id($es_query->post->ID) );

				if($thumbnail4x3CloudURLForStory==''){
					$thumbnail4x3CloudURLForStory='https://res.cloudinary.com/dlqwlpgdx/image/upload/c_fill,ar_1:1,g_auto/w_750,q_auto,f_auto/v1536932173/journey-top-banner_yshlby.jpg';
				}
				$catAttributesArray = array();
				$catAttributesArray = getCatAttributesForStories($es_query, $catAttributesArray, $es_query->post->post_type);
				array_push($searchResultsMatchedArray, 
					array(   
						  "title" => $es_query->post->post_title,
						  "id" => $es_query->post->ID,                                                                         
						  "type" => $es_query->post->post_type,
						  "permalink" => $es_query->post->permalink,
						  "post_last_modified" => $es_query->post->post_modified,
						  "post_card_excerpt" => get_card_excerpt_of_article($es_query->post->ID),
						  "count_on_card" => $count_on_card,
						  "articles_count_author" => $userMetaArray['items_authored'],
						  "card_thumbnail_src" => $thumbnail4x3CloudURLForStory,
						  //"card_thumbnail_16x9_src" => '',
						  "post_cats" => $catAttributesArray,
						  "author_name" => get_the_author($es_query->post->ID),
						  "author_login" => $userMetaArray['user_login'],
						  "author_id" => $userMetaArray['user_id'],
						  "author_profile_link" => get_author_page_link_by_article_id($es_query->post->ID),
						  "author_profile_bio" => $userMetaArray['user_meta_description'],
						  "author_profile_pic_src" => $userMetaArray['user_meta_avatar_src'],
						  "author_category" => $userMetaArray['user_category'],
						  "tags" => $storiesTags,
						  //"category_slug" => $category_slug
					)
				);
			}
			
		endwhile;
	} //echo 'Im here with no posts found';
	//print_r($es_query);
	return $searchResultsMatchedArray;
}

function ep_wp_query_get_object($searchStrToGetQueryObject,$suggestedPostID='') {
	
	if($suggestedPostID ==''){
		if($resultsSortDesc==false) {
			$es_query_obj = new WP_Query( array(
				'posts_per_page' => -1,
				'ep_integrate' => true,
				'autocomplete' => true,
				'sites' => 'current',
				's' => $searchStrToGetQueryObject,
				'post_status' => array('publish'),
				'post_type' => array('post','photostory','videostory','journey'),
				//'post__not_in' => array(3462),
				'size' => 10000
			) );
		
		} 
		else {
			$es_query_obj = new WP_Query( array(
				'posts_per_page' => -1,
				'ep_integrate' => true,
				'autocomplete' => true,
				'sites' => 'current',
				's' => $searchStrToGetQueryObject,
				'post_status' => array('publish'),
				'post_type' => array('post','photostory','videostory','journey'),
				'orderby' => 'modified',
				'order' => 'desc',
				//'post__not_in' => array(3462),
				'size' => 10000,
			) );
		}
        
    }
	else {
		
			if($resultsSortDesc==false) {
				$es_query_obj = new WP_Query( array(
					'posts_per_page' => -1,
					'ep_integrate' => true,
					'autocomplete' => true,
					'sites' => 'current',
					's'         => $searchStrToGetQueryObject,
					'post_status' => array('publish'),
					'post_type' => array('post','photostory','videostory','journey'),
					//'post__not_in' => array(3462),
					'post__in' => array($suggestedPostID),
					'size' => 10000,
				) );
				
			} 
			else {
				$es_query_obj = new WP_Query( array(
					'posts_per_page' => -1,
					'ep_integrate' => true,
					'autocomplete' => true,
					'sites' => 'current',
					's'         => $searchStrToGetQueryObject,
					'post_status' => array('publish'),
					'post_type' => array('post','photostory','videostory','journey'),
					'orderby' => 'modified',
					'order' => 'desc',
					//'post__not_in' => array(3462),
					'post__in' => array($suggestedPostID),
					'size' => 10000,
				) );
			}
    }
	//echo "<pre>";
	//print_r($es_query_obj);
	//echo "</pre>";
	//die('$searchStrToGetQueryObject = '.$searchStrToGetQueryObject);
	return $es_query_obj;
}

function getAuthorNamesfromStories($inarray) {
	return $inarray;
}

function createArray ($searchResults, $newarray, $collectionFlag, $limitSize, $noPostTypeFlag=false) {
	
	$totalSearchRecords = count($newarray);
	if ($totalSearchRecords >= $limitSize) {
		return;
	}
	
	for ($i = 0; $i < count($searchResults); $i++) { 
		//echo "<br/>Post Type" . $searchResults[$i]["type"];
	
		if ($collectionFlag == true && $searchResults[$i]["type"] == "journey" && $noPostTypeFlag==false) {
			if(!in_array($searchResults[$i], $newarray)) {
				$newarray[$totalSearchRecords] = $searchResults[$i];
				$totalSearchRecords++;
			}
		} 
		
		if($collectionFlag == false && $searchResults[$i]["type"] != "journey" && $noPostTypeFlag==false) {
			if(!in_array($searchResults[$i], $newarray)) { 
				$newarray[$totalSearchRecords] = $searchResults[$i];
				$totalSearchRecords++;
			}
			
		}
		
		if($noPostTypeFlag==true) {
			if(!in_array($searchResults[$i], $newarray)) { 
				$newarray[$totalSearchRecords] = $searchResults[$i];
				$totalSearchRecords++;
			}
		}

	if(count($newarray) >= $limitSize)
		$newarray = array_slice($newarray, 0, $limitSize, true);
		
	}	
	return $newarray;
}

function makeYourAssociativeArrayUnique($arrayToBeMadeUnique){
	$uniqueArray = array();
	$arrayToBeMadeUnique = array_reverse($arrayToBeMadeUnique);
	foreach ($arrayToBeMadeUnique as $value)	{
		$uniqueArray[$value['author_name']] = $value;
	}
	return $data = array_values($uniqueArray);
}

function getRelatedTagsArray($searchResults) {
	//print_r($searchResultsJSONEncoded["complete_results"]["all_results"]["matched_title"][1]["tags"]);
	$relatedTagsInterimArray = array();
	$relatedTagsInterimArray = relatedTagsLogicBuilderIteratingThruAllCriteria($searchResults["matched_title"], $relatedTagsInterimArray);
	$relatedTagsInterimArray = relatedTagsLogicBuilderIteratingThruAllCriteria($searchResults["matched_tags"], $relatedTagsInterimArray);
	$relatedTagsInterimArray = relatedTagsLogicBuilderIteratingThruAllCriteria($searchResults["matched_content"], $relatedTagsInterimArray);
	$relatedTagsInterimArray = relatedTagsLogicBuilderIteratingThruAllCriteria($searchResults["matched_author"], $relatedTagsInterimArray);
	//print_r($relatedTagsInterimArray);

	$relatedTagsInterimArrayWithCountedValues = array_count_values($relatedTagsInterimArray);
	arsort($relatedTagsInterimArrayWithCountedValues);
	//print_r($relatedTagsInterimArrayWithCountedValues);
	
	$relatedTags = array();
	$counterForRelatedTags = 0;
	$counterMaxLimitForRelatedTags = 6;
	foreach ($relatedTagsInterimArrayWithCountedValues as $key => $value) {
			if($counterForRelatedTags < $counterMaxLimitForRelatedTags) {
				if(explode('-', $key) !== false) {
					$explodedArraySlug = explode('-',$key);
					$implodedStrForName = ucwords(implode(' ', $explodedArraySlug));
				}
				else {
					$implodedStrForName = ucwords($key);
				}
				array_push($relatedTags, array('tag_slug'=> $key, 'tag_name'=> $implodedStrForName));
				$counterForRelatedTags++;
			}
			else {
				break;
			}
	}
	return $relatedTags;
}

function relatedTagsLogicBuilderIteratingThruAllCriteria($searchResults, $relatedTagsInterimArray) {
	
	//$itermediateArrayForTags = array();
	for($i=0; $i<count($searchResults); $i++) {
		$itermediateArrayForTags = $searchResults[$i]["tags"];
		//print_r($itermediateArrayForTags);
		if(count($itermediateArrayForTags) > 0) {
			for($j=0; $j<count($itermediateArrayForTags); $j++) {
				array_push($relatedTagsInterimArray, $itermediateArrayForTags[$j]['tag_slug']);
			}
		}
	}
	return $relatedTagsInterimArray;
}

function toGetThumbnailCloudURLForCollection1stArticle($first_article_id, $blog_id, $site_url) {
	
	//4x3 and 16x9 cloudinary URLs for collection's 1st article thumbnails
	$featured16x9ImageID = get_post_thumbnail_id($first_article_id);
	//$featured16x9ImageID=get_field('thumbnail_custom_image', $first_article_id)
	$featured16x9ImageCloudURLFor1stArticle = get_post_meta($featured16x9ImageID, '_wp_attached_file');
	//print_r($featured16x9ImageCloudURLFor1stArticle);
	 
	if($featured16x9ImageCloudURLFor1stArticle[0] != "") {
		if(strpos($featured16x9ImageCloudURLFor1stArticle[0], 'cloudinary.com') > 0) {
			
		}
		else {
			$featured16x9ImageCloudURLFor1stArticle[0] = $site_url.'/wp-content/uploads/sites/'.$blog_id.'/'.$featured16x9ImageCloudURLFor1stArticle[0];
		}
		
		return $featured16x9ImageCloudURLFor1stArticle[0];
	}
	else {
		return "";
	}		
}

function toGetThumbnailCloudURLForStory($attachment_id, $blog_id, $site_url) {
	//4x3 cloudinary URLs for stories
	$thumbnail4x3CloudinaryURLForStory = get_post_meta($attachment_id, '_wp_attached_file'); 
	//print_r($thumbnail4x3CloudinaryURLForStory);
	
	if($thumbnail4x3CloudinaryURLForStory[0] != "") {
		if(strpos($thumbnail4x3CloudinaryURLForStory[0], 'cloudinary.com') > 0) {
			
		}
		else {
			$thumbnail4x3CloudinaryURLForStory[0] = $site_url.'/wp-content/uploads/sites/'.$blog_id.'/'.$thumbnail4x3CloudinaryURLForStory[0];
		}
		
		return $thumbnail4x3CloudinaryURLForStory[0];
	}
	else {
		return "";
	}	
}

function toGetAdditonalAuthorMetaInfoForPosts ($post_id, $blog_id, $site_url) {
	$post = get_post( $post_id );                      
	$user = get_userdata( $post->post_author );
	//print_r($user->user_login);
	$user_written_articles_count = count_user_posts($user->ID, array('post', 'videostory', 'photostory'), true);
	$user_meta = get_user_meta($user->ID);
	$user_category = '';
	$userArrayToGetSecondaryRole = array();
	$userArrayToGetSecondaryRole = unserialize($user_meta['wp_'.$blog_id.'_capabilities'][0]);
	if(array_key_exists('author_journeys', $userArrayToGetSecondaryRole) || array_key_exists('editor_journeys', $userArrayToGetSecondaryRole)) {
        $user_category = "journeys";
    }
    elseif(array_key_exists('author_samsara', $userArrayToGetSecondaryRole) || array_key_exists('editor_samsara', $userArrayToGetSecondaryRole)) {
        $user_category = "samsara";
    }
    else {
        $user_category = '';
    }
	$user_meta_description = $user_meta['description'][0];
	$user_meta_avatar_id = $user_meta['wp_'.$blog_id.'_user_avatar'][0];
	$user_meta_avatar_src = '';
	
	if($user_meta_avatar_id != '' ) {
		$user_meta_avatar_src = get_post_meta($user_meta_avatar_id, '_wp_attached_file'); 
		if($user_meta_avatar_src[0] != "") {
			if(strpos($user_meta_avatar_src[0], 'cloudinary.com') > 0) {
				
			}
			else {
				$user_meta_avatar_src[0] = $site_url.'/wp-content/uploads/sites/'.$blog_id.'/'.$user_meta_avatar_src[0];
			}
		}
	}
	
	return array(
		'user_meta_description'=>$user_meta_description, 
		'user_meta_avatar_src' => $user_meta_avatar_src[0],
		'user_login' => $user->user_login,
		'user_id' => $user->ID,
		'items_authored' => $user_written_articles_count,
		'user_category' => $user_category,
	);
}

function getCatAttributesForStories($es_query, $catAttributesArray, $post_type) {
	if($post_type == 'photostory' || $post_type == 'videostory') { 
		$actualCatID = $es_query->post->meta['acf_category'][0]['value'];
		
	}
	elseif($post_type == 'collection'){
		$actualCatID = $es_query->post->meta['collection_category'][0]['value'];
	}
	elseif($post_type == 'post'){
		$actualCatID = $es_query->post->terms['category'][0]['term_id'];
	}
		
	if($actualCatID != '')	{
		$categoryInterim = get_category($actualCatID);
		if(checkIfCatHasParent($actualCatID)==true) {
			$parentCatsString = rtrim(toGetTheTopMostParentCatIfCatHasParents($actualCatID), '/');
			
			if(explode($parentCatsString,'/') !== false) { 
				$explodedParentCatsArray = explode('/', $parentCatsString);
				if(strpos($explodedParentCatsArray[0],' ') > 0) {
					$catAttributesArraySlug = str_replace(' ','-',strtolower($explodedParentCatsArray[0]));
				}
				else {
					$catAttributesArraySlug = strtolower($explodedParentCatsArray[0]);
				}
				$catAttributesArray = array(
					'parent_cat_name' => $explodedParentCatsArray[0],
					'parent_cat_slug' => $catAttributesArraySlug,
					'actual_cat_name'=>	 $categoryInterim->name,
					'actual_cat_slug'=>  $categoryInterim->slug,
				);
			}
		}
		else {
			$catAttributesArray = array(
				'parent_cat_name' => $categoryInterim->name,
				'parent_cat_slug' => $categoryInterim->slug,
				'actual_cat_name'=>	 $categoryInterim->name,
				'actual_cat_slug'=>  $categoryInterim->slug,
			);
		}
		
		
	} 
	else {
		$catAttributesArray = array(
				'parent_cat_name' => '',
				'parent_cat_slug' => '',
				'actual_cat_name'=>	 '',
				'actual_cat_slug'=>  '',
		);	
		
	}
	return $catAttributesArray;
}

function checkIfCatHasParent($catid){
	$category = get_category($catid);
	if ($category->category_parent > 0){
		return true;
	}
	return false;
}

function toGetTheTopMostParentCatIfCatHasParents($catid) {
	//if(checkIfCatHasParent($catid)==true) {
		return get_category_parents($catid);
	//}
	//return '';
	
}

//CODE START FOR AUTO SYNCING AS PER CRON INTERVAL

/*This function is used to add every minutes cron setup*/

add_filter( 'cron_schedules', 'add_minutes_intervals');
function add_minutes_intervals($schedules){
	
	$schedules['minutes'] = array(
		'interval' => 120,
		'display' => __('Once Every Ten Minutes')
	);

	return $schedules;
}

/*This function is used to call auto sync elastic function in every minutes*/

add_action('my_minutes_event', 'do_this_hourly_for_elastic_syncing');
function elastic_press_auto_sync() {
	if ( !wp_next_scheduled( 'my_minutes_event' ) ) {
		wp_schedule_event( current_time( 'timestamp' ), 'minutes', 'my_minutes_event');
	}
}

/*This function is used to auto sync data in every minutes */

add_action('wp', 'elastic_press_auto_sync');
function do_this_hourly_for_elastic_syncing() {
	global $wpdb;

	$posttitle = 'auto_sync_through_cron'; //Set post title
	$args = array("post_type" => "elastic_cron", "s" => $posttitle); //Get Post through title
	$query = get_posts( $args );
	if(empty($query)){
		$my_post = array(
			'post_title' => $posttitle,
			'post_content' => 'This is used to check that cron is running or not.',
			'post_status' => 'publish',
			'post_type' => 'elastic_cron',
		);
		$the_post_id = wp_insert_post( $my_post );	
		__update_post_meta( $the_post_id, 'cron_current_status', 'completed');	
	}
	else {
		$the_post_id = $query[0]->ID;
	}
	
	$cron_meta = get_post_meta( $the_post_id, 'cron_current_status', true ); 
	
	if($cron_meta =='running'){
		exit();
	}
	else {
		__update_post_meta( $the_post_id, 'cron_current_status', 'running');		
		if (class_exists('EP_Dashboard')) {
			ini_set('memory_limit','2048M');
			//$response = EP_Dashboard::action_wp_ajax_ep_index($call_type="custom_cron");
			echo '<script>jQuery(document).ready(function(){jQuery.post( "'. home_url('/wp-admin/admin-ajax.php').'", { action: "ep_index", feature_sync: false, nonce: "'.wp_create_nonce( 'ep_dashboard_nonce' ).'", }).done(function( data ) {console.log(data)});});</script>';
		}
	}
}

add_action('ep_pre_dashboard_index', 'update_complete_status');
function update_complete_status(){
	global $wpdb;
	$posttitle = 'auto_sync_through_cron'; //Set post title
	$args = array("post_type" => "elastic_cron", "s" => $posttitle); //Get Post through title
	$query = get_posts( $args );
	$the_post_id = $query[0]->ID;
	__update_post_meta( $the_post_id, 'cron_current_status', 'Completed');
}

/**
  * Updates post meta for a post. It also automatically deletes or adds the value to field_name if specified
*/
function __update_post_meta( $post_id, $field_name, $value = '' ){
	if ( empty( $value ) OR ! $value )	{
		delete_post_meta( $post_id, $field_name );
	}
	elseif ( ! get_post_meta( $post_id, $field_name ) ) {
		add_post_meta( $post_id, $field_name, $value );
	}
	else {
		update_post_meta( $post_id, $field_name, $value );
	}
}

	
//CODE END FOR AUTO SYNCING AS PER CRON INTERVAL


/** Search Ends**/
function set_ac_search_args_title( $ep_formatted_args, $args ) {
	
	if( isset( $args['autocomplete'] ) && $args['autocomplete'] ) {
		$titleSearchTerm = '';
		
			$titleSearchTerm = strtolower($args['s']); 
		
			$ep_formatted_args['query'] = array(
				"match_phrase_prefix" => array(
					"post_title.suggest" => array(
						"query" => $titleSearchTerm,
					),
				),
			);
			
			
	}	
	return $ep_formatted_args;
}

add_action('wp_ajax_autocomplete_search_ajax_results', 'autocomplete_search_ajax_results');
add_action('wp_ajax_nopriv_autocomplete_search_ajax_results', 'autocomplete_search_ajax_results');

function autocomplete_search_ajax_results() {
	
	$searchResults = $ac_results = $final_ac_results = array();
	
	add_filter( 'ep_formatted_args', 'set_ac_search_args_title', 300, 2 );
	$searchResults = ac_wp_query_get_object($_REQUEST['s']);	
	
	if($searchResults->found_posts > 0) {
		$pst=1;
		while ($searchResults->have_posts()) : $searchResults->the_post();
			$ac_results[$pst]['title'] = $searchResults->post->post_title;
			$ac_results[$pst]['id'] = $searchResults->post->ID;
		$pst++;
		endwhile;
	}
	
	if(!empty($ac_results)){
		$i=1;
		foreach($ac_results as $ac_results_val){
			
			if(stripos($ac_results_val['title'], $_REQUEST['s'])==0){
				if($i<=4){
					$final_ac_results['code'] = "success";
					$final_ac_results['results'][] = $ac_results_val;	
					$i++;	
				}				
			}
		}
		
	}else{
		$final_ac_results['code'] = "fail";
	}
	echo json_encode($final_ac_results);	die;

}

function ac_wp_query_get_object($searchStrToGetQueryObject) {
	$es_query_obj = new WP_Query( array(
		'posts_per_page' => -1,
		'ep_integrate' => true,
		'autocomplete' => true,
		'sites' => 'current',
		's'     => $searchStrToGetQueryObject,
		'post_status' => array('publish'),
		'post_type' => array('post','photostory','videostory','journeys'),
		'orderby' => 'modified',
		'post__not_in' => array(3462),
	) );
	return $es_query_obj;
}

ob_end_clean();

// check for iphone 
function check_iphone(){
    
    if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') )
    {
        echo '<style>
        		.searchPop{ position: absolute !important;}
        		@media screen and (max-width: 767px) {
					ul.autoCompleteRes {
					    top: 87px;
					}
				}
        	</style>';
    }
}

add_action("wp_head",'check_iphone');

function check_mac(){
	$user_agent = getenv("HTTP_USER_AGENT");

	if(strpos($user_agent, "Win") !== FALSE)
	$os = "Windows";
	elseif(strpos($user_agent, "Mac") !== FALSE)
	$os = "Mac";

	if($os === "Mac")
	{
		echo '<style type="text/css"> 
			.min-read{  margin-top: 1px;}
			.photo-story span.min-read {margin-top: 0;}
		</style>';
	}
}

add_action("wp_head",'check_mac');
//code to override the bp search slug to avoid conflict EMAG-891
add_action('bp_get_search_slug', 'my_search_cust_slug_bp');
function my_search_cust_slug_bp() {
	return 'search-bp';
}



add_action( 'save_post','save_post_callback', 10, 3 );
//add_action( 'publish_post', 'save_post_callback', 100, 2 );
function save_post_callback($post_id, $post, $update){
    updatePostContentFieldWithACFContentBlocks($post);
}

add_action( 'wp_insert_post', 'insert_post_callback', 10, 3 );
function insert_post_callback($post_id, $post, $update ){
    //global $post; 
	//global $wpdb;
    updatePostContentFieldWithACFContentBlocks($post);
}
function elasticPressSyncMethod($post_id) {
	/*if (class_exists('EP_Dashboard')) {
			ini_set('memory_limit','2048M');
			//$response = EP_Dashboard::action_wp_ajax_ep_index($call_type="custom_cron");
			echo '<script>jQuery(document).ready(function(){jQuery.post( "'. home_url('/wp-admin/admin-ajax.php').'", { action: "ep_index", feature_sync: true, nonce: "'.wp_create_nonce( 'ep_dashboard_nonce' ).'", }).done(function( data ) {console.log(data)});});</script>';
		}*/
	if(class_exists('EP_Sync_Manager')) {
		ini_set('memory_limit','2048M');
		$classRef = new EP_Sync_Manager;
		$classRef->action_sync_on_update($post_id);
	}
}
function updatePostContentFieldWithACFContentBlocks($post=[]) {
	if(empty($post)) { 
		global $post;
	}
	global $wpdb;
    if ($post->post_type == 'post' || $post->post_type == 'videostory' || $post->post_type == 'photostory'){
		$blog_id = get_current_blog_id();
		$site_url = get_site_url($blog_id);
		$query = 'SELECT * from wp_'.$blog_id.'_postmeta where post_id="'.$post->ID.'" and meta_key LIKE "content_%" AND (meta_key LIKE "%title%" OR meta_key LIKE "%heading%" OR meta_key LIKE "%description%" 
				  OR meta_key LIKE "%caption%" OR meta_key LIKE "%text%" OR meta_key LIKE "%paragraph%");';

		$results = $wpdb->get_results($query);
		$postContentFromFlexiFields = '';
		$delimiter = " ";
		for($i=0; $i<count($results); $i++) {
			$postContentFromFlexiFields = $postContentFromFlexiFields.$results[$i]->meta_value.$delimiter;
	
		}
		
		$queryForExcerpt = 'SELECT post_excerpt from wp_'.$blog_id.'_posts where ID="'.$post->ID.'";';
		$resultsForExcerpt = $wpdb->get_results($queryForExcerpt);
		$postExcerptHere = $resultsForExcerpt[0]->post_excerpt;
		
		//$postContentFromFlexiFields = $postContentFromFlexiFields.' '.$post->post_excerpt;
		$postContentFromFlexiFields = $postContentFromFlexiFields.' '.$postExcerptHere;
		//die('TEST ='.$postContentFromFlexiFields);
		$wpdb->query('UPDATE wp_'.$blog_id.'_posts SET post_content = "'.$postContentFromFlexiFields.'" WHERE ID="'.$post->ID.'"');
		//elasticPressSyncMethod($post->ID);
	}
	else {
		return;
	}
}
/*code (for search) to update post_content with the ACF text fields values held by the stories, end*/
?>