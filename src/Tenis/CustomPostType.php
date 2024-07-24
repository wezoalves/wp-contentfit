<?php

use Review\Repository\Store;

function cpt_tenis_init()
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

    register_post_type('tenis', $args);
}
add_action('init', 'cpt_tenis_init');

// Adiciona uma nova coluna na listagem do CPT "tenis"
function add_tenis_custom_columns($columns)
{
    $columns['tenis_brand'] = __('Marca', 'text_domain');
    $columns['tenis_priceregular'] = __('Preço Regular', 'text_domain');
    $columns['thumbnail'] = __('Imagem', 'text_domain');

    return $columns;
}
add_filter('manage_tenis_posts_columns', 'add_tenis_custom_columns');

// Preenche os dados na nova coluna
function tenis_custom_column_content($column, $post_id)
{
    $stores = (new Store())->getAll();

    if ($column == 'tenis_brand') {
        // Exemplo: exibe o valor do campo meta "tenis_brand"
        $tenis_brand = get_post_meta($post_id, 'tenis_brand', true);
        echo $stores[$tenis_brand]['title'];
    }

    if ($column == 'thumbnail') {
        // Exibe a imagem de destaque
        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail($post_id, array(150, 200));
        } else {
            echo __('Sem imagem', 'text_domain');
        }
    }

    if ($column == 'tenis_priceregular') {
        // Exemplo: exibe o valor do campo meta "tenis_priceregular"
        $tenis_priceregular = get_post_meta($post_id, 'tenis_priceregular', true);
        echo "R$ " . number_format($tenis_priceregular, 2, ',', '.');
    }


}
add_action('manage_tenis_posts_custom_column', 'tenis_custom_column_content', 10, 2);

// Torna a nova coluna ordenável
function tenis_custom_column_sortable($columns)
{
    $columns['tenis_priceregular'] = 'tenis_priceregular';
    $columns['tenis_brand'] = 'tenis_brand';
    return $columns;
}
add_filter('manage_edit-tenis_sortable_columns', 'tenis_custom_column_sortable');

// Lógica de ordenação para a nova coluna
function tenis_custom_column_orderby($query)
{
    if (! is_admin())
        return;

    $orderby = $query->get('orderby');
    if ('tenis_priceregular' == $orderby) {
        $query->set('meta_key', 'tenis_priceregular');
        $query->set('orderby', 'meta_value');
    }
    if ('tenis_brand' == $orderby) {
        $query->set('meta_key', 'tenis_brand');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'tenis_custom_column_orderby');
