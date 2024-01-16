<?php

function register_cpt_slides()
{
  $labels = array(
    'name' => _x('Slides', 'post type general name'),
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
    'description' => 'Cadastre os slides',
    'public' => true,
    'menu_position' => 5, // Abaixo de 'Posts'
    'menu_icon' => 'dashicons-cover-image', // https://developer.wordpress.org/resource/dashicons/
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'slide', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicy_queryable' => true
  );

  register_post_type('slide', $args);
}

add_action('init', 'register_cpt_slides');

function slides_shortcode()
{
  $args = array(
    'post_type' => 'slide',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'rand',
    'meta_key' => 'ativo',     // Adiciona a chave do campo personalizado
    'meta_value' => '0',           // Define o valor para buscar (true)
    'meta_compare' => '!=',
  );
  $query = new WP_Query($args);
  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $custom = array(
        'titulo' => get_the_title(),
        'imagem' => get_field("imagem"),
        'imagem_mobile' => get_field("imagem_mobile"),
        'link' => get_field("link")
      );

      echo theme_slides_template($custom);
    }
  }
  wp_reset_postdata();
}

add_shortcode('slides', 'slides_shortcode');

function register_cpt_banners()
{
  $labels = array(
    'name' => _x('Banners', 'post type general name'),
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
    'description' => 'Cadastre os banners',
    'public' => true,
    'menu_position' => 5, // Abaixo de 'Posts'
    'menu_icon' => 'dashicons-images-alt2', // https://developer.wordpress.org/resource/dashicons/
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'banner', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicy_queryable' => true
  );

  register_post_type('banners', $args);
}

add_action('init', 'register_cpt_banners');

function banners_shortcode($obituario = false, $eventos = false)
{
  $args = array(
    'post_type' => 'banners',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'meta_key' => 'ativo',     // Adiciona a chave do campo personalizado
    'meta_value' => '0',           // Define o valor para buscar (true)
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
        'obituario' => get_field("obituario"),
        'eventos' => get_field("eventos")
      );

      if ($obituario === true) {
        if ($custom["obituario"]) {
          echo banners_html($custom);
        }
      } else if ($eventos === true) {
        if ($custom["eventos"]) {
          echo banners_html($custom);
        }
      } else {
        if (!$custom["obituario"] && !$custom["eventos"]) {
          echo banners_html($custom);
        }
      }
    }
  }
  wp_reset_postdata();
}

add_shortcode('banners', 'banners_shortcode');

function banners_html($custom)
{
  $html = "";
  if ($custom["link"]) {
    $html .= '<a target="_blank" rel="nofollow" href="' . $custom['link'] . '" title="' . $custom['titulo'] . '" class="l-banner">';
  } else {
    $html .= '<article class="l-banner">';
    $html .= '<h3 class="screen-readers-only">' . $custom['titulo'] . '</h3>';
  }

  $html .= '<img loading="lazy" width="380" height="380" src="' . $custom['imagem'] . '" alt="' . $custom['titulo'] . '"/>';

  if ($custom["link"]) {
    $html .= '</a>';
  } else {
    $html .= '</article>';
  }
  return $html;
}

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
    'menu_position' => 5, // Abaixo de 'Posts'
    'menu_icon' => 'dashicons-images-alt2', // https://developer.wordpress.org/resource/dashicons/
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'banner', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicy_queryable' => true
  );

  register_post_type('banners_home', $args);
}

add_action('init', 'register_cpt_banners_home');

function register_cpt_banners_topo()
{
  $labels = array(
    'name' => _x('Banners Topo', 'post type general name'),
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
    'description' => 'Cadastre os banners do topo do site',
    'public' => true,
    'menu_position' => 5, // Abaixo de 'Posts'
    'menu_icon' => 'dashicons-images-alt2', // https://developer.wordpress.org/resource/dashicons/
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'banner', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicy_queryable' => true
  );

  register_post_type('banners_topo', $args);
}

add_action('init', 'register_cpt_banners_topo');

function register_cpt_banners_obituario()
{
  $labels = array(
    'name' => _x('Banners Obituário', 'post type general name'),
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
    'description' => 'Cadastre os banners da página do obituário',
    'public' => true,
    'menu_position' => 5, // Abaixo de 'Posts'
    'menu_icon' => 'dashicons-images-alt2', // https://developer.wordpress.org/resource/dashicons/
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'banner', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicy_queryable' => true
  );

  register_post_type('banners_obituario', $args);
}

add_action('init', 'register_cpt_banners_obituario');

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
    'menu_position' => 5, // Abaixo de 'Posts'
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
    'menu_position' => 5, // Abaixo de 'Posts'
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
    'meta_key' => 'ativo',     // Adiciona a chave do campo personalizado
    'meta_value' => '0',           // Define o valor para buscar (true)
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
        echo banners_html($custom);
      }

      $custom_date_string = $custom["exibir_ate"];
      $custom_date = DateTime::createFromFormat('d/m/Y', $custom_date_string);

      if ($custom_date && $custom_date >= new DateTime()) {
        echo banners_html($custom);
      }
    }
  }
  wp_reset_postdata();
}

add_shortcode('banners', 'banners_vagas_shortcode');


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
    'menu_position' => 5, // Abaixo de 'Posts'
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
    $i = 1;
    while ($query->have_posts()) {
      $query->the_post();
      $custom = array(
        'titulo' => get_the_title(),
        'video' => get_field("video")
      );

      echo '<section class="l-page-home__video">';
      echo '<h2 class="l-page-home__title">' . $custom['titulo'] . '</h2>';
      echo '<div class="l-page-home__video-content">';
      echo $custom['video'];
      echo '</div>';
      echo '</section>';
    }
  }
  wp_reset_postdata();
}
