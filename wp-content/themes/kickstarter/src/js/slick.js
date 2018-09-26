// ==== FOOTER ==== //
;
(function($) {
    $(function() {
        $('.company-name-att').fitText(1.2, {
            minFontSize: '10px',
            maxFontSize: '14px'
        });;
        $('.sponsor-slider').slick({
            lazyLoad: 'ondemand',
            prevArrow: '<i class="icon-chevron-left"></i>',
            nextArrow: '<i class="icon-chevron-right"></i>',
        });
    });
}(jQuery));
