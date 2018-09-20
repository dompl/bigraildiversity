<?php

namespace config\setup;

use config\setup\defaults;

class enqueue {

  public static $prefix = 'x';
  public static $jquery = true; // Use custom jQuery
  public static $pjax   = true; // Use pJax page load.

  public function __construct($jquery = true, $pjax = false) {

    self::$jquery = $jquery;
    self::$pjax   = $pjax;
    add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
    add_filter('clean_url', array(&$this, 'ks_async_scripts'), 11, 1);

  }

  // Create styles array
  public function styles() {

    $styles['style'] = array(
      'handle'    => 'ks-header-js',
      'file'      => 'style.css',
      'deps'      => array(),
      'version'   => THEME_VERSION,
      'media'     => 'screen',
      'condition' => true,
    );
    return $styles;
  }

  // Scripts array
  public function scripts() {

    // Install custom jQuery
    if (self::$jquery == true) {

      $scripts['jquery'] = array(
        'deps'      => array(),
        'version'   => '3.1.1',
        'in_footer' => false,
        'async'     => false,
        'condition' => ! is_admin(), // Add only in admin area
        'localize'  => false,
      );

    }

    $scripts['footer'] = array(
      'deps'      => array('jquery'),
      'version'   => THEME_VERSION,
      'in_footer' => true,
      'async'     => true,
      'condition' => true,
      'localize'  => self::$pjax ? array('is_ks_pjax' => 1) : false,
    );

    $scripts['header'] = array(
      'deps'      => array('jquery'),
      'version'   => THEME_VERSION,
      'in_footer' => false,
      'async'     => false,
      'condition' => true,
      'localize'  => self::$pjax ? array('is_ks_pjax' => 1) : false,
    );

    return $scripts;
  }

  /* Async function scripts */

  public function ks_async_scripts($url) {

    if (strpos($url, '#asyncload') === false) {

      return $url;

    } elseif (is_admin()) {

      return str_replace('#asyncload', '', $url);

    } else {

      return str_replace('#asyncload', '', $url) . "' async='async";
    }
  }

  /* Enqueue Scripts */
  public function enqueue_scripts() {

    // Disable WP Jquery (only in front end)
    if ( ! is_admin() && self::$jquery === true) {

      self::$jquery === true ? wp_deregister_script('jquery') : '';

    }

    // CSS Styles
    foreach ($this->styles() as $styles) {

      if ($styles['condition'] == true) {

        wp_enqueue_style($styles['handle'], get_template_directory_uri() . '/' . $styles['file'], $styles['deps'], $styles['version'], $styles['media']);

      }

    }

    // Js
    foreach ($this->scripts() as $key => $scripts) {

      $async = $scripts['async'] === true ? '#asyncload' : '';
      // Set handle. We need to do that as some plugins will require handle to be stricted to jquery
      $handle = $key === 'jquery' ? $key : 'ks-' . $key . 'js';

      if ($scripts['condition'] == true) {

        wp_enqueue_script($handle, get_template_directory_uri() . '/js/' . self::$prefix . '-' . $key . '.js' . $async, $scripts['deps'], $scripts['version'], $scripts['in_footer']);

        if ($scripts['localize'] !== false && is_array($scripts['localize'])) {

          // Add Wordpress Lcoalize scripts
          foreach ($scripts['localize'] as $variable => $value) {

            wp_localize_script($handle, $variable, array($value));

          }

        }

      }

    }

  }

}
