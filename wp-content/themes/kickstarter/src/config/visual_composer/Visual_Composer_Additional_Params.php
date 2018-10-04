<?php

namespace config\visual_composer;
use WPBakeryShortCode;
if ( ! class_exists('Visual_Composer_Additional_Params')) {

  class Visual_Composer_Additional_Params extends WPBakeryShortCode {

    public function __construct() {}

    public function param_text_tags($param_name = 'tag', $group = 'Content') {
      return array(
        'type'        => 'dropdown',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'heading'     => __('Title tag', 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __($group, 'TEXT_DOMAIN'),
        'value'       => array('h1', 'h2', 'h3', 'h4', 'h5', 'p', 'div'),
        'description' => __('Set title tag', 'TEXT_DOMAIN'),
        'std'         => 'h2',
      );
    }

    public function param_additional_class($param_name = 'custom_class', $group = 'Content') {

      return array(
        'type'        => 'textfield',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'vc_label'    => false,
        'heading'     => __('Extra class name', 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __($group, 'TEXT_DOMAIN'),
        'value'       => '',
        'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'TEXT_DOMAIN'),
      );
    }

    public function param_additional_id($param_name = 'custom_id', $group = 'Content') {

      return array(
        'type'        => 'textfield',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'vc_label'    => false,
        'heading'     => __('Element ID', 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __($group, 'TEXT_DOMAIN'),
        'value'       => '',
        'description' => __('Enter element ID (Note: make sure it is unique and valid according to <a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">w3c specification</a>).', 'TEXT_DOMAIN'),
      );
    }

    public function param_animation_classes($param_name = 'animation', $group = 'Content') {
      return array(
        'type'        => 'animation_style',
        'heading'     => __('Animation Style', 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __($group, 'TEXT_DOMAIN'),
        'description' => __('Select type of animation for element to be animated when it "enters" the browsers viewport (Note: works only in modern browsers).', 'TEXT_DOMAIN'),
        'admin_label' => false,
        'weight'      => 0,
        'group'       => 'Settings',
      );
    }

    /* Text Alignment */
    public function param_text_alignment($param_name = 'align', $group = 'Settings', $title = 'Text alignment') {

      return array(
        'type'        => 'dropdown',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'heading'     => __($title, 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __($group, 'TEXT_DOMAIN'),
        'value'       => array('Left', 'Center', 'Right'),
        'description' => __('Set alignment', 'TEXT_DOMAIN'),
        'std'         => 'Left',
      );
    }

    /* Font weight */
    public function param_font_weight($param_name = 'font_weight', $group = 'Settings') {
      return array(
        'type'        => 'dropdown',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'heading'     => __('Font weight', 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __($group, 'TEXT_DOMAIN'),
        'value'       => array('Default', 'Extra Bold', 'Bolder', 'Bold', 'Light', 'Lighter', 'Extra Light'),
        'description' => __('Set font weight', 'TEXT_DOMAIN'),
        'std'         => 'Default',
      );
    }

    /* Font sizes */
    public function param_font_sizes($param_name = 'font_size', $group = 'Settings') {
      return array(
        'type'        => 'dropdown',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'heading'     => __('Font size', 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __($group, 'TEXT_DOMAIN'),
        'value'       => $this->font_sizes(),
        'description' => __('Set font size', 'TEXT_DOMAIN'),
        'std'         => '16px',
      );
    }

    /* Colours */
    public function param_colors($param_name = 'color', $group = 'Settings', $title = 'Colour') {
      return array(
        'type'        => 'dropdown',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'heading'     => __($title, 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __($group, 'TEXT_DOMAIN'),
        'value'       => $this->brdc_colours(),
        'description' => __('Set colour', 'TEXT_DOMAIN'),
        'std'         => 'Default',
      );
    }

    /* Line heights */
    public function param_line_height($param_name = 'line_height', $group = 'Settings', $heading = 'Line height') {
      return array(
        'type'        => 'dropdown',
        'holder'      => 'div',
        'class'       => 'vc_hidden',
        'heading'     => __($heading, 'TEXT_DOMAIN'),
        'param_name'  => $param_name,
        'group'       => __($group, 'TEXT_DOMAIN'),
        'value'       => $this->line_heights(),
        'description' => __('Set line height', 'TEXT_DOMAIN'),
        'std'         => '18px',
      );
    }

    /* Spaces */
    public function param_space($param_name = 'above', $std = 'None') {
      return array(
        'type'        => 'dropdown',
        'holder'      => 'div',
        'class'       => "vc_label vc_space vc_space_$param_name",
        'heading'     => __('Space ' . $param_name, 'TEXT_DOMAIN'),
        'param_name'  => 'space_' . $param_name,
        'group'       => __('Spaces', 'TEXT_DOMAIN'),
        'value'       => $this->vertical_space(),
        'description' => __("Set space $param_name", 'TEXT_DOMAIN'),
        'std'         => __($std, 'TEXT_DOMAIN'),
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

    /**
     * Slider settings
     * ---
     */
    public function slick_slider_settings() {
      return array(
        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'admin_label' => false,
          'heading'     => __('Slides to show', 'TEXT_DOMAIN'),
          'param_name'  => 'slides_to_show',
          'group'       => __('Slider Settings', 'TEXT_DOMAIN'),
          'value'       => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6),
          'description' => __('How many slides would you like to show in slider.', 'TEXT_DOMAIN'),
          'std'         => 1,
        ),
        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'admin_label' => false,
          'heading'     => __('Slides to scroll', 'TEXT_DOMAIN'),
          'param_name'  => 'slides_to_scroll',
          'group'       => __('Slider Settings', 'TEXT_DOMAIN'),
          'value'       => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6),
          'description' => __('How many slides would you like to scroll on one click', 'TEXT_DOMAIN'),
          'std'         => 1,
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'admin_label' => false,
          'heading'     => __('Slider center mode', 'TEXT_DOMAIN'),
          'param_name'  => 'slider_center_mode',
          'group'       => __('Slider Settings', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Yes', 'TEXT_DOMAIN') => true,
          ),
          'description' => __('Run center mode in slider', 'TEXT_DOMAIN'),
          'std'         => false,
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'admin_label' => false,
          'heading'     => __('Slider infnite mode', 'TEXT_DOMAIN'),
          'param_name'  => 'slider_infinite',
          'group'       => __('Slider Settings', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Activate infinite mode', 'TEXT_DOMAIN') => true,
          ),
          'description' => __('If active your slides will scroll in an infinite loop.', 'TEXT_DOMAIN'),
          'std'         => true,
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'admin_label' => false,
          'heading'     => __('Slider navigation', 'TEXT_DOMAIN'),
          'param_name'  => 'slider_navigation',
          'group'       => __('Slider Settings', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Display dots', 'TEXT_DOMAIN')   => 'dots',
            __('Display arrows', 'TEXT_DOMAIN') => 'arrows',
          ),
          'description' => __('What type of navigation would you like to show in slider?', 'TEXT_DOMAIN'),
          'std'         => 'dots',
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'admin_label' => false,
          'heading'     => __('Autoplay', 'TEXT_DOMAIN'),
          'param_name'  => 'slider_autoplay',
          'group'       => __('Slider Settings', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Activate autoplay', 'TEXT_DOMAIN') => true,
          ),
          'description' => __('What type of navigation would you like to show in slider?', 'TEXT_DOMAIN'),
          'std'         => true,
        ),
      );
    }
  }
}
