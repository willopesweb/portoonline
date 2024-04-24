<?php

// Pesquisa personalizada
function custom_search_filter($query)
{
  if ($query->is_search && !is_admin()) {
    // Incluir páginas na busca
    $query->set('post_type', array('post', 'page'));

    // Verificar se a categoria foi selecionada
    $selected_category = isset($_GET['category_name']) ? sanitize_text_field($_GET['category_name']) : '';

    if ($selected_category) {
      // Se uma categoria foi selecionada, priorizar resultados nessa categoria
      $query->set('tax_query', array(
        array(
          'taxonomy' => 'category',
          'field' => 'slug',
          'terms' => $selected_category,
        ),
      ));
    }

    // Excluir IDs de páginas específicas dos resultados da pesquisa
    $exclude_page_ids = array(17195, 13, 131, 68); // IDs das páginas que você deseja excluir
    $query->set('post__not_in', $exclude_page_ids);

    // Priorizar resultados
    $query->set('orderby', array(
      'post_type' => 'ASC', // Páginas primeiro
      'tax_query' => array(  // Em seguida, posts da categoria "Produtos"
        array(
          'taxonomy' => 'category',
          'field' => 'slug',
          'terms' => 'produtos',
        ),
      ),
      'date' => 'DESC' // Ordenar pela data de publicação
    ));
  }
  return $query;
}
add_filter('pre_get_posts', 'custom_search_filter');

// Retorna redes sociais
function theme_social_networks()
{
  if (!isset($page_home_id)) {
    $page_home_id = 68;
  }

  $html = '';
  $html .= '<ul class="c-social">';

  if (function_exists('get_field') && get_field("whatsapp", $page_home_id)) {
    $html .= '<li><a href="https://api.whatsapp.com/send?phone=5519' . str_replace(' ', '', get_field("whatsapp", $page_home_id)) . '" class="icon-whatsapp" target="_blank"></a></li>';
  }
  if (function_exists('get_field') && get_field("instagram", $page_home_id)) {
    $html .= '<li><a class="icon-instagram" href="' . get_field("instagram", $page_home_id) . '" title="Nos Siga no Instagram" target="_blank" rel="_nofollow"></a></li>';
  }
  if (function_exists('get_field') && get_field("facebook", $page_home_id)) {
    $html .= '<li><a class="icon-facebook" href="' . get_field("facebook", $page_home_id) . '" title="Curta nossa página no Facebook" target="_blank" rel="_nofollow"></a></li>';
  }
  if (function_exists('get_field') && get_field("linkedin", $page_home_id)) {
    $html .= '<li><a class="icon-linkedin" href="' . get_field("linkedin", $page_home_id) . '" title="Curta nossa página no Linkedin" target="_blank" rel="_nofollow"></a></li>';
  }
  if (function_exists('get_field') && get_field("youtube", $page_home_id)) {
    $html .= '<li><a class="icon-youtube" href="' . get_field("youtube", $page_home_id) . '" title="Inscreva-se no nosso canal no Youtube" target="_blank" rel="_nofollow"></a></li>';
  }

  $html .= '</ul>';

  return $html;
}

function custom_posts_per_page($query)
{
  if ($query->is_archive() && $query->is_main_query()) {
    $query->set('posts_per_page', 30);
  }
}
add_action('pre_get_posts', 'custom_posts_per_page');

//Resume títulos dos posts adicionando os caracteres [...]
function resume_text($text, $limitCharacters = 60)
{
  if (mb_strlen($text) > $limitCharacters) {
    $text = str_replace(array("<strong>", "</strong>"), '', mb_substr($text, 0, $limitCharacters, 'UTF-8')) . ' [...]';
  }
  return $text;
}

//Retorna os posts conforme os argumentos fornecidos
function theme_get_posts($args)
{
  if (!$args) return;

  $query = new WP_Query($args);
  if ($query->have_posts()) {
    $i = 1;
    while ($query->have_posts()) {
      $query->the_post();
      $categories = get_the_category();
      $parent_category_id = null;
      if (empty($categories[1])) {
        $category_id = $categories[0]->term_id;
      } else {
        $category_id = $categories[1]->term_id;
        $parent_category_id = $categories[0]->term_id;
      }

      $post = array(
        'titulo' => resume_text(get_the_title(), 80),
        'imagem' => get_the_post_thumbnail_url(),
        'data' => get_the_date(),
        'descricao' => get_the_excerpt(),
        'categoria' => array(get_cat_name($category_id), get_category_link($category_id)),
        'categoria_pai' => isset($parent_category_id) ? get_cat_name($parent_category_id) : "",
        'categoria_pai_link' => isset($parent_category_id) ? get_category_link($parent_category_id) : "",
        'link' => get_permalink(),
        'comentarios' => get_comments_number()
      );

      echo theme_post_template($post);
    }
  }
  wp_reset_postdata();
}

//Template para os posts
function theme_post_template($post)
{
  $html = '<article class="c-post">';
  $html .= '<a class="c-post__image" href="' . $post['link'] . '" title="' . $post['titulo'] . '">';
  $html .= '<img width="530" height="300" class="lazy" data-src="' . $post['imagem'] . '" alt="' . $post['titulo'] . '" />';
  $html .= '</a>';
  $html .= '<header class="c-post__header">';
  $html .= '<ul class="c-post__categories">';
  if ($post['categoria']) {
    $html .= '<li class="c-post__category"><a href="' . $post['categoria'][1] . '" title="' . $post['categoria'][0] . '">' . $post['categoria'][0] . '</a></li>';
  }
  if ($post['categoria_pai'] !== "" && $post['categoria_pai_link'] !== "") {
    $html .= '<li class="c-post__category"><a href="' . $post['categoria_pai_link'] . '" title="' . $post['categoria_pai'] . '">' . $post['categoria_pai'] . '</a></li>';
  }
  $html .= '</ul>';
  $html .= '<h2 class="c-post__title"><a href="' . $post['link'] . '" title="' . $post['titulo'] . '">' . $post['titulo'] . '</a></h2>';
  $html .= '<div class="c-post__info">';
  if ($post['data']) {
    $html .= '<p class="c-post__data">' . $post['data'] . '</p>';
  }
  if (isset($post['comentarios'])) {
    $html .= '<a href="' . $post['link'] . '#respond" title="Ver comentários" class="c-post__comentarios">' . $post['comentarios'] . " " . ($post['comentarios'] === 1 ? "Comentário" : "Comentários") . '</a>';
  }
  $html .= "</div>";
  $html .= '</header>';
  if ($post['descricao']) {
    $html .= '<div class="c-post__descricao">' . $post['descricao'] . '</div>';
  }
  $html .= '<a href="' . $post['link'] . '" class="c-button">Ler mais</a>';
  $html .= '</article>';

  return $html;
}

//Retorna os slides conforme os argumentos fornecidos
function theme_get_slides($args)
{
  if (!$args) return;

  $query = new WP_Query($args);
  if ($query->have_posts()) {
    // Verifica se é a página inicial
    $is_home = is_front_page();

    // Adiciona a classe is-home se estiver na página inicial
    $carousel_class = $is_home ? 'c-carousel is-home' : 'c-carousel';

    echo '<div class="l-page__content ' . $carousel_class . ' js-main-carousel splide">';
    echo '<div class="splide__track"><ul class="splide__list">';
    while ($query->have_posts()) {
      $query->the_post();
      $custom = array(
        'titulo' => get_the_title(),
        'imagem' => get_field("imagem"),
        'imagem_mobile' => get_field("imagem_mobile"),
        'link' => get_field("link"),
      );
      echo theme_slides_template($custom);
    }
    echo '</ul></div>';
    echo '</div>';
    wp_reset_postdata();
  }
}

//Template para os slides
function theme_slides_template($custom)
{
  $html = '<li class="splide__slide"><article class="l-slide">';
  if ($custom["link"]) {
    $html .= '<a target="_blank" rel="nofollow" href="' . $custom['link'] . '" title="' . $custom['titulo'] . '">';
  }
  $html .= '<picture class="l-slide__image">';
  if ($custom['imagem_mobile']) {
    $html .= '<source media="(max-width:600px)" srcset="' . $custom["imagem_mobile"] . '">';
  };
  $html .= '<img width="1500" height="415" src="' . $custom["imagem"] . '" alt="' . $custom['titulo'] . '" />';
  $html .= '</picture>';
  $html .= '<h2 class="screen-readers-only">' . $custom['titulo'] . '</h2>';
  $html .= '</article>';
  if ($custom["link"]) {
    $html .= '</a>';
  }
  $html .= '</li>';

  return $html;
}

//Template para os banners
function theme_banner_template($custom)
{
  $html = "";
  if ($custom["link"]) {
    $html .= '<a target="_blank" rel="nofollow" href="' . $custom['link'] . '" title="' . $custom['titulo'] . '" class="l-banner">';
  } else {
    $html .= '<article class="l-banner">';
    $html .= '<h3 class="screen-readers-only">' . $custom['titulo'] . '</h3>';
  }

  $html .= '<img class="lazy" width="380" height="380" data-src="' . $custom['imagem'] . '" alt="' . $custom['titulo'] . '"/>';

  if ($custom["link"]) {
    $html .= '</a>';
  } else {
    $html .= '</article>';
  }
  return $html;
}

/* function theme_banners_archive($custom)
{
  $html = "";

  if ($custom["link"]) {
    $html .= '<a target="_blank" rel="nofollow" href="' . $custom['link'] . '" title="' . $custom['titulo'] . '" class="l-page-home__banner">';
  } else {
    $html .= '<article class="l-page-home__banner">';
    $html .= '<h3 class="screen-readers-only">' . $custom['titulo'] . '</h3>';
  }

  $html .= '<picture>';
  if ($custom['imagem_mobile']) {
    $html .= '<source media="(max-width:600px)" srcset="' . $custom['imagem_mobile'] . '">';
  };
  $html .= '<img loading="lazy" width="1000" height="100" src="' . $custom['imagem'] . '" alt="' . $custom['titulo'] . '" />';
  $html .= '</picture>';

  if ($custom["link"]) {
    $html .= '</a>';
  } else {
    $html .= '</article>';
  }

  return $html;
} */
