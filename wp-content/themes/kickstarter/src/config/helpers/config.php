<?php
/**
 * Global theme helpers
 * ---
 */
namespace config\helpers;

class config {

    public function __construct() {}

    /* Parase Args helper function */
    public function ks_parse_args(  $args = '',  $defaults = '') {

        $args = ($args == '') ? $defaults : wp_parse_args($args, $defaults);

        return $args;

    }
}
