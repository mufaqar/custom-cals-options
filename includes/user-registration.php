<?php


function custom_user_registration_form() {
    if (is_user_logged_in()) {
        return '<p>You are already registered and logged in.</p>';
    }

    ob_start();
    ?>
    <form id="custom-registration-form" method="post">
        <label for="custom-user-name">Name:</label>
        <input type="text" name="custom_user_name" id="custom-user-name" required><br>

        <label for="custom-user-email">Email:</label>
        <input type="email" name="custom_user_email" id="custom-user-email" required><br>

        <label for="custom-user-phone">Phone Number:</label>
        <input type="tel" name="custom_user_phone" id="custom-user-phone" required><br>

        <label for="custom-user-address">Address:</label>
        <textarea name="custom_user_address" id="custom-user-address" required></textarea><br>

        <input type="submit" name="custom_register_submit" value="Register">
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_registration_form', 'custom_user_registration_form');



function custom_user_registration_process() {
    if (isset($_POST['custom_register_submit'])) {
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

            echo '<p>Thank you for registering! Your account is pending approval.</p>';
        } else {
            echo '<p>Error: ' . $user_id->get_error_message() . '</p>';
        }
    }
}
add_action('init', 'custom_user_registration_process');


