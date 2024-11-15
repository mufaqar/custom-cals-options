<?php



// Hook the calculator to display before the price on the single product page
function add_expiry_date_calculator_before_price() {
    custom_expiry_date_calculator();
}
add_action('woocommerce_single_product_summary', 'add_expiry_date_calculator_before_price', 15);
