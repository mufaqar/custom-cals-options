<?php
/*
Plugin Name: Expiry Date Calculator
Plugin URI: https://yourwebsite.com
Description: A plugin to calculate expiry dates and display dynamic prices based on user input.
Version: 2.1.12
Author: Mufaqar Islam
Author URI: https://mufaqar.com
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: custom-expiry-date-calculator
*/
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

include_once plugin_dir_path(__FILE__) . 'includes/user-registration.php';
include_once plugin_dir_path(__FILE__) . 'includes/custom-options.php';
include_once plugin_dir_path(__FILE__) . 'includes/cart-checkout.php';
include_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
include_once plugin_dir_path(__FILE__) . 'includes/expiry-date-calculator.php';
//include_once plugin_dir_path(__FILE__) . 'includes/custom-shipping-methods.php';



function custom_registration_scripts() {
    wp_enqueue_script('custom-registration-script', plugin_dir_url(__FILE__) . 'assets/js/custom-registration.js', array('jquery'), null, true);
    wp_localize_script('custom-registration-script', 'custom_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('custom_user_registration')
    ));
}
add_action('wp_enqueue_scripts', 'custom_registration_scripts');


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