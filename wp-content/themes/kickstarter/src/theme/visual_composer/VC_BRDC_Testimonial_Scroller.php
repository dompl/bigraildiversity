<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_BRDC_Testimonial_Scroller')) {

  class VC_BRDC_Testimonial_Scroller extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_Testimonial_Scroller_section_map'));
      add_shortcode('VC_BRDC_Testimonial_Scroller_shortcode', array(&$this, 'VC_BRDC_Testimonial_Scroller_shortcode_callback'));
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
          'admin_label' => true,
          'heading'     => __('Settings', 'TEXT_DOMAIN'),
          'param_name'  => 'content_cource',
          'group'       => __('Settings', 'TEXT_DOMAIN'),
          'value'       => array(
            __('From current page', 'TEXT_DOMAIN') => 'current',
            __('All testimonials', 'TEXT_DOMAIN')  => 'all',
          ),
          'description' => __('Select testimonial source', 'TEXT_DOMAIN'),
          'std'         => 'current',
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Settings', 'TEXT_DOMAIN'),
          'param_name'  => 'options',
          'group'       => __('Settings', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Display person\'s name', 'TEXT_DOMAIN')      => 'person_name',
            __('Display company name', 'TEXT_DOMAIN')        => 'company_name',
            __('Display company logo', 'TEXT_DOMAIN')        => 'company_logo',
            __('Display company website URL', 'TEXT_DOMAIN') => 'company_url',
          ),
          'description' => __('Set display settings for your testinonial slder', 'TEXT_DOMAIN'),
          'std'         => 'person_name,company_name,company_logo,company_url',
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Settings', 'TEXT_DOMAIN'),
          'param_name'  => 'fromwho',
          'group'       => __('Settings', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Challanges testimonials', 'TEXT_DOMAIN')               => 'challenges',
            __('Atendees testimonials', 'TEXT_DOMAIN')                 => 'atendees',
            __('Supporting organisations testimonials', 'TEXT_DOMAIN') => 'supportingorgs',
          ),
          'description' => __('From who would you like to show the testinomials from', 'TEXT_DOMAIN'), #
          'std'         => 'challenges,atendees,supportingorgs',
        ),

        $this->param_text_alignment('align'),
        $this->param_space('above'),
        $this->param_space('below'),
        $this->prevent_space_on_mobile(),
        $this->param_additional_id('custom_id', 'Settings'),
        $this->param_additional_class('custom_class', 'Settings'),
      );
      return $params;
    }

    /**
     * Visual Composer Map
     * ---
     */
    public function VC_BRDC_Testimonial_Scroller_section_map() {

      $title       = 'Testimonial Scroller';     // Shortcode description
      $description = 'Add testimonial scroller'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_BRDC_Testimonial_Scroller_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon('icon-testiomonials.svg'),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_BRDC_Testimonial_Scroller_shortcode_callback($atts, $content = null) {

      extract(shortcode_atts(array(
        'options'        => 'person_name,company_name,company_logo,company_url',
        'fromwho'        => 'challenges,atendees,supportingorgs',
        'content_cource' => 'current',
        'space_above'    => __('None', 'TEXT_DOMAIN'),
        'space_below'    => __('None', 'TEXT_DOMAIN'),
        'align'          => __('Left', 'TEXT_DOMAIN'),
        'custom_class'   => '',
        'custom_id'      => '',
      ), $atts));

      if ($fromwho == '' || $options == '') {
        return;
      }

      $options = explode(',', $options);
      $fromwho = explode(',', $fromwho);
      $args    = array(
        'posts_per_page' => -1,
      );

      if ($content_cource == 'all') {
        $args['post_type'] = (array) $fromwho;
      } elseif ($content_cource == 'current') {
        $args['post_type'] = get_post_type();
        $args['post__in']  = array(get_the_ID());
      }

      $posts = get_posts($args);
      $item         = '';
      $custom_class = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id    = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      $item .= $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';
      $item .= '<div class="' . $this->pixels_class($align, 'align') . ' ' . $this->pixels_class($space_above, 'spacer-top') . ' ' . $this->pixels_class($space_below, 'spacer-bottom') . '">';

      $item .= '<ul class="testimonial-slider list-unstyled">';
      foreach ($posts as $post) {

        $id = $post->ID;

        if (have_rows('testimonials_list', $id)) {

          while (have_rows('testimonials_list', $id)) {
            the_row();
            if (get_sub_field('testimonial', $id) != '' && get_sub_field('in_slider', $id) == true) {

              $item .= sprintf(
                '<li>%s%s%s%s%s</li>',
                '<div class="full-tesimonial">' . get_sub_field('testimonial') . '</div>',
                get_sub_field('person') && in_array('person_name', $options) ? '<div class="person">' . get_sub_field('person') . '</div>' : '',
                get_sub_field('company') && in_array('company_name', $options) ? '<div class="person">' . str_replace('%company%', get_the_title($id), get_sub_field('company')) . '</div>' : '',
                get_field('add_attendee_logo', $id) && in_array('company_logo', $options) ? '<img src="'.wpimage('img=' . get_field('add_attendee_logo', $id)).'" alt="'.get_the_title().'>' : '',
                get_field('attendee_website_url') && in_array('company_url', $options) ? '<div class="website"><a href="' . esc_url(get_field('attendee_website_url')) . '" target="_blank">' . __('Visit', 'TEXT_DOMAIN') . ' ' . get_the_title($id) . ' ' . __('website', 'TEXT_DOMAIN') . '</a></div>' : ''
              );
            }
          }}
      }
      wp_reset_postdata();
      $item .= '</ul>';

      $item .= '</div>';
      $item .= $custom_class || $custom_id ? '</div>' : '';

      return $item;
    }
  }

}