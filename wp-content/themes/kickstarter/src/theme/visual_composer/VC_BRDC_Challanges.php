<?php

namespace theme\visual_composer;

use config\visual_composer\Visual_Composer_General_Settings;
use WP_Query;

if (! class_exists('VC_BRDC_Challanges')) {
  class VC_BRDC_Challanges extends Visual_Composer_General_Settings
  {
    public function __construct()
    {
      add_action('vc_before_init', array(&$this, 'VC_BRDC_Challanges_section_map'));
      add_shortcode('VC_BRDC_Challanges_shortcode', array(&$this, 'VC_BRDC_Challanges_shortcode_callback'));
    }

    public function challanges_settings()
    {
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
        public function params()
        {
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
              'heading'     => __('Link destination', 'TEXT_DOMAIN'),
              'param_name'  => 'link_dest',
              'admin_label' => true,
              'group'       => __('Content', 'TEXT_DOMAIN'),
              'value'       => array('Pop Up Window' => 'popup', 'Link to Challenge page' => 'link'),
              'description' => __('Select to eiter display as pop up or link to challenge page.', 'TEXT_DOMAIN'),
              'std'         => 'link',
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
        public function VC_BRDC_Challanges_section_map()
        {
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
    public function sponsor($post_id = '', $challange = '', $batch_year = '', $display = 'columns', $link_dest = '')
    {
      if ($challange == '') {
        return;
      }

      $image_source = $display == 'columns' ? 'class="lazy" src="' . wpimagebase() . '" data-src' : 'src';
      $retina       = $display == 'columns' ? 'false' : 'false';

      $sponsor    = '';
      $sponsor_id = get_field('challange_sponsor', $post_id);

      $has_sponsor  = (get_field('challange_sponsor', $post_id)) ? true : false;
      $sponsor_word = $has_sponsor ? __('Sponsored by', 'TEXT_DOMAIN') : __('Sponsor this challenge', 'TEXT_DOMAIN');

      $popup_link = str_replace(' ', '-', the_title_attribute('echo=0&id=' . $post_id));
      $popup_link  = preg_replace('/[^A-Za-z0-9\-]/', '', $popup_link);

      if (in_array('sponsor', $challange)) {
        $sponsor .= '<div class="sponsor-container">';
        $sponsor .= $has_sponsor ? '' : '<a href="'.esc_url(get_permalink(21)).'">';
        $sponsor .= '<span class="sp-word' . ($has_sponsor ? ' has-sp' : '') . '">' . $sponsor_word . '</span>';
        $sponsor .=  $has_sponsor ? '' : '</a>';

        $sponsor_image = get_field('add_attendee_logo', $sponsor_id);

                // Sponsor logo image
        if ($sponsor_image != '') {
          $sponsor .= sprintf(
            '<div class="sp-logo"><a href="%s" title="%s" class="%s"><img ' . $image_source . '="%s" alt="%s"/></a></div>',
            $link_dest == 'popup' ? '#' . $popup_link : esc_url(get_the_permalink($post_id)),
            sprintf(__('Discover more about %s challange.', 'TEXT_DOMAIN'), the_title_attribute('echo=0&post=' . $post_id)),
            $link_dest == 'popup' ? 'challenge-popup' : '',
            wpimage('img=' . $sponsor_image . '&h=' . $this->challanges_settings()['lh'] . '&w=' . $this->challanges_settings()['lw'] . '&retina=' . $retina . '&crop=false'),
            the_title_attribute('echo=0&post=' . $sponsor_id) . ' ' . __('logo', 'TEXT_DOMAIN')
          );
        } else {
          $sponsor .= sprintf(
            '<div class="sp-logo"><img ' . $image_source . '="%s" alt="%s"/></div>',
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
        $challange_batch .= sprintf(
          '<div class="spon-batch"><img ' . $image_source . '="%s" alt="%s"></div>',
          wpimage('img=' . $batch . '&h=' . $this->challanges_settings()['sbatch'] . '&w=' . $this->challanges_settings()['sbatch']),
          sprintf('%s challenge is new in %s', the_title_attribute('echo=0&post=' . $post_id), $batch_year)
        );
      }
            // Challenge image
      if (in_array('image', $challange) && get_field('challenge_main_image', $post_id) != '') {
        $image = wpimage('img=' . get_field('challenge_main_image', $post_id) . '&h=' . $this->challanges_settings()['simgh'] . '&w=' . $this->challanges_settings()['simgw'] . '&crop=true&upscale=true&retina=false');


        if ($link_dest == 'popup') {
          $sponsor .= sprintf(
            '<div class="challange-image"><a href="#%s" title="%s" class="challenge-popup"><img ' . $image_source . '="%s" />%s</a></div>',
            $popup_link,
            sprintf(__('Discover more about %s challenge', 'TEXT_DOMAIN'), str_replace('Challenge', '', the_title_attribute('echo=0&post=' . $post_id))),
            $image,
            $challange_batch
          );
        } else {
          $sponsor .= sprintf(
            '<div class="challange-image"><a href="%s" title="%s"><img ' . $image_source . '="%s" />%s</a></div>',
            esc_url(get_the_permalink($post_id)),
            sprintf(__('Discover more about %s challenge', 'TEXT_DOMAIN'), str_replace('Challenge', '', the_title_attribute('echo=0&post=' . $post_id))),
            $image,
            $challange_batch
          );
        }
      }

            // Challange name
      if (in_array('title', $challange)) {
        if ($link_dest == 'popup') {
          $sponsor .= sprintf(
            '<div class="challange-title display-%1$s" data-mh="c-title"><h3><a href="#%2$s" title="%3$s" class="challenge-popup">%4$s</a></h3></div>',
            $display,
            $popup_link,
            sprintf(__('Discover more about %s challenge.', 'TEXT_DOMAIN'), the_title_attribute('echo=0&post=' . $post_id)),
            the_title_attribute('echo=0&post=' . $post_id)
          );
        } else {
          $sponsor .= sprintf(
            '<div class="challange-title display-%1$s" data-mh="c-title"><h3><a href="%2$s" title="%3$s">%4$s</a></h3></div>',
            $display,
            esc_url(get_permalink($post_id)),
            sprintf(__('Discover more about %s challenge.', 'TEXT_DOMAIN'), the_title_attribute('echo=0&post=' . $post_id)),
            the_title_attribute('echo=0&post=' . $post_id)
          );
        }
      }

            // Challange short description
      if (in_array('description', $challange)) {

        if ($link_dest == 'popup') {

          $sponsor .= sprintf(
            '<div class="challange-description" data-mh="c-description"><div class="description-inner first-last"><a href="#%s" class="challenge-popup">%s</a></div></div>',
            $popup_link,
            get_field('attendee_short_description', $post_id)
          );

        } else {
          $sponsor .= sprintf(
            '<div class="challange-description" data-mh="c-description"><div class="description-inner first-last"><a href="%s">%s</a></div></div>',
            esc_url(get_permalink($post_id)),
            get_field('attendee_short_description', $post_id)
          );
        }
      }

            // Challange button
      if (in_array('button', $challange)) {
        if ($link_dest == 'popup') {
          $sponsor .= sprintf(
            '<div class="challange-button"><a href="#%s" title="%s" class="button small fill color-green challenge-popup">%s</a></div>',
            $popup_link,
            sprintf(__('Discover more about %s challenge.', 'TEXT_DOMAIN'), the_title_attribute('echo=0&post=' . $post_id)),
            __('Discover More', 'TEXT_DOMAIN')
          );
        } else {
          $sponsor .= sprintf(
            '<div class="challange-button"><a href="%s" title="%s" class="button small fill color-green">%s</a></div>',
            esc_url(get_permalink($post_id)),
            sprintf(__('Discover more about %s challenge.', 'TEXT_DOMAIN'), the_title_attribute('echo=0&post=' . $post_id)),
            __('Discover More', 'TEXT_DOMAIN')
          );
        }
      }

      /* PopUp Information */

      if ($link_dest == 'popup') {

        $image = get_field('challenge_main_image', $post_id);
        $batch = '';

        /* Batch */
        if ($batch_year != '' && in_array('batch', $challange) && get_field('new_batch', $post_id) == true) {

          $batch = wp_upload_dir()['baseurl'] . '/2018/10/batch-' . $batch_year . '.png';

          $batch = sprintf(
          '<div class="pop-batch"><img ' . $image_source . '="%s" alt="%s"></div>',
          wpimage('img=' . $batch . '&h=' . $this->challanges_settings()['sbatch'] . '&w=' . $this->challanges_settings()['sbatch']),
          sprintf('%s challenge is new in %s', the_title_attribute('echo=0&post=' . $post_id), $batch_year)
        );

      }

      /* Sponsor */
      $sim = '';
      if($sponsor_image != '') {
        $sim = sprintf('<div class="sponsor-image"><span>Sponsored by</span><img src="%s"></div>',
          wpimage('img=' . $sponsor_image . '&h=' . $this->challanges_settings()['lh'] . '&w=' . $this->challanges_settings()['lw'] . '&retina=false&crop=false')
        );
      }

        $text = '';

        if ($image) {
          $text .= sprintf('<div class="popimage"><img src="%s" alt="%s">%s</div>',
            wpimage('img=' . $image . '&w=700&h=400&crop=true&retina=false&upscale=true'),
            the_title_attribute('echo=0'),
            $batch != '' ? '<div class="batch-pop">'.$batch.'</div>' : ''
          );
        }

        $text .= sprintf('<div class="title-pop">%s</div>', the_title_attribute('echo=0'));

        if (get_field('attendee_short_description_pop', $post_id)) {
          $text    .= sprintf('<div class="description-pop">%s</div>', get_field('attendee_short_description_pop', $post_id));
        }

        $text .=  $sim ;

        $sponsor .= sprintf('<div id="%s" style="display:none;">%s</div>', $popup_link, $text);
      }

      return $sponsor;
    }

    public function VC_BRDC_Challanges_shortcode_callback($atts, $content = null)
    {
      wp_reset_query();

      extract(shortcode_atts(array(
        'year'         => date('Y'),
        'batch_year'   => date('Y'),
        'display'      => 'slick',
        'bcg'          => 'white',
        'link_dest'    => 'link',
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
          $this->require_script()['slick'];
        }

        $slick_settings = '';
        if ($display == 'slick') {
          $slick_settings = ' data-slick=\'{"slidesToShow": ' . $row . ', "slidesToScroll": ' . $row . '}\'';
        }

        $item .= $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';
        $item .= '<div class="' . $this->pixels_class($space_above, 'spacer-top') . ' ' . $this->pixels_class($space_below, 'spacer-bottom') . '">';
        $item .= '<div class="challanges-container ' . ($display == 'slick' ? ' sli ' : '') . ' challanges-in-' . $display . ' row-' . $row . '"' . $slick_settings . '>';
        $i = 1;
        while ($the_query->have_posts()) {
          $the_query->the_post();
          $id = get_the_ID();
          $item .= sprintf(
            '<div class="challange-item challange-item-%s"><div class="bcg-%s inner">%s%s</div></div>',
            $id,
            $bcg,
            $this->sponsor($id, $challange, $batch_year, $display, $link_dest),
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