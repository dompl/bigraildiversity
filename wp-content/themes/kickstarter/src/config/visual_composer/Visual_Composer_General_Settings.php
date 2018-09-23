<?php

namespace config\visual_composer;
use config\visual_composer\Visual_Composer_Additional_Params;

if ( ! class_exists('Visual_Composer_General_Settings')) {

  class Visual_Composer_General_Settings extends Visual_Composer_Additional_Params {

    public function __construct() {
      add_action('vc_before_init', array($this, 'vc_remove_elements'));                  // remove unwanted visual composer elements
      add_action('vc_before_init', array($this, 'vc_disable_front'));                    // remove fron end editor
      add_action('vc_before_init', array($this, 'set_visual_composer_template_folder')); // add template folder
      add_filter('acf/load_field/key=field_5ba7604b316da', array(&$this, 'acf_load_dates'));
      add_filter('acf/load_field/key=field_5ba75fbd316d9', array(&$this, 'acf_load_dates'));
    }

    public function replace_brackets_with_tags($field = '') {

      $field = str_replace(array('{', '}'), array('<', '>'), $field);
      return $field;
    }

    /* Remove unwanted VC elemenrs */
    public function vc_remove_elements() {
      if ( ! defined('WPB_VC_VERSION')) {
        return;
      }
      $elements = array('vc_wp_rss', 'vc_wp_archives', 'vc_wp_categories', 'vc_wp_text', 'vc_wp_posts', 'vc_wp_custommenu', 'vc_wp_tagcloud', 'vc_wp_pages', 'vc_wp_calendar', 'vc_wp_recentcomments', 'vc_wp_meta', 'vc_wp_search', 'vc_empty_space', 'vc_line_chart', 'vc_round_chart', 'vc_progress_bar', 'vc_masonry_media_grid', 'vc_masonry_grid', 'vc_basic_grid', 'vc_flickr', 'vc_widget_sidebar', 'vc_pie', 'vc_media_grid', 'vc_acf', /*'vc_gmaps',*/'vc_tta_tour', 'vc_tta_accordion', 'vc_tta_pageable', 'vc_custom_heading', 'vc_btn', 'vc_btn', 'vc_cta', 'vc_tta_tabs', 'vc_images_carousel', 'vc_gallery', 'vc_toggle', 'vc_pinterest', 'vc_googleplus', 'vc_icon', 'vc_separator', 'vc_zigzag', 'vc_message', 'vc_tweetmeme', 'vc_posts_slider', 'vc_video', 'vc_facebook', 'vc_hoverbox', 'vc_text_separator', 'vc_tabs', 'vc_tour', 'vc_accordion', 'vc_single_image');

      foreach ($elements as $element) {
        vc_remove_element($element);
      }
    }

    /* Disable front end */
    public function vc_disable_front() {
      if ( ! defined('WPB_VC_VERSION')) {
        return;
      }
      vc_disable_frontend();
    }

    /* Add admin CSS */
    public function admin_css() {
      return array(get_template_directory_uri() . '/vc.css');
    }

    // Visual Composer Icon
    public function icon() {
      return get_template_directory_uri() . '/img/theme/vc_icon.png';
    }

    /* Gengeral category insde the visual composer (tab) */
    public function tab_category($category = null) {

      if ($category == null) {
        return __('Big Rail', 'TEXT_DOMAIN');
      } else {
        return __($category, 'TEXT_DOMAIN');
      }
    }

    /* Exit visual composer */
    public function exit_vc() {

      if ( ! defined('WPB_VC_VERSION')) {
        return;
      }

    }

    /* Array of all website colour */
    public function brdc_colours($replace = false) {
      $colours = array(
        'Default',
        'White',
        'Gray Light',
        'Balck',
        'Green',
        'WIR',
        'Purple Light',
        'Purple medium',
        'Purple dark',
        'Red',
        'Orange',
        'Blue light',
        'Blue dark',
        'Pink',
      );
      return $colours;
    }

    /* Replace colurr */
    function colour_build($colour = '') {

      if ( ! $colour) {
        return;
      }
      $colours = strtolower(str_replace(' ', '-', $colour));
      return $colours;
    }

    /* Font sizes */
    public function font_sizes($starting = '16px') {
      return array($starting, '18px', '20px', '22px', '24px', '26px', '28px', '30px', '32px', '34px', '36px', '38px', '40px', '42px', '44px', '46px', '48px', '50px');
    }

    /* Line heights */
    public function line_heights($starting = '18px') {
      return array($starting, '20px', '22px', '24px', '26px', '28px', '30px', '32px', '34px', '36px', '38px', '40px', '42px', '44px', '44px', '46px', '48px', '50px', '52px', '54px');
    }

    // Remove pixels
    public function pixels_class($string = false, $class = false) {
      if ( ! $string || ! $class || $string == 'None') {
        return;
      }
      $string = str_replace(' ', '-', $string);
      return strtolower($class) . '-' . str_replace('px', '', strtolower($string));
    }

    // set

    /* Verticals space */

    public function vertical_space($use_none = true) {

      $space = array(
        __('Small', 'TEXT_DOMAIN'),
        __('Default', 'TEXT_DOMAIN'),
        __('Medium', 'TEXT_DOMAIN'),
        __('Large', 'TEXT_DOMAIN'),
        __('Extra Large', 'TEXT_DOMAIN'),
      );
      if ($use_none === true) {
        $space[] = __('None', 'TEXT_DOMAIN');
      }

      return $space;
    }

    public function acf_load_years() {
      return range(2016, (date('Y') + 1));
    }

    public function years() {
      $years = array();
      foreach ($this->acf_load_years() as $year) {
        $years[$year] = $year;
      }
      return $years;
    }

    public function acf_load_dates($field) {

      $field['choices'] = array();
      $years            = $this->acf_load_years();

      foreach ($this->acf_load_years() as $choice) {

        $value                     = $years[0];
        $label                     = $years[0];
        $field['choices'][$value]  = $label;
        $field['choices'][$choice] = $choice;
      }
      return $field;
    }

    /* Ser visual composer template foldee */

    public function set_visual_composer_template_folder() {
      $templage_folder = get_stylesheet_directory() . '/theme/visual_composer/templates';
      vc_set_shortcodes_templates_dir($templage_folder);
    }
  }
}