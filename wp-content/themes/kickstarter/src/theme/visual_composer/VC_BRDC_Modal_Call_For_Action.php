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
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Columns per row', 'TEXT_DOMAIN'),
          'param_name'  => 'cols',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(1, 2, 3, 4, 5, 6),
          'description' => __('Set the amount of columns per row', 'TEXT_DOMAIN'),
          'std'         => 2,
        ),
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
            /* Custom link */
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
array(
  'type'        => 'textfield',
  'holder'      => 'div',
  'class'       => 'vc_hidden',
  'heading'     => __('Image height', 'TEXT_DOMAIN'),
  'param_name'  => 'img_height',
  'group'       => __('Settings', 'TEXT_DOMAIN'),
  'value'       => 150,
  'description' => __('Set call for action image height', 'TEXT_DOMAIN'),
),
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
        'img_height'   => 150,
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
        'cols'         => 2,
        'color'        => 'Default',
        'prevent'      => false,
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

      $random            = rand(10, 100000);
      $animation_classes = $this->getCSSAnimation($animation);
      $custom_class      = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id         = $custom_id != '' ? ' id="' . $custom_id . '"' : false;
      $calls             = vc_param_group_parse_atts($calls);
      $calls_count       = count($calls);
      ob_start()?>
      <?php echo $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : ''; ?>

      <div class="<?php echo "colsumns-$cols" ?> colsumns <?php echo $calls_count < $cols ? 'around' : 'between' ?> flex brdc-custom-calls<?php echo $cspacer_class ?><?php echo $prevent ? '' : ' no-prevent' ?>">

        <?php
        if ($calls):

          foreach ($calls as $call):

            $link_to           = array_key_exists('link_to', $call) ? $call['link_to'] : false;
            $title             = array_key_exists('link_to', $call) ? $this->replace_brackets_with_tags($call['title']) : false;
            $text              = array_key_exists('text', $call) ? $call['text'] : false;
            $image             = array_key_exists('img', $call) ? $call['img'] : false;
            $pop_button_text   = array_key_exists('pop_button_text', $call) ? $call['pop_button_text'] : false;
            $show_img_in_popup = array_key_exists('show_in_popup', $call) ? $call['show_in_popup'] : false;

            /* Build image */
            $img = false;
            if ($call['img']) {

              $image = wpimage('img=' . (int) $call['img'] . '&h=400&retina=false&upscale=true&crop=false&single=false');
              if ($img_height < imagedata($call['img'])['height']) {
                $height      = (int) imagedata($call['img'])['height'] * 5;
                $width       = (int) imagedata($call['img'])['width'] * 5;
                $large_image = wpimage('img=' . (int) $call['img'] . '&h=' . $height . '&w=' . $width . 'retina=false&upscale=true&crop=true&single=true');
                $image       = wpimage('img=' . $large_image . '&h=' . $img_height . '&w=' . $width . 'retina=false&upscale=true&crop=false&single=false');
              }
              $img = sprintf('<div class="call-image %s"><figure><img src="%s" data-src="%s" alt="%s" class="lazy" ></figure></div>',
                $this->pixels_class($align, 'align'),
                wpimagebase(),
                $image[0],
                imagedata($call['img'])['alt'],
                imagedata($call['img'])['width']
              );
            }
            /* Title */
            $the_title = ($call['title']) ? "<$tag  data-mh=\"call-title\" class='call-title custom-call-title-$random $class $animation_classes'>" . do_shortcode($title) . "</$tag>" : '';

            $modal_rand = rand(10, 10000);
            /* link */
            $link = array(false, false, false);
            $href = false;
            if ($link_to == 'link' && array_key_exists('custom_link', $call)) {
              $href    = vc_build_link($call['custom_link']);
              $link    = array();
              $link[0] = '</a>';
              $link[1] = '<a href="' . esc_url($href['url']) . '" title="' . $href['title'] . '" target="' . $href['target'] . '" class="display-block clx">';
              $link[2] = '<a href="' . esc_url($href['url']) . '" title="' . $href['title'] . '" target="' . $href['target'] . '" class="button default color-green">';
            } elseif ($link_to == 'popup') {
              $link    = array();
              $link[0] = '</a>';
              $link[1] = '<a href="#modal-' . $modal_rand . '" data-modaal-type="inline" data-modaal-width="650" data-modaal-animation="fade" class="modaal display-block clx">';
              $link[2] = '<a href="#modal-' . $modal_rand . '" data-modaal-type="inline" data-modaal-width="650" data-modaal-animation="fade" class="modaal button default color-green">';
            }?>
            <div class="call-for-action <?php echo "cols-$cols" ?> ">
              <?php echo $img ? $link[1] . $img . $link[0] : '' ?>
              <?php echo $the_title ? $link[1] . $the_title . $link[0] : '' ?>
              <?php if ($pop_button_text != ''): ?>
                <div class="<?php echo $this->pixels_class($align, 'align') ?>"><?php echo $link[2] . $pop_button_text . $link[0] ?></div>
              <?php endif;

              if (array_key_exists('custom_link', $call)):
                if ($href['url'] != '' && $href['title'] != '' && $call['link_to'] == 'link'): ?>
                  <div class="<?php echo $this->pixels_class($align, 'align') ?>"><?php echo $link[2] . $href['title'] . $link[0] ?></div>
                <?php endif;
              endif;
              /* Popup Image */
              if ($link_to == 'popup'): ?>
                <div id="modal-<?php echo $modal_rand ?>" style="display:none;">
                 <?php if ($img && $show_img_in_popup == true): ?>
                  <div class="popup-image">
                    <?php
                    printf('<div class="call-image"><figure><img src="%s" alt="%s" height="' . $img_height . '"></figure></div>',
                      $image[0],
                      imagedata($call['img'])['alt'],
                      imagedata($call['img'])['width']
                    );?>
                  </div>
                <?php endif;
                /* Pop Up Title */
                if ($call['popuptitle'] != ''): ?>
                  <p class="popup-title"><?php echo str_replace('%title%', $title, $call['popuptitle']) ?></p>
                <?php endif;
                /* PopUp Text */
                if ($call['text'] != ''): ?>
                  <div class="popup-text"><?php echo $call['text']; ?></div>
                <?php endif?>
              </div>
            <?php endif;?>
          </div>

          <?php if ((int) str_replace('px', '', $font_size) > 20): ?>
          <script>
            jQuery(function() {
              jQuery('.custom-call-title-<?php echo $random ?>').fitText(1.5, { minFontSize: '<?php echo (int) round((str_replace('px', '', $font_size) / 1.5), 0) . 'px' ?>', maxFontSize: '<?php echo $font_size ?>' });;
            });
          </script>
        <?php endif;?>
      <?php endforeach;endif;?>
    </div>
    <?php
    echo $custom_class || $custom_id ? '</div>' : '';

    $item = ob_get_contents();
    ob_end_clean();

    return $item;
  }
}

}