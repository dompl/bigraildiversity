<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;
use WP_Screen;
if ( ! class_exists('VC_BDRCS_Page_Image')) {

  class VC_BDRCS_Page_Image extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BDRCS_Page_Image_section_map'));
      add_shortcode('VC_BDRCS_Page_Image_shortcode', array(&$this, 'VC_BDRCS_Page_Image_shortcode_callback'));
    }

    /**
     * Params
     * ---
     */
    public function params() {

      $params = array(
        array(
          'type'        => 'custom_radio',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('New year', 'TEXT_DOMAIN'),
          'param_name'  => 'year',
          'admin_label' => true,
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => $this->years(),
          'description' => __('In which year this challenge was new', 'TEXT_DOMAIN'),
          'std'         => date('Y') + 1,
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
    public function VC_BDRCS_Page_Image_section_map() {

      $title       = 'Page image';                       // Shortcode description
      $description = 'Display image from page settings'; // Shortcode Name

      vc_map(
        array(
          'name'                    => __($title, 'TEXT_DOMAIN'),
          'base'                    => 'VC_BDRCS_Page_Image_shortcode',
          'class'                   => '',
          'show_settings_on_create' => false,
          'category'                => $this->tab_category(),
          'icon'                    => $this->icon('icon-image.svg'),
          'description'             => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css'       => $this->admin_css(),
          'params'                  => $this->params(),
        )
      );
    }

    public function VC_BDRCS_Page_Image_shortcode_callback($atts, $content = null) {

      if (get_field('challenge_main_image') != '') {
        $image = get_field('challenge_main_image');
      } elseif (get_field('add_attendee_logo')) {
        $image = get_field('add_attendee_logo');
      } else {
        return;
      }

      extract(shortcode_atts(array(
        'year'         => date('Y') + 1,
        'space_above'  => __('None', 'TEXT_DOMAIN'),
        'space_below'  => __('None', 'TEXT_DOMAIN'),
        'custom_class' => '',
        'custom_id'    => '',
      ), $atts));

      $item         = '';
      $custom_class = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id    = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      $item .= $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';
      $item .= '<div class="' . $this->pixels_class($space_above, 'spacer-top') . ' ' . $this->pixels_class($space_below, 'spacer-bottom') . '">';

      $batch = '';

      if ((get_field('new_batch') == 1)) {
        $batch_image = wp_upload_dir()['baseurl'] . '/2018/10/batch-' . $year . '.png';
        $batch       = sprintf('<div class="batch"><img src="%s" data-src="%s" alt="%s" class="lazy"></div>',
          wpimagebase(),
          wpimage('img=' . $batch_image . '&height=150&w=150&upscale=true&crop=true&single=true&retina=true'),
          sprintf(__('%s is a new challenge for %s'), the_title_attribute('echo=0'), $year)
        );
      }
      // additional_challenge_images
      $images            = array($image);
      $additional_images = get_field('additional_challenge_images');

      if ($additional_images != '') {

        $this->require()['slick'];

        foreach ($additional_images as $additional_image) {
          $images[] = $additional_image['ID'];
        }
      }

      $slider_images = '';
      $i = 1;
      foreach ($images as $image) {
        $slider_images .= sprintf('<div class="item clx"><img %s="%s" alt="%s"></div>',
          $additional_images != '' ? ( $i == 1 ? 'class="lazy" data-src' : 'data-lazy' ) : 'class="lazy" data-src',
          wpimage('img=' . $image . '&h=566&w=840&upscale=true&crop=true&single=true&retina=false'),
          the_title_attribute('echo=0&posts=' . get_the_ID())
        );
        $i++;
      }

      $item .= sprintf('<div class="page-image"><div class="%s">%s</div>%s<div>',
        $additional_images != '' ? 'page-image-slider sli' : '',
        $slider_images,
        $batch
      );

      $item .= '</div>';
      $item .= $custom_class || $custom_id ? '</div>' : '';

      return $item;
    }
  }

}