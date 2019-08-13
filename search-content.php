<?php /* Template Name: search-results */ ?>
<?php 
function journey_script() {
    wp_register_script('experience-js', get_template_directory_uri() . '/theme/js/experience.js', false, null, null);
    wp_enqueue_script('experience-js');
  }
  add_action( 'wp_enqueue_scripts', 'journey_script', 101 );
get_header(); ?>
<script>
jQuery(document).ready(function() { 

    if ($('.jntab').hasClass('active')) {
        jQuery('#disableMediaAC').css("display","none");
        jQuery('#relatedTagsStoriesWrapperSrp').css("display","none");
        
    }

//beLazy();
jQuery('ul.srpTabs li a').each(function(){
	jQuery(this).click(function () {
		//beLazy();
	});
});

jQuery('ul[data-control-name="categories-filter"] li div span.squaredTwo input[type="checkbox"], ul[data-control-name="categories-filter"] li div span.catSpan').each(function(index){
	jQuery(this).click(function(index) {
		//beLazy();
	});
});

jQuery('div#storiesLoadMoreBtn, div#authorsLoadMoreBtn, div#collectionsLoadMoreBtn ').click(function() {
		//beLazy();
});

	function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};  




  
    var inputSearcPressEnterValue = getUrlParameter('search_term'); 
    
    var inputSearchFacetValue = getUrlParameter('facet');
   
	
	var isSearchFromHome = getUrlParameter('is_from_home');
	
    var inputTagClick = (getUrlParameter('tags') !='' && getUrlParameter('tags') !=null)?true:false;
    if (inputSearchFacetValue != '' && inputSearchFacetValue != null) {
        jQuery(".active").removeClass("active");
        jQuery("." + inputSearchFacetValue).addClass("active");
        jQuery("#" + inputSearchFacetValue).addClass("active");
        if(inputSearchFacetValue=="authors"||inputSearchFacetValue=="collections")
        {
            var facetCurrentTab="#"+inputSearchFacetValue;
                 if(facetCurrentTab=='#stories'){
         if(jQuery(facetCurrentTab).hasClass( "active" ))
        
        {
           jQuery('#disableMediaAC').removeClass('disabledMediaType');
            jQuery('#disableMediaACRes').removeClass('disabledMediaType')
        }

        }

         if(facetCurrentTab=='#authors'||facetCurrentTab=='#collections'){
         if(jQuery(facetCurrentTab).hasClass( "active" ))
        
        {
           jQuery('#disableMediaAC').addClass('disabledMediaType');
            jQuery('#disableMediaACRes').addClass('disabledMediaType')
        }
    }

        }
    }
  


////////////////////////////////////////////////////////////
jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        var currentTab = jQuery(e.target).attr('href'); // get current tab
       
        if(currentTab=="#stories")
        {   jQuery('li.story').addClass("active");

            jQuery('li.collections.jntab').removeClass("active");
            
            var countOfStoriesSrpHideButton=document.getElementById('countOfStoriesSrp').innerText;
            if(jQuery(currentTab).hasClass( "active" )){
            //remove collection and author button
            jQuery('#storiesLoadMoreBtn').show();
            jQuery('#collectionsLoadMoreBtn').hide();
            jQuery('#authorsLoadMoreBtn').hide();
        }
            if(countOfStoriesSrpHideButton<=10){
                jQuery('#storiesLoadMoreBtn').hide();
            }

        }
        if(currentTab=="#collections")
        {    
            jQuery('li.collections.jntab').addClass("active");
            jQuery('li.story').removeClass("active");
            jQuery('#relatedTagsStoriesWrapperSrp').css('display','none');
            var countOfCollectionsSrpHideButton=document.getElementById('countOfCollectionSrp').innerText;
            if(jQuery(currentTab).hasClass( "active" )){
            //remove stories and authors button
            jQuery('#collectionsLoadMoreBtn').show();
            jQuery('#storiesLoadMoreBtn').hide();
            jQuery('#authorsLoadMoreBtn').hide();
        }   
            if(countOfCollectionsSrpHideButton<=10){
                jQuery('#collectionsLoadMoreBtn').hide();
                //console.log('less than 10');
            }

        }
        if(currentTab=="#authors")
        {
            var countOfAuthorsSrpHideButton=document.getElementById('countOfAuthorsSrp').innerText;
            if(jQuery(currentTab).hasClass( "active" )){
            //remove stories and collections button
            jQuery('#authorsLoadMoreBtn').show();
            jQuery('#collectionsLoadMoreBtn').hide();
            jQuery('#storiesLoadMoreBtn').hide();
   
        }     
            if(countOfAuthorsSrpHideButton<=10){
                jQuery('#authorsLoadMoreBtn').hide();
            }


        }

        //ends here
           if(currentTab=='#stories'){
         if(jQuery(currentTab).hasClass( "active" ))
        
        {
          
           jQuery('#disableMediaAC').css("display","block");
           jQuery('#disableMediaACRes').css("display","block");
           jQuery('#disableCatAC').css("display","none");
           jQuery('#disableCatACRes').css("display","none");
		   jQuery('#disableTimeAC').css("display","none");
           jQuery('#disableTimeRes').css("display","none");
           jQuery('#disableDurationAC').css("display","none");
           jQuery('#disableDurationRes').css("display","none");
          
           jQuery('#relatedTagsStoriesWrapperSrp').css("display","block");
		   
		   
        }
    }
        if(currentTab=='#authors'||currentTab=='#collections'){
         if(jQuery(currentTab).hasClass( "active" ))
        
        {
			
	
           // add id for res time filter 
		  
           jQuery('#disableDurationAC').css("display","block");
           jQuery('#disableCatAC').css("display","block");
           jQuery('#disableCatACRes').css("display","block");
            jQuery('#disableTimeAC').css("display","block");
		   jQuery('#disableTimeRes').css("display","block");
		   jQuery('#disableMediaAC').css("display","none");
           jQuery('#disableMediaACRes').css("display","none");
           jQuery('#disableDurationRes').css("display","block");
			// jQuery('#disableCatAC').addClass('disabledMediaType');
            // jQuery('#disableCatACRes').addClass('disabledMediaType');
              jQuery('div.cat-check input[name="MediaFilterSrpDes"]').each(function() 
            {
                
                 if(this.checked==true)
                     {
                        jQuery('div.cat-check input[name="MediaFilterSrpDes"]:checked').trigger('click');
                     }
                    this.checked = false;

            });
			jQuery('div.cat-check input[name="CatFilterSrpDes"]').each(function() 
            {
                
                 if(this.checked==true)
                     {
                        jQuery('div.cat-check input[name="CatFilterSrpDes"]:checked').trigger('click');
                     }
                    this.checked = false;

            });
        }
    }
    });


//jQuery("#cat-check-res").children("input:checked").map(function()  {

jQuery('div#cat-check-res input[name="FilterSrpRes"]').change(function() {
//var filterCheckboxCountSrp=jQuery('div#cat-check-res input[name="FilterSrpRes"]').length;
// console.log(filterCheckboxCountSrp); 
jQuery('div#cat-check-res input[name="FilterSrpRes"]').each(function() 
{   
var filterCheckboxCountSrp=jQuery('div#cat-check-res input[name="FilterSrpRes"]:checked').length;
//console.log(filterCheckboxCountSrp);
if(filterCheckboxCountSrp!=0)
{
document.getElementById('filterCheckBoxCount').innerHTML="<span>&#40;<span>" + filterCheckboxCountSrp + "</span>&#41;</span>";
jQuery('.FilterOuterCon').addClass('filterFontColor');
}
if(filterCheckboxCountSrp==0)
{
document.getElementById('filterCheckBoxCount').innerHTML="";
jQuery('.FilterOuterCon').removeClass('filterFontColor');
}
//'<span>&#40;<span id="filterCheckBoxCount">filterCheckboxCountSrp</span>&#41;</span>';
// });
});
});
/////ends here
////////////////////////////////////////////////////////////
//reset filters
 jQuery("#resetCheckbox").click(function(e) {
     e.preventDefault();
        jQuery('div#cat-check-res input[name="FilterSrpRes"]').each(function() 
    { 
      var filterCheckboxCountSrp=jQuery('div#cat-check-res input[name="FilterSrpRes"]:checked').length;
        //console.log(filterCheckboxCountSrp);
        if(filterCheckboxCountSrp==0)
    {
document.getElementById('filterCheckBoxCount').innerHTML="";
    }
       if(this.checked==true)
       {
        jQuery('div#cat-check-res input[name="FilterSrpRes"]:checked').trigger('click');
       }
        this.checked = false; 
    });
        jQuery('.FilterOuterCon').removeClass('filterFontColor');
    });
jQuery('.searchSuggestiveT').val(inputSearcPressEnterValue);
var initialsearchTermValueSrp = jQuery("#suggestiveSearchInputSrp").val();
var initialsearchTermSrp = (initialsearchTermValueSrp.trim());
if(initialsearchTermSrp=='') {
	initialsearchTermSrp="*"; 
	jQuery('input#suggestiveSearchInputSrp').val('');
}
  if(initialsearchTermSrp!= '' && initialsearchTermSrp != null){

    //load more button code on active tabs
    if(jQuery('#stories').hasClass( "active" )){
             jQuery('#storiesLoadMoreBtn').show();
            jQuery('#collectionsLoadMoreBtn').hide();
            jQuery('#authorsLoadMoreBtn').hide();
        }
        if(jQuery('#collections').hasClass( "active" )){
             jQuery('#storiesLoadMoreBtn').hide();
            jQuery('#collectionsLoadMoreBtn').show();
            jQuery('#authorsLoadMoreBtn').hide();
        }
        if(jQuery('#authors').hasClass( "active" )){
             jQuery('#storiesLoadMoreBtn').hide();
            jQuery('#collectionsLoadMoreBtn').hide();
            jQuery('#authorsLoadMoreBtn').show();
        }
    //ends here

    jQuery(document).ajaxStart(function() {
        //jQuery('.popover-arrow').css('bottom', '-16px');
        jQuery(".progressBarLoad").show();
    }).ajaxStop(function() {
        //jQuery('.popover-arrow').css('bottom', '-16px');
        jQuery(".progressBarLoad").hide();
    });
	
	jQuery(document).ajaxComplete(function(evt){
        ////beLazy();
		//if(jQuery('img.').length > 0) {
				 //if(!jQuery('img.').hasClass('b-loaded')) {
					 ////beLazy();
					 //console.log('ajax completed, //beLazy should be worked out again');
				 //}
		//}
	});
    
}
onReloadAJAX(initialsearchTermSrp, false);
 function onReloadAJAX(initialsearchTermSrp, wereResultsNoFound) {
	if(jQuery('span.search-anno').length > 0) {
						jQuery('span.search-anno').remove();
					} 
	 var timeoutSrp = null;
 var limit_of_records=10;
    clearTimeout(timeoutSrp);
    var tmp_results = [];
     document.getElementById("elasticSearchStoriesResultSrp").style.display = "none";
      document.getElementById("suggeTabsRes").style.display = "none";
  var sessionValue=localStorage.getItem('showAllResults')
        //alert(sessionValue);
		var checkIsFromHome = false;
  if(localStorage.getItem('showAllResults') != null){
       jQuery(document).ajaxStart(function() {
        //jQuery('.popover-arrow').css('bottom', '-16px');
        jQuery(".progressBarLoad").show();
    }).ajaxStop(function() {
        //jQuery('.popover-arrow').css('bottom', '-16px');
        jQuery(".progressBarLoad").hide();
    });
    jQuery(document).ajaxComplete(function(evt){
		//beLazy();
		//if(jQuery('img.').length > 0) {
				 //if(!jQuery('img.').hasClass('b-loaded')) {
					 ////beLazy(true);
					 //console.log('ajax completed, //beLazy should be worked out again');
				 //}
		//}
    });
   //console.log(initialsearchTermSrp); 
   //console.log('from home page');
    initialsearchTermSrp="*"
    localStorage.removeItem('showAllResults');
checkIsFromHome = true;
// Remove all saved data from sessionStorage
    localStorage.clear();
  }

  //code to show no message when coming from pages starts
  if(document.referrer.indexOf('/journeys/search/') == -1) {
	checkIsFromHome = true;
  }
  else {
    checkIsFromHome = false;
  }
  //ends
  if(wereResultsNoFound==true || initialsearchTermSrp=='*') {
		initialsearchTermSrp = '*';
		jQuery('input#suggestiveSearchInputSrp').val('');
	}
    if(initialsearchTermSrp!= '' && initialsearchTermSrp != null)
   {
   // jQuery( "#suggestiveSearchInputSrp" ).focus();

   timeoutSrp = setTimeout(function() {
            jQuery.ajax({
                dataType: 'json',
                url: ajaxurl,
                type: "POST",
                data: {
                    "action": "suggestive_search_ajax_results",
                    's': initialsearchTermSrp,
                    'tag_req': inputTagClick,
                },
                success: function(response) { 
                    jQuery('#stories').empty();
                    jQuery('#journeys').empty();
                    jQuery('#authors').empty();
                    jQuery('#collections').empty();
                    jQuery('#storiesLoadMoreBtn').empty();
                    jQuery('#collectionsLoadMoreBtn').empty();
                    jQuery('#authorsLoadMoreBtn').empty();
                    jQuery('#relatedTagsStoriesSrp').empty();
                    jQuery('#relatedTagsStoriesResponsiveSrp').empty();
                    jQuery('div#elasticSearchStoriesResultSrp').jplist({command: 'empty' });
                    tmp_results['complete_results'] = response;
                    var matchedTitleArray = [];
                    var matchedTagsArray = [];
                    var matchedAuthorArray = [];
                    var matchedContentArray = [];
                   
					
					if(jQuery('span.search-anno').length > 0) {
						jQuery('span.search-anno').remove();
					}
					
					var totalNoOfSearchResultsFound='';
                    totalNoOfSearchResultsFound = response.complete_results.stories.length+response.complete_results.collection.length;
                    //search-anno read_count
            
					if(totalNoOfSearchResultsFound>1) {
						
						if(initialsearchTermSrp!='*'){
							jQuery('<span class="search-anno read_count">'+totalNoOfSearchResultsFound+' Results for "'+initialsearchTermSrp+'"</span>').insertAfter('input#suggestiveSearchInputSrp');
						}
						else {
							if(checkIsFromHome!=true || wereResultsNoFound==true) {
								jQuery('<span class="search-anno read_count">No result for your search, showing all recent results instead</span>').insertAfter('input#suggestiveSearchInputSrp');
							}
							else {
								//do not show annotation
								checkIsFromHome = false;
							}
						}
					
					}

                    else if (totalNoOfSearchResultsFound == 1) {

                        if(initialsearchTermSrp!='*'){
                            jQuery('<span class="search-anno read_count">'+totalNoOfSearchResultsFound+' Result for "'+initialsearchTermSrp+'"</span>').insertAfter('input#suggestiveSearchInputSrp');
                        }
                        else {
                            if(checkIsFromHome!=true || wereResultsNoFound==true) {
                                jQuery('<span class="search-anno read_count">No result for your search, showing all recent results instead</span>').insertAfter('input#suggestiveSearchInputSrp');
                            }
                            else {
                                //do not show annotation
                                checkIsFromHome = false;
                            }
                        }
                    }

 					else {
						jQuery('<span found="not found" class="search-anno">No result for your search, showing all results (reverse chronologically) instead</span>').insertAfter('input#suggestiveSearchInputSrp');
						onReloadAJAX(initialsearchTermSrp, true);
					}

                   
                    var relatedTagsStoriesSrp = '';
                   
                    var resultCountSrp = response.complete_results.all_results.matched_title.length +
                        response.complete_results.all_results.matched_content.length +
                        response.complete_results.all_results.matched_tags.length;
                    var isStoriesPresentSrp = response.complete_results.stories.length;
                   // var isJourneysPresentSrp = response.complete_results.journeys.length;
                    var isCollectionPresentSrp = response.complete_results.collection.length;
                    var storiesTagCountSrp = response.complete_results.related_tags.length;
                    var relatedAuthorsCountSrp = response.complete_results.authors.length;
                    document.getElementById('countOfStoriesSrp').innerText=isStoriesPresentSrp;
                    //document.getElementById('countOfJourneysSrp').innerText = isJourneysPresentSrp;
                    document.getElementById('countOfCollectionSrp').innerText=isCollectionPresentSrp;
                    document.getElementById('countOfAuthorsSrp').innerText=relatedAuthorsCountSrp;
                    // //var isAuthorPresent=response.complete_results.authors.length;
                    // // console.log(isStoriesPresent);
                    // // console.log(isCollectionPresent);
                    // // console.log(resultCount);
                    // Fetching Stories Result Starts Here
                  //  var journeysArticleImageSrp = '';
                   /* if (isJourneysPresentSrp > 0) {
                        for (countJourneysSrp = 0; countJourneysSrp < isJourneysPresentSrp; countJourneysSrp++) {
                            var jounryes_title = response.complete_results.journeys[countJourneysSrp]['jounryes_title'];

                            var jounryes_link = response.complete_results.journeys[countJourneysSrp]['jounryes_link'];
                            var jounryes_image = response.complete_results.journeys[countJourneysSrp]['jounryes_image'];
                            var jounryes_description = response.complete_results.journeys[countJourneysSrp]['jounryes_description'];
                            var jounryes_city = response.complete_results.journeys[countJourneysSrp]['jounryes_city'];
                            var jounryes_experience_name = response.complete_results.journeys[countJourneysSrp]['jounryes_experience_name'];
                            var jounryes_duration = response.complete_results.journeys[countJourneysSrp]['jounryes_duration'];
                            journeysArticleImageSrp += '<div data-control-storage="false" data-storyparentcategory="'+jounryes_experience_name+'" data-mediastorytype="post" class="list-item '+ jounryes_experience_name + ' post col-xs-12 col-sm-12 col-md-12 article-search paddingLeftRight0 journeysloadMore"><div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 articleSearch-img paddingleft0 paddingRight0"> <img class="" data-src="" src="' + jounryes_image + '"> </div> <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 articleSearch-content"><h5><a class="card_article_heading" href="'+ jounryes_link+'">'+jounryes_title+'</a></h5><div class="artistName"> <a href="http://127.0.0.1/journeys/author/?authorname=vagrant" class="botName image_caption copper">vagrant</a></div><p class="image_caption black--" >'+jounryes_description+'</p> </div> </div>';
                        }
                    }*/
                    //console.log(journeysArticleImageSrp);
                   // jQuery('#journeys').append(journeysArticleImageSrp);
                    if (isStoriesPresentSrp > 0) {
                        for (countStorySrp = 0; countStorySrp < isStoriesPresentSrp; countStorySrp++) {
                            var storiesResultSrp = '';
                            var storiesAuthorSrp = '';
                            var storiesArticleImageSrp='';
                            var storiesResultCardExcerpt='';
                            var storiesTimeRead='';
                            var articleCardTextByMediaTypeSrp='';
                            var parentCategoryStoriesSrp = response.complete_results.stories[countStorySrp].post_cats['parent_cat_slug'];
							
                            var mediaTypeStoriesSrp = response.complete_results.stories[countStorySrp].type;
                            var storiesArticlePermalinkSrp = response.complete_results.stories[countStorySrp].permalink;
                            var storiesAuthorPermalinkSrp = response.complete_results.stories[countStorySrp].author_profile_link;
                            var storiesArticleImagesLinkSrp = response.complete_results.stories[countStorySrp].card_thumbnail_src;
                                
                            //added to handle cloudinary URL intel params starts
                            storiesArticleImagesLinkSrp = getCloudinaryURLWithARParams(storiesArticleImagesLinkSrp.indexOf('cloudinary.com'), storiesArticleImagesLinkSrp, false, true);
                            //added to handle cloudinary URL intel params ends
                            
                            
                           
                            if(mediaTypeStoriesSrp=='photostory')
                            {

                                var photoCountSingularCheckSrp = '';

                                photoCountSingularCheckSrp = response.complete_results.stories[countStorySrp].count_on_card['photo_count'];

                                if(photoCountSingularCheckSrp == 1)
                                {
                                    articleCardTextByMediaTypeSrp+='<span class="iconTime-read"><img src="<?php echo $site_url; ?>/wp-content/themes/emagazine/images/icon_photostories_01.svg" /> </span><span class="min-read">' + response.complete_results.stories[countStorySrp].count_on_card['photo_count'] +' Photo</span>';
                                }

                                 if(photoCountSingularCheckSrp == 0 || photoCountSingularCheckSrp > 1)
                                {

                                //articleCardTextByMediaTypeSrp+='<span class="iconTime-read"><img src="<?php echo $site_url; ?>/wp-content/themes/emagazine/images/icon_photostories_01.svg" /> </span><span class="min-read">' + response.complete_results.stories[countStorySrp].count_on_card['photo_count'] +' Photos</span>';
                                articleCardTextByMediaTypeSrp+='';
                                }

                            }
                            if(mediaTypeStoriesSrp=='videostory')
                            { 
                                
                                //articleCardTextByMediaTypeSrp+='<span class="iconTime-read"><img src="<?php echo $site_url; ?>/wp-content/themes/emagazine/images/icon-searchTime.svg" /> </span>';
                                articleCardTextByMediaTypeSrp+='';

                            }
                            storiesArticleImageSrp +=
                                '<div data-control-storage="false"  data-storyparentcategory="' + parentCategoryStoriesSrp + '" data-mediastorytype="' + mediaTypeStoriesSrp + '" class="list-item '+parentCategoryStoriesSrp+' '+mediaTypeStoriesSrp+' col-xs-12 col-sm-12 col-md-12 article-search paddingLeftRight0 storiesloadMore"><div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 articleSearch-img paddingleft0 paddingRight0"><a href="' + storiesArticlePermalinkSrp + '"><img class="" src="' + storiesArticleImagesLinkSrp + '"></a></div>';
                            storiesResultSrp +=
                                '<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 articleSearch-content"><h5><a class="card_article_heading"  href="' + storiesArticlePermalinkSrp + '"  >' +
                                response.complete_results.stories[countStorySrp].title + '</a></h5>';
                            storiesAuthorSrp += '<div class="artistName"><a href="' + storiesAuthorPermalinkSrp + '" class="botName image_caption copper">' +
                                response.complete_results.stories[countStorySrp].author_name + '</a></div>';
                            storiesResultCardExcerpt+='<p class="image_caption black--">'+response.complete_results.stories[countStorySrp].post_card_excerpt + '</p>';
                            storiesTimeRead+='<div class="iconTimeOuter read_count">'+articleCardTextByMediaTypeSrp+'</div></div>';
                            
                            var fullResultStoriesSrp = storiesArticleImageSrp+storiesResultSrp + storiesAuthorSrp+storiesResultCardExcerpt+storiesTimeRead;
                          
                            jQuery('#stories').append(jQuery(fullResultStoriesSrp));
                            breakWords();
                            
                            document.getElementById("elasticSearchStoriesResultSrp").style.display = "block";
                            document.getElementById("suggeTabsRes").style.display = "block";
                        }
						////beLazy();
                        triggerJPLists('elasticSearchStoriesResultSrp', 'list-stories', 0);
                        jQuery('#storiesLoadMoreBtn').append('<div class="alm-btn-wrap"><button id="storiesLoadMoreBtnNew" class="alm-load-more-btn more srp_stories_load_more">Load More</button></div>');

                  if (storiesTagCountSrp != 0 && storiesTagCountSrp != null) {
                            for (storiesTagCounterSrp = 0; storiesTagCounterSrp < storiesTagCountSrp; storiesTagCounterSrp++) {
                                var relatedTagsStories = '';
                                var storiesTagsSrp = response.complete_results.related_tags[storiesTagCounterSrp].tag_name;
                                relatedTagsStories += '<a href="/journeys/search/?search_term=' + storiesTagsSrp + '&tags=true">' + storiesTagsSrp + '</a>'
                                
                  
                                jQuery('#relatedTagsStoriesSrp').append(jQuery(relatedTagsStories));
                                jQuery('#relatedTagsStoriesResponsiveSrp').append(jQuery(relatedTagsStories));
                                document.getElementById("elasticSearchStoriesResultSrp").style.display = "block";
                                document.getElementById("suggeTabsRes").style.display = "block";
                            }
                        }
                    }
                    // Stories Result Ends Here
                    // //To Show Related Authors
                    if (relatedAuthorsCountSrp != 0 && relatedAuthorsCountSrp != null) {
                        for (relatedAuthorsCounterSrp = 0; relatedAuthorsCounterSrp < relatedAuthorsCountSrp; relatedAuthorsCounterSrp++) {
                            var relatedAuthorsSrp = '';
                            var relatedAuthorsImageSrp = '';
                            var relatedAuthorsCardExcerpt = '';
                            var relatedAuthorsTimeRead = '';
                            var relatedAuthorsCategory = response.complete_results.authors[relatedAuthorsCounterSrp].author_category;
                            var relatedAuthorsImageLinkSrp = response.complete_results.authors[relatedAuthorsCounterSrp].author_profile_pic_src;
                            
                            //added to handle cloudinary URL intel params starts
                            relatedAuthorsImageLinkSrp = getCloudinaryURLWithARParams(relatedAuthorsImageLinkSrp.indexOf('cloudinary.com'), relatedAuthorsImageLinkSrp, true, true);
                            //added to handle cloudinary URL intel params ends
                            
                            
                            var relatedAuthorsPermalinkSrp = response.complete_results.authors[relatedAuthorsCounterSrp].author_profile_link;
                            
                             relatedAuthorsImageSrp +=
                                '<div data-control-storage="false"    class="list-item '+relatedAuthorsCategory+' col-md-12 col-xs-12 col-sm-12 article-search authorCard paddingLeftRight0 authorsloadMore"><div class="col-4 col-xs-4 col-sm-4 col-md-3 col-lg-3 img-authOuter paddingleft0 paddingRight0"><a  href="' + relatedAuthorsPermalinkSrp + '"  ><img class="authorCard-img " src="' + relatedAuthorsImageLinkSrp + '" src="https://res.cloudinary.com/round-glass-magazine/image/upload/c_fill,ar_1:1,g_auto/w_100,q_auto,f_auto/v1509084065/loading_zytd8l.gif"></a></div>';
                           
                            
                            relatedAuthorsSrp +=
                                '<div class="col-8 col-xs-8 col-sm-8 col-md-9 col-lg-9 articleSearch-content"><h5><a class="card_article_heading"  href="' + relatedAuthorsPermalinkSrp + '"  >' +
                                response.complete_results.authors[relatedAuthorsCounterSrp].author_name + '</a></h5>';
                            
                            relatedAuthorsCardExcerpt+='<p class="image_caption black--">'+response.complete_results.authors[relatedAuthorsCounterSrp].author_profile_bio +'</p>';

                            var authorsArticlesSingularCheckSrp ='';
                            authorsArticlesSingularCheckSrp = response.complete_results.authors[relatedAuthorsCounterSrp].articles_count_author ;
                            if(authorsArticlesSingularCheckSrp == 1)
                            {

                                 relatedAuthorsTimeRead += '<div class="iconTimeOuter read_count"><span class="iconAuthors"><img src="<?php echo $site_url; ?>/wp-content/themes/emagazine/images/icon_author_01.svg" /></span></span><span class="min-read">' + response.complete_results.authors[relatedAuthorsCounterSrp].articles_count_author+ ' Article</span></div></div>';
                            }
                            if(authorsArticlesSingularCheckSrp == 0 || authorsArticlesSingularCheckSrp >1)
                            {
                                 relatedAuthorsTimeRead += '<div class="iconTimeOuter read_count"><span class="iconAuthors"><img src="<?php echo $site_url; ?>/wp-content/themes/emagazine/images/icon_author_01.svg" /></span></span><span class="min-read">' + response.complete_results.authors[relatedAuthorsCounterSrp].articles_count_author+ ' Articles</span></div></div>';
                            }
                           
                            var fullResultAuthorsSrp = relatedAuthorsImageSrp + relatedAuthorsSrp+relatedAuthorsCardExcerpt+relatedAuthorsTimeRead;
                            jQuery('#authors').append(jQuery(fullResultAuthorsSrp));
                            breakWords();
                            
                        }
						////beLazy();
                        triggerJPLists('elasticSearchStoriesResultSrp', 'list-authors', 1);
                        jQuery('#authorsLoadMoreBtn').append('<div class="alm-btn-wrap"><button id="authorsLoadMoreBtnNew" class="alm-load-more-btn more srp_authors_load_more">Load More</button></div>');

                    }
                    // //Ends here

                    function breakWords() {
                    jQuery('div.articleSearch-content').find('p').each(function(i) {
                       var iTotalWords = jQuery(this).text().length;
                       var iTotalWordsVal = jQuery(this).text();
                           if(iTotalWords >= 145){
                                jQuery(this).text(iTotalWordsVal.substring(0,145)+"..")        
                                
                            }
                        });
                    }

                    // Fetching Collection Result Starts Here
                    if (isCollectionPresentSrp > 0) {
                      
                        for (countCollectSrp = 0; countCollectSrp < isCollectionPresentSrp; countCollectSrp++) {
                            var collectionResultSrp = '';
                            var collectionAuthorSrp = '';
                            var collectionArticleImageSrp='';
                            var collectionResultCardExcerpt='';
                            var collectionTimeRead='';
                            var parentCategoryCollectionSrp = response.complete_results.collection[countCollectSrp].post_cats['parent_cat_slug'];
                            var mediaTypeCollectionSrp = response.complete_results.collection[countCollectSrp].type;
                            var collectionArticlePermalinkSrp = response.complete_results.collection[countCollectSrp].permalink;
                            var collectionAuthorPermalinkSrp = response.complete_results.collection[countCollectSrp].author_profile_link;
                            var collectionArticleImagesLinkSrp = response.complete_results.collection[countCollectSrp].card_thumbnail_src;
							
							
							
							 var collectionCity =  response.complete_results.collection[countCollectSrp].collection_city;
							 var collectionDesc =  response.complete_results.collection[countCollectSrp].collection_desc;
							 var collectionDay =  response.complete_results.collection[countCollectSrp].collection_day;
							 var collectionNight =  response.complete_results.collection[countCollectSrp].collection_night;
							 var collectionSdate =  response.complete_results.collection[countCollectSrp].collection_s_date;
							 var colletionEdate=  response.complete_results.collection[countCollectSrp].colletion_e_date;
							 var collectionEx= response.complete_results.collection[countCollectSrp].collection_e_x;
							 var collectionImage =response.complete_results.collection[countCollectSrp].collection_image;
							 var purl =response.complete_results.collection[countCollectSrp].purl;
                             var jt= response.complete_results.collection[countCollectSrp].title;
							 var dclass =response.complete_results.collection[countCollectSrp].collectionDayClass;
							 var concatmonthstr=collectionSdate+colletionEdate.trim();
							 
							 var concatmonth = concatmonthstr.replace(/ /g, '');
							 
							 //added to handle cloudinary URL intel params starts
                            collectionArticleImagesLinkSrp = getCloudinaryURLWithARParams(collectionArticleImagesLinkSrp.indexOf('cloudinary.com'), collectionArticleImagesLinkSrp, false, true);
                            //added to handle cloudinary URL intel params ends
                            
                            collectionArticleImageSrp +=
                                '<div data-control-storage="false"   data-collectionparentcategory="' + parentCategoryCollectionSrp + '" data-mediacollectiontype="' + mediaTypeCollectionSrp + '" class="list-item '+collectionEx+' '+concatmonth+' '+mediaTypeCollectionSrp+' '+dclass+' col-xs-12 col-sm-12 col-md-12 col-lg-12 article-search paddingLeftRight0 collectionsloadMore"><div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 articleSearch-img paddingleft0 paddingRight0"><a href="' + collectionArticlePermalinkSrp + '"><img class=""  src="'+collectionImage+'"></a></div>';
                            collectionResultSrp +=
                                '<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 articleSearch-content"><div style="text-transform:uppercase" class="sub-header"><a class="tdec" href="journeys/experience/'+collectionEx+'">'+collectionEx+'</a></div><h5><a class="card_article_heading"  href="' + collectionArticlePermalinkSrp + '"  >' +
                                response.complete_results.collection[countCollectSrp].title + '</a></h5>';
                            //collectionAuthorSrp += '<div class="artistName">' +
                             //  response.complete_results.collection[countCollectSrp].author_name + '</div>';
                            //console.log('collection author');
                            //console.log(collectionAuthorSrp);
                            collectionResultCardExcerpt+='<p class="light swiper-slide-exp-mobile">'+collectionDesc+'</p><div class="location swiper-slide-exp-mobile"><span class="map">'+collectionCity+'</span><span class="day">'+collectionNight+' Nights '+collectionDay+' Days</span><a href="" data-toggle="modal" data-target="#myBook" data-image='+purl+' data-title="'+jt+'" data-city="'+collectionCity+'" class="bkform float-right url">+ BOOK</a></div>';

                             var collectionsArticlesSingularCheckSrp ='';
                             collectionsArticlesSingularCheckSrp = response.complete_results.collection[countCollectSrp].count_on_card['collection_articles_count'];
                             if(collectionsArticlesSingularCheckSrp == 1)
                            {
                                 collectionTimeRead+='<div class="iconTimeOuter read_count"><span class="iconColletion"><img src="<?php echo $site_url; ?>/wp-content/themes/emagazine/images/icon_collection_01.png" /></span><span class="min-read">'+response.complete_results.collection[countCollectSrp].count_on_card['collection_articles_count'] +' Article</span></div></div>';

                            }
                            if(collectionsArticlesSingularCheckSrp == 0 || collectionsArticlesSingularCheckSrp > 1)
                            { 
                                 collectionTimeRead+='<div class="iconTimeOuter read_count"><span class="iconColletion"><img src="<?php echo $site_url; ?>/wp-content/themes/emagazine/images/icon_collection_01.png" /></span><span class="min-read">'+response.complete_results.collection[countCollectSrp].count_on_card['collection_articles_count'] +' Articles</span></div></div>';
                            }


                            // // console.log('tag count');
                            // // console.log(storiesTagCount);
                            // // console.log('tag count');
                            var fullResultCollectionSrp = collectionArticleImageSrp+collectionResultSrp + collectionAuthorSrp+collectionResultCardExcerpt+collectionTimeRead;
                           
                            jQuery('#collections').append(fullResultCollectionSrp);
                            breakWords();
                            // jQuery( ".suggestiveHeaderStoriesWrapper" ).show();
                            document.getElementById("elasticSearchStoriesResultSrp").style.display = "block";
                            document.getElementById("suggeTabsRes").style.display = "block";

                        }
						////beLazy();
                        triggerJPLists('elasticSearchStoriesResultSrp', 'list-collections', 2);
                        jQuery('#collectionsLoadMoreBtn').append('<div class="alm-btn-wrap"><button id="collectionsLoadMoreBtnNew" class="alm-load-more-btn more srp_collections_load_more">Load More</button></div>');

                    }
     
                   
                },
                error: function() {},
            })
        }, 500);

    }
   if(initialsearchTermSrp=="")
   {
    document.getElementById("elasticSearchStoriesResultSrp").style.display = "none";
    document.getElementById("suggeTabsRes").style.display = "none";
    jQuery('#stories').empty();
    jQuery('#collection').empty();
    jQuery('#authors').empty();
    jQuery('#relatedTagsStoriesSrp').empty();
    jQuery('#relatedTagsStoriesResponsiveSrp').empty();
   }
	 
 }
   //to handle ajax when user comes through more button or enter click ends here
}); 


//code to make the search filter checkbox label clickable
jQuery('ul.jplist-group span.catSpan').each(function(index) { 
	jQuery(this).click(function(){
		jQuery(this).prev('span.squaredTwo').children('input[type="checkbox"]').trigger('click');
	}); 
});

function triggerJPLists(overAllContainerID, itemsBoxClass, callCount) {
    jQuery('#'+overAllContainerID).jplist({             
        itemsBox: '.'+itemsBoxClass,
        itemPath: '.list-item',
        panelPath: '.jplist-panel'  
        ,redrawCallback: function(collection, $dataview, statuses){
            
                //this code occurs on every jplist action
                if(callCount==0) {
                    //alert('hjghjfkjaf');
                        document.getElementById('countOfStoriesSrp').innerText = collection.dataview.length;
                        if(jQuery('span#countOfStoriesSrp').length > 0){
                            var myLengthStories = jQuery('span#countOfStoriesSrp').text(); 
                            jQuery('div#stories div.list-item').hide();
                            for (var i=0; i<$dataview.length; i++) {
                            jQuery($dataview[i]).show();
							//beLazy();
                    }
                    
                }
                        }
                        if(callCount==1) {
                        document.getElementById('countOfAuthorsSrp').innerText = collection.dataview.length;
                        if(jQuery('span#countOfAuthorsSrp').length > 0){
                    var myLengthAuthors = jQuery('span#countOfAuthorsSrp').text(); 
                    jQuery('div#authors div.list-item').hide();
                    for (var i=0; i<$dataview.length; i++) {
                        jQuery($dataview[i]).show();
						//beLazy();
                    }
                }
                        }
                        if(callCount==2){
                        document.getElementById('countOfCollectionSrp').innerText = collection.dataview.length;
                        if(jQuery('span#countOfCollectionSrp').length > 0){
                    var myLengthCollections = jQuery('span#countOfCollectionSrp').text(); 
                    jQuery('div#collections div.list-item').hide();
                    for (var i=0; i<$dataview.length; i++) {
                        jQuery($dataview[i]).show();
						//beLazy();
                    }
                }
                        }
                     }
               });  
}





//code for load more on scroll
        jQuery.fn.isInViewport = function() {
          var elementTop = jQuery(this).offset().top;
          var elementBottom = elementTop + jQuery(this).outerHeight();

          var viewportTop = jQuery(window).scrollTop();
          var viewportBottom = viewportTop + jQuery(window).height();

          return elementBottom > viewportTop && elementTop < viewportBottom;
        };
        var timer;
        jQuery(window).on('resize scroll', function() {
             if(timer) {
        window.clearTimeout(timer);
     }

        timer = window.setTimeout(function() {   if(jQuery('button#storiesLoadMoreBtnNew').is(":visible"))
         {
            
            if (jQuery('button#storiesLoadMoreBtnNew').isInViewport()) {
              jQuery('button#storiesLoadMoreBtnNew').trigger('click');
              
            } 
        }

        if(jQuery('button#authorsLoadMoreBtnNew').is(":visible"))
        {
             

            if (jQuery('button#authorsLoadMoreBtnNew').isInViewport()) {
              jQuery('button#authorsLoadMoreBtnNew').trigger('click');
              
            }
        }

            if(jQuery('button#collectionsLoadMoreBtnNew').is(":visible"))
            {
                
            if (jQuery('button#collectionsLoadMoreBtnNew').isInViewport()) {
              jQuery('button#collectionsLoadMoreBtnNew').trigger('click');
             
            }
        }
             }, 500);
        
        });

     
//Load More for Search Result Page Ends Here
///////////////////////////////////////////////////

</script>

    <div class="container searchWrap">
        <div class="row rowinner">
        <div class="suggeTabs nav-down col-sm-12 col-xs-12 hidden-md hidden-lg paddingLeftRight0" id="suggeTabsRes">
            <ul>
                <li class="col-6 col-sm-6 col-xs-6"><a class="col-sm-12 col-xs-12 FilterOuterCon"  data-toggle="modal" data-target="#Fiters-search" href="">Filters<span id="filterCheckBoxCount"></span></a></li>
                <li class="col-6 col-sm-6 col-xs-6"><a class="col-sm-12 col-xs-12" data-toggle="modal" data-target="#Related-search" href="">Related Tags</a></li>
            </ul>
        </div>

        
        <div class="col-md-12 searchSuggestive greyish_brown- paddingLeftRight0">
            <form class="form-group" autocomplete="off">
                <input type="hidden" name="ac_option_selected" id="ac_option_selected" value="">
                <input type="search" name="search" id="suggestiveSearchInputSrp" style="padding-left:0px" class="searchSuggestiveT search_heading" placeholder="Search">
                <input type="" name="" value="" class="inputNotexist">
                <div class="autoCompleteSrpSuggestion"></div><div class="suggesDesk"></div>
            </form>           
        </div>
        <div class="clear-fix"></div>

        <div id="elasticSearchStoriesResultSrp" class="jplist">
        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-8 paddingleft0 resrightPadding">
              <!-- Nav tabs -->
                <div class="card">
                    <ul class="nav nav-tabs srpTabs" role="tablist">
                    <!--<li role="presentation" class="active journey"><a class="breadcrumb copper" href="#journeys" aria-controls="Journeys" role="tab" data-toggle="tab"><span id="countOfJourneysSrp"></span> <span id="checkForStoriesPlural">Journeys</span></a></li>-->
					 <li role="presentation" class="active collections jntab"><a class="breadcrumb copper" href="#collections" aria-controls="collections" role="tab"  data-toggle="tab"><span id="countOfCollectionSrp"></span> <span id="checkForCollectionsPlural">Journeys</span></a></li>
                        <li role="presentation" class="story"><a class="breadcrumb copper" href="#stories" aria-controls="Stories" role="tab" data-toggle="tab"><span id="countOfStoriesSrp"></span> <span id="checkForStoriesPlural">Stories</span></a></li>
                        <li style="display:none !important;" role="presentation" class="authors"><a class="breadcrumb copper" href="#authors" aria-controls="authors" role="tab" data-toggle="tab"><span id="countOfAuthorsSrp"></span> <span id="checkForAuthorsPlural">AUTHORS</span></a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                    <!--<div role="tabpanel" class="tab-pane active list-journeys" id="journeys">
                    </div>
                        <div id="journeysLoadMoreBtn"></div> -->
						<!--Collections Content-->
                        <div role="tabpanel" class="tab-pane active list-collections" id="collections">
                            
                        </div>
                        <div id="collectionsLoadMoreBtn"></div>	
                        <div role="tabpanel" class="tab-pane list-stories" id="stories">
                            
                        </div>
                        <div id="storiesLoadMoreBtn"></div>
                        

                        <!-- <p class="totop"> 
                            <a href="#top">Back to top</a> 
                        </p> -->

                        

                         <!--Authors Content-->
                        <div role="tabpanel" class="tab-pane list-authors" id="authors">
                          </div>
                               <div id="authorsLoadMoreBtn"></div> 
                            </div>
                        </div>              
        </div>
        <div class="col-12 col-md-3 col-lg-3 col-xl-3 offset-lg-1 offset-xs-0 offset-sm-0 offset-md-0 offset-col-0 d-none d-xl-block">
            <div class="cat-check jplist-panel">
                <span id="filters" class="breadcrumb copper">Filters</span>
				<div class="" id="disableCatAC">
					<span class="button_cta copper span_mar">Experiences</span>
					<ul class="jplist-group"
							   data-control-type="checkbox-group-filter"
							   data-control-action="filter"
							   data-control-name="categories-filter">
					<!--<li>
					<div class="checkbox-custom image_caption black--">
						<span class="squaredTwo">
						 <input name="samsaraFilterSrp" data-path=".samsara"  id="samsara" type="checkbox" value="samsara" class="filter-srp" /> 
						<label for="samsara"></label></span>
						<span class="catSpan">Samsara</span>
					</div>
					</li>-->
					<li>
					<div class="checkbox-custom image_caption black--">
						<span class="squaredTwo">
						 <input name="CatFilterSrpDes" data-path=".mind"  id="mind" type="checkbox" value="mind" class="filter-srp" /> 
						<label for="mind"></label></span>
						<span class="catSpan">Mind</span>
					</div>
					</li>
					<li>
					<div class="checkbox-custom image_caption black--">
						<span class="squaredTwo">
						 <input name="CatFilterSrpDes" data-path=".body"  id="body" type="checkbox" value="body" class="filter-srp" /> 
						<label for="body"></label></span>
						<span class="catSpan">Body</span>
					</div>
					</li>
					<li>
					<div class="checkbox-custom image_caption black--">
						<span class="squaredTwo">
						 <input name="CatFilterSrpDes" data-path=".soul"  id="soul" type="checkbox" value="soul" class="filter-srp" /> 
						<label for="soul"></label></span>
						<span class="catSpan">Soul</span>
					</div>
					</li>
					
					
					</ul>
				</div>
                <div class="" id="disableTimeAC">
					<span class="button_cta copper span_mar">Time</span>
					<ul class="jplist-group" data-control-type="checkbox-group-filter" data-control-action="filter" data-control-name="time-filter">
					
					<li>
					<div class="checkbox-custom image_caption black--">
						<span class="squaredTwo">
						 <input name="CatFilterSrpDes" data-path=".JanuaryMarch" id="JanuaryMarch" type="checkbox" value="JanuaryMarch" class="filter-srp"> 
						<label for="JanuaryMarch"></label></span>
						<span class="catSpan">Jan to March</span>
					</div>
					</li>
					<li>
					<div class="checkbox-custom image_caption black--">
						<span class="squaredTwo">
						 <input name="CatFilterSrpDes" data-path=".AprilJune" id="AprilJune" type="checkbox" value="AprilJune" class="filter-srp"> 
						<label for="AprilJune"></label></span>
						<span class="catSpan">April to June</span>
					</div>
					</li>
					<li>
					<div class="checkbox-custom image_caption black--">
						<span class="squaredTwo">
						 <input name="CatFilterSrpDes" data-path=".JulySeptember" id="JulySeptember" type="checkbox" value="JulySeptember" class="filter-srp"> 
						<label for="JulySeptember"></label></span>
						<span class="catSpan">July to September</span>
					</div>
					</li>
					<li>
					<div class="checkbox-custom image_caption black--">
						<span class="squaredTwo">
						 <input name="CatFilterSrpDes" data-path=".OctoberDecember" id="OctoberDecember" type="checkbox" value="OctoberDecember" class="filter-srp"> 
						<label for="OctoberDecember"></label></span>
						<span class="catSpan">October to December</span>
					</div>
					</li>
					
					
					</ul>
                </div>

                <div class="" id="disableDurationAC">
					<span class="button_cta copper span_mar">Duration</span>
					<ul class="jplist-group" data-control-type="checkbox-group-filter" data-control-action="filter" data-control-name="duration-filter">
					
					<li>
					<div class="checkbox-custom image_caption black--">
						<span class="squaredTwo">
						 <input name="CatFilterSrpDes" data-path=".45days" id="45days" type="checkbox" value="45days" class="filter-srp"> 
						<label for="45days"></label></span>
						<span class="catSpan">4 - 5 Days</span>
					</div>
					</li>
					<li>
					<div class="checkbox-custom image_caption black--">
						<span class="squaredTwo">
						 <input name="CatFilterSrpDes" data-path=".67days" id="67days" type="checkbox" value="6-7days" class="filter-srp"> 
						<label for="67days"></label></span>
						<span class="catSpan">6 - 7 Days</span>
					</div>
					</li>
					<li>
					<div class="checkbox-custom image_caption black--">
						<span class="squaredTwo">
						 <input name="CatFilterSrpDes" data-path=".8days" id="8days" type="checkbox" value="8days" class="filter-srp"> 
						<label for="8days"></label></span>
						<span class="catSpan">8+ Days</span>
					</div>
					</li>
					</ul>
				</div>
                <div class="" id="disableMediaAC">
                <span class="button_cta copper span_mar">Media Type</span>
                <ul class="jplist-group"
                           data-control-type="checkbox-group-filter"
                           data-control-action="filter"
                           data-control-name="media-filter">
                <li>
                <div class="checkbox-custom image_caption black--">
                    <span class="squaredTwo">
                    <input name="MediaFilterSrpDes" data-path=".post" id="post" type="checkbox" value="post" class="filter-srp storiesHiddenReset"/>
                    <label for="post"></label></span>
                    <span class="catSpan">Stories</span>
                </div>
                </li>
                <li>
                <div class="checkbox-custom image_caption black--">
                    <span class="squaredTwo">
                    <input name="MediaFilterSrpDes" data-path=".photostory" id="photostory" type="checkbox" value="photostory" class="filter-srp photoStoryHiddenReset"/> 
                    <label for="photostory"></label></span>
                    <span class="catSpan">Photo Stories</span>
                </div>
                </li>
                <li>
                <div class="checkbox-custom image_caption black--">
                    <span class="squaredTwo">
                    <input name="MediaFilterSrpDes" data-path=".videostory"  id="videos" type="checkbox" value="videostory" class="filter-srp  videosHiddenReset"/>
                    <label for="videos"></label></span>
                    <span class="catSpan">Videos</span>
                </div>
                </li>
                </ul>
                </div>
                <div class="catLinks01" id="relatedTagsStoriesWrapperSrp">
                    <span class="related-marginTtop breadcrumb copper" id="relatedTags">Related Tags</span>
                    <!-- Related Tags through Ajax-->
                    <div id="relatedTagsStoriesSrp" class="mobilecategory_label">
<!--                <a href="#">Riccha Paul</a>
                    <a href="#">Wildlife</a>
                    <a href="#">Travel</a>
                    <a href="#">Environment</a>
                    <a href="#">Life</a>
                    <a href="#">Climate</a> -->
                </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="Related-search" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title">Related Tags</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"></span>
                </button>
              </div>
              <div class="modal-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="catLinks01" id="relatedTagsStoriesResponsiveSrp">
                       
                    </div>
                </div>
              </div>
              <div class="modal-footer"></div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="Fiters-search" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title">Filter</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"></span>
                </button>
              </div>
              <div class="modal-body">   
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="cat-check  jplist-panel" id="cat-check-res">
						<div class="" id="disableCatACRes">
							<span class="span_mar">Experiences</span>
							<ul class="jplist-group"
									   data-control-type="checkbox-group-filter"
									   data-control-action="filter"
									   data-control-name="categories-filter">
							
							<li>
							<div class="checkbox-custom image_caption black--">
								<span class="squaredTwo">
								<input name="FilterSrpRes" data-path=".mind" class="checkboxCommonRes mindFilterRes" id="mindRes" type="checkbox" value="mind" class="filter-srp"/>
								<label for="mindRes"></label></span>
								<span class="catSpan">Mind</span>
							</div>
							</li>
							<li>
							<div class="checkbox-custom image_caption black--">
								<span class="squaredTwo">
								<input name="FilterSrpRes" data-path=".body" class="checkboxCommonRes bodyFilterRes" id="bodyRes" type="checkbox" value="body" class="filter-srp"/>
								<label for="bodyRes"></label></span>
								<span class="catSpan">Body</span>
							</div>
							</li>
							<li>
							<div class="checkbox-custom image_caption black--">
								<span class="squaredTwo">
								<input name="FilterSrpRes" data-path=".soul" class="checkboxCommonRes soulFilterRes" id="soulRes" type="checkbox" value="soul" class="filter-srp"/>
								<label for="soulRes"></label></span>
								<span class="catSpan">Soul</span>
							</div>
							</li>
							
							
							</ul>
						</div>

                        <div class="" id="disableTimeRes">
                        <span class="button_cta copper span_mar">Time</span>
					    <ul class="jplist-group" data-control-type="checkbox-group-filter" data-control-action="filter" data-control-name="time-filter">    
							
							<li>
							<div class="checkbox-custom image_caption black--">
								<span class="squaredTwo">
								<input name="FilterSrpRes" data-path=".JanuaryMarch" class="checkboxCommonRes JanuaryMarchRes" id="JanuaryMarchRes" type="checkbox" value="JanuaryMarch" />
								<label for="JanuaryMarch"></label></span>
								<span class="catSpan">Jan to March</span>
							</div>
							</li>
							<li>
							<div class="checkbox-custom image_caption black--">
								<span class="squaredTwo">
								<input name="FilterSrpRes" data-path=".AprilJune" class="checkboxCommonRes AprilJuneFilterRes" id="AprilJuneRes" type="checkbox" value="AprilJune"/>
								<label for="AprilJune"></label></span>
								<span class="catSpan">April to June</span>
							</div>
							</li>
							<li>
							<div class="checkbox-custom image_caption black--">
								<span class="squaredTwo">
								<input name="FilterSrpRes" data-path=".JulySeptember" class="checkboxCommonRes JulySeptemberFilterRes" id="JulySeptemberRes" type="checkbox" value="JulySeptember" />
								<label for="JulySeptember"></label></span>
								<span class="catSpan">July to September</span>
							</div>
							</li>


                            <li>
							<div class="checkbox-custom image_caption black--">
								<span class="squaredTwo">
								<input name="FilterSrpRes" data-path=".OctoberDecember" class="checkboxCommonRes OctoberDecemberFilterRes" id="OctoberDecemberRes" type="checkbox" value="OctoberDecember" />
								<label for="OctoberDecember"></label></span>
								<span class="catSpan">October to December</span>
							</div>
							</li>
							
							
							</ul>
                        </div>


                        <div class="" id="disableDurationRes">
                        <span class="span_mar">Duration</span>
					<ul class="jplist-group" data-control-type="checkbox-group-filter" data-control-action="filter" data-control-name="duration-filter">
					
					<li>
					<div class="checkbox-custom image_caption black--">
						<span class="squaredTwo">
						 <input name="FilterSrpRes" id="45daysRes"  data-path=".45days" type="checkbox" value="45days" class="checkboxCommonRes 45daysRes"> 
						<label for="45days"></label></span>
						<span class="catSpan">4 - 5 Days</span>
					</div>
					</li>
					<li>
					<div class="checkbox-custom image_caption black--">
						<span class="squaredTwo">
						 <input name="FilterSrpRes" data-path=".67days" id="67daysRes" type="checkbox" value="6-7days" class="checkboxCommonRes 67daysRes"> 
						<label for="67days"></label></span>
						<span class="catSpan">6 - 7 Days</span>
					</div>
					</li>
					<li>
					<div class="checkbox-custom image_caption black--">
						<span class="squaredTwo">
						 <input name="FilterSrpRes" data-path=".8days" id="8daysRes" type="checkbox" value="8days" class="checkboxCommonRes 8daysRes"> 
						<label for="8days"></label></span>
						<span class="catSpan">8+ Days</span>
					</div>
					</li>
					</ul>
                </div>
                        
                <div class="" id="disableMediaACRes">
                <span class="span_mar">Media Type</span>
                <ul class="jplist-group"
                           data-control-type="checkbox-group-filter"
                           data-control-action="filter"
                           data-control-name="media-filter">
                <li>
                <div class="checkbox-custom image_caption black--">
                    <span class="squaredTwo">
                    <input name="FilterSrpRes" data-path=".post" class="checkboxCommonRes" id="postRes" type="checkbox" value="post" />
                    <label for="postRes"></label></span>
                    <span class="catSpan">Stories</span>
                </div>
                </li>
                <li>
                <div class="checkbox-custom image_caption black--">
                    <span class="squaredTwo">
                    <input name="FilterSrpRes" data-path=".photostory" class="checkboxCommonRes" id="photo-storyRes" type="checkbox" value="photostory"  /> 
                    <label for="photo-storyRes"></label></span>
                    <span class="catSpan">Photo Stories</span>
                </div>
                </li>
                <li>
                <div class="checkbox-custom image_caption black--">
                    <span class="squaredTwo">
                    <input name="FilterSrpRes" data-path=".videostory"  class="checkboxCommonRes" id="videosRes" type="checkbox" value="videostory"/>
                    <label for="videosRes"></label></span>
                    <span class="catSpan">Videos</span>
                </div>
                </li>
                </ul>
                </div>
                </div>
                <div class="filterPopFooter col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="footerBorder"></div>
                    <a href="javascript:void(0)" id="apllyFilterCheckbox">Apply Filter</a>
                    <a href="" id="resetCheckbox">Reset all filters</a>
                </div>
                </div>
              </div>
              <div class="modal-footer"></div>
            </div>
          </div>
        </div>
        </div>
        </div>  
    </div>
    <style>
    .jplist-hidden {
            display: none !important;
        }
        .autoCompleteSrpSuggestion{
            position:relative;  
        }
        ul.autoCompleteRes {
            max-height: 237px;
            overflow: hidden;
            background-color: #FBFBFC;
            position: absolute;
            top: 71px;
            width: 100%;
            
        }
        ul.customAddFrstLstLiCss li:first-child {
                margin-top:10px;
                
        }
        ul.customAddFrstLstLiCss li:last-child{
            margin-bottom: 19px;
        }
        ul.autoCompleteRes li {
            width: 100%;
            font-family: Gibson;
            font-size: 27px;
            font-weight: normal;
            font-style: normal;
            font-stretch: normal;
            line-height: normal;
            letter-spacing: 0.8px;
            text-align: left;
            color: #666666;
            padding: 10px 25px;
            cursor:pointer;
        }
        ul.autoCompleteRes li:hover {
            color:#d44e28;
        }
        
        ul.autoCompleteRes li.selected {
            color:#d44e28;
        }
        @media screen and (max-width: 767px) {
            ul.autoCompleteRes li {
                width: 100%;
                font-family: Gibson;
                font-size: 18px;
                font-weight: normal;
                font-style: normal;
                font-stretch: normal;
                line-height: normal;
                letter-spacing: 0.6px;
                text-align: left;
                color: #666666;
                padding: 10px 25px;
                cursor:pointer;
            }
            
        }
        @media screen and (max-width: 768px) and (min-width:512px) {
            ul.autoCompleteRes {
                top: 71px;
            }
            
        }
        @media only screen and (max-width: 511px){
            div.searchSuggestive .row.autoCompleteSrpSuggestion {
                top: -11px;
            }
        }

        .srp_collections_load_more, .srp_authors_load_more, .srp_stories_load_more{
                padding: 0 1em;
                border-radius: 0;
                color: #4a4e55;
                background-color: #f8f8f8;
                font-family: Gibson;
                font-size: 16px;
                font-weight: 300;
                height: 1.8em;
                border: 1px solid #e3e6e8;
            }   
        div#storiesLoadMoreBtn, div#authorsLoadMoreBtn, div#collectionsLoadMoreBtn {
            display: inline-block;
            width: 100%;
            text-align: center;
        }

        #storiesLoadMoreBtn > div.alm-btn-wrap, #authorsLoadMoreBtn > div.alm-btn-wrap, #collectionsLoadMoreBtn > div.alm-btn-wrap {
            margin-bottom: 1em;
        }
		
		/*hiding auto-complete as of now*/
		ul.autoCompleteRes {
			display: none !important;
		}
    </style> 
<?php get_footer(); ?>

<script src="<?php echo MAIN_DIR; ?>/theme/js/jplist.core.min.js" defer></script>


<script src="<?php echo MAIN_DIR; ?>/theme/js/jplist.filter-toggle-bundle.min.js" defer></script>
<script>
jQuery(function(){
	jQuery("#apllyFilterCheckbox").click(function(){
		jQuery("#Fiters-search").modal('hide');
	});
});
</script>