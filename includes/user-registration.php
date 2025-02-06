<?php


function prevent_pending_users_login($user, $username, $password) {
    if ($user instanceof WP_User) {
        $account_status = get_user_meta($user->ID, 'account_status', true);
        
        if ($account_status === 'pending') {
            return new WP_Error('pending_approval', 'Your account is pending approval. Please wait for an administrator to approve your account.');
        }
    }
    return $user;
}
add_filter('authenticate', 'prevent_pending_users_login', 30, 3);


function add_custom_user_column($columns) {
    $columns['account_status'] = 'Account Status';
    return $columns;
}
add_filter('manage_users_columns', 'add_custom_user_column');

function show_custom_user_column_data($value, $column_name, $user_id) {
    if ($column_name === 'account_status') {
        $status = get_user_meta($user_id, 'account_status', true);
        return ($status === 'pending') ? 'Pending Approval' : 'Active';
    }
    return $value;
}
add_filter('manage_users_custom_column', 'show_custom_user_column_data', 10, 3);


function add_approve_user_action($actions, $user_object) {
    $status = get_user_meta($user_object->ID, 'account_status', true);

    if ($status === 'pending') {
        $approve_url = add_query_arg([
            'action' => 'approve_user',
            'user_id' => $user_object->ID,
            'security' => wp_create_nonce('approve_user_nonce')
        ], admin_url('users.php'));

        $actions['approve_user'] = '<a href="' . esc_url($approve_url) . '">Approve</a>';
    }

    return $actions;
}
add_filter('user_row_actions', 'add_approve_user_action', 10, 2);

function approve_pending_user() {
    if (isset($_GET['action']) && $_GET['action'] === 'approve_user' && isset($_GET['user_id']) && wp_verify_nonce($_GET['security'], 'approve_user_nonce')) {
        $user_id = intval($_GET['user_id']);

        if ($user_id) {
            update_user_meta($user_id, 'account_status', 'active');

            // Notify user via email
            $user = get_userdata($user_id);
            $email = $user->user_email;
            $subject = 'Your Account Has Been Approved';
            $message = "Dear " . $user->display_name . ",\n\nYour account has been approved. You can now log in to our website.\n\nLogin here: " . wp_login_url();
            wp_mail($email, $subject, $message);
        }
    }
}
add_action('admin_init', 'approve_pending_user');


// Add a user meta field in the admin panel for discount price
function add_global_discount_price_user_meta($user) {
    ?>
    <h3>Global Discount Price</h3>
    <table class="form-table">
        <tr>
            <th><label for="global_discount_price">Discount Price</label></th>
            <td>
                <input type="number" name="global_discount_price" id="global_discount_price" value="<?php echo esc_attr(get_the_author_meta('global_discount_price', $user->ID)); ?>" step="0.01">
                <p class="description">Enter the discount price that applies to all products for this user.</p>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'add_global_discount_price_user_meta');
add_action('edit_user_profile', 'add_global_discount_price_user_meta');

// Save user meta data
function save_global_discount_price_user_meta($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    if (isset($_POST['global_discount_price'])) {
        update_user_meta($user_id, 'global_discount_price', sanitize_text_field($_POST['global_discount_price']));
    }
}
add_action('personal_options_update', 'save_global_discount_price_user_meta');
add_action('edit_user_profile_update', 'save_global_discount_price_user_meta');


function display_global_discount_price($price, $product) {
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $discount_price = get_user_meta($user_id, 'global_discount_price', true);

        if (!empty($discount_price) && is_numeric($discount_price)) {
            $price = '<del>' . wc_price($product->get_regular_price()) . '</del> <ins>' . wc_price($discount_price) . '</ins>';
        }
    }
    return $price;
}
add_filter('woocommerce_get_price_html', 'display_global_discount_price', 10, 2);







function custom_user_registration_form() {
    if (is_user_logged_in()) {
        return '<p>You are already registered and logged in.</p>';
    }

    ob_start();
    ?>
    <div class="alert" id="alert-message"></div>
    <form id="custom-registration-form">
        <?php wp_nonce_field('custom_user_registration', 'custom_registration_nonce'); ?>
        
        <label for="custom-user-name">Name:</label>
        <input type="text" name="custom_user_name" id="custom-user-name" required><br>

        <label for="custom-user-email">Email:</label>
        <input type="email" name="custom_user_email" id="custom-user-email" required><br>

        <label for="custom-user-phone">Phone Number:</label>
        <input type="tel" name="custom_user_phone" id="custom-user-phone" required><br>

        <label for="custom-user-address">Address:</label>
        <textarea name="custom_user_address" id="custom-user-address" required></textarea><br>

        <button type="submit" id="register-button">Register</button>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_registration_form', 'custom_user_registration_form');


function custom_user_registration_process() {
    // Security check
    check_ajax_referer('custom_user_registration', 'security');

    if (isset($_POST['custom_user_email'])) {
        $username = sanitize_user($_POST['custom_user_email']); // Use email as username
        $email = sanitize_email($_POST['custom_user_email']);
        $password = wp_generate_password(); // Generate a random password
        $name = sanitize_text_field($_POST['custom_user_name']);
        $phone = sanitize_text_field($_POST['custom_user_phone']);
        $address = sanitize_textarea_field($_POST['custom_user_address']);

        // Create the user
        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            // Add custom user meta
            update_user_meta($user_id, 'phone_number', $phone);
            update_user_meta($user_id, 'address', $address);
            update_user_meta($user_id, 'account_status', 'pending'); // Set account status to pending

            // Send email to admin for approval
            $admin_email = get_option('admin_email');
            $subject = 'New User Registration Requires Approval';
            $message = "A new user has registered and is awaiting approval.\n\n";
            $message .= "Name: $name\n";
            $message .= "Email: $email\n";
            $message .= "Phone: $phone\n";
            $message .= "Address: $address\n";
            wp_mail($admin_email, $subject, $message);

            // Send email to user with login details
            $user_subject = 'Your Account Registration Details';
            $user_message = "Dear $name,\n\n";
            $user_message .= "Thank you for registering. Your account is currently pending approval.\n\n";
            $user_message .= "Once approved, you can log in using the following details:\n";
            $user_message .= "Email: $email\n";
            $user_message .= "Password: $password\n\n";
            $user_message .= "Login here: " . wp_login_url() . "\n\n";
            $user_message .= "Best regards,\nYour Website Team";

            wp_mail($email, $user_subject, $user_message);

            wp_send_json(array(
                'success' => true,
                'message' => 'Thank you for registering! Your account is pending approval. Check your email for login details.'
            ));
        } else {
            wp_send_json(array(
                'success' => false,
                'message' => 'Error: ' . $user_id->get_error_message()
            ));
        }
    } else {
        wp_send_json(array(
            'success' => false,
            'message' => 'Error: Invalid request!'
        ));
    }
    wp_die();
}
add_action('wp_ajax_custom_user_registration_process', 'custom_user_registration_process');
add_action('wp_ajax_nopriv_custom_user_registration_process', 'custom_user_registration_process');



function custom_redirect_wp_login() {
    $woo_login_url = wc_get_page_permalink('myaccount'); // WooCommerce My Account login page

    if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false && !is_admin()) {
        wp_redirect($woo_login_url);
        exit;
    }
}
add_action('init', 'custom_redirect_wp_login');


function custom_redirect_wp_logout() {
    wp_redirect(wc_get_page_permalink('myaccount'));
    exit;
}
add_action('wp_logout', 'custom_redirect_wp_logout');

function custom_login_form_links($link, $action, $redirect) {
    if ($action === 'lostpassword') {
        return wc_lostpassword_url(); // Redirects to WooCommerce lost password page
    }
    return $link;
}
add_filter('login_url', 'custom_login_form_links', 10, 3);

