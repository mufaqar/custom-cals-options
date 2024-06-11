<?php
// Enqueue necessary scripts and styles
function custom_curtain_options_enqueue_scripts() {
    wp_enqueue_script('custom-curtain-options-script', plugins_url('../js/custom-curtain-options.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_style('custom-curtain-options-style', plugins_url('../css/custom-curtain-options.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'custom_curtain_options_enqueue_scripts');
