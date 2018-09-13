<?php
/**
 * WordPress link array.
 * ---
 */
namespace config\helpers;

class link {

    public $link;
    public $link_colse;
    public $link_classes;
    public $link_data;

    public function __construct($link = '', $link_close = true, $link_classes = '', $link_data = '') {
        $this->link         = $link;
        $this->link_close   = $link_close;
        $this->link_classes = $link_classes;
        $this->link_data    = $link_data;
    }

    /* Return the full HTML for the link */
    public function html() {

        $wplink = $this->link;

        $link_html = sprintf('<a href="%1$s" title="%6$s"%3$s%4$s%7$s>%2$s%5$s',
            $this->url(),
            $this->title(),
            $wplink['target'] != '' ? ' target="' . $wplink['target'] . '"' : '',
            $this->link_classes != '' ? ' class="' . esc_html($this->link_classes) . '"' : '',
            $this->link_close == true ? '</a>' : '',
            ucfirst(strtolower(esc_html($this->title()))),
            $this->link_data ? ' ' . $this->link_data : ''
        );

        return $link_html;
    }

    /* Return URL onlu */
    public function url() {
        return esc_url($this->link['url']);
    }

    /* Return link title */
    public function title() {
        if ($this->link['title'] === '') {
            return;
        }
        return $this->link['title'];
    }

}
