<?php
/**
 * Create Custom Post type
 * Documentation : https://github.com/jjgrainger/PostTypes
 * ---
 */
namespace config\setup;
use PostTypes\PostType;

class cpt {

    public function __construct() {
        // $this->portfolio();
    }

    public function portfolio() {

        $names = array(
            'name'     => 'portfolio',
            'singular' => 'Portfolio',
            'plural'   => 'Portfolio',
            'slug'     => 'our-work',
        );

        $portfolio = new PostType($names);

        $portfolio->icon('dashicons-image-filter');

        return $portfolio->register();

    }

}
