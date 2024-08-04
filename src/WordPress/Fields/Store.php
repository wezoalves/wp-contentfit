<?php

namespace Review\WordPress\Fields;

use Review\Model\Field;
use Review\WordPress\Fields;
use Review\Model\ProgramPlatform;

final class Store extends Fields
{
    public static function fields()
    {


        $key = \Review\WordPress\CustomPostType\Store::getKey();

        $types = array_map(function ($type) {
            return [
                'id' => $type->getId(),
                'title' => $type->getName()
            ];
        }, (new \Review\Utils\TypeStore())->getAll());


        $programs = array_map(function (ProgramPlatform $type) {
            return [
                'id' => $type->getId(),
                'title' => $type->getName()
            ];
        }, (new \Review\Affiliate\Programs())->getAll());

        

        $fields = [


            new Field("{$key}_type", "select", "Tipo", "", null, "TYPE", $types),

            new Field("{$key}_description", "textarea", "Descrição da Loja", "", null, "DETAIL", []),

            new Field("{$key}_domain", "text", "Domínio", "", null, "DETAIL", []),
            new Field("{$key}_url", "text", "Url", "https://...", null, "DETAIL", []),
            new Field("{$key}_email", "text", "Email de Contato", "", null, "DETAIL", []),

            new Field("{$key}_ra_shortname", "text", "RA Store Shortname", "", null, "RA", []),
            new Field("{$key}_ra_storeid", "text", "RA Store ID", "", null, "RA", []),
            new Field("{$key}_ra_score", "range", "RA Store Score", "", null, "RA", [0, 10, 0.1]),


            new Field("{$key}_logosvg", "textarea", "Logo SVG", "", null, "DETAIL", []),

            new Field("{$key}_affiliate", "customprograms", "Programas de Afiliados", "", null, "DETAIL", $programs),

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
