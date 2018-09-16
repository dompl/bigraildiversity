<?php get_header();

printf('<main role="main" aria-label="Content">');


if (have_posts()) {
    while (have_posts()) {
        the_post();

        the_content();

    }
}


printf('</main>');

get_sidebar();
get_footer();
