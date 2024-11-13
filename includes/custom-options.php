<?php



function display_expiry_date_calculator() {
    echo do_shortcode('[expiry_date_calculator]');
}
// Hook into WooCommerce single product summary, with priority 15 (between title and price)
add_action('woocommerce_single_product_summary', 'display_expiry_date_calculator', 15);
