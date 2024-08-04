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
        $key = \Review\WordPress\CustomPostType\Tenis::getKey();
        $post_image = get_the_post_thumbnail_url($post_id, 'full');
        $priceregular = get_post_meta($post_id, $key . '_priceregular', true);
        $brand = get_post_meta($post_id, $key . '_brand', true);
        $brandData = (new Store())->getById($brand);
        $description = get_post_meta($post_id, $key . '_description', true);
        $characteristics = get_post_meta($post_id, $key . '_characteristics', true);
        $benefits = get_post_meta($post_id, $key . '_benefits', true);
        $offers = get_post_meta($post_id, $key . '_offers', true) ?: [];
        $typeId = get_post_meta($post_id, $key . '_type', true);
        $type = TypeTenis::getById($typeId);



        // Classification Explained

        $classificationExplained = [];
        foreach ((RatingTenis::getAll()) as $typeScore) {
            $keyClassification = "{$key}_{$typeScore['id']}";
            $value = get_post_meta($post_id, $keyClassification, true);
            $value = $value ? $value : 0;
            $classificationExplained[$keyClassification] = [
                "id" => $keyClassification,
                "value" => $value,
                "description" => $typeScore['description'],
                "name" => $typeScore['name']
            ];
        }

        // Populate List Offers to Tenis
        $offersList = [];
        foreach ($offers as $offer) {

            if (isset($offer['preco']) && isset($offer['loja'])) :
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
            else :
                $discount = 0;
                if ($priceregular && isset($offer['price']) && $offer['price']) {
                    $descontoValor = $priceregular - $offer['price'];
                    $discount = ($descontoValor / $priceregular) * 100;
                    $discount = round($discount, 0, PHP_ROUND_HALF_UP);
                }

                $offersList[] = (new Offer())
                    ->setStore((new Store())->getById($offer['store']))
                    ->setStoreId($offer['store'])
                    ->setPrice($offer['price'])
                    ->setPriceFormated(number_format($offer['price'], 2, ',', '.'))
                    ->setUrl($offer['url'])
                    ->setUrlOffer((new AffiliateOffer($offer['url'], $offer['store'], $this->source))->getUrl())
                    ->setDiscount($discount);
            endif;


        }

        // Rules Offer
        $offerBest = (new BestOffer())->getBest($offersList);


        $tenis = (new TenisModel(
            $post_id,
            $key,
            $type,
            $post_image,
            [], // TODO create gallery with images product
            $description,
            get_the_excerpt($post->ID),
            [], // TODO create classification global per type [[users: 10],[brand: 8],[jedi's : 7.6], etc etc ...]
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
