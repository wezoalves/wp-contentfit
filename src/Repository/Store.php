<?php

namespace Review\Repository;

final class Store
{
    public function getById($post_id)
    {
        $post = get_post($post_id);

        if (! $post) {
            return null;
        }

        $key = \Review\WordPress\CustomPostType\Store::getKey();
        $post_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $type = get_post_meta($post->ID, $key . '_type', true);
        $type = \Review\Utils\TypeStore::getById($type);
        $logosvg = get_post_meta($post->ID, $key . '_logosvg', true);
        $description = get_post_meta($post->ID, $key . '_description', true);
        $domain = get_post_meta($post->ID, $key . '_domain', true);
        $url = get_post_meta($post->ID, $key . '_url', true);
        $email = get_post_meta($post->ID, $key . '_email', true);
        $ra_shortname = get_post_meta($post->ID, $key . '_ra_shortname', true);
        $ra_storeid = get_post_meta($post->ID, $key . '_ra_storeid', true);
        $ra_score = get_post_meta($post->ID, $key . '_ra_score', true);
        $programs = get_post_meta($post->ID, $key . '_affiliate', true);
        $programs = $programs ? $programs : null;

        $programsList = [];
        if ($programs) :
            foreach ($programs as $program) :
                $programsList[] = (new \Review\Model\AffiliateProgram())
                    ->setAdvertiserId($program['advertiser_id'])
                    ->setPublisherId($program['publisher_id'])
                    ->setComission(intval($program['comission']))
                    ->setPlatform($program['platform']);
            endforeach;
        endif;

        return (new \Review\Model\Store())
            ->setId($post_id)
            ->setKeyCpt($key)
            ->setType($type)
            ->setLogo($post_image)
            ->setDescription($description)
            ->setTitle(get_the_title($post->ID))
            ->setContent(get_the_content($post->ID))
            ->setLink(get_permalink($post->ID))
            ->setLogoSvg($logosvg)
            ->setDomain($domain)
            ->setUrl($url)
            ->setEmail($email)
            ->setRaShortName($ra_shortname)
            ->setRaStoreId($ra_storeid)
            ->setRaScore($ra_score)
            ->setAffiliatePrograms($programsList);
    }

    public function getAll($query = [
        'post_type' => 'loja',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ])
    {

        $key = \Review\WordPress\CustomPostType\Store::getKey();

        $query = new \WP_Query($query);

        $stores = [];
        if ($query->have_posts()) {
            while ($query->have_posts()) {

                $query->the_post();
                $post = get_post(get_the_ID());
                $post_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                $type = get_post_meta($post->ID, $key . '_type', true);
                $type = \Review\Utils\TypeStore::getById($type);
                $logosvg = get_post_meta($post->ID, $key . '_logosvg', true);
                $description = get_post_meta($post->ID, $key . '_description', true);
                $domain = get_post_meta($post->ID, $key . '_domain', true);
                $url = get_post_meta($post->ID, $key . '_url', true);
                $email = get_post_meta($post->ID, $key . '_email', true);
                $ra_shortname = get_post_meta($post->ID, $key . '_ra_shortname', true);
                $ra_storeid = get_post_meta($post->ID, $key . '_ra_storeid', true);
                $ra_score = get_post_meta($post->ID, $key . '_ra_score', true);
                $programs = get_post_meta($post->ID, $key . '_affiliate', true);
                $programs = $programs ? $programs : null;

                $programsList = [];
                if ($programs) :
                    foreach ($programs as $program) :
                        $programsList[] = (new \Review\Model\AffiliateProgram())
                            ->setAdvertiserId($program['advertiser_id'])
                            ->setPublisherId($program['publisher_id'])
                            ->setComission(intval($program['comission']))
                            ->setPlatform($program['platform']);
                    endforeach;
                endif;

                $stores[$post->ID] = (new \Review\Model\Store())
                    ->setId($post->ID)
                    ->setKeyCpt($key)
                    ->setType($type)
                    ->setLogo($post_image)
                    ->setDescription($description)
                    ->setTitle(get_the_title($post->ID))
                    ->setContent(get_the_content($post->ID))
                    ->setLink(get_permalink($post->ID))
                    ->setLogoSvg($logosvg)
                    ->setDomain($domain)
                    ->setUrl($url)
                    ->setEmail($email)
                    ->setRaShortName($ra_shortname)
                    ->setRaStoreId($ra_storeid)
                    ->setRaScore($ra_score)
                    ->setAffiliatePrograms($programsList);

            }
            wp_reset_postdata();
        }
        return $stores;
    }

    public function getByType($type = ['BRAND'])
    {

        $key = \Review\WordPress\CustomPostType\Store::getKey();

        $metaQuery[] = [
            'key' => $key . '_type',
            'value' => $type,
            'compare' => 'IN'
        ];

        $query = new \WP_Query([
            'post_type' => 'loja',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => $metaQuery
        ]);

        $stores = [];
        if ($query->have_posts()) {
            while ($query->have_posts()) {

                $query->the_post();
                $post = get_post(get_the_ID());
                $post_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                $type = get_post_meta($post->ID, $key . '_type', true);
                $type = \Review\Utils\TypeStore::getById($type);
                $logosvg = get_post_meta($post->ID, $key . '_logosvg', true);
                $description = get_post_meta($post->ID, $key . '_description', true);
                $domain = get_post_meta($post->ID, $key . '_domain', true);
                $url = get_post_meta($post->ID, $key . '_url', true);
                $email = get_post_meta($post->ID, $key . '_email', true);
                $ra_shortname = get_post_meta($post->ID, $key . '_ra_shortname', true);
                $ra_storeid = get_post_meta($post->ID, $key . '_ra_storeid', true);
                $ra_score = get_post_meta($post->ID, $key . '_ra_score', true);
                $programs = get_post_meta($post->ID, $key . '_affiliate', true);
                $programs = $programs ? $programs : null;

                $programsList = [];
                if ($programs && !empty($programs)) :
                    foreach ($programs as $program) :
                        $programsList[] = (new \Review\Model\AffiliateProgram())
                            ->setAdvertiserId($program['advertiser_id'])
                            ->setPublisherId($program['publisher_id'])
                            ->setComission(intval($program['comission']))
                            ->setPlatform($program['platform']);
                    endforeach;
                endif;

                $stores[$post->ID] = (new \Review\Model\Store())
                    ->setId($post->ID)
                    ->setKeyCpt($key)
                    ->setType($type)
                    ->setLogo($post_image)
                    ->setDescription($description)
                    ->setTitle(get_the_title($post->ID))
                    ->setContent(get_the_content($post->ID))
                    ->setLink(get_permalink($post->ID))
                    ->setLogoSvg($logosvg)
                    ->setDomain($domain)
                    ->setUrl($url)
                    ->setEmail($email)
                    ->setRaShortName($ra_shortname)
                    ->setRaStoreId($ra_storeid)
                    ->setRaScore($ra_score)
                    ->setAffiliatePrograms($programsList);

            }
            wp_reset_postdata();
        }
        return $stores;
    }
}