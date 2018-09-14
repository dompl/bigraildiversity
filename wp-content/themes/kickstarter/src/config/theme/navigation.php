<?php
namespace config\theme;

class navigation {

    // default settings for navigation

    public static $defaults = array(
        'breakpoint'     => '768',
        'theme_location' => 'header',
        'menu_id'        => 'menu-header',
        'menu_class'     => 'align-to-left nav-menu clx',
        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'echo'           => 0,
        'nav_id'         => 'navigation',
        'nav_toggle'     => 1,
        'text'           => '',
    );

    // We need to initaie constructor in order to delete transients from nav
    public function __construct() {
        add_filter('wp_nav_menu', array(&$this, 'submenu'));
    }

    public function submenu($menu) {
        $menu = str_replace('class="sub-menu"', 'class="nav-dropdown"', $menu);
        $menu = str_replace('current-menu-item', 'current-menu-item active', $menu);
        $menu = str_replace('menu-item-type-post_type', '', $menu);
        $menu = str_replace('menu-item-object-page', '', $menu);
        return $menu;
    }

    /* Global Arguments */
    private static function nav_args($args = array()) {

        $args = (empty($args)) ? self::$defaults : wp_parse_args($args, self::$defaults);
        return $args;
    }

    /* Navigation header */
    private static function nav_header($nav_args = array()) {

        $args = self::nav_args($nav_args);

        return sprintf('<div class="nav-toggle">%1$s<i class="icon-bars"></i></div>',
            $args['text'] != '' ? '<span class="nav-text">' . __($args['text'], 'TEXT_DOMAIN') . '</span>' : '' // Additional Text
        );

    }

    /* Create navigation bar */
    public static function init($nav_args = array()) {

        $args = self::nav_args($nav_args);

        $data = sprintf(
            '<nav id="%1$s" class="%1$s navigation-landscape"%2$s>%3$s<div class="nav-menus-wrapper">%4$s</div></nav>',
            $args['nav_id'],
            $args['breakpoint'] > 0 ? ' data-breakpoint="' . $args['breakpoint'] . '"' : '',
            $args['nav_toggle'] == 1 ? '<div class="nav-header clx">' . self::nav_header($args) . '</div>' : '',
            wp_nav_menu($args)
        );
        return $data;
    }
}
