<?php
/*
Plugin Name: WezoAlves - Content Fit
Description: Plugin para adicionar o Custom Post Type Tênis com campos personalizados para reviews de tênis.
Version: 1.0
Author: Weslley Alves
*/

require __DIR__ . '/vendor/autoload.php';


include ('api/Food.php');


function getValueCPTReview($postId, $key, $type)
{
    return get_post_meta($postId, $type . '_' . $key, true);
}


function cpt_review_admin_css($hook)
{
    global $typenow;

    if ($typenow == 'loja' || $typenow == 'tenis') {
        wp_enqueue_style('custom_admin_css', plugin_dir_url(__FILE__) . '/assets/css/cpt.css');
    }
}
add_action('admin_enqueue_scripts', 'cpt_review_admin_css');

(new \Review\WordPress\Init());