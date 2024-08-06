<?php

namespace Review\Repository;

use \Review\Model\Coupon as CouponModel;

final class Coupon implements \Review\Interface\RepositoryInterface
{
    public function getById($post_id)
    {
        $post = get_post($post_id);

        if (!$post) {
            return null;
        }

        return $this->createModel($post);
    }

    public function getAll($per_page = 10, $page = 0, $search_term = null)
    {
        $args = array(
            'post_type' => 'cupom',
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
                $itemsArray[] = $this->createModel($post);
            }
            wp_reset_postdata();
        }

        return $itemsArray;
    }

    private function createModel($post)
    {
        return (new CouponModel())
            ->setId($post->ID)
            ->setTitle(get_the_title($post->ID))
            ->setDescription(get_the_content($post->ID))
            ->setPercentage(get_post_meta($post->ID, 'coupon_percentage', true))
            ->setAffiliatePlatform(get_post_meta($post->ID, 'coupon_affiliatePlatform', true))
            ->setPromotionId(get_post_meta($post->ID, 'coupon_promotionId', true))
            ->setCode(get_post_meta($post->ID, 'coupon_code', true))
            ->setIniDate(get_post_meta($post->ID, 'coupon_iniDate', true))
            ->setEndDate(get_post_meta($post->ID, 'coupon_endDate', true))
            ->setAddDate(get_post_meta($post->ID, 'coupon_addDate', true))
            ->setTerms(get_post_meta($post->ID, 'coupon_terms', true))
            ->setLink(get_permalink($post->ID))
            ->setUrl(get_post_meta($post->ID, 'coupon_url', true));
    }
}
