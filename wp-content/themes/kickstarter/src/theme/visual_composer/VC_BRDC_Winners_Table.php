<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;

if ( ! class_exists('VC_BRDC_Winners_Table')) {

  class VC_BRDC_Winners_Table extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_Winners_Table_section_map'));
      add_shortcode('VC_BRDC_Winners_Table_shortcode', array(&$this, 'VC_BRDC_Winners_Table_shortcode_callback'));
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
          'heading'     => __('Winners list count', 'TEXT_DOMAIN'),
          'param_name'  => 'how_many',
          'admin_label' => true,
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(
            __('All Winners', 'TEXT_DOMAIN')       => 'all',
            __('Number of winners', 'TEXT_DOMAIN') => 'number',
          ),
          'description' => __('How many winners would you like to show on the list? To add winners visit <a href="/wp-admin/edit.php?post_type=atendees&page=winnters-list" target="_blank">Winners page</a>', 'TEXT_DOMAIN'),
          'std'         => 'all',
        ),
        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Winners list layout', 'TEXT_DOMAIN'),
          'param_name'  => 'winners_layout',
          'admin_label' => true,
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Standard', 'TEXT_DOMAIN')    => 'standard',
            __('With images', 'TEXT_DOMAIN') => 'with_images',
          ),
          'description' => __('Select layout type for the winners table', 'TEXT_DOMAIN'),
          'std'         => 'standard',
        ),
        array(
          'type'        => 'textfield',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'admin_label' => false,
          'heading'     => __('Winners count', 'TEXT_DOMAIN'),
          'param_name'  => 'count',
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => 10,
          'description' => __('Set the amount of winners to show on the list', 'TEXT_DOMAIN'),
          'std'         => 10,
          'dependency'  => array(
            'element' => 'how_many',
            'value'   => 'number',
          ),
        ),
        array(
          'type'        => 'custom_radio',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Year', 'TEXT_DOMAIN'),
          'param_name'  => 'year',
          'admin_label' => true,
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => $this->years(),
          'description' => __('For which year would you like to show the winenrs.', 'TEXT_DOMAIN'),
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
    public function VC_BRDC_Winners_Table_section_map() {

      $title       = 'Winners Table';     // Shortcode description
      $description = 'Add Winners Table'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_BRDC_Winners_Table_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon('icon-winners.svg'),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'admin_enqueue_js'  => get_template_directory_uri() . '/js/x-visual-composer.js',
          'params'            => $this->params(),
        )
      );
    }

    public function sortByOrder($a, $b) {
      return (int) $a[2] - (int) $b[2];
    }

    public function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
      $sort_col = array();
      foreach ($arr as $key => $row) {
        $sort_col[$key] = $row[$col];
      }
      array_multisort($sort_col, $dir, $arr);
    }

    public function VC_BRDC_Winners_Table_shortcode_callback($atts, $content = null) {

      extract(shortcode_atts(array(
        'how_many'       => 'all',
        'count'          => 10,
        'year'           => date('Y'),
        'winners_layout' => 'standard',
        'space_above'    => __('None', 'TEXT_DOMAIN'),
        'space_below'    => __('None', 'TEXT_DOMAIN'),
        'custom_class'   => '',
        'custom_id'      => '',
      ), $atts));

      $winners = get_field('field_5bab1224f0b3f', 'options');

      $winner = array();
      foreach ($winners as $win) {
        if ($win['winner_year'] == $year) {
          if ($winners_layout == 'with_images') {
            $winner[]  =  array('date' => $win['winner_year'], 'name' => $win['winner_data'], 'image'=> $win['winner_image'] );
          } else {
            $w        = $win['winner_data'] . '|' . $win['winner_year'];
            $winner[] = explode('|', $w);
          }
        }
      }
      if ($winners_layout == 'with_images') {
      } else {
        $this->array_sort_by_column($winner, 2);
        $winners = array_reverse($winner);
      }

      $item         = '';
      $custom_class = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id    = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      $i = 1;

      if ($how_many == 'number') {
        $winners = array_slice($winners, 0, $count, true);
        // $winner = array_slice($winner, 0, $count, true);
      }

      if ($winners) {

        $item .= $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';
        $item .= '<div class="' . $this->pixels_class($space_above, 'spacer-top') . ' ' . $this->pixels_class($space_below, 'spacer-bottom') . '">';

        /* START STANDARD WINNERS LAYOUT */
        if ($winners_layout != 'with_images') {

          $item .= '<ul class="winners-table list-unstyled">';
          $item .= '<li><span class="item item-company header">' . __('Company Name', 'TEXT_DOMAIN') . '</span><span class="item item-team-name header">' . __('Team Name', 'TEXT_DOMAIN') . '</span><span class="item item-score header">' . __('Score', 'TEXT_DOMAIN') . '</span></li>';
          foreach ($winners as $winner) {
            if ($year == $winner[3]) {
              $item .= '<li class="position-' . $i . '"><span class="item item-company">' . $winner[0] . '</span><span class="item item-team-name">' . $winner[1] . '</span><span class="item item-score">' . $winner[2] . '</span></li>';
            }
            $i++;
          }
          $item .= '</ul>';
        }
        /* END STANDARD WINNERS LAYOUT */
        /* START STANDARD WINNERS LAYOUT WITH IMAGES */
        elseif ($winners_layout == 'with_images') {

          $item .= '<ul class="winners-with-img list-unstyled">';
          $inc = 1;
          $winner_count = count($winner);

          foreach ($winner as $winn) {
            $winner_data = array();
            $hidden_class = $inc > $count ? 'hidden' : '';
            if ($year == $winn['date']) {
              $winner_data = explode('|', $winn['name']);
              $image = wpimage('img=' . ($winn['image']['id'] ? $winn['image']['id'] : 49) . '&w=100&h=100&crop=false&retina=false&upscale=true');
              $item .= '<li class="position-' . $inc . ' '.($inc <= 3 ? 'top-3' : '').' ' . $hidden_class .'">';
              $item .= '<div class="number'.($inc <= 3 ? ' top-3-number' : '').'">'.$inc.'</div>';
              $item .= sprintf('<div class="image"><img src="%s" alt="%s"></div>', $image, $winner_data[0]);
              $item .= '<div class="name">' . $winner_data[0] . '</div>';
              $item .= '<div class="score">';
              $item .= __('Score:', 'TEXT_DOMAIN');
              $item .= '<strong> ' . $winner_data[2] . '</strong><div>';
              $item .= '</div>';
              $item .= '</li>';

              if ($inc == $count && $count <  $winner_count ) {
                 $item .= '<li class="more-button">';
                 $item .= '<span class="button small fill">'.__('View All Scores' , 'TEXT_DOMAIN').'</span>';
                 $item .= '</li>';
              }
            }
            $inc++;
          }
          $item .= '</ul>';
          /* END STANDARD WINNERS LAYOUT WITH IMAGES */
          $item .= '</div>';
          $item .= $custom_class || $custom_id ? '</div>' : '';
        }

        return $item;
      }
    }
  }
}