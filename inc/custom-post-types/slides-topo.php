<?php

function register_cpt_slides_topo()
{
  $labels = array(
    'name' => _x('Slides Topo', 'post type general name'),
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
    'description' => 'Cadastre os slides do topo do site',
    'public' => true,
    'menu_position' => 6, // Abaixo de 'Slides Home'
    'menu_icon' => 'dashicons-slides', // https://developer.wordpress.org/resource/dashicons/
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'banner', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicy_queryable' => true
  );

  register_post_type('banners_topo', $args);
}

add_action('init', 'register_cpt_slides_topo');

function slides_topo_shortcode()
{
  $args = array(
    'post_type' => 'banners_topo',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'rand',
    'meta_key' => 'ativo',     // Adiciona a chave do campo personalizado
    'meta_value' => '0',           // Define o valor para buscar (true)
    'meta_compare' => '!=',
  );

  $query = new WP_Query($args);
  if ($query->have_posts()) {
    $carousel = ($query->post_count > 1) ?  true : false;
    echo '<div class="l-header__slide' . ($carousel ? ' c-carousel js-header-carousel splide' : '') . '">';
    if ($carousel) echo '<div class="splide__track"><ul class="splide__list">';
    while ($query->have_posts()) {
      $query->the_post();
      $custom = array(
        'titulo' => get_the_title(),
        'imagem' => get_field("imagem"),
        'imagem_mobile' => get_field("imagem_mobile"),
        'link' => get_field("link"),
      );
      if ($carousel) echo '<li class="splide__slide">';
      if ($custom["link"]) {
        echo '<a target="_blank" href="' . $custom['link'] . '" title="' . $custom['titulo'] . '" class="l-header__banner">';
      } else {
        echo '<div class="l-header__banner">';
      }

      echo '<picture>';
      if ($custom['imagem_mobile']) {
        echo '<source media="(max-width:600px)" srcset="' . $custom["imagem_mobile"] . '">';
      };
      echo '<img class="lazy" width="600" height="100" data-src="' . $custom['imagem'] . '" alt="' . $custom['titulo'] . '"/>';
      echo '</picture>';


      if ($custom["link"]) {
        echo '</a>';
      } else {
        echo '</div>';
      }
      if ($carousel) echo '</li>';
    }
    if ($carousel) echo '</ul></div>';
    echo '</div>';
  }
  wp_reset_postdata();
}

add_shortcode('slides_topo', 'slides_topo_shortcode');
