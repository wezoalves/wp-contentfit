<?php

namespace Review\WordPress\Elements;

use Review\Model\Field;

final class hidden
{

    public function get(Field $field) : string
    {
        // make row table
        $tr = <<<HTML
        <tr>
            <td>
                <label for="{$field->id}">{$field->name} {$field->placeholder}</label>
            </td>
            <td>

                <input type="hidden" name="{$field->id}" id="{$field->id}" value="{$field->value}" class="regular-text"/>
                
                <fieldset style="background-color: #eeeeee;margin-bottom:15px; border: 1px solid red; padding:20px;">
                    <legend>Debug: {$field->name}</legend>
                    <textarea type="{$field->type}" name="debug_{$field->id}" id="debug_{$field->id}" rows="5" class="large-text" style="width: 100%;">{$field->value}</textarea>
                </fieldset>
                <hr />
            </td>
        </tr>
        
        HTML;
        return $tr;
    }

}
