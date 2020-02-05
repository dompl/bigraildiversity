<?php
/*  ********************************************************
 *   this
 *  ********************************************************
 */
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


function acf_load_years($field)
{

    // reset choices
    $field['choices'] = array();

    $current_year = date('Y') + 1;

    $i = 2016;
    while ($i <= $current_year) {
        $field['choices'][ $i ] = $i;
        $i++;
    }

    // return the field
    return $field;
}

add_filter('acf/load_field/key=field_5bab62438990d', 'acf_load_years');