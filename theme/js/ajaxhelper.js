var ajaxurl = '/journeys/wp-admin/admin-ajax.php';

var limit_of_records = 10;
jQuery(document).ready(function() {
    //binding load to elastic search function
    jQuery("#suggestiveSearchInput").keyup(function(e) {

        jQuery(document).ajaxStart(function() {
            //jQuery('.popover-arrow').css('bottom', '-16px');
            jQuery(".progressBarLoad").show();
        }).ajaxStop(function() {
            //jQuery('.popover-arrow').css('bottom', '-16px');
            //  beLazy();
            jQuery(".progressBarLoad").hide();
        });
        jQuery(document).ajaxComplete(function(evt) {

            //  beLazy();

        });

    });

    jQuery("#suggestiveSearchInputSrp").keyup(function(esrp) {
        //console.log('ajax Srp Start');
        jQuery(document).ajaxStart(function() {
            jQuery(".progressBarLoad").show();
        }).ajaxStop(function() {
            jQuery(".progressBarLoad").hide();
            //console.log('ajax Srp Stop');
        });

        jQuery(document).ajaxComplete(function(evt) {
            //  beLazy();

        });
    });
});


jQuery(function() {

    var timeout = null;
    var siteUrl = window.location.hostname;
    var websiteHost = window.location.protocol;
    jQuery("#suggestiveSearchInput").keyup(function(e) {

        e.preventDefault();
        clearTimeout(timeout);
        var tmp_results = [];
        var siteUrlEnterKey = window.location.hostname;

        var tokenParamm = jQuery("#ac_option_selected").val();

        // console.log(siteUrlEnterKey);
        var searchTermValue = jQuery("#suggestiveSearchInput").val();
        var searchTerm = (searchTermValue.trim());

        /*if(searchTerm=='') {
        	searchTerm="*";
        }*/

        // console.log(searchTerm);
        document.getElementById("elasticSearchKeyword").innerText = "Search for\"" + searchTerm + "\"";
        var suggestiveSearchArrowUrl = '/journeys/search/?search_term=' + searchTerm + '';
        jQuery('a.suggestive-search-arrow').attr('href', suggestiveSearchArrowUrl);

        //enter key is pressed and search value is not blank
        if ((e.which == 13 || e.keyCode == 13) && searchTerm != '') {
            localStorage.removeItem('showAllResults');

            // Remove all saved data from sessionStorage
            localStorage.clear();
            var siteUrlEnterKey = window.location.hostname;
            var location = "/journeys/search/?search_term=" + searchTerm;
            window.location.href = location;
        }
        //enter key is pressed and search value is blank
        if ((e.which == 13 || e.keyCode == 13) && searchTerm == '') {
            localStorage.removeItem('showAllResults');

            // Remove all saved data from sessionStorage
            localStorage.clear();
            var location = "/journeys/search/?search_term=" + searchTerm;
            window.location.href = location;
        }
        if (searchTerm == "") {
            document.getElementById("suggestiveSearchDropDown").style.display = "none";
            jQuery('#elasticSearchStoriesResult').empty();
            jQuery('#elasticSearchCollectionResult').empty();
            jQuery('#relatedTagsElasticSearch').empty();
            jQuery('#elasticSearchAuthorsResult').empty();
        }
        if (searchTerm != '' && searchTerm != null) {
            timeout = setTimeout(function() {
                jQuery.ajax({
                    dataType: 'json',
                    url: ajaxurl,
                    type: "POST",
                    data: {
                        "action": "suggestive_search_ajax_results",
                        's': searchTerm,
                        'suggested_post_id': tokenParamm,
                    },
                    success: function(response) {
                        jQuery('#elasticSearchStoriesResult').empty();
                        jQuery('#elasticSearchCollectionResult').empty();
                        jQuery('#relatedTagsElasticSearch').empty();
                        jQuery('#elasticSearchAuthorsResult').empty();
                        //tmp_results['complete_results'] = JSON.parse(response.replace(/ 0+(?![\. }])/g, ' '));
                        tmp_results['complete_results'] = response;
                        var matchedTitleArray = [];
                        var matchedTagsArray = [];
                        var matchedAuthorArray = [];
                        var matchedContentArray = [];
                        var relatedTagsCollection = '';
                        var resultCount = response.complete_results.all_results.matched_title.length +
                            response.complete_results.all_results.matched_content.length +
                            response.complete_results.all_results.matched_tags.length;
                        var isStoriesPresent = response.complete_results.stories.length;
                        var isCollectionPresent = response.complete_results.collection.length;
                        var storiesTagCount = response.complete_results.related_tags.length;
                        var relatedAuthorsCount = response.complete_results.authors.length;
                        var totlaAuthorsCount = response.complete_results.all_results.matched_author.length;

                        // Fetching Stories Result Starts Here
                        if (isStoriesPresent >= 3) {
                            for (countStory = 0; countStory < 3; countStory++) {
                                var storiesResult = '';
                                var storiesAuthor = '';
                                var storiesArticleImage = '';
                                var storiesShowMorePostType = 'stories';
                                var storiesShowMoreUrl = '/journeys/search/?search_term=' + searchTerm + '&facet=' + storiesShowMorePostType + '';
                                jQuery('a.storiesShowMoreText').attr('href', storiesShowMoreUrl);
                                var storiesArticlePermalink = response.complete_results.stories[countStory].permalink;
                                var storiesAuthorPermalink = response.complete_results.stories[countStory].author_profile_link;
                                var storiesArticleImagesLink = response.complete_results.stories[countStory].card_thumbnail_src;

                                //added to handle cloudinary URL intel params starts
                                storiesArticleImagesLink = getCloudinaryURLWithARParams(storiesArticleImagesLink.indexOf('cloudinary.com'), storiesArticleImagesLink, false, false);
                                //added to handle cloudinary URL intel params ends

                                storiesArticleImage +=
                                    '<li><div class="pull-left sugg-img"><a  href="' + storiesArticlePermalink + '"  ><img class="" src="' + storiesArticleImagesLink + '"></a></div>';
                                storiesResult +=
                                    '<div class="pull-right"><a class="headerSerchImg" href="' + storiesArticlePermalink + '"  >' +
                                    response.complete_results.stories[countStory].title + '</a>';
                                // storiesAuthor += '<a href="' + storiesAuthorPermalink + '" class="botName">' +
                                //  response.complete_results.stories[countStory].author_name + '</a></div></li>';
                                storiesAuthor += '</div></li>';
                                var fullResultStories = storiesArticleImage + storiesResult + storiesAuthor;

                                if (isStoriesPresent <= 3) {
                                    jQuery("#storiesShowMoreHideText").css("display", "none");
                                }
                                // jQuery('#elasticSearchStoriesResult').empty();
                                jQuery('#elasticSearchStoriesResult').append(jQuery(fullResultStories));
                                jQuery(".suggestiveHeaderStoriesWrapper").show();
                                document.getElementById("suggestiveSearchDropDown").style.display = "block";

                            }

                        }

                        if (isStoriesPresent < 3) {
                            for (countStory = 0; countStory < isStoriesPresent; countStory++) {
                                var storiesResult = '';
                                var storiesAuthor = '';
                                var storiesArticleImage = '';
                                var storiesShowMorePostType = 'stories';
                                var storiesShowMoreUrl = '/journeys/search/?search_term=' + searchTerm + '&facet=' + storiesShowMorePostType + '';
                                jQuery('a.storiesShowMoreText').attr('href', storiesShowMoreUrl);
                                var storiesArticlePermalink = response.complete_results.stories[countStory].permalink;
                                var storiesAuthorPermalink = response.complete_results.stories[countStory].author_profile_link;
                                var storiesArticleImagesLink = response.complete_results.stories[countStory].card_thumbnail_src;

                                //added to handle cloudinary URL intel params starts
                                storiesArticleImagesLink = getCloudinaryURLWithARParams(storiesArticleImagesLink.indexOf('cloudinary.com'), storiesArticleImagesLink, false, false);
                                ////added to handle cloudinary URL intel params ends

                                storiesArticleImage +=
                                    '<li><div class="pull-left sugg-img"><a  href="' + storiesArticlePermalink + '"  ><img class="" src="' + storiesArticleImagesLink + '"></a></div>';
                                storiesResult +=
                                    '<div class="pull-right"><a class="headerSerchImg" href="' + storiesArticlePermalink + '"  >' +
                                    response.complete_results.stories[countStory].title + '</a>';
                                storiesAuthor += '<a href="' + storiesAuthorPermalink + '" class="botName">' +
                                    response.complete_results.stories[countStory].author_name + '</a></div></li>';

                                var fullResultStories = storiesArticleImage + storiesResult + storiesAuthor;

                                if (isStoriesPresent <= 3) {
                                    jQuery("#storiesShowMoreHideText").css("display", "none");
                                }
                                // jQuery('#elasticSearchStoriesResult').empty();
                                jQuery('#elasticSearchStoriesResult').append(jQuery(fullResultStories));
                                jQuery(".suggestiveHeaderStoriesWrapper").show();
                                document.getElementById("suggestiveSearchDropDown").style.display = "block";

                            }

                        }

                        if (storiesTagCount != 0 && storiesTagCount != null) {
                            for (storiesTagCounter = 0; storiesTagCounter < storiesTagCount; storiesTagCounter++) {
                                var relatedTagsStories = '';
                                var storiesTags = response.complete_results.related_tags[storiesTagCounter].tag_name;
                                relatedTagsStories += '<a href="/journeys/search/?search_term=' + storiesTags + '&tags=true"  >' + storiesTags + '</a>'


                                jQuery('#relatedTagsElasticSearch').append(jQuery(relatedTagsStories));
                                jQuery(".related-tags").show();
                            }
                        }
                        // Stories Result Ends Here
                        //To Show Related Authors
                        if (relatedAuthorsCount != 0 && relatedAuthorsCount != null) {
                            //console.log('author count');
                            //console.log(relatedAuthorsCount);
                            var authoorsShowMore = 'authors';
                            var authorsShowMoreUrl = '/journeys/search/?search_term=' + searchTerm + '&facet=' + authoorsShowMore + '';
                            jQuery('a.authorShowMoreText').attr('href', authorsShowMoreUrl);
                            if (relatedAuthorsCount >= 3) {

                                for (relatedAuthorsCounter = 0; relatedAuthorsCounter < 3; relatedAuthorsCounter++) {
                                    var relatedAuthors = '';
                                    var relatedAuthorsImage = '';
                                    var relatedAuthorsImageLink = response.complete_results.authors[relatedAuthorsCounter].author_profile_pic_src;


                                    //added to handle cloudinary URL intel params starts
                                    relatedAuthorsImageLink = getCloudinaryURLWithARParams(relatedAuthorsImageLink.indexOf('cloudinary.com'), relatedAuthorsImageLink, true, false);
                                    //added to handle cloudinary URL intel params ends

                                    var relatedAuthorsPermalink = response.complete_results.authors[relatedAuthorsCounter].author_profile_link;
                                    relatedAuthorsImage +=
                                        '<li><div class="pull-left sugg-img"><a  href="' + relatedAuthorsPermalink + '"   class="onimgmar"><img class="onimgauth " src="' + relatedAuthorsImageLink + '"></a></div>';
                                    relatedAuthors +=
                                        '<div class="pull-right"><a class="headerSerchImg" href="' + relatedAuthorsPermalink + '"  >' +
                                        response.complete_results.authors[relatedAuthorsCounter].author_name + '</a></div></li>';
                                    var fullResultAuthors = relatedAuthorsImage + relatedAuthors;
                                    jQuery('#elasticSearchAuthorsResult').append(jQuery(fullResultAuthors));
                                    //unblock to show authors
                                    // jQuery(".suggestiveHeaderAuthorsWrapper").show();
                                    document.getElementById("suggestiveSearchDropDown").style.display = "block";
                                }

                                //to show only top three authors

                            }
                            if (relatedAuthorsCount < 3) {

                                //to show related authors
                                for (relatedAuthorsCounter = 0; relatedAuthorsCounter < relatedAuthorsCount; relatedAuthorsCounter++) {
                                    var relatedAuthors = '';
                                    var relatedAuthorsImage = '';
                                    var relatedAuthorsImageLink = response.complete_results.authors[relatedAuthorsCounter].author_profile_pic_src;


                                    //added to handle cloudinary URL intel params starts
                                    relatedAuthorsImageLink = getCloudinaryURLWithARParams(relatedAuthorsImageLink.indexOf('cloudinary.com'), relatedAuthorsImageLink, true, false);
                                    //added to handle cloudinary URL intel params ends


                                    var relatedAuthorsPermalink = response.complete_results.authors[relatedAuthorsCounter].author_profile_link;
                                    relatedAuthorsImage +=
                                        '<li><div class="pull-left sugg-img"><a  href="' + relatedAuthorsPermalink + '"   class="onimgmar"><img class="onimgauth "  class="" src="' + relatedAuthorsImageLink + '"></a></div>';
                                    relatedAuthors +=
                                        '<div class="pull-right"><a class="headerSerchImg"  href="' + relatedAuthorsPermalink + '"  >' +
                                        response.complete_results.authors[relatedAuthorsCounter].author_name + '</a></div></li>';
                                    var fullResultAuthors = relatedAuthorsImage + relatedAuthors;
                                    jQuery('#elasticSearchAuthorsResult').append(jQuery(fullResultAuthors));
                                    jQuery(".suggestiveHeaderAuthorsWrapper").show();
                                    document.getElementById("suggestiveSearchDropDown").style.display = "block";
                                }

                            }
                            if (relatedAuthorsCount <= 3) {
                                //console.log('yes its less then or equl to three');
                                jQuery("#authorShowMoreHideText").css("display", "none");
                            }
                        }

                        //Ends here
                        // Fetching Collection Result Starts Here
                        if (isCollectionPresent >= 3) {
                            for (countCollect = 0; countCollect < 3; countCollect++) {
                                var collectionResult = '';
                                var collectionAuthor = '';
                                var collectionArticleImage = '';
                                var collectionShowMorePostType = 'collections';
                                var collectionShowMoreUrl = '/journeys/search/?search_term=' + searchTerm + '&facet=' + collectionShowMorePostType + '';
                                jQuery('a.collectionShowMoreText').attr('href', collectionShowMoreUrl);;
                                var collectionArticlePermalink = response.complete_results.collection[countCollect].permalink;
                                var collectionAuthorPermalink = response.complete_results.collection[countCollect].author_profile_link;
                                var collectionArticleImagesLink = response.complete_results.collection[countCollect].collection_image;
                                var collectionArticleImagesCity = response.complete_results.collection[countCollect].collection_city;

                                //added to handle cloudinary URL intel params starts
                                collectionArticleImagesLink = getCloudinaryURLWithARParams(collectionArticleImagesLink.indexOf('cloudinary.com'), collectionArticleImagesLink, false, false);
                                //added to handle cloudinary URL intel params ends

                                collectionArticleImage +=
                                    '<li><div class="pull-left sugg-img"><a  href="' + collectionArticlePermalink + '"  ><img class="" src="' + collectionArticleImagesLink + '" ></a></div>';
                                collectionResult += '<div class="pull-right"><a class="headerSerchImg" href="' + collectionArticlePermalink + '"  >' + response.complete_results.collection[countCollect].title + '</a>';

                                collectionAuthor += '' + collectionArticleImagesCity + '</div></li>';

                                var fullResultCollection = collectionArticleImage + collectionResult + collectionAuthor;
                                if (isCollectionPresent <= 3) {
                                    jQuery("#collectionShowMoreHideText").css("display", "none");
                                }

                                jQuery('#elasticSearchCollectionResult').append(jQuery(fullResultCollection));
                                document.getElementById("suggestiveSearchDropDown").style.display = "block";
                                jQuery(".suggestiveHeaderCollectionWrapper").show();

                            }
                        }
                        if (isCollectionPresent < 3) {
                            for (countCollect = 0; countCollect < isCollectionPresent; countCollect++) {
                                var collectionResult = '';
                                var collectionAuthor = '';
                                var collectionArticleImage = '';
                                var collectionShowMorePostType = 'collections';
                                var collectionShowMoreUrl = '/journeys/search/?search_term=' + searchTerm + '&facet=' + collectionShowMorePostType + '';
                                jQuery('a.collectionShowMoreText').attr('href', collectionShowMoreUrl);;
                                var collectionArticlePermalink = response.complete_results.collection[countCollect].permalink;
                                var collectionAuthorPermalink = response.complete_results.collection[countCollect].author_profile_link;
                                var collectionArticleImagesLink = response.complete_results.collection[countCollect].card_thumbnail_src;

                                //added to handle cloudinary URL intel params starts
                                collectionArticleImagesLink = getCloudinaryURLWithARParams(collectionArticleImagesLink.indexOf('cloudinary.com'), collectionArticleImagesLink, false, false);
                                //added to handle cloudinary URL intel params ends

                                collectionArticleImage +=
                                    '<li><div class="pull-left sugg-img"><a  href="' + collectionArticlePermalink + '"  ><img class=""  src="' + collectionArticleImagesLink + '"></a></div>';
                                collectionResult += '<div class="pull-right"><a class="headerSerchImg" href="' + collectionArticlePermalink + '"  >' + response.complete_results.collection[countCollect].title + '</a>';

                                collectionAuthor += '<a href="' + collectionAuthorPermalink + '"   class="botName">' +
                                    response.complete_results.collection[countCollect].author_name + '</a></div></li>';

                                var fullResultCollection = collectionArticleImage + collectionResult + collectionAuthor;
                                if (isCollectionPresent <= 3) {
                                    jQuery("#collectionShowMoreHideText").css("display", "none");
                                }

                                jQuery('#elasticSearchCollectionResult').append(jQuery(fullResultCollection));
                                document.getElementById("suggestiveSearchDropDown").style.display = "block";
                                jQuery(".suggestiveHeaderCollectionWrapper").show();

                            }
                        }

                        //To handle if Stories Results Are Blank
                        if (isStoriesPresent == 0) {
                            jQuery(".suggestiveHeaderStoriesWrapper").hide();
                            jQuery(".related-tags").hide();

                        }
                        //To handle if Collection Results Are Blank Ends Here
                        if (isCollectionPresent == 0) {
                            jQuery(".suggestiveHeaderCollectionWrapper").hide();
                        }
                        //To handle if Authors Results Are Blank Ends Here
                        if (relatedAuthorsCount == 0) {
                            jQuery(".suggestiveHeaderAuthorsWrapper").hide();
                        }


                        // code for search starts
                        /*var bLazy = new Blazy({
                        	success: function(element){
                        		console.log('test');
                        		setTimeout(function(){
                        		var parent = element.parentNode;
                        		parent.className = parent.className.replace(/\bloading\b/,'');
                        		}, 200);
                        	}
                        });*/

                        // code for search ends
                    },
                    error: function() {},
                })
            }, 500);
        }
    });

});
/**Search Suggestive JS Ends **/


//Js code for responsive input search field for suggestive search
jQuery("#suggestiveSearchInputResponsive").keyup(function(esug) {
    esug.preventDefault();


    var searchTermValueResponsiveSrp = jQuery("#suggestiveSearchInputResponsive").val();
    var searchTermSrpResponsive = (searchTermValueResponsiveSrp.trim());
    // //enter key is pressed and search value is not blank
    if ((esug.which == 13 || esug.keyCode == 13) && searchTermSrpResponsive != '') {
        var siteUrlEnterKey = window.location.hostname;
        var location = "/journeys/search/?search_term=" + searchTermSrpResponsive;
        window.location.href = location;
    }
    // //enter key is pressed and search value is blank
    if ((esug.which == 13 || esug.keyCode == 13) && searchTermSrpResponsive == '') {
        var location = "/journeys/search/?search_term=" + searchTermSrpResponsive;
        window.location.href = location;
    }

});
//Ends here
//////////////////////////////////////////////////////////////////////////////////////
// /**  Search Result Page JS Code Starts **/

var timeoutSrp = null;
jQuery("#suggestiveSearchInputSrp").keyup(function(esrp) {
    esrp.preventDefault();
    if (jQuery('span.search-anno').length > 0) {
        jQuery('span.search-anno').remove();
    }
    onKeyUpAjax(esrp, false);
});

function onKeyUpAjax(esrp, wereNoResultsFound) {
    clearTimeout(timeoutSrp);
    var tmp_results = [];
    // var siteUrlEnterKey=window.location.hostname;
    // // console.log(siteUrlEnterKey);
    var searchTermValueSrp = jQuery("#suggestiveSearchInputSrp").val();
    var tokenParamm = jQuery("#ac_option_selected").val();
    var searchTermSrp = (searchTermValueSrp.trim());
    // //enter key is pressed and search value is not blank

    //	handling to show all when no results were found with the entered keyword
    if (wereNoResultsFound == true) {
        searchTermSrp = '*';
    }

    //console.log(esrp.keyCode);
    if ((esrp.which == 13 || esrp.keyCode == 13) && searchTermSrp != '') {
        var siteUrlEnterKey = window.location.hostname;
        var location = "/journeys/search/?search_term=" + searchTermSrp;
        window.location.href = location;
    }
    // //enter key is pressed and search value is blank
    if ((esrp.which == 13 || esrp.keyCode == 13) && searchTermSrp == '') {
        var location = "/journeys/search/?search_term=" + searchTermSrp;
        window.location.href = location;
    }
    if (searchTermSrp == "") {
        document.getElementById("elasticSearchStoriesResultSrp").style.display = "none";
        document.getElementById("suggeTabsRes").style.display = "none";
        jQuery('#stories').empty();
        jQuery('#collection').empty();
        jQuery('#authors').empty();
        jQuery('#relatedTagsStoriesSrp').empty();
        jQuery('#relatedTagsStoriesResponsiveSrp').empty();

    }
    //Block search when user enter up and down key
    if (searchTermSrp != '' && searchTermSrp != null && esrp.keyCode != 40 && esrp.keyCode != 38) {


        //load more button code on active tabs
        if (jQuery('#stories').hasClass("active")) {
            jQuery('#storiesLoadMoreBtn').show();
            jQuery('#collectionsLoadMoreBtn').hide();
            jQuery('#authorsLoadMoreBtn').hide();
        }
        if (jQuery('#collections').hasClass("active")) {
            jQuery('#storiesLoadMoreBtn').hide();
            jQuery('#collectionsLoadMoreBtn').show();
            jQuery('#authorsLoadMoreBtn').hide();
        }
        if (jQuery('#authors').hasClass("active")) {
            jQuery('#storiesLoadMoreBtn').hide();
            jQuery('#collectionsLoadMoreBtn').hide();
            jQuery('#authorsLoadMoreBtn').show();
        }
        //ends here
        timeoutSrp = setTimeout(function() {
            jQuery.ajax({
                dataType: 'json',
                url: ajaxurl,
                type: "POST",
                data: {
                    "action": "suggestive_search_ajax_results",
                    's': searchTermSrp,
                    'suggested_post_id': tokenParamm
                },
                success: function(response) {
                    jQuery('#stories').empty();
                    // jQuery('#journeys').empty();
                    jQuery('#collections').empty();
                    jQuery('#authors').empty();
                    jQuery('#storiesLoadMoreBtn').empty();
                    jQuery('#collectionsLoadMoreBtn').empty();
                    jQuery('#authorsLoadMoreBtn').empty();
                    jQuery('#relatedTagsStoriesSrp').empty();
                    jQuery('#relatedTagsStoriesResponsiveSrp').empty();
                    jQuery('div#elasticSearchStoriesResultSrp').jplist({ command: 'empty' });

                    // //tmp_results['complete_results'] = JSON.parse(response.replace(/ 0+(?![\. }])/g, ' '));
                    tmp_results['complete_results'] = response;
                    var matchedTitleArray = [];
                    var matchedTagsArray = [];
                    var matchedAuthorArray = [];
                    var matchedContentArray = [];


                    if (jQuery('span.search-anno').length > 0) {
                        jQuery('span.search-anno').remove();
                    }

                    var totalNoOfSearchResultsFound = '';
                    totalNoOfSearchResultsFound = response.complete_results.stories.length + response.complete_results.collection.length;


                    if (totalNoOfSearchResultsFound > 1) {
                        if (searchTermSrp != '*') {
                            jQuery('<span class="search-anno">' + totalNoOfSearchResultsFound + ' Results for "' + searchTermSrp + '"</span>').insertAfter('input#suggestiveSearchInputSrp');
                        } else {
                            jQuery('<span class="search-anno">No result for your search, showing all recent results instead</span>').insertAfter('input#suggestiveSearchInputSrp');
                        }

                    } else if (totalNoOfSearchResultsFound == 1) {
                        if (searchTermSrp != '*') {
                            jQuery('<span class="search-anno">' + totalNoOfSearchResultsFound + ' Result for "' + searchTermSrp + '"</span>').insertAfter('input#suggestiveSearchInputSrp');
                        } else {
                            jQuery('<span class="search-anno">No result for your search, showing all recent results instead</span>').insertAfter('input#suggestiveSearchInputSrp');
                        }

                    } else {
                        jQuery('<span class="search-anno">No result for your search, showing all recent results instead</span>').insertAfter('input#suggestiveSearchInputSrp');
                        onKeyUpAjax(esrp, true);
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
                    document.getElementById('countOfStoriesSrp').innerText = isStoriesPresentSrp;
                    //document.getElementById('countOfJourneysSrp').innerText = isJourneysPresentSrp;
                    document.getElementById('countOfCollectionSrp').innerText = isCollectionPresentSrp;
                    document.getElementById('countOfAuthorsSrp').innerText = relatedAuthorsCountSrp;
                    var siteUrlEnterKeyIcons = window.location.hostname;
                    // //var isAuthorPresent=response.complete_results.authors.length;
                    // // console.log(isStoriesPresent);
                    // // console.log(isCollectionPresent);
                    // // console.log(resultCount);
                    // Fetching Stories Result Starts Here
                    /* if (isJourneysPresentSrp > 0) {
                         for (countJourneysSrp = 0; countJourneysSrp < isJourneysPresentSrp; countJourneysSrp++) {
                             var jounryes_title = response.complete_results.journeys[countJourneysSrp]['jounryes_title'];

                             var jounryes_link = response.complete_results.journeys[countJourneysSrp]['jounryes_link'];
                             var jounryes_image = response.complete_results.journeys[countJourneysSrp]['jounryes_image'];
                             var jounryes_description = response.complete_results.journeys[countJourneysSrp]['jounryes_description'];
                             var jounryes_city = response.complete_results.journeys[countJourneysSrp]['jounryes_city'];
                             var jounryes_experience_name = response.complete_results.journeys[countJourneysSrp]['jounryes_experience_name'];
                             var jounryes_duration = response.complete_results.journeys[countJourneysSrp]['jounryes_duration'];
                             journeysArticleImageSrp +=
                                 '<div data-control-storage="false" data-storyparentcategory="' + jounryes_experience_name + '" data-mediastorytype="post" class="list-item ' + jounryes_experience_name + ' post col-xs-12 col-sm-12 col-md-12 article-search paddingLeftRight0 journeysloadMore" style=""> <div class = "col-xs-12 col-sm-12 col-md-4 col-lg-4 articleSearch-img paddingleft0 paddingRight0" > < img class = "" data-src = "' + jounryes_image + '" src = "https://res.cloudinary.com/round-glass-magazine/image/upload/c_fill,ar_1:1,g_auto/w_100,q_auto,f_auto/v1509084065/loading_zytd8l.gif" > < /div> <div class = "col-xs-12 col-sm-12 col-md-8 col-lg-8 articleSearch-content"><h5 > < a class = "card_article_heading"  href = "' + jounryes_link + '" > ' + jounryes_title + ' < /a></h5><div class = "artistName" > < a href = "http://127.0.0.1/journeys/author/?authorname=vagrant" class = "botName image_caption copper" > vagrant < /a></div><p class = "image_caption black--" > ... < /p> <div class = "iconTimeOuter read_count" >< /div> < /div > </div>';
                         }
                     }*/
                    if (isStoriesPresentSrp > 0) {

                        for (countStorySrp = 0; countStorySrp < isStoriesPresentSrp; countStorySrp++) {
                            var storiesResultSrp = '';
                            var storiesAuthorSrp = '';
                            var storiesArticleImageSrp = '';
                            var storiesResultCardExcerpt = '';
                            var storiesTimeRead = '';
                            var articleCardTextByMediaType = '';
                            // var mediaTypeStories='';
                            var parentCategoryStories = response.complete_results.stories[countStorySrp].post_cats['parent_cat_slug'];
                            var mediaTypeStories = response.complete_results.stories[countStorySrp].type;


                            var storiesArticlePermalinkSrp = response.complete_results.stories[countStorySrp].permalink;
                            var storiesAuthorPermalinkSrp = response.complete_results.stories[countStorySrp].author_profile_link;
                            var storiesArticleImagesLinkSrp = response.complete_results.stories[countStorySrp].card_thumbnail_src;

                            //added to handle cloudinary URL intel params starts
                            storiesArticleImagesLinkSrp = getCloudinaryURLWithARParams(storiesArticleImagesLinkSrp.indexOf('cloudinary.com'), storiesArticleImagesLinkSrp, false, true);
                            //added to handle cloudinary URL intel params ends

                            if (mediaTypeStories == 'post')

                            {

                                //articleCardTextByMediaType += '<span class="iconTime-read"><img src="//' + siteUrlEnterKeyIcons + '/journeys/wp-content/themes/journeys/images/icon-searchTime.svg" /> </span><span class="min-read">' + response.complete_results.stories[countStorySrp].count_on_card['read_time'] + ' Min Read</span>';
                                articleCardTextByMediaType += '';

                            }
                            if (mediaTypeStories == 'photostory') {
                                var photoCountSingularCheck = '';

                                photoCountSingularCheck = response.complete_results.stories[countStorySrp].count_on_card['photo_count'];

                                if (photoCountSingularCheck == 1) {
                                    articleCardTextByMediaType += '<span class="iconTime-read"><img src="//' + siteUrlEnterKeyIcons + '/journeys/wp-content/themes/journeys/images/icon_photostories_01.svg" /> </span><span class="min-read">' + response.complete_results.stories[countStorySrp].count_on_card['photo_count'] + ' Photo</span>';
                                }

                                if (photoCountSingularCheck == 0 || photoCountSingularCheck > 1) {

                                    articleCardTextByMediaType += '<span class="iconTime-read"><img src="//' + siteUrlEnterKeyIcons + '/journeys/wp-content/themes/journeys/images/icon_photostories_01.svg" /> </span><span class="min-read">' + response.complete_results.stories[countStorySrp].count_on_card['photo_count'] + ' Photos</span>';
                                }

                            }
                            if (mediaTypeStories == 'videostory') {

                                articleCardTextByMediaType += '<span class="iconTime-read"><img src="//' + siteUrlEnterKeyIcons + '/journeys/wp-content/themes/journeys/images/icon-searchTime.svg" /> </span><span class="min-read">' + response.complete_results.stories[countStorySrp].count_on_card['read_time'] + ' Min Watch</span>';

                            }


                            storiesArticleImageSrp +=
                                '<div style="display:none;" data-storyparentcategory="' + parentCategoryStories + '" data-mediastorytype="' + mediaTypeStories + '" class="list-item  ' + parentCategoryStories + ' ' + mediaTypeStories + ' col-xs-12 col-sm-12 col-md-12 article-search paddingLeftRight0 storiesloadMore"><div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 articleSearch-img paddingleft0 paddingRight0"><a href="' + storiesArticlePermalinkSrp + '"><img  class=""  src="' + storiesArticleImagesLinkSrp + '"></a></div>';
                            storiesResultSrp +=
                                '<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 articleSearch-content"><h5><a class="card_article_heading"  href="' + storiesArticlePermalinkSrp + '"  >' +
                                response.complete_results.stories[countStorySrp].title + '</a></h5>';
                            storiesAuthorSrp += '<div class="artistName"><a href="' + storiesAuthorPermalinkSrp + '" class="botName">' +
                                response.complete_results.stories[countStorySrp].author_name + '</a></div>';
                            storiesResultCardExcerpt += '<p class="image_caption black--">' + response.complete_results.stories[countStorySrp].post_card_excerpt + '</p>';
                            storiesTimeRead += '<div class="iconTimeOuter  read_count">' + articleCardTextByMediaType + '</div></div>';

                            var fullResultStoriesSrp = storiesArticleImageSrp + storiesResultSrp + storiesAuthorSrp + storiesResultCardExcerpt + storiesTimeRead;

                            // jQuery('#journeys').append(journeysArticleImageSrp);

                            jQuery('#stories').append(jQuery(fullResultStoriesSrp));

                            breakWords();

                            // jQuery( ".suggestiveHeaderStoriesWrapper" ).show();
                            jQuery('#relatedTagsStoriesSrp').append(jQuery(relatedTagsStoriesSrp));
                            //jQuery('#relatedTagsStoriesResponsiveSrp').append(jQuery(relatedTagsStoriesSrp));

                            document.getElementById("elasticSearchStoriesResultSrp").style.display = "block";
                            document.getElementById("suggeTabsRes").style.display = "block";
                        }

                        triggerJPLists('elasticSearchStoriesResultSrp', 'list-stories', 0);

                        jQuery('#storiesLoadMoreBtn').append('<div class="alm-btn-wrap"><button id="storiesLoadMoreBtnNew" class="alm-load-more-btn more srp_stories_load_more">Load More</button></div>');

                        if (storiesTagCountSrp != 0 && storiesTagCountSrp != null) {
                            for (storiesTagCounterSrp = 0; storiesTagCounterSrp < storiesTagCountSrp; storiesTagCounterSrp++) {
                                var relatedTagsStories = '';
                                var storiesTagsSrp = response.complete_results.related_tags[storiesTagCounterSrp].tag_name;
                                relatedTagsStories += '<a href="/journeys/search/?search_term=' + storiesTagsSrp + '&tags=true">' + storiesTagsSrp + '</a>'
                                    // console.log(relatedTagsStories);
                                    // console.log(storiesTags);

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
                                '<div class="list-item ' + relatedAuthorsCategory + ' col-md-12 col-xs-12 col-sm-12 article-search authorCard paddingLeftRight0 authorsloadMore"><div class="col-4 col-xs-4 col-sm-4 col-md-3 col-lg-3 img-authOuter paddingleft0 paddingRight0"><a  href="' + relatedAuthorsPermalinkSrp + '"  ><img class="authorCard-img"  src="' + relatedAuthorsImageLinkSrp + '"></a></div>';


                            relatedAuthorsSrp +=
                                '<div class="col-8 col-xs-8 col-sm-8 col-md-9 col-lg-9 articleSearch-content"><h5><a class="card_article_heading" href="' + relatedAuthorsPermalinkSrp + '"  >' +
                                response.complete_results.authors[relatedAuthorsCounterSrp].author_name + '</a></h5>';

                            relatedAuthorsCardExcerpt += '<p class="image_caption black--">' + response.complete_results.authors[relatedAuthorsCounterSrp].author_profile_bio + '</p>';

                            var authorsArticlesSingularCheck = '';

                            authorsArticlesSingularCheck = response.complete_results.authors[relatedAuthorsCounterSrp].articles_count_author;

                            if (authorsArticlesSingularCheck == 1) {

                                relatedAuthorsTimeRead += '<div class="iconTimeOuter read_count"><span class="iconAuthors"><img src="//' + siteUrlEnterKeyIcons + '/journeys/wp-content/themes/journeys/images/icon_author_01.svg" /></span><span class="min-read">' + response.complete_results.authors[relatedAuthorsCounterSrp].articles_count_author + ' Article</span></div></div>';

                            }

                            if (authorsArticlesSingularCheck == 0 || authorsArticlesSingularCheck > 1) {
                                relatedAuthorsTimeRead += '<div class="iconTimeOuter read_count"><span class="iconAuthors"><img src="//' + siteUrlEnterKeyIcons + '/journeys/wp-content/themes/journeys/images/icon_author_01.svg" /></span><span class="min-read">' + response.complete_results.authors[relatedAuthorsCounterSrp].articles_count_author + ' Articles</span></div></div>';
                            }


                            var fullResultAuthorsSrp = relatedAuthorsImageSrp + relatedAuthorsSrp + relatedAuthorsCardExcerpt + relatedAuthorsTimeRead;
                            jQuery('#authors').append(jQuery(fullResultAuthorsSrp));

                            breakWords();

                            // jQuery(".suggestiveHeaderAuthorsWrapper").show();
                            // document.getElementById("suggestiveSearchDropDown").style.display = "block";
                        }
                        triggerJPLists('elasticSearchStoriesResultSrp', 'list-authors', 1);
                        jQuery('#authorsLoadMoreBtn').append('<div class="alm-btn-wrap"><button id="authorsLoadMoreBtnNew" class="alm-load-more-btn more srp_authors_load_more">Load More</button></div>');

                    }
                    // //Ends here

                    // Fetching Collection Result Starts Here
                    if (isCollectionPresentSrp > 0) {

                        for (countCollectSrp = 0; countCollectSrp < isCollectionPresentSrp; countCollectSrp++) {
                            var collectionResultSrp = '';
                            var collectionAuthorSrp = '';
                            var collectionArticleImageSrp = '';
                            var collectionResultCardExcerpt = '';
                            var collectionTimeRead = '';
                            var parentCategoryCollection = response.complete_results.collection[countCollectSrp].post_cats['parent_cat_slug'];
                            var mediaTypeCollection = response.complete_results.collection[countCollectSrp].type;
                            var collectionArticlePermalinkSrp = response.complete_results.collection[countCollectSrp].permalink;
                            var collectionAuthorPermalinkSrp = response.complete_results.collection[countCollectSrp].author_profile_link;
                            var collectionArticleImagesLinkSrp = response.complete_results.collection[countCollectSrp].card_thumbnail_src;
                            var collectionCity = response.complete_results.collection[countCollectSrp].collection_city;
                            var collectionNight = response.complete_results.collection[countCollectSrp].collection_night;
                            var collectionDay = response.complete_results.collection[countCollectSrp].collection_day;
                            var collectionDesc = response.complete_results.collection[countCollectSrp].collection_desc;
                            var purl = response.complete_results.collection[countCollectSrp].purl;
                            var collectionImage = response.complete_results.collection[countCollectSrp].collection_image;
                            var collectionEx = response.complete_results.collection[countCollectSrp].collection_e_x;

                            var collectionSdate = response.complete_results.collection[countCollectSrp].collection_s_date;
                            var colletionEdate = response.complete_results.collection[countCollectSrp].colletion_e_date;
                            var concatmonthstr = collectionSdate + colletionEdate.trim();
                            var concatmonth = concatmonthstr.replace(/ /g, '');
                            var mediaTypeCollectionSrp = response.complete_results.collection[countCollectSrp].type;
                            var jt = response.complete_results.collection[countCollectSrp].title;
                            var dclass = response.complete_results.collection[countCollectSrp].collectionDayClass;

                            //added to handle cloudinary URL intel params starts
                            collectionArticleImagesLinkSrp = getCloudinaryURLWithARParams(collectionArticleImagesLinkSrp.indexOf('cloudinary.com'), collectionArticleImagesLinkSrp, false, true);
                            //added to handle cloudinary URL intel params ends

                            collectionArticleImageSrp +=
                                '<div data-mediacollectiontype="' + mediaTypeCollectionSrp + '" data-collectionparentcategory="' + parentCategoryCollection + '" data-mediacollectiontype="' + mediaTypeCollection + '" class=" list-item ' + collectionEx + ' ' + concatmonth + ' ' + mediaTypeCollectionSrp + ' ' + dclass + ' col-xs-12 col-sm-12 col-md-12 article-search paddingLeftRight0 collectionsloadMore"><div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 articleSearch-img paddingleft0 paddingRight0"><a href="' + collectionArticlePermalinkSrp + '"><img class="" src="' + collectionImage + '"></a></div>';
                            collectionResultSrp +=
                                '<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 articleSearch-content"><div style="text-transform:uppercase" class="sub-header"><a class="tdec" href="journeys/experience/' + collectionEx + '">' + collectionEx + '</a></div><h5><a class="card_article_heading" href="' + collectionArticlePermalinkSrp + '"  >' +
                                response.complete_results.collection[countCollectSrp].title + '</a></h5>';
                            collectionAuthorSrp += '';
                            // console.log('collection author');
                            // console.log(collectionAuthorSrp);
                            collectionResultCardExcerpt += '<p class="light swiper-slide-exp-mobile">' + collectionDesc + '</p><div class="location swiper-slide-exp-mobile"><span class="map">' + collectionCity + '</span></span><span class="day">' + collectionNight + ' Nights ' + collectionDay + ' Days</span><a href="" data-toggle="modal" data-target="#myBook" data-image=' + purl + ' data-title="' + jt + '" data-city="' + collectionCity + '" class="bkform float-right url">+ BOOK</a></div>';
                            //console.log(siteUrlEnterKeyIcons);
                            var collectionsArticlesSingularCheck = '';

                            collectionsArticlesSingularCheck = response.complete_results.collection[countCollectSrp].count_on_card['collection_articles_count'];

                            if (collectionsArticlesSingularCheck == 1) {
                                collectionTimeRead += '<div class="iconTimeOuter read_count"><span class="iconColletion"><img src="//' + siteUrlEnterKeyIcons + '/journeys/wp-content/themes/journeys/images/icon_collection_01.png" /></span><span class="min-read">' + response.complete_results.collection[countCollectSrp].count_on_card['collection_articles_count'] + ' Article</span></div></div>';
                            }

                            if (collectionsArticlesSingularCheck == 0 || collectionsArticlesSingularCheck > 1) {
                                collectionTimeRead += '<div class="iconTimeOuter read_count"><span class="iconColletion"><img src="//' + siteUrlEnterKeyIcons + '/journeys/wp-content/themes/journeys/images/icon_collection_01.png" /></span><span class="min-read">' + response.complete_results.collection[countCollectSrp].count_on_card['collection_articles_count'] + ' Articles</span></div></div>';
                            }



                            // // console.log('tag count');
                            // // console.log(storiesTagCount);
                            // // console.log('tag count');
                            var fullResultCollectionSrp = collectionArticleImageSrp + collectionResultSrp + collectionAuthorSrp + collectionResultCardExcerpt + collectionTimeRead;
                            // //var storiesShowMore = jQuery('').val();
                            // //jQuery('a.target').attr('href', newurl);
                            // if(resultCount<3||isStoriesPresent<3){
                            // jQuery( "#storiesShowMoreHideText" ).css( "display", "none" );
                            // }
                            // // jQuery('#elasticSearchStoriesResult').empty();
                            // jQuery('#relatedTagsElasticSearch').empty();
                            jQuery('#collections').append(jQuery(fullResultCollectionSrp));

                            breakWords();

                            // jQuery( ".suggestiveHeaderStoriesWrapper" ).show();
                            document.getElementById("elasticSearchStoriesResultSrp").style.display = "block";
                            document.getElementById("suggeTabsRes").style.display = "block";

                        }
                        triggerJPLists('elasticSearchStoriesResultSrp', 'list-collections', 2);
                        jQuery('#collectionsLoadMoreBtn').append('<div class="alm-btn-wrap"><button id="collectionsLoadMoreBtnNew" class="alm-load-more-btn more srp_collections_load_more">Load More</button></div>');
                    }

                    //To handle if Stories Results Are Blank
                    // if (isStoriesPresentSrp == 0) {
                    //     jQuery(".suggestiveHeaderStoriesWrapper").hide();
                    //     jQuery(".related-tags").hide();

                    // }
                    //To handle if Collection Results Are Blank Ends Here
                    // if (isCollectionPresentSrp == 0) {
                    //     jQuery(".suggestiveHeaderCollectionWrapper").hide();
                    // }
                    //To handle if Authors Results Are Blank Ends Here
                    // if(relatedAuthorsCountSrp==0)
                    // {
                    // jQuery( ".suggestiveHeaderAuthorsWrapper" ).hide();
                    // }

                    // code for search starts
                    /*var bLazy = new Blazy({
						success: function(element){
							console.log('test');
							setTimeout(function(){
							var parent = element.parentNode;
							parent.className = parent.className.replace(/\bloading\b/,'');
							}, 200);
						}
				    });*/

                    // code for search ends
                    jQuery("#ac_option_selected").val('');
                },
                error: function() {},
            })
        }, 500);
    }
}
//code to make the search filter checkbox label clickable
jQuery('ul.jplist-group span.catSpan').each(function(index) {
    jQuery(this).click(function() {
        jQuery(this).prev('span.squaredTwo').children('input[type="checkbox"]').trigger('click');
    });
});

function triggerJPLists(overAllContainerID, itemsBoxClass, callCount) {
    jQuery('#' + overAllContainerID).jplist({
        itemsBox: '.' + itemsBoxClass,
        itemPath: '.list-item',
        panelPath: '.jplist-panel',
        redrawCallback: function(collection, $dataview, statuses) {

            localStorage.clear();



            //this code occurs on every jplist action
            if (callCount == 0) {

                var storiesTabCountPluralCheck = '';

                storiesTabCountPluralCheck = collection.dataview.length;
                if (storiesTabCountPluralCheck == 1) {
                    document.getElementById('checkForStoriesPlural').innerText = 'STORY';

                }
                if (storiesTabCountPluralCheck == 0 || storiesTabCountPluralCheck > 1) {
                    document.getElementById('checkForStoriesPlural').innerText = 'STORIES';

                }

                document.getElementById('countOfStoriesSrp').innerText = collection.dataview.length;
                var countOfStoriesSrpBtn = collection.dataview.length;
                if (countOfStoriesSrpBtn <= 10) {

                    jQuery('#storiesLoadMoreBtn').hide();

                }
                jQuery('.filter-srp').change(function() {

                    var onCheckStoriesChangeCount = document.getElementById('countOfStoriesSrp').innerText;
                    //console.log('onCheckStoriesChangeCount'+onCheckStoriesChangeCount);
                    if (jQuery('#stories').hasClass("active")) {
                        if (onCheckStoriesChangeCount > 10) {

                            //alert('yes');

                            jQuery('div#storiesLoadMoreBtn').show();
                            jQuery('div#authorsLoadMoreBtn').hide();
                            jQuery('div#collectionsLoadMoreBtn').hide();
                        }

                    }
                    for (var i = 0; i < $dataview.length; i++) {


                        jQuery($dataview[i]).addClass('pussy');
                        jQuery($dataview[i]).removeClass('lifeSaver');



                    }
                });
                var datalength = collection.dataview.length;
                //console.log(datalength);
                if (jQuery('span#countOfStoriesSrp').length > 0) {
                    var myLengthStories = jQuery('span#countOfStoriesSrp').text();
                    jQuery('div#stories div.list-item').hide();
                    //var filterCheckboxCountSrp=jQuery('div#cat-check-res input[name="FilterSrpRes"]:checked').length;
                    //console.log("filterCheckboxCountSrp="+filterCheckboxCountSrp);
                    for (var i = 0; i < $dataview.length; i++) {
                        jQuery($dataview[i]).addClass('lifeSaver');


                    }
                    for (var i = 0; i < 10; i++) {
                        jQuery($dataview[i]).show();



                        //console.log($dataview[i]);


                    }


                    jQuery('div#stories div.list-item').each(function() {
                        //console.log(jQuery(this).css('display'));
                        if (jQuery(this).css('display') == 'none' && !(jQuery(this).hasClass('lifeSaver'))) {
                            //console.log(jQuery(this).css('display'));
                            jQuery(this).remove();
                        }
                    });
                    //}


                }
            }

            if (callCount == 1) {
                var authorsTabCountPluralCheck = '';

                authorsTabCountPluralCheck = collection.dataview.length;
                if (authorsTabCountPluralCheck == 1) {
                    document.getElementById('checkForAuthorsPlural').innerText = 'AUTHOR';

                }
                if (authorsTabCountPluralCheck == 0 || authorsTabCountPluralCheck > 1) {
                    document.getElementById('checkForAuthorsPlural').innerText = 'AUTHORS';

                }

                document.getElementById('countOfAuthorsSrp').innerText = collection.dataview.length;

                // prevent author count from changing

                //                   jQuery('div#disableMediaAC input[type="checkbox"]').change(function()
                //                   {
                //                   	console.log('in media type');

                //                   	if(jQuery('#stories').hasClass( "active"))
                //                   	{

                //                   		var hiddenFieldCount='';
                //                   		document.getElementById('hiddenValueSrpMediaResetPrevent').innerText = '';
                //                   		document.getElementById('countOfAuthorsSrp').innerText=relatedAuthorsCountSrp;
                //                   		hiddenFieldCount=document.getElementById('countOfStoriesSrp').innerText;
                //                   	    document.getElementById('hiddenValueSrpMediaResetPrevent').innerText = hiddenFieldCount;
                //                   		return false;


                //                   	}

                //                   });

                //                   jQuery('input[name="samsaraFilterSrp"]').change(function()
                //                   {
                //                   	  document.getElementById('countOfAuthorsSrp').innerText = collection.dataview.length;

                //                   });

                //                    jQuery('input[name="journeysFilterSrp"]').change(function()
                //                   {
                //                   		document.getElementById('countOfAuthorsSrp').innerText = collection.dataview.length;
                //                   });

                //                     jQuery('.samsaraFilterRes').change(function()
                //                   {
                //                   		document.getElementById('countOfAuthorsSrp').innerText = collection.dataview.length;
                //                   });

                //                        jQuery('.journeysFilterRes').change(function()
                //                   {
                //                   		document.getElementById('countOfAuthorsSrp').innerText = collection.dataview.length;
                //                   });


                var countOfAuthorsSrpBtn = collection.dataview.length;
                if (countOfAuthorsSrpBtn <= 10) {

                    jQuery('#authorsLoadMoreBtn').hide();

                }
                jQuery('.filter-srp').change(function() {

                    var onCheckAuthorsChangeCount = document.getElementById('countOfAuthorsSrp').innerText;
                    //console.log('authorchangecount='+onCheckAuthorsChangeCount);
                    if (onCheckAuthorsChangeCount > 10) {
                        if (jQuery('#authors').hasClass("active")) {
                            jQuery('div#storiesLoadMoreBtn').hide();
                            jQuery('div#authorsLoadMoreBtn').show();
                            jQuery('div#collectionsLoadMoreBtn').hide();
                        }
                    }
                    for (var i = 0; i < $dataview.length; i++) {


                        jQuery($dataview[i]).addClass('pussy');
                        jQuery($dataview[i]).removeClass('lifeSaver');



                    }
                });
                if (jQuery('span#countOfAuthorsSrp').length > 0) {
                    var myLengthAuthors = jQuery('span#countOfAuthorsSrp').text();
                    jQuery('div#authors div.list-item').hide();
                    for (var i = 0; i < $dataview.length; i++) {
                        jQuery($dataview[i]).addClass('lifeSaver');


                    }
                    for (var i = 0; i < 10; i++) {
                        jQuery($dataview[i]).show();

                    }


                    jQuery('div#authors div.list-item').each(function() {
                        //console.log(jQuery(this).css('display'));
                        if (jQuery(this).css('display') == 'none' && !(jQuery(this).hasClass('lifeSaver'))) {
                            //console.log(jQuery(this).css('display'));
                            jQuery(this).remove();
                        }
                    });
                }
            }



            if (callCount == 2) {

                var collectionsTabCountPluralCheck = '';

                collectionsTabCountPluralCheck = collection.dataview.length;
                if (collectionsTabCountPluralCheck == 1) {
                    document.getElementById('checkForCollectionsPlural').innerText = 'JOURNEY';

                }
                if (collectionsTabCountPluralCheck == 0 || collectionsTabCountPluralCheck > 1) {
                    document.getElementById('checkForCollectionsPlural').innerText = 'JOURNEYS';

                }

                document.getElementById('countOfCollectionSrp').innerText = collection.dataview.length;

                // prevent collection count from changing

                //                   jQuery('div#disableMediaAC input[type="checkbox"]').change(function()
                //                   {
                //                   	console.log('in media type');

                //                   	if(jQuery('#stories').hasClass( "active"))
                //                   	{
                //                   		document.getElementById('countOfAuthorsSrp').innerText=relatedAuthorsCountSrp;
                //                   		return false;

                //                   	}

                //                   });

                //                   jQuery('input[name="samsaraFilterSrp"]').change(function()
                //                   {
                //                   	  document.getElementById('countOfCollectionSrp').innerText = collection.dataview.length;

                //                   });

                //                    jQuery('input[name="journeysFilterSrp"]').change(function()
                //                   {
                //                   		document.getElementById('countOfCollectionSrp').innerText = collection.dataview.length;
                //                   });


                //                      jQuery('.samsaraFilterRes').change(function()
                //                   {
                //                   		document.getElementById('countOfCollectionSrp').innerText = collection.dataview.length;
                //                   });

                //                        jQuery('.journeysFilterRes').change(function()
                //                   {
                //                   		document.getElementById('countOfCollectionSrp').innerText = collection.dataview.length;
                //                   });

                var countOfCollectionSrpBtn = collection.dataview.length;
                if (countOfCollectionSrpBtn <= 10) {

                    jQuery('#collectionsLoadMoreBtn').hide();

                }
                jQuery('.filter-srp').change(function() {
                    var onCheckCollectionsChangeCount = document.getElementById('countOfCollectionSrp').innerText;
                    //console.log('onCheckCollectionsChangeCount'+onCheckCollectionsChangeCount);
                    if (onCheckCollectionsChangeCount > 10) {
                        if (jQuery('#collections').hasClass("active")) {
                            jQuery('div#storiesLoadMoreBtn').hide();
                            jQuery('div#authorsLoadMoreBtn').hide();
                            jQuery('div#collectionsLoadMoreBtn').show();
                        }
                    }
                    for (var i = 0; i < $dataview.length; i++) {


                        jQuery($dataview[i]).addClass('pussy');
                        jQuery($dataview[i]).removeClass('lifeSaver');



                    }
                });
                if (jQuery('span#countOfCollectionSrp').length > 0) {
                    var myLengthCollections = jQuery('span#countOfCollectionSrp').text();
                    jQuery('div#collections div.list-item').hide();
                    for (var i = 0; i < $dataview.length; i++) {
                        jQuery($dataview[i]).addClass('lifeSaver');


                    }
                    for (var i = 0; i < $dataview.length; i++) {
                        jQuery($dataview[i]).show();

                    }


                    jQuery('div#collections div.list-item').each(function() {
                        //console.log(jQuery(this).css('display'));
                        if (jQuery(this).css('display') == 'none' && !(jQuery(this).hasClass('lifeSaver'))) {
                            //console.log(jQuery(this).css('display'));
                            jQuery(this).remove();
                        }
                    });
                }
            }
        }
    });
}
/** Magazine Search Result Page JS Ends **/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////






///////////////////////////////////////////////////
//Load More for Search Result Page
jQuery(document).ready(function($) {
    //Close autocomplete when clicked outside input field
    jQuery(document).on("click", function(event) {
        var $trigger = jQuery(".autoCompleteSrpSuggestion");
        if ($trigger !== event.target && !$trigger.has(event.target).length) {
            jQuery(".autoCompleteSrpSuggestion").hide();
        }
    });
    //ends here

    /*This code used for load more functionality on SRP page over stories tab*/
    jQuery('body').on('click', '#storiesLoadMoreBtnNew', function(e) {
        e.preventDefault();
        jQuery(this).text("Loading...");
        setTimeout(function() {
            jQuery(".storiesloadMore:hidden").slice(0, 10).slideDown();
            jQuery('.srp_stories_load_more').text("Load More");
        }, 500);
        if (jQuery(".storiesloadMore:hidden").length == 0) {
            jQuery("#storiesLoadMoreBtn").fadeOut('slow');
        }
        // jQuery('html,body').animate({
        //     scrollTop: jQuery(this).offset().top
        // }, 500);

    });

    /*This code used for load more functionality on SRP page over authors tab*/
    jQuery('body').on('click', '#authorsLoadMoreBtnNew', function(e) {
        e.preventDefault();
        jQuery(this).text("Loading...");
        setTimeout(function() {
            jQuery(".authorsloadMore:hidden").slice(0, 10).slideDown();
            jQuery('.srp_authors_load_more').text("Load More");
        }, 500);
        if (jQuery(".authorsloadMore:hidden").length == 0) {
            jQuery("#authorsLoadMoreBtn").fadeOut('slow');
        }
        // jQuery('html,body').animate({
        //     scrollTop: jQuery(this).offset().top
        // }, 500);

    });

    /*This code used for load more functionality on SRP page over collection tab*/
    jQuery('body').on('click', '#collectionsLoadMoreBtnNew', function(e) {
        e.preventDefault();
        jQuery(this).text("Loading...");
        setTimeout(function() {
            jQuery(".collectionsloadMore:hidden").slice(0, 10).slideDown();
            jQuery('.srp_collections_load_more').text("Load More");
        }, 500);
        if (jQuery(".collectionsloadMore:hidden").length == 0) {
            jQuery("#collectionsLoadMoreBtn").fadeOut('slow');
        }
        // jQuery('html,body').animate({
        //     scrollTop: jQuery(this).offset().top
        // }, 500);

    });
    //         jQuery(window).scroll(function () {
    // 		    if (jQuery(this).scrollTop() > 50) {
    // 		        jQuery('.totop a').fadeIn();
    // 		    } else {
    // 		        jQuery('.totop a').fadeOut();
    // 		    }
    // });
});
//Load More for Search Result Page Ends Here
///////////////////////////////////////////////////
function breakWords() {
    jQuery('div.articleSearch-content').find('p').each(function(i) {
        var iTotalWords = jQuery(this).text().length;
        var iTotalWordsVal = jQuery(this).text();
        if (iTotalWords >= 150) {
            jQuery(this).text(iTotalWordsVal.substring(0, 150) + "..")

        }
    });
}


/*This code used for auto-complete functionality on SRP page*/
jQuery("#suggestiveSearchInputSrp, #suggestiveSearchInputResponsive").keyup(function(esrp) {

    var searchTermValueSrp = jQuery(this).val();
    var asSrpTarget = jQuery(this).next().next();
    var Targetid = jQuery(this).attr('id');
    var breakWord = '';

    if (searchTermValueSrp != "") {

        if (esrp.keyCode != 40 && esrp.keyCode != 38) {
            jQuery.ajax({

                dataType: 'json',
                url: ajaxurl,
                type: "POST",
                data: {
                    "action": "autocomplete_search_ajax_results",
                    's': searchTermValueSrp,
                },
                success: function(response) {

                    if (jQuery.trim(response.code) == "success") {
                        var suggestedWordsCount = 0;
                        suggestedWordsCount = response.results.length;
                        var suggestedWords = response.results;

                        if (suggestedWordsCount > 0) {
                            var customAddFrstLstLiCss = 'customAddFrstLstLiCss';
                            if (suggestedWordsCount == 1) {
                                customAddFrstLstLiCss = '';
                            }
                            var htmlcode = '<ul class="autoCompleteRes ' + customAddFrstLstLiCss + '" style="display: none !important">';
                            for (i = 0; i < suggestedWordsCount; i++) {
                                if (suggestedWords[i].title.length > 25) {
                                    breakWord = suggestedWords[i].title.substring(0, 25) + "..";
                                } else {
                                    breakWord = suggestedWords[i].title;
                                }

                                htmlcode += "<li class='selectWord' data-trgid= '" + Targetid + "' data-fill='" + suggestedWords[i].title + "' data-tokenid= '" + suggestedWords[i].id + "'>" + breakWord + "</li>";
                            }
                            htmlcode += "</ul>";
                            asSrpTarget.html(htmlcode);
                            asSrpTarget.show();

                            srpAutoCompleteSelectedOnKeyUpDown(Targetid);

                        } else {
                            asSrpTarget.hide();
                            asSrpTarget.html('');
                        }
                    } else {
                        asSrpTarget.hide();
                        asSrpTarget.html('');
                    }
                }
            });
        }

    } else {
        asSrpTarget.hide();
        asSrpTarget.html('');
    }

});

/*This code used for select title from auto-complete on SRP page */
jQuery('body').on("click", '.selectWord', function() {
    var autoSugInptID = jQuery(this).data('trgid');
    jQuery('.autoCompleteSrpSuggestion').hide();
    jQuery("#" + autoSugInptID).val(jQuery(this).data('fill'));

    if (autoSugInptID == 'suggestiveSearchInputResponsive') {
        var searchTermValueResponsiveSrp = jQuery(this).data('fill').trim();
        var siteUrlEnterKey = window.location.hostname;
        var location = "/journeys/search/?search_term=" + searchTermValueResponsiveSrp;
        window.location.href = location;
    } else {
        jQuery("#ac_option_selected").val(jQuery(this).data('tokenid'));

        jQuery("#" + autoSugInptID).trigger('keyup');
        localStorage.clear();
    }
});


/*This code is used to select title through up and down key*/
function srpAutoCompleteSelectedOnKeyUpDown(srchInput) {

    var listItems = jQuery('ul.autoCompleteRes li');

    jQuery("#" + srchInput).keydown(function(e) {
        var key = e.keyCode,
            selected = listItems.filter('.selected'),
            current;

        if (key != 40 && key != 38) return;

        listItems.removeClass('selected');

        if (key == 40) // Down key
        {
            if (!selected.length || selected.is(':last-child')) {
                current = listItems.eq(0);
                jQuery("#" + srchInput).val(current.data('fill'));
            } else {
                current = selected.next();
                jQuery("#" + srchInput).val(current.data('fill'));
            }
        } else if (key == 38) // Up key
        {
            if (!selected.length || selected.is(':first-child')) {
                current = listItems.last();
                jQuery("#" + srchInput).val(current.data('fill'));
            } else {
                current = selected.prev();
                jQuery("#" + srchInput).val(current.data('fill'));
            }
        }

        current.addClass('selected');
    });
}

// code for search starts
jQuery(window).on('resize scroll', function() {

});

jQuery('ul.srpTabs li a').each(function() {
    jQuery(this).click(function() {

    });
});
jQuery('ul[data-control-name="categories-filter"] li div span.squaredTwo input[type="checkbox"], ul[data-control-name="categories-filter"] li div span.catSpan').each(function(index) {
    jQuery(this).click(function(index) {

    });
});
jQuery('div#storiesLoadMoreBtn, div#authorsLoadMoreBtn, div#collectionsLoadMoreBtn ').click(function() {

});

jQuery('button.srp_stories_load_more').on('click', function() {

});

function beLazy(revalidate = false) {
    return true;
}




//like-unlike for article starts
jQuery(window).on('load', function() {
    if (jQuery('article[id^="post-"]').length == 1) {
        var postIDHere = jQuery('article[id^="post-"]').attr('id').split('post-')[1];
        var articleLikeCount = jQuery('div#wp-ulike-post-' + postIDHere + ' ' + 'input[data-ulike-id="' + postIDHere + '"]').siblings('span.count-box').text();
        if (articleLikeCount != '0') {
            articleLikeCount = articleLikeCount.substr(0, articleLikeCount.length - 1);
            jQuery('span.article-like-count').text(articleLikeCount);
        } else {
            jQuery('span.article-like-count').text('');
        }

        var checkIfLiked = jQuery('div#wp-ulike-post-' + postIDHere + ' ' + 'div.wp_ulike_general_class').hasClass('wp_ulike_is_liked');
        if (checkIfLiked == true) {
            jQuery('div.socialicon a.like').css('background-image', 'url(/journeys/wp-content/themes/journeys/images/likeh.svg)');
            jQuery('div.socialicon a.like').attr('title', 'unlike');
        } else {
            jQuery('div.socialicon a.like').css('background-image', 'url(/journeys/wp-content/themes/journeys/images/like.svg)');
            jQuery('div.socialicon a.like').attr('title', 'like');
        }
    }
});
jQuery('div.socialicon a.like').click(function(e) {
    //e.preventDefault();
    if (jQuery('article[id^="post-"]').length == 1) {

        //e.preventDefault(); 
        var logIn = jQuery('span.login-span').text();

        if (!(jQuery('div.magLogOut').length > 0)) {
            return;
        } else {
            e.preventDefault();
            var postIDHere = jQuery('article[id^="post-"]').attr('id').split('post-')[1];
            jQuery('div#wp-ulike-post-' + postIDHere + ' ' + 'input[data-ulike-id="' + postIDHere + '"]').trigger('click');
            //jQuery('span.article-like-count').text(articleLikeCount);
            jQuery(document).ajaxComplete(function(evt) {

                var countItem = jQuery('div#wp-ulike-post-' + postIDHere + ' ' + 'input[data-ulike-id="' + postIDHere + '"]').siblings('span.count-box').text();
                //console.log('postIDHere = '+postIDHere+' count = '+countItem);       
                //var contentHere = jQuery('div[com-id="'+comId+'"] div.like_count a').siblings('span.image_caption');

                if (countItem != '0') {
                    countItem = countItem.substr(0, countItem.length - 1);
                    jQuery('span.article-like-count').text(countItem);
                } else {
                    jQuery('span.article-like-count').text('');
                }

                var checkIfLiked = jQuery('div#wp-ulike-post-' + postIDHere + ' ' + 'div.wp_ulike_general_class').hasClass('wp_ulike_is_liked');
                if (checkIfLiked == true) {
                    jQuery('div.socialicon a.like').css('background-image', 'url(/journeys/wp-content/themes/journeys/images/likeh.svg)');
                    jQuery('div.socialicon a.like').attr('title', 'unlike');

                } else {
                    jQuery('div.socialicon a.like').css('background-image', 'url(/journeys/wp-content/themes/journeys/images/like.svg)');
                    jQuery('div.socialicon a.like').attr('title', 'like');
                }

            });
        }

    }
});
//like-unlike for article ends

//like-unlike for comments starts
jQuery(window).on('load', function() {
    jQuery('div.prev_comments div.like_count a').each(function(index) {
        var comId = jQuery(this).parents('div.prev_comments').attr('com-id');
        var countItem = jQuery('input[data-ulike-id="' + comId + '"]').siblings('span.count-box').text();
        console.log('com-id = ' + comId + ' count = ' + countItem);
        //var contentHere = jQuery('div[com-id="'+comId+'"] div.like_count a').siblings('span.image_caption');
        if (countItem != '0') {
            countItem = countItem.substr(0, countItem.length - 1);
            jQuery('div[com-id="' + comId + '"] div.like_count a').siblings('span.image_caption').text(countItem);
        } else {
            jQuery('div[com-id="' + comId + '"] div.like_count a').siblings('span.image_caption').text('');
        }


        var checkIfLikedCom = jQuery('div#wp-ulike-post-' + comId + ' ' + 'div.wp_ulike_general_class').hasClass('wp_ulike_is_liked');
        if (checkIfLikedCom == true) {
            //alert('true');
            jQuery('div[com-id="' + comId + '"] div.like_count a span.like_icon img').attr('src', '/journeys/wp-content/themes/journeys/images/likeh.svg');
            jQuery('div[com-id="' + comId + '"] div.like_count a span.like_icon img').attr('title', 'unlike');
            jQuery('div[com-id="' + comId + '"] div.like_count a span.like_icon').attr('title', 'unlike');
        } else {
            jQuery('div[com-id="' + comId + '"] div.like_count a span.like_icon img').attr('src', '/journeys/wp-content/themes/journeys/images/like.svg');
            jQuery('div[com-id="' + comId + '"] div.like_count a span.like_icon img').attr('title', 'like');
            jQuery('div[com-id="' + comId + '"] div.like_count a span.like_icon').attr('title', 'like');
        }

    });
});
jQuery('div.prev_comments div.like_count a').each(function(index) {
    jQuery(this).click(function(e) {
        e.preventDefault();
        var logIn = jQuery('span.login-span').text();
        if (!(jQuery('div.magLogOut').length > 0)) {
            var currentWindowLoc = window.location;
            window.location = '/journeys/login/' + '?redirect_to=' + currentWindowLoc;
        } else {
            var comId = jQuery(this).parents('div.prev_comments').attr('com-id');
            //alert(comId);
            jQuery('input[data-ulike-id="' + comId + '"]').trigger('click');
            jQuery(document).ajaxComplete(function(evt) {

                var countItem = jQuery('input[data-ulike-id="' + comId + '"]').siblings('span.count-box').text();
                console.log('com-id = ' + comId + ' count = ' + countItem);
                //var contentHere = jQuery('div[com-id="'+comId+'"] div.like_count a').siblings('span.image_caption');

                if (countItem != '0') {
                    countItem = countItem.substr(0, countItem.length - 1);
                    jQuery('div[com-id="' + comId + '"] div.like_count a').siblings('span.image_caption').text(countItem);
                } else {
                    jQuery('div[com-id="' + comId + '"] div.like_count a').siblings('span.image_caption').text('');
                }

                var checkIfLikedCom = jQuery('div#wp-ulike-post-' + comId + ' ' + 'div.wp_ulike_general_class').hasClass('wp_ulike_is_liked');
                if (checkIfLikedCom == true) {
                    //alert('true');
                    jQuery('div[com-id="' + comId + '"] div.like_count a span.like_icon img').attr('src', '/journeys/wp-content/themes/journeys/images/likeh.svg');
                    jQuery('div[com-id="' + comId + '"] div.like_count a span.like_icon img').attr('title', 'unlike');
                    jQuery('div[com-id="' + comId + '"] div.like_count a span.like_icon').attr('title', 'unlike');
                } else {
                    jQuery('div[com-id="' + comId + '"] div.like_count a span.like_icon img').attr('src', '/journeys/wp-content/themes/journeys/images/like.svg');
                    jQuery('div[com-id="' + comId + '"] div.like_count a span.like_icon img').attr('title', 'like');
                    jQuery('div[com-id="' + comId + '"] div.like_count a span.like_icon').attr('title', 'like');
                }

            });
        }
    });

});
//like-unlike for comments ends

//social login redirect
jQuery(window).on('load', function() {
    if (window.location.pathname == "/journeys/login/") {
        var prevURL = document.referrer;
        localStorage.setItem("prev_url", prevURL);
    } else if ((localStorage.getItem("prev_url") != '') && (window.location.pathname != "/journeys/")) {
        localStorage.removeItem("prev_url");
    }
    if (document.getElementsByClassName("magLogOut").length > 0) { //check login
        if ((localStorage.getItem("prev_url") != '') && (localStorage.getItem("prev_url") != null)) { // chk if prev url exist
            if (localStorage.getItem("prev_url").substr(localStorage.getItem("prev_url").length - 10) != '/journeys/') { // chk if not home page
                var prevURL = localStorage.getItem("prev_url");
                localStorage.removeItem("prev_url");
                window.location = prevURL;
            }
        }
    }
    jQuery(document).ready(function() {
        jQuery('a#fblogin').click(function(e) {

        });
    });
});

/**
 * Vertical Landing Page More Section Functions Start
 */
$ = jQuery;
$(window).on('load', function() {
    var theCategorySelectOption = $("[data-name='vertical_landing_more_categories']").find("select");
    var theFeaturedArticleSelectOption = $("[data-name='vertical_landing_more_featured_article']").find("select");
    $('#loading').css('background-color', 'red');
    var i = 0;
    var j = 0;
    $(theCategorySelectOption).each(function() {
        $(this).attr('data-catId', j);
        $(this).addClass('verticalLandingPageMoreCategoriesSelect');
        j++;
    });
    $(theFeaturedArticleSelectOption).each(function() {
        $(this).attr('data-faId', i);
        $(this).addClass('verticalLandingPageMoreFeaturedArticleSelect' + i);
        i++;
    });
    $('.verticalLandingPageMoreCategoriesSelect').each(function(i, obj) {

        var selectDataId = $(this).data('catid');
        console.log(selectDataId);
        getMoreCategoryFromSelect(this, true);
    });
    if ($('select[class^="verticalLandingPageMoreCategoriesSelect"]')) {
        $('select[class^="verticalLandingPageMoreCategoriesSelect"]').change(function() {
            getMoreCategoryFromSelect(this, false);
        });
    }
});

/**
 * 
 * @param {is the seelcte element which will be populated will be populated with the options we get from the database} theThis 
 * @param {boolean values to get the options on window load for the select and show the selected values which was earlier saved} getCatsForOnLoadAsItWillGetAlreadySelectedValues 
 */
function getMoreCategoryFromSelect(theThis, getCatsForOnLoadAsItWillGetAlreadySelectedValues) {
    jQuery('#loading').fadeIn();
    var selected = $(theThis).find(":selected");
    var selectNum = $(theThis).data('catid');
    var selectedCat = selected.text();
    // console.log(theThis);
    // console.log(selected);
    var featuredArticleSelect = $('[class^="verticalLandingPageMoreFeaturedArticleSelect' + selectNum + '"');
    // console.log(featuredArticleSelect);

    getCatIdBySlug(selectedCat, featuredArticleSelect, getCatsForOnLoadAsItWillGetAlreadySelectedValues, selectNum);
    // console.log(typeof categoryID);	
}
/**
 * 
 * @param {string slug for the category you want to get the ID for} categorySlug 
 * @param {is the seelcte element which will be populated will be populated with the options we get from the database} theElement 
 * @param {boolean values to get the options on window load for the select and show the selected values which was earlier saved} pageID 
 * @param {int from the data attribute of the select whose sibling we will populate on the bases of this number} selectDataId 
 */
function getCatIdBySlug(categorySlug, theElement, pageID, selectDataId) {
    var catID = null;
    jQuery.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            "action": "getArticlesForCatSlug",
            "categorySlug": categorySlug
        },
        success: function(response) {
            catID = response.category.term_id;
            console.log(catID);
            if (pageID) {
                var currPageID = getQueryParam('post');
                getArticlesForMoreCategoryWithTheOptionSelected(catID, false, theElement, currPageID, selectDataId);
            } else {
                getArticlesForMoreCategory(catID, false, theElement);
            }
            return catID;
        },
        error: function(data) {
            console.log("FAILURE");
        }
    });

}
/**
 * 
 * @param {id of the category you want to get the articles for} categoryID 
 * @param {if you want to get articles for the collection} doGetArticlesforCollection 
 * @param {this function get the select element and echoes from backend the options which will fill up this select, but you can modify it for other elements as well by maybe hooking someother function from php} theElement 
 */
function getArticlesForMoreCategory(categoryID, doGetArticlesforCollection, theElement) {
    // jQuery('#loading').fadeIn();
    jQuery.ajax({
        url: ajaxurl + "?action=getArticlesForCat",
        type: 'POST',
        data: {

            "categoryID": categoryID,
        },
        success: function(response) {
            console.log(response);

            jQuery('#loading').fadeOut();
            theElement.each(function(i, obj) {
                jQuery(this).empty();
                jQuery(this).append(response);
            });

            if (doGetArticlesforCollection == true) {
                getArticlesForCollection();
            }
            //console.log("SUCCESS!");
        },
        error: function(data) {
            console.log("FAILURE");
        }
    });
}
/**
 * 
 * @param {id of the category you want to get the articles for} categoryID 
 * @param {if you want to get articles for the collection} doGetArticlesforCollection 
 * @param {HTMLElementInThisCaseTypeSelect get the select element and echoes from backend the options which will fill up this select, but you can modify it for other elements as well by maybe hooking someother function from php} theElement 
 * @param{this is the id of the current page which is a post type. we will get the id and accordingly populate and make the appropriate option selected}pageID
 * @param{this is being used to get the sequence of selects and their corresponding selects which will contain the articles and will show the selected one from before}selectedDataID
 */
function getArticlesForMoreCategoryWithTheOptionSelected(categoryID, doGetArticlesforCollection, theElement, pageID, selectedDataID) {
    jQuery.ajax({
        url: ajaxurl + "?action=getArticlesForCatAndMakeTheAppropriateOptionSelected",
        type: 'POST',
        data: {

            "categoryID": categoryID,
            "pageID": pageID,
            "selectedDataID": selectedDataID
        },
        success: function(response) {
            console.log(response);

            jQuery('#loading').fadeOut();
            theElement.each(function(i, obj) {
                jQuery(this).empty();
                jQuery(this).append(response);
            });

            if (doGetArticlesforCollection == true) {
                getArticlesForCollection();
            }
            //console.log("SUCCESS!");
        },
        error: function(data) {
            console.log("FAILURE");
        }
    });
}

function getQueryParam(param) {
    location.search.substr(1)
        .split("&")
        .some(function(item) { // returns first occurence and stops
            return item.split("=")[0] == param && (param = item.split("=")[1])
        })
    return param
}


jQuery('input#publish, input#save-post').click(function(e) {

    if (jQuery('select#page_template').length > 0) {
        var vlpTemplateName = jQuery('select#page_template option[selected="selected"]').text();

        if (vlpTemplateName == 'Vertical Landing Template') {
            var wasCatsDuplicatedInMoreCatsSection = false;
            var wasFearuredArticleDuplicatedInMoreCatsSection = false;
            var wasSubNav1stColItemsDuplicatedForMore = false;
            var wasSubNav1stColItemsDuplicatedForCollections = false;
            var wasSubNav2ndColItemsDuplicatedForCats = false;
            var wasMoreCatsAndVlpSubNav2ndColItemsCatsDuplicated = false;
            var wasMoreChosenInVlpSubNav1stColItems = false;

            var vlpSubNav1stColItemsForMoreCatsArray = [];
            jQuery('div.vlp-sub-nav-all-items td.vlp-sub-nav-1st-col-items input[value="more"]').each(function(index) {

                //if(index > 2) { return false; }
                if (jQuery(this).is(':checked')) {
                    //console.log(jQuery(this).val());
                    vlpSubNav1stColItemsForMoreCatsArray.push(jQuery(this).val());
                }

                //console.log(vlpSubNav1stColItemsArray[index]);
                if (vlpSubNav1stColItemsForMoreCatsArray.length) {
                    //e.preventDefault();
                    wasMoreChosenInVlpSubNav1stColItems = true;
                } else {
                    wasMoreChosenInVlpSubNav1stColItems = false;
                }
            });


            var moreCatsArray = [];
            var moreCatsFeaturedArticlesArray = [];
            if (wasMoreChosenInVlpSubNav1stColItems == true) {
                jQuery('div.vlp-more-cats td.vlp-more-cats-categories select.verticalLandingPageMoreCategoriesSelect').each(function(index) {
                    //console.log(index);
                    if (index > 2) { return false; }
                    moreCatsArray.push(jQuery(this).val());
                    //console.log(moreCatsArray[index]);
                    if (moreCatsArray.length != jQuery.unique(moreCatsArray).length) {
                        e.preventDefault();
                        wasCatsDuplicatedInMoreCatsSection = true;
                        alert('Select distinct categories within more categories section');
                        return false;
                    } else {
                        wasCatsDuplicatedInMoreCatsSection = false;

                    }
                });


                if (wasCatsDuplicatedInMoreCatsSection == false) {
                    jQuery('div.vlp-more-cats td.vlp-more-cats-featured-articles select').each(function(index) {

                        if (index > 2) { return false; }
                        moreCatsFeaturedArticlesArray.push(jQuery(this).val());

                        if (moreCatsFeaturedArticlesArray.length != jQuery.unique(moreCatsFeaturedArticlesArray).length) {
                            e.preventDefault();
                            wasFearuredArticleDuplicatedInMoreCatsSection = true;
                            alert('Select distinct featured articles within more categories section');
                            return false;
                        } else {
                            wasFearuredArticleDuplicatedInMoreCatsSection = false;
                        }
                    });

                }
            }


            var vlpSubNav1stColItemsArrayForMore = [];
            if (wasCatsDuplicatedInMoreCatsSection == false && wasFearuredArticleDuplicatedInMoreCatsSection == false) {
                jQuery('div.vlp-sub-nav-all-items td.vlp-sub-nav-1st-col-items input[value="more"]').each(function(index) {

                    //if(index > 2) { return false; }
                    if (jQuery(this).is(':checked')) {
                        //console.log(jQuery(this).val());
                        vlpSubNav1stColItemsArrayForMore.push(jQuery(this).val());
                    }


                    if (vlpSubNav1stColItemsArrayForMore.length != jQuery.unique(vlpSubNav1stColItemsArrayForMore).length) {
                        e.preventDefault();
                        wasSubNav1stColItemsDuplicatedForMore = true;
                        alert('More cannot be chosen more than once within 1st column of sub-nav section');
                        return false;
                    } else {
                        wasSubNav1stColItemsDuplicatedForMore = false;
                    }
                });

            }

            var vlpSubNav1stColItemsArrayForCollections = [];
            if (wasCatsDuplicatedInMoreCatsSection == false && wasFearuredArticleDuplicatedInMoreCatsSection == false && wasSubNav1stColItemsDuplicatedForMore == false) {
                jQuery('div.vlp-sub-nav-all-items td.vlp-sub-nav-1st-col-items input[value="collections"]').each(function(index) {

                    //if(index > 2) { return false; }
                    if (jQuery(this).is(':checked')) {

                        vlpSubNav1stColItemsArrayForCollections.push(jQuery(this).val());
                    }


                    if (vlpSubNav1stColItemsArrayForCollections.length != jQuery.unique(vlpSubNav1stColItemsArrayForCollections).length) {
                        e.preventDefault();
                        wasSubNav1stColItemsDuplicatedForCollections = true;
                        alert('Collections cannot be chosen more than once within 1st column of sub-nav section');
                        return false;
                    } else {
                        wasSubNav1stColItemsDuplicatedForCollections = false;
                    }
                });

            }

            var vlpSubNav1stColItemsArrayForCategory = [];
            jQuery('div.vlp-sub-nav-all-items td.vlp-sub-nav-1st-col-items input[value="category"]').each(function(index) {

                //if(index > 2) { return false; }
                if (jQuery(this).is(':checked')) {
                    //console.log(jQuery(this).val());
                    vlpSubNav1stColItemsArrayForCategory.push(jQuery(this).val());
                }
            });

            var vlpSubNav2ndColItemsArrayForCats = [];
            if (wasCatsDuplicatedInMoreCatsSection == false && wasFearuredArticleDuplicatedInMoreCatsSection == false && wasSubNav1stColItemsDuplicatedForMore == false && wasSubNav1stColItemsDuplicatedForCollections == false) {
                jQuery('div.vlp-sub-nav-all-items td.vlp-sub-nav-2nd-col-items select').each(function(index) {

                    if (!jQuery(this).parents('td').hasClass('hidden-by-conditional-logic')) {
                        console.log(jQuery(this).val());
                        var checkIdOfSelect = jQuery(this).attr('id');
                        if (!(checkIdOfSelect.indexOf("acfcloneindex") > -1)) {
                            vlpSubNav2ndColItemsArrayForCats.push(jQuery(this).val());
                        }
                    }



                    if (vlpSubNav2ndColItemsArrayForCats.length != jQuery.unique(vlpSubNav2ndColItemsArrayForCats).length) {
                        e.preventDefault();
                        wasSubNav2ndColItemsDuplicatedForCats = true;
                        alert('Chosen category cannot be chosen more than once within 2nd column of sub-nav section');
                        return false;
                    } else {
                        wasSubNav2ndColItemsDuplicatedForCats = false;
                    }
                });

            }

            var mergedMoreCatsAndVlpSubNav2ndColItemsCatsArray = [];
            if (wasCatsDuplicatedInMoreCatsSection == false && wasFearuredArticleDuplicatedInMoreCatsSection == false && wasSubNav1stColItemsDuplicatedForMore == false && wasSubNav1stColItemsDuplicatedForCollections == false && wasSubNav2ndColItemsDuplicatedForCats == false) {

                mergedMoreCatsAndVlpSubNav2ndColItemsCatsArray = jQuery.merge(jQuery.unique(moreCatsArray), jQuery.unique(vlpSubNav2ndColItemsArrayForCats));

                if (mergedMoreCatsAndVlpSubNav2ndColItemsCatsArray.length != jQuery.unique(mergedMoreCatsAndVlpSubNav2ndColItemsCatsArray).length) {
                    e.preventDefault();
                    wasMoreCatsAndVlpSubNav2ndColItemsCatsDuplicated = true;
                    alert('Duplicate categories cannot be chosen for both the More Cats section and the Sub-nav section');
                    return false;
                } else {
                    wasMoreCatsAndVlpSubNav2ndColItemsCatsDuplicated = false;
                }

            }


        }
    }
});


function getCloudinaryURLWithARParams(isCloudinaryURL, imageSrc, isForAuthor, isAtSRP) {
    if (isCloudinaryURL > -1) {
        //console.log('in');
        var betweenAfterAndBeforeUploadStr = '';
        var beforeUploadStr = imageSrc.split('upload')[0];
        var afterUploadStr = imageSrc.split('upload')[1];
        if (isAtSRP == true) {
            if (isForAuthor == true) {
                betweenAfterAndBeforeUploadStr = 'upload/c_fill,ar_1:1,g_auto/w_120,q_auto,f_auto';
            } else {
                betweenAfterAndBeforeUploadStr = 'upload/c_fill,ar_1:1,g_auto/w_750,q_auto,f_auto';
                //console.log('SRP Param = '+betweenAfterAndBeforeUploadStr);
            }
        } else {
            if (isForAuthor == true) {
                betweenAfterAndBeforeUploadStr = 'upload/c_fill,ar_1:1,g_auto/w_50,q_auto,f_auto';
            } else {
                betweenAfterAndBeforeUploadStr = 'upload/c_fill,ar_4:3,g_auto/w_50,q_auto,f_auto';
            }

        }

        return beforeUploadStr + betweenAfterAndBeforeUploadStr + afterUploadStr;
    } else {
        return imageSrc;
    }
}
/////////////function to add intel params to the cloudinary image srcs ends