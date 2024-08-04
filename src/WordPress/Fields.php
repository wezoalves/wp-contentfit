<?php
namespace Review\WordPress;

class Fields
{
    public static function show_meta_box($post, $fields = [])
    {
        wp_nonce_field($post->post_type . '_nonce', $post->post_type . '_nonce');
        $meta = get_post_meta($post->ID);
        $html = '<div class="inside"><table class="table-review">';
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

                // default
                if ($field->getId() != "customoffer") :
                    update_post_meta($post_id, $fieldId, $postValue);
                endif;

                // filter offers
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

                // filter programs
                if ($field->getId() == "customprograms") :
                    $programs = [];
                    if (isset($_POST[$field->getType()])) {
                        foreach ($_POST[$field->getType()] as $key => $value) {
                            if (! empty($value['advertiser_id']) || ! empty($value['comission']) ||
                                ! empty($value['platform']) || ! empty($value['publisher_id'])) {
                                $programs[] = [
                                    'platform' => sanitize_text_field($value['platform']),
                                    'comission' => floatval($value['comission']),
                                    'advertiser_id' => sanitize_text_field($value['advertiser_id']),
                                    'publisher_id' => sanitize_text_field($value['publisher_id']),
                                ];
                            }
                        }
                    }
                    update_post_meta($post_id, $field->getType(), serialize($programs));
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
