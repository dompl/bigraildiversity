<?php
$logo_1    = 55;
$logo_2    = 47;
$logo_3    = 52;
$logo_size = 80;
?>
<div class="container flex-center" id="logo-container">
  <div class="left">
    <?php if ($logo_1): ?>
      <div class="logo-1 logo">
        <a href="<?php echo esc_url(get_bloginfo('url')); ?>">
          <img src="<?php echo wpimage('img=' . $logo_1 . '&h=' . $logo_size) ?>" data-src="<?php echo wpimage('img=' . $logo_1 . '&h=' . $logo_size . '&retina=true') ?>"  class="lazy no" alt="<?php echo bloginfo('name') ?> <?php _e('logo', 'TEXT_DOMAIN');?>">
        </a>
      </div>
    <?php endif?>
    <?php if ($logo_2): ?>
      <div class="logo-2 logo">
        <a href="<?php echo esc_url(get_bloginfo('url')); ?>">
          <img src="<?php echo wpimage('img=' . $logo_2 . '&h=' . $logo_size . '&crop=false') ?>" data-src="<?php echo wpimage('img=' . $logo_2 . '&h=' . $logo_size . '&retina=true&crop=false') ?>"  class="lazy no" alt="<?php echo bloginfo('name') ?> <?php _e('logo', 'TEXT_DOMAIN');?>">
        </a>
      </div>
    <?php endif?>
  </div>
  <div class="right flex-center">
    <?php if ($logo_3): ?>
      <div class="logo-3 logo">
        <a href="http://www.nimblemedia.co.uk" title="<?php _e('Event organiser', 'TEXT_DOMAIN');?>">
          <img src="<?php echo wpimage('img=' . $logo_3 . '&h=' . $logo_size / 1.5 . '&crop=false') ?>" data-src="<?php echo wpimage('img=' . $logo_3 . '&h=' . $logo_size / 1.5 . '&retina=true&crop=false') ?>" class="lazy no" alt="<?php echo bloginfo('name') ?> <?php _e('logo', 'TEXT_DOMAIN');?>">
        </a>
      </div>
      <div class="button">
        <a href="/about/attend/" class="button large outlined wir" title="<?php _e('Attend Big Rail Diversity Challange')?>"><?php _e('Enter', 'TEXT_DOMAIN'); ?> <span> <?php _e('Today', 'TEXT_DOMAIN'); ?></span></a>
      </div>
    <?php endif?>
  </div>
</div>