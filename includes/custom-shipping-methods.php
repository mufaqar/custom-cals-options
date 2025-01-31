<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add this to custom-shipping-methods.php
class WC_Shipping_Free_Shipping_Label extends WC_Shipping_Method {
    public function __construct() {
        $this->id = 'free_shipping_label';
        $this->method_title = __('Free Shipping Label', 'custom-expiry-date-calculator');
        $this->method_description = __('Receive a free shipping label via email (printer required).', 'custom-expiry-date-calculator');
        $this->enabled = 'yes';
        $this->title = __('Free Shipping Label', 'custom-expiry-date-calculator');
        $this->init();
    }

    public function init() {
        $this->init_form_fields();
        $this->init_settings();
        $this->enabled = $this->get_option('enabled');
        $this->title = $this->get_option('title');
        add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
    }

    public function init_form_fields() {
        $this->form_fields = array(
            'enabled' => array(
                'title' => __('Enable/Disable', 'custom-expiry-date-calculator'),
                'type' => 'checkbox',
                'label' => __('Enable this shipping method', 'custom-expiry-date-calculator'),
                'default' => 'yes',
            ),
            'title' => array(
                'title' => __('Method Title', 'custom-expiry-date-calculator'),
                'type' => 'text',
                'description' => __('This controls the title which the user sees during checkout.', 'custom-expiry-date-calculator'),
                'default' => __('Free Shipping Label', 'custom-expiry-date-calculator'),
            ),
        );
    }
}