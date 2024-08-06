<?php

namespace Review\Repository;

use \Review\Model\Food as FoodModel;

final class Food implements \Review\Interface\RepositoryInterface
{
    public function getById($post_id)
    {
        $post = get_post($post_id);

        if (! $post) {
            return null;
        }

        return $this->createModel($post);
    }

    public function getAll($per_page = 10, $page = 0, $search_term = null)
    {
        $args = array(
            'post_type' => \Review\WordPress\CustomPostType\Foods::getKey(),
            'posts_per_page' => $per_page,
            'paged' => $page,
            's' => $search_term
        );

        $custom_types_query = new \WP_Query($args);
        $foods = [];

        if ($custom_types_query->have_posts()) {
            while ($custom_types_query->have_posts()) {
                $custom_types_query->the_post();
                $post = get_post(get_the_ID());
                $foods[] = $this->createModel($post);
            }
            wp_reset_postdata();
        }

        return $foods;
    }

    public function createModel($post)
    {
        $composition = [];
        foreach (\Review\WordPress\Fields\Foods::fields() as $field) {
            $value = get_post_meta($post->ID, $field->getId(), true);
            $composition[] = new \Review\Model\Field(
                $field->getId(),
                $field->getType(),
                $field->getName(),
                $field->getPlaceholder(),
                $value,
                $field->getGroup()
            );
        }

        return (new FoodModel(""))
            ->setId($post->ID)
            ->setName($post->post_title)
            ->setDescription($post->post_excerpt)
            ->setUrl(get_permalink($post->ID))
            ->setComposition($composition);
    }
}
