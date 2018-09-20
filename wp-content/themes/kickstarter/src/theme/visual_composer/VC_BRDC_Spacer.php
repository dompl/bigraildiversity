<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_BRDC_Spacer')) {

  class VC_BRDC_Spacer extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_Spacer_section_map'));
      add_shortcode('VC_BRDC_Spacer_shortcode', array(&$this, 'VC_BRDC_Spacer_shortcode_callback'));
    }

    /**
     * Params
     * ---
     */
    public function params() {

      $params = array(
        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_label',
          'heading'     => __('Section space', 'TEXT_DOMAIN'),
          'param_name'  => 'spacer',
          'group'       => __('Settings', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Small', 'TEXT_DOMAIN'),
            __('Default', 'TEXT_DOMAIN'),
            __('Medium', 'TEXT_DOMAIN'),
            __('Large', 'TEXT_DOMAIN'),
            __('Extra Large', 'TEXT_DOMAIN'),
          ),
          'description' => __('Section title', 'TEXT_DOMAIN'),
          'std'         => __('Default', 'TEXT_DOMAIN'),
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'admin_label' => false,
          'heading'     => __('Prevent responsive', 'TEXT_DOMAIN'),
          'param_name'  => 'prevent',
          'group'       => __('Settings', 'TEXT_DOMAIN'),
          'value'       => array(__('Prevent', 'TEXT_DOMAIN') => true),
          'description' => __('Prevent space from reducing it size on mobile/tablet devices', 'TEXT_DOMAIN'),
          'std'         => false,
        ),
      );
      return $params;
    }

    /**
     * Visual Composer Map
     * ---
     */
    public function VC_BRDC_Spacer_section_map() {

      $title       = 'Section spacer';                  // Shortcode description
      $description = 'Add space between your sections'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_BRDC_Spacer_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon(),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_BRDC_Spacer_shortcode_callback($atts) {

      extract(shortcode_atts(array(
        'spacer'  => __('Default', 'TEXT_DOMAIN'),
        'prevent' => false,
      ), $atts));

      $spacer = str_replace(' ', '-', $spacer);
      $spacer = strtolower($spacer);

      return sprintf('<div class="spacer spacer-%s clear%s"></div>', $spacer, $prevent ? '' : ' no-prevent');

    }
  }
}