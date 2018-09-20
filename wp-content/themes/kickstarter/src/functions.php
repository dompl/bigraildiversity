<?php
/* Load classes with composer () */
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
  require_once dirname(__FILE__) . '/vendor/autoload.php';
}
//use mobiledetect\mobiledetectlib;
//$detect = new Mobile_Detect;
// Initiate theme config
if (class_exists('config\\init')) {
  new \config\init();
}
// Initiate theme files
if (class_exists('theme\\init')) {
  new \theme\init();
}

    function change_vc_rows() {

        // Add parameters we want
        vc_add_param('vc_row', array(
            'type' => 'textfield',
            'heading' => "HTML ID",
            'param_name' => 'element_id',
            'value' => '',
            'description' => __("Assign an ID to the row", "discprofile")
        ));

        // Update 'vc_row' to include custom vc_row template and remap shortcode
        $new_map = vc_map_update( 'vc_row', array('html_template' => locate_template('templates/vc_row.php')) );

        // Remove default vc_row
        vc_remove_element('vc_row');

        // Remap shortcode with custom template
        vc_map($new_map['vc_row']);
    }

    // Include our function when all wordpress stuff is loaded
    add_action( 'wp_loaded', 'change_vc_rows' );
