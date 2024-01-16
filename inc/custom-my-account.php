<?php
// Desabilita opção de Downloads
function custom_my_account_menu_items($items)
{
  unset($items['downloads']);
  return $items;
}
add_filter('woocommerce_account_menu_items', 'custom_my_account_menu_items');

//Mostrar imagem do produto em Minha Conta -> Pedidos
function display_product_image_in_my_account($item_name, $item, $is_visible)
{
  // Targeting view order pages only
  if (is_wc_endpoint_url('view-order')) {
    $product   = $item->get_product(); // Get the WC_Product object (from order item)
    $thumbnail = $product->get_image(array(60, 60)); // Get the product thumbnail (from product object)
    if ($product->get_image_id() > 0)
      $item_name = '<div class="item-thumbnail">' . $thumbnail . '</div>' . $item_name;
  }
  return $item_name;
}
add_filter('woocommerce_order_item_name', 'display_product_image_in_my_account', 20, 3);
