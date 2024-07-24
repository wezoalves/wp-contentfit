<?php

$cpt_store_key = 'store';

// Salva os dados dos Metaboxes
function cpt_lojas_save_details($post_id)
{

    global $cpt_store_key;

    if (! isset($_POST['cpt_lojas_details_nonce']) || ! wp_verify_nonce($_POST['cpt_lojas_details_nonce'], 'cpt_lojas_save_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    $type = sanitize_text_field($_POST[$cpt_store_key . '_type']);
    $logo = sanitize_text_field($_POST[$cpt_store_key . '_logo']);
    $logosvg = $_POST[$cpt_store_key . '_logosvg'];
    $description = sanitize_textarea_field($_POST[$cpt_store_key . '_description']);
    $domain = sanitize_text_field($_POST[$cpt_store_key . '_domain']);
    $url = esc_url_raw($_POST[$cpt_store_key . '_url']);
    $email = sanitize_email($_POST[$cpt_store_key . '_email']);
    $ra_shortname = sanitize_text_field($_POST[$cpt_store_key . '_ra_shortname']);
    $ra_storeid = sanitize_text_field($_POST[$cpt_store_key . '_ra_storeid']);
    $ra_score = sanitize_text_field($_POST[$cpt_store_key . '_ra_score']);
    $programas = isset($_POST[$cpt_store_key . '_affiliate']) ? array_map(function ($programa) {
        return array(
            'platform' => sanitize_text_field($programa['platform']),
            'advertiser_id' => sanitize_text_field($programa['advertiser_id']),
            'publisher_id' => sanitize_text_field($programa['publisher_id']),
            'comission' => intval($programa['comission']),
        );
    }, $_POST[$cpt_store_key . '_affiliate']) : null;

    update_post_meta($post_id, $cpt_store_key . '_type', $type);
    update_post_meta($post_id, $cpt_store_key . '_logo', $logo);
    update_post_meta($post_id, $cpt_store_key . '_logosvg', $logosvg);
    update_post_meta($post_id, $cpt_store_key . '_description', $description);
    update_post_meta($post_id, $cpt_store_key . '_domain', $domain);
    update_post_meta($post_id, $cpt_store_key . '_url', $url);
    update_post_meta($post_id, $cpt_store_key . '_email', $email);
    update_post_meta($post_id, $cpt_store_key . '_affiliate', $programas);
    update_post_meta($post_id, $cpt_store_key . '_ra_shortname', $ra_shortname);
    update_post_meta($post_id, $cpt_store_key . '_ra_storeid', $ra_storeid);
    update_post_meta($post_id, $cpt_store_key . '_ra_score', $ra_score);

}
add_action('save_post', 'cpt_lojas_save_details');