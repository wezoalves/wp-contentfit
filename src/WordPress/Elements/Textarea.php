<?php

namespace Review\WordPress\Elements;

use Review\Model\Field;

final class Textarea
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

            <textarea name="{$field->id}" id="{$field->id}" class="large-text" rows="5">{$field->value}</textarea>

                
                <!--fieldset style="background-color: #eeeeee;margin-bottom:15px; border: 1px solid red; padding:20px;">
                    <legend>Debug: {$field->name}</legend>
                    <textarea name="debug_{$field->id}" id="debug_{$field->id}">
                        {$field->value}
                    </textarea>
                </fieldset>
                <hr /-->
            </td>
        </tr>
        
        HTML;
        return $tr;
    }

}
