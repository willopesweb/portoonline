<?php
function register_cpt_videos()
{
  $labels = array(
    'name' => _x('Vídeos', 'post type general name'),
    'singular_name' => _x('Vídeo', 'post type singular name'),
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
    'description' => 'Cadastre os vídeos exibidos na página inicial',
    'public' => true,
    'menu_position' => 13, // Abaixo de 'Posts'
    'menu_icon' => 'dashicons-video-alt3', // https://developer.wordpress.org/resource/dashicons/
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'video', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicy_queryable' => true
  );

  register_post_type('video', $args);
}

add_action('init', 'register_cpt_videos');

function videos_shortcode()
{
  $args = array(
    'post_type' => 'video',
    'post_status' => 'publish',
    'posts_per_page' => -1
  );
  $query = new WP_Query($args);
  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $custom = array(
        'titulo' => get_the_title(),
        'video' => get_field("video")
      );

      echo '<section class="l-page-home__video">';
      echo '<h2 class="l-page-home__title">' . $custom['titulo'] . '</h2>';
      echo '<div class="l-page-home__video-content">';
      echo '<div class="l-page-home__video-iframe" data-video-id="' . $custom['video'] . '"></div>';
      echo '</div>';
      echo '</section>';
    }
  }
  wp_reset_postdata();
}
