<?php

namespace Review\Repository;

use \Review\Model\Coupon as CouponModel;

final class Coupon implements \Review\Interface\RepositoryInterface
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

    public function getByStore($storeId = null, $skipId = null, $per_page = 100, $page = 0, $search_term = null)
    {
        $current_date = current_time('d/m/Y H:i:s');
        $current_date_ymd = $this->convertToDate($current_date);

        $query = [
            'posts_per_page' => $per_page,
            'paged' => $page,
            's' => $search_term,
            'post_type' => 'cupom',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_key' => 'coupon_store',
            'meta_query' => array(
                array(
                    'key' => 'coupon_store',
                    'value' => $storeId,
                    'compare' => '=='
                ),
            ),
        ];

        if($skipId){
            $query['post__not_in'] = array($skipId);
        }

        $custom_types_query = new \WP_Query($query);
        $stores = [];

        if ($custom_types_query->have_posts()) {
            while ($custom_types_query->have_posts()) {
                $custom_types_query->the_post();
                $post = get_post(get_the_ID());
                $stores[$post->ID] = $this->createModel($post);
            }
            wp_reset_postdata();
        }

        return $stores;
    }
    public function getNoExpired($per_page = 100, $page = 0, $search_term = null, $orderTerm = 'coupon_endDate')
    {
        $current_date = current_time('d/m/Y H:i:s');
        $current_date_ymd = $this->convertToDate($current_date);

        $query = [
            'posts_per_page' => $per_page,
            'paged' => $page,
            's' => $search_term,
            'post_type' => 'cupom',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_key' => $orderTerm,
            'meta_query' => array(
                array(
                    'key' => 'coupon_endDate',
                    'value' => $current_date_ymd,
                    'compare' => '>=',
                    'type' => 'DATETIME'
                ),
            ),
        ];

        $custom_types_query = new \WP_Query($query);
        $stores = [];

        if ($custom_types_query->have_posts()) {
            while ($custom_types_query->have_posts()) {
                $custom_types_query->the_post();
                $post = get_post(get_the_ID());
                $stores[$post->ID] = $this->createModel($post);
            }
            wp_reset_postdata();
        }

        return $stores;
    }

    private function convertToDate($date)
    {
        $datetime = \DateTime::createFromFormat('d/m/Y H:i:s', $date);
        return $datetime ? $datetime->format('Ymd H:i:s') : '';
    }


    public function createModel($post)
    {

        $idStore = get_post_meta($post->ID, 'coupon_store', true);
        $store = (new \Review\Repository\Store())->getById($idStore);


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
            ->setStore($store)
            ->setUrl(get_post_meta($post->ID, 'coupon_url', true));
    }

}
