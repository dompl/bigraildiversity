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
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Images order', 'TEXT_DOMAIN'),
          'param_name'  => 'orderby',
          'group'       => __('Gellery settings', 'TEXT_DOMAIN'),
          'value'       => array(__('Display images in random order', 'TEXT_DOMAIN') => 'rand'),
          'description' => __('Display gallery in random order.', 'TEXT_DOMAIN'),
          'dependency'  => array(
            'element' => 'gallery_type',
            'value'   => array('mosaic'),
          ),
          'std'         => false,
        ),
        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Image size', 'TEXT_DOMAIN'),
          'param_name'  => 'size',
          'group'       => __('Gellery settings', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Thumbnail', 'TEXT_DOMAIN') => 'thumbnail',
            __('Medium', 'TEXT_DOMAIN')    => 'medium',
            __('Large', 'TEXT_DOMAIN')     => 'large',
            __('Full', 'TEXT_DOMAIN')      => 'Full',
          ),
          'description' => __('Gallery images size', 'TEXT_DOMAIN'),
          'std'         => 'thumbnail',
          'dependency'  => array(
            'element' => 'gallery_type',
            'value'   => array('mosaic'),
          ),
        ),

        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Gallery type', 'TEXT_DOMAIN'),
          'param_name'  => 'type',
          'group'       => __('Gellery settings', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Thumbnail Grid', 'TEXT_DOMAIN') => 'thumbnails',
            __('Tiled Mosaic', 'TEXT_DOMAIN')   => 'rectangular',
            __('Square Tiles', 'TEXT_DOMAIN')   => 'square',
            __('Circles', 'TEXT_DOMAIN')        => 'circle',
          ),
          'description' => __('Set gallery type', 'TEXT_DOMAIN'),
          'std'         => 'rectangular',
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
        'orderby'             => false,
        'size'                => 'thumbnail',
        'size'                => 'thumbnail',
        'type'                => 'rectangular',
        'link'                => 'file',
      ), $atts));

      if ( ! $images) {
        return;
      }

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
        $settings = $orderby ? " orderby=$orderby " : '';
        $settings .= $size ? " size=$size " : '';
        $settings .= $type ? " type=$type " : '';
        $settings .=   $open_in_lightbox ? " link=file " : 'link=none ';

        $item .= do_shortcode('[gallery ' . $settings . ' ids="' . $images . '"]');
        // $item .= do_shortcode('[gallery <span data-mce-type="bookmark" style="display: inline-block; width: 0px; overflow: hidden; line-height: 0;" class="mce_SELRES_start">﻿</span> data-mce-type="bookmark" style="display: inline-block; width: 0px; overflow: hidden; line-height: 0;" ' . $settings . ' ids="' . $images . '"]');

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