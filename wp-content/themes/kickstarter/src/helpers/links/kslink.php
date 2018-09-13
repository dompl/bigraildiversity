<?php

function kslink($link_array = '', $link_close = true, $link_classes = '', $method = '', $data = '') {

    if (empty($link_array) || ! is_array($link_array)) {
        return;
    }

    $link = new config\helpers\link($link_array, $link_close, $link_classes, $data);

    switch ($method) {

    case 'title':
        $link_data = $link->title();
        break;

    case 'href':
        $link_data = $link->href();
        break;

    default:
        $link_data = $link->html();
        break;
    }

    return $link_data;

};
