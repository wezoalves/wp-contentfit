<?php

namespace Review\WordPress\Fields;

use Review\Model\Field;
use Review\WordPress\Fields;

final class Foods extends Fields
{
    public static function fields()
    {
        $key = \Review\WordPress\CustomPostType\Foods::getKey();
        $fields = [
            new Field("{$key}_id", "number", "Nº Alimento Tabela <a target='_blank' href='https://www.nepa.unicamp.br/wp-content/uploads/sites/27/2023/10/Taco-4a-Edicao.xlsx'>TACO</a>","", null, "INFO"),
            new Field("{$key}_calcio", "number", "Cálcio", "(mg)", null, "MICRONUTRIENTES_MINERAIS"),
            new Field("{$key}_carboidrato", "number", "Carboidrato", "(g)", null, "MACRONUTRIENTES"),
            new Field("{$key}_cinzas", "number", "Cinzas", "(g)", null, "MICRONUTRIENTES_MINERAIS"),
            new Field("{$key}_cobre", "number", "Cobre", "(mg)", null, "MICRONUTRIENTES_MINERAIS"),
            new Field("{$key}_colesterol", "number", "Colesterol", "(mg)", null, "COMPONENTES_ADICIONAIS"),
            new Field("{$key}_calorias", "number", "Calorias Energia", "(kcal)", null, "COMPONENTES_ADICIONAIS"),
            new Field("{$key}_energia", "number", "Calorias Energia", "(kJ)", null, "COMPONENTES_ADICIONAIS"),
            new Field("{$key}_ferro", "number", "Ferro", "(mg)", null, "MICRONUTRIENTES_MINERAIS"),
            new Field("{$key}_fibraalimentar", "number", "Fibra Alimentar", "(g)", null, "COMPONENTES_ADICIONAIS"),
            new Field("{$key}_fosforo", "number", "Fósforo", "(mg)", null, "MICRONUTRIENTES_MINERAIS"),
            new Field("{$key}_lipideos", "number", "Lipídeos", "(g)", null, "MACRONUTRIENTES"),
            new Field("{$key}_magnesio", "number", "Magnésio", "(mg)", null, "MICRONUTRIENTES_MINERAIS"),
            new Field("{$key}_manganes", "number", "Manganês", "(mg)", null, "MICRONUTRIENTES_MINERAIS"),
            new Field("{$key}_niacina", "number", "Niacina", "(mg)", null, "MICRONUTRIENTES_VITAMINAS"),
            new Field("{$key}_piridoxina", "number", "Piridoxina", "(mg)", null, "MICRONUTRIENTES_VITAMINAS"),
            new Field("{$key}_potassio", "number", "Potássio", "(mg)", null, "MICRONUTRIENTES_MINERAIS"),
            new Field("{$key}_proteína", "number", "Proteína", "(g)", null, "MACRONUTRIENTES"),
            new Field("{$key}_rae", "number", "RAE", "(mcg)", null, "MICRONUTRIENTES_VITAMINAS"),
            new Field("{$key}_re", "number", "RE", "(mcg)", null, "MICRONUTRIENTES_VITAMINAS"),
            new Field("{$key}_retinol", "number", "Retinol", "(mcg)", null, "MICRONUTRIENTES_VITAMINAS"),
            new Field("{$key}_riboflavina", "number", "Riboflavina", "(mg)", null, "MICRONUTRIENTES_VITAMINAS"),
            new Field("{$key}_sodio", "number", "Sódio", "(mg)", null, "MICRONUTRIENTES_MINERAIS"),
            new Field("{$key}_tiamina", "number", "Tiamina", "(mg)", null, "MICRONUTRIENTES_VITAMINAS"),
            new Field("{$key}_umidade", "number", "Umidade", "(%)", null, "COMPONENTES_ADICIONAIS"),
            new Field("{$key}_vitaminac", "number", "Vitamina C", "(mg)", null, "MICRONUTRIENTES_VITAMINAS"),
            new Field("{$key}_zinco", "number", "Zinco", "(mg)", null, "MICRONUTRIENTES_MINERAIS"),
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
