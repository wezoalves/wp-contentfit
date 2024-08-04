<?php

namespace Review\WordPress\Fields;

use Review\Model\Field;
use Review\WordPress\Fields;
use Review\Repository\Store;
use Review\Utils\TypeTenis;
use Review\Utils\RatingTenis;

final class Tenis extends Fields
{
    public static function fields()
    {
        $key = \Review\WordPress\CustomPostType\Tenis::getKey();

        
        $brands = array_map(function (\Review\Model\Store $brand) {
            return [
                'id' => $brand->getId(),
                'title' => $brand->getTitle()
            ];
        }, (new Store())->getByType(['BRAND']));

        
        $stores = array_map(function (\Review\Model\Store $store) {
            return [
                'id' => $store->getId(),
                'title' => $store->getTitle()
            ];
        }, (new Store())->getByType(['BRAND','MULTIBRAND']));

        
        $types = array_map(function ($type) {
            return [
                'id' => $type->getId(),
                'title' => $type->getName()
            ];
        }, TypeTenis::getAll());

        
        $fields = [
            new Field("{$key}_brand", "select", "Marca", "", null, "TYPE", $brands),
            new Field("{$key}_type", "select", "Tipo", "", null, "TYPE", $types),
            new Field("{$key}_priceregular", "number", "Preço Regular", "", null, "PRICE"),
            new Field("{$key}_description", "textarea", "Descrição", "", null, "DETAIL"),
            new Field("{$key}_benefits", "textarea", "Benefícios", "", null, "DETAIL"),
            new Field("{$key}_characteristics", "textarea", "Características Técnicas", "", null, "DETAIL"),
            new Field("{$key}_offers", "customoffer", "Ofertas", "", null, "OFFER", $stores),
            new Field("{$key}_classification", "legacy", "Classificação Global", "", null, "DETAIL"),
        ];

        
        foreach (RatingTenis::getAll() as $typeScore) {
            $typeScore = (object) $typeScore;
            $fields[] = new Field("{$key}_{$typeScore->id}", "range", $typeScore->name, "", null, "DETAIL");
        }

        return $fields;
    }

    public static function showMetaBox($post)
    {
        parent::show_meta_box($post, self::fields());
    }

    public static function saveMeta($post_id)
    {
        parent::save_meta($post_id, self::fields());
    }

    public static function registerCustomFields()
    {
        parent::register_custom_fields(self::fields());
    }
}
