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


function custom_rollover_tarps_tab($tabs) {
    global $product;

    // Ensure $product is available and get the product type
    if ($product && $product->is_type('simple')) {
        $product_id = $product->get_id();
        $product_type = get_post_meta($product_id, '_product_type', true);

        // Add a new tab if the product type is 'rollover_tarps'
        if ($product_type === 'rollover_tarps') {
            $tabs['rollover_tarps_tab'] = array(
                'title'    => __('Rollover Tarps Info', 'your-textdomain'),
                'priority' => 50, // Adjust priority to control tab order
                'callback' => 'custom_rollover_tarps_tab_content',
            );
            // Add the "Materials" tab for the same product type
            $tabs['materials_tab'] = array(
                'title'    => __('Materials', 'your-textdomain'),
                'priority' => 60, // Adjust priority to control tab order
                'callback' => 'custom_materials_tab_content',
            );
        }
    }

    return $tabs;
}
add_filter('woocommerce_product_tabs', 'custom_rollover_tarps_tab');

function custom_rollover_tarps_tab_content() {
    echo '<h2>Rollover Tarps Information</h2>';
    echo '<table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>Inches</th>
                    <th>Decimal</th>
                </tr>
                <tr>
                    <td>1"</td>
                    <td>0.083</td>
                </tr>
                <tr>
                    <td>2"</td>
                    <td>0.167</td>
                </tr>
                <tr>
                    <td>3"</td>
                    <td>0.25</td>
                </tr>
                <tr>
                    <td>4"</td>
                    <td>0.333</td>
                </tr>
                <tr>
                    <td>5"</td>
                    <td>0.417</td>
                </tr>
                <tr>
                    <td>6"</td>
                    <td>0.5</td>
                </tr>
                <tr>
                    <td>7"</td>
                    <td>0.583</td>
                </tr>
                <tr>
                    <td>8"</td>
                    <td>0.667</td>
                </tr>
                <tr>
                    <td>9"</td>
                    <td>0.75</td>
                </tr>
                <tr>
                    <td>10"</td>
                    <td>0.833</td>
                </tr>
                <tr>
                    <td>11"</td>
                    <td>0.917</td>
                </tr>
                <tr>
                    <td>12"</td>
                    <td>1</td>
                </tr>
        </table>';
    echo '<p>*Please use the above conversion chart because the inches MUST Be converted into decimal form for proper processing.<p>';
    echo '<p>Std RTR	Example:	If the length is 35\'5" then you would enter it as:35.417<p>';
    echo '<p>Custom	Example:	Width 9\'3" x length 20\'7" then enter it as:9.25 x 20.583<p>';     
}

function custom_materials_tab_content() {
    echo '<h2>Materials Information</h2>';
    echo '<p><strong> 18oz Vinyl Coated Polyester (VCP): </strong>  *This is the most popular fabric option</p>';
    echo '<p>Commonly used in agricultural applications.  Grain haulers, gravity wagons, and more.</p>';
    echo '<table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>Specification</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td>Weight</td>
                    <td>18oz/yard²</td>
                </tr>
                <tr>
                    <td>Construction</td>
                    <td>100% Polyester, 1000D x 1300D (18 x 17)</td>
                </tr>
                <tr>
                    <td>Tensile Strength (Grab)</td>
                    <td>410 pounds x 410 pounds</td>
                </tr>
                <tr>
                    <td>Tensile Strength (Strip)</td>
                    <td>300 pounds x 300 pounds</td>
                </tr>
                <tr>
                    <td>Tear Strength (Tongue)</td>
                    <td>100 pounds x 100 pounds</td>
                </tr>
                <tr>
                    <td>Adhesion Strength</td>
                    <td>12 x 10 pounds/inch</td>
                </tr>
                <tr>
                    <td>Abrasion Resistance</td>
                    <td>400 cycles</td>
                </tr>
                <tr>
                    <td>Hydrostatic Resistance</td>
                    <td>At least 600 pounds/inch²</td>
                </tr>
                <tr>
                    <td>U.V. Resistance</td>
                    <td>Not excessive fading after 300 hours</td>
                </tr>
                <tr>
                    <td>Cold Crack</td>
                    <td>-40˚ Fahrenheit</td>
                </tr>
                <tr>
                    <td>High Temperature Resistance</td>
                    <td>180˚ Fahrenheit</td>
                </tr>
            </table>';
    echo '<p><strong>Stock Colors:</strong>Black, Gray, Green, Orange, Purple, Red, Royal Blue, Tan, White, & Yellow.</p>';
    echo '<p>22oz Vinyl Coated Polyester (VCP): </p>	';
    echo '<p>Common material choice for dump trailers that haul things like asphalt.</p>';
    echo '<table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>Specification</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td>Weight</td>
                    <td>22oz/yard²</td>
                </tr>
                <tr>
                    <td>Construction</td>
                    <td>100% Polyester, 1500D x 1500D (16 x 16)</td>
                </tr>
                <tr>
                    <td>Tensile Strength (Grab)</td>
                    <td>500 pounds x 500 pounds</td>
                </tr>
                <tr>
                    <td>Tensile Strength (Strip)</td>
                    <td>430 pounds x 380 pounds</td>
                </tr>
                <tr>
                    <td>Tear Strength (Tongue)</td>
                    <td>145 pounds x 145 pounds</td>
                </tr>
                <tr>
                    <td>Adhesion Strength</td>
                    <td>15 x 12 pounds/inch</td>
                </tr>
                <tr>
                    <td>Abrasion Resistance</td>
                    <td>600 cycles</td>
                </tr>
                <tr>
                    <td>Hydrostatic Resistance</td>
                    <td>At least 600 pounds/inch²</td>
                </tr>
                <tr>
                    <td>U.V. Resistance</td>
                    <td>Not excessive fading after 300 hours</td>
                </tr>
                <tr>
                    <td>Cold Crack</td>
                    <td>-40˚ Fahrenheit</td>
                </tr>
                <tr>
                    <td>High Temperature Resistance</td>
                    <td>180˚ Fahrenheit</td>
                </tr>
            </table>';
    echo '<p<strong>Stock Colors:</strong>	Black, Red, Royal Blue, and White.</p>';
}


