<?php
// Save custom options in cart
function custom_curtain_options_save_custom_options($cart_item_data, $product_id, $variation_id) {
    if (isset($_POST['curtain_material'])) {
        $cart_item_data['curtain_material'] = sanitize_text_field($_POST['curtain_material']);
    }
    if (isset($_POST['curtain_size'])) {
        $cart_item_data['curtain_size'] = sanitize_text_field($_POST['curtain_size']);
        if ($_POST['curtain_size'] == 'custom') {
            $cart_item_data['custom_length'] = sanitize_text_field($_POST['custom_length']);
            $cart_item_data['custom_width'] = sanitize_text_field($_POST['custom_width']);
        }
    }
    if (isset($_POST['curtain_hem'])) {
        $cart_item_data['curtain_hem'] = sanitize_text_field($_POST['curtain_hem']);
    }
    if (isset($_POST['second_hem']) && $_POST['second_hem'] != 'none') {
        $cart_item_data['second_hem'] = sanitize_text_field($_POST['second_hem']);
    }
    if (isset($_POST['pipe_pocket']) && $_POST['pipe_pocket'] != 'none') {
        $cart_item_data['pipe_pocket'] = sanitize_text_field($_POST['pipe_pocket']);
    }
    if (isset($_POST['webbing_reinforcement'])) {
        $cart_item_data['webbing_reinforcement'] = sanitize_text_field($_POST['webbing_reinforcement']);
    }
    if (isset($_POST['additional_details'])) {
        $cart_item_data['additional_details'] = sanitize_textarea_field($_POST['additional_details']);
    }
    return $cart_item_data;
}
add_filter('woocommerce_add_cart_item_data', 'custom_curtain_options_save_custom_options', 10, 3);

// Display custom options in cart and checkout
function custom_curtain_options_display_custom_options($item_data, $cart_item) {
    if (isset($cart_item['curtain_material'])) {
        $item_data[] = array(
            'key' => __('Curtain Material', 'custom-curtain-options'),
            'value' => wc_clean($cart_item['curtain_material']),
        );
    }
    if (isset($cart_item['curtain_size'])) {
        $item_data[] = array(
            'key' => __('Curtain Size', 'custom-curtain-options'),
            'value' => wc_clean($cart_item['curtain_size']),
        );
        if ($cart_item['curtain_size'] == 'custom') {
            $item_data[] = array(
                'key' => __('Custom Length', 'custom-curtain-options'),
                'value' => wc_clean($cart_item['custom_length']),
            );
            $item_data[] = array(
                'key' => __('Custom Width', 'custom-curtain-options'),
                'value' => wc_clean($cart_item['custom_width']),
            );
        }
    }
    if (isset($cart_item['curtain_hem'])) {
        $item_data[] = array(
            'key' => __('Curtain Hem', 'custom-curtain-options'),
            'value' => wc_clean($cart_item['curtain_hem']),
        );
    }
    if (isset($cart_item['second_hem'])) {
        $item_data[] = array(
            'key' => __('Second Hem', 'custom-curtain-options'),
            'value' => wc_clean($cart_item['second_hem']),
        );
    }
    if (isset($cart_item['pipe_pocket'])) {
        $item_data[] = array(
            'key' => __('Pipe Pocket', 'custom-curtain-options'),
            'value' => wc_clean($cart_item['pipe_pocket']),
        );
    }
    if (isset($cart_item['webbing_reinforcement'])) {
        $item_data[] = array(
            'key' => __('Webbing Reinforcement', 'custom-curtain-options'),
            'value' => wc_clean($cart_item['webbing_reinforcement']),
        );
    }
    if (isset($cart_item['additional_details'])) {
        $item_data[] = array(
            'key' => __('Additional Details', 'custom-curtain-options'),
            'value' => wc_clean($cart_item['additional_details']),
        );
    }
    return $item_data;
}
add_filter('woocommerce_get_item_data', 'custom_curtain_options_display_custom_options', 10, 2);

// Save custom options to order
function custom_curtain_options_save_custom_options_to_order($item, $cart_item_key, $values, $order) {
    if (isset($values['curtain_material'])) {
        $item->add_meta_data(__('Curtain Material', 'custom-curtain-options'), $values['curtain_material']);
    }
    if (isset($values['curtain_size'])) {
        $item->add_meta_data(__('Curtain Size', 'custom-curtain-options'), $values['curtain_size']);
        if ($values['curtain_size'] == 'custom') {
            $item->add_meta_data(__('Custom Length', 'custom-curtain-options'), $values['custom_length']);
            $item->add_meta_data(__('Custom Width', 'custom-curtain-options'), $values['custom_width']);
        }
    }
    if (isset($values['curtain_hem'])) {
        $item->add_meta_data(__('Curtain Hem', 'custom-curtain-options'), $values['curtain_hem']);
    }
    if (isset($values['second_hem'])) {
        $item->add_meta_data(__('Second Hem', 'custom-curtain-options'), $values['second_hem']);
    }
    if (isset($values['pipe_pocket'])) {
        $item->add_meta_data(__('Pipe Pocket', 'custom-curtain-options'), $values['pipe_pocket']);
    }
    if (isset($values['webbing_reinforcement'])) {
        $item->add_meta_data(__('Webbing Reinforcement', 'custom-curtain-options'), $values['webbing_reinforcement']);
    }
    if (isset($values['additional_details'])) {
        $item->add_meta_data(__('Additional Details', 'custom-curtain-options'), $values['additional_details']);
    }
}
add_action('woocommerce_checkout_create_order_line_item', 'custom_curtain_options_save_custom_options_to_order', 10, 4);
