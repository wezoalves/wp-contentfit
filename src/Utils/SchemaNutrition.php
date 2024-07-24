<?php

namespace Review\Utils;

use Review\Model\ObjectType as Type;

final class SchemaNutrition
{
    private static function data()
    {
        return [
            new Type("calcio", "calciumContent"),
            new Type("carboidrato", "carbohydrateContent"),
            new Type("cinzas", "cinzas"),
            new Type("cobre", "copperContent"),
            new Type("colesterol", "cholesterolContent"),
            new Type("calorias", "calories"),
            new Type("energia", "energyContent"),
            new Type("ferro", "ironContent"),
            new Type("fibraalimentar", "fiberContent"),
            new Type("fosforo", "phosphorusContent"),
            new Type("lipideos", "fatContent"),
            new Type("magnesio", "magnesiumContent"),
            new Type("manganes", "manganeseContent"),
            new Type("niacina", "niacinContent"),
            new Type("piridoxina", "vitaminB6Content"),
            new Type("potassio", "potassiumContent"),
            new Type("proteína", "proteinContent"),
            new Type("rae", "rae"),
            new Type("re", "re"),
            new Type("retinol", "vitaminAContent"),
            new Type("riboflavina", "riboflavinContent"),
            new Type("sodio", "sodiumContent"),
            new Type("tiamina", "thiaminContent"),
            new Type("umidade", "umidade"),
            new Type("vitaminac", "vitaminCContent"),
            new Type("zinco", "zincContent"),
        ];
    }

    public static function getAll()
    {
        return self::data();
    }

    public static function getById($id) : ?Type
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
