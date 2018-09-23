<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_Element_Blank')) {

  class VC_Element_Blank extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_Element_Blank_section_map'));
      add_shortcode('VC_Element_Blank_shortcode', array(&$this, 'VC_Element_Blank_shortcode_callback'));
    }

    /**
     * Params
     * ---
     */
    public function params() {

      $params = array(
        array(
          'type'        => 'textfield',
          'holder'      => 'div',
          'class'       => 'vc_label',
          'heading'     => __('Content title', 'TEXT_DOMAIN'),
          'param_name'  => 'text',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => __('Add title here', 'TEXT_DOMAIN'),
          'description' => __('Section title', 'TEXT_DOMAIN'),
        ),
        $this->param_text_alignment('align'),
        $this->param_space('above'),
        $this->param_space('below'),
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
    public function VC_Element_Blank_section_map() {

      $title       = 'Shortcode title';       // Shortcode description
      $description = 'Shortcode description'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_Element_Blank_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon(),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_Element_Blank_shortcode_callback($atts, $content = null) {

      extract(shortcode_atts(array(
        'text'         => '',
        'animation'    => '',
        'space_above'  => __('None', 'TEXT_DOMAIN'),
        'space_below'  => __('None', 'TEXT_DOMAIN'),
        'align'        => __('Left', 'TEXT_DOMAIN'),
        'custom_class' => '',
        'custom_id'    => '',
      ), $atts));

      // $href = vc_build_link( $href ); // Build Link
      // $content = wpb_js_remove_wpautop($content, true); // Content
      // $text              = $this->replace_brackets_with_tags($text);
      $item              = '';
      $animation_classes = $this->getCSSAnimation($animation);
      $custom_class      = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id         = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      $item .= $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';
      $item .= '<div class="' . $this->pixels_class($align, 'align') . ' ' . $this->pixels_class($space_above, 'spacer-top') . ' ' . $this->pixels_class($space_below, 'spacer-bottom') . '">';

      $item .= '</div>';
      $item .= $custom_class || $custom_id ? '</div>' : '';

      return $item;
    }
  }

}