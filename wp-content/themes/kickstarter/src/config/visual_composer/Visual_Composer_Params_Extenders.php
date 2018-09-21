<?php

namespace config\visual_composer;
use WPBakeryShortCode;
if ( ! class_exists('Visual_Composer_Params_Extenders')) {

  class Visual_Composer_Params_Extenders extends WPBakeryShortCode {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'add_param_vc_row_contaier_width'));
      add_action('vc_before_init', array(&$this, 'add_param_vc_row_contaier_background'));
      add_action('vc_before_init', array(&$this, 'remove_param_vc_row_section_stretch'));
    }

    /**
     * Containet
     * ---
     */
    // Remove stretching
    public function remove_param_vc_row_section_stretch() {
      vc_remove_param('vc_row', 'full_width');
    }

    // Set conteainer background colour
    public function add_param_vc_row_contaier_background() {
      vc_add_param('vc_row',
        array(
          'type'        => 'dropdown',
          'heading'     => __('Container background', 'TEXT_DOMAIN'),
          'param_name'  => 'brdc_container_background',
          'std'         => 'bcg-white',
          'weight'      => 1.2,
          'value'       => array(
            __('Transparent background', 'TEXT_DOMAIN') => 'bcg-transparent',
            __('White background', 'TEXT_DOMAIN')       => 'bcg-white',
            __('Green background', 'TEXT_DOMAIN')       => 'bcg-green',
            __('Blue background', 'TEXT_DOMAIN')        => 'bcg-blue',
          ),
          'description' => __('Set background width or colour', 'TEXT_DOMAIN'),
        )
      );
    }

    // Add container width
    public function add_param_vc_row_contaier_width() {
      vc_add_param('vc_row',
        array(
          'type'        => 'dropdown',
          'heading'     => __('Container width', 'TEXT_DOMAIN'),
          'param_name'  => 'brdc_container_width',
          'std'         => 'container-narrow',
          'weight'      => 1.1,
          'value'       => array(
            __('Narrow container', 'TEXT_DOMAIN')     => 'container-narrow',
            __('Wide container', 'TEXT_DOMAIN')       => 'container-wide',
            __('Full width container', 'TEXT_DOMAIN') => 'container-full',
          ),
          'description' => __('Set background width or colour', 'TEXT_DOMAIN'),
        )
      );
    }
  }
}
