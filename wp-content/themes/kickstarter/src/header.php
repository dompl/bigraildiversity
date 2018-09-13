<?php echo config\theme\header::header('UA-71890077-1'); // Pass GA code  ?>
<header id="header" class="top-header">
  <div id="top">
    <div class="container">
      <div class="su-span">
        <div class="contact">
          <div class="email">
            <i class="icon-envelope"></i> <?php _e('Email us at:')?> <a href="mailto:<?php echo antispambot('info@bigraildiversity.co.uk') ?>"><?php echo antispambot('info@bigraildiversity.co.uk') ?></a>
          </div>
          <div class="tel">
            <i class="icon-telephone"></i> <?php _e('Call us on:')?> <a href="tel:01780 432930">01780 432930</a>
          </div>
        </div>
        <div class="enter">
          <a href="/about/attend/" class="button outlined green" title="<?php _e('Attend', 'TEXT_DOMAIN') ?> <?php echo get_bloginfo('name') ?>"><?php _e('Attend', 'TEXT_DOMAIN'); ?></a>
        </div>
      </div>
    </div>
    <div class="container-full">
      <div class="main-nav clx su-span"><?php echo ks_nav('breakpoint=768&text=Menu') ?></div>
    </div>
  </header>
