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
            autoplaySpeed: 12000,
        });
        $('.challanges-in-slick').slick({
            lazyLoad: 'ondemand',
            prevArrow: '<i class="icon-chevron-left"></i>',
            nextArrow: '<i class="icon-chevron-right"></i>',
            dots: false,
            arrows:true,
            adaptiveHeight: false,
            autoplay: true,
            autoplaySpeed: 12000,
        });
    });
}(jQuery));
