<div class="flex-between">
  <div class="about-nimble about">
    <div class="logo">
      <a href="<?php esc_url('http://www.nimblemedia.co.uk')?>" title="<?php _e('Visit Nimble Media website', 'TEXT_DOMAIN');?>">
        <img data-src="<?php echo wpimage('img=' . (int) get_field('nimble_footer_logo', 'options') . '&h=50&w=9999&crop=false&retina=true') ?>" src="<?php echo wpimage('img=' . (int) get_field('nimble_footer_logo', 'options') . '&h=50&w=9999&crop=false&retina=false') ?>" alt="<?php _e('Nimble Media logo', 'TEXT_DOMAIN');?>" class="lazy no">
      </a>
    </div>
    <div class="content">
      <?php the_field('nimble_media_text', 'options')?>
    </div>
  </div>
  <div class="about-wir about">
    <div class="logo">
      <a href="<?php esc_url('http://www.womeninrail.org')?>" title="<?php _e('Visit Women in Rail websit', 'TEXT_DOMAIN');?>">
        <img data-src="<?php echo wpimage('img=' . (int) get_field('wir_footer_logo', 'options') . '&h=50&w=9999&crop=false&retina=true') ?>" src="<?php echo wpimage('img=' . (int) get_field('wir_footer_logo', 'options') . '&h=50&w=9999&crop=false&retina=false') ?>" alt="<?php _e('Women in Rail logo', 'TEXT_DOMAIN');?>" class="lazy no">
      </a>
    </div>
    <div class="content">
      <?php echo the_field('wir_text', 'options') ?>
    </div>
  </div>
</div>