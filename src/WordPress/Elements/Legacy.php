<?php

namespace Review\WordPress\Elements;

use Review\Model\Field;

final class Legacy
{
    public function get(Field $field) : string
    {
        $values = is_serialized($field->value) ? unserialize($field->value) : null;
        $valuesHtml = "";
        if ($values && is_array($values)) :
            foreach ($values as $key => $value) :
                $vl = print_r($value, true);
                $valuesHtml .= <<<HTML
            {$key} - {$vl} <br>
        HTML;
            endforeach;
        endif;

        $tr = <<<HTML
        <tr>
            <td>
                {$valuesHtml}
            </td>
        </tr>
        HTML;
        return $tr;
    }
}
