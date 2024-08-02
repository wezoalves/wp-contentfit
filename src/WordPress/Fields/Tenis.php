<?php

namespace Review\WordPress\Fields;

use Review\Model\Field;
use Review\WordPress\Fields;

final class Tenis extends Fields
{
    public static function fields()
    {


        $key = \Review\WordPress\CustomPostType\Tenis::getKey();

        $brands = array_map(function ($brand) {
            return [
                'id' => $brand['id'],
                'title' => $brand['title']
            ];
        }, (new \Review\Repository\Store())->getAll());

        $stores = array_map(function ($brand) {
            return [
                'id' => $brand['id'],
                'title' => $brand['title']
            ];
        }, (new \Review\Repository\Store())->getAll());

        $types = array_map(function ($type) {
            return [
                'id' => $type->getId(),
                'title' => $type->getName()
            ];
        }, \Review\Utils\TypeTenis::getAll());


        $fields = [

            new Field("{$key}_brand", "select", "Marca", "", null, "TYPE", $brands),
            new Field("{$key}_type", "select", "Tipo", "", null, "TYPE", $types),

            new Field("{$key}_priceregular", "number", "Preço Regular", "", null, "PRICE"),

            new Field("{$key}_images", "text", "Imagens", "", null, "MEDIA"),

            new Field("{$key}_description", "textarea", "Descrição", "", null, "DETAIL"),
            new Field("{$key}_benefits", "textarea", "Benefícios", "", null, "DETAIL"),
            new Field("{$key}_characteristics", "textarea", "Características Técnicas", "", null, "DETAIL"),

            new Field("{$key}_offers", "customoffer", "Ofertas", "", null, "OFFER", $stores),

            new Field("{$key}_classification", "hidden", "Classificação Global", "", null, "DETAIL"),

        ];

        foreach ((\Review\Utils\RatingTenis::getAll()) as $typeScore) :
            $typeScore = (object) $typeScore;
            $fields[] = new Field("{$key}_{$typeScore->id}", "range", $typeScore->name, "", null, "DETAIL");
        endforeach;

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
