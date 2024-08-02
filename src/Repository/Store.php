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

        $cpt_store_key = 'store';
        $post_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $type = get_post_meta($post->ID, $cpt_store_key . '_type', true);
        $logo = get_post_meta($post->ID, $cpt_store_key . '_logo', true);
        $logosvg = get_post_meta($post->ID, $cpt_store_key . '_logosvg', true);
        $description = get_post_meta($post->ID, $cpt_store_key . '_description', true);
        $domain = get_post_meta($post->ID, $cpt_store_key . '_domain', true);
        $url = get_post_meta($post->ID, $cpt_store_key . '_url', true);
        $email = get_post_meta($post->ID, $cpt_store_key . '_email', true);
        $ra_shortname = get_post_meta($post->ID, $cpt_store_key . '_ra_shortname', true);
        $ra_storeid = get_post_meta($post->ID, $cpt_store_key . '_ra_storeid', true);
        $ra_score = get_post_meta($post->ID, $cpt_store_key . '_ra_score', true);
        $programs = get_post_meta($post->ID, $cpt_store_key . '_affiliate', true);
        $programs = $programs ? $programs : null;

        $programsList = [];
        if ($programs) :
            foreach ($programs as $program) :
                $programsList[] = (new \Review\Model\AffiliateProgram())
                    ->setAdvertiserId($program['advertiser_id'])
                    ->setPublisherId($program['publisher_id'])
                    ->setComission($program['comission'])
                    ->setPlatform($program['platform']);
            endforeach;
        endif;

        return [
            "id" => $post_id,
            "key_cpt" => $cpt_store_key,
            "type" => $type,
            "image" => $post_image,
            "description" => $description,
            "title" => get_the_title($post->ID),
            "content" => get_the_content($post->ID),
            "link" => get_permalink($post->ID),
            "logo" => $logo,
            "logosvg" => $logosvg,
            "domain" => $domain,
            "url" => $url,
            "email" => $email,
            "ra_shortname" => $ra_shortname,
            "ra_storeid" => $ra_storeid,
            "ra_score" => $ra_score,
            //"programas" => $programs,
            "affiliatePrograms" => $programsList,
        ];
    }

    public function getAll()
    {

        $cpt_store_key = 'store';

        $query = new \WP_Query([
            'post_type' => 'loja',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ]);

        $stores = [];
        if ($query->have_posts()) {
            while ($query->have_posts()) {

                $query->the_post();
                $post = get_post(get_the_ID());
                $cpt_store_key = 'store';
                $post_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                $type = get_post_meta($post->ID, $cpt_store_key . '_type', true);
                $logo = get_post_meta($post->ID, $cpt_store_key . '_logo', true);
                $logosvg = get_post_meta($post->ID, $cpt_store_key . '_logosvg', true);
                $description = get_post_meta($post->ID, $cpt_store_key . '_description', true);
                $domain = get_post_meta($post->ID, $cpt_store_key . '_domain', true);
                $url = get_post_meta($post->ID, $cpt_store_key . '_url', true);
                $email = get_post_meta($post->ID, $cpt_store_key . '_email', true);
                $ra_shortname = get_post_meta($post->ID, $cpt_store_key . '_ra_shortname', true);
                $ra_storeid = get_post_meta($post->ID, $cpt_store_key . '_ra_storeid', true);
                $ra_score = get_post_meta($post->ID, $cpt_store_key . '_ra_score', true);
                $programs = get_post_meta($post->ID, $cpt_store_key . '_affiliate', true);
                $programs = $programs ? $programs : null;

                $programsList = [];
                if ($programs) :
                    foreach ($programs as $program) :
                        $programsList[] = (new \Review\Model\AffiliateProgram())
                            ->setAdvertiserId($program['advertiser_id'])
                            ->setPublisherId($program['publisher_id'])
                            ->setComission($program['comission'])
                            ->setPlatform($program['platform']);
                    endforeach;
                endif;

                $stores[$post->ID] = [
                    "id" => $post->ID,
                    "key_cpt" => $cpt_store_key,
                    "type" => $type,
                    "image" => $post_image,
                    "description" => $description,
                    "title" => get_the_title($post->ID),
                    "content" => get_the_content($post->ID),
                    "link" => get_permalink($post->ID),
                    "logo" => $logo,
                    "logosvg" => $logosvg,
                    "domain" => $domain,
                    "url" => $url,
                    "email" => $email,
                    "ra_shortname" => $ra_shortname,
                    "ra_storeid" => $ra_storeid,
                    "ra_score" => $ra_score,
                    "affiliatePrograms" => $programsList,
                ];

            }
            wp_reset_postdata();
        }
        return $stores;
    }
}
