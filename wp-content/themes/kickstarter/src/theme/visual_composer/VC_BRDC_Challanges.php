<?php

namespace theme\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;
use WP_Query;

if ( ! class_exists('VC_BRDC_Challanges')) {

  class VC_BRDC_Challanges extends Visual_Composer_General_Settings {

    public function __construct() {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_Challanges_section_map'));
      add_shortcode('VC_BRDC_Challanges_shortcode', array(&$this, 'VC_BRDC_Challanges_shortcode_callback'));
    }

    public function challanges_settings() {

      return array(
        'simgh'  => 280, // Sponsor image height (in pixlex)
        'simgw'  => 400, // Sponsor image height (in pixlex)
        'sbatch' => 100, // Batch Size (in pixlex)
        'lw'     => 120, // Batch Size (in pixlex)
        'lh'     => 120, // Batch Size (in pixlex)
      );

    }

    /**
     * Params
     * ---
     */
    public function params() {

      $params = array(

        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Dates', 'TEXT_DOMAIN'),
          'param_name'  => 'year',
          'admin_label' => true,
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => $this->years(),
          'description' => __('For which your would you like to show the challenges?', 'TEXT_DOMAIN'),
          'std'         => date('Y'),
        ),

        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Display mode', 'TEXT_DOMAIN'),
          'param_name'  => 'display',
          'admin_label' => true,
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(
            __('In columns') => 'columns',
            __('In slider')  => 'slick',
          ),
          'description' => __('How would you like to display the challenges list', 'TEXT_DOMAIN'),
          'std'         => 'slick',
        ),
        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Challenges per row', 'TEXT_DOMAIN'),
          'param_name'  => 'row',
          'admin_label' => true,
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(1, 2, 3, 4, 5, 6),
          'description' => __('How many challenges would you like to show in a one row', 'TEXT_DOMAIN'),
          'std'         => 4,
        ),
        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Background', 'TEXT_DOMAIN'),
          'param_name'  => 'bcg',
          'admin_label' => false,
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(
            __('White', 'TEXT_DOMAIN')       => 'white',
            __('Transparent', 'TEXT_DOMAIN') => 'transparent',
          ),
          'description' => __('Background for challenge container. Transparent will also remove inner horizontal spaces.', 'TEXT_DOMAIN'),
          'std'         => 'white',
        ),
        array(
          'type'        => 'checkbox',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('Challange item content', 'TEXT_DOMAIN'),
          'param_name'  => 'challange',
          'admin_label' => false,
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => array(
            __('Sponsor')           => 'sponsor',
            __('Image')             => 'image',
            __('Title')             => 'title',
            __('Short Description') => 'description',
            __('Read More button')  => 'button',
            __('New natch')         => 'batch',
            __('Colour line')       => 'line',
          ),
          'description' => __('How would you like to display the challenges list', 'TEXT_DOMAIN'),
          'std'         => 'sponsor,image,title,description,button,batch,line',
        ),
        array(
          'type'        => 'dropdown',
          'holder'      => 'div',
          'class'       => 'vc_hidden',
          'heading'     => __('New Batch', 'TEXT_DOMAIN'),
          'param_name'  => 'batch_year',
          'admin_label' => true,
          'group'       => __('Content', 'TEXT_DOMAIN'),
          'value'       => $this->years(),
          'description' => __('For which year display batch for the challenges.', 'TEXT_DOMAIN'),
          'std'         => date('Y'),
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
    public function VC_BRDC_Challanges_section_map() {

      $title       = 'BRDC Challanges';                  // Shortcode description
      $description = 'Display cuson list of challanges'; // Shortcode Name

      vc_map(
        array(
          'name'              => __($title, 'TEXT_DOMAIN'),
          'base'              => 'VC_BRDC_Challanges_shortcode',
          'class'             => '',
          'category'          => $this->tab_category(),
          'icon'              => $this->icon('icon-challanges.png'),
          'description'       => __($description, 'TEXT_DOMAIN'),
          'admin_enqueue_css' => $this->admin_css(),
          'params'            => $this->params(),
        )
      );
    }

    /* Challange sponsor */
    public function sponsor($post_id = '', $challange = '', $batch_year = '', $display = 'columns') {

      if ($challange == '') {
        return;
      }

      $image_source = $display == 'columns' ? 'class="lazy" src="' . wpimagebase() . '" data-src' : 'src';
      $retina       = $display == 'columns' ? 'false' : 'false';

      $sponsor    = '';
      $sponsor_id = get_field('challange_sponsor', $post_id);

      $has_sponsor  = (get_field('challange_sponsor', $post_id) != '') ? true : false;
      $sponsor_word = $has_sponsor ? __('Sponsored by', 'TEXT_DOMAIN') : __('Sponsorship', 'TEXT_DOMAIN');

      if (in_array('sponsor', $challange)) {

        $sponsor .= '<div class="sponsor-container">';
        $sponsor .= '<span class="sp-word' . ($has_sponsor ? ' has-sp' : '') . '">' . $sponsor_word . '</span>';

        $sponsor_image = get_field('add_attendee_logo', $sponsor_id);

        // Sponsor logo image
        if ($sponsor_image != '') {
          $sponsor .= sprintf('<div class="sp-logo"><a href="%s" title="%s"><img ' . $image_source . '="%s" alt="%s"/></a></div>',
            esc_url(get_the_permalink($post_id)),
            sprintf(__('Discover more about %s challange.', 'TEXT_DOMAIN'), the_title_attribute('echo=0&post=' . $post_id)),
            wpimage('img=' . $sponsor_image . '&h=' . $this->challanges_settings()['lh'] . '&w=' . $this->challanges_settings()['lw'] . '&retina=' . $retina . '&crop=false'),
            the_title_attribute('echo=0&post=' . $sponsor_id) . ' ' . __('logo', 'TEXT_DOMAIN')
          );
        } else {
          $sponsor .= sprintf('<div class="sp-logo"><img ' . $image_source . '="%s" alt="%s"/></div>',
            wpimage('img=624&h=' . $this->challanges_settings()['lh'] . '&w=' . $this->challanges_settings()['lw'] . '&retina=' . $retina . '&crop=false'),
            sprintf(__('Discover more about %s challange.', 'TEXT_DOMAIN'), the_title_attribute('echo=0&post=' . $post_id))
          );
        }
        $sponsor .= '</div>';
      }

      // Challenge new for batch
      $challange_batch = '';
      if ($batch_year != '' && in_array('batch', $challange) && get_field('new_batch', $post_id) == true) {
        $batch = wp_upload_dir()['baseurl'] . '/2018/10/batch-' . $batch_year . '.png';
        $challange_batch .= sprintf('<div class="spon-batch"><img ' . $image_source . '="%s" alt="%s"></div>',
          wpimage('img=' . $batch . '&h=' . $this->challanges_settings()['sbatch'] . '&w=' . $this->challanges_settings()['sbatch']),
          sprintf('%s challenge is new in %s', the_title_attribute('echo=0&post=' . $post_id), $batch_year)
        );
      }
      // Challenge image
      if (in_array('image', $challange) && get_field('challenge_main_image', $post_id) != '') {

        $image = wpimage('img=' . get_field('challenge_main_image', $post_id) . '&h=' . $this->challanges_settings()['simgh'] . '&w=' . $this->challanges_settings()['simgw'] . '&crop=true&upscale=true&retina=false');
        $sponsor .= sprintf('<div class="challange-image"><a href="%s" title="%s"><img ' . $image_source . '="%s" />%s</a></div>',
          esc_url(get_the_permalink($post_id)),
          sprintf(__('Discover more about %s challenge', 'TEXT_DOMAIN'), str_replace('Challenge', '', the_title_attribute('echo=0&post=' . $post_id))),
          $image,
          $challange_batch
        );
      }

      // Challange name
      if (in_array('title', $challange)) {
        $sponsor .= sprintf('<div class="challange-title display-%1$s" data-mh="c-title"><h3><a href="%2$s" title="%3$s">%4$s</a></h3></div>',
          $display,
          esc_url(get_permalink($post_id)),
          sprintf(__('Discover more about %s challenge.', 'TEXT_DOMAIN'), the_title_attribute('echo=0&post=' . $post_id)),
          the_title_attribute('echo=0&post=' . $post_id)
        );
      }

      // Challange short description
      if (in_array('description', $challange)) {

        $sponsor .= sprintf('<div class="challange-description" data-mh="c-description"><div class="description-inner first-last"><a href="%s">%s</a></div></div>',
          esc_url(get_permalink($post_id)),
          get_field('attendee_short_description', $post_id)
        );

      }

      // Challange button
      if (in_array('button', $challange)) {
        $sponsor .= sprintf('<div class="challange-button"><a href="%s" title="%s" class="button small fill color-green">%s</a></div>',
          esc_url(get_permalink($post_id)),
          sprintf(__('Discover more about %s challenge.', 'TEXT_DOMAIN'), the_title_attribute('echo=0&post=' . $post_id)),
          __('Discover More', 'TEXT_DOMAIN')
        );
      }

      return $sponsor;
    }

    public function VC_BRDC_Challanges_shortcode_callback($atts, $content = null) {

      wp_reset_query();

      extract(shortcode_atts(array(
        'year'         => date('Y'),
        'batch_year'   => date('Y'),
        'display'      => 'slick',
        'bcg'          => 'white',
        'row'          => 4,
        'challange'    => 'sponsor,image,title,description,button,batch,line',
        'space_above'  => __('None', 'TEXT_DOMAIN'),
        'space_below'  => __('None', 'TEXT_DOMAIN'),
        'custom_class' => '',
        'custom_id'    => '',
      ), $atts));

      $item = '';

      $custom_class = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
      $custom_id    = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

      $challange = explode(',', $challange);
      $year      = explode(',', $year);
      /* Build query args */
      $args = array(
        'post_type'      => 'challenges',
        'posts_per_page' => -1,
        'post__not_in'   => array(get_the_ID()),
      );

      foreach ($year as $y) {
        $args['meta_query']['relation'] = 'OR';
        $args['meta_query'][]           = array(
          'key'     => 'challange_year',
          'value'   => $y,
          'compare' => 'LIKE',
        );
      }

      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) {

        if ($display == 'slick') {
          wp_enqueue_script('ks-slick-js', get_template_directory_uri() . '/js/x-slick.js', array('jquery'), '1.6.11', true);
        }

        $slick_settings = '';
        if ($display == 'slick') {
          $slick_settings = ' data-slick=\'{"slidesToShow": ' . $row . ', "slidesToScroll": ' . $row . '}\'';
        }

        $item .= $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';
        $item .= '<div class="' . $this->pixels_class($space_above, 'spacer-top') . ' ' . $this->pixels_class($space_below, 'spacer-bottom') . '">';
        $item .= '<div class="challanges-container ' . ($display == 'slick' ? ' sli ' : '') . ' challanges-in-' . $display . ' row-' . $row . '"' . $slick_settings . '>';
        $i = 1;
        while ($the_query->have_posts()) {$the_query->the_post();
          $id = get_the_ID();
          $item .= sprintf('<div class="challange-item challange-item-%s"><div class="bcg-%s inner">%s%s</div></div>',
            $id,
            $bcg,
            $this->sponsor($id, $challange, $batch_year, $display),
            in_array('line', $challange) ? ('<span class="line"></span>') : ''
          );
          $i++;
        }
        $item .= '</div>';
        $item .= '</div>';
        $item .= $custom_class || $custom_id ? '</div>' : '';
      }
      wp_reset_postdata();
      wp_reset_query();
      return $item;
    }
  }

}