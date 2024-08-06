<?php

namespace Review\Repository;

use Review\Utils\TypeTenis;
use Review\Utils\RatingTenis;
use Review\Repository\Store;
use Review\Domain\BestOffer;
use Review\Domain\AffiliateOffer;
use Review\Model\Tenis as TenisModel;
use Review\Model\Offer;

final class Tenis implements \Review\Interface\RepositoryInterface
{
    public string|null $source = null;

    public function __construct(string $source = null)
    {
        $this->source = $source;
    }

    public function getById($post_id) : TenisModel
    {
        $post = get_post($post_id);
        if (!$post) {
            return null;
        }
        
        return $this->createModel($post);
    }

    public function setSource(string $source = null)
    {
        $this->source = $source;
    }

    private function getClassificationExplained($post_id, $key)
    {
        $classificationExplained = [];
        foreach (RatingTenis::getAll() as $typeScore) {
            $keyClassification = "{$key}_{$typeScore['id']}";
            $value = get_post_meta($post_id, $keyClassification, true) ?: 0;
            $classificationExplained[$keyClassification] = [
                "id" => $keyClassification,
                "value" => $value,
                "description" => $typeScore['description'],
                "name" => $typeScore['name']
            ];
        }
        return $classificationExplained;
    }

    private function populateOffersList($offers, $priceregular)
    {
        $offersList = [];
        foreach ($offers as $offer) {
            $discount = 0;
            if ($priceregular && isset($offer['preco']) && $offer['preco']) {
                $discount = round((($priceregular - $offer['preco']) / $priceregular) * 100, 0, PHP_ROUND_HALF_UP);
            } elseif ($priceregular && isset($offer['price']) && $offer['price']) {
                $discount = round((($priceregular - $offer['price']) / $priceregular) * 100, 0, PHP_ROUND_HALF_UP);
            }

            $store_id = $offer['loja'] ?? $offer['store'];
            $price = $offer['preco'] ?? $offer['price'];
            $offersList[] = (new Offer())
                ->setStore((new Store())->getById($store_id))
                ->setStoreId($store_id)
                ->setPrice($price)
                ->setPriceFormated(number_format($price, 2, ',', '.'))
                ->setUrl($offer['url'])
                ->setUrlOffer((new AffiliateOffer($offer['url'], $store_id, $this->source))->getUrl())
                ->setDiscount($discount);
        }
        return $offersList;
    }

    public function createModel($post) : TenisModel
    {
        $post_id = $post->ID;
        $key = \Review\WordPress\CustomPostType\Tenis::getKey();

        $post_image = get_the_post_thumbnail_url($post_id, 'full');
        $priceregular = get_post_meta($post_id, $key . '_priceregular', true);
        $brandData = (new Store())->getById(get_post_meta($post_id, $key . '_brand', true));
        $description = get_post_meta($post_id, $key . '_description', true);
        $characteristics = get_post_meta($post_id, $key . '_characteristics', true);
        $benefits = get_post_meta($post_id, $key . '_benefits', true);
        $offers = get_post_meta($post_id, $key . '_offers', true) ?: [];
        $type = TypeTenis::getById(get_post_meta($post_id, $key . '_type', true));

        $classificationExplained = $this->getClassificationExplained($post_id, $key);
        $offersList = $this->populateOffersList($offers, $priceregular);

        $offerBest = (new BestOffer())->getBest($offersList);

        return (new TenisModel(
            $post_id,
            $key,
            $type,
            $post_image,
            [], // TODO create gallery with images product
            $description,
            get_the_excerpt($post_id),
            [], // TODO create classification global per type [[users: 10],[brand: 8],[jedi's : 7.6], etc etc ...]
            $classificationExplained,
            $characteristics,
            $benefits,
            $priceregular ?? 0,
            $offerBest,
            $offersList,
            $brandData,
            get_the_title($post_id),
            get_the_content($post_id),
            get_permalink($post_id)
        ));
    }
}
