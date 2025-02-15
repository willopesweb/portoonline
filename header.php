<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta property="og:title" content="<?php the_title(); ?>" />
  <meta property="og:description" content="<?php echo get_the_excerpt(); ?>" />
  <meta property="og:url" content="<?php echo get_permalink(); ?>" />
  <?php
  if (has_post_thumbnail()) {
    echo '<meta name="twitter:image" content="' . get_the_post_thumbnail_url() . '" />';
  }
  ?>
  <?php if (is_archive()) {
    echo '<title>' . str_replace('</span>', '', str_replace('Categoria: <span>', '', get_the_archive_title())) . ' - Porto Ferreira Online</title>';
  } else { ?>
    <title><?= wp_title() ?> - Porto Ferreira Online</title>
  <?php
  }
  ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

  <?php

  wp_head();
  ?>
</head>


<body <?php body_class(); ?> style="overflow-x: initial; padding-bottom:0">
  <div id="skip"><a href="#content">Pular para o Conteúdo</a></div>

  <header class="l-header" role="banner">
    <div class="l-header__main">
      <a href="<?= get_site_url() ?>" title="Página Inicial" class="l-header__logo">
        <h1 class="screen-readers-only"><?= wp_title() ?> - Porto Ferreira Online</h1>
        <img width="200" height="90" src="<?= get_stylesheet_directory_uri() . '/' . ASSETS_DIR ?>/img/logo.png" alt="Porto Ferreira Online">
      </a>

      <?php
      echo slides_topo_shortcode();
      ?>
      <div class="l-header__subheader">
        <a href="<?= get_site_url() ?>/categoria/etv" class="l-header__tv-logo" title="Porto Ferreira Online TV">
          <img width="100" src="<?= get_stylesheet_directory_uri() . '/' . ASSETS_DIR ?>/img/tv.png" alt="Porto Ferreira Online TV" />
        </a>
        <a href="<?= get_site_url() ?>/categoria/podcast-de-negocios" class="l-header__tv-logo" title="Podcast de Negócios com William Malaco">
          <img width="100" src="<?= get_stylesheet_directory_uri() . '/' . ASSETS_DIR ?>/img/podnegocios.png" alt="Podcast de Negócios com William Malaco" />
        </a>
        <a href="<?= get_site_url() ?>/categoria/podcast-mais-saude" class="l-header__tv-logo" title="Podcast Mais Saúde">
          <img width="100" src="<?= get_stylesheet_directory_uri() . '/' . ASSETS_DIR ?>/img/podsaude.png" alt="Podcast Mais Saúde" />
        </a>
        <a href="<?= get_site_url() ?>/categoria/aqui-podcast-com-roberto-neves" class="l-header__tv-logo" title="Aqui Podcast com Roberto Neves">
          <img width="100" src="<?= get_stylesheet_directory_uri() . '/' . ASSETS_DIR ?>/img/aquipod.png" alt="Aqui Podcast com Roberto Neves" />
        </a>
        <nav class="l-header__topmenu">
          <?php
          wp_nav_menu([
            'menu' => 'Institucional',
            'container' => 'ul',
            'menu_class' => 'l-header__topmenu-content',
            'menu_id' => 'topmenu',
            'container_aria_label' => 'main navigation'
          ]);
          ?>
          <?= theme_social_networks() ?>
        </nav>
      </div>

    </div>
  </header>

  <nav id="nav" class="c-nav" role="navigation">
    <div class="c-nav__content">
      <h1 class="screen-readers-only">Menu Principal</h1>
      <?php
      wp_nav_menu([
        'menu' => 'Topo',
        'container' => 'ul',
        'menu_class' => 'c-nav__menu',
        'menu_id' => 'menu',
        'container_aria_label' => 'main navigation'
      ]);
      ?>
      <span id="searchButton" class="c-nav__search-icon icon-search"></span>
      <span id="mobileButton" class="c-nav__mobile-icon icon-menu"></span>
    </div>
    <div class="l-header__search" id="search">
      <div class="l-header__search-content">
        <form role="search" method="get" class="l-header__search-form" action="<?php echo esc_url(home_url('/')); ?>">
          <label>
            <span class="screen-reader-text">Pesquisar por:</span>
            <input type="search" class="search-field" placeholder="Digite aqui o que você procura" value="<?php echo get_search_query(); ?>" name="s" />
          </label>

          <label>
            <span class="screen-reader-text">Categorias</span>
            <select name="category_name">
              <option value="">Todos</option>
              <?php
              $categories = get_categories(array(
                'parent' => 0 // Filtrar apenas as categorias principais
              ));

              foreach ($categories as $category) {
                if ($category->slug !== "sem-categoria") {
                  echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
                }
              }
              ?>
            </select>
          </label>
          <button class="c-button icon-search" type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </nav>

  <?php
  if (is_front_page()) {
    echo slides_home_shortcode();
  }
  ?>