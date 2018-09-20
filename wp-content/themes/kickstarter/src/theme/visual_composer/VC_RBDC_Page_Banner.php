<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_RBDC_Page_Banner')) {

  class VC_RBDC_Page_Banner extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_RBDC_Page_Banner_section_map'));
      add_shortcode('VC_RBDC_Page_Banner_shortcode', array(&$this, 'VC_RBDC_Page_Banner_shortcode_callback'));
    }

    /**
     * Params
     * ---
     */
    public function params() {

      $params = array(
        array(
          'type'        => 'textfield',
          'holder'      => 'div',
          'class'       => 'vc_label bold',
          'heading'     => __('Banner title', 'TEXT_DOMAIN'),
          'param_name'  => 'title',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => __('%title%', 'TEXT_DOMAIN'),
          'description' => __('Leave variable %title% to display page title.', 'TEXT_DOMAIN'),
        ),
        array(
          'type'        => 'textfield',
          'holder'      => 'div',
          'class'       => 'vc_label',
          'heading'     => __('Banner subtitle', 'TEXT_DOMAIN'),
          'param_name'  => 'subtitle',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => '',
          'description' => __('Add subtitles for banner', 'TEXT_DOMAIN'),
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'admin_label' => false,
          'heading'     => __('Uppercase title', 'TEXT_DOMAIN'),
          'param_name'  => 'uppercase',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(__('Display title in uppercase', 'TEXT_DOMAIN') => true),
          'std'         => true,
        ),
      );
      return $params;
    }

    /**
     * Visual Composer Map
     * ---
     */
    public function VC_RBDC_Page_Banner_section_map() {

      $title       = 'Page banner';     // Shortcode description
      $description = 'Add page banner'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_RBDC_Page_Banner_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon(),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_RBDC_Page_Banner_shortcode_callback($atts, $content = null) {

      extract(shortcode_atts(array(
        'title'     => '%title%',
        'subtitle'  => '',
        'uppercase' => true,
      ), $atts));

      $title   = str_replace('%title%', wp_kses_post(get_the_title()), $title); // Get page title
      $pattern = get_field('background_pattern', 'options');                    // Get patttern backgrounf
      $images  = get_field('page_banners', 'options');                          // get background image
      $size    = 200;                                                           // banner height
      $uc      = $uppercase ? 'uc' : 'lc';
      // Create banner background pattern
      $background_image = '';

      if ($images) {
        $img              = $images[array_rand($images)];
        $background_image = sprintf('  data-src="%s" class="lazy background-image"',
          wpimage('img=' . (int) $img['ID'] . '&h=' . $size . '&w=999999&crop=false&upscale=true&retina=true')
        );
      }

      // Create banner background image
      $background_pattern = '';

      if ($pattern) {
        $background_pattern = sprintf('  data-src="%s" class="lazy background-pattern"',
          wpimage('img=' . (int) $pattern . '&h=' . get_field('background_pattern_size', 'options') . '&w=999999&crop=false&upscale=true&retina=false')

        );
      }

      ob_start()?>
      <section class="page-banner">
        <?php echo $pattern ? "<div $background_pattern>" : '' ?>
        <div class="inner">
         <?php echo $images ? "<div $background_image>" : '' ?>
         <div class="banner">
          <div class="container">
           <?php echo $title ? "<div class='title-container'><h1 class='page-title $uc'>$title</h1></div>" : '' ?>
           <?php echo $subtitle ? "<div class='subtitle-container'><p>$subtitle</p></div>" : '' ?>
         </div>
       </div>
       <?php echo $images ? '</div>' : '' ?>
     </div>
     <?php echo $pattern ? '</div>' : '' ?>
   </section>
   <div class="bar"></div>

   <?php

   $item = ob_get_contents();
   ob_end_clean();

   return $item;

 }
}

}