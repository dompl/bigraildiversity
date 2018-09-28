<?php
/**
 * Default Theme settings
 * ---
 */
namespace config\setup;

class defaults {

  public function __construct() {

    add_action('init', array(&$this, 'global_variables'));                                // Set theme global variables
    add_action('init', array(&$this, 'navigation_setup'), 10);                            // Register navigation
    add_action('init', array(&$this, 'remove_junk'), 10);                                 // remove junk from WP header
    add_action('after_theme_setup', array(&$this, 'content_width'));                      // Set default content width
    add_action('wp_footer', array(&$this, 'deregister_scripts'), 10);                     // deregister all unvanted scripts
    add_filter('emoji_svg_url', array(&$this, '__return_false'));                         // Remove emojis
    add_filter('embed_oembed_discover', array(&$this, '__return_false'));                 // Turn off oEmbed auto discovery.
    add_filter('post_thumbnail_html', array(&$this, 'remove_thumbnail_dimenstions'), 10); // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', array(&$this, 'wp_filter_oembed_result'));          // Don'tfilteroEmbedresults .
    add_action('admin_menu', array(&$this, 'remove_menus'));

  }

  /**
   * Remove menu pages
   * ---
   */
  public function remove_menus() {

    if (get_current_user_id() == 1) {
      return;
    }

    global $submenu;

    remove_menu_page('themepacific_jp_gallery'); //Settings
    remove_menu_page('jetpack');             //Jetpack*
    remove_menu_page('edit.php');            //Posts
    remove_menu_page('edit-comments.php');   //Comments
    remove_menu_page('users.php');           //Users
    remove_menu_page('tools.php');           //Tools
    remove_menu_page('options-general.php'); //Settings


    remove_menu_page('vc-general');                   // Visual Composer
    remove_submenu_page('themes.php', 'widgets.php'); //Widgets
    remove_submenu_page('themes.php', 'themes.php');  //Widgets
    remove_submenu_page('themes.php', 'editor.php');  //Widgets
    remove_menu_page('plugins.php');                  //Plugins
  }


// Global Variables
public function global_variables() {

  define('TEXT_DOMAIN', 'bigrail');
  define('THEME_VERSION', '1.0.0');

}

// Set content width
// public function content_width($ks_content_width = 1200) {

//   global $content_width;

//   if ( ! isset($content_width)) {
//     $content_width = $ks_content_width;
//   }

//   return $content_width;
// }

// Register navigations
public function navigation_setup() {

  register_nav_menu('header', esc_html__('Header menu', TEXT_DOMAIN));
  register_nav_menu('footer', esc_html__('Footer menu', TEXT_DOMAIN));

}

/**
 * Remove oembed
 * Removed only on production servers
 */
public function deregister_scripts() {

  if (WP_DEBUG == false) {
    wp_deregister_script('wp-embed');
  }

  return;
}

public function remove_junk($remove_junk = true) {
  if ($remove_junk === false) {
    return;
  }

  /* REMOVE WORDPRESS HEADER META */
  remove_action('wp_head', 'rsd_link');                            // remove really simple discovery link
  remove_action('wp_head', 'wp_generator');                        // remove wordpress version meta tag
  remove_action('wp_head', 'feed_links', 2);                       // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
  remove_action('wp_head', 'feed_links_extra', 3);                 // removes all extra rss feed links
  remove_action('wp_head', 'index_rel_link');                      // remove link to index page
  remove_action('wp_head', 'wlwmanifest_link');                    // remove wlwmanifest.xml (needed to support windows live writer)
  remove_action('wp_head', 'start_post_rel_link', 10);             // remove random post link
  remove_action('wp_head', 'parent_post_rel_link', 10);            // remove parent post link
  remove_action('wp_head', 'adjacent_posts_rel_link', 10);         // remove the next and previous post links
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10); // remove the next and previous post links
  remove_action('wp_head', 'wp_shortlink_wp_head', 10);            // remove wp shortlink

  /*  REMOVE EMOJIS: */
  remove_action('wp_head', 'print_emoji_detection_script', 7);          // Emoji Scripts and Styles
  remove_action('admin_print_scripts', 'print_emoji_detection_script'); // Emoji Scripts and Styles
  remove_action('wp_print_styles', 'print_emoji_styles');               // Emoji Scripts and Styles
  remove_action('admin_print_styles', 'print_emoji_styles');            // Emoji Scripts and Styles

  /* REMOVE REST API */
  remove_action('wp_head', 'rest_output_link_wp_head', 10);      // Remove the REST API lines from the HTML Header (api.w.org)
  remove_action('wp_head', 'wp_oembed_add_discovery_links', 10); // Remove the REST API lines from the HTML Header (api.w.org)
  remove_action('rest_api_init', 'wp_oembed_register_route');    // Remove the REST API endpoint.

}

public function remove_thumbnail_dimenstions($html) {
  $html = preg_replace('/(width|height)=\"\d*\"\s/', '', $html);
  return $html;
}

public function __return_false() {
  return false;
}
}
