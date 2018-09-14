<div class="flex-center">
<div class="about-nimble about">
  <div class="logo">
    <a href="<?php esc_url('http://www.nimblemedia.co.uk')?>" title="<?php _e('Visit Nimble Media website', 'TEXT_DOMAIN');?>">
      <img src="<?php echo get_template_directory_uri(); ?>/img/theme/nimble-logo-white.png" alt="<?php _e('Nimble Media logo', 'TEXT_DOMAIN');?>">
    </a>
  </div>
  <div class="content">
    <?php the_field('nimble_media_text', 'options')?>
  </div>
</div>
<div class="about-wir about">
  <div class="logo">
    <a href="<?php esc_url('http://www.womeninrail.org')?>" title="<?php _e('Visit Women in Rail websit', 'TEXT_DOMAIN');?>">
      <img src="<?php echo get_template_directory_uri(); ?>/img/theme/wir-logo-white.png" alt="<?php _e('Women in Rail logo', 'TEXT_DOMAIN');?>">
    </a>
    </div>
    <div class="content">
      <?php the_field('wir_media_text', 'options')?>
    </div>
  </div>
  </div>