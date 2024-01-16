<?php

function my_login_logo_url()
{
  return get_bloginfo('url');
}
add_filter('login_headerurl', 'my_login_logo_url');


function my_login_logo_url_title()
{
  return 'Voltar para Página Inicial';
}
add_filter('login_headertext', 'my_login_logo_url_title');

function theme_custom_login_logo()
{
  echo '<style type="text/css">
  :root{
    --login-background-color: #0f274d;
    --login-font-family: "Poppins", sans-serif;
    --button-background-color:#ff5400;
    --button-hover-color: #ef3b3e;
    --button-font-color: #f1f1f1;
  }

  h1 a {
    background-image: url(' . get_stylesheet_directory_uri() . '/' . ASSETS_DIR . '/img/logo.png) !important;
    background-size: contain !important;
    height: 72px !important;   
    margin-bottom: 20px !important;
    padding-bottom: 0 !important;
    width: 320px !important;
  }

  .login form {
    margin-top: 10px !important;
  }

  body.login {
    background-color: var(--login-background-color);
  }

  .button {
    border: none !important;
    border-radius: 0.5rem;
    cursor: pointer;
    font-family: var(--login-font-family);
    font-size: 1rem;
    font-weight: 600;
    outline: 0;
    padding: 0.625rem 1.5625rem;
    text-align: center;
    text-transform: uppercase;
    transition: 300ms ease all;
    -webkit-appearance: none !important;
  }

  .button:focus,
  .button:active {
    border: none !important;
    box-shadow: none;
    outline: 2px solid var(--button-background-color);
  }

  .button-primary {
    background-color: var(--button-background-color) !important;
    color: var(--button-font-color);
  }

  .button-primary:hover {
    background-color: var(--button-hover-color) !important;
  }
</style>';
}

add_action('login_head', 'theme_custom_login_logo');
