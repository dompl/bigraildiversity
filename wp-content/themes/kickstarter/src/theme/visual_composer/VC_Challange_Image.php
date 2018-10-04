<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;
use WP_Screen;
if ( ! class_exists('VC_Challange_Image')) {

  class VC_Challange_Image extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_Challange_Image_section_map'));
      add_shortcode('VC_Challange_Image_shortcode', array(&$this, 'VC_Challange_Image_shortcode_callback'));
    }

    /**
     * Params
     * ---
     */
    public function params() {

      $params = array(
        $this->param_space('above'),
        $this->param_space('below', 'Default'),
        $this->prevent_space_on_mobile(),
        $this->param_additional_id('custom_id'),
        $this->param_additional_class('custom_class'),
      );
      return $params;
    }

    /**
     * Visual Composer Map
     * ---
     */
    public function VC_Challange_Image_section_map() {

      $title       = 'Page image';                       // Shortcode description
      $description = 'Display image from page settings'; // Shortcode Name

      vc_map(
        array(
          'name'                    => __($title, 'TEXT_DOMAIN'),
          'base'                    => 'VC_Challange_Image_shortcode',
          'class'                   => '',
          'show_settings_on_create' => false,
          'category'                => $this->tab_category(),
          'icon'                    => $this->icon('icon-image.svg'),
          'description'             => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css'       => $this->admin_css(),
          'params'                  => $this->params(),
        )
      );
    }

    public function VC_Challange_Image_shortcode_callback($atts, $content = null) {

      if (get_field('challenge_main_image') != '') {
        $image = get_field('challenge_main_image');
      } elseif (get_field('add_attendee_logo')) {
        $image = get_field('add_attendee_logo');
      } else {
        return;
      }

      extract(shortcode_atts(array(
        'animation'    => '',
        'space_above'  => __('None', 'TEXT_DOMAIN'),
        'space_below'  => __('Default', 'TEXT_DOMAIN'),
        'custom_class' => '',
        'custom_id'    => '',
      ), $atts));

      $item         = '';
      $custom_class = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id    = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      $item .= $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';
      $item .= '<div class="' . $this->pixels_class($space_above, 'spacer-top') . ' ' . $this->pixels_class($space_below, 'spacer-bottom') . '">';

      $item .= sprintf('<img src="%s" data-src="%s" alt="%s" class="lazy">',
        wpimagebase(),
        wpimage('img=' . $image . '&height=900&w=600&upscale=true&crop=true&single=true&retina=true'),
        the_title_attribute('echo=0&posts=' . get_the_ID())
      );
      $item .= '</div>';
      $item .= $custom_class || $custom_id ? '</div>' : '';

      return $item;
    }
  }

}