<?php


add_filter('woocommerce_add_cart_item_data', 'add_custom_values_to_cart_item', 10, 2);
function add_custom_values_to_cart_item($cart_item_data, $product_id) {
    if (!empty($_POST['expiry_month'])) {
        $cart_item_data['expiry_month'] = sanitize_text_field($_POST['expiry_month']);
    }
    if (!empty($_POST['expiry_year'])) {
        $cart_item_data['expiry_year'] = sanitize_text_field($_POST['expiry_year']);
    }
    if (!empty($_POST['expiration_date'])) {
        $cart_item_data['expiration_date'] = sanitize_text_field($_POST['expiration_date']);
    }
    if (!empty($_POST['condition'])) {
        $cart_item_data['condition'] = sanitize_text_field($_POST['condition']);
    }
    if (isset($_POST['dynamic_price']) && !empty($_POST['dynamic_price'])) {
        $cart_item_data['dynamic_price'] = floatval($_POST['dynamic_price']);
        $cart_item_data['unique_key'] = md5(microtime() . rand()); // Ensure unique cart item
    }

    // Unique key to ensure the cart item is treated uniquely
    $cart_item_data['unique_key'] = md5(microtime() . rand());

 
    return $cart_item_data;
}

add_filter('woocommerce_get_item_data', 'display_custom_values_in_cart', 10, 2);
function display_custom_values_in_cart($item_data, $cart_item) {
    if (isset($cart_item['expiry_month']) && isset($cart_item['expiry_year'])) {
        $item_data[] = array(
            'name'  => __('Print Expiration Date'),
            'value' => $cart_item['expiry_month'] . '/' . $cart_item['expiry_year'],
        );
    }
    if (isset($cart_item['expiration_date'])) {
        $item_data[] = array(
            'name'  => __('Expiration Date'),
            'value' => $cart_item['expiration_date'],
        );
    }
    if (isset($cart_item['condition'])) {
        $item_data[] = array(
            'name'  => __('Condition'),
            'value' => $cart_item['condition'],
        );
    }
    return $item_data;
}

add_action('woocommerce_add_order_item_meta', 'save_custom_values_to_order', 10, 2);
function save_custom_values_to_order($item_id, $cart_item) {
    if (isset($cart_item['expiry_month']) && isset($cart_item['expiry_year'])) {
        wc_add_order_item_meta($item_id, 'Print Expiration Date', $cart_item['expiry_month'] . '/' . $cart_item['expiry_year']);
    }
    if (isset($cart_item['expiration_date'])) {
        wc_add_order_item_meta($item_id, 'Expiration Date', $cart_item['expiration_date']);
    }
    if (isset($cart_item['condition'])) {
        wc_add_order_item_meta($item_id, 'Condition', $cart_item['condition']);
    }
}


add_action('woocommerce_before_calculate_totals', 'update_cart_item_price_with_dynamic_price', 10, 1);
function update_cart_item_price_with_dynamic_price($cart) {
    // Loop through cart items
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if (isset($cart_item['dynamic_price'])) {
            $cart_item['data']->set_price($cart_item['dynamic_price']);
        }
    }
}



add_action('woocommerce_before_calculate_totals', 'update_cart_item_price_with_discount', 10, 1);
function update_cart_item_price_with_discount($cart) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $discount_price = get_user_meta($user_id, 'global_discount_price', true);

        if (!empty($discount_price) && is_numeric($discount_price)) {
            foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
                $original_price = $cart_item['data']->get_price();

                // Apply discount by subtracting the discount price
                $new_price = max(0, $original_price - $discount_price); // Ensure price doesn't go below zero
                
                $cart_item['data']->set_price($new_price);
            }
        }
    }
}







?>
