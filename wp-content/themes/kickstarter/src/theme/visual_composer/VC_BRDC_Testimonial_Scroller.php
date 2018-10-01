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
          'heading'     => __('Display', 'TEXT_DOMAIN'),
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
          'heading'     => __('Source', 'TEXT_DOMAIN'),
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

        array(
          'type'        => 'numeric',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Limit', 'TEXT_DOMAIN'),
          'param_name'  => 'limit',
          'group'       => __('Settings', 'TEXT_DOMAIN'),
          'value'       => '',
          'description' => __('Limit the amount of testimonials to showin in slider', 'TEXT_DOMAIN'),
          'dependency'  => array(
            'element' => 'content_cource',
            'value'   => array('all'),
          ),
        ),

        array(
          'type'       => 'checkbox',
          'holder'     => 'div',
          'class'      => 'vc_hidden',
          'heading'    => __('Randomise', 'TEXT_DOMAIN'),
          'param_name' => 'order',
          'group'      => __('Settings', 'TEXT_DOMAIN'),
          'value'      => array(__('Randomise testimonials', 'TEXT_DOMAIN') => true),
          'std'        => false,
          'dependency' => array(
            'element' => 'content_cource',
            'value'   => array('all'),
          ),
        ),

        array(
          'type'        => 'numeric',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Autoplay Speed', 'TEXT_DOMAIN'),
          'param_name'  => 'speed',
          'group'       => __('Settings', 'TEXT_DOMAIN'),
          'value'       => 2,
          'std'         => false,
          'description' => __('Set autoplay speed (in seconds)' , 'TEXT_DOMAIN'),
          'dependency'  => array(
            'element' => 'content_cource',
            'value'   => array('all'),
          ),
        ),

        $this->param_space('above'),
        $this->param_space('below'),
        $this->prevent_space_on_mobile(),
        $this->param_additional_id('custom_id', 'Settings'),
        $this->param_additional_class('custom_class', 'Settings'),
      );
      return $params;
    }

    public function specific_testimonials() {

      $args = array(
        'posts_per_page' => -1,
        'post_type'      => array('challenges', 'atendees', 'supportingorgs'),
        'meta_query'     => array(
          array(
            'key'     => 'testimonials_list',
            'value'   => array(''),
            'compare' => 'NOT IN',
          ),
        ),
      );
      $posts = get_posts($args);

      $items = array();
      if ($posts) {

        foreach ($posts as $post) {
          $id         = $post->ID;
          $name       = get_the_title($id);
          $items[$id] = $name;
        }
      }
      wp_reset_postdata();
      wp_reste_query();
      return $item;
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
        'limit'          => '',
        'speed'          => 2,
        'order'          => false,
        'custom_class'   => '',
        'custom_id'      => '',
      ), $atts));

      if ($fromwho == '' || $options == '') {
        return;
      }

      $speed = ($speed * 1000);

      $options = explode(',', $options);
      $fromwho = explode(',', $fromwho);
      $limit   = $limit == '' ? -1 : (int) $limit;
      $args    = array(
        'posts_per_page' => $limit,
        'meta_query'     => array(
          array(
            'key'     => 'testimonials_list',
            'value'   => array(''),
            'compare' => 'NOT IN',
          ),
        ),
      );

      if ($content_cource == 'all') {
        $args['post_type'] = (array) $fromwho;
      } elseif ($content_cource == 'current') {
        $args['post_type'] = get_post_type();
        $args['post__in']  = array(get_the_ID());
      }

      if ($order == true && $content_cource == 'all') {
        $args['orderby'] = 'rand';
      }

      $posts = get_posts($args);

      $item         = '';
      $custom_class = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id    = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      $item .= $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';
      $item .= '<div class="' . $this->pixels_class($space_above, 'spacer-top') . ' ' . $this->pixels_class($space_below, 'spacer-bottom') . '">';

      $item .= '<div class="testimonials">';
      $item .= '<ul class="testimonial-slider list-unstyled" data-slick=\'{"autoplaySpeed": '.$speen.'}\'>';
      foreach ($posts as $post) {

        $id = $post->ID;
        $i  = 1;

        if (have_rows('testimonials_list', $id)) {

          while (have_rows('testimonials_list', $id)) {
            the_row();

            $logo = get_field('add_attendee_logo', $id);

            if (imagedata($logo)['width'] < (imagedata($logo)['height'] * 1.5)) {
              $width = 100;
            } else {
              $width = 200;
            }

            if (get_sub_field('testimonial', $id) != '' && get_sub_field('in_slider', $id) == true) {
              $item .= sprintf(
                '<li class="clx">%s%s%s%s%s</li>',
                '<div class="full-tesimonial">' . get_sub_field('testimonial') . '</div>',
                get_sub_field('person') && in_array('person_name', $options) ? '<div class="person">' . get_sub_field('person') . '</div>' : '',
                get_sub_field('company') && in_array('company_name', $options) ? '<div class="company">' . str_replace('%company%', get_the_title($id), get_sub_field('company')) . '</div>' : '',
                get_field('add_attendee_logo', $id) && in_array('company_logo', $options) ? '<div class="logo"><a href="' . esc_url(get_the_permalink($id)) . '" title="' . __('Discover more about', 'TEXT_DOMAIN') . ' ' . the_title_attribute('echo=0&post=' . $id) . '"><img src="' . wpimage('img=' . get_field('add_attendee_logo', $id) . '&h=100&w=300&crop=fale') . '" alt="' . the_title_attribute('echo=0&post=' . $id) . ' ' . __('logo', 'TEXT_DOMAIN') . '" /></a></div>' : '',
                get_field('attendee_website_url', $id) && in_array('company_url', $options) ? '<div class="website"><a href="' . esc_url(get_field('attendee_website_url', $id)) . '" target="_blank">' . __('Visit', 'TEXT_DOMAIN') . ' ' . get_the_title($id) . ' ' . __('website', 'TEXT_DOMAIN') . '</a></div>' : ''
              );
            }
            $i++;
          }
        }
      }
      wp_reset_postdata();
      $item .= '</ul>';
      $item .= '</div>';

      $item .= '</div>';
      $item .= $custom_class || $custom_id ? '</div>' : '';

      return $item;
    }
  }

}