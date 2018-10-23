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
    <link href="<?php echo get_template_directory_uri(); ?>/img/theme/favicon.ico" rel="shortcut icon">
    <?php
    $http_host = getenv('HTTP_HOST');
    if ($http_host == 'http167.99.206.212/bigrail') {
     echo '<script src="//cdn.trackduck.com/toolbar/prod/td.js" async data-trackduck-id="5bb9e15b55fb3c8278d9c8fe"></script>'
    }
    ?>
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
