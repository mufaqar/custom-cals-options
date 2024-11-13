<?php
/*
Plugin Name: Custom Product Options
Description: Custom Product Options to WooCommerce products.
Version: 1.0.1
Author: Mufaqar
*/
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include necessary files
//include_once plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php';
include_once plugin_dir_path(__FILE__) . 'includes/custom-options.php';
include_once plugin_dir_path(__FILE__) . 'includes/cart-checkout.php';
include_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
include_once plugin_dir_path(__FILE__) . 'includes/expiry-date-calculator.php';


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

