<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;
use WP_Query;
if ( ! class_exists('VC_BRDV_Folks_List')) {

  class VC_BRDV_Folks_List extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDV_Folks_List_section_map'));
      add_shortcode('VC_BRDV_Folks_List_shortcode', array(&$this, 'VC_BRDV_Folks_List_shortcode_callback'));
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
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Type', 'TEXT_DOMAIN'),
          'param_name'  => 'mode',
          'admin_label' => true,
          'group'       => __('Display mode', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Center', 'TEXT_DOMAIN') => 'center',
            __('Side', 'TEXT_DOMAIN')   => 'side',
          ),
          'description' => __('How would you like to display the content', 'TEXT_DOMAIN'),
          'std'         => 'side',
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
        // array(
        //   'type'        => 'checkbox',
        //   'holder'      => 'div',
        //   'class'       => 'vc_hidden',
        //   'heading'     => __('Sponsors First', 'TEXT_DOMAIN'),
        //   'param_name'  => 'sponsor_first',
        //   'admin_label' => true,
        //   'group'       => __('Content', 'TEXT_DOMAIN'),
        //   'value'       => array(__('Put sponsors at the top of the list', 'TEXT_DOMAIN') => 'Yes'),
        //   'description' => __('Put sponsors at the top of the list', 'TEXT_DOMAIN'),
        //   'std'         => false,
        //   'dependency'  => array(
        //     'element' => 'type',
        //     'value'   => array('supportingorgs', 'atendees'),
        //   ),
        // ),
        $this->param_text_alignment('align'),
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
    public function VC_BRDV_Folks_List_section_map() {

      $title       = 'Folks List';                               // Shortcode description
      $description = 'List of Attendees, Sponsors or Supp Orgs'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_BRDV_Folks_List_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon('icon-folks.svg'),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_BRDV_Folks_List_shortcode_callback($atts, $content = null) {

      extract(shortcode_atts(array(
        // 'sponsor_first' => false,
        'type'         => 'atendees',
        'mode'         => 'side',
        'year'         => (int) date('Y'),
        'space_above'  => __('None', 'TEXT_DOMAIN'),
        'space_below'  => __('None', 'TEXT_DOMAIN'),
        'custom_class' => '',
        'custom_id'    => '',
      ), $atts));

      $years = explode(',', $year);

      $key_type = ($type == 'atendees' || $type == 'supportingorgs') ? 'attendance_year' : 'sponsorship_year';

      $type = str_replace('_sponsor', '', $type);

      $year = explode(',', $year);
      $type = explode(',', $type);

      /* Build query args */
      $args = array(
        'post_type'      => $type,
        'posts_per_page' => -1,
      );

      // if ($sponsor_first == 'Yes') {
      //   $args['meta_key'] = 'sponsorship_year';
      //   $args['orderby']  = 'meta_value';
      //   $args['order']    = 'DESC';
      // }

      foreach ($year as $y) {
        $args['meta_query']['relation'] = 'OR';
        $args['meta_query'][]           = array(
          'key'     => $key_type,
          'value'   => $y,
          'compare' => 'LIKE',
        );
      }

      $item = '';

      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) {
        $custom_class = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
        $custom_id    = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

        $item .= $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';
        $item .= '<div class="' . $this->pixels_class($space_above, 'spacer-top') . ' ' . $this->pixels_class($space_below, 'spacer-bottom') . '">';

        $item .= '<div class="folks-container">';
        while ($the_query->have_posts()) {$the_query->the_post();

          $id = get_the_ID();

          $item .= '<div class="folks-item ' . implode($type) . ' mode-' . $mode . '"><div class="folks-item-inner clx">';
          // Image

          $image             = get_field('add_attendee_logo');
          $link              = esc_url(get_the_permalink());
          $title             = the_title_attribute('echo=0&post' . $id);
          $short_description = get_field('attendee_short_description', $id);

          $logo = sprintf('<img data-src="%s" src="%s" class="lazy" alt="%s">',
            wpimage('img=' . $image . '&h=150&w=300&retina=false&crop=false'),
            wpimagebase(),
            sprintf(__('%s logo', 'TEXT_DOMAIN'), $title)
          );

          $img = sprintf('<div class="image"><a href="%s" title="%s">%s</a></div>',
            $link,
            sprintf(__('Find out more about %s', 'TEXT_DOMAIN'), $title),
            $logo
          );
          // Content
          $full = sprintf('<div class="content">
            <div class="title"><h2><a href="%1$s" title="%2$s">' . $title . '</a></h2></div>
            %3$s
            <div class="link"><a href="%1$s" title="%2$s" class="button small fill color-green">%4$s</a></div>
            </div>',
            $link,                                                                                                  // 1
            sprintf(__('Premalink to %s', 'TEXT_DOMAIN'), $title),                                                  // 2
            $short_description ? '<div class="short-description first-last">' . $short_description . '</div>' : '', // 3
            sprintf(__('Discover More', 'TEXT_DOMAIN'))                                                             // 4
          );

          $item .= $img . $full;

          $item .= '</div></div>';
        }

        $item .= '</div>';

        $item .= '</div>';
        $item .= $custom_class || $custom_id ? '</div>' : '';

      }
      wp_reset_query();

      return $item;
    }
  }

}