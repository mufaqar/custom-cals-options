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

