<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_Sponsors_Slider')) {

  class VC_Sponsors_Slider extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_Sponsors_Slider_section_map'));
      add_shortcode('VC_Sponsors_Slider_shortcode', array(&$this, 'VC_Sponsors_Slider_shortcode_callback'));
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
          'heading'     => __('Type', 'TEXT_DOMAIN'),
          'param_name'  => 'type',
          'admin_label' => true,
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Sponsors', 'TEXT_DOMAIN')  => 'sponsorship_year',
            __('Attendees', 'TEXT_DOMAIN') => 'attendance_year',
          ),
          'description' => __('Select type of content', 'TEXT_DOMAIN'),
          'std'         => 'sponsorship_year',
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Dates', 'TEXT_DOMAIN'),
          'param_name'  => 'year',
          'admin_label' => true,
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => $this->years(),
          'description' => __('Select for which ear you want to show the sponsors/atendees.', 'TEXT_DOMAIN'),
          'std'         => date('Y'),
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'admin_label' => false,
          'heading'     => __('Display company name', 'TEXT_DOMAIN'),
          'param_name'  => 'company',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(__('Display', 'TEXT_DOMAIN') => true),
          'description' => __('Display company names under the logos', 'TEXT_DOMAIN'),
          'std'         => false,
        ),
        $this->slider_items_per_show(),
        $this->slider_display_navigation(),
        $this->slider_autoplay(),
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
    public function VC_Sponsors_Slider_section_map() {

      $title       = 'Sponsors/Attendees Slider'; // Shortcode description
      $description = 'Add sponsors slider';       // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_Sponsors_Slider_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon(),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_Sponsors_Slider_shortcode_callback($atts, $content = null) {

      extract(shortcode_atts(array(
        'type'              => 'sponsorship_year',
        'year'              => date('Y'),
        'company'           => false,
        'slides_count'      => 1,
        'slider_navigation' => 'dots',
        'slider_autoplay'   => false,
        'space_above'       => __('None', 'TEXT_DOMAIN'),
        'space_below'       => __('None', 'TEXT_DOMAIN'),
        'custom_class'      => '',
        'custom_id'         => '',
      ), $atts));

      $years = explode(',', $year);

      /* Build query args */
      $args = array(
        'post_type'      => 'atendees',
        'posts_per_page' => -1,
        'meta_query'     => array(
          // 'relation' => 'AND',
          array(
            'key'     => $type,
            'value'   => $years,
            'compare' => '!=',
          ),
        ),
      );

      $item              = '';
      $animation_classes = $this->getCSSAnimation($animation);
      $custom_class      = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id         = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      $item .= $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';

      $posts = get_posts($args);

      if ($posts) {

        $item .= '<div class="sponsor-atendee-slider"><ul class="list-inline">';

        foreach ($posts as $post) {

          $id   = $post->ID;
          $logo = get_field('add_attendee_logo', $id);

          if ($logo) {

            $item .= sprintf('<li><a href="%s" title="%s"><div class="logo"><img src="%s" alt="%s"></div>%s</a></li>',
              esc_url(get_permalink($id)),
              __('Find out more about', 'TEXT_DOMAIN') . ' ' . esc_html(get_the_title($id)),
              wpimage('img=' . (int) $logo . '&h=100&retina=false&crop=false'),
              esc_html(get_the_title($id)) . ' ' . __('logo', 'TEXT_DOMAIN'),
               $company ? '<span class="company-name">' . esc_html(get_the_title($id)) . '</span>' : ''
            );

          }

        }

        $item .= '</ul></div>';

      }
      wp_reset_postdata();
      $item .= $custom_class || $custom_id ? '</div>' : '';

      return $item;
    }
  }

}