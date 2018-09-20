<?php

namespace config\visual_composer;
use WPBakeryShortCode;
if ( ! class_exists('Visual_Composer_Params_Extenders')) {

  class Visual_Composer_Params_Extenders extends WPBakeryShortCode {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'add_param_vc_row_background_dropdown'));
    }

    public function add_param_vc_row_background_dropdown() {
      vc_add_param('vc_row',
        array(
          'type'       => 'dropdown',
          'heading'    => __('Content', 'wpex'),
          'param_name' => 'background_style',
          'std'        => 'bcg-default',
          'value'      => array(
            __('White background', 'TEXT_DOMAIN')   => 'bcg-white',
            __('Green background', 'TEXT_DOMAIN')   => 'bcg-green',
            __('Blue background', 'TEXT_DOMAIN')    => 'bcg-blue',
            __('Default background', 'TEXT_DOMAIN') => 'bcg-default',
          ),
        )
      );
    }
  }
}
