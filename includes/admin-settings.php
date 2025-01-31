<?php


// Add this to your admin-settings.php file
function custom_user_approval_admin_page() {
    ?>
    <div class="wrap">
        <h1>User Approvals</h1>
        <?php
        if (isset($_GET['action']) && isset($_GET['user_id'])) {
            $user_id = intval($_GET['user_id']);
            if ($_GET['action'] === 'approve') {
                update_user_meta($user_id, 'account_status', 'approved');
                echo '<div class="notice notice-success"><p>User approved successfully.</p></div>';
            } elseif ($_GET['action'] === 'reject') {
                update_user_meta($user_id, 'account_status', 'rejected');
                echo '<div class="notice notice-error"><p>User rejected.</p></div>';
            }
        }

        // Display pending users
        $pending_users = get_users(array(
            'meta_key' => 'account_status',
            'meta_value' => 'pending',
            'fields' => array('ID', 'user_email', 'display_name'),
        ));

        if (!empty($pending_users)) {
            echo '<table class="wp-list-table widefat fixed striped">';
            echo '<thead><tr><th>Name</th><th>Email</th><th>Actions</th></tr></thead>';
            echo '<tbody>';
            foreach ($pending_users as $user) {
                echo '<tr>';
                echo '<td>' . esc_html($user->display_name) . '</td>';
                echo '<td>' . esc_html($user->user_email) . '</td>';
                echo '<td>';
                echo '<a href="' . admin_url('admin.php?page=custom_user_approval&action=approve&user_id=' . $user->ID) . '">Approve</a> | ';
                echo '<a href="' . admin_url('admin.php?page=custom_user_approval&action=reject&user_id=' . $user->ID) . '">Reject</a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<p>No pending users.</p>';
        }
        ?>
    </div>
    <?php
}

function custom_user_approval_menu() {
    add_menu_page(
        'User Approvals',
        'User Approvals',
        'manage_options',
        'custom_user_approval',
        'custom_user_approval_admin_page',
        'dashicons-groups',
        6
    );
}
add_action('admin_menu', 'custom_user_approval_menu');

// Add this to your cart-checkout.php file
function custom_save_payment_methods($order_id) {
    if (isset($_POST['payment_method'])) {
        $payment_method = sanitize_text_field($_POST['payment_method']);
        update_user_meta(get_current_user_id(), 'preferred_payment_method', $payment_method);
    }
}
add_action('woocommerce_checkout_update_order_meta', 'custom_save_payment_methods');

function custom_checkout_payment_method_field($checkout) {
    woocommerce_form_field('payment_method', array(
        'type' => 'select',
        'class' => array('form-row-wide'),
        'label' => __('Preferred Payment Method'),
        'options' => array(
            'check' => __('Check'),
            'ach' => __('Bank Transfer (ACH)'),
            'wire' => __('Wire Transfer'),
            'paypal' => __('PayPal'),
            'zelle' => __('Zelle'),
            'venmo' => __('Venmo'),
            'cashapp' => __('CashApp'),
            'chime' => __('Chime'),
        ),
        'required' => true,
    ), $checkout->get_value('payment_method'));
}
add_action('woocommerce_after_order_notes', 'custom_checkout_payment_method_field');












function custom_curtain_options_product_custom_fields() {
    global $post;
    $product_id = $post->ID;

    $predefined_materials = array(
        '15_oz' => '15oz',
        '18_oz' => '18oz',
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
    $product_type = get_post_meta($product_id, '_product_type', true);

    echo '<div class="options_group">';

    woocommerce_wp_select(array(
        'id' => '_product_type',
        'label' => __('Product Type', 'custom-curtain-options'),
        'options' => array(
            'livestock_curtains' => __('Livestock Curtains', 'custom-curtain-options'),
            'rollover_tarps' => __('Rollover Tarps', 'custom-curtain-options'),
        ),
        'value' => $product_type,
        'desc_tip' => true,
    ));

  

  
    

    echo '</div>';
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            function toggleFieldsByProductType() {
                var selectedProductType = $('#_product_type').val();
                if (selectedProductType === 'livestock_curtains' || selectedProductType === 'rollover_tarps') {
                    $('#_curtain_hem_field, #_second_hem_field, #_pipe_pocket_field, #_webbing_reinforcement_field, #_additional_details_field, #_electric_system_field, #_curtain_length_field').hide();
                } else {
                    $('#_curtain_length_field').show();
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


// Add this to your custom-options.php or expiry-date-calculator.php file
function custom_check_user_login_before_add_to_cart() {
    if (!is_user_logged_in()) {
        echo '<p>You must be logged in to add products to your cart. <a href="' . wp_login_url(get_permalink()) . '">Login here</a>.</p>';
        return; // Stop further execution
    }
}
add_action('woocommerce_before_add_to_cart_button', 'custom_check_user_login_before_add_to_cart');