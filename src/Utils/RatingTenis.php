<?php
namespace Review\Utils;

final class RatingTenis
{
    private static function data()
    {
        return [
            ["id" => "conforto", "name" => "Conforto", "description" => "Nível de conforto proporcionado durante o uso."],
            ["id" => "durabilidade", "name" => "Durabilidade", "description" => "Resistência do tênis ao desgaste ao longo do tempo."],
            ["id" => "estabilidade", "name" => "Estabilidade", "description" => "Capacidade de oferecer suporte e prevenir torções."],
            ["id" => "peso", "name" => "Peso", "description" => "Leveza do tênis, influenciando na agilidade."],
            ["id" => "amortecimento", "name" => "Amortecimento", "description" => "Eficácia na absorção de impactos."],
            ["id" => "tracao", "name" => "Tração", "description" => "Aderência ao solo para evitar escorregões."],
            ["id" => "respirabilidade", "name" => "Respirabilidade", "description" => "Capacidade de manter os pés ventilados."],
            ["id" => "design", "name" => "Design", "description" => "Estilo e aparência do tênis."],
        ];
    }

    public static function getAll()
    {
        return self::data();
    }
    public static function getById($id)
    {
        $types = self::data();
        $ids = array_column($types, 'id');
        $index = array_search($id, $ids);

        return ($index !== false) ? $types[$index] : null;
    }
}
