<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_RBDC_Page_Banner')) {

  class VC_RBDC_Page_Banner extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_RBDC_Page_Banner_section_map'));
      add_shortcode('VC_RBDC_Page_Banner_shortcode', array(&$this, 'VC_RBDC_Page_Banner_shortcode_callback'));
    }

    public function colours() {
      return array(
        __('Randomize colours', 'TEXT_DOMAIN')             => 'bcg-random',
        __('WIR Green background', 'TEXT_DOMAIN')          => 'bcg-green',
        __('WIR Blue background', 'TEXT_DOMAIN')           => 'bcg-blue',
        __('BRDC Pink background', 'TEXT_DOMAIN')          => 'bcg-pink',
        __('BRDC Green background', 'TEXT_DOMAIN')         => 'bcg-brdc-green',
        __('BRDC Purple Light background', 'TEXT_DOMAIN')  => 'bcg-purple-light',
        __('BRDC Purple Medium background', 'TEXT_DOMAIN') => 'bcg-purple-medium',
        __('BRDC Purple Dark background', 'TEXT_DOMAIN')   => 'bcg-purple-dark',
        __('BRDC Red background', 'TEXT_DOMAIN')           => 'bcg-red',
        __('BRDC Orange background', 'TEXT_DOMAIN')        => 'bcg-orange',
        __('BRDC Blue Light background', 'TEXT_DOMAIN')    => 'bcg-blue-light',
        __('BRDC Blue Dark background', 'TEXT_DOMAIN')     => 'bcg-blue-dark',
      );
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
          'heading'     => __('Banner type', 'TEXT_DOMAIN'),
          'param_name'  => 'type',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Background colour', 'TEXT_DOMAIN')    => 'new',
            __('Legacy (with images)', 'TEXT_DOMAIN') => 'legacy',
          ),
          'description' => __('Set banner type', 'TEXT_DOMAIN'),
          'std'         => 'new',
        ),
        array(
          'type'        => 'dropdown',
          'heading'     => __('Container background', 'TEXT_DOMAIN'),
          'param_name'  => 'bcg',
          'std'         => 'bcg-random',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'weight'      => 1.1,
          'value'       => $this->colours(),
          'description' => __('Set background colour', 'TEXT_DOMAIN'),
          'dependency'  => array(
            'element' => 'type',
            'value'   => array('new'),
          ),
        ),
        array(
          'type'        => 'textfield',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Banner title', 'TEXT_DOMAIN'),
          'param_name'  => 'title',
          'admin_label' => true,
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => __('%title%', 'TEXT_DOMAIN'),
          'description' => __('Leave variable %title% to display page title.', 'TEXT_DOMAIN'),
        ),
        array(
          'type'        => 'textfield',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'admin_label' => true,
          'heading'     => __('Banner subtitle', 'TEXT_DOMAIN'),
          'param_name'  => 'subtitle',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => '',
          'description' => __('Add subtitles for banner', 'TEXT_DOMAIN'),
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'admin_label' => false,
          'heading'     => __('Upper case title', 'TEXT_DOMAIN'),
          'param_name'  => 'uppercase',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(__('Display title in upper case', 'TEXT_DOMAIN') => true),
          'std'         => true,
        ),
      );
      return $params;
    }

    /**
     * Visual Composer Map
     * ---
     */
    public function VC_RBDC_Page_Banner_section_map() {

      $title       = 'Page banner';     // Shortcode description
      $description = 'Add page banner'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_RBDC_Page_Banner_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon(),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_RBDC_Page_Banner_shortcode_callback($atts, $content = null) {

      extract(shortcode_atts(array(
        'title'     => '%title%',
        'bcg'       => 'bcg-random',
        'subtitle'  => '',
        'type'      => 'new',
        'uppercase' => true,
      ), $atts));

      $title   = str_replace('%title%', wp_kses_post(get_the_title()), $title); // Get page title
      $pattern = get_field('background_pattern', 'options');                    // Get patttern backgrounf
      $images  = get_field('page_banners', 'options');                          // get background image
      $size    = 200;                                                           // banner height
      $uc      = $uppercase ? 'uc' : 'lc';

      foreach ($colours as $colour) {
        # code...
      }

      // Create banner background image
      $background_image   = '';
      $background_pattern = '';

      if ($type == 'legacy') {

        if ($pattern) {
          $img                = $images[array_rand($images)];
          $background_pattern = sprintf('  data-src="%s" class="lazy background-pattern"', wpimage('img=' . (int) $pattern . '&h=' . get_field('background_pattern_size', 'options') . '&w=999999&crop=false&upscale=true&retina=false'));
          $background_image   = sprintf('  data-src="%s" class="lazy background-image"', wpimage('img=' . (int) $img['ID'] . '&h=' . $size . '&w=999999&crop=false&upscale=true&retina=true'));
        }

      } else {

        if ($bcg == '' || $bcg == 'bcg-random') {

          $abc = $this->colours();

          unset($abc['Randomize colours']);
          unset($abc['WIR Green background']);
          unset($abc['WIR Blue background']);

          $abc = array_rand($abc, 1);

          $background_pattern = ' class="' . $this->colours()[$abc] . '"';

        } else {

          $background_pattern = ' class="bcg-banner bcg-' . $bcg . '"';

        }

        $background_image = ' class="banner-logo"';

      }

      $item .= '<section class="page-banner banner-'.get_the_ID().' style-' . $type . '">';
      $item .= "<div $background_pattern>";
      $item .= '<div class="inner">';
      $item .= $images ? "<div $background_image>" : '';
      $item .= '<div class="banner"><div class="container">';
      $item .= $title ? "<div class='title-container'><h1 class='page-title $type $uc'>$title</h1></div>" : '';
      $item .= $subtitle ? "<div class='subtitle-container'><p>$subtitle</p></div>" : '';
      $item .= '</div></div>';
      $item .= $images ? '</div>' : '';
      $item .= '</div>';
      $item .= $pattern ? '</div>' : '';
      $item .= '<div class="bar"></div>';
      $item .= '</section>';
      return $item;

    }
  }

}