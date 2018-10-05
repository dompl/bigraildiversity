<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_BRDC_Bullet_List')) {

  class VC_BRDC_Bullet_List extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_Bullet_List_section_map'));
      add_shortcode('VC_BRDC_Bullet_List_shortcode', array(&$this, 'VC_BRDC_Bullet_List_shortcode_callback'));
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
          'class'       => 'vc_hidden',
          'heading'     => __('Coulmns', 'TEXT_DOMAIN'),
          'param_name'  => 'cols',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array('1', '2', '3'),
          'description' => __('How many columns per 1 row.', 'TEXT_DOMAIN'),
          'std'         => '1',
        ),
        array(
          'type'        => 'textarea',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('List items', 'TEXT_DOMAIN'),
          'param_name'  => 'list',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => '',
          'description' => __('Add your list item. One item per row only.', 'TEXT_DOMAIN'),
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
    public function VC_BRDC_Bullet_List_section_map() {

      $title       = 'Bullet list';                // Shortcode description
      $description = 'Add customised bullet list'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_BRDC_Bullet_List_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon('icon-list.svg'),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_BRDC_Bullet_List_shortcode_callback($atts, $content = null) {

      extract(shortcode_atts(array(
        'list'         => '',
        'cols'         => '1',
        'space_above'  => __('None', 'TEXT_DOMAIN'),
        'space_below'  => __('None', 'TEXT_DOMAIN'),
        'custom_class' => '',
        'custom_id'    => '',
      ), $atts));

      // $href = vc_build_link( $href ); // Build Link
      // $content = wpb_js_remove_wpautop($content, true); // Content
      $list         = $this->replace_brackets_with_tags($list);
      $item         = '';
      $custom_class = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id    = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      if ($list == '') {
        return;
      }

      $list = explode("\n", $list);
      $list = str_replace("<br />" , '', $list);



      $item .= $custom_class != '' || $custom_id != '' ? '<div' . $custom_id . $custom_class . '>' : '';
      $item .= '<div class="' . $this->pixels_class($space_above, 'spacer-top') . ' ' . $this->pixels_class($space_below, 'spacer-bottom') . '">';
      $item .= '<ul class="bullet-list list-unstyled columns-'.$cols.'">';
      foreach ($list as $list_item) {
      $item .= '<li class="clx"><span class="inner">'.$list_item.'</span></li>';
      };
      $item .= '</ul>';
      $item .= '</div>';
      $item .=  $custom_class != '' || $custom_id != '' ? '</div>' : '';

      return $item;
    }
  }

}