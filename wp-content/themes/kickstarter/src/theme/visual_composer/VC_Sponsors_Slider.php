<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;
use WP_Query;

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
            __('Sponsors', 'TEXT_DOMAIN')                 => 'atendees_sponsor',
            __('Attendees', 'TEXT_DOMAIN')                => 'atendees',
            __('Supporting Organisations', 'TEXT_DOMAIN') => 'supportingorgs',
          ),
          'description' => __('Select type of content', 'TEXT_DOMAIN'),
          'std'         => 'atendees',
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
          'description' => __('Select for which year you want to show the logos.', 'TEXT_DOMAIN'),
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
        // $this->slider_items_per_show(),
        // $this->slider_display_navigation(),
        // $this->slider_autoplay(),
        $this->param_space('above'),
        $this->param_space('below'),
        $this->prevent_space_on_mobile(),
        $this->param_additional_id('custom_id'),
        $this->param_additional_class('custom_class'),
      );

      foreach ($this->slick_slider_settings() as $value) {
        $params[] = $value;
      }

      return $params;
    }

    /**
     * Visual Composer Map
     * ---
     */
    public function VC_Sponsors_Slider_section_map() {

      $title       = 'Logo Slider';                               // Shortcode description
      $description = 'Sponsors/Attendees/Supporting Orgs Slider'; // Shortcode Name

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
        'type'               => 'atendees',
        'year'               => (int) date('Y'),
        'company'            => false,
        'slides_to_show'     => '1',
        'slides_to_scroll'   => '1',
        'slider_center_mode' => false,
        'slider_infinite'    => true,
        'slider_autoplay'    => true,
        'slider_navigation'  => 'dots',
        'space_above'        => __('None', 'TEXT_DOMAIN'),
        'space_below'        => __('None', 'TEXT_DOMAIN'),
        'custom_class'       => '',
        'custom_id'          => '',
      ), $atts));

      $years = explode(',', $year);

      $key_type = ($type == 'atendees' || $type == 'supportingorgs') ? 'attendance_year' : 'sponsorship_year';

      $type = str_replace('_sponsor', '', $type);

      $year = explode(',', $year);
      /* Build query args */
      $args = array(
        'post_type'      => 'atendees',
        'posts_per_page' => -1,
      );

      foreach ($year as $y) {
        $args['meta_query']['relation'] = 'OR';
        $args['meta_query'][]           = array(
          'key'     => 'sponsorship_year',
          'value'   => $y,
          'compare' => 'LIKE',
        );
      }

      // print_r($args);

      $item         = '';
      $custom_class = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id    = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      $item .= $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';

      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) {

        $this->require()['slick'];

        $slick_settings = '';
        $slick_settings .= '"slidesToShow": ' . $slides_to_show . ', ';
        $slick_settings .= '"slidesToScroll": ' . $slides_to_scroll . ', ';
        $slick_settings .= '"centerMode": ' . ($slider_center_mode ? 'true, ' : 'false, ');
        $slick_settings .= '"infinite": ' . ($slider_infinite ? 'true, ' : 'false, ');
        $slick_settings .= '"autoplay": ' . ($slider_autoplay ? 'true' : 'false');

        $item .= '<div class="sponsor-atendee-slider"><ul class="list-inline sponsor-slider slick-equal" data-slick=\'{' . $slick_settings . '}\'>';

        while ($the_query->have_posts()) {$the_query->the_post();

          $id    = get_the_ID();
          $logo  = get_field('add_attendee_logo', $id);
          $year1 = get_field('sponsorship_year', $id);

          if ($logo) {

            $item .= sprintf('<li><div class="logo"><a href="%1$s" title="%2$s"><img data-lazy="%3$s" alt="%4$s"></a></div>%5$s</li>',
              esc_url(get_permalink($id)),
              __('Find out more about', 'TEXT_DOMAIN') . ' ' . esc_html(get_the_title($id)),
              wpimage('img=' . (int) $logo . '&h=200&w=150&retina=false&crop=false'),
              esc_html(get_the_title($id)) . ' ' . __('logo', 'TEXT_DOMAIN'),
              $company ? '<span class="company-name company-name-att">' . esc_html(get_the_title($id)) . '</span>' : ''
            );

          }

        }

        $item .= '</ul></div>';

      }
      wp_reset_query();
      $item .= $custom_class || $custom_id ? '</div>' : '';

      return $item;
    }
  }

}