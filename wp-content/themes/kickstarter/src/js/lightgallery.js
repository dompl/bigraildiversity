// ==== FOOTER ==== //
;
(function($) {
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
            selector : '.jig-link'
        });
    });
}(jQuery));
