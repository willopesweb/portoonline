<?php
// Funções para o painel Admin

// Renomeia os plugins
function admin_rename_plugins()
{
  global $menu;

  $updates = array(
    "WooCommerce" => array(
      'name' => 'Loja'
    ),
    "WP Mail SMTP" => array(
      'name' => 'Config. E-mail'
    ),
    "FooBox" => array(
      'name' => 'Config. Galeria'
    ),
    "Loco Translate" => array(
      'name' => 'Traduções'
    ),
  );

  foreach ($menu as $k => $props) {

    // Check for new values
    $new_values = (isset($updates[$props[0]])) ? $updates[$props[0]] : false;
    if (!$new_values) continue;

    // Change menu name
    $menu[$k][0] = $new_values['name'];

    // Optionally change menu icon
    if (isset($new_values['icon']))
      $menu[$k][6] = $new_values['icon'];
  }
}
add_action('admin_init', 'admin_rename_plugins');
