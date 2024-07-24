<?php

namespace Review\Repository;

use Review\Utils\TypeTenis;
use Review\Utils\RatingTenis;
use Review\Repository\Store;
use Review\Domain\BestOffer;
use Review\Domain\AffiliateOffer;
use Review\Model\Tenis as TenisModel;
use Review\Model\Offer;

final class Tenis
{
    public string|null $source = null;

    public function __construct(string $source = null)
    {
        $this->source = $source;
    }

    public function getById($post_id) : TenisModel
    {
        $post = get_post($post_id);
        $cpt_tenis_key = 'tenis';
        $post_image = get_the_post_thumbnail_url($post_id, 'full');
        $priceregular = get_post_meta($post_id, $cpt_tenis_key . '_priceregular', true);
        $brand = get_post_meta($post_id, $cpt_tenis_key . '_brand', true);
        $brandData = (new Store())->getById($brand);
        $description = get_post_meta($post_id, $cpt_tenis_key . '_description', true);
        $classification = get_post_meta($post_id, $cpt_tenis_key . '_classification', true);
        $characteristics = get_post_meta($post_id, $cpt_tenis_key . '_characteristics', true);
        $benefits = get_post_meta($post_id, $cpt_tenis_key . '_benefits', true);
        $offers = get_post_meta($post_id, $cpt_tenis_key . '_offers', true) ?: [];
        $gallery = get_post_meta($post_id, $cpt_tenis_key . '_images', true);
        $typeId = get_post_meta($post_id, $cpt_tenis_key . '_type', true);
        $type = TypeTenis::getById($typeId);

        // Classification Explained
        $classificationExplained = [];
        foreach ($classification as $key => $value) {
            $rating = RatingTenis::getById($key);
            $classificationExplained[$key] = [
                "id" => $key,
                "value" => $value,
                "description" => $rating['description'],
                "name" => $rating['name']
            ];
        }

        if ($gallery) {
            $gallery = explode(",", $gallery);
        }

        if (! $gallery) {
            $gallery = [];
        }



        // Populate List Offers to Tenis
        $offersList = [];
        foreach ($offers as $offer) {
            $discount = 0;
            if ($priceregular && isset($offer['preco']) && $offer['preco']) {
                $descontoValor = $priceregular - $offer['preco'];
                $discount = ($descontoValor / $priceregular) * 100;
                $discount = round($discount, 0, PHP_ROUND_HALF_UP);
            }

            $offersList[] = (new Offer())
                ->setStore((new Store())->getById($offer['loja']))
                ->setStoreId($offer['loja'])
                ->setPrice($offer['preco'])
                ->setPriceFormated(number_format($offer['preco'], 2, ',', '.'))
                ->setUrl($offer['url'])
                ->setUrlOffer((new AffiliateOffer($offer['url'], $offer['loja'], $this->source))->getUrl())
                ->setDiscount($discount);
        }

        // Rules Offer
        $offerBest = (new BestOffer())->getBest($offersList);


        $tenis = (new TenisModel(
            $post_id,
            $cpt_tenis_key,
            $type,
            $post_image,
            $gallery,
            $description,
            get_the_excerpt($post->ID),
            $classification,
            $classificationExplained,
            $characteristics,
            $benefits,
            $priceregular ?? 0,
            $offerBest,
            $offersList,
            $brandData,
            get_the_title($post->ID),
            get_the_content($post->ID),
            get_permalink($post->ID)
        ));

        return $tenis;
    }

    public function setSource(string $source = null)
    {
        $this->source = $source;
    }
}
