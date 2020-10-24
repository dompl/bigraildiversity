<?php
/* Load classes with composer () */
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}
//use mobiledetect\mobiledetectlib;
//$detect = new Mobile_Detect;
// Initiate theme config
if ( class_exists( 'config\\init' ) ) {
    new \config\init();
}
// Initiate theme files
if ( class_exists( 'theme\\init' ) ) {
    new \theme\init();
}

/* Add resonsive youtube vide ( youtube ) */
/**
 * @param $atts
 */
function youtube( $atts )
{
    return '<div class="videoWrapper"><iframe width="560" height="315" src="https://www.youtube.com/embed/' . $atts['id'] . '?rel=0" frameborder="0" allowfullscreen></iframe></div>';
}
add_shortcode( 'youtube', 'youtube' );

/**
 * @param $atts
 */
function vimeo( $atts )
{
    return '<div class="embed-container"><iframe src="https://player.vimeo.com/video/' . $atts['id'] . '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
}
add_shortcode( 'vimeo', 'vimeo' );