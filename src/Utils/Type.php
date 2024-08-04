<?php

namespace Review\Utils;

use Review\Model\SimpleType;

class Type
{
    public static array $types = [];
    private static function data()
    {
        return self::$types;
    }
    public static function getAll()
    {
        return self::data();
    }

    public static function getById($id) : ?SimpleType
    {
        $types = self::data();
        foreach ($types as $type) {
            if ($type->getId() === $id) {
                return $type;
            }
        }
        return null;
    }

}
