<?php

namespace theme\visual_composer;

use config\visual_composer\Visual_Composer_General_Settings;

if ( !  class_exists( 'VC_BRDC_Testimonial_Scroller' ) ) {

    class VC_BRDC_Testimonial_Scroller extends Visual_Composer_General_Settings
    {

        public function __construct()
        {
            add_action( 'vc_before_init', array( &$this, 'VC_BRDC_Testimonial_Scroller_section_map' ) );
            add_shortcode( 'VC_BRDC_Testimonial_Scroller_shortcode', array( &$this, 'VC_BRDC_Testimonial_Scroller_shortcode_callback' ) );

        }

        /**
         * @return mixed
         */
        public function event_testimonials()
        {
            $tesimonial = array();
            if ( have_rows( 'misc_testimonials', 'options' ) ) {
                $i = 1;
                while ( have_rows( 'misc_testimonials', 'options' ) ) {
                    the_row();
                    $name          = get_sub_field( 'testimonials_person', 'options' ) . ' - ' . get_sub_field( 'testimoanial_company', 'options' )['label'];
                    $number        = get_sub_field( 'testimoanial_company', 'options' )['value'];
                    $data['value'] = $number;
                    $data['label'] = $name;
                    $tesimonial[]  = $data;
                    $i++;
                }
            }
            return $tesimonial;

        }

        /**
         * Params
         * ---
         */
        public function params()
        {

            $params = array(
                array(
                    'type'        => 'dropdown',
                    'holder'      => 'div',
                    'class'       => 'vc_hidden',
                    'admin_label' => true,
                    'heading'     => __( 'Settings', 'TEXT_DOMAIN' ),
                    'param_name'  => 'content_cource',
                    'group'       => __( 'Settings', 'TEXT_DOMAIN' ),
                    'value'       => array(
                        __( 'From current page', 'TEXT_DOMAIN' )            => 'current',
                        __( 'All testimonials', 'TEXT_DOMAIN' )             => 'all',
                        // __('Event testimonials', 'TEXT_DOMAIN')           => 'event',
                        __( 'Event testimonials from year', 'TEXT_DOMAIN' ) => 'per_year',
                        __( 'Custom testimonials', 'TEXT_DOMAIN' )          => 'custom_testimonials'
                    ),
                    'description' => __( 'Select testimonial source', 'TEXT_DOMAIN' ),
                    'std'         => 'current'
                ),

                array(
                    'type'        => 'custom_radio',
                    'holder'      => 'div',
                    'class'       => 'vc_hidden',
                    'heading'     => __( 'Miscellaneous testimonials year', 'TEXT_DOMAIN' ),
                    'param_name'  => 'years',
                    'admin_label' => true,
                    'group'       => __( 'Settings', 'TEXT_DOMAIN' ),
                    'value'       => $this->years(),
                    'description' => __( 'Set miscellaneous testimonials year', 'TEXT_DOMAIN' ),
                    'std'         => date( 'Y' ),
                    'dependency'  => array(
                        'element' => 'content_cource',
                        'value'   => array( 'per_year' )
                    )
                ),

                array(
                    'type'        => 'autocomplete',
                    'class'       => '',
                    'heading'     => __( 'Specific testimonials', 'TEXT_DOMAIN' ),
                    'param_name'  => 'testimonias_id',
                    'group'       => __( 'Settings', 'TEXT_DOMAIN' ),
                    'settings'    => array(
                        'values'         => $this->event_testimonials(),
                        'multiple'       => true,
                        'sortable'       => true,
                        'min_length'     => 1,
                        'no_hide'        => false, // In UI after select doesn't hide an select list
                        'groups'         => true,  // In UI show results grouped by groups
                        'unique_values'  => true,  // In UI show results except selected. NB! You should manually check values in backend
                        'display_inline' => false // In UI show results inline view),
                    ),
                    'description' => __( 'Select the testimonials to display. If this remains blank, all testimonials will be displayed', 'TEXT_DOMAIN' ),
                    'dependency'  => array(
                        'element' => 'content_cource',
                        'value'   => array( 'event' )
                    )
                ),

                array(
                    'type'        => 'checkbox',
                    'holder'      => 'div',
                    'class'       => 'vc_hidden',
                    'heading'     => __( 'Display', 'TEXT_DOMAIN' ),
                    'param_name'  => 'options',
                    'group'       => __( 'Settings', 'TEXT_DOMAIN' ),
                    'value'       => array(
                        __( 'Display person\'s name', 'TEXT_DOMAIN' )      => 'person_name',
                        __( 'Display company name', 'TEXT_DOMAIN' )        => 'company_name',
                        __( 'Display company logo', 'TEXT_DOMAIN' )        => 'company_logo',
                        __( 'Display company website URL', 'TEXT_DOMAIN' ) => 'company_url'
                    ),
                    'description' => __( 'Set display settings for your testimonial slider', 'TEXT_DOMAIN' ),
                    'std'         => 'person_name,company_name,company_logo,company_url',
                    'dependency'  => array(
                        'element' => 'content_cource',
                        'value'   => array( 'all', 'per_year', 'current' )
                    )
                ),
                array(
                    'type'        => 'checkbox',
                    'holder'      => 'div',
                    'class'       => 'vc_hidden',
                    'heading'     => __( 'Source', 'TEXT_DOMAIN' ),
                    'param_name'  => 'fromwho',
                    'group'       => __( 'Settings', 'TEXT_DOMAIN' ),
                    'value'       => array(
                        __( 'Challenges testimonials', 'TEXT_DOMAIN' )               => 'challenges',
                        __( 'Attendees testimonials', 'TEXT_DOMAIN' )                => 'atendees',
                        __( 'Supporting organizations testimonials', 'TEXT_DOMAIN' ) => 'supportingorgs'
                    ),
                    'description' => __( 'From who would you like to show the testimonials from', 'TEXT_DOMAIN' ), #
                    'std'         => 'challenges,atendees,supportingorgs',
                    'dependency'  => array(
                        'element' => 'content_cource',
                        'value'   => array( 'all', 'per_year', 'current' )
                    )
                ),

                array(
                    'type'        => 'numeric',
                    'holder'      => 'div',
                    'class'       => 'vc_hidden',
                    'heading'     => __( 'Limit', 'TEXT_DOMAIN' ),
                    'param_name'  => 'limit',
                    'group'       => __( 'Settings', 'TEXT_DOMAIN' ),
                    'value'       => '',
                    'description' => __( 'Limit the amount of testimonials to showing in slider', 'TEXT_DOMAIN' ),
                    'dependency'  => array(
                        'element' => 'content_cource',
                        'value'   => array( 'all' )
                    )
                ),

                array(
                    'type'       => 'checkbox',
                    'holder'     => 'div',
                    'class'      => 'vc_hidden',
                    'heading'    => __( 'Randomize', 'TEXT_DOMAIN' ),
                    'param_name' => 'order',
                    'group'      => __( 'Settings', 'TEXT_DOMAIN' ),
                    'value'      => array( __( 'Randomize testimonials', 'TEXT_DOMAIN' ) => true ),
                    'std'        => false,
                    'dependency' => array(
                        'element' => 'content_cource',
                        'value'   => array( 'all' )
                    )
                ),

                array(
                    'type'        => 'numeric',
                    'holder'      => 'div',
                    'class'       => 'vc_hidden',
                    'heading'     => __( 'Autoplay Speed', 'TEXT_DOMAIN' ),
                    'param_name'  => 'speed',
                    'group'       => __( 'Settings', 'TEXT_DOMAIN' ),
                    'value'       => 2,
                    'std'         => false,
                    'description' => __( 'Set autoplay speed (in seconds)', 'TEXT_DOMAIN' ),
                    'dependency'  => array(
                        'element' => 'content_cource',
                        'value'   => array( 'all' )
                    )
                ),

                $this->param_space( 'above' ),
                $this->param_space( 'below' ),
                $this->prevent_space_on_mobile(),
                $this->param_additional_id( 'custom_id', 'Settings' ),
                $this->param_additional_class( 'custom_class', 'Settings' )
            );
            return $params;
        }

        /**
         * Visual Composer Map
         * ---
         */
        public function VC_BRDC_Testimonial_Scroller_section_map()
        {

            $title       = 'Testimonial Scroller';     // Shortcode description
            $description = 'Add testimonial scroller'; // Shortcode Name

            vc_map(
                array(
                    'name'              => __( $title, 'TEXT_DOMAIN' ),
                    'base'              => 'VC_BRDC_Testimonial_Scroller_shortcode',
                    'class'             => '',
                    'category'          => $this->tab_category(),
                    'icon'              => $this->icon( 'icon-testiomonials.svg' ),
                    'description'       => __( $description, 'TEXT_DOMAIN' ),
                    'admin_enqueue_css' => $this->admin_css(),
                    'params'            => $this->params()
                )
            );
        }

        /**
         * @param $atts
         * @param $content
         * @return mixed
         */
        public function VC_BRDC_Testimonial_Scroller_shortcode_callback( $atts, $content = null )
        {

            extract( shortcode_atts( array(
                'options'        => 'person_name,company_name,company_logo,company_url',
                'fromwho'        => 'challenges,atendees,supportingorgs',
                'content_cource' => 'current',
                'years'          => date( 'Y' ),
                'testimonias_id' => '',
                'space_above'    => __( 'None', 'TEXT_DOMAIN' ),
                'space_below'    => __( 'None', 'TEXT_DOMAIN' ),
                'limit'          => '',
                'speed'          => 2,
                'order'          => false,
                'custom_class'   => '',
                'custom_id'      => ''
            ), $atts ) );

            if ( $fromwho == '' || $options == '' ) {
                return;
            }

            $speed = ( (int) $speed * 1000 );

            $options = explode( ',', $options );
            $fromwho = explode( ',', $fromwho );
            $limit   = $limit == '' ? -1 : (int) $limit;

            $item         = '';
            $custom_class = $custom_class != '' ? ' class="' . $custom_class . '"' : false;
            $custom_id    = $custom_id != '' ? ' id="' . $custom_id . '"' : false;

            $item .= $custom_class || $custom_id ? '<div' . $custom_id . $custom_class . '>' : '';
            $item .= '<div class="' . $this->pixels_class( $space_above, 'spacer-top' ) . ' ' . $this->pixels_class( $space_below, 'spacer-bottom' ) . '">';

            $item .= '<div class="testimonials">';
            $item .= '<ul class="testimonial-slider list-unstyled" data-slick=\'{"autoplaySpeed": ' . 2500 . '}\'>';

            $this->require_script()['slick'];

            /* Custom testimonials */
            if ( $content_cource == 'custom_testimonials' ) {

                if ( have_rows( 'custom_testimonials', 'option' ) ) {
                    while ( have_rows( 'custom_testimonials', 'option' ) ) {

                        the_row();
                        $logo = get_sub_field( 'custom_testimonials_logo', 'option' );
                        if ( $logo ) {
                            if ( imagedata( $logo )['width'] < ( imagedata( $logo )['height'] * 1.5 ) ) {
                                $width = 100;
                            } else {
                                $width = 200;
                            }
                        }

                        $person  = get_sub_field( 'custom_testimonials_person', 'option' );
                        $company = get_sub_field( 'custom_testimonials_company', 'option' );
                        $website = get_sub_field( 'custom_testimonials_website', 'option' );
                        $full    = get_sub_field( 'custom_testimonials_full', 'option' );

                        $item .= '<li class="clx">';
                        $item .= $full ? '<div class="full-tesimonial">' . $full . '</div>' : '';
                        $item .= $person ? '<div class="person">' . $person . '</div>' : '';
                        $item .= $company ? '<div class="company">' . $company . '</div>' : '';
                        $item .= $website ? '<div class="website"><a href="' . esc_url( $website ) . '" target="_blank">' : '';
                        $item .= $logo ? '<div class="logo"><img src="' . wpimage( 'img=' . $logo['id'] . '&h=100&w=300&crop=fale' ) . '"  style="margin-left:auto;margin-right:auto" /></div>' : '';
                        $item .= $website ? '</a>' : '';
                        $item .= $website ? '<div class="website"><a href="' . esc_url( $website ) . '" target="_blank">Visit ' . ( $company ?: '' ) . ' website</a></div>': '';
                        $item .= '</li>';
                    }
                }
                /* Not custom testimonials */
            } else {

                if ( $content_cource == 'event' || $content_cource == 'per_year' ) {

                    if ( $content_cource == 'event' ) {
                        $ids = explode( ',', $testimonias_id );
                    } else {
                        $testims = get_field( 'misc_testimonials', 'options' );
                        $ids     = array();
                        foreach ( $testims as $testi ) {
                            if ( $testi['testimonial_from_year'] == $years ) {
                                $ids[] = $testi['testimoanial_company']['value'];
                            }
                        }
                    }

                    foreach ( $testims as $testi ) {

                        if ( $testi['testimonial_from_year'] == $years ) {

                            $id = $testi['testimoanial_company']['value'];

                            $logo = get_field( 'add_attendee_logo', $id );

                            if ( imagedata( $logo )['width'] < ( imagedata( $logo )['height'] * 1.5 ) ) {
                                $width = 100;
                            } else {
                                $width = 200;
                            }

                            $testimonial_from_year = $testi['testimonial_from_year'];
                            $preson                = $testi['testimonials_person'];
                            $company_name          = $testi['testimoanial_company']['label'];
                            $full                  = $testi['full_testimoanal'];

                            if ( $id == $testi['testimoanial_company']['value'] && $content_cource == 'per_year' ) {
                                $item .= sprintf(
                                    '<li class="clx">%s%s%s%s%s</li>',
                                    '<div class="full-tesimonial">' . $full . '</div>',
                                    $preson && in_array( 'person_name', $options ) ? '<div class="person">' . $preson . '</div>' : '',
                                    $company_name && in_array( 'company_name', $options ) ? '<div class="company">' . str_replace( '%company%', get_the_title( $id ), get_the_title( $id ) ) . '</div>' : '',
                                    get_field( 'add_attendee_logo', $id ) && in_array( 'company_logo', $options ) ? '<div class="logo"><a href="' . esc_url( get_the_permalink( $id ) ) . '" title="' . __( 'Discover more about', 'TEXT_DOMAIN' ) . ' ' . the_title_attribute( 'echo=0&post=' . $id ) . '"><img src="' . wpimage( 'img=' . get_field( 'add_attendee_logo', $id ) . '&h=100&w=300&crop=fale' ) . '" alt="' . the_title_attribute( 'echo=0&post=' . $id ) . ' ' . __( 'logo', 'TEXT_DOMAIN' ) . '" /></a></div>' : '',
                                    get_field( 'attendee_website_url', $id ) && in_array( 'company_url', $options ) ? '<div class="website"><a href="' . esc_url( get_field( 'attendee_website_url', $id ) ) . '" target="_blank">' . __( 'Visit', 'TEXT_DOMAIN' ) . ' ' . get_the_title( $id ) . ' ' . __( 'website', 'TEXT_DOMAIN' ) . '</a></div>' : ''
                                );
                            }

                        }
                    }

                } else {

                    // IF NOT SELECTED TESTIMONIALS
                    $args = array(
                        'posts_per_page' => $limit,
                        'meta_query'     => array(
                            array(
                                'key'     => 'testimonials_list',
                                'value'   => array( '' ),
                                'compare' => 'NOT IN'
                            )
                        )
                    );

                    if ( $content_cource == 'all' ) {
                        $args['post_type'] = (array) $fromwho;
                    } elseif ( $content_cource == 'current' ) {
                        $args['post_type'] = get_post_type();
                        $args['post__in']  = array( get_the_ID() );
                    }

                    if ( $order == true && $content_cource == 'all' ) {
                        $args['orderby'] = 'rand';
                    }

                    foreach ( get_posts( $args ) as $post ) {

                        $id = $post->ID;
                        $i  = 1;

                        if ( have_rows( 'testimonials_list', $id ) ) {

                            while ( have_rows( 'testimonials_list', $id ) ) {
                                the_row();

                                $logo = get_field( 'add_attendee_logo', $id );

                                if ( imagedata( $logo )['width'] < ( imagedata( $logo )['height'] * 1.5 ) ) {
                                    $width = 100;
                                } else {
                                    $width = 200;
                                }

                                if ( get_sub_field( 'testimonial', $id ) != '' && get_sub_field( 'in_slider', $id ) == true ) {
                                    $item .= sprintf(
                                        '<li class="clx">%s%s%s%s%s</li>',
                                        '<div class="full-tesimonial">' . get_sub_field( 'testimonial' ) . '</div>',
                                        get_sub_field( 'person' ) && in_array( 'person_name', $options ) ? '<div class="person">' . get_sub_field( 'person' ) . '</div>' : '',
                                        get_sub_field( 'company' ) && in_array( 'company_name', $options ) ? '<div class="company">' . str_replace( '%company%', get_the_title( $id ), get_sub_field( 'company' ) ) . '</div>' : '',
                                        get_field( 'add_attendee_logo', $id ) && in_array( 'company_logo', $options ) ? '<div class="logo"><a href="' . esc_url( get_the_permalink( $id ) ) . '" title="' . __( 'Discover more about', 'TEXT_DOMAIN' ) . ' ' . the_title_attribute( 'echo=0&post=' . $id ) . '"><img src="' . wpimage( 'img=' . get_field( 'add_attendee_logo', $id ) . '&h=100&w=300&crop=fale' ) . '" alt="' . the_title_attribute( 'echo=0&post=' . $id ) . ' ' . __( 'logo', 'TEXT_DOMAIN' ) . '" /></a></div>' : '',
                                        get_field( 'attendee_website_url', $id ) && in_array( 'company_url', $options ) ? '<div class="website"><a href="' . esc_url( get_field( 'attendee_website_url', $id ) ) . '" target="_blank">' . __( 'Visit', 'TEXT_DOMAIN' ) . ' ' . get_the_title( $id ) . ' ' . __( 'website', 'TEXT_DOMAIN' ) . '</a></div>' : ''
                                    );
                                }
                                $i++;
                            }
                        }
                    }
                    wp_reset_postdata();
                }
            }

            $item .= '</ul>';
            $item .= '</div>';

            $item .= '</div>';
            $item .= $custom_class || $custom_id ? '</div>' : '';

            return $item;
        }
    }

}