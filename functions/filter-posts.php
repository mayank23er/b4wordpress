<?php

	/**!
	 * Filter journeys
	 */

	//assign tag template
	add_action('init', function() {
		
		$request_uri = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
		$post_type = $post_slug ='';
		if(!empty($request_uri)){

			$explodedRequestURI = explode("/",$request_uri);
			@$post_type = $explodedRequestURI[0];
			@$post_slug = $explodedRequestURI[1];
		}
		
		if ( $post_slug === 'filter_journey' ) {
			// load the file if exists
			$load = locate_template('page-templates/rg-filters.php', true);	
			if ($load) {
				exit(); // just exit if template was found and loaded
			}
		}
	}); 
	
	/*Ajax filteration by requested paramters*/
	add_action('wp_ajax_journeys_filteration', 'journeys_filteration'); 
	add_action('wp_ajax_nopriv_journeys_filteration', 'journeys_filteration');	
	function journeys_filteration(){
		$blog_id = get_current_blog_id();
		global $wpdb; 
		$my_custom_query = $journey_time = array();
		
		// Set Query for Journeys Type
		if(isset($_POST['journey_type']) && !empty($_POST['journey_type']) ){
			
			$journey_type = "'".implode("','",$_POST['journey_type'])."'";
			$my_custom_query = array_merge($my_custom_query, array("( wp_".$blog_id."_postmeta.meta_key = 'ACF_journey_experiences' AND wp_".$blog_id."_postmeta.meta_value IN (".$journey_type.") )"));
			
		}
		
		// Set Query for Journeys Month
		if(isset($_POST['journey_time']) && !empty($_POST['journey_time']) ){
			
			foreach($_POST['journey_time'] as $time_key=>$time_val){
				
				$exploded_j_time = explode("-",$time_val);
				$start_month = $exploded_j_time[0];
				$end_month =  $exploded_j_time[1];
			
				$journey_time_multiple[] = "( ( mt2.meta_key = 'journey_start_month_custom' AND mt2.meta_value >= '".$start_month."' ) AND ( mt2.meta_key = 'journey_start_month_custom' AND mt2.meta_value <= '".$end_month."' ) )";
			}
			
			if(!empty($journey_time_multiple)){
				$multiple_journey_time_query = array("(".implode(" OR ",$journey_time_multiple).")");	
				$my_custom_query = array_merge($my_custom_query, $multiple_journey_time_query);
			}
		} 
		
		// Set Query for Journeys Duration
		if(isset($_POST['journey_duration']) && !empty($_POST['journey_duration']) ){
					
			$days = $nights =  array();
			foreach($_POST['journey_duration'] as $j_type){
				$exploded_j_type = explode("-",$j_type);
				$journey_duration_multiple[] = "( ( mt1.meta_key = 'total_days' AND mt1.meta_value = '".$exploded_j_type[0]."' ) AND ( mt3.meta_key = 'total_nights' AND mt3.meta_value = '".$exploded_j_type[1]."' ) )";
			}
			
			if(!empty($journey_duration_multiple)){
				$multiple_journey_duration_query = array("(".implode(" OR ",$journey_duration_multiple).")");	
				$my_custom_query = array_merge($my_custom_query, $multiple_journey_duration_query);
			}
			
		}
		
		if(!empty($my_custom_query))
		{
			
			$final_query = implode(" AND ",$my_custom_query);
			
			$param_query = "SELECT SQL_CALC_FOUND_ROWS wp_".$blog_id."_posts.ID FROM wp_".$blog_id."_posts ";
			
			$param_query .="INNER JOIN wp_".$blog_id."_postmeta ON ( wp_".$blog_id."_posts.ID = wp_".$blog_id."_postmeta.post_id ) "; 
			
			if(isset($_POST['journey_duration']) && !empty($_POST['journey_duration']) ){
				$param_query .="INNER JOIN wp_".$blog_id."_postmeta AS mt1 ON ( wp_".$blog_id."_posts.ID = mt1.post_id ) "; 
				$param_query .="INNER JOIN wp_".$blog_id."_postmeta AS mt3 ON ( wp_".$blog_id."_posts.ID = mt3.post_id ) "; 
			}
			if(isset($_POST['journey_time']) && !empty($_POST['journey_time']) ){
				$param_query .="INNER JOIN wp_".$blog_id."_postmeta AS mt2 ON ( wp_".$blog_id."_posts.ID = mt2.post_id ) "; 
			}
			$param_query .="WHERE 1=1 AND (".$final_query.") AND wp_".$blog_id."_posts.post_type = 'journey' AND ((wp_".$blog_id."_posts.post_status = 'publish')) GROUP BY wp_".$blog_id."_posts.ID ORDER BY wp_".$blog_id."_posts.post_date DESC";
			//echo $param_query; die;
			$get_results= $wpdb->get_results($param_query);	
			
		}else{
			$param_query = "SELECT SQL_CALC_FOUND_ROWS wp_".$blog_id."_posts.ID FROM wp_".$blog_id."_posts 
			INNER JOIN wp_".$blog_id."_postmeta ON ( wp_".$blog_id."_posts.ID = wp_".$blog_id."_postmeta.post_id ) 
			WHERE 1=1 
			AND wp_".$blog_id."_posts.post_type = 'journey' AND ((wp_".$blog_id."_posts.post_status = 'publish')) GROUP BY wp_".$blog_id."_posts.ID ORDER BY wp_".$blog_id."_posts.post_date DESC";
			//echo $param_query; die;
			$get_results= $wpdb->get_results($param_query);	
		}


		if( $get_results ) : 
			global $post;
			$count = count($get_results);
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
						$jurl = str_replace("image/upload/","image/upload/c_fill,ar_1.48,f_auto,q_auto,w_1920,g_auto/",$cloud_jurl);
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
					
					@$html .='<div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
					<div class="exp-list">
					<a href="'.$journey_link.'" class="img-wrapper-animate display-inherit;"><img src="'.$jurl.'" alt="'.$jalt.'" /></a>
					<div class="sub-header">'.strtoupper($experience_name).'</div>
					<h5>'.$j_title.'</h5>
					<p class="light dk-jndesc">'.$j_desc.'</p>
					<div class="location">
					<span class="map">'.$j_city.'</span>
					<span class="day">'.$tdays.'</span>
					<a data-image="'.$purl.'" data-title="'.$j_title.'" data-city="'.$j_city.'" href="" data-toggle="modal" data-target="#myBook" class="bkform float-right url">+ BOOK</a>
					</div>
					</div>
					</div>';
			}  
			echo $count."==::==".$html;
			wp_reset_postdata();
		else :
			echo $count."==::==".'<div class="exp-list"><h5>No posts found.</h5></div>';
		endif;
	 
		die();
	}
	 
	/*Save journey hook*/
	function add_custom_date_of_journey( $post_id ) {
		
		/*
		 * In production code, $slug should be set only once in the plugin,
		 * preferably as a class property, rather than in each function that needs it.
		 */
		$post_type = get_post_type($post_id);

		// If this isn't a 'book' post, don't update it.
		if ( "journey" != $post_type ) return;
		$start_journey_date = get_post_meta( $post_id, 'ACF_journey_smonth', true );
		$start_journey_month =  date("m",strtotime($start_journey_date));
		if(!empty($start_journey_month )){
			update_post_meta($post_id, "journey_start_month_custom", $start_journey_month);
		}
	   
	}
	add_action( 'save_post', 'add_custom_date_of_journey' );
	
	/*GET Journeys Day Night Value For input box over filter page*/
	function get_day_night(){
		
		$args = array( 'post_type' => 'journey', 'posts_per_page' => -1, 'post_status' 	=> 'publish', );
		$loop = new WP_Query( $args );
		$total_journey_duration = array();
		if($loop->have_posts()){
			$k=1;
			while ( $loop->have_posts() ) : $loop->the_post();
				$jid=get_the_ID();
				$total_journey_duration[$k]['total_nights'] = get_field('total_nights',$jid );
				$total_journey_duration[$k]['drop_title'] = get_field('total_nights',$jid )." Nights ".get_field('total_days',$jid )." Days";
				$total_journey_duration[$k]['drop_value'] = get_field('total_days',$jid )."-".get_field('total_nights',$jid );
			$k++;
			endwhile;	
		}	
		$unique_array = super_unique($total_journey_duration,'drop_value');
		return sort_my_array($unique_array);
		
	}
	
	/*Return Journeys Day Night Value by unique*/
	function super_unique($array,$key){
       $temp_array = [];
       foreach ($array as &$v) {
           if (!isset($temp_array[$v[$key]]))
           $temp_array[$v[$key]] =& $v;
       }
       $array = array_values($temp_array);
       return $array;

    }
	
	/*Return Journeys Day Night Value Order by Asc*/
	function sort_my_array($sort_my_array){
		if(is_array($sort_my_array)){
			foreach ($sort_my_array as $key => $row)
			{
				$sort_my_array_name[$key] = $row['total_nights'];
			}
			array_multisort($sort_my_array_name, SORT_ASC, $sort_my_array);
			return $sort_my_array;
		}else{
			return true;
		}
		
	}