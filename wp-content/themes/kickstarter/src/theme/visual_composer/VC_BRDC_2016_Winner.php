<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_BRDC_2016_Winner')) {

  class VC_BRDC_2016_Winner extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_2016_Winner_section_map'));
      add_shortcode('VC_BRDC_2016_Winner_shortcode', array(&$this, 'VC_BRDC_2016_Winner_shortcode_callback'));
    }

    public function companies() {

      $args = array(
        'posts_per_page' => -1,
        'post_type'      => array('atendees', 'supportingorgs'),
        'orderby'        => 'title',
        'order'          => 'ASC',
      );

      $posts = get_posts($args);

      if ( ! $posts) {
        return;
      }

      $items = array();
      foreach ($posts as $post) {
        $title         = the_title_attribute('echo=0&post=' . $post->ID);
        $items[$title] = $post->ID;
      }

      wp_reset_postdata();

      return $items;

    }

    /**
     * Params
     * ---
     */
    public function params() {

      $params = array(
        array(
          'type'       => 'param_group',
          'value'      => 'Winners',
          'group'      => __('Content', 'TEXT_DOMAIN'),
          'heading'    => __('Add winners', 'TEXT_DOMAIN'),
          'param_name' => 'winners',
          'params'     => array(
            array(
              'type'        => 'textfield',
              'holder'      => 'div',
              'class'       => 'vc_label',
              'heading'     => __('Challenge name', 'TEXT_DOMAIN'),
              'param_name'  => 'challenge',
              'group'       => __('Content', 'TEXT_DOMAIN'),
              'value'       => '',
              'description' => __('Add challenge name', 'TEXT_DOMAIN'),
            ),
            array(
              'type'        => 'textfield',
              'holder'      => 'div',
              'class'       => 'vc_label',
              'heading'     => __('Subtext', 'TEXT_DOMAIN'),
              'param_name'  => 'subtitle',
              'group'       => __('Content', 'TEXT_DOMAIN'),
              'value'       => '',
              'description' => __('Add subtitle here', 'TEXT_DOMAIN'),
            ),
            array(
              'type'        => 'dropdown',
              'holder'      => 'div',
              'class'       => 'vc_label',
              'heading'     => __('Company', 'TEXT_DOMAIN'),
              'param_name'  => 'company',
              'group'       => __('Content', 'TEXT_DOMAIN'),
              'value'       => $this->companies(),
              'description' => __('Select company', 'TEXT_DOMAIN'),
            ),
          ),
        ),
        $this->param_space('above'),
        $this->param_space('below'),
        $this->prevent_space_on_mobile(),
        $this->param_additional_id('custom_id'),
        $this->param_additional_class('custom_class'),
      );
      return $params;
    }

    /**
     * Visual Composer Map
     * ---
     */
    public function VC_BRDC_2016_Winner_section_map() {

      $title       = '2016 Winners';                 // Shortcode description
      $description = '2016 Winners Legacy display.'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_BRDC_2016_Winner_shortcode',
          'class '            => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon(),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    public function VC_BRDC_2016_Winner_shortcode_callback($atts, $content = null) {

      extract(shortcode_atts(array(
        'winners'      => '',
        'space_above'  => __('None', 'TEXT_DOMAIN'),
        'space_below'  => __('None', 'TEXT_DOMAIN'),
        'custom_class' => '',
        'custom_id'    => '',
      ), $atts));

     $winners      = vc_param_group_parse_atts($winners);
      if ($winners == '') {
        return;
      }


      $item         = '';
      $custom_class = $custom_class != '' ? 'class  = "' . $custom_class . '"' : false;
      $custom_id    = $custom_id != '' ? 'id = "' . $custom_id . '"' : false;

      $item .= $custom_class || $custom_id ? ' <div' . $custom_id . $custom_class . ' > ' : '';
      $item .= ' <div class = "' . $this->pixels_class($space_above, 'spacer-top') . ' ' . $this->pixels_class($space_below, 'spacer-bottom') . '" > ';

      $item .= '<div class="winners-2016">';

      foreach ($winners as $winner) {


        $challenge = $winner['challenge'];
        $subtitle  = $winner['subtitle'];
        $image     = get_field('add_attendee_logo', (int) $winner['company']);

        $item .= sprintf('<div class="winner-2016-container"><div class="inner clx" data-mh="win-2016">%s%s%s</div></div>',
          '<div class="challenge-name">' . $challenge . '</div>',
          '<div class="challenge-subtitle">' . $subtitle . '</div>',
          sprintf('<div class="image"><a href="%s" title="%s"><img src="%s" data-src="%s" alt="%s" class="lazy" /></a></div>',
            esc_url(get_the_permalink($winner['company'])),
            sprintf(__('Discover more about %s', 'TEXT_DOMAIN'), the_title_attribute('echo=0&post=' . $winner['company'])),
            wpimagebase(),
            wpimage('img=' . $image . '&h=100&w=200&crop=false&retina=false'),
            sprintf(__('%s company logo', 'TEXT_DOMAIN'), the_title_attribute('echo=0&post=' . $winner['company']))
          )
        );

      }

      $item .= '</div>';

      $item .= ' </div> ';
      $item .= $custom_class || $custom_id ? ' </div> ' : '';

      return $item;
    }
  }

}
