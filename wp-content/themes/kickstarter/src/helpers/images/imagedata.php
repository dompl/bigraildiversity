<?php
/**
 * Helper function
 * ---
 * @return array [image attachement info]
 */
if ( ! function_exists('imagedata')) {

    function imagedata($id = '') {

        if ($id == '' || ! is_numeric($id)) {
            return;
        }

        $attachment = get_post($id);

        $array                = wp_get_attachment_image_src($id, 'full');
        $image['src']         = $array[0];
        $image['url']         = $array[0];
        $image['width']       = $array[1];
        $image['height']      = $array[2];
        $image['alt']         = get_post_meta($id, '_wp_attachment_image_alt', true);
        $image['caption']     = $attachment->post_excerpt;
        $image['description'] = $attachment->post_content;
        $image['href']        = esc_url(get_permalink($id));

        wp_reset_postdata();

        return $image;
    }
}
