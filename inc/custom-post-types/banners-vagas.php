<?php
function register_cpt_banners_vagas()
{
  $labels = array(
    'name' => _x('Banners Vagas', 'post type general name'),
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
    'description' => 'Cadastre os banners da página de vagas de emprego',
    'public' => true,
    'menu_position' => 10, // Abaixo de 'Mídia'
    'menu_icon' => 'dashicons-images-alt2', // https://developer.wordpress.org/resource/dashicons/
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'banner', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicy_queryable' => true
  );

  register_post_type('banners_vagas', $args);
}

add_action('init', 'register_cpt_banners_vagas');

function banners_vagas_shortcode()
{
  $args = array(
    'post_type' => 'banners_vagas',
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

add_shortcode('banners', 'banners_vagas_shortcode');