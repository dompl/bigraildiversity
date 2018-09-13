<?php
namespace theme;

use theme\header\banner;

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

        /* Page banner */
        new banner();

    }

}
