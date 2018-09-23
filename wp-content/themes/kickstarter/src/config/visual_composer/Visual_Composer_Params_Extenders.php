<?php

namespace config\visual_composer;
use WPBakeryShortCode;
if ( ! class_exists('Visual_Composer_Params_Extenders')) {

  class Visual_Composer_Params_Extenders extends WPBakeryShortCode {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'add_param_vc_row_contaier_width'));
      add_action('vc_before_init', array(&$this, 'add_param_vc_row_contaier_background'));
      add_action('vc_before_init', array(&$this, 'remove_param_vc_row_section_stretch'));
      add_action('vc_before_init', array(&$this, 'add_param_vc_row_contaier_icon'));
      add_action('vc_before_init', array(&$this, 'add_param_vc_row_prevent_margins'));
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
          'weight'      => 1.1,
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
          'weight'      => 1.2,
          'value'       => array(
            __('Narrow container', 'TEXT_DOMAIN')     => 'container-narrow',
            __('Wide container', 'TEXT_DOMAIN')       => 'container-wide',
            __('Full width container', 'TEXT_DOMAIN') => 'container-full',
          ),
          'description' => __('Set background width or colour', 'TEXT_DOMAIN'),
        )
      );
    }

    public function add_param_vc_row_contaier_icon() {
      vc_add_param('vc_row',
        array(
          'type'        => 'dropdown',
          'heading'     => __('Select iton', 'TEXT_DOMAIN'),
          'param_name'  => 'brdc_container_icon',
          'std'         => false,
          'weight'      => 1.3,
          'value'       => array(
            __('None', 'TEXT_DOMAIN')      => false,
            __('Quotation', 'TEXT_DOMAIN') => 'icon-quotes',
          ),
          'description' => __('Choose an icon to show above the container.', 'TEXT_DOMAIN'),
        )
      );
    }

    public function add_param_vc_row_prevent_margins() {
      vc_add_param('vc_row',
        array(
          'type'        => 'checkbox',
          'heading'     => __('Prevent margins', 'TEXT_DOMAIN'),
          'param_name'  => 'brdc_container_prevent_margins',
          'std'         => false,
          'weight'      => 1.2,
          'value'       => array(
            __('Prevent', 'TEXT_DOMAIN') => true,
          ),
          'description' => __('Remove top and bottom spaces from your section', 'TEXT_DOMAIN'),
        )
      );
    }
  }
}
