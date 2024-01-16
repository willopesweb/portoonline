<?php

/** PERFORMANCE */
function theme_remove_unnecessary_css_js()
{

  wp_dequeue_style('wp-block-library'); // Remove o CSS WP Block, usado para estilizar os blocos do Gutenberg
  wp_deregister_script('wp-embed'); // Remove o JS para embedar Vídeos no Wordpress
  wp_deregister_style('classic-theme-styles');
  wp_dequeue_style('classic-theme-styles');

  // Remove CSS e JS do plugin Contact Form 7 nas páginas onde não existir formulários
  $load_scripts_wcp7 = false;
  $post = get_post();
  if (is_singular()) {
    if (has_shortcode($post->post_content, 'contact-form-7') || $post->post_title == 'Contato') {
      $load_scripts_wcp7 = true;
    }
  }

  if (!$load_scripts_wcp7) {
    wp_dequeue_script('contact-form-7');
    wp_dequeue_style('contact-form-7');
  }

  // Remove CSS e JS do plugin Instagram nas páginas onde não existir formulários
  $load_scripts_instagram = false;

  if (is_singular()) {
    $post = get_post();
    if (has_shortcode($post->post_content, 'instagram-feed') || $post->post_title == 'Home' || $post->post_title == 'Sobre') {
      $load_scripts_instagram = true;
    }
  }

  if (!$load_scripts_instagram) {
    wp_dequeue_script('sb_instagram');
    wp_dequeue_style('sb_instagram');
  }
}

add_action('wp_enqueue_scripts', 'theme_remove_unnecessary_css_js');

// Desativa WP Emojis
function disable_emoji_feature()
{

  // Prevent Emoji from loading on the front-end
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');

  // Remove from admin area also
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('admin_print_styles', 'print_emoji_styles');

  // Remove from RSS feeds also
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');

  // Remove from Embeds
  remove_filter('embed_head', 'print_emoji_detection_script');

  // Remove from emails
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

  // Disable from TinyMCE editor. Currently disabled in block editor by default
  add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');

  /** Finally, prevent character conversion too
   ** without this, emojis still work 
   ** if it is available on the user's device
   */

  add_filter('option_use_smilies', '__return_false');
}

function disable_emojis_tinymce($plugins)
{
  if (is_array($plugins)) {
    $plugins = array_diff($plugins, array('wpemoji'));
  }
  return $plugins;
}

add_action('init', 'disable_emoji_feature');
add_filter('option_use_smilies', '__return_false');


// Lista todos os CSS e JS carregados
function crunchify_print_scripts_styles()
{

  $result = [];
  $result['scripts'] = [];
  $result['styles'] = [];

  // Print all loaded Scripts
  global $wp_scripts;
  foreach ($wp_scripts->queue as $script) :
    $result['scripts'][] =  $wp_scripts->registered[$script]->src . ";";
  endforeach;

  // Print all loaded Styles (CSS)
  global $wp_styles;
  foreach ($wp_styles->queue as $style) :
    $result['styles'][] =  $wp_styles->registered[$style]->src . ";";
  endforeach;

  return $result;
}

add_action('wp_enqueue_scripts', 'crunchify_print_scripts_styles');
