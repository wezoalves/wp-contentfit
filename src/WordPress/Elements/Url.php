<?php

namespace Review\WordPress\Elements;

use Review\Model\Field;

final class Url implements \Review\Interface\ElementsInterface
{
    public function get(Field $field) : string
    {
        $tr = <<<HTML
        <tr>
            <td>
                <label for="{$field->id}">{$field->name}</label>
            </td>
            <td>
                <input type="url" name="{$field->id}" id="{$field->id}" value="{$field->value}" class="regular-text" placeholder="{$field->placeholder}"/>
            </td>
        </tr>
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                const urlInput = document.getElementById('{$field->id}');

                urlInput.addEventListener('blur', (event) => {
                    let input = urlInput.value.trim();
                    
                    if (input && !input.match(/^https?:\/\//)) {
                        urlInput.value = 'https://' + input;
                    }
                });

                urlInput.addEventListener('paste', (event) => {
                    setTimeout(() => {
                        let input = urlInput.value.trim();

                        if (input && !input.match(/^https?:\/\//)) {
                            urlInput.value = 'https://' + input;
                        }
                    }, 100);
                });
            });
        </script>
        HTML;
        return $tr;
    }
}
