<?php echo config\theme\header::header('UA-71890077-1'); // Pass GA code        ?>
<button class="inline">Show</button>
<div id="inline" style="display:none;">
  <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</p>
</div>
<header id="header" class="top-header">
  <div id="top">
    <div class="container flex-center">
      <div class="contact">
        <div class="email">
          <div class="desktop">
            <i class="icon-envelope"></i> <?php _e('Email us at:')?> <a href="mailto:<?php echo antispambot('info@bigraildiversity.co.uk') ?>"><strong><?php echo antispambot('info@bigraildiversity.co.uk') ?></strong></a>
          </div>
          <div class="mobile">
            <a href="mailto:<?php echo antispambot('info@bigraildiversity.co.uk') ?>"><i class="icon-envelope-bold"></i></a>
          </div>
        </div>
        <div class="tel">
          <div class="desktop">
            <i class="icon-phone"></i> <?php _e('Call us on:')?> <strong>01780 432930</strong></a>
          </div>
          <div class="mobile">
            <a href="tel:01780 432930"><i class="icon-phone-bold"></i></a>
          </div>
        </div>
      </div>
      <div class="social">
        <ul class="list-unstyled">
          <li><a href="https://www.facebook.com/bigraildiversity/" title="<?php _e('Join us on Facebook', 'TEXT_DOMAIN');?>" target="_blank"><i class="icon-facebook"></i></a></li>
          <li><a href="https://twitter.com/braildiversityc?lang=en" title="<?php _e('Follow us on Twitter', 'TEXT_DOMAIN');?>" target="_blank"><i class="icon-twitter"></i></a></li>
        </ul>
      </div>
    </div>
  </div>
 <?php get_template_part('modules/header' , 'logos');?>
  <div id="top-nav">
    <div class="container">
    <div class="main-nav clx"><?php echo ks_nav('breakpoint=1024&text=') ?></div>
  </div>
  </div>
</header>
