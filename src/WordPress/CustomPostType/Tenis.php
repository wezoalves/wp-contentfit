<?php

namespace Review\WordPress\CustomPostType;

use Review\WordPress\Fields\Tenis as TenisFields;

final class Tenis
{
    private static string $key = "tenis";

    public static function getKey()
    {
        return self::$key;
    }
    public static function init()
    {
        $labels = array(
            'name' => 'Tênis',
            'singular_name' => 'Tênis',
            'menu_name' => 'Tênis',
            'name_admin_bar' => 'Tênis',
            'add_new' => 'Adicionar Novo',
            'add_new_item' => 'Adicionar Novo Tênis',
            'new_item' => 'Novo Tênis',
            'edit_item' => 'Editar Tênis',
            'view_item' => 'Ver Tênis',
            'all_items' => 'Todos os Tênis',
            'search_items' => 'Procurar Tênis',
            'not_found' => 'Nenhum tênis encontrado.',
            'not_found_in_trash' => 'Nenhum tênis encontrado na lixeira.'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-admin-post',
            'supports' => array('title', 'editor', 'thumbnail'),
            'show_in_rest' => true
        );

        register_post_type(self::$key, $args);

        add_action('add_meta_boxes', [self::class, 'add_meta_boxes']);

        add_action('save_post', [TenisFields::class, 'saveMeta']);

    }
    public static function add_meta_boxes()
    {
        add_meta_box(
            self::$key . '_meta_box',
            'Tabela de Composição',
            [TenisFields::class, 'showMetaBox'],
            self::$key,
            'advanced',
            'default'
        );
    }
}

