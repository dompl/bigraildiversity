<?php
/*
Template Name: Sample Template
Template Post Type: page
 */
get_header();
if (have_posts()) {
    while (have_posts()) {
        the_post();
        the_content();
    }
}
get_footer();
