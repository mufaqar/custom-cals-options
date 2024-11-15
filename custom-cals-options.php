<?php
/*
Plugin Name: Custom Expiry Date Calculator
Plugin URI: https://yourwebsite.com
Description: A plugin to calculate expiry dates and display dynamic prices based on user input.
Version: 1.0
Author: Mufaqar Islam
Author URI: https://github.com/mufaqar
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: custom-expiry-date-calculator
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

