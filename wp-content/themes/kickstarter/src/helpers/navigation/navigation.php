<?php
/* Helper function for navigation */
use config\theme\navigation;

if (!function_exists('ks_nav')) {

    function ks_nav( $args = '' ) {

        $args = $args === '' ? navigation::$defaults : $args;

        return navigation::init($args);

    }
}
