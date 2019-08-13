<?php
/* 
Template Name: Filter Page
*/
get_header(); 
//header white js
wp_register_script('experience-js', get_template_directory_uri() . '/theme/js/experience.js',array('jquery'), null, true);
wp_enqueue_script('experience-js');

$today = date('Ymd'); 
$journeys = array(
	'post_type'  => array('journey'),
	'meta_key' => 'ACF_journey_smonth',
	'post_status'	=> 'publish',
	'orderby' => 'publish_date',
	'offset' => 1, 
	'order' => 'DESC',
	'meta_query' => array(
		'key' => 'ACF_journey_smonth',
		'value' => $today,
		'compare' => '>='
	)
);

$loop = new WP_Query( $journeys ); 
?>
<section class="search-filters articles-marginT">
	<div class="container">
		<div class="row">
			<div id="all-filters" class="col-md-12">
				<h4><span class="storiesCount"><?php echo $loop->post_count; ?></span> <span class="headingJ" style="font-family: Gibson;font-size: 18px;font-weight: 600;font-style: normal;font-stretch: normal;line-height: 48px;letter-spacing: 4px;color: #bbbbbb;text-transform: uppercase;">Journeys</span></h4>
				<div id="all-filters-drop">
					<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="journey_filter_form">
						<ul class="drop-downf">
							<li class="drop-filter">
								<a href="#">All Journeys</a>
								<ul>
									<li><input type="checkbox" id="journey_type_all" class="journey_filter_field journey_type_global"><label for="journey_type_all">All</label></li>
									<?php 
									$args = array( 'post_type' => 'experience', 'posts_per_page' => -1, 'post_status' 	=> 'publish', );
									$loop = new WP_Query( $args );
									while ( $loop->have_posts() ) : $loop->the_post();
									  
									echo '<li><input id="journey_type_'.get_the_ID().'" type="checkbox" class="journey_filter_field journey_type" name="journey_type[]" value="'.get_the_ID().'"><label for="journey_type_'.get_the_ID().'">'.get_the_title().'</label></li>';  
									endwhile;
									?>
								</ul>
							</li>
							<li class="drop-filter">
								<a href="#">Time</a>
								<ul>
									<li><input type="checkbox" id="journey_time_all" class="journey_filter_field journey_time_global"><label for="journey_time_all">All</label></li>
									<li><input type="checkbox" id="m_journey_time_01-03" class="journey_filter_field journey_time" name="journey_time[]" value="01-03"><label for="m_journey_time_01-03">Jan - Mar</label></li>
									<li><input type="checkbox" id="m_journey_time_04-06" class="journey_filter_field journey_time" name="journey_time[]" value="04-06"><label for="m_journey_time_04-06">Apr - Jun</label></li>
									<li><input type="checkbox" id="m_journey_time_07-09" class="journey_filter_field journey_time" name="journey_time[]" value="07-09"><label for="m_journey_time_07-09">Jul - Sep</label></li>
									<li><input type="checkbox" id="m_journey_time_10-12" class="journey_filter_field journey_time" name="journey_time[]" value="10-12"><label for="m_journey_time_10-12">Oct - Dec</label></li>
								</ul>
							</li>
							<li class="drop-filter">
								<a href="#">Duration</a>
								<ul>
									<li><input id="journey_duration_all" type="checkbox" class="journey_filter_field journey_duration_global"><label for="journey_duration_all">All</label></li>
									<?php 
									$day_night_checkbox_value = get_day_night();
									if(!empty($day_night_checkbox_value)){
										foreach($day_night_checkbox_value as $checkbox_value){
											echo '<li><input id="m_journey_duration_'.$checkbox_value['drop_value'].'" type="checkbox" class="journey_filter_field journey_duration" name="journey_duration[]" value="'.$checkbox_value['drop_value'].'"><label for="m_journey_duration_'.$checkbox_value['drop_value'].'">'.$checkbox_value['drop_title'].'</label></li>';
										}
									}
									?>
								</ul>
							</li>
						</ul>
						<input type="hidden" name="action" value="journeys_filteration">
						<a href="#" class="filter-cta">FILTERS</a>
					</form>
				</div>
			</div>
	
		<div style="min-height:400px" class="row results waitJourneysResponse"></div>
	</div>
</section>


<!-- Mobile Journey Filter Popup Start-->
<div class="modal" id="journeyMobileFilterPopup">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<img src="<?php echo MAIN_DIR; ?>/images/close-icon.png" />
				</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<div id="all-filters-drop">
					<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" class="" id="journey_filter_form_mobile">
						<div id="filters-mobile">			
							<h6>Experiences</h6>
							<ul>
								<li><input type="checkbox" id="m_journey_type_all" class="journey_type_global" checked><label for="m_journey_type_all">All</label></li>
								<?php 
								$args = array( 'post_type' => 'experience', 'posts_per_page' => -1, 'post_status' 	=> 'publish', );
								$loop = new WP_Query( $args );
								while ( $loop->have_posts() ) : $loop->the_post();
								  
								echo '<li><input type="checkbox" id="journey_type'.get_the_ID().'" class="journey_type" name="journey_type[]" value="'.get_the_ID().'"><label for="journey_type'.get_the_ID().'">'.get_the_title().'</label></li>';  
								endwhile;
								?>
							</ul>
							<div class="clearfix"></div>
							<h6>Time</h6>
							<ul>
								<li><input id="m_journey_time_all" type="checkbox" class="journey_time_global" checked><label for="m_journey_time_all">All</label></li>
								<li><input id="journey_time_01-03" type="checkbox" class="journey_time" name="journey_time[]" value="01-03"><label for="journey_time_01-03">Jan - Mar</label></li>
								<li><input id="journey_time_04-06" type="checkbox" class="journey_time" name="journey_time[]" value="04-06"><label for="journey_time_04-06">Apr - Jun</label></li>
								<li><input id="journey_time_07-09" type="checkbox" class="journey_time" name="journey_time[]" value="07-09"><label for="journey_time_07-09">Jul - Sep</label></li>
								<li><input id="journey_time_10-12" type="checkbox" class="journey_time" name="journey_time[]" value="10-12"><label for="journey_time_10-12">Oct - Dec</label></li>
							</ul>
							<div class="clearfix"></div>
							<h6>Duration</h6>
							<ul>
								<li><input id="m_journey_duration_all" type="checkbox" class="journey_duration_global" checked><label for="m_journey_duration_all">All</label></li>
								<?php 
								$day_night_checkbox_value = get_day_night();
								if(!empty($day_night_checkbox_value)){
									foreach($day_night_checkbox_value as $checkbox_value){
										echo '<li><input id="journey_duration_'.$checkbox_value['drop_value'].'" type="checkbox" class="journey_duration" name="journey_duration[]" value="'.$checkbox_value['drop_value'].'"><label for="journey_duration_'.$checkbox_value['drop_value'].'">'.$checkbox_value['drop_title'].'</label></li>';
									}
								}
								?>
							</ul>
							<ul>
								<li class=""><a href="Javascript:void(0)" class="nav-link nav-btn apply_filter">Apply</a></li>
							</ul>	
						</div>
						<input type="hidden" name="action" value="journeys_filteration">
						
					</form>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- Mobile Journey Filter Popup Start-->
<style>
.waitJourneysResponseExtraHeight{
    background: #fff !important;
    height: 500px;
    margin: 0 auto;
    width: 100%;
}
.waitJourneysResponseExtraHeight img.ajax_loader {
    margin: 0 auto;
    height: 75px;
    position: relative;
    top: 25%;
}
.light.min-h-70{
	min-height:70px;
}
</style>
<?php
get_footer();
?>