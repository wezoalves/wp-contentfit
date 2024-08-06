<?php

namespace Review\WordPress\CustomPostType;

use Review\WordPress\Fields\Coupon as CouponFields;
use ReviewApi\Coupon as CouponApi;

final class Coupon implements \Review\Interface\CustomPostTypeInterface
{
    private static string $key = "coupon";
    private static string $slug = "cupom";

    public static function getSlug() : string
    {
        return self::$slug;
    }
    public static function getKey() : string
    {
        return self::$key;
    }
    public static function init() : void
    {
        $labels = array(
            'name' => 'Cupons',
            'singular_name' => 'Cupom',
            'menu_name' => 'Cupons',
            'name_admin_bar' => 'Cupom',
            'add_new' => 'Adicionar Novo',
            'add_new_item' => 'Adicionar Novo Cupom',
            'new_item' => 'Novo Cupom',
            'edit_item' => 'Editar Cupom',
            'view_item' => 'Ver Cupom',
            'all_items' => 'Todos Cupons',
            'search_items' => 'Buscar Cupons',
            'not_found' => 'Cupom não encontrado',
            'not_found_in_trash' => 'Cupom não encontrado na lixeira.'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-tag',
            'supports' => array('title', 'editor', 'custom-fields'),
            'show_in_rest' => true
        );

        register_post_type(self::getSlug(), $args);

        add_action('add_meta_boxes', [self::class, 'add_meta_boxes']);
        add_action('save_post', [CouponFields::class, 'saveMeta']);
        add_action('rest_api_init', [new CouponApi(), 'RestApiInit']);
    }

    public static function add_meta_boxes() : void
    {
        add_meta_box(
            self::$key . '_meta_box',
            'Detalhes do Cupom',
            [CouponFields::class, 'showMetaBox'],
            self::getSlug(),
            'advanced',
            'default'
        );
    }
}