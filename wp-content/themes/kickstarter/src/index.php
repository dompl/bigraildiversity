<?php get_header();

printf('<main role="main" aria-label="Content">');
printf('<section class="container">');

if (have_posts()) {
    while (have_posts()) {
        the_post();
        printf('<article>');
        the_content();
        printf('</article>');
    }
}

printf('</section>');
printf('</main>');

get_sidebar();
get_footer();
