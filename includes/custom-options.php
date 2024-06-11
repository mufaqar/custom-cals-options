<?php
// Add custom curtain options to product pages
function custom_curtain_options_add_to_product() {
    global $product;

    if ($product->is_type('simple')) {
        echo '<div class="custom-curtain-options">';
         // Price Display
         echo '<div id="curtain_price_display" style="margin-top: 10px;">
                    <strong>Price: </strong><span id="curtain_price">$0.00</span>
                </div>';

        // Curtain Material
        echo '<div class="curtain-material">
                <label for="curtain_material">Choose Curtain Material:</label>
                <select id="curtain_material" name="curtain_material">
                    <option value="15_clear">15oz Clear</option>
                    <option value="18_white">18oz White</option>
                </select>
              </div>';

        // Width/Size Options
        echo '<div class="curtain-size">
                <label for="curtain_size">Choose a width/size option:</label>
                <select id="curtain_size" name="curtain_size">
                    <option value="5_3_58_4_57">5\' with 1 3" Hem (58") or 4" Hem (57")</option>
                    <option value="6_3_69_4_68">6\' with 1 3" Hem (69") or 4" Hem (68")</option>
                    <option value="9_3_105_4_104">9\' with 1 3" Hem (105") or 4" Hem (104")</option>
                    <option value="12_3_141_4_140">12\' with 1 3" Hem (141") or 4" Hem (140")</option>
                    <option value="custom">Custom Size (price x total sq ft)</option>
                </select>
                <div id="curtain_size_custom" style="display:none;">
                    <div>
                    <label for="custom_length">Enter Length (ft):</label>
                    <input type="number" id="custom_length" name="custom_length" min="1">
                    </div><div>
                    <label for="custom_width">Enter Width (ft):</label>
                    <input type="number" id="custom_width" name="custom_width" min="1"> </div>
                </div>
              </div>';

       

        // Hem Selection
        echo '<div class="curtain-hem">
                <label for="curtain_hem">Choose a hem:</label>
                <select id="curtain_hem" name="curtain_hem">
                    <option value="3_hem">3" Hem</option>
                    <option value="4_hem">4" Hem</option>
                </select>
              </div>';

        // Curtain Optional Add-ons
        echo '<div class="curtain-addons">
                <label>Add a second hem:</label>
                <select id="second_hem" name="second_hem">
                    <option value="none">None</option>
                    <option value="3_hem">3" Hem</option>
                    <option value="4_hem">4" Hem</option>
                </select>
                <label>Add a Pipe Pocket:</label>
                <select id="pipe_pocket" name="pipe_pocket">
                    <option value="none">None</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
                <label for="webbing_reinforcement">Add Webbing Reinforcement:</label>
                <input type="checkbox" id="webbing_reinforcement" name="webbing_reinforcement" value="yes">
              </div>';

        // Additional details/requests
        echo '<div class="additional-details">
                <label for="additional_details">Additional details/requests:</label>
                <textarea id="additional_details" name="additional_details" rows="4" cols="50"></textarea>
              </div>';

        echo '</div>';
    }
}
add_action('woocommerce_before_add_to_cart_button', 'custom_curtain_options_add_to_product');