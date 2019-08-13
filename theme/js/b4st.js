/**!
 * b4st JS
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        affix();
        book_joruney();
        swiperexperience();
        swipercause();
        swiperpersonalise();
        storiesSlider();
        getCurrentScroll();
        addClasses();
        searchFocus();
        searchFunt();
    });

}(jQuery));


function searchFunt() {
    $(".suggesIcon").on('click', function() {
        if (jQuery('.serpop').length >= 1 && jQuery('.no-scroll').length >= 1) {
            jQuery('.searchPop').removeClass('serpop');
            jQuery('html').removeClass('no-scroll');
            jQuery('.searchPop').css('visibility', 'hidden');
            jQuery('.nav_menu').css('display', 'none');
            jQuery('.stop-scroll .fa.fa-bars').addClass('no-after');
            jQuery('html').removeClass('stop-scroll');
            jQuery('.suggesIcon').removeClass('closeser');
            jQuery('.searchPop').removeClass('showsSearch');
            jQuery('.searInner').removeClass('bgBlock');
            jQuery('header').removeClass('search-open');
            jQuery('.navbar-toggler').css('display', 'block');
        } else {
            jQuery('.searchPop').addClass('serpop');
            jQuery('html').addClass('no-scroll');
            jQuery('.nav_menu').css('display', 'none');
            jQuery('.searchPop').css('visibility', 'visible');
            jQuery('.no-scroll .fa.fa-bars').removeClass('no-after');
            jQuery('.stop-scroll .fa.fa-bars').removeClass('no-after');
            jQuery('.suggesIcon').addClass('closeser');
            jQuery('.stop-scroll .fa.fa-bars').addClass('no-after');
            jQuery('.searchPop').addClass('showsSearch');
            jQuery('.searInner').addClass('bgBlock');
            jQuery('header').addClass('search-open');
            jQuery('nav').removeClass('menucolor');
            jQuery('.navbar-collapse').removeClass('show');
            jQuery('.navbar-toggler').css('display', 'none');

        }
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });

    $(".nav-wrap .fa.fa-bars").on('click', function() {
        if (jQuery('.serpop').length >= 1) {
            jQuery('.suggesIcon').removeClass('closeser');
            jQuery('html').removeClass('no-scroll');
            jQuery('.searchPop').css('visibility', 'hidden');
            jQuery('.searchPop').removeClass('serpop');
        } else {
            jQuery('.searchPop').addClass('serpop');
        }
        jQuery('.searInner').removeClass('bgBlock');
        jQuery('.searchPop').addClass('serpop');
        jQuery('.stop-scroll .fa.fa-bars').removeClass('no-after');
    });
}


function searchFocus() {
    $(".srch_icn").click(function() {
        jQuery("#suggestiveSearchInput").focus();
    });
}

function afterModalTransition(e) {
    e.setAttribute("style", "display: none !important;");
}
$('#myBook').on('hide.bs.modal', function(e) {
    setTimeout(() => afterModalTransition(this), 500);
});


function affix() {
    var shrinkHeader = 100;
    $(window).scroll(function() {
        var scroll = getCurrentScroll();
        if (scroll >= shrinkHeader) {
            $('header').addClass('shrink');
            $(".b-search").css("display", "block");
            $(".w-search").css("display", "none");

        } else {
            $('header').removeClass('shrink');
            $(".b-search").css("display", "none");
            $(".w-search").css("display", "block");
        }
    });
}





function swiperexperience() {

    $('.swiper-slide-prev .swiper-slide-exp-mobile').css('visibility', 'hidden');
    $('.swiper-slide-next .swiper-slide-exp-mobile').css('visibility', 'hidden');

    var swiper_experience = new Swiper('.swiper-container-experience', {
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
        loop: true,
        loopedSlides: 20,
        autoplay: 6000,
        autoplayDisableOnInteraction: true
    });

    swiper_experience.on('slideChangeTransitionStart ', function() {
        $('.swiper-slide-prev .swiper-slide-exp-mobile').css('visibility', 'hidden');
        $('.swiper-slide-next .swiper-slide-exp-mobile').css('visibility', 'hidden');
        $('.swiper-slide-active .swiper-slide-exp-mobile').css('visibility', 'visible');
    });
}

function swipercause() {
    var swiper_cause = new Swiper('.swiper-container-cause', {
        loop: true,
        spaceBetween: 5,
    });
}

function swiperpersonalise() {
    var swiper_per = new Swiper('.swiper-container-personalise', {
        loop: true,
        spaceBetween: 5,
    });
}

function storiesSlider() {

    var swiper_stories = new Swiper('.stories-slider', {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: false,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            1181: {
                slidesPerView: 3
            },
            1180: {
                slidesPerView: 3
            },
            1020: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            700: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }

    });
}


function getCurrentScroll() {
    return window.pageYOffset || document.documentElement.scrollTop;
}

function addClasses() {

    // Comments

    $('.commentlist li').addClass('card');
    $('.comment-reply-link').addClass('btn btn-secondary');

    // Forms

    $('select, input[type=text], input[type=email], input[type=password], textarea').addClass('form-control');
    $('input[type=submit]').addClass('btn btn-primary');
    $('.js-show-help').removeClass('form-control');


    // Pagination fix for ellipsis

    $('.pagination .dots').addClass('page-link').parent().addClass('disabled');
}

function book_joruney() {
    jQuery('body').on("click", '.bkform', function() {
        var journey_imageurl = $(this).data('image');
        var journey_imageurl_mobile = journey_imageurl.replace("ar_0.53", "ar_1.47");
        var journey_name = $(this).data('title');
        var journey_city = $(this).data('city');

        jQuery("#modal-desktop-img").attr('src', journey_imageurl);
        jQuery("#modal-mobile-img").attr('src', journey_imageurl_mobile);
        jQuery("#modal-journey-title").text(journey_name);
        jQuery("#modal-journey-city").text(journey_city);

    });
}