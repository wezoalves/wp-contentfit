<?php

namespace Review\WordPress\Elements;

use Review\Model\Field;

final class Customoffer implements \Review\Interface\ElementsInterface
{
    public function get(Field $field) : string
    {
        $values = is_serialized($field->value) ? unserialize($field->value) : null;
        $values = $values ? $values : [['store' => 0, 'price' => '', 'url' => '']];

        // fix old names to new
        // TODO remove after update all itens in prod
        $tmpValues = [];
        foreach ($values as $value) :
            if (isset($value['loja']) && isset($value['preco'])) :
                $tmpValues[] = [
                    'store' => $value['loja'],
                    'price' => $value['preco'],
                    'url' => $value['url']
                ];
            else :
                $tmpValues[] = $value;
            endif;
        endforeach;
        $values = $tmpValues;
        // End fix old names to new

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
        HTML;
        return $tr;
    }
}
