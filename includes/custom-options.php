<?php

function custom_curtain_options_add_to_product() {
    global $product;

    if ($product->is_type('simple')) {
        $product_id = $product->get_id();
        $curtain_material = get_post_meta($product_id, '_curtain_material', true) ?: array();
        $curtain_size = get_post_meta($product_id, '_curtain_size', true) ?: array();
        $curtain_custom_width = get_post_meta($product_id, '_curtain_custom_width', true);
        $curtain_custom_height = get_post_meta($product_id, '_curtain_custom_height', true);
        $curtain_hem = get_post_meta($product_id, '_curtain_hem', true);
        $second_hem = get_post_meta($product_id, '_second_hem', true);
        $pipe_pocket = get_post_meta($product_id, '_pipe_pocket', true);
        $webbing_reinforcement = get_post_meta($product_id, '_webbing_reinforcement', true);
        $additional_details = get_post_meta($product_id, '_additional_details', true);
        $electric_system = get_post_meta($product_id, '_electric_system', true);
        $product_type = get_post_meta($product_id, '_product_type', true);
        $curtain_length = get_post_meta($product_id, '_curtain_length', true);
        $precise_length = get_post_meta($product_id, '_precise_length', true);
        $tarp_color = get_post_meta($product_id, '_tarp_color', true);

        // Predefined options
        $predefined_materials = array(
            '15_oz' => '15oz Clear',
            '18_oz' => '18oz White',
            '20_oz' => '20oz',
            '22_oz' => '22oz'
        );

        $predefined_size_options = array(
            'size_1' => '5\' with 1 3" Hem (58") or 4" Hem',
            'size_2' => '6\' with 1 3" Hem (69") or 4" Hem',
            'size_3' => '9\' with 1 3" Hem (105") or 4" Hem',
            'size_4' => '12\' with 1 3" Hem (141") or 4" Hem (140")',
            'size_5' => '10\'3" width (96" trailer width)',
            'size_6' => '10\'6" width (99" trailer width)',
            'size_7' => '10\'9" width (102" trailer width)',
            'custom' => 'Custom Size (price x total sq ft)',
        );

        echo '<div class="custom-curtain-options">';
        echo '<div id="curtain_options" class="form-group curtain-options" style="display: block;">';

        // Price Display
        echo '<div id="curtain_price_display" style="margin-top: 10px;">
                <strong>Price: </strong><span id="curtain_price">$0.00</span>
              </div>';

        // Width/Size Options
        if (!empty($curtain_size)) {
            echo '<div class="form-group curtain-size">
                    <label for="curtain_size">Linear Ft. Width:</label>
                    <select id="curtain_size" name="curtain_size">';
            foreach ($curtain_size as $key) {
                if (isset($predefined_size_options[$key])) {
                    echo '<option value="' . esc_attr($key) . '">' . esc_html($predefined_size_options[$key]) . '</option>';
                }
            }
            echo '</select></div>';

            // Custom Width
            echo '<div class="form-group curtain-custom-size-fields" style="display: ' . (in_array('custom', $curtain_size) ? 'block' : 'none') . ';">
                    <label for="custom_width">Linear Ft. Length:</label>
                    <input type="number" id="custom_width" name="custom_width" value="' . esc_attr($curtain_custom_width) . '" min="0" step="0.1">
                 </div>';

            // Curtain Fabric
            if (!empty($curtain_material)) {
                echo '<div class="form-group curtain-material">
                        <label for="curtain_material">Curtain Fabric:</label>
                        <select id="curtain_material" name="curtain_material">';
                foreach ($curtain_material as $key) {
                    if (isset($predefined_materials[$key])) {
                        echo '<option value="' . esc_attr($key) . '">' . esc_html($predefined_materials[$key]) . '</option>';
                    }
                }
                echo '</select></div>';
            }
        }

        // If Product type is rollover_tarps
        if ($product_type === 'rollover_tarps') {
            // Curtain Length
            echo '<div class="form-group curtain-length">
                    <label for="curtain_length">Length (ft):</label>
                    <select id="curtain_length" name="curtain_length">';
            for ($i = 11; $i <= 50; $i++) {
                echo '<option value="' . esc_attr($i) . '" ' . selected($curtain_length, $i, false) . '>' . esc_html($i) . '</option>';
            }
            echo '</select></div>';

            // Electric System
            echo '<div class="form-group electric-system">
                    <label for="electric_system">Will this tarp be used in an electric system?</label>
                    <select id="electric_system" name="electric_system">
                        <option value="no" ' . selected($electric_system, 'no', false) . '>No</option>
                        <option value="yes" ' . selected($electric_system, 'yes', false) . '>Yes</option>
                    </select>
                  </div>';

            // Precise Length
            echo '<div class="form-group precise-length">
                    <label for="precise_length">Precise Length (in inches):</label>
                    <input type="number" id="precise_length" name="precise_length" value="' . esc_attr($precise_length) . '" min="0" step="0.1">
                    <p cl>Examples: If your tarp length is 42 ft 7 inches (42’7”) then select a 43’ length tarp from the dropdown above and enter either 42ft 7in or 42’7” into this field.  If your actual length happens to be 42’ even then type n/a or a zero in the precise length field.</p>
                 </div>';

            // Tarp Color
            echo '<div class="form-group tarp-color">
                    <label for="tarp_color">Tarp Color:</label>
                    <input type="text" id="tarp_color" name="tarp_color" value="' . esc_attr($tarp_color) . '">
                    <p>Colors Available:</p>
                    <p>18oz: Black, White, Gray, Royal Blue, Red, Tan, Purple, Green, Orange, and Yellow</p>
                    <p>22oz: Black, White, Royal Blue, and Red</p>
                  </div>';

            
        }

        // Curtain Hem
        if ($product_type === 'livestock_curtains') {
            echo '<div class="form-group curtain-addons">
                    <input type="checkbox" id="second_hem" name="second_hem" value="yes"' . ($second_hem == 'yes' ? ' checked' : '') . '>
                    <label for="second_hem">Add a second hem:</label>
                  </div>';

            echo '<div class="form-group curtain-addons">
                    <input type="checkbox" id="pipe_pocket" name="pipe_pocket" value="yes"' . ($pipe_pocket == 'yes' ? ' checked' : '') . '>
                    <label for="pipe_pocket">Add a Pipe Pocket:</label>
                  </div>';

            echo '<div class="form-group curtain-addons">
                    <input type="checkbox" id="webbing_reinforcement" name="webbing_reinforcement" value="yes"' . ($webbing_reinforcement == 'yes' ? ' checked' : '') . '>
                    <label for="webbing_reinforcement">2″ Webbing Reinforcement:</label>
                  </div>';
        }

        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
add_action('woocommerce_before_add_to_cart_button', 'custom_curtain_options_add_to_product');
?>
