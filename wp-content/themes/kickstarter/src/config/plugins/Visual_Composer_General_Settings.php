<?php

namespace config\plugins;

if ( ! class_exists('Visual_Composer_General_Settings')) {


  class Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array($this, 'vc_remove_elements')); // remove unwanted visual composer elements
      add_action('vc_before_init', array($this, 'vc_disable_front'));   // remove fron end editor
    }

    /* Remove unwanted VC elemenrs */
    public function vc_remove_elements() {
      if ( ! defined('WPB_VC_VERSION')) {
        return;
      }
      $elements = array('vc_wp_rss', 'vc_wp_archives', 'vc_wp_categories', 'vc_wp_text', 'vc_wp_posts', 'vc_wp_custommenu', 'vc_wp_tagcloud', 'vc_wp_pages', 'vc_wp_calendar', 'vc_wp_recentcomments', 'vc_wp_meta', 'vc_wp_search', 'vc_empty_space', 'vc_line_chart', 'vc_round_chart', 'vc_progress_bar', 'vc_masonry_media_grid', 'vc_masonry_grid', 'vc_basic_grid', 'vc_flickr', 'vc_widget_sidebar', 'vc_pie', 'vc_media_grid', 'vc_acf', /*'vc_gmaps',*/ 'vc_tta_tour', 'vc_tta_accordion', 'vc_tta_pageable', 'vc_custom_heading', 'vc_btn', 'vc_btn', 'vc_cta', 'vc_tta_tabs', 'vc_images_carousel', 'vc_gallery', 'vc_toggle', 'vc_pinterest', 'vc_googleplus', 'vc_icon', 'vc_separator', 'vc_zigzag', 'vc_message', 'vc_tweetmeme', 'vc_posts_slider', 'vc_video', 'vc_facebook', 'vc_hoverbox', 'vc_text_separator', 'vc_tabs', 'vc_tour', 'vc_accordion');

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
    public function css() {
      return array(get_template_directory_uri() . '/vc.css');
    }

    // Visual Composer Icon
    public function icon() {

      return get_template_directory_uri() . '/img/theme/vc_icon.png';

    }

    /* Exit visual composer */
    public function exit_vc() {

      if ( ! defined('WPB_VC_VERSION')) {
        return;
      }

    }

    /* Array of all website colour */
    public function colours($first = 'Default') {
      $colours = array(
        $first,
        'Orange light',
        'Orange dark',
        'Red light',
        'Red dark',
        'Purple light',
        'Purple dark',
        'Green light',
        'Green dark',
        'Blue light',
        'Blue dark',
        'Yellow',
        'White',
        'Black',
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
      return array($starting, '18px', '20px', '22px', '24px', '26px', '28px', '30px', '32px', '34px', '36px', '38px', '40px', '42px', '44px');
    }

    /* Line heights */
    public function line_heights($starting = '18px') {
      return array($starting, '20px', '22px', '24px', '26px', '28px', '30px', '32px', '34px', '36px', '38px', '40px', '42px', '44px', '44px', '46px', '48px', '50px');
    }

    /* Verticals space */

    public function vertical_space($replace = false) {

      $space = array(
        'Default',
        'None',
        'Small',
        'Large',
        'Tiny',
      );

      if ($replace === true) {
        $space = strtolower($space);
      }

      return $space;
    }
  }
}