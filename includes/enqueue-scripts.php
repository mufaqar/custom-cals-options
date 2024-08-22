<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
function custom_curtain_options_enqueue_scripts() {
    if (is_product()) {
        global $product;
         wp_enqueue_style('custom-curtain-options-css', plugin_dir_url(__FILE__) . '../assets/css/custom-curtain-options.css', array(), '1.0.0');      
        if ($product && $product->is_type('simple')) {
            $product_id = $product->get_id();
            $product_type = get_post_meta($product_id, '_product_type', true);
            if (!empty($product_type) && $product_type === 'rollover_tarps') {
                wp_enqueue_script('roll-curtain-options', plugin_dir_url(__FILE__) . '../assets/js/roll-curtain-options.js', array('jquery'), '1.0.0', true);
            } elseif (!empty($product_type) && $product_type === 'livestock_curtains') {
                wp_enqueue_script('custom-curtain-options-js', plugin_dir_url(__FILE__) . '../assets/js/custom-curtain-options.js', array('jquery'), '1.0.0', true);
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'custom_curtain_options_enqueue_scripts');


function custom_rollover_tarps_tab($tabs) {
    global $product;

    // Ensure $product is available and get the product type
    if ($product && $product->is_type('simple')) {
        $product_id = $product->get_id();
        $product_type = get_post_meta($product_id, '_product_type', true);

        // Add a new tab if the product type is 'rollover_tarps'
        if ($product_type === 'rollover_tarps') {
            $tabs['rollover_tarps_tab'] = array(
                'title'    => __('Rollover Tarps Info', 'your-textdomain'),
                'priority' => 50, // Adjust priority to control tab order
                'callback' => 'custom_rollover_tarps_tab_content',
            );
        }
    }

    return $tabs;
}
add_filter('woocommerce_product_tabs', 'custom_rollover_tarps_tab');

function custom_rollover_tarps_tab_content() {
    echo '<h2>' . __('Rollover Tarps Information', 'your-textdomain') . '</h2>';
    echo '<p>' . __('This is additional information specifically for rollover tarps.', 'your-textdomain') . '</p>';
    // Add any additional content or HTML here
}


