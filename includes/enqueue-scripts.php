<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function custom_curtain_options_enqueue_scripts() {
    if (is_product()) {
        wp_enqueue_script('custom-curtain-options-js', plugin_dir_url(__FILE__) . '../assets/js/custom-curtain-options.js', array('jquery'), '1.0.0', true);
        wp_enqueue_style('custom-curtain-options-css', plugin_dir_url(__FILE__) . '../assets/css/custom-curtain-options.css', array(), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'custom_curtain_options_enqueue_scripts');
