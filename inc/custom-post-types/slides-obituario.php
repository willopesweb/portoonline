<?php

function register_cpt_slides_obituario()
{
  $labels = array(
    'name' => _x('Slides Obituário', 'post type general name'),
    'singular_name' => _x('Slide', 'post type singular name'),
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
    'description' => 'Cadastre os slides da página do obituário',
    'public' => true,
    'menu_position' => 7, // Abaixo de 'Slides Topo'
    'menu_icon' => 'dashicons-slides', // https://developer.wordpress.org/resource/dashicons/
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'banner', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicy_queryable' => true
  );

  register_post_type('slides_obituario', $args);
}

add_action('init', 'register_cpt_slides_obituario');

function slides_obituario_shortcode()
{
  $args = array(
    'post_type' => 'slides_obituario',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'rand',
    'meta_key' => 'ativo',
    'meta_value' => '0',
    'meta_compare' => '!=',
  );
  theme_get_slides($args);
}

add_shortcode('slides_obituario', 'slides_obituario_shortcode');
