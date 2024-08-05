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

        // Predefined options
        $predefined_materials = array(
            '15_oz' => '15oz',
            '18_oz' => '18oz',
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

        // Show Electric System Question
        if ($product_type === 'rollover_tarps') {
            echo '<div class="electric-system">
                    <label for="electric_system">Will this tarp be used in an electric system?</label>
                    <select id="electric_system" name="electric_system">
                        <option value="no" ' . selected($electric_system, 'no', false) . '>No</option>
                        <option value="yes" ' . selected($electric_system, 'yes', false) . '>Yes</option>
                    </select>
                  </div>';

            // Curtain Length
            echo '<div class="form-field curtain-length">
                <label for="curtain_length">Length (ft):</label>
                <select id="curtain_length" name="curtain_length">';
            for ($i = 11; $i <= 50; $i++) {
                echo '<option value="' . esc_attr($i) . '" ' . selected($curtain_length, $i, false) . '>' . esc_html($i) . '</option>';
            }
            echo '</select></div>';
        }

        echo '<div id="curtain_options" style="display: block;">';

        // Price Display
        echo '<div id="curtain_price_display" style="margin-top: 10px;">
                <strong>Price: </strong><span id="curtain_price">$0.00</span>
              </div>';

        // Curtain Material
        if (!empty($curtain_material)) {
            echo '<div class="curtain-material">
                    <label for="curtain_material">Choose Curtain Material:</label>
                    <select id="curtain_material" name="curtain_material">';
            foreach ($curtain_material as $key) {
                if (isset($predefined_materials[$key])) {
                    echo '<option value="' . esc_attr($key) . '">' . esc_html($predefined_materials[$key]) . '</option>';
                }
            }
            echo '</select></div>';
        }

        // Width/Size Options
        if (!empty($curtain_size)) {
            echo '<div class="curtain-size">
                    <label for="curtain_size">Choose a width/size option:</label>
                    <select id="curtain_size" name="curtain_size">';
            foreach ($curtain_size as $key) {
                if (isset($predefined_size_options[$key])) {
                    echo '<option value="' . esc_attr($key) . '">' . esc_html($predefined_size_options[$key]) . '</option>';
                }
            }
            echo '</select></div>';

            // Custom Width
            echo '<div class="form-field curtain-custom-size-fields" style="display: ' . (in_array('custom', $curtain_size) ? 'block' : 'none') . ';">
                <label for="custom_width">Custom Width (ft):</label>
                <input type="number" id="custom_width" name="custom_width" value="' . esc_attr($curtain_custom_width) . '" min="0" step="0.1">
                <span id="custom_width_inches" class="custom-size-inches">--</span>
            </div>';

            // Custom Height
            echo '<div class="form-field curtain-custom-size-fields" style="display: ' . (in_array('custom', $curtain_size) ? 'block' : 'none') . ';">
                <label for="custom_height">Custom Height (ft):</label>
                <input type="number" id="custom_height" name="custom_height" value="' . esc_attr($curtain_custom_height) . '" min="0" step="0.1">
                <span id="custom_height_inches" class="custom-size-inches">--</span>
            </div>';
        }

        // Curtain Hem
        if ($curtain_hem && $product_type === 'livestock_curtains') {
            $hem_options = array(
                '3_hem' => '3" Hem',
                '4_hem' => '4" Hem',
            );
            echo '<div class="curtain-hem">
                    <label for="curtain_hem">Choose a hem:</label>
                    <select id="curtain_hem" name="curtain_hem">';
            foreach ($hem_options as $key => $value) {
                $selected = ($curtain_hem == $key) ? 'selected' : '';
                echo '<option value="' . esc_attr($key) . '" ' . $selected . '>' . esc_html($value) . '</option>';
            }
            echo '</select></div>';
        }

        // Curtain Optional Add-ons
        if ($product_type === 'livestock_curtains' || $product_type === 'rollover_tarps') {
            echo '<div class="curtain-addons">';
            if ($second_hem && $product_type === 'livestock_curtains') {
                $second_hem_options = array(
                    'none' => 'None',
                    '3_hem' => '3" Hem',
                    '4_hem' => '4" Hem',
                );
                echo '<label>Add a second hem:</label>
                      <select id="second_hem" name="second_hem">';
                foreach ($second_hem_options as $key => $value) {
                    $selected = ($second_hem == $key) ? 'selected' : '';
                    echo '<option value="' . esc_attr($key) . '" ' . $selected . '>' . esc_html($value) . '</option>';
                }
                echo '</select>';
            }
            if ($pipe_pocket && $product_type === 'rollover_tarps') {
                $pipe_pocket_options = array(
                    'none' => 'None',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                );
                echo '<label>Add a Pipe Pocket:</label>
                      <select id="pipe_pocket" name="pipe_pocket">';
                foreach ($pipe_pocket_options as $key => $value) {
                    $selected = ($pipe_pocket == $key) ? 'selected' : '';
                    echo '<option value="' . esc_attr($key) . '" ' . $selected . '>' . esc_html($value) . '</option>';
                }
                echo '</select>';
            }
            if ($webbing_reinforcement && $product_type === 'rollover_tarps') {
                echo '<label for="webbing_reinforcement">Add Webbing Reinforcement:</label>
                      <input type="checkbox" id="webbing_reinforcement" name="webbing_reinforcement" value="yes"' . ($webbing_reinforcement == 'yes' ? ' checked' : '') . '>';
            }
            echo '</div>';
        }

        // Additional details/requests
        echo '<div class="additional-details">
                <label for="additional_details">Additional details/requests:</label>
                <textarea id="additional_details" name="additional_details" rows="4" cols="50">' . esc_textarea($additional_details) . '</textarea>
              </div>';

        echo '</div>';
        echo '</div>';
    }
}
add_action('woocommerce_before_add_to_cart_button', 'custom_curtain_options_add_to_product');
