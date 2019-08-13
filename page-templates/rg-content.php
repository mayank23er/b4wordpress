<?php
/*
Template Name: Content Default template
*/

get_header(); 
//header white js
wp_register_script('experience-js', get_template_directory_uri() . '/theme/js/experience.js',array('jquery'), null, true);
wp_enqueue_script('experience-js');
?>

<?php get_header();?>
<section class="articles-marginT">
	<div class="content-area container">
	<?php while ( have_posts() ) : the_post(); ?>
		<h3><?php the_title(); ?></h3>
		<div class="content-container"><?php
		$cont=get_field('wcommon_content')  ?: ''; 	
		echo $cont;
		?></div>
				
	<?php endwhile; ?>
	</div>
</section>
<style>
.content-container{
	padding-top:20px;
}
strong{
	font-weight:600;
}
</style>
<?php get_footer(); ?>	
