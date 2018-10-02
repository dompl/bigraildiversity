<?php
/**
 * Create ACF Fields
 * ---
 */
namespace config\plugins;

use config\helpers\config;

class acf extends config {

    // Advanced Custom Fields activation key
    // const ACF_ACTIVATION_KEY = 'b3JkZXJfaWQ9NDA5NzF8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE0LTA5LTMwIDE0OjIxOjUy';

    public function __construct() {

        /* Get config class constructor */
        if (function_exists('acf')) {

            add_filter('acf/settings/save_json', array(&$this, 'ks_json_save_point')); // Change json save points
            add_filter('acf/settings/load_json', array(&$this, 'ks_json_load_point')); // Change json load points

            // Activate Advanced Custom Fileds Key
            // if (is_admin() && ! acf_pro_get_license_key()) {
            //     acf_pro_update_license(self::ACF_ACTIVATION_KEY);
            // }
        }

    }

    /* Set save point for ACF json files in src file for development */
    public function ks_json_save_point($path) {

        // remove original path (optional)
        $path = realpath(__DIR__ . '/../../../src/json/acf');

        // return
        return $path;

    }

    /* Set load points for ACF json files in theme */
    public function ks_json_load_point($paths) {

        // remove original path (optional)
        unset($paths[0]);

        // append path
        $paths[] = get_stylesheet_directory() . '/json/acf';

        // return
        return $paths;

    }

    /* Set default settings for General oprions in theme */
    public function defaults() {

        return array(
            'page_title'  => 'General Options',
            'menu_title'  => 'General Options',
            'menu_slug'   => 'theme-options',
            'capability'  => 'edit_posts',
            'position'    => false,
            'parent_slug' => false,
            'icon_url'    => 'dashicons-admin-plugins',
            'redirect'    => false,
            'post_id'     => 'options',
            'autoload'    => false,
        );

    }

    /* Get pafet menu slug for acf field */
    public function parent() {

        return $this->defaults()['menu_slug'];

    }

    /* Initiate ACF options page */
    public function init($args = '') {

        // Exit if ACF is OFF
        if ( ! function_exists('acf_add_options_page')) {
            return;
        }

        // Parase args
        $args = $this->ks_parse_args($args, $this->defaults());

        // Add optin page with parased args
        acf_add_options_page($args);
    }

}
