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

                let year = value.substring(0, 4);
                let month = value.substring(4, 6);
                let day = value.substring(6, 8);
                let hour = value.substring(8, 10);
                let minute = value.substring(10, 12);
                let second = value.substring(12, 14);

                if (year.length === 4) {
                    formattedValue += year;
                }
                if (month.length === 2) {
                    month = Math.min(parseInt(month, 10), 12).toString().padStart(2, '0');
                }
                if (month.length > 0) {
                    formattedValue += '-' + month;
                }
                if (day.length === 2) {
                    day = Math.min(parseInt(day, 10), 31).toString().padStart(2, '0');
                }
                if (day.length > 0) {
                    formattedValue += '-' + day;
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

                clearTimeout(input._formatTimeout);

                input._formatTimeout = setTimeout(function() {
                    input.value = formattedValue;
                }, 500);
            });
        </script>

        HTML;
        return $tr;
    }
}
