<?php

namespace Review\WordPress\Elements;

use Review\Model\Field;

final class hidden
{
    public function get(Field $field) : string
    {
        $tr = <<<HTML
        <tr>
            <td>
                <input type="hidden" name="{$field->id}" id="{$field->id}" value="{$field->value}" class="regular-text"/>
            </td>
        </tr>
        HTML;
        return $tr;
    }
}
