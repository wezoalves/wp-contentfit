<?php
namespace Review\Utils;

use Review\Model\TenisType as Type;

final class TypeTenis
{
    private static function data()
    {
        return [
            new Type("PERFORMANCE_RUNNING", "Performance - Corrida (Running)"),
            new Type("PERFORMANCE_TRAINING", "Performance - Treino (Training)"),
            new Type("PERFORMANCE_BASKETBALL", "Performance - Basquete"),
            new Type("PERFORMANCE_FOOTBALL", "Performance - Futebol (Society e Futsal)"),
            new Type("PERFORMANCE_TENNIS_SQUASH", "Performance - Tennis e Squash"),
            new Type("CASUAL_LIFESTYLE", "Casual - Estilo de Vida (Lifestyle)"),
            new Type("CASUAL_SKATE", "Casual - Skate"),
            new Type("OUTDOOR_TRAIL", "Outdoor - Trilha (Trail)"),
            new Type("OUTDOOR_HIKING", "Outdoor - Caminhada (Hiking)"),
            new Type("SPECIAL_MINIMALIST", "Especiais - Minimalistas"),
            new Type("SPECIAL_SPORTS_SPECIFIC", "Especiais - Para Esportes Específicos"),
            new Type("KIDS", "Infantis"),
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
