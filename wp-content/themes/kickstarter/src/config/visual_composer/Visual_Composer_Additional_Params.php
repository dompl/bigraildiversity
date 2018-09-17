<?php

namespace config\visual_composer;

if ( ! class_exists('Visual_Composer_Additional_Params')) {

  class Visual_Composer_Additional_Params {

    public function __construct() {}

    /* Text Alignment */
    public function param_text_alignment($param_name = 'align') {

      return array(
        'type'        => 'dropdown',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'heading'     => __('Text alignment', 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __('Settings', 'TEXT_DOMAIN'),
        'value'       => array('Left', 'Center', 'Right'),
        'description' => __('Set alignment', 'TEXT_DOMAIN'),
        'std'         => 'Left',
      );
    }

    /* Font sizes */
    public function param_font_sizes($param_name = 'font_size') {
      array(
        'type'        => 'dropdown',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'heading'     => __('Font size', 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __('Settings', 'TEXT_DOMAIN'),
        'value'       => $this->font_sizes(),
        'description' => __('Set font size', 'TEXT_DOMAIN'),
        'std'         => '16px',
      );
    }

    /* Colours */
    public function param_colors($param_name = 'color') {
      array(
        'type'        => 'dropdown',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'heading'     => __('Colour', 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __('Settings', 'TEXT_DOMAIN'),
        'value'       => $this->brdc_colours(),
        'description' => __('Set colour', 'TEXT_DOMAIN'),
        'std'         => 'Default',
      );
    }

    /* Line heights */
    public function param_line_height($param_name = 'line_height') {
      array(
        'type'        => 'dropdown',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'heading'     => __('Line height', 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __('Settings', 'TEXT_DOMAIN'),
        'value'       => $this->line_heights(),
        'description' => __('Set line height', 'TEXT_DOMAIN'),
        'std'         => '18px',
      );
    }

    /* Spaces */
    public function param_space($param_name = 'above') {
      return array(
        'type'        => 'dropdown',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'heading'     => __('Space above', 'TEXT_DOMAIN'),
        'param_name'  => 'space_' . $param_name,
        'group'       => __('Spaces', 'TEXT_DOMAIN'),
        'value'       => $this->vertical_space(),
        'description' => __("Set space $param_name", 'TEXT_DOMAIN'),
        'std'         => 'None',
      );
    }

  }
}