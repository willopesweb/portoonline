<?php
//Banners exibidos entre o conteúdo da página inicial
function register_cpt_banners_home()
{
  $labels = array(
    'name' => _x('Banners Home', 'post type general name'),
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
    'description' => 'Cadastre os banners da página inicial',
    'public' => true,
    'menu_position' => 13, // Abaixo de 'Posts'
    'menu_icon' => 'dashicons-feedback', // https://developer.wordpress.org/resource/dashicons/
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'banner', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicy_queryable' => true
  );

  register_post_type('banners_home', $args);
}

add_action('init', 'register_cpt_banners_home');
