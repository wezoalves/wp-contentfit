<?php
namespace Review\WordPress;


class Fields
{
    public static function show_meta_box($post, $fields = [])
    {
        wp_nonce_field($post->post_type . '_nonce', $post->post_type . '_nonce');
        $meta = get_post_meta($post->ID);
        $html = '<div class="inside"><table style="width:100%;display: flex;justify-content: space-evenly;">';
        foreach ($fields as $field) :
            $fieldId = $field->id;
            $value = isset($meta[$fieldId][0]) ? $meta[$fieldId][0] : '';
            $html .= <<<HTML
            <tr>
                <td style="width: 70%; margin-right:10px;">
                    <label for="{$fieldId}">{$field->name}</label>
                </td>
                <td>
                    <input type="{$field->type}" name="{$fieldId}" id="{$fieldId}" value="{$value}" class="components-text-control__input editor-text-editor" placeholder="{$field->placeholder}" />
                </td>
            </tr>
            HTML;
        endforeach;
        echo $html . "</table></div>";
    }

    public static function save_meta($post_id, $fields = [])
    {
        $post = get_post($post_id);
        $nonce = $post->post_type . '_nonce';

        if (! isset($_POST[$nonce]) || ! wp_verify_nonce($_POST[$nonce], $nonce)) {
            return $post_id;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        if (! current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        foreach ($fields as $field) {
            $fieldId = $field->getId();
            if (isset($_POST[$fieldId])) {
                $postValue = $_POST[$fieldId];

                // validate type number
                if ($field->getType() == "number") :
                    update_post_meta($post_id, $fieldId, floatval($postValue));
                endif;

                // validate type text
                if ($field->getType() == "text") :
                    update_post_meta($post_id, $fieldId, sanitize_text_field($postValue));
                endif;
            }
        }
    }

    public static function register_custom_fields($post, $fields = [])
    {
        foreach ($fields as $field) :
            register_meta(
                $post->post_type,
                $field->getId(),
                [
                    'single' => true,
                    'type' => $field->getType(),
                    'show_in_rest' => true,
                ]
            );
        endforeach;
    }
}
