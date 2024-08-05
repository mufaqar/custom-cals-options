<?php

function custom_curtain_options_product_custom_fields() {
    global $post;
    $product_id = $post->ID;

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

    echo '<div class="options_group">';

    // Product Type Dropdown
    woocommerce_wp_select(
        array(
            'id' => '_product_type',
            'label' => __('Product Type', 'custom-curtain-options'),
            'options' => array(
                'livestock_curtains' => __('Livestock Curtains', 'custom-curtain-options'),
                'rollover_tarps' => __('Rollover Tarps', 'custom-curtain-options'),
            ),
            'value' => $product_type,
            'desc_tip' => true,
        )
    );

    woocommerce_wp_select(
        array(
            'id' => '_electric_system',
            'label' => __('Will this tarp be used in an electric system?', 'custom-curtain-options'),
            'options' => array(
                'no' => __('No', 'custom-curtain-options'),
                'yes' => __('Yes', 'custom-curtain-options'),
            ),
            'value' => $electric_system,
            'desc_tip' => true,
        )
    );

    woocommerce_wp_select(
        array(
            'id' => '_curtain_length',
            'label' => __('Length (ft)', 'custom-curtain-options'),
            'options' => array_combine(range(11, 50), range(11, 50)),
            'value' => $curtain_length,
            'desc_tip' => true,
            'custom_attributes' => array('hidden' => 'hidden') // Initially hidden
        )
    );

    echo '<p class="form-field"><label for="_curtain_material">' . __('Curtain Material Options', 'custom-curtain-options') . '</label><br>';
    echo '<select id="_curtain_material" name="_curtain_material[]" multiple="multiple" style="width: 100%; height: auto;">';
    foreach ($predefined_materials as $key => $label) {
        $selected = in_array($key, $curtain_material) ? 'selected' : '';
        echo '<option value="' . esc_attr($key) . '" ' . $selected . '>' . esc_html($label) . '</option>';
    }
    echo '</select></p>';

    echo '<p class="form-field"><label for="_curtain_size">' . __('Curtain Size Options', 'custom-curtain-options') . '</label><br>';
    echo '<select id="_curtain_size" name="_curtain_size[]" multiple="multiple" style="width: 100%; height: auto;">';
    foreach ($predefined_size_options as $key => $label) {
        $selected = in_array($key, $curtain_size) ? 'selected' : '';
        echo '<option value="' . esc_attr($key) . '" ' . $selected . '>' . esc_html($label) . '</option>';
    }
    echo '</select></p>';

    echo '<p class="form-field curtain-custom-size-fields" style="display: ' . (in_array('custom', $curtain_size) ? 'block' : 'none') . ';">
    <label for="_curtain_custom_width">' . __('Custom Width (ft)', 'custom-curtain-options') . '</label>
    <input type="number" id="_curtain_custom_width" name="_curtain_custom_width" value="' . esc_attr($curtain_custom_width) . '" min="0" step="0.1">
    <span id="custom_width_inches" class="custom-size-inches">--</span>
</p>';

    echo '<p class="form-field curtain-custom-size-fields" style="display: ' . (in_array('custom', $curtain_size) ? 'block' : 'none') . ';">
    <label for="_curtain_custom_height">' . __('Custom Height (ft)', 'custom-curtain-options') . '</label>
    <input type="number" id="_curtain_custom_height" name="_curtain_custom_height" value="' . esc_attr($curtain_custom_height) . '" min="0" step="0.1">
    <span id="custom_height_inches" class="custom-size-inches">--</span>
</p>';

    woocommerce_wp_select(
        array(
            'id' => '_curtain_hem',
            'label' => __('Curtain Hem Options', 'custom-curtain-options'),
            'options' => array(
                '3_hem' => __('3" Hem', 'custom-curtain-options'),
                '4_hem' => __('4" Hem', 'custom-curtain-options'),
            ),
            'value' => $curtain_hem,
            'desc_tip' => true,
        )
    );

    woocommerce_wp_select(
        array(
            'id' => '_second_hem',
            'label' => __('Second Hem Options', 'custom-curtain-options'),
            'options' => array(
                'none' => __('None', 'custom-curtain-options'),
                '3_hem' => __('3" Hem', 'custom-curtain-options'),
                '4_hem' => __('4" Hem', 'custom-curtain-options'),
            ),
            'value' => $second_hem,
            'desc_tip' => true,
        )
    );

    woocommerce_wp_select(
        array(
            'id' => '_pipe_pocket',
            'label' => __('Pipe Pocket Options', 'custom-curtain-options'),
            'options' => array(
                'none' => __('None', 'custom-curtain-options'),
                '1' => __('1', 'custom-curtain-options'),
                '2' => __('2', 'custom-curtain-options'),
                '3' => __('3', 'custom-curtain-options'),
            ),
            'value' => $pipe_pocket,
            'desc_tip' => true,
        )
    );

    woocommerce_wp_checkbox(
        array(
            'id' => '_webbing_reinforcement',
            'label' => __('Webbing Reinforcement', 'custom-curtain-options'),
            'value' => $webbing_reinforcement,
            'desc_tip' => true,
        )
    );

    woocommerce_wp_textarea_input(
        array(
            'id' => '_additional_details',
            'label' => __('Additional Details', 'custom-curtain-options'),
            'value' => $additional_details,
            'desc_tip' => true,
        )
    );

    echo '</div>';

    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            function toggleFieldsByProductType() {
                var selectedProductType = $('#_product_type').val();
                if (selectedProductType === 'livestock_curtains') {
                    $('#_curtain_hem_field, #_second_hem_field').show();
                    $('#_pipe_pocket_field, #_webbing_reinforcement_field, #_electric_system_field, #_curtain_length_field').hide();
                } else if (selectedProductType === 'rollover_tarps') {
                    $('#_curtain_hem_field, #_second_hem_field').hide();
                    $('#_pipe_pocket_field, #_webbing_reinforcement_field, #_electric_system_field, #_curtain_length_field').show();
                } else {
                    $('#_curtain_hem_field, #_second_hem_field, #_pipe_pocket_field, #_webbing_reinforcement_field, #_electric_system_field, #_curtain_length_field').show();
                }
            }

            $('#_product_type').change(function() {
                toggleFieldsByProductType();
            }).change();

            $('#_curtain_size').change(function() {
                if ($('#_curtain_size option[value="custom"]').is(':selected')) {
                    $('.curtain-custom-size-fields').show();
                } else {
                    $('.curtain-custom-size-fields').hide();
                }
            }).change();
        });
    </script>
    <?php
}
add_action('woocommerce_product_options_general_product_data', 'custom_curtain_options_product_custom_fields');

function custom_curtain_options_save_product_custom_fields($post_id) {
    $fields = array(
        '_curtain_hem',
        '_second_hem',
        '_pipe_pocket',
        '_webbing_reinforcement',
        '_additional_details',
        '_electric_system',
        '_curtain_custom_width',
        '_curtain_custom_height',
        '_product_type',
        '_curtain_length',
    );

    if (isset($_POST['_curtain_material'])) {
        update_post_meta($post_id, '_curtain_material', array_map('sanitize_text_field', $_POST['_curtain_material']));
    } else {
        delete_post_meta($post_id, '_curtain_material');
    }

    if (isset($_POST['_curtain_size'])) {
        update_post_meta($post_id, '_curtain_size', array_map('sanitize_text_field', $_POST['_curtain_size']));
    } else {
        delete_post_meta($post_id, '_curtain_size');
    }

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        } else {
            delete_post_meta($post_id, $field);
        }
    }
}
add_action('woocommerce_process_product_meta', 'custom_curtain_options_save_product_custom_fields');
