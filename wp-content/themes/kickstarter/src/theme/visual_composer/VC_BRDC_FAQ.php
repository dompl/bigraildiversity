<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_BRDC_FAQ')) {

  class VC_BRDC_FAQ extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_FAQ_section_map'));
      add_shortcode('VC_BRDC_FAQ_shortcode', array(&$this, 'VC_BRDC_FAQ_shortcode_callback'));
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
          'class'       => 'vc_hidden',
          'admin_label' => true,
          'heading'     => __('Question', 'TEXT_DOMAIN'),
          'param_name'  => 'question',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => '',
          'description' => __('Question', 'TEXT_DOMAIN'),
        ),
        array(
          'type'        => 'textarea_html',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'admin_label' => false,
          'heading'     => __('Answer', 'TEXT_DOMAIN'),
          'param_name'  => 'content',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => '',
          'description' => __('Answer to the question', 'TEXT_DOMAIN'),
        ),
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
    public function VC_BRDC_FAQ_section_map() {

      $title       = 'FAQ';                       // Shortcode description
      $description = 'Frequently asked question'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_BRDC_FAQ_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon('icon-question.svg'),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_BRDC_FAQ_shortcode_callback($atts, $content = null) {

      extract(shortcode_atts(array(
        'question'     => '',
        'space_above'  => __('None', 'TEXT_DOMAIN'),
        'space_below'  => __('None', 'TEXT_DOMAIN'),
        'custom_class' => '',
        'custom_id'    => '',
      ), $atts));

      $content = wpb_js_remove_wpautop($content, true);

      $item         = '';
      $custom_class = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id    = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      $item .= $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';
      $item .= '<div class="' . $this->pixels_class($space_above, 'spacer-top') . ' ' . $this->pixels_class($space_below, 'spacer-bottom') . '">';

      if ($content != '' && $question != '') {
        $item .= sprintf('<div class="faq"><div class="faq-question clx"><span>%s</span></div><div class="faq-answer">%s</div></div>', $question, $content);
      }

      $item .= '</div>';
      $item .= $custom_class || $custom_id ? '</div>' : '';

      return $item;
    }
  }

}