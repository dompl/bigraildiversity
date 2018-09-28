<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_BRDC_Image_Gallery')) {

  class VC_BRDC_Image_Gallery extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_Image_Gallery_section_map'));
      add_shortcode('VC_BRDC_Image_Gallery_shortcode', array(&$this, 'VC_BRDC_Image_Gallery_shortcode_callback'));
    }

    /**
     * Params
     * ---
     */
    public function params() {

      $params = array(
        array(
          'type'        => 'attach_images',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Gallery images', 'TEXT_DOMAIN'),
          'param_name'  => 'images',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => '',
          'description' => __('Add images to your gallery', 'TEXT_DOMAIN'),
        ),
        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'admin_label' => true,
          'heading'     => __('Gallery Type', 'TEXT_DOMAIN'),
          'param_name'  => 'gallery_type',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Mosaic', 'TEXT_DOMAIN') => 'mosaic',
            __('Slider', 'TEXT_DOMAIN') => 'slider',
          ),
          'description' => __('How would you like to display your gallery?', 'TEXT_DOMAIN'),
          'std'         => 'mosaic',
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Lightbox', 'TEXT_DOMAIN'),
          'param_name'  => 'open_in_lightbox',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Open in gallery in lightbox', 'TEXT_DOMAIN') => true,
          ),
          'description' => __('Open lightbox for your gallery', 'TEXT_DOMAIN'),
          'std'         => true,
        ),
        array(
          'type'        => 'numeric',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Target row height', 'TEXT_DOMAIN'),
          'param_name'  => 'row_height',
          'group'       => __('Gellery settings', 'TEXT_DOMAIN'),
          'value'       => '',
          'description' => __('Desired row height in pixels, e.g. 200 (without px).', 'TEXT_DOMAIN'),
          'dependency'  => array(
            'element' => 'gallery_type',
            'value'   => array('mosaic'),
          ),
        ),
        array(
          'type'        => 'numeric',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Spacing between the thumbnails', 'TEXT_DOMAIN'),
          'param_name'  => 'thumbs_spacing',
          'group'       => __('Gellery settings', 'TEXT_DOMAIN'),
          'value'       => 5,
          'description' => __('Enter a number like 0, 1, 4 or 10 (without px).', 'TEXT_DOMAIN'),
          'dependency'  => array(
            'element' => 'gallery_type',
            'value'   => array('mosaic'),
          ),
        ),
        array(
          'type'        => 'textfield',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Thumbnail aspect ratio', 'TEXT_DOMAIN'),
          'param_name'  => 'aspect_ratio',
          'group'       => __('Gellery settings', 'TEXT_DOMAIN'),
          'value'       => '',
          'description' => __('To crop your thumbs enter a ratio: 1, 1:1 or 1/1 (square) 2.35:1 or 16:9 (wide), 4/3, 1.5 or similar - to lock it, look at the next setting.', 'TEXT_DOMAIN'),
          'dependency'  => array(
            'element' => 'gallery_type',
            'value'   => array('mosaic'),
          ),
        ),
        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Disable cropping', 'TEXT_DOMAIN'),
          'param_name'  => 'disable_cropping',
          'group'       => __('Gellery settings', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Default', 'TEXT_DOMAIN')                                                 => 'default',
            __('No, respect the row height and allow some cropping.', 'TEXT_DOMAIN')     => 'no',
            __('Yes, lock aspect ratio and use 50px minimum row height.', 'TEXT_DOMAIN') => 'yes',
            __('Yes, but only on mobile devices.', 'TEXT_DOMAIN')                        => 'yes-mobile',
            __('Gellery settings', 'TEXT_DOMAIN')                                        => '',
          ),
          'description' => __('Use this to avoid cropping or to lock your selected aspect ratio.', 'TEXT_DOMAIN'),
          'std'         => 'default',
          'dependency'  => array(
            'element' => 'gallery_type',
            'value'   => array('mosaic'),
          ),
        ),

      );

      $params[] = array(
        'type'        => 'numeric',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'admin_label' => false,
        'heading'     => __('Image height in slider', 'TEXT_DOMAIN'),
        'param_name'  => 'slides_image_height',
        'group'       => __('Slider Settings', 'TEXT_DOMAIN'),
        'value'       => 100,
        'description' => __('Set image height for your scrolling gallery', 'TEXT_DOMAIN'),
        'std'         => 100,
        'dependency'  => array(
          'element' => 'gallery_type',
          'value'   => array('slider'),
        ),
      );

      foreach ($this->slick_slider_settings() as $value) {
        $value['dependency'] = array(
          'element' => 'gallery_type',
          'value'   => array('slider'),
        );
        $params[] = $value;
      }
      $params[] = $this->param_space('above');
      $params[] = $this->param_space('below');
      $params[] = $this->prevent_space_on_mobile();
      $params[] = $this->param_additional_id('custom_id');
      $params[] = $this->param_additional_class('custom_class');

      return $params;
    }

    /**
     * Visual Composer Map
     * ---
     */
    public function VC_BRDC_Image_Gallery_section_map() {

      $title       = 'Image Gallery';            // Shortcode description
      $description = 'Add custom image gallery'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_BRDC_Image_Gallery_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon('icon-gallery.svg'),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_BRDC_Image_Gallery_shortcode_callback($atts, $content = null) {

      extract(shortcode_atts(array(
        'images'              => '',
        'gallery_type'        => 'mosaic',
        'open_in_lightbox'    => true,
        'initially_load'      => '',
        'row_height'          => '',
        'thumbs_spacing'      => '',
        'aspect_ratio'        => '',
        'disable_cropping'    => 'default',
        'load_more'           => 'off',
        'load_more_text'      => '',
        'load_more_offset'    => '',
        'space_above'         => __('None', 'TEXT_DOMAIN'),
        'space_below'         => __('None', 'TEXT_DOMAIN'),
        'custom_class'        => '',
        'custom_id'           => '',
        'slides_to_show'      => '1',
        'slides_to_scroll'    => '1',
        'slider_center_mode'  => false,
        'slider_infinite'     => true,
        'slider_autoplay'     => true,
        'slider_navigation'   => 'dots',
        'slides_image_height' => 100,
      ), $atts));

      // $href = vc_build_link( $href ); // Build Link
      // $content = wpb_js_remove_wpautop($content, true); // Content
      // $text              = $this->replace_brackets_with_tags($text);
      $item         = '';
      $custom_class = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id    = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      $item .= $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';
      $item .= '<div class="' . $this->pixels_class($space_above, 'spacer-top') . ' ' . $this->pixels_class($space_below, 'spacer-bottom') . '">';

      if ($open_in_lightbox == true) {
        wp_enqueue_script('ks-lightgallery-js', get_template_directory_uri() . '/js/x-lightgallery.js', array('jquery'), '1.6.11', true);
        $item .= '<div class="image-gallery">';
      }

      if ($gallery_type == 'mosaic') {

        /**
         * Mosaic Gallery
         * ---
         */
        //$item .= do_shortcode("[justified_image_grid ids=$images thumbs_spacing=5 row_height=400 caption=off mobile_caption=off caption_match_width=no overlay=off mobile_overlay=off lightbox=custom aspect_ratio=16:9 disable_cropping=no load_more=scroll load_more_text=wefdfs load_more_count_text=none load_more_offset=2 load_more_mobile=scroll initially_load=2]");
        $row_height     = $row_height != '' ? ' row_height=' . $row_height : '';
        $thumbs_spacing = $thumbs_spacing != '' ? ' thumbs_spacing=' . ($thumbs_spacing != '0' ? $thumbs_spacing - 2 : $thumbs_spacing) : ' thumbs_spacing=0';
        // $load_more_offset = $load_more_offset != '' ? ' load_more_offset=' . $load_more_offset : '';
        $aspect_ratio     = $aspect_ratio != '' ? ' aspect_ratio=' . $aspect_ratio : '';
        $disable_cropping = $disable_cropping != 'default' ? ' disable_cropping=' . $disable_cropping : '';
        // $load_more        = $load_more != 'default' ? ' load_more=' . $load_more : 'load_more=off';
        // $load_more_text   = $load_more_text != '' ? ' load_more_text=' . $load_more_text : __('Load more', 'TEXT_DOMAIN');
        // $load_more_offset = $load_more_offset != '' ? ' load_more_offset=' . $load_more_offset : '';

        $item .= do_shortcode('[justified_image_grid ids=' . $images . ' caption=off mobile_caption=off caption_match_width=no overlay=off mobile_overlay=off lightbox=custom load_more=scroll load_more_count_text=none load_more_auto_width=off ' . $aspect_ratio . $thumbs_spacing . $load_more_offset . $row_height . $disable_cropping . ']');

      } else {

        /**
         * Slider gallery
         * ---
         */
        wp_enqueue_script('ks-slick-js', get_template_directory_uri() . '/js/x-slick.js', array('jquery'), '1.6.11', true);

        $slick_settings = '';
        $slick_settings .= '"slidesToShow": ' . $slides_to_show . ', ';
        $slick_settings .= '"slidesToScroll": ' . $slides_to_scroll . ', ';
        $slick_settings .= '"centerMode": ' . ($slider_center_mode ? 'true, ' : 'false, ');
        $slick_settings .= '"infinite": ' . ($slider_infinite ? 'true, ' : 'false, ');
        $slick_settings .= '"autoplay": ' . ($slider_autoplay ? 'true,' : 'false,');

        $slider_navigation = explode(',', $slider_navigation);

        $slick_settings .= in_array('dots', $slider_navigation) ? ' "dots": true,' : '"dots": false,';
        $slick_settings .= in_array('arrows', $slider_navigation) ? ' "arrows": true' : '"arrows": false';

        $item .= '<div class="a-slider"><ul class="list-inline sponsor-slider slick-equal" data-slick=\'{' . $slick_settings . '}\'>';

        $images = explode(',', $images);

        foreach ($images as $image) {

          $height = (int) $slides_image_height / $slides_to_show;
          $width  = 740 / $slides_to_show;

          $item .= sprintf('<li><div class="image"><a href="%1$s" title="%2$s" class="jig-link"><img data-lazy="%3$s" alt="%4$s"></a></div></li>',
            esc_url(imagedata($image)['url']),
            imagedata($image)['alt'],
            wpimage('img=' . (int) $image . '&h=' . $height . '&w=' . $width . '&retina=false&crop=true'),
            ''
          );

        }

        $item .= '</div>';
      }

      $item .= $open_in_lightbox ? '</div>' : '';

      $item .= '</div>';
      $item .= $custom_class || $custom_id ? '</div>' : '';

      return $item;
    }
  }

}