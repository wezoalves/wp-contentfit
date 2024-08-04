<?php

namespace Review\WordPress\Elements;

use Review\Model\Field;

final class Customprograms
{
    public function get(Field $field) : string
    {
        $values = is_serialized($field->value) ? unserialize($field->value) : null;
        $values = $values ? $values : [['platform' => 0, 'advertiser_id' => '', 'publisher_id' => '', 'comission' => '']];

        $tr = <<<HTML
        <tr>
            <td>
                <label for="{$field->id}">{$field->name} {$field->placeholder}</label>
            </td>
            <td>
                <fieldset class="fieldset">
                    <legend>Programas</legend>
                    <div class="program-container">
        HTML;

        foreach ($values as $key => $value) {
            $items = "<option value='0'>Selecione</option>";
            foreach ($field->getOptions() as $option) {
                $option = (object) $option;
                $selected = $option->id == $value['platform'] ? 'selected' : '';
                $items .= <<<HTML
                    <option value="{$option->id}" {$selected}>{$option->title}</option>
                HTML;
            }

            $tr .= <<<HTML
                <div class="program form-grid">
                    <select class="regular-text field-half" name="{$field->id}[{$key}][platform]">                    
                        {$items}
                    </select>
                    
                    <label>Anunciante</label>
                    <input type="text" class="regular-text field-half" 
                        name="{$field->id}[{$key}][advertiser_id]" 
                        value="{$value['advertiser_id']}" 
                        placeholder="Anunciante" />
                    
                    
                    <label>Afiliado</label>
                    <input type="text" class="regular-text field-half" 
                        name="{$field->id}[{$key}][publisher_id]" 
                        value="{$value['publisher_id']}" 
                        placeholder="Afiliado" />
                    
                    
                    <label>Comissão</label>
                    <input type="number" class="regular-text field-full" 
                        name="{$field->id}[{$key}][comission]"
                        value="{$value['comission']}" 
                        placeholder="Comissão" />
                    

                    <button class="remove-program button">Remover</button>
                    <br>
                    <hr class="separator"/>
                </div>
            HTML;
        }

        $tr .= <<<HTML
                    </div>
                    <button class="add-program button">Adicionar Programa</button>
                </fieldset>
            </td>
        </tr>
        HTML;

        $tr .= <<<HTML
        <script>
        jQuery(document).ready(function($) {
            // Function to add new program
            $('.add-program').on('click', function(e) {
                e.preventDefault();
                var container = $(this).siblings('.program-container');
                var lastItem = container.find('.program').last();
                var clone = lastItem.clone();

                // Update names and IDs for cloned fields
                var nextIndex = container.find('.program').length;
                clone.find('select').attr('name', '{$field->id}[' + nextIndex + '][platform]').val('0');
                clone.find('input[name$="[advertiser_id]"]').attr('name', '{$field->id}[' + nextIndex + '][advertiser_id]').val('');
                clone.find('input[name$="[publisher_id]"]').attr('name', '{$field->id}[' + nextIndex + '][publisher_id]').val('');
                clone.find('input[name$="[comission]"]').attr('name', '{$field->id}[' + nextIndex + '][comission]').val('');

                container.append(clone);
            });

            // Function to remove program
            $(document).on('click', '.remove-program', function(e) {
                e.preventDefault();
                if ($('.program').length > 1) {
                    $(this).closest('.program').remove();
                }
            });
        });
        </script>
        HTML;
        return $tr;
    }
}
