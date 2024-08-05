<?php

namespace Review\WordPress\CustomPostType;

use Review\WordPress\Fields\Store as StoreFields;

final class Store implements \Review\Interface\CustomPostTypeInterface
{
    private static string $key = "store";

    public static function getKey() : string
    {
        return self::$key;
    }
    public static function init() : void
    {
        $labels = array(
            'name' => 'Lojas',
            'singular_name' => 'Loja',
            'menu_name' => 'Lojas',
            'name_admin_bar' => 'Loja',
            'add_new' => 'Adicionar Nova',
            'add_new_item' => 'Adicionar Nova Loja',
            'new_item' => 'Nova Loja',
            'edit_item' => 'Editar Loja',
            'view_item' => 'Ver Loja',
            'all_items' => 'Todas as Lojas',
            'search_items' => 'Procurar Lojas',
            'not_found' => 'Nenhuma loja encontrada.',
            'not_found_in_trash' => 'Nenhuma loja encontrada na lixeira.'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-store',
            'supports' => array('title', 'editor', 'thumbnail'),
            'show_in_rest' => true
        );

        register_post_type('loja', $args);

        add_action('add_meta_boxes', [self::class, 'add_meta_boxes']);

        add_action('save_post', [StoreFields::class, 'saveMeta']);

    }
    public static function add_meta_boxes() : void
    {
        add_meta_box(
            self::$key . '_meta_box',
            'Detalhes da Loja',
            [StoreFields::class, 'showMetaBox'],
            'loja',
            'advanced',
            'default'
        );
    }
}

