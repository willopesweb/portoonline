<?php

/** PERFORMANCE */
function theme_remove_unnecessary_css_js()
{
  global $wp_scripts;

  // Remover todos os scripts enfileirados pelos plugins
  $wp_scripts->queue = array();
}

add_action('wp_enqueue_scripts', 'theme_remove_unnecessary_css_js');
