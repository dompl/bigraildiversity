<?php

namespace config;

use config\plugins\acf;
use config\setup\enqueue;
use config\setup\defaults;
use config\setup\cpt;
use config\theme\navigation;
use config\plugins\Disable_Plugins_When_Local_Dev;
use config\visual_composer\Visual_Composer_Initiator;

class init {

    private static $loaded = false;

    public function __construct() {
        $this->initClasses();
    }

    public function initClasses() {

        if (self::$loaded) {

            return false;

        }

        self::$loaded = true;

        /**
         * Initiate ACF Options page
         * Reffer to full documentation
         * @url https://www.advancedcustomfields.com/resources/acf_add_options_page/
         * Samle usage
         * $acf->init('page_title=Porfolio Settings&menu_title=Settings&menu_slug=portfolio-settings&parent_slug=edit.php?post_type=page');
         */
        $acf = new acf();

        $acf->init();

        /**
         * Initiate navigation
         */
        new navigation();

        /**
         * Initiate theme scripts
         * @var $jquery [include custom jquery instead of wordpress one. You can run in as an async. Settings in class enqueue]
         * @var $pjax   [Local   pages with pJax load. If disabled, remember to disable it in you gulpconfig file. No need to load it if set to false]
         */
        new enqueue($jquery = false, $pjax = false);

        /**
         * Theme setup - Mostly removes junk from header
         */
        new defaults();

        /* Visual Composer */
        new Visual_Composer_Initiator();

        /**
         * Theme setup - Custom post types
         */
        new cpt();

        /**
         * Disable plugins on local developmebt
         */
        if (defined('WP_LOCAL_DEV') && WP_LOCAL_DEV) {

            // Set plugins to disable
            $plugins = array(
                'vaultpress.php',
            );

            new Disable_Plugins_When_Local_Dev($plugins);
        }

    }

}
