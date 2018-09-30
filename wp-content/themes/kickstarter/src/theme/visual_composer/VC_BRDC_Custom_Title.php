<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_BRDC_Custom_Title')) {

  class VC_BRDC_Custom_Title extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_Custom_Title_section_map'));
      add_shortcode('VC_BRDC_Custom_Title_shortcode', array(&$this, 'VC_BRDC_Custom_Title_shortcode_callback'));
    }

    public function prefix_sanitize_text_callback($value, $field_args, $field) {

      $value = strip_tags($value, '<p><a><br><br/><span><div>');

      return $value;

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
          'description' => __('Add title text. You can use variable <strong>%title%</strong> to display page title.', 'TEXT_DOMAIN'),
        ),
        $this->param_text_tags('tag'),
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
        $this->prevent_space_on_mobile(),

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
          'icon'              => $this->icon('icon-title.svg'),
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
        'space_above'  => __('None', 'TEXT_DOMAIN'),
        'space_below'  => __('None', 'TEXT_DOMAIN'),
        'align'        => 'Left',
        'color'        => 'Default',
        'animation'    => '',
        'custom_class' => '',
        'custom_id'    => '',
        'prevent'      => false,
      ), $atts));

      wp_reset_query();

      $text              = $this->replace_brackets_with_tags($text);
      $text              = str_replace('%title%', strtoupper(the_title_attribute('echo=0&post=' . get_the_ID())), $text);
      $animation_classes = $this->getCSSAnimation($animation);
      $custom_class      = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id         = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      $class = '';
      $i     = 0;

      $classes = array(
        $this->pixels_class($font_size, 'font'),
        $this->pixels_class($line_height, 'line-height line'),

        $this->pixels_class($align, 'align'),
        $this->pixels_class($color, 'color'),
        $this->pixels_class($font_weight, 'weight'),
      );

      $spacer_classes = array(
        $this->pixels_class($space_above, 'spacer-top'),
        $this->pixels_class($space_below, 'spacer-bottom'),
      );

      $random = rand(10, 100000);

      foreach ($classes as $class_i) {
        $class .= ($i == 0 ? '' : ' ') . $class_i;
        $i++;
      }
      $cspacer_class = '';
      foreach ($spacer_classes as $spacer_classes_i) {
        $cspacer_class .= ($i == 0 ? '' : ' ') . $spacer_classes_i;
        $i++;
      }
      ob_start()?>
      <?php echo $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : ''; ?>
      <div class="brdc-custom-heading<?php echo $cspacer_class ?><?php echo $prevent ? '' : ' no-prevent' ?>">
        <?php echo "<$tag class='custom-heading-$random $class $animation_classes'>" . do_shortcode($text) . "</$tag>" ?>
    </div>
    <?php if ((int) str_replace('px', '', $font_size) > 20): ?>
    <script>
      jQuery(function() {
      jQuery('.custom-heading-<?php echo $random ?>').fitText(1.5, { minFontSize: '<?php echo (int) round((str_replace('px', '', $font_size) / 1.5), 0) . 'px' ?>', maxFontSize: '<?php echo $font_size ?>' });;
      });
    </script>
    <?php endif?>
    <?php echo $custom_class || $custom_id ? '</div>' : ''; ?>
    <?php

      $item = ob_get_contents();
      ob_end_clean();

      return $item;
    }
  }

}