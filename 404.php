<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); 
 
?>

<!-- To redirect to searhc page -->


<div class="live_wrap pt-196 padT4rem">
	<div class="row">
		  <div class="container">
				<div class="row">

					<div class="col-md-12">
						<div class="error-template">
							<h1 class="hero_title_r text-1 hero_title_s">Oops! 404 Not Found</h1>
							<p class="m-42">Sorry, an error has occured, Requested page not found.</p>
							<div class="error-actions">
							   <!--  <a href="<?php //echo site_url(); ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
									Take Me Home </a><a href="mailto:magazine@round.glass" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>

<style>
.footer_area{
	display: block !important;  
}
.error-template {text-align: center;}
.error-actions {margin-top:15px;margin-bottom:15px;}
.error-actions .btn { margin-right:10px; }
.padT4rem{padding:18rem 0 !important;}
</style>
<?php get_footer();