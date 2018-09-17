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
        'text' => '',
      ), $atts));

      // $href = vc_build_link( $href ); // Build Link
      // $content = wpb_js_remove_wpautop($content, true); // Content

       ob_start()?>
       <!-- Content goes here -->
       <?php

       $item = ob_get_contents();
      ob_end_clean();

      return $item;
    }
  }

}