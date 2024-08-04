<?php

namespace Review\Repository;

use \Review\Model\Example as ExampleModel;

final class Example
{
    public function getById($post_id)
    {
        $post = get_post($post_id);

        if (! $post) {
            return null;
        }

        $options = [
            (new \Review\Model\SimpleType("ID_ONE", "Name One")),
            (new \Review\Model\SimpleType("ID_TWO", "Name Two"))
        ];
        $data = (new ExampleModel($post->ID, "TYPE_C", "NAME", "VALUE", $options));
        return $data;
    }

    public function getAll($per_page = 10, $page = 0, $search_term = null)
    {

        $args = array(
            'post_type' => \Review\WordPress\CustomPostType\Example::getKey(),
            'posts_per_page' => $per_page,
            'paged' => $page,
            's' => $search_term
        );

        $custom_types_query = new \WP_Query($args);
        $itemsArray = [];
        if ($custom_types_query->have_posts()) {

            $options = [
                (new \Review\Model\SimpleType("ID_ONE", "Name One")),
                (new \Review\Model\SimpleType("ID_TWO", "Name Two"))
            ];

            while ($custom_types_query->have_posts()) {
                $custom_types_query->the_post();

                $post = get_post(get_the_ID());
                $data = (new ExampleModel($post->ID, "TYPE_C", "NAME", "VALUE", $options));

                $itemsArray[] = $data;
            }
            wp_reset_postdata();
        }
        return $itemsArray;
    }
}