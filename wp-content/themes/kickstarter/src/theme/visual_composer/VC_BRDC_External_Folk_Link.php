<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_BRDC_External_Folk_Link')) {

  class VC_BRDC_External_Folk_Link extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_External_Folk_Link_section_map'));
      add_shortcode('VC_BRDC_External_Folk_Link_shortcode', array(&$this, 'VC_BRDC_External_Folk_Link_shortcode_callback'));
    }

    /**
     * Params
     * ---
     */
    public function params() {

      $params = array(
        array(
          'type'       => 'textfield',
          'holder'     => 'div',
          'class'      => 'vc_label',
          'heading'    => __('Content title', 'TEXT_DOMAIN'),
          'param_name' => 'text',
          'group'      => __('Content', 'TEXT_DOMAIN'),
          'value'      => __('This item has no settings', 'TEXT_DOMAIN'),
        ),
      );
      return $params;
    }

    /**
     * Visual Composer Map
     * ---
     */
    public function VC_BRDC_External_Folk_Link_section_map() {

      $title       = 'External Link';        // Shortcode description
      $description = 'External link button'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_BRDC_External_Folk_Link_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon(),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_BRDC_External_Folk_Link_shortcode_callback($atts) {

      if ( ! get_field('attendee_website_url')) {
        return;
      }

      extract(shortcode_atts(array(
      ), $atts));

      $item .= sprintf('<div class="external-link"><div class="inner"><a href="%1$s" title="%2$s" class="button medium fill color-wir" target="_blank">%2$s</a></div></div>',
        esc_url(get_field('attendee_website_url', get_the_ID())),
        sprintf(__('Visit %s website', 'TEXT_DOMAIN'), the_title_attribute('echo=0&post=' . get_the_ID()))
    );
    return $item;
  }
}

}