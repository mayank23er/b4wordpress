<?php
/**
 * Displays content for front page
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
$postAuthorIDHere = $post->post_author;
$postAuthorHere = ucwords(get_the_author_meta('display_name', $postAuthorIDHere));
$author_url = get_author_page_link_by_article_id(get_the_ID());
?>

	<section class="community paddTopBottomArticleSection paddTopBottomZero">
		<div class="container">
			<div class="community-wrap">
				<div class="tag-comm">
					<div class="written">
						<div class="row">
							<div class="col-xl-7 col-md-6 col-lg-6 col-sm-12">
								<div class="media">
									<?php if ( get_field( 'AUTHORIMAGE' ) ) { 
										$author_img = get_field( 'AUTHORIMAGE' );
										// if(strpos($author_img,'cloudinary.com') > 0){ 
										// 	$author_img = str_replace("image/upload/","image/upload/c_fill,ar_1:1,g_auto/w_80,q_auto:best,f_auto/",$author_img);
										// }
										
									?>
										<a href="<?php echo $author_url; ?>" class="author-no-decor"><img class="mr-4 rounded-circle" src="<?php echo $author_img; ?>" /></a>
									<?php } ?>
									
									<div class="media-body">
										<h6 class="mt-0 light"><?php the_field( 'WrittenByText' ); ?></h6>
										<h5 class="mt-0">
											<?php if ( get_field( 'customauthor_name' ) ){
													?>
													<?php echo get_field( 'customauthor_name' ); ?>
													<?php
											}
											else { ?> 
											<a href="<?php echo $author_url; ?>" class="author-no-decor"><?php echo $postAuthorHere; ?></a>
										<?php } ?>
										</h5>
									</div>
								</div>
							</div>
							<div class="col-xl-5 col-md-6 col-lg-6 col-sm-12">
								<div class="share">
									<h5 class="light"><?php the_field( 'ShareStoryText' ); ?></h5>  
									<?php 
										$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
										
										if(has_post_thumbnail()):
											$fb_image = get_the_post_thumbnail_url();
										else:
											$fb_image =get_field('thumbnail_image_custom', $post->ID);
										endif;
										// if(strpos($fb_image,'cloudinary.com') > 0){ 
										// 	$fb_image = str_replace("image/upload/","image/upload/c_fill,ar_16:9,g_auto/w_1920,q_auto,f_auto/",$fb_image);
										// }
											?>
								
								<ul class="list-inline a2a_kit a2a_kit_size_32 a2a_default_style">
										<li class="list-inline-item">
											<a href="#" data-url="<?php echo $actual_link; ?>" data-image="<?php echo $fb_image; ?>"  data-description="<?php echo get_card_excerpt_of_article($post->ID); ?>" data-title="<?php echo get_the_title(); ?>" class="share-on-fb-article">
											<i class="fab fa-facebook-f"></i>
											</a>
										</li>
										<li class="list-inline-item">
											<a href="https://twitter.com/home?status=<?php echo esc_html( get_the_title() )." ".get_permalink(); ?>" class="twitter" title="Share on Twitter" target="_blank">
											<i class="fab fa-twitter"></i></a>
										</li>
										<li class="list-inline-item">
											<a href="https://plus.google.com/share?url=<?php echo get_permalink(); ?>" class="gplus" title="Share on Google+" target="_blank"><i class="fab fa-instagram"></i></a>		
										</li>
										<li class="list-inline-item"><a href=""><i class="fab fa-linkedin-in"></i></a></li>
									</ul>
									
								</div>
							</div>
						</div>
					</div>
					<?php 
					$post_tags = get_the_tags(); 
						if ( $post_tags ) { ?>
					<div class="tagged-in">
						<h5 class="light"><?php the_field( 'TaggsInText' ); ?>
						<?php
								foreach( $post_tags as $tag ) {
									$term_url = home_url().'/search_term/?tag='.$tag->name;	
									echo '<span><a href="'.$term_url.'" class="tag-button">'.strtoupper($tag->name).'</a></span>'; 
								}
							?>
						</h5>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>