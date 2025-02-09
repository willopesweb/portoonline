<?php
function register_cpt_banners_saude()
{
  $labels = array(
    'name' => _x('Banners Saúde', 'post type general name'),
    'singular_name' => _x('Banner', 'post type singular name'),
    'add_new' => __('Adicionar Novo'),
    'add_new_item' => __('Adicionar Novo'),
    'edit_item' => __('Editar'),
    'new_item' => __('Novo'),
    'view_item' => __('Ver'),
    'search_items' => __('Pequisar'),
    'not_found' => __('Nenhum encontrado'),
    'not_found_in_trash' => __('Nenhum na Lixeira'),
    'parent_item_colon' => ''
  );

  $args = array(
    'labels' => $labels,
    'description' => 'Cadastre os banners da página de saúde',
    'public' => true,
    'menu_position' => 11, // Abaixo de 'Banners'
    'menu_icon' => 'dashicons-images-alt2', // https://developer.wordpress.org/resource/dashicons/
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'banner', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicy_queryable' => true
  );

  register_post_type('banners_saude', $args);
}

add_action('init', 'register_cpt_banners_saude');
