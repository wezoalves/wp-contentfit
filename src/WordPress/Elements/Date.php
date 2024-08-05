<?php

namespace Review\WordPress\Elements;

use Review\Model\Field;

final class Date implements \Review\Interface\ElementsInterface
{
    public function get(Field $field) : string
    {
        $tr = <<<HTML
        <tr>
            <td>
                <label for="{$field->id}">{$field->name}</label>
            </td>
            <td>
                <input type="text" name="{$field->id}" id="{$field->id}" value="{$field->value}" class="regular-text" placeholder="{$field->placeholder}" maxlength="19"/>
            </td>
        </tr>
        <script>
            document.getElementById('{$field->id}').addEventListener('input', function(e) {
                let input = e.target;
                let value = input.value.replace(/\D/g, ''); 
                let formattedValue = '';

                let day = value.substring(0, 2);
                let month = value.substring(2, 4);
                let year = value.substring(4, 8);
                let hour = value.substring(8, 10);
                let minute = value.substring(10, 12);
                let second = value.substring(12, 14);
                
                if (day.length === 2) {
                    day = Math.min(parseInt(day, 10), 31).toString().padStart(2, '0');
                }
                if (day.length > 0) {
                    formattedValue += day;
                }
                if (month.length === 2) {
                    month = Math.min(parseInt(month, 10), 12).toString().padStart(2, '0');
                }
                if (month.length > 0) {
                    formattedValue += '/' + month;
                }
                if (year.length === 4) {
                    let currentYear = new Date().getFullYear();
                    let maxYear = currentYear + 5;
                    year = Math.min(parseInt(year, 10), maxYear).toString();
                }
                if (year.length > 0) {
                    formattedValue += '/' + year;
                }
                if (hour.length === 2) {
                    hour = Math.min(parseInt(hour, 10), 23).toString().padStart(2, '0'); 
                }
                if (hour.length > 0) {
                    formattedValue += ' ' + hour;
                }
                if (minute.length === 2) {
                    minute = Math.min(parseInt(minute, 10), 59).toString().padStart(2, '0');
                }
                if (minute.length > 0) {
                    formattedValue += ':' + minute;
                }
                if (second.length === 2) {
                    second = Math.min(parseInt(second, 10), 59).toString().padStart(2, '0');
                }
                if (second.length > 0) {
                    formattedValue += ':' + second;
                }

                input.value = formattedValue;
            });
        </script>
        HTML;
        return $tr;
    }
}
