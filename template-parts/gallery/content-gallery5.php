<?php
	while ( have_rows( 'gallery_images' ) ) : the_row(); 
		if($counter==1) {
			$img_gallery_images = get_sub_field( 'img_gallery_images' );
			if ( $img_gallery_images ) { 
				$lm_url=$img_gallery_images['url'];
				$lm_alt=$img_gallery_images['alt'];
				if(strpos($lm_url,'cloudinary.com') > 0){
					$firimg_url = str_replace("image/upload/","image/upload/c_fill,ar_1.47,f_auto,q_auto,w_auto,g_auto/",$lm_url);
				}else{
					$firimg_url = $lm_url; 
				}
			}
			?>
			<div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
				<a href="<?php echo $firimg_url; ?>" data-caption="<?php the_sub_field( 'galleryimage_caption' ); ?>" data-fancybox="images">
					<img alt="<?php echo $lm_alt; ?>" src="<?php echo $firimg_url; ?>" class="w-100"> 
				</a>
			</div>      
		<?php 
		} 
		$counter++; 
	endwhile; ?> 
	
	<div class="col-xl-6 col-md-6 col-lg-6 col-sm-12">
		<div class="row">
			<?php 
			$countj=1;
			
			while ( have_rows( 'gallery_images' ) ) : the_row(); 
				if($countj !=1) { 
					
					$smimg_gallery_images = get_sub_field( 'img_gallery_images' ); 
					
					if( $smimg_gallery_images ) { 
						$sm_url=$smimg_gallery_images['url'];
						$sm_alt=$smimg_gallery_images['alt'];
						$sm_caption=get_sub_field( 'galleryimage_caption' );
						if(strpos($sm_url,'cloudinary.com') > 0){
							$scimg_url = str_replace("image/upload/","image/upload/c_fill,ar_1.49,f_auto,q_auto,w_auto,g_auto/",$sm_url);
						}else{
							$scimg_url = $sm_url; 
						}

					}	?>
					<div class="col-xl-6 col-md-6 col-lg-6 col-6">
						<a  href="<?php echo $scimg_url; ?>" data-caption="<?php the_sub_field( 'galleryimage_caption' ); ?>" data-fancybox="images">  
							<img title="gallery" src="<?php echo $scimg_url; ?>" class="w-100">
						</a>
					</div>
		
				<?php  
				} 
				$countj++;   
			endwhile; ?> 
		</div>
	</div>