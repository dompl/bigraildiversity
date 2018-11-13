// ==== FOOTER ==== //
;(function($) {
    $(function() {
        $(".is_lightbox").lightGallery({
            download: false,
            counter: false,
            share: false,
            thumbnail: false,
            getCaptionFromTitleOrAlt: false,
        });
        $(".image-gallery").lightGallery({
            download: false,
            counter: false,
            share: false,
            thumbnail: false,
            getCaptionFromTitleOrAlt: false,
            selector : $(this).find('a'),
            // galleryItems = $(this.s.selectWithin).find(this.s.selector);
        });
    });
}(jQuery));
