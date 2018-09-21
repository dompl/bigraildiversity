<?php
/*  ********************************************************
 *   Custom elements for visual composer
 *  ********************************************************
 */
namespace config\visual_composer;
if ( ! defined('ABSPATH')) {
  die('-1');
}
use config\visual_composer\Visual_Composer_Additional_Params;

if ( ! class_exists('Visual_Composer_Custom_Elements')) {

  class Visual_Composer_Custom_Elements extends Visual_Composer_Additional_Params {

    public function __construct() {
      vc_add_shortcode_param('image_sizer_width', array(&$this, 'image_sizer_width_callback'));
      vc_add_shortcode_param('image_sizer_height', array(&$this, 'image_sizer_height_callback'));
    }

    /* Image height */
    public function image_sizer_height_callback($settings, $value) {

      $param = sprintf('<div class="vc_image_sizer image_sizer_height"><input name="%1$s" type="number" class="wpb_vc_param_value wpb-textinput %1$s %2$s_field" value="%3$s" /><span class="vc_px">px</span></div>',
        esc_attr($settings['param_name']),
        esc_attr($settings['type']),
        esc_attr($value)
      );

      return $param;

    }

    /* Image width */
    public function image_sizer_width_callback($settings, $value) {

      $param = sprintf('<div class="vc_image_sizer image_sizer_width"><input name="%1$s" type="number" class="wpb_vc_param_value wpb-textinput %1$s %2$s_field" value="%3$s" /><span class="vc_px">px</span></div>',
        esc_attr($settings['param_name']),
        esc_attr($settings['type']),
        esc_attr($value)
      );
      return $param;

    }

  }
}