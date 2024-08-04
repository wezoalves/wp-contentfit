<?php

namespace Review\WordPress\Fields;

use Review\Model\Field;
use Review\WordPress\Fields;

final class Example extends Fields
{
    public static function fields()
    {
        $key = \Review\WordPress\CustomPostType\Example::getKey();

        $types = [
            ["id" => "ID_ONE_FIELD", "title" => "TITLE TYPE ONE"],
            ["id" => "ID_TWO_FIELD", "title" => "TITLE TYPE TWO"]
        ];

        $fields = [
            new Field("{$key}_type", "select", "Type Od Data", "", null, "TYPE", $types),
            new Field("{$key}_description", "textarea", "Description", "", null, "DETAIL", []),
            new Field("{$key}_name", "text", "Name Data", "", null, "DETAIL", []),
            new Field("{$key}_score", "range", "Score", "", null, "DETAIL", [0, 10, 0.1]),
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
