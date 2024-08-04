<?php

namespace Review\WordPress\Elements;

use Review\Model\Field;

final class Range
{

    public function get(Field $field) : string
    {

        // make options
        $options = $field->getOptions();
        $min = $options[0] ?? 0;
        $max = $options[1] ?? 10;
        $step = isset($options[2]) ? ('step="' . $options[2] . '"') : "";

        // make row table
        $tr = <<<HTML
        <tr>
            <td>
                <label for="{$field->id}">{$field->name} {$field->placeholder}</label>
            </td>
            <td>
                <p>Nota <b>{$field->name}</b>: <output id="{$field->id}_score"></output></p>

                <input type="range" min="{$min}" max="{$max}" {$step} name="{$field->id}" id="{$field->id}" value="{$field->value}" class="regular-text" placeholder="{$field->placeholder}"/>
                
                <script>
                    {$field->id}_score.textContent = {$field->id}.value;
                    {$field->id}.addEventListener("input", (event) => {
                        {$field->id}_score.textContent = event.target.value;
                    });
                </script>
                
            </td>
        </tr>
        
        HTML;
        return $tr;
    }

}
