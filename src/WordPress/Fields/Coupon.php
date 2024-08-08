<?php

namespace Review\WordPress\Fields;

use Review\Model\Field;
use Review\WordPress\Fields;

final class Coupon extends Fields
{
    public static function fields()
    {
        $key = \Review\WordPress\CustomPostType\Coupon::getKey();

        $stores = array_map(function (\Review\Model\Store $store) {
            return [
                'id' => $store->getId(),
                'title' => $store->getTitle()
            ];
        }, (new \Review\Repository\Store())->getAll());

        
        usort($stores, function ($a, $b) {
            return $a['title'] <=> $b['title'];
        });

        $programs = array_map(function (\Review\Model\ProgramPlatform $type) {
            return [
                'id' => $type->getId(),
                'title' => $type->getName()
            ];
        }, (new \Review\Affiliate\Programs())->getAll());


        $isActive = [
            ['id' => 1, 'title' => 'Sim'],
            ['id' => 0, 'title' => 'Não']
        ];


        $fields = [
            new Field("{$key}_isActive", "select", "Está ativo", "", null, "DETAIL", $isActive),
            new Field("{$key}_store", "select", "Loja", "", null, "TYPE", $stores),
            new Field("{$key}_affiliatePlatform", "select", "Plataforma", "", null, "TYPE", $programs),
            new Field("{$key}_percentage", "number", "Desconto", "%"),

            new Field("{$key}_promotionId", "text", "ID Promoção", ""),
            new Field("{$key}_code", "text", "Código Cupom", ""),

            new Field("{$key}_iniDate", "date", "Inicio Validade", "AAAA-MM-DD H:i:s"),
            new Field("{$key}_endDate", "date", "Fim Validade", "AAAA-MM-DD H:i:s"),
            new Field("{$key}_addDate", "date", "Disponibilizado", "AAAA-MM-DD H:i:s"),

            new Field("{$key}_terms", "textarea", "Termos de Uso", "", null, "DETAIL", []),

            new Field("{$key}_url", "url", "Url", ""),
        ];

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
