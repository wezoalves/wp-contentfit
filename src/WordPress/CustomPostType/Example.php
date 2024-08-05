<?php

namespace Review\WordPress\CustomPostType;

use Review\WordPress\Fields\Example as ExampleFields;

final class Example implements \Review\Interface\CustomPostTypeInterface
{
    private static string $key = "key_custom_post_type";
    private static string $slug = "slug_custom_post_type";

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
            'name' => '{Name Plural}',
            'singular_name' => '{Name Singular}',
            'menu_name' => '{Name Plural}',
            'name_admin_bar' => '{Name Singular}',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New {Name Singular}',
            'new_item' => 'New {Name Singular}',
            'edit_item' => 'Edit {Name Singular}',
            'view_item' => 'View {Name Singular}',
            'all_items' => 'All {Name Plural}',
            'search_items' => 'Search {Name Plural}',
            'not_found' => 'Not found {Name Singular}',
            'not_found_in_trash' => 'Not found {Name Singular} in trash.'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-carrot', // https://developer.wordpress.org/resource/dashicons/#hidden
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'show_in_rest' => true
        );

        register_post_type(self::$key, $args);

        add_action('add_meta_boxes', [self::class, 'add_meta_boxes']);
        add_action('save_post', [ExampleFields::class, 'saveMeta']);
        add_action('rest_api_init', [new \Review\Api\Food(), 'RestFoodApiInit']);
    }

    public static function add_meta_boxes() : void
    {
        add_meta_box(
            self::$key . '_meta_box',
            '{Name Box In Admin}',
            [ExampleFields::class, 'showMetaBox'],
            self::$key,
            'advanced',
            'default'
        );
    }
}