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
