<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_BRDC_Custom_Title')) {

  class VC_BRDC_Custom_Title extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_Custom_Title_section_map'));
      add_shortcode('VC_BRDC_Custom_Title_shortcode', array(&$this, 'VC_BRDC_Custom_Title_shortcode_callback'));
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
          'heading'     => __('Title text', 'TEXT_DOMAIN'),
          'param_name'  => 'text',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => __('Add title here', 'TEXT_DOMAIN'),
          'description' => __('Add title text', 'TEXT_DOMAIN'),
        ),
        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Title tag', 'TEXT_DOMAIN'),
          'param_name'  => 'tag',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array('h1', 'h2', 'h3', 'h4', 'h5', 'p', 'div'),
          'description' => __('Set title tag', 'TEXT_DOMAIN'),
          'std'         => 'h2',
        ),
        $this->param_additional_id('custom_id'),
        $this->param_additional_class('custom_class'),
        $this->param_font_sizes('font_size'),
        $this->param_line_height('line_height'),
        $this->param_font_weight('font_weight'),
        $this->param_colors('color'),
        $this->param_text_alignment('align'),
        $this->param_animation_classes('animation'),
        $this->param_space('above'),
        $this->param_space('below'),
      );
      return $params;
    }

    /**
     * Visual Composer Map
     * ---
     */
    public function VC_BRDC_Custom_Title_section_map() {

      $title       = 'Custom title';             // Shortcode description
      $description = 'Add section custom title'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_BRDC_Custom_Title_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon(),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_BRDC_Custom_Title_shortcode_callback($atts, $content = null) {

      extract(shortcode_atts(array(
        'text'         => '',
        'tag'          => 'h2',
        'font_size'    => '16px',
        'line_height'  => '18px',
        'font_weight'  => 'Default',
        'space_above'  => 'None',
        'space_below'  => 'None',
        'align'        => 'Left',
        'color'        => 'Default',
        'animation'    => '',
        'custom_class' => '',
        'custom_id'    => '',
      ), $atts));

      $animation_classes = $this->getCSSAnimation($animation);
      $custom_class      = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id         = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      $class = '';
      $i     = 0;

      $classes = array(
        $this->pixels_class($font_size, 'font'),
        $this->pixels_class($line_height, 'line'),
        $this->pixels_class($space_above, 'space-top'),
        $this->pixels_class($space_below, 'space-bottom'),
        $this->pixels_class($align, 'align'),
        $this->pixels_class($color, 'color'),
        $this->pixels_class($font_weight, 'weight'),
      );

      foreach ($classes as $class_i) {
        $class .= ($i == 0 ? '' : ' ') . $class_i;
        $i++;
      }
      ob_start()?>
      <?php echo $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : ''; ?>
      <div class="brdc-custom-heading">
       <div class="container">
        <?php echo "<$tag class='$class $animation_classes'>$text</$tag>" ?>
      </div>
    </div>
    <?php echo $custom_class || $custom_id ? '</div>' : ''; ?>
    <?php

      $item = ob_get_contents();
      ob_end_clean();

      return $item;
    }
  }

}