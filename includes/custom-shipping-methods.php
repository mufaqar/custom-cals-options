<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register custom shipping methods.
 */
add_action('woocommerce_shipping_init', 'register_custom_shipping_methods');

function register_custom_shipping_methods() {
    class WC_Shipping_Free_Shipping_Label extends WC_Shipping_Method {
        public function __construct() {
            $this->id                 = 'free_shipping_label';
            $this->method_title       = __('Free Shipping Label', 'custom-expiry-date-calculator');
            $this->method_description = __('Receive a free shipping label via email (printer required).', 'custom-expiry-date-calculator');
            $this->enabled            = 'yes';
            $this->title              = __('Free Shipping Label', 'custom-expiry-date-calculator');
            $this->init();
        }

        public function init() {
            $this->init_form_fields();
            $this->init_settings();

            $this->enabled = $this->get_option('enabled');
            $this->title   = $this->get_option('title');

            add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
        }
    }

    class WC_Shipping_Mail_Boxes_Reimbursed extends WC_Shipping_Method {
        public function __construct() {
            $this->id                 = 'mail_boxes_reimbursed';
            $this->method_title       = __('Mail Boxes Yourself', 'custom-expiry-date-calculator');
            $this->method_description = __('Mail the boxes yourself and be reimbursed for shipping.', 'custom-expiry-date-calculator');
            $this->enabled            = 'yes';
            $this->title              = __('Mail Boxes Yourself', 'custom-expiry-date-calculator');
            $this->init();
        }

        public function init() {
            $this->init_form_fields();
            $this->init_settings();

            $this->enabled = $this->get_option('enabled');
            $this->title   = $this->get_option('title');

            add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
        }
    }

    class WC_Shipping_Free_Shipping_Kit extends WC_Shipping_Method {
        public function __construct() {
            $this->id                 = 'free_shipping_kit';
            $this->method_title       = __('Free Shipping Kit', 'custom-expiry-date-calculator');
            $this->method_description = __('Receive a free Shipping Kit.', 'custom-expiry-date-calculator');
            $this->enabled            = 'yes';
            $this->title              = __('Free Shipping Kit', 'custom-expiry-date-calculator');
            $this->init();
        }

        public function init() {
            $this->init_form_fields();
            $this->init_settings();

            $this->enabled = $this->get_option('enabled');
            $this->title   = $this->get_option('title');

            add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
        }
    }
}

/**
 * Add the custom shipping methods to WooCommerce.
 */
add_filter('woocommerce_shipping_methods', 'add_custom_shipping_methods');

function add_custom_shipping_methods($methods) {
    $methods['free_shipping_label'] = 'WC_Shipping_Free_Shipping_Label';
    $methods['mail_boxes_reimbursed'] = 'WC_Shipping_Mail_Boxes_Reimbursed';
    $methods['free_shipping_kit'] = 'WC_Shipping_Free_Shipping_Kit';
    return $methods;
}
