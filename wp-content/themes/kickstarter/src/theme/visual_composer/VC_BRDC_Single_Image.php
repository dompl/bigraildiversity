<?php
namespace theme\visual_composer;

if ( ! defined('ABSPATH')) {
  die('-1');
}

use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_BRDC_Single_Image')) {

  class VC_BRDC_Single_Image extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_Single_Image_section_map'));
      add_shortcode('VC_BRDC_Single_Image_shortcode', array(&$this, 'VC_BRDC_Single_Image_shortcode_callback'));
    }

    /**
     * Params
     * ---
     */
    public function params() {

      $params = array(
        array(
          'type'        => 'attach_image',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Single image', 'TEXT_DOMAIN'),
          'param_name'  => 'single_image',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'description' => __('Add single image', 'TEXT_DOMAIN'),
        ),
        array(
          'type'        => 'image_sizer_height',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'label'       => false,
          'heading'     => __('Image width', 'TEXT_DOMAIN'),
          'param_name'  => 'height',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => 100,
          'description' => __('Provide image width (in pixels)', 'TEXT_DOMAIN'),
        ),
        array(
          'type'        => 'image_sizer_width',
          'holder'      => 'div',
          'label'       => false,
          'class'       => 'vc_hidden',
          'heading'     => __('Image height', 'TEXT_DOMAIN'),
          'param_name'  => 'width',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => 100,
          'description' => __('Provide image height (in pixels)', 'TEXT_DOMAIN'),
        ),
        $this->param_text_alignment('align', 'Content', 'Image alignment'),
        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Image action', 'TEXT_DOMAIN'),
          'param_name'  => 'custom_link',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(
            __('None', 'TEXT_DOMAIN')             => 'none',
            __('Custom URL', 'TEXT_DOMAIN')       => 'custom_url',
            __('Open in lightbox', 'TEXT_DOMAIN') => 'lightbox',
          ),
          'description' => __('Set action for your image.', 'TEXT_DOMAIN'),
          'std'         => 'none',
        ),
        array(
          'type'        => 'vc_link',
          'holder'      => 'div',
          'label'       => false,
          'class'       => 'vc_hidden',
          'heading'     => __('Image Link', 'TEXT_DOMAIN'),
          'param_name'  => 'url',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => '',
          'description' => __('Add link for you image', 'TEXT_DOMAIN'),
          'dependency'  => array(
            'element' => 'custom_link',
            'value'   => 'custom_url',
          ),
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Crop', 'TEXT_DOMAIN'),
          'param_name'  => 'crop',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Crop image', 'TEXT_DOMAIN') => true,
          ),
          'description' => __('Crop image to sizes above. Both height and width are required for this feature to work. System will also allow you to upscale the image if you check the box above', 'TEXT_DOMAIN'),
          'std'         => false,
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Lazy load', 'TEXT_DOMAIN'),
          'param_name'  => 'lazy',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Use lazy load', 'TEXT_DOMAIN') => true,
          ),
          'description' => __('Use this to speed up page load', 'TEXT_DOMAIN'),
          'std'         => true,
        ),
        $this->param_additional_id('custom_id'),
        $this->param_additional_class('custom_class'),
      );
      return $params;
    }

    /**
     * Visual Composer Map
     * ---
     */
    public function VC_BRDC_Single_Image_section_map() {

      $title       = 'Single image';      // Shortcode description
      $description = 'Add single image.'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_BRDC_Single_Image_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon(),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_BRDC_Single_Image_shortcode_callback($atts) {

      extract(shortcode_atts(array(
        'single_image' => '',
        'height'       => '',
        'width'        => '',
        'custom_link'  => 'none',
        'url'          => '',
        'crop'         => false,
        'lazy'         => false,
        'align'        => 'Left',
        'animation'    => '',
        'custom_class' => '',
        'custom_id'    => '',
      ), $atts));

      $animation_classes = $this->getCSSAnimation($animation);
      $href              = vc_build_link($url);
      $custom_class      = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id         = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      if ($single_image == '') {
        return;
      }

      // Get the image
      if ($height == '' && $width == '') {
        $img = imagedata($single_image)['url'];
      } else {
        $img = wpimage('img=' . $single_image . '&h=' . $height . '&w=' . $width . '&crop' . $crop . '&retina=false');
      }

      /* Image tag build */

      $image_item = sprintf('<figure><img src="%s" %sclass="%s%s" %s></figure>',
        $lazy ? wpimagebase() : $img,
        $lazy ? 'data-src="' . $img . '" ' : '',
        $lazy ? 'lazy ' : '',
        $animation_classes,
        imagedata($single_image)['alt'] ? ' alt="' . imagedata($single_image)['alt'] . '"' : ''
      );

      /* Link build */
      $a_open  = null;
      $a_close = null;
      if ($custom_link != 'none') {

        if ($custom_link == 'lightbox') {

          // Register lightbox script
          wp_enqueue_script('ks-lightgallery-js', get_template_directory_uri() . '/js/x-lightgallery.js', array('jquery'), '1.6.11', true);

          $a_open  = '<div class="lightbox-container is_lightbox"><a href="' . imagedata($single_image)['url'] . '">';
          $a_close = '</a></div>';

        } elseif ($custom_link == 'custom_url') {

          $a_open = sprintf('<a href="%s"%s%s>',
            $href['url'] ? esc_url($href['url']) : '#',
            $href['title'] ? ' title="' . esc_html($href['title']) . '"' : '',
            $href['target'] ? ' target="' . esc_html($href['target']) . '"' : ''
          );

          $a_close = '</a>';
        }
      }

      $item = $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';

      // Container classes and ID's
      $item .= '<div class="' . $this->pixels_class($align, 'align') . '">';
      $item .= $a_open;
      $item .= $image_item;
      $item .= $a_close;
      $item .= '</div>';
      $item .= $custom_class || $custom_id ? '</div>' : ''; // Container classes and ID's close

      return $item;
    }
  }

}