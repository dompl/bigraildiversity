<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_BRDC_Modal_Call_For_Action')) {

  class VC_BRDC_Modal_Call_For_Action extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_Modal_Call_For_Action_section_map'));
      add_shortcode('VC_BRDC_Modal_Call_For_Action_shortcode', array(&$this, 'VC_BRDC_Modal_Call_For_Action_shortcode_callback'));
    }

    /**
     * Params
     * ---
     */
    public function params() {

      $params = array(
        array(
          'type'       => 'param_group',
          'value'      => 'Banner slides',
          'group'      => __('Content', 'TEXT_DOMAIN'),
          'heading'    => __('Add banner slides', 'TEXT_DOMAIN'),
          'param_name' => 'calls',
          'params'     => array(
            /* Link type - link_to */
            array(
              'type'        => 'dropdown',
              'holder'      => 'div',
              'class'       => 'vc_hidden',
              'heading'     => __('Link', 'TEXT_DOMAIN'),
              'param_name'  => 'link_to',
              'group'       => __('Content', 'TEXT_DOMAIN'),
              'value'       => array(
                __('PopUp window content', 'TEXT_DOMAIN') => 'popup',
                __('Standard link', 'TEXT_DOMAIN')        => 'link',
                __('No action', 'TEXT_DOMAIN')            => 'none',
              ),
              'description' => __('', 'TEXT_DOMAIN'),
              'std'         => 'none',
            ),
            /* call for action title - title */
            array(
              'type'        => 'textfield',
              'holder'      => 'div',
              'class'       => 'vc_label',
              'heading'     => __('Main title', 'TEXT_DOMAIN'),
              'param_name'  => 'title',
              'group'       => __('Content', 'TEXT_DOMAIN'),
              'value'       => '',
              'description' => __('Call for action title', 'TEXT_DOMAIN'),
            ),
            /* PopUp Title */
            array(
              'type'        => 'textfield',
              'holder'      => 'div',
              'class'       => 'vc_label',
              'heading'     => __('Main PopUp title', 'TEXT_DOMAIN'),
              'param_name'  => 'popuptitle',
              'group'       => __('Content', 'TEXT_DOMAIN'),
              'value'       => '%title%',
              'description' => __('Call for action title in pop up window. Leave <strong>%title%</strong> to inherit from above', 'TEXT_DOMAIN'),
              'dependency'  => array(
                'element' => 'link_to',
                'value'   => array('popup'),
              ),
            ),
            /* image - img */
            array(
              'type'        => 'attach_image',
              'holder'      => 'div',
              'class'       => 'vc_hidden',
              'heading'     => __('Image', 'TEXT_DOMAIN'),
              'param_name'  => 'img',
              'group'       => __('Content', 'TEXT_DOMAIN'),
              'value'       => __('%title%', 'TEXT_DOMAIN'),
              'description' => __('Leave %title% for lowercase page title', 'TEXT_DOMAIN'),
            ),
            /* show content in popup - show_in_popup*/
            array(
              'type'        => 'checkbox',
              'holder'      => 'div',
              'class'       => 'vc_hidden',
              'heading'     => __('Show in PopUp', 'TEXT_DOMAIN'),
              'param_name'  => 'show_in_popup',
              'group'       => __('Content', 'TEXT_DOMAIN'),
              'value'       => array(
                __('Show in PopUp', 'TEXT_DOMAIN') => true,
              ),
              'description' => __('Check the box above to show your image in PopUp', 'TEXT_DOMAIN'),
              'dependency'  => array(
                'element' => 'link_to',
                'value'   => array('popup'),
              ),
              'std'         => true,
            ),
            /* PopUp Main content - text */
            array(
              'type'        => 'textarea',
              'holder'      => 'div',
              'class'       => 'vc_hidden',
              'heading'     => __('PopUp Content', 'TEXT_DOMAIN'),
              'param_name'  => 'text',
              'group'       => __('Content', 'TEXT_DOMAIN'),
              'value'       => '',
              'description' => __('PopUp text', 'TEXT_DOMAIN'),
              'dependency'  => array(
                'element' => 'link_to',
                'value'   => array('popup'),
              ),
            ),
            /* PopUp button text - pop_button_text */
            array(
              'type'        => 'textfield',
              'holder'      => 'div',
              'class'       => 'vc_label',
              'heading'     => __('PopUp Button', 'TEXT_DOMAIN'),
              'param_name'  => 'pop_button_text',
              'group'       => __('Content', 'TEXT_DOMAIN'),
              'value'       => '',
              'description' => __('If you like to add aditional button under the call for action add text for it here.', 'TEXT_DOMAIN'),
              'dependency'  => array(
                'element' => 'link_to',
                'value'   => array('popup'),
              ),
            ),
            array(
              'type'        => 'vc_link',
              'holder'      => 'div',
              'class'       => 'vc_hidden',
              'heading'     => __('Call for action link', 'TEXT_DOMAIN'),
              'param_name'  => 'custom_link',
              'group'       => __('Content', 'TEXT_DOMAIN'),
              'value'       => '',
              'description' => __('Add link for your call for action. In order to show button under your call for action the link has to have Link Text.', 'TEXT_DOMAIN'),
              'dependency'  => array(
                'element' => 'link_to',
                'value'   => array('link'),
              ),
            ),
          ),
),
$this->param_text_alignment('align', 'Text Settings'),
$this->param_text_tags('tag', 'Text Settings'),
$this->param_font_sizes('font_size', 'Text Settings'),
$this->param_line_height('line_height', 'Text Settings'),
$this->param_font_weight('font_weight', 'Text Settings'),
$this->param_colors('color', 'Text Settings'),
$this->param_space('above'),
$this->param_space('below'),
$this->prevent_space_on_mobile(),
$this->param_additional_id('custom_id', 'Settings'),
$this->param_additional_class('custom_class', 'Settings'),
$this->param_animation_classes('animation', 'Settings'),
);
return $params;
}

    /**
     * Visual Composer Map
     * ---
     */
    public function VC_BRDC_Modal_Call_For_Action_section_map() {

      $title       = 'Image call for action';                // Shortcode description
      $description = 'Add image call for action with PopUp'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_BRDC_Modal_Call_For_Action_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon(),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_BRDC_Modal_Call_For_Action_shortcode_callback($atts, $content = null) {

      extract(shortcode_atts(array(
        'calls'        => '',
        'animation'    => '',
        'space_above'  => __('None', 'TEXT_DOMAIN'),
        'space_below'  => __('None', 'TEXT_DOMAIN'),
        'align'        => __('Left', 'TEXT_DOMAIN'),
        'custom_class' => '',
        'custom_id'    => '',
        'tag'          => 'h2',
        'font_size'    => '16px',
        'line_height'  => '18px',
        'font_weight'  => 'Default',
        'space_above'  => __('None', 'TEXT_DOMAIN'),
        'space_below'  => __('None', 'TEXT_DOMAIN'),
        'align'        => 'Left',
        'color'        => 'Default',
      ), $atts));

      $classes = array(
        $this->pixels_class($font_size, 'font'),
        $this->pixels_class($line_height, 'line-height line'),
        $this->pixels_class($align, 'align'),
        $this->pixels_class($color, 'color'),
        $this->pixels_class($font_weight, 'weight'),
      );
      $class = '';
      $i     = 0;
      foreach ($classes as $class_i) {
        $class .= ($i == 0 ? '' : ' ') . $class_i;
        $i++;
      }

      $spacer_classes = array(
        $this->pixels_class($space_above, 'spacer-top'),
        $this->pixels_class($space_below, 'spacer-bottom'),
      );

      $cspacer_class = '';
      foreach ($spacer_classes as $spacer_classes_i) {
        $cspacer_class .= ($i == 0 ? '' : ' ') . $spacer_classes_i;
        $i++;
      }

      $random = rand(10, 100000);
      // $href = vc_build_link( $href ); // Build Link
      // $content = wpb_js_remove_wpautop($content, true); // Content
      // $text              = $this->replace_brackets_with_tags($text);
      $animation_classes = $this->getCSSAnimation($animation);
      $custom_class      = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id         = $custom_id != '' ? ' id="' . $custom_id . '"' : false;
      $calls             = vc_param_group_parse_atts($calls);
      ob_start()?>
      <?php echo $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : ''; ?>
      <div class="brdc-custom-heading<?php echo $cspacer_class ?><?php echo $prevent ? '' : ' no-prevent' ?>">

        <?php foreach ($calls as $call): ?>
          <?php var_dump($call)?>
          <?php
          $link_to           = $call['link_to'];
          $title             = $call['title'];
          $text              = $call['text'];
          $img               = $call['img'];
          $show_img_in_popup = $call['show_in_popup'];
          ?>
        <?php endforeach?>

      </div>
      <?php echo $custom_class || $custom_id ? '</div>' : ''; ?>
      <?php if ((int) str_replace('px', '', $font_size) > 20): ?>
      <script>
        jQuery(function() {
          jQuery('.custom-heading-<?php echo $random ?>').fitText(1.5, { minFontSize: '<?php echo (int) round((str_replace('px', '', $font_size) / 1.5), 0) . 'px' ?>', maxFontSize: '<?php echo $font_size ?>' });;
        });
      </script>
    <?php endif;?>
    <?php

    $item = ob_get_contents();
    ob_end_clean();

    return $item;
  }
}

}