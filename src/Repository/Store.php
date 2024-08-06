<?php

namespace Review\Repository;

final class Store implements \Review\Interface\RepositoryInterface
{
    public function getById($post_id)
    {
        $post = get_post($post_id);

        if (! $post) {
            return null;
        }

        return $this->createModel($post);
    }

    public function getAll($query = [
        'post_type' => 'loja',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ])
    {
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
                $stores[$post->ID] = $this->createModel($post);
            }
            wp_reset_postdata();
        }

        return $stores;
    }

    public function getByDomain($domain)
    {
        $metaQuery[] = [
            'key' => 'store_domain',
            'value' => $domain,
            'compare' => '=='
        ];

        $query = new \WP_Query([
            'post_type' => 'loja',
            'posts_per_page' => 1,
            'post_status' => 'publish',
            'meta_query' => $metaQuery
        ]);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post = get_post(get_the_ID());

                if (! $post) {
                    return null;
                }

                return $this->createModel($post);
            }
        }
        wp_reset_postdata();
        return null;
    }

    public function createModel($post)
    {
        $key = \Review\WordPress\CustomPostType\Store::getKey();
        $post_image = get_the_post_thumbnail_url($post->ID, 'full');
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
        $programsList = $this->createAffiliateProgramsList($programs);
        $showInFront = get_post_meta($post->ID, $key . '_showinfront', true);

        return (new \Review\Model\Store())
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
            ->setAffiliatePrograms($programsList)
            ->setShowInFront($showInFront)
            ;
    }

    private function createAffiliateProgramsList($programs)
    {
        $programsList = [];
        if ($programs) {
            foreach ($programs as $program) {
                $programsList[] = (new \Review\Model\AffiliateProgram())
                    ->setAdvertiserId($program['advertiser_id'])
                    ->setPublisherId($program['publisher_id'])
                    ->setComission(intval($program['comission']))
                    ->setPlatform($program['platform']);
            }
        }
        return $programsList;
    }
}
