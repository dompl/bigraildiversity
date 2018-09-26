<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_BRDC_Simple_Button')) {

  class VC_BRDC_Simple_Button extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_Simple_Button_section_map'));
      add_shortcode('VC_BRDC_Simple_Button_shortcode', array(&$this, 'VC_BRDC_Simple_Button_shortcode_callback'));
    }

    /**
     * Params
     * ---
     */
    public function params() {

      $params = array(
        array(
          'type'       => 'param_group',
          'value'      => 'Buttons',
          'group'      => __('Content', 'TEXT_DOMAIN'),
          'heading'    => __('Add buttons', 'TEXT_DOMAIN'),
          'param_name' => 'buttons',
          'params'     => array(
            array(
              'type'        => 'vc_link',
              'holder'      => 'div',
              'class'       => 'vc_label',
              'heading'     => __('Button link', 'TEXT_DOMAIN'),
              'param_name'  => 'href',
              'group'       => __('Content', 'TEXT_DOMAIN'),
              'value'       => __('Add title here', 'TEXT_DOMAIN'),
              'description' => __('Section title', 'TEXT_DOMAIN'),
            ),
            array(
              'type'        => 'dropdown',
              'holder'      => 'div',
              'class'       => 'vc_label',
              'heading'     => __('Button style', 'TEXT_DOMAIN'),
              'param_name'  => 'style',
              'group'       => __('Content', 'TEXT_DOMAIN'),
              'value'       => array(
                __('Fill', 'TEXT_DOMAIN')     => 'fill',
                __('Outlined', 'TEXT_DOMAIN') => 'outline',
              ),
              'description' => __('Set button style', 'TEXT_DOMAIN'),
              'std'         => 'fill',
            ),
            $this->param_colors('color', 'Content'),
          ),
        ),
        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_label',
          'heading'     => __('Buttons size', 'TEXT_DOMAIN'),
          'param_name'  => 'size',
          'group'       => __('Settings', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Small', 'TEXT_DOMAIN')  => 'small',
            __('Medium', 'TEXT_DOMAIN') => 'medium',
            __('Large', 'TEXT_DOMAIN')  => 'large',
          ),
          'description' => __('Set buttons size', 'TEXT_DOMAIN'),
          'std'         => 'medium',
        ),
        $this->param_text_alignment('align', 'Settings', 'Buttons alignment'),
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
    public function VC_BRDC_Simple_Button_section_map() {

      $title       = 'Simple button';     // Shortcode description
      $description = 'Add simple button'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_BRDC_Simple_Button_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon(),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_BRDC_Simple_Button_shortcode_callback($atts) {

      extract(shortcode_atts(array(
        'buttons'      => '',
        'space_above'  => __('None', 'TEXT_DOMAIN'),
        'space_below'  => __('None', 'TEXT_DOMAIN'),
        'align'        => __('Left', 'TEXT_DOMAIN'),
        'size'         => 'medium',
        'custom_class' => '',
        'custom_id'    => '',
      ), $atts));

      $custom_class = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id    = $custom_id != '' ? ' id="' . $custom_id . '"' : false;
      $buttons      = vc_param_group_parse_atts($buttons);

      if ( ! empty($buttons) && $buttons != '') {

        $item = $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';

        $item .= '<div class="' . $this->pixels_class($align, 'align') . ' ' . $this->pixels_class($space_above, 'spacer-top') . ' ' . $this->pixels_class($space_below, 'spacer-bottom') . '">';

        foreach ($buttons as $button) {

          $link  = vc_build_link($button['href']);
          $style = $button['style'];
          $color = $this->pixels_class($button['color'], 'color');
          $item .= sprintf('<a href="%1$s" class="button %2$s %3$s %4$s" title="' . esc_html('%5$s') . '"%6$s>%5$s</a>',
            esc_url($link['url']),
            $size,
            $style,
            $color,
            $link['title'] ? $this->replace_brackets_with_tags($link['title']) : __('Discover More', 'TEXT_DOMAIN'),
            $link['target'] != '' ? ' target="' . $link['target'] . '"' : ''
          );
        }
        $item .= '</div>';
        $item .= $custom_class || $custom_id ? '</div>' : '';
      }

      return $item;
    }
  }

}
