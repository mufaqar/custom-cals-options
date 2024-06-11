<?php
/*
Plugin Name: Custom Curtain Options
Description: Adds custom curtain options to WooCommerce products.
Version: 1.0.0
Author: Mufaqar
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include necessary files
include_once plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php';
include_once plugin_dir_path(__FILE__) . 'includes/custom-options.php';
include_once plugin_dir_path(__FILE__) . 'includes/cart-checkout.php';
