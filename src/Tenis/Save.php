<?php

$cpt_tenis_key = 'tenis';

function cpt_tenis_save_details($post_id)
{

    global $cpt_tenis_key;

    if (! isset($_POST['cpt_tenis_details_nonce']) || ! wp_verify_nonce($_POST['cpt_tenis_details_nonce'], 'cpt_tenis_save_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    $priceregular = sanitize_text_field($_POST[$cpt_tenis_key . '_priceregular']);
    $brand = sanitize_text_field($_POST[$cpt_tenis_key . '_brand']);
    $type = sanitize_text_field($_POST[$cpt_tenis_key . '_type']);
    $description = sanitize_textarea_field($_POST[$cpt_tenis_key . '_description']);
    $classification = array_map('sanitize_text_field', $_POST[$cpt_tenis_key . '_classification']);
    $characteristics = sanitize_textarea_field($_POST[$cpt_tenis_key . '_characteristics']);
    $benefits = sanitize_textarea_field($_POST[$cpt_tenis_key . '_benefits']);

    $offers = isset($_POST[$cpt_tenis_key . '_offers']) ? array_map(function ($oferta) {
        return array(
            'loja' => sanitize_text_field($oferta['loja']),
            'preco' => floatval($oferta['preco']),
            'url' => esc_url_raw($oferta['url']),
        );
    }, $_POST[$cpt_tenis_key . '_offers']) : null;

    $images = sanitize_text_field($_POST[$cpt_tenis_key . '_images']);

    update_post_meta($post_id, $cpt_tenis_key . '_priceregular', $priceregular);
    update_post_meta($post_id, $cpt_tenis_key . '_brand', $brand);
    update_post_meta($post_id, $cpt_tenis_key . '_type', $type);
    update_post_meta($post_id, $cpt_tenis_key . '_description', $description);
    update_post_meta($post_id, $cpt_tenis_key . '_classification', $classification);
    update_post_meta($post_id, $cpt_tenis_key . '_characteristics', $characteristics);
    update_post_meta($post_id, $cpt_tenis_key . '_benefits', $benefits);
    update_post_meta($post_id, $cpt_tenis_key . '_offers', $offers);
    update_post_meta($post_id, $cpt_tenis_key . '_images', $images);
}
add_action('save_post', 'cpt_tenis_save_details');