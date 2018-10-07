// ==== FOOTER ==== //
(function($) {
    $(function() {
        $('.company-name-att').fitText(1.2, {
            minFontSize: '10px',
            maxFontSize: '14px'
        });
        $('.sponsor-slider').slick({
            lazyLoad: 'ondemand',
            prevArrow: '<i class="icon-chevron-left"></i>',
            nextArrow: '<i class="icon-chevron-right"></i>',
        });
        $('.testimonial-slider').slick({
            lazyLoad: 'ondemand',
            prevArrow: '<i class="icon-chevron-left"></i>',
            nextArrow: '<i class="icon-chevron-right"></i>',
            slidesToShow: 1,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 3000,
        });
        $('.challanges-in-slick').slick({
            lazyLoad: 'ondemand',
            prevArrow: '<i class="icon-chevron-left"></i>',
            nextArrow: '<i class="icon-chevron-right"></i>',
            dots: false,
            arrows: true,
            adaptiveHeight: false,
            autoplay: true,
            autoplaySpeed: 3000,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                    }
                }, {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }, {
                    breakpoint: 360,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
        $('.page-image-slider').slick({
            lazyLoad: 'ondemand',
            prevArrow: '<i class="icon-chevron-left"></i>',
            nextArrow: '<i class="icon-chevron-right"></i>',
            slidesToShow: 1,
            adaptiveHeight: true,
            fade: true,
            autoplay: false,
            autoplaySpeed: 3000,
        });
    });
}(jQuery));
