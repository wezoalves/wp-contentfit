<?php

namespace Review\Repository;

use \Review\Model\Coupon as CouponModel;

final class Coupon
{
    public function getById($post_id)
    {
        $post = get_post($post_id);

        if (! $post) {
            return null;
        }

        $data = (new CouponModel())
            ->setId($post->ID)
            ->setTitle(get_the_title($post->ID))
            ->setDescription(get_the_content($post->ID))
            ->setPercentage()
            ->setAdvertiserId()
            ->setPromotionId()
            ->setCode()
            ->setIniDate()
            ->setEndDate()
            ->setAddDate()
            ->setTerms()
            ->setLink()
            ->setUrl();
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

            while ($custom_types_query->have_posts()) {
                $custom_types_query->the_post();

                $post = get_post(get_the_ID());
                $data = (new CouponModel())
                    ->setId($post->ID)
                    ->setTitle(get_the_title($post->ID))
                    ->setDescription(get_the_content($post->ID))
                    ->setPercentage()
                    ->setAdvertiserId()
                    ->setPromotionId()
                    ->setCode()
                    ->setIniDate()
                    ->setEndDate()
                    ->setAddDate()
                    ->setTerms()
                    ->setLink()
                    ->setUrl();

                $itemsArray[] = $data;
            }
            wp_reset_postdata();
        }
        return $itemsArray;
    }
}