<?php
namespace config\theme;

class header {

    public static function header($ga = '') {

        ob_start();

        ?>
<!DOCTYPE html>
  <html <?php language_attributes();?> class="no-js">
  <head>
    <title><?php wp_title('');?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="<?php bloginfo('charset');?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="//www.google-analytics.com" rel="dns-prefetch">
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo('pingback_url');?>" />
    <?php wp_head();?>
    <?php self::ga($ga) ?>
  </head>
  <body>
    <?php

        $header = ob_get_contents();

        ob_end_clean();

        return $header;
    }

    /* Add google analitics */
    private static function ga($ga = '') {

        if ($ga === '') {
            return;
        }

        printf('<!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=%1$s"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag(\'js\', new Date());
        gtag(\'config\', \'%1$s\');
        </script>', $ga);

    }
}
