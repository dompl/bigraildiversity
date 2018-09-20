<?php

namespace config\visual_composer;
use WPBakeryShortCode;
if ( ! class_exists('Visual_Composer_Additional_Params')) {

  class Visual_Composer_Additional_Params extends WPBakeryShortCode {

    public function __construct() {}

    public function param_additional_class($param_name = 'custom_class') {

      return array(
        'type'        => 'textfield',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'vc_label'    => false,
        'heading'     => __('Extra class name', 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __('Content', 'TEXT_DOMAIN'),
        'value'       => '',
        'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'TEXT_DOMAIN'),
      );
    }

    public function param_additional_id($param_name = 'custom_id') {

      return array(
        'type'        => 'textfield',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'vc_label'    => false,
        'heading'     => __('Element ID', 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __('Content', 'TEXT_DOMAIN'),
        'value'       => '',
        'description' => __('Enter element ID (Note: make sure it is unique and valid according to <a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">w3c specification</a>).', 'TEXT_DOMAIN'),
      );
    }

    public function param_animation_classes($param_name = 'animation') {
      return array(
        'type'        => 'animation_style',
        'heading'     => __('Animation Style', 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'description' => __('Select type of animation for element to be animated when it "enters" the browsers viewport (Note: works only in modern browsers).', 'TEXT_DOMAIN'),
        'admin_label' => false,
        'weight'      => 0,
        'group'       => 'Settings',
      );
    }

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
    public function param_font_weight($param_name = 'font_weight') {
      return array(
        'type'        => 'dropdown',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'heading'     => __('Font weight', 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __('Settings', 'TEXT_DOMAIN'),
        'value'       => array('Default', 'Extra Bold', 'Bolder', 'Bold', 'Light', 'Lighter', 'Extra Light'),
        'description' => __('Set font weight', 'TEXT_DOMAIN'),
        'std'         => 'Default',
      );
    }

    /* Font sizes */
    public function param_font_sizes($param_name = 'font_size') {
      return array(
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
      return array(
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
      return array(
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
        'std'         => __('None', 'TEXT_DOMAIN'),
      );
    }

    public function prevent_space_on_mobile() {
      return array(
        'type'        => 'checkbox',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'admin_label' => false,
        'heading'     => __('Prevent responsive', 'TEXT_DOMAIN'),
        'param_name'  => 'prevent',
        'group'       => __('Spaces', 'TEXT_DOMAIN'),
        'value'       => array(__('Prevent', 'TEXT_DOMAIN') => true),
        'description' => __('Prevent space from reducing it size on mobile/tablet devices', 'TEXT_DOMAIN'),
        'std'         => false,
      );
    }
  }
}