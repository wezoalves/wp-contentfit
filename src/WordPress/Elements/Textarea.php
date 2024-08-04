<?php

namespace Review\WordPress\Elements;

use Review\Model\Field;

final class Textarea
{
    public function get(Field $field) : string
    {
        $tr = <<<HTML
        <tr>
            <td>
                <label for="{$field->id}">{$field->name} {$field->placeholder}</label>
            </td>
            <td>
                <textarea name="{$field->id}" id="{$field->id}" class="large-text" rows="5">{$field->value}</textarea>
            </td>
        </tr>
        HTML;
        return $tr;
    }
}
