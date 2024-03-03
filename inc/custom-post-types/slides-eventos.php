<?php

function register_cpt_slides_eventos()
{
  $labels = array(
    'name' => _x('Slides Eventos', 'post type general name'),
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
    'description' => 'Cadastre os slides da página de eventos',
    'public' => true,
    'menu_position' => 9, // Abaixo de 'Slides Obituário'
    'menu_icon' => 'dashicons-slides', // https://developer.wordpress.org/resource/dashicons/
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'banner', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicy_queryable' => true
  );

  register_post_type('slides_eventos', $args);
}

add_action('init', 'register_cpt_slides_eventos');


function slides_eventos_shortcode()
{
  $args = array(
    'post_type' => 'slides_eventos',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'rand',
    'meta_key' => 'ativo',
    'meta_value' => '0',
    'meta_compare' => '!=',
  );

  theme_get_slides($args);
}

add_shortcode('slides_eventos', 'slides_eventos_shortcode');
