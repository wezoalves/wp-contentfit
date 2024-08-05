<?php

namespace Review\WordPress\Elements;

use Review\Model\Field;

final class Select implements \Review\Interface\ElementsInterface
{
    public function get(Field $field) : string
    {
        $items = "";
        foreach ($field->getOptions() as $option) :
            $option = (object) $option;
            $selected = $option->id == $field->value ? 'selected' : '';
            $items .= <<<HTML
                <option value="{$option->id}" {$selected}>{$option->title}</option>
            HTML;
        endforeach;

        $tr = <<<HTML
        <tr>
            <td>
                <label for="{$field->id}">{$field->name} {$field->placeholder}</label>
            </td>
            <td>
                <select name="{$field->id}" id="{$field->id}" class="regular-text">
                    {$items}
                </select>
            </td>
        </tr>
        HTML;
        return $tr;
    }
}
