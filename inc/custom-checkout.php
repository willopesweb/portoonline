<?php
// Funções para o Checkout

// Mostrar imagem do produto no checkout
function show_product_image_on_checkout($name, $cart_item, $cart_item_key)
{
  // Return is isn't checkout page
  if (!is_checkout()) {
    return $name;
  }

  // Get product object
  $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

  // Get product thumbnail
  $thumbnail = $_product->get_image();

  // Add wrapper to image and some css
  $image = "<div class='checkout_product_image' style='width: 52px; height: 45px; display:inline-block; padding-right: 7px; vertical-align: middle;'>" . $thumbnail . "</div>";

  // Prepend image to name and return it
  return $image .  $name;
}
add_filter('woocommerce_cart_item_name', 'show_product_image_on_checkout', 10, 3);

// Adiciona o campo Presente ao Checkout
function theme_custom_checkout($fields)
{
  $fields['billing']['billing_gift'] = [
    'label' => 'Embrulhar para Presente?',
    'required' => false,
    'class' => ['form-row-wide'],
    'clear' => true,
    'type' => 'select',
    'options' => [
      'nao' => 'Não',
      'sim' => 'Sim'
    ]
  ];

  return $fields;
}

add_filter('woocommerce_checkout_fields', 'theme_custom_checkout');

// Exibe o campo Presente no Painel Admin
function show_admin_custom_checkout_gift($order)
{
  $gift = get_post_meta($order->get_id(), '_billing_gift', true);
  echo '<p><strong>Embrulhar para Presente:</strong>' . $gift . '</p>';
}

add_action('woocommerce_admin_order_data_after_shipping_address', 'show_admin_custom_checkout_gift');

// Exibe o campo Mensagem Personalizada na página de checkout
function theme_custom_checkout_field($checkout)
{
  woocommerce_form_field('mensagem_personalizada', [
    'type' => 'textarea',
    'class' => ['form-row-wide mensagem-personalizada'],
    'label' => 'Mensagem Personalizada',
    'placeholder' => 'Escreva uma mensagem para a pessoa que vocês esta presenteando.',
    //'required' => true
  ], $checkout->get_value('mensagem-personalizada'));
}

add_action('woocommerce_after_order_notes', 'theme_custom_checkout_field');

//// Validar campo
//function theme_custom_checkout_process()
//{
//  if (!$_POST['mensagem_personalizada']) {
//    wc_add_notice('Por favor, escreva uma mensagem personalizada.', 'error');
//  }
//}

add_action('woocommerce_checkout_process', 'theme_custom_checkout_process');

// Adicionar ao Banco de Dados
function theme_custom_checkout_field_update($order_id)
{
  if (!empty($_POST['mensagem-personalizada'])) :
    update_post_meta($order_id, 'mensage_personalizada', sanitize_text_field($_POST['mensagem_personalizada']));
  endif;
}
add_action('woocommerce_checkout_update_order_meta', 'theme_custom_checkout_field_update');

// Exibe o campo Mensagem Personalizada no Painel Admin
function show_admin_custom_checkout_personal_message($order)
{
  $message = get_post_meta($order->get_id(), '_mensagem_personalizada', true);
  echo '<p><strong>Mensagem Personalizada:</strong>' . $message . '</p>';
}

add_action('woocommerce_admin_order_data_after_shipping_address', 'show_admin_custom_checkout_personal_message');
