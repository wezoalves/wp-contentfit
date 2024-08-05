<?php

namespace Review\WordPress\Elements;

use Review\Model\Field;

final class Text implements \Review\Interface\ElementsInterface
{
    public function get(Field $field) : string
    {
        $tr = <<<HTML
        <tr>
            <td>
                <label for="{$field->id}">{$field->name} {$field->placeholder}</label>
            </td>
            <td>
                <input type="text" name="{$field->id}" id="{$field->id}" value="{$field->value}" class="regular-text" placeholder="{$field->placeholder}"/>
            </td>
        </tr>
        HTML;
        return $tr;
    }
}
