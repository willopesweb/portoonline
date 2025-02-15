<?php
const ASSETS_DIR = 'assets/public';


// Setup Inicial do Tema
function theme_initial_setup()
{
  add_theme_support('post-thumbnails'); // Adiciona suporte à post thumbnails

  // Tamanho personalizados para imagens
  // Define o tamanho da imagem personalizado
  add_image_size('slide', 1500, 415, true);
  add_image_size('slide-mobile', 415, 415, true);
  add_image_size('post', 530, 300, true);
  add_image_size('bannner', 1000, 100, true);

  update_option('medium_crop', 1);

  // Adiciona Menu Principal
  if (function_exists('wp_nav_menu')) {
    add_theme_support('nav-menus');
    register_nav_menus(
      array(
        'primary' => 'Menu Principal'
      )
    );
  }
}
add_action('after_setup_theme', 'theme_initial_setup');


// Registra o arquivo CSS do tema
function theme_css()
{
  wp_register_style('theme-style', get_template_directory_uri() . '/' . ASSETS_DIR . '/css/main.css', [], '1.6.8', false);
  wp_register_style('theme-icons', get_template_directory_uri() . '/' . ASSETS_DIR . '/fonts/icons.css', [], '1.0.0', false);

  wp_enqueue_style('theme-style');
  wp_enqueue_style('theme-icons');
}
add_action('wp_enqueue_scripts', 'theme_css');


// Tamanho do resumo dos posts
function theme_custom_excerpt_length($length)
{
  return 20;
}
add_filter('excerpt_length', 'theme_custom_excerpt_length', 999);

// Paginação
function theme_custom_pagination($query = null)
{
  global $wp_query;
  if ($query == null) {
    $query = $wp_query;
  }
  $query->query_vars['posts_per_page'] = 2;

  $current = get_query_var('page') ? get_query_var('page') : get_query_var('paged');


  echo paginate_links(array(
    'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
    'total'        => $query->max_num_pages,
    'current'      => max(1, $current),
    'format'       => '?page=%#%',
    'show_all'     => false,
    'type'         => 'plain',
    'end_size'     => 2,
    'mid_size'     => 1,
    'prev_next'    => true,
    'prev_text'    => sprintf('<i></i> %1$s', __('Anterior', 'text-domain')),
    'next_text'    => sprintf('%1$s <i></i>', __('Próximo', 'text-domain')),
    'add_args'     => false,
    'add_fragment' => '',
  ));
}

function custom_disable_redirect_canonical($redirect_url)
{
  if (is_paged() && is_singular()) $redirect_url = false;
  return $redirect_url;
}
add_filter('redirect_canonical', 'custom_disable_redirect_canonical');




require "inc/custom-admin-functions.php";
require "inc/custom-admin-login.php";
require "inc/performance.php";
require "inc/custom-theme-functions.php";
require "inc/custom-post-type.php";
