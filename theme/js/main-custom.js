    $(document).ready(function() {
        /** hide prev and next slides on ready **/
        $('.swiper-slide-prev .swiper-slide-journey-cat-mobile').css('visibility', 'hidden');
        $('.swiper-slide-next .swiper-slide-journey-cat-mobile').css('visibility', 'hidden');

        /** Swiper Init **/
        var swiper_container_journey_cat = new Swiper('.swiper-container-journey-cat', {
            // pagination: '.swiper-pagination',
            // nextButton: '.swiper-button-next',
            // prevButton: '.swiper-button-prev',
            // paginationClickable: true,
            keyboard: {
                enabled: true,
                onlyInViewport: false,
            },
            coverflowEffect: {
                rotate: 30,
                slideShadows: false,
            },
            preloadImages: false,
            effect: 'slide',
            setWrapperSize: false,
            grabCursor: true,
            autoResize: false,
            centeredSlides: true,
            cssWidthAndHeight: true,
            visibilityFullFit: true,
            slidesPerView: '1.1',
            initialSlide: 0,
            centeredSlides: true,
            spaceBetween: 10,
            //spaceBetween: 40,
            loop: true,
            loopedSlides: 20,
            autoplay: 6000,
            autoplayDisableOnInteraction: true
        });

        $('.swiper-slide-prev .swiper-slide-journey-cat-mobile').css('visibility', 'hidden');
        $('.swiper-slide-next .swiper-slide-journey-cat-mobile').css('visibility', 'hidden');

        swiper_container_journey_cat.on('slideChangeTransitionStart ', function() {
            $('.swiper-slide-prev .swiper-slide-journey-cat-mobile').css('visibility', 'hidden');
            $('.swiper-slide-next .swiper-slide-journey-cat-mobile').css('visibility', 'hidden');
            $('.swiper-slide-active .swiper-slide-journey-cat-mobile').css('visibility', 'visible');
        });

        $("button.navbar-toggler").click(function() {
            $('html').toggleClass('no-scroll');
            $("nav.navbar").toggleClass("menucolor");
            if ($("nav.navbar").hasClas("menucolor") == true) {
                $(".logo-white").hide();
                $(".logo-black").show();

            } else {
                $(".logo-black").hide();
                $(".logo-white").show();
            }
        });

    });
	
	jQuery(function($){
		/*Check on document ready*/
		if($('.journey_type_global').prop("checked")) {
			$(".journey_type").prop("checked", true);
		} else {
			$(".journey_type").prop("checked", false);
		}  

		 if($('.journey_time_global').prop("checked")) {
			$(".journey_time").prop("checked", true);
		} else {
			$(".journey_time").prop("checked", false);
		}    

		if($('.journey_duration_global').prop("checked")) {
			$(".journey_duration").prop("checked", true);
		} else {
			$(".journey_duration").prop("checked", false);
		}   
		setTimeout(function(){
			$('#journey_filter_form').submit();	
		},200);
		
		/*Check on document ready*/
		$('.journey_filter_field').click(function(){
			setTimeout(function(){
				$('#journey_filter_form').submit();	
			},100);
			
		});
		
		$('.apply_filter').click(function(){
			setTimeout(function(){
				$('#journey_filter_form_mobile').submit();	
				$("#journeyMobileFilterPopup").modal('hide');
			},100);
			
		});
		
		$('.filter-cta').click(function(){
			$("#journeyMobileFilterPopup").modal('show');
		});
		
		$('#journey_filter_form').submit(function(){
			
			var filter = $('#journey_filter_form');
			
			$.ajax({
				url:filter.attr('action'),
				data:filter.serialize(), // form data
				type:filter.attr('method'), // POST
				beforeSend:function(xhr){
					//filter.find('button').text('Processing...'); // changing the button label
					$('.row.results.waitJourneysResponse').addClass('waitJourneysResponseExtraHeight'); // changing the button label
					$('.waitJourneysResponse').html('<img class="ajax_loader" src="/wp-content/themes/journeys/images/ajax-loader.gif">'); // changing the button label
				},
				success:function(data){
					var splited_date = data.split("==::==");
					if(splited_date[0]==0){
						$('.storiesCount').html(0); // changing the button label
						$('.row.results.waitJourneysResponse').html(splited_date[1]); // insert data
					}else{
						$('.storiesCount').html(splited_date[0]); // changing the button label
						$('.row.results.waitJourneysResponse').removeClass('waitJourneysResponseExtraHeight'); // changing the button label
						$('.row.results.waitJourneysResponse').html(splited_date[1]); // insert data	
						if(parseInt(splited_date[0])==1){
							$(".headingJ").html('Journey');
						}else{
							$(".headingJ").html('Journeys');
						}
					}
					
				}
			});
			return false;
		});
		
		$('#journey_filter_form_mobile').submit(function(){
			
			var filter = $('#journey_filter_form_mobile');
			
			$.ajax({
				url:filter.attr('action'),
				data:filter.serialize(), // form data
				type:filter.attr('method'), // POST
				beforeSend:function(xhr){
					//filter.find('button').text('Processing...'); // changing the button label
					$('.row.results.waitJourneysResponse').addClass('waitJourneysResponseExtraHeight'); // changing the button label
					$('.waitJourneysResponse').html('<img class="ajax_loader" src="/wp-content/themes/journeys/images/ajax-loader.gif">'); // changing the button label
				},
				success:function(data){
					var splited_date = data.split("==::==");
					if(splited_date[0]==0){
						$('.storiesCount').html(0); // changing the button label
						$('.row.results.waitJourneysResponse').html(splited_date[1]); // insert data
					}else{
						$('.storiesCount').html(splited_date[0]); // changing the button label
						$('.row.results.waitJourneysResponse').removeClass('waitJourneysResponseExtraHeight'); // changing the button label
						$('.row.results.waitJourneysResponse').html(splited_date[1]); // insert data	
						if(parseInt(splited_date[0])==1){
							$(".headingJ").html('Journey');
						}else{
							$(".headingJ").html('Journeys');
						}
					}
					
				}
			});
			return false;
		});
		
		/*Journey Type Checkbox Group Start*/
		$('.journey_type_global').click(function(){
            if($(this).prop("checked")) {
                $(".journey_type").prop("checked", true);
            } else {
                $(".journey_type").prop("checked", false);
            }                
        });

		
        $('.journey_type').click(function(){
            if($(".journey_type").length == $(".journey_type:checked").length) {
                $(".journey_type_global").prop("checked", true);
            }else {
                $(".journey_type_global").prop("checked", false);            
            }
        });
		/*Journey Type Checkbox Group End*/
		
		/*Journey Time Checkbox Group Start*/
		$('.journey_time_global').click(function(){
            if($(this).prop("checked")) {
                $(".journey_time").prop("checked", true);
            } else {
                $(".journey_time").prop("checked", false);
            }                
        });

	    $('.journey_time').click(function(){
            if($(".journey_time").length == $(".journey_time:checked").length) {
                $(".journey_time_global").prop("checked", true);
            }else {
                $(".journey_time_global").prop("checked", false);            
            }
        });
		/*Journey Time Checkbox Group Ends*/	
		
		/*Journey Duration Checkbox Group Start*/
		$('.journey_duration_global').click(function(){
            if($(this).prop("checked")) {
                $(".journey_duration").prop("checked", true);
            } else {
                $(".journey_duration").prop("checked", false);
            }                
        });

		$('.journey_duration').click(function(){
            if($(".journey_duration").length == $(".journey_duration:checked").length) {
                $(".journey_duration_global").prop("checked", true);
            }else {
                $(".journey_duration_global").prop("checked", false);            
            }
        });
		/*Journey Duration Checkbox Group Ends*/
		
	});
	
	jQuery( document ).ready( function() {
		jQuery( document )
			.on('click', '#nf-field-16', function() {
				jQuery(this).val('Wait..');
				setTimeout(function(){
					jQuery('html, body').animate({
					  scrollTop: jQuery(".nf-error").offset().top
					}, 1000);
					jQuery('#nf-field-16').val('Submit');	
				},1000);
			
		});
		
		jQuery('.cstm-anchor').click(function(){
			var customa = jQuery(this).attr('data-href');
			window.location.href = customa;
		});
	});
    
	
	jQuery(function() {
			jQuery(".srch_icn, .search_mag form").on("click", function(e) {
			jQuery(".search_mag, .search_mag form").addClass("icon_clicked");
			//jQuery("li.nav-item").hide(500);
			jQuery("li.nav-custom-search").addClass('widthAuto');
			e.stopPropagation()
		  });
		  jQuery(document).on("click", function(e) {
			if (jQuery(e.target).is(".search_mag, .search_mag form") === false) {
				jQuery(".search_mag").removeClass("icon_clicked");
				jQuery("li.nav-custom-search").removeClass('widthAuto');
				
				
				//jQuery("li.nav-item").show(500);
			  //reset input field value
			  jQuery('#suggestiveSearchInput').val("");
			}
		});

	});