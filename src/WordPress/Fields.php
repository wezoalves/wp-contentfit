<?php
namespace Review\WordPress;

use Review\WordPress\Elements\Select;

class Fields
{
    public static function show_meta_box($post, $fields = [])
    {
        wp_nonce_field($post->post_type . '_nonce', $post->post_type . '_nonce');
        $meta = get_post_meta($post->ID);
        $html = '<div class="inside"><table style="width: 100%;display: flex;flex-direction: row;">';
        foreach ($fields as $field) :

            $value = isset($meta[$field->id][0]) ? $meta[$field->id][0] : '';
            $field->setValue($value);
            $type = "\\Review\\WordPress\\Elements\\" . ucfirst($field->getType());
            $html .= (new $type())->get($field);

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

                if ($field->getId() != "customoffer") :
                    update_post_meta($post_id, $fieldId, $postValue);
                endif;

                if ($field->getId() == "customoffer") :

                    $offers = [];
                    if (isset($_POST[$field->getType()])) {
                        foreach ($_POST[$field->getType()] as $key => $value) {
                            if (! empty($value['store']) || ! empty($value['price']) || ! empty($value['url'])) {
                                $offers[] = [
                                    'store' => sanitize_text_field($value['store']),
                                    'price' => floatval($value['price']),
                                    'url' => esc_url_raw($value['url'])
                                ];
                            }
                        }
                    }
                    update_post_meta($post_id, $field->getType(), serialize($offers));
                endif;



                // // validate type number
                // if ($field->getType() == "number") :
                //     update_post_meta($post_id, $fieldId, floatval($postValue));
                // endif;

                // // validate type text
                // if ($field->getType() == "text") :
                //     update_post_meta($post_id, $fieldId, sanitize_text_field($postValue));
                // endif;
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
