<?php get_header();?>
<main class="container">
  <article id="page_404">
    <?php if (get_field('error_page_image', 'options')): $img = (int) get_field('error_page_image', 'options');?>
        <div class="image_404 center">
          <img src="<?php echo wpimage('img=' . $img . '&w=800&retina=false&crop=false&h=9999')?>" data-src="<?php echo wpimage('img=' . $img . '&w=800&retina=true&crop=false&h=9999')?>"alt="<?php esc_html(imagedata($img)['alt'])?>" class="lazy no">
        </div>
      <?php endif?>
    <?php if (get_field('error_page_text', 'options')): ?>
      <div class="first-last content">
        <?php the_field('error_page_text', 'options')?>
      </div>
    <?php endif?>
    <?php if (get_field('error_page_button', 'options')): $button = get_field('error_page_button', 'options');?>
        <div class="center">
        <a href="<?php echo $button['url'] ?>" target="<?php echo $button['target'] ?>" title="<?php echo $button['title'] ?>" class="button outlined green uc"><?php echo $button['title'] ?></a>
        </div>
      <?php endif?>
  </article>
</main>
<?php get_footer();
