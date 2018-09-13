<?php
/*  ********************************************************
 *   Custom excerpt
 *  ********************************************************
 */
namespace config\helpers;

class CustomExcerpt {

    public static function custom_excerpt($character_length = 100, $continue = '...') {

        global $post;

        $excerpt = get_the_excerpt();

        if (has_excerpt()) {
            return get_the_excerpt();
        }

        $character_length++;

        if (mb_strlen($excerpt) > $character_length) {

            $subex   = mb_substr($excerpt, 0, $character_length - 5);
            $exwords = explode(' ', $subex);
            $excut   = -(mb_strlen($exwords[count($exwords) - 1]));

            if ($excut < 0) {

                echo mb_substr($subex, 0, $excut);

            } else {

                echo $subex;

            }

            echo $continue;

        } else {

            echo $excerpt;

        }

    }

}
