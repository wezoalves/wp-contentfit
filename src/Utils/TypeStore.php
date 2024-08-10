<?php
namespace Review\Utils;

use Review\Model\SimpleType as Type;

final class TypeStore extends \Review\Utils\Type
{
    public function __construct()
    {
        self::$types = [
            new Type("BRAND", "Marca"),
            new Type("SHOES", "Calçados"),
            new Type("FOOD", "Alimento"),
            new Type("ACCESSORIES", "Acessórios"),
            new Type("SMARTPHONE", "Celular"),
            new Type("PHARMACY", "Farmácia"),
            new Type("BOOK", "Livro"),
            new Type("MULTIBRAND", "Loja Multi-marcas"),
            new Type("GLASSES", "Óculos"),
            new Type("WRISTWATCH", "Relógio"),
            new Type("SUPPLEMENT", "Suplemento"),
            new Type("CLOTHING", "Vestuário"),
        ];
    }
}
