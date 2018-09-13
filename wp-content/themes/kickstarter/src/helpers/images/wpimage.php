<?php

if ( ! function_exists('wpimage')) {

    /**
     * This is just a tiny wrapper function for the class above so that there is no
     * need to change any code in your own WP themes. Usage is still the same :)
     *
     * Sample usage - Retina
     * @var $blank        = wpimagebase(); // Small balnk gif 1x1px
     * @var $image_alt    = imagedata($image_ID)['alt']; // Image alt
     * @var $image_retina = wpimage("image=$image_ID&w=100&retina=true"); // Image src. This can be URL or ID. Has to be coming from media library
     * <img src="<?php echo $blank; ?>" data-src="<?php echo $image_retina ?>" alt="<?php echo $image_alt ?>" class="lazy" />
     *
     * Sample usage - Non Retina
     * @var $blank        = wpimagebase(); // Small balnk gif 1x1px
     * @var $image_alt    = imagedata($image_ID)['alt']; // Image alt
     * @var $image        = wpimage("image=$image_ID&w=100"); // Image src. This can be URL or ID. Has to be coming from media library
     * <img src="<?php echo $image ?>" alt="<?php echo $image_alt ?>" />
     */
    // function wpimage($attachment, $width = null, $height = null, $crop = null, $single = true, $upscale = false) {
    function wpimage($args = array()) {

        $defaults = array(
            'img'     => '',
            'w'       => 100,
            'h'       => null,
            'crop'    => true,
            'retina'  => false,
            'single'  => true,
            'upscale' => true,
        );

        /* Parasa array for wordpress */
        $args = wp_parse_args($args, $defaults);

        $args['crop']    = filter_var($args['crop'], FILTER_VALIDATE_BOOLEAN);
        $args['retina']  = filter_var($args['retina'], FILTER_VALIDATE_BOOLEAN);
        $args['single']  = filter_var($args['single'], FILTER_VALIDATE_BOOLEAN);
        $args['upscale'] = filter_var($args['upscale'], FILTER_VALIDATE_BOOLEAN);

        if ($args['img'] == '') {
            return;
        }

        /* Check is image id is provided and convert it to URL */
        if (is_numeric($args['img'])) {
            $args['img'] = wp_get_attachment_url($args['img'], 'full');
        }

        /* WPML Fix */
        if (defined('ICL_SITEPRESS_VERSION')) {
            global $sitepress;
            $args['img'] = $sitepress->convert_url($args['img'], $sitepress->get_default_language());
        }

        $aq_resize = Aq_Resize::getInstance();

        $image = $aq_resize->process(
            $args['img'],
            (int) $args['w'],
            (int) $args['h'],
            $args['crop'],
            $args['single'],
            $args['upscale']
        );

        if ($args['retina'] === true) {
            $image .= '+';
            $image .= $aq_resize->process(
                $args['img'],
                (int) $args['w'] * 2,
                (int) $args['h'] * 2,
                $args['crop'],
                $args['single'],
                $args['upscale']
            );
        }

        return $image;
    }
}
/* Image base */
function wpimagebase() {
    return 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
}
