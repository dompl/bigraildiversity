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
      add_action('vc_before_init', array(&$this, 'add_param_vc_row_prevent_margins_hor'));
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
            __('None', 'TEXT_DOMAIN')           => false,
            __('Awards', 'TEXT_DOMAIN')         => 'icon-award',
            __('Bell', 'TEXT_DOMAIN')           => 'icon-bell',
            __('Boxing Glove', 'TEXT_DOMAIN')   => 'icon-boxing-glove',
            __('Calendar', 'TEXT_DOMAIN')       => 'icon-calendar-alt',
            __('Calendar Check', 'TEXT_DOMAIN') => 'icon-calendar-alt',
            __('Camera', 'TEXT_DOMAIN')         => 'icon-camera-alt',
            __('Circle', 'TEXT_DOMAIN')         => 'icon-circle',
            __('Clipboard', 'TEXT_DOMAIN')      => 'icon-clipboard',
            __('Clock', 'TEXT_DOMAIN')          => 'icon-clock',
            __('Close', 'TEXT_DOMAIN')          => 'icon-menu-close',
            __('Envelope', 'TEXT_DOMAIN')       => 'icon-envelope',
            __('Facebook', 'TEXT_DOMAIN')       => 'icon-facebook',
            __('Map', 'TEXT_DOMAIN')            => 'icon-map-marked-alt',
            __('Ribbon', 'TEXT_DOMAIN')         => 'icon-ribbon',
            __('Smile', 'TEXT_DOMAIN')          => 'icon-smile',
            __('Star', 'TEXT_DOMAIN')           => 'icon-star',
            __('Subway', 'TEXT_DOMAIN')         => 'icon-subway',
            __('Train', 'TEXT_DOMAIN')          => 'icon-train',
            __('Trophy', 'TEXT_DOMAIN')         => 'icon-trophy-alt',
            __('Quotation', 'TEXT_DOMAIN')      => 'icon-quotes',
          ),
          'description' => __('Choose an icon to show above the container.', 'TEXT_DOMAIN'),
        )
      );
    }

    public function add_param_vc_row_prevent_margins() {
      vc_add_param('vc_row',
        array(
          'type'        => 'checkbox',
          'heading'     => __('Prevent margins (top bottom)', 'TEXT_DOMAIN'),
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

    public function add_param_vc_row_prevent_margins_hor() {
      vc_add_param('vc_row',
        array(
          'type'        => 'checkbox',
          'heading'     => __('Prevent margins (left right)', 'TEXT_DOMAIN'),
          'param_name'  => 'brdc_container_prevent_margins_hor',
          'std'         => false,
          'weight'      => 1.2,
          'value'       => array(
            __('Prevent', 'TEXT_DOMAIN') => true,
          ),
          'description' => __('Remove left and right spaces from your section', 'TEXT_DOMAIN'),
        )
      );
    }
  }
}
