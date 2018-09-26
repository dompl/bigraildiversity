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
      vc_add_shortcode_param('custom_radio', array(&$this, 'custom_radio_callback'));
    }

    /**
     * Custom radio buttons
     * ---
     */

    public function custom_radio_callback($settings, $value) {
      $output        = '';
      $current_value = is_string($value) ? (strlen($value) > 0 ? explode(',', $value) : array()) : (array) $value;
      $values        = isset($settings['value']) && is_array($settings['value']) ? $settings['value'] : array(__('Yes') => 'true');
      if ( ! empty($values)) {
        foreach ($values as $label => $v) {
          $checked = count($current_value) > 0 && in_array($v, $current_value) ? ' checked' : '';
          $output .= ' <label class="vc_radio-label"><input style="width:auto" id="' . $settings['param_name'] . '-' . $v . '" value="' . $v . '" class="wpb_vc_param_value ' . $settings['param_name'] . ' ' . $settings['type'] . '" type="radio" name="' . $settings['param_name'] . '"' . $checked . '> ' . $label . '</label>';
        }
      }
      return $output;
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