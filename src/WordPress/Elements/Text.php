<?php

namespace Review\WordPress\Elements;

use Review\Model\Field;

final class Text
{

    public function get(Field $field) : string
    {
        // make options
        $items = "";
        foreach ($field->getOptions() as $option) :
            $option = (object) $option;
            $selected = $option->id == $field->id ? 'selected' : '';
            $items .= <<<HTML
                <option value="{$option->id}" {$selected}>{$option->title}</option>
            HTML;
        endforeach;

        // make row table
        $tr = <<<HTML
        <tr>
            <td>
                <label for="{$field->id}">{$field->name} {$field->placeholder}</label>
            </td>
            <td>

                <input type="text" name="{$field->id}" id="{$field->id}" value="{$field->value}" class="regular-text" placeholder="{$field->placeholder}"/>
                
                <!--fieldset style="background-color: #eeeeee;margin-bottom:15px; border: 1px solid red; padding:20px;">
                    <legend>Debug: {$field->name}</legend>
                    <input type="{$field->type}" name="debug_{$field->id}" id="debug_{$field->id}" value="{$field->value}" class="components-text-control__input editor-text-editor" style="width: 100%;" placeholder="{$field->placeholder}"/>
                
                </fieldset>
                <hr /-->
            </td>
        </tr>
        
        HTML;
        return $tr;
    }

}
