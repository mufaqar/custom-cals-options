<?php

function custom_curtain_options_add_to_product() {
    global $product;

    if ($product->is_type('simple')) {
        $product_id = $product->get_id();
        $product_type = get_post_meta($product_id, '_product_type', true);
        $curtain_size = get_post_meta($product_id, '_curtain_size', true) ?: array();

        // LiveStock Material Options
        $livestock_materials = array(
            '15_oz' => '15oz',
            '18_oz' => '18oz',
        );
        // RollOver Material Options
        $rollover_materials = array(
            '18_oz' => '18oz',
            '22_oz' => '22oz'
        );

        // Size Options for LiveStock
        $livestock_size_options = array(
            'size_5' => '5\' with 1 3" Hem (58") or 4" Hem',
            'size_6' => '6\' with 1 3" Hem (69") or 4" Hem',
            'size_9' => '9\' with 1 3" Hem (105") or 4" Hem',
            'size_12' => '12\' with 1 3" Hem (141") or 4" Hem (140")',
            'custom' => 'Custom Size (price x total sq ft)',
        );
        // Size Options for Roll Over
        $rollover_size_options = array(
            'size_96' => '10\'3" width (96" trailer width)',
            'size_99' => '10\'6" width (99" trailer width)',
            'size_102' => '10\'9" width (102" trailer width)',
        );

        echo '<div class="custom-curtain-options">';
        echo '<div id="curtain_options" class="form-group curtain-options" style="display: block;">';

        // Price Display
        echo '<div id="curtain_price_display" style="margin-top: 10px;">
                <strong>Price: </strong><span id="curtain_price">$0.00</span>
              </div>';

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
                    <p class="hint">Examples: If your tarp length is 42 ft 7 inches (42’7”) then select a 43’ length tarp from the dropdown above and enter either 42ft 7in or 42’7” into this field. If your actual length happens to be 42’ even, then type n/a or a zero in the precise length field.</p>
                 </div>';

            // Tarp Color
            echo '<div class="form-group tarp-color">
                    <label for="tarp_color">Tarp Color:</label>
                    <input type="text" id="tarp_color" name="tarp_color" value="' . esc_attr($tarp_color) . '">
                    <p>Colors Available:</p>
                    <p class="hint">18oz: Black, White, Gray, Royal Blue, Red, Tan, Purple, Green, Orange, and Yellow</p>
                    <p class="hint">22oz: Black, White, Royal Blue, and Red</p>
                  </div>';
        }

        // If Product type is livestock_curtains
        if ($product_type === 'livestock_curtains') {
            // Width/Size Options
            echo '<div class="form-group curtain-size">
                    <label for="curtain_size">Linear Ft. Width:</label>
                    <select id="curtain_size" name="curtain_size">';
            foreach ($livestock_size_options as $key => $label) {
                echo '<option value="' . esc_attr($key) . '">' . esc_html($label) . '</option>';
            }
            echo '</select></div>';

            // Custom Width and Height with Feet and Inches
            echo '<div class="curtain-custom-size-fields">';
            echo '<div class="form-group curtain_custom_width">
                    <label for="custom_width_feet">Linear Ft. Width:</label>
                    <input type="number" id="custom_width_feet" name="custom_width_feet" value="" placeholder="Feet">
                    <input type="number" id="custom_width_inches" name="custom_width_inches" value="" placeholder="Inches">
                 </div>';

            echo '<div class="form-group curtain_custom_height">
                    <label for="custom_height_feet">Linear Ft. Length:</label>
                    <input type="number" id="custom_height_feet" name="custom_height_feet" value="" placeholder="Feet">
                    <input type="number" id="custom_height_inches" name="custom_height_inches" value="" placeholder="Inches">
                 </div>';
            echo '</div>';

            // Curtain Fabric
            echo '<div class="form-group curtain-material">
                    <label for="curtain_material">Curtain Fabric:</label>
                    <select id="curtain_material" name="curtain_material">';
            foreach ($livestock_materials as $key => $label) {
                echo '<option value="' . esc_attr($key) . '">' . esc_html($label) . '</option>';
            }
            echo '</select></div>';

            // Curtain Hem
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

            // Curtain Optional Add-ons
            echo '<div class="curtain-addons">';
            
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
            echo '</select> </div>';

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

            echo '<div class="form-group curtain-addons">
                    <input type="checkbox" id="webbing_reinforcement" name="webbing_reinforcement" value="yes">
                    <label for="webbing_reinforcement">2″ Webbing Reinforcement:</label>
                  </div>';
        }

        echo '</div>'; // End of curtain_options
        echo '</div>'; // End of custom-curtain-options
    }
}
add_action('woocommerce_before_add_to_cart_button', 'custom_curtain_options_add_to_product');
?>
