<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
function custom_product_options_enqueue_scripts() {
    wp_enqueue_script(
        'expiry-date-calculator', 
        plugin_dir_url(__FILE__) . 'assets/js/expiry-date-calculator.js', 
        array('jquery'), 
        '1.0.0', 
        true
    );

    wp_enqueue_style(
        'custom-product-style', 
        plugin_dir_url(__FILE__) . 'assets/css/style.css'
    );
}
add_action('wp_enqueue_scripts', 'custom_product_options_enqueue_scripts');
