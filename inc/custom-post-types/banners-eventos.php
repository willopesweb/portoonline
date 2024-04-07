<?php
function register_cpt_banners_eventos()
{
  $labels = array(
    'name' => _x('Banners Eventos', 'post type general name'),
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
    'description' => 'Cadastre os banners da página de eventos',
    'public' => true,
    'menu_position' => 11, // Abaixo de 'Banners'
    'menu_icon' => 'dashicons-images-alt2', // https://developer.wordpress.org/resource/dashicons/
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'banner', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicy_queryable' => true
  );

  register_post_type('banners_eventos', $args);
}

add_action('init', 'register_cpt_banners_eventos');

function banners_eventos_shortcode()
{
  $args = array(
    'post_type' => 'banners_eventos',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'meta_key' => 'ativo',
    'meta_value' => '0',
    'meta_compare' => '!=',
  );

  $query = new WP_Query($args);
  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $custom = array(
        'titulo' => get_the_title(),
        'imagem' => get_field("imagem"),
        'link' => get_field("link"),
        'exibir_ate' => get_field("exibir_ate"),
      );

      if (!$custom["exibir_ate"]) {
        echo theme_banner_template($custom);
      }

      $custom_date_string = $custom["exibir_ate"];
      $custom_date = DateTime::createFromFormat('d/m/Y', $custom_date_string);

      if ($custom_date && $custom_date >= new DateTime()) {
        echo theme_banner_template($custom);
      }
    }
  }
  wp_reset_postdata();
}

add_shortcode('banners_eventos', 'banners_eventos_shortcode');
