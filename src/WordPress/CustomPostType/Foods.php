<?php

namespace Review\WordPress\CustomPostType;

use Review\WordPress\Fields\Foods as FoodsFields;

final class Foods
{
    private static string $key = "alimento";

    public static function getKey()
    {
        return self::$key;
    }
    public static function init()
    {
        $labels = array(
            'name' => 'Alimentos',
            'singular_name' => 'Alimento',
            'menu_name' => 'Alimentos',
            'name_admin_bar' => 'Alimento',
            'add_new' => 'Adicionar Novo',
            'add_new_item' => 'Adicionar Novo Alimento',
            'new_item' => 'Novo Alimento',
            'edit_item' => 'Editar Alimento',
            'view_item' => 'Ver Alimento',
            'all_items' => 'Todos os Alimentos',
            'search_items' => 'Procurar Alimentos',
            'not_found' => 'Nenhum alimento encontrado.',
            'not_found_in_trash' => 'Nenhum alimento encontrado na lixeira.'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-carrot',
            'supports' => array('title', 'editor', 'thumbnail','custom-fields'),
            'show_in_rest' => true
        );

        register_post_type(self::$key, $args);

        add_action('add_meta_boxes', [self::class, 'add_meta_boxes']);
        add_action('save_post', [FoodsFields::class, 'saveMeta']);
        //add_action('rest_api_init', [FoodsFields::class, 'registerCustomFields']);
        add_action('rest_api_init', [new \Review\Api\Food(), 'RestFoodApiInit']);
    }

    public static function add_meta_boxes()
    {
        add_meta_box(
            self::$key . '_meta_box', // ID
            'Tabela de Composição', // Título
            [FoodsFields::class, 'showMetaBox'], // Callback
            self::$key, // Post type
            'advanced', // Contexto
            'default' // Prioridade
        );
    }
}

add_action('init', ['\Review\WordPress\CustomPostType\Foods', 'init']);