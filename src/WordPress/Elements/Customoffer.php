<?php

namespace Review\WordPress\Elements;

use Review\Model\Field;

final class Customoffer
{
    public function get(Field $field) : string
    {
        $values = unserialize($field->value);
        $values = $values ? $values : [['store' => 0, 'price' => '', 'url' => '']];

        $tr = <<<HTML
        <tr>
            <td>
                <label for="{$field->id}">{$field->name} {$field->placeholder}</label>
            </td>
            <td>
                <fieldset class="fieldset">
                    <legend>Ofertas</legend>
                    <div class="ofertas-container">
        HTML;

        foreach ($values as $key => $value) {
            $items = "<option value='0'>Selecione</option>";
            foreach ($field->getOptions() as $option) {
                $option = (object) $option;
                $selected = $option->id == $value['store'] ? 'selected' : '';
                $items .= <<<HTML
                    <option value="{$option->id}" {$selected}>{$option->title}</option>
                HTML;
            }

            $tr .= <<<HTML
                <div class="oferta form-grid">
                    <select class="regular-text field-half" name="{$field->id}[{$key}][store]">                    
                        {$items}
                    </select>

                    <input type="number" class="regular-text field-half" 
                        name="{$field->id}[{$key}][price]" 
                        value="{$value['price']}" 
                        placeholder="Preço" />
                    
                    <br>
                    <input type="url" class="regular-text field-full" 
                        name="{$field->id}[{$key}][url]"
                        value="{$value['url']}" 
                        placeholder="URL" />
                    <br>

                    <button class="remove-oferta button">Remover</button>
                    <br>
                    <hr class="separator"/>
                </div>
            HTML;
        }

        $tr .= <<<HTML
                    </div>
                    <button class="add-oferta button">Adicionar Oferta</button>
                </fieldset>
                <fieldset style="background-color: #eeeeee;margin-bottom:15px; border: 1px solid red; padding:20px;">
                    <legend>Debug: {$field->name}</legend>
                    <textarea type="{$field->type}" name="debug_{$field->id}" id="debug_{$field->id}" rows="5" class="large-text" style="width: 100%;">{$field->value}</textarea>
                </fieldset>
                <hr />
            </td>
        </tr>
        HTML;

        $tr .= <<<HTML
        <script>
        jQuery(document).ready(function($) {
            // Function to add new offer
            $('.add-oferta').on('click', function(e) {
                e.preventDefault();
                var container = $(this).siblings('.ofertas-container');
                var lastOferta = container.find('.oferta').last();
                var clone = lastOferta.clone();

                // Update names and IDs for cloned fields
                var nextIndex = container.find('.oferta').length;
                clone.find('select').attr('name', '{$field->id}[' + nextIndex + '][store]').val('0');
                clone.find('input[name$="[price]"]').attr('name', '{$field->id}[' + nextIndex + '][price]').val('');
                clone.find('input[name$="[url]"]').attr('name', '{$field->id}[' + nextIndex + '][url]').val('');

                container.append(clone);
            });

            // Function to remove offer
            $(document).on('click', '.remove-oferta', function(e) {
                e.preventDefault();
                if ($('.oferta').length > 1) {
                    $(this).closest('.oferta').remove();
                }
            });
        });
        </script>
        <style>
            .form-grid { display: grid; justify-items: stretch; }
            .field-half { width: 100%; display: block; margin-bottom: 5px; }
            .field-full { width: 100%; display: block; margin-bottom: 5px; }
            .fieldset { padding: 15px; margin: 15px auto; border: 1px solid #ccc; }
            .separator { border: 1px solid #c9c9c9; border-style: solid; border-width: 1px 0 0 0; width: 100%; margin: 15px 0 30px 0; }
        </style>
        HTML;

        return $tr;
    }
}
