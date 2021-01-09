<?php
/**
 *
 * WooCommerce Integration
 *
 * References
 *   - WoCommerce checkout fields
 *     https://docs.woocommerce.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
 *
 */

namespace TOT\Integrations\WooCommerce;

use function TOT\get_query_var;
use TOT\Settings;
use TOT\API_Request;
use TOT\User;
use WP_Error;
use TOT\Reasons;

class Checkout_Enabled extends Checkout
{

    public $verify_result = null;
    public $order_reputation_result = null;
    public $email_reputation_result = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_name()
    {
        return "Checkout_Enabled";
    }

    public function register_wordpress_hooks()
    {
        add_action('plugins_loaded', array($this, 'register_wordpress_hooks_after_load'));
    }

    public function register_wordpress_hooks_after_load()
    {
        if (!class_exists('WooCommerce')) {
            return;
        }

        /*
         * References:
         * - Checkout fields: https://docs.woocommerce.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
         * - Checkout hooks: https://businessbloomer.com/woocommerce-visual-hook-guide-checkout-page/
         * - Order methods: https://businessbloomer.com/woocommerce-easily-get-order-info-total-items-etc-from-order-object/
         * - WooCommerce hooks: https://premmerce.com/woocommerce-hooks-guide/
         * - WooCommerce (Docs) hooks: https://docs.woocommerce.com/wc-apidocs/hook-docs.html
         */

        // Shared across screens
        add_action('wp_enqueue_scripts', array($this, 'enqueue_javascript'));
        add_action('init', array($this, 'register_awaiting_verification_order_status'));
        add_filter('wc_order_statuses', array($this, 'add_awaiting_verification_to_order_statuses'));

        // Validation before order is complete
        add_action('woocommerce_after_order_notes', array($this, 'checkout_field_verification_acknowledgement'));
        add_action('woocommerce_checkout_process', array($this, 'checkout_field_validation'));


        // Validation after order is processed
        add_action('woocommerce_checkout_order_processed', array($this, 'process_order'), 99, 1);
        add_action('woocommerce_payment_complete', array($this, 'post_payment_status_check'), 10, 2);
        add_filter('woocommerce_cod_process_payment_order_status', array($this, 'post_payment_cod_status_check'), 10, 2);
        add_action('woocommerce_before_template_part', array($this, 'handle_order_complete_notice_and_modal'), 99, 4);
        add_filter('body_class', array($this, 'add_body_class'));

        // Verification results processing
        add_action('tot_webhook_success', array($this, 'default_autoprocess_webhook'), 10, 3);
        add_action('template_redirect', array($this, 'order_lookup_redirect'));

        // TODO - the old way.
        // add_filter('woocommerce_payment_complete_order_status', array($this, 'post_payment_status_check'), 10, 2);
        // add_action('woocommerce_order_status_changed', array($this, 'payment_post_processing_order_status'),10,3);
    }

    // This was for debugging.
    // add_action('woocommerce_order_status_changed', array($this, 'woocommerce_order_status_changed'), 10, 4);

//    public function woocommerce_order_status_changed($id, $status_transition_from, $status_transition_to, $that)
//    {
//        tot_log_debug("Saw transition from $status_transition_from to $status_transition_to that $that");
//    }

    public function add_body_class($classes)
    {

        if (function_exists('is_order_received_page') && is_order_received_page()) {

            $wcOrderKeyFromQuery = getWcOrderKeyFromQuery();
            if (!isset($wcOrderKeyFromQuery)) {
                return $classes;
            }

            $order_key = sanitize_text_field($wcOrderKeyFromQuery);
            $order_id = wc_get_order_id_by_order_key($order_key);

            $require_verification_at_checkout = $this->tot_is_verification_on_checkout_enabled();

            if (!$require_verification_at_checkout || $this->should_display_receipt($order_id)) {
                return $classes;
            }

            array_push($classes, 'tot-hide-receipt');
        }

        return $classes;

    }

    public function handle_order_complete_notice_and_modal($template_name, $template_path, $located, $args)
    {

        if (('checkout/thankyou.php' !== $template_name)) {
            return;
        }

        tot_log_as_html_comment("Running", "handle_order_complete_notice_and_modal");

        // TODO - should we just use WC->getOrder() here?
        $order = isset($args['order']) ? $args['order'] : '';

        if (!empty($order)) {
            $order = wc_get_order($order);
        } else {
            $order_id = Checkout::get_current_wc_order_id();
            $order = wc_get_order($order_id);
        }

        if (empty($order)) {
            tot_log_as_html_comment("empty_order", "Order is unavailable!!");
            return;
        }

        $this->verify($order, false, array($this, 'handle_verify_person_api_error'));
        $order_id = $order->get_id();
        $should_receipt_display_verification_prompt = $this->should_receipt_display_verification_prompt($order);

        if (!$should_receipt_display_verification_prompt) {
            tot_log_as_html_comment("should_receipt_display_verification_prompt", "false");
            return;
        }

        // We're displaying the popup so there's more to be done.
        $this->add_user_verification_notices($order_id);
        $this->display_reciept_summary_widget($order_id);
    }

    public function display_reciept_summary_widget($order_id)
    {

        $tot_transaction_id = get_post_meta($order_id, 'tot_transaction_id', true);

        echo do_shortcode(
            '[tot-wp-embed'
            . ' tot-widget="reputationSummary"'
            . ' tot-transaction-id="' . $tot_transaction_id . '"][/tot-wp-embed]'
        );

    }

    public function add_user_verification_notices($order_id)
    {

        if ($this->is_order_preapproved($order_id)) {
            tot_log_as_html_comment("add_user_verification_notices", "tot_order_is_whitelisted_message");
            $orderIsWhiteListed = apply_filters('tot_order_is_whitelisted_message', __('Thank you for being a valued customer! Your order has been submitted.', $this->text_domain));
            wc_add_notice(
                '<span class="tot-wc-order-validation">'
                . $orderIsWhiteListed
                . '</span>',
                'notice'
            );
            wc_print_notices();
            return;
        }

        if ($this->is_verification_complete($order_id)) {
            tot_log_as_html_comment("add_user_verification_notices", "tot_order_is_submitted");
            $orderIsWhiteListed = apply_filters('tot_order_is_completed', 'Thank you for being a valued customer! Your order has been submitted.');
            wc_add_notice(
                '<span class="tot-wc-order-validation">'
                . __($orderIsWhiteListed, $this->text_domain)
                . '</span>',
                'notice'
            );
            wc_print_notices();
            return;
        }

        if ($this->is_verification_info_submitted($order_id)) {
            tot_log_as_html_comment("add_user_verification_notices", "is_verification_info_submitted == true");
            wc_add_notice(
                '<span class="tot-wc-order-validation">'
                . __('Verification has been submitted and is under review', $this->text_domain)
                . '</span>',
                'notice'
            );
            wc_print_notices();

            return;

        } else {
            tot_log_as_html_comment("add_user_verification_notices", "Verification is required.");

            wc_add_notice(
                '<span class="tot-wc-order-validation">'
                . '<a data-tot-verification-required="true" data-tot-auto-open-modal="true" href="#tot_get_verified">'
                . __('Verification', $this->text_domain)
                . '</a> '
                . __(' is required before we can ship your order', $this->text_domain)
                . '</span>',
                'error'
            );
            wc_print_notices();
        }
    }

    public function handle_verify_person_api_error($response, $request = null, $url = null, $data = '')
    {
        return \TOT\API_Person::handle_verify_person_api_error($response, $request, $url, $data);
    }

    public function is_verification_info_submitted($order_id)
    {

        $reasons = $this->get_order_reputation_reasons($order_id, true);
        if (empty($reasons)) {
            return false;
        }

        if ($reasons->is_positive('govtIdPendingReview')) {
            return true;
        }

        return false;

    }

    public function get_order_whitelist_data($order_id = null)
    {
        return apply_filters('tot_order_whitelisted_data', false, $order_id);
    }

    public function register_awaiting_verification_order_status()
    {
        register_post_status(
            'wc-must-verify',
            array(
                'label' => _x('Awaiting Verification', 'Order status', $this->text_domain),
                'public' => true,
                'exclude_from_search' => false,
                'show_in_admin_all_list' => true,
                'show_in_admin_status_list' => true,
                'label_count' => _n_noop('Awaiting Verification <span class="count">(%s)</span>', 'Awaiting Verification <span class="count">(%s)</span>')
            )
        );
        register_post_status(
            'wc-needs-review',
            array(
                'label' => _x('Please Review', 'Order status', $this->text_domain),
                'public' => true,
                'exclude_from_search' => false,
                'show_in_admin_status_list' => true,
                'show_in_admin_all_list' => true,
                'label_count' => _n_noop('Ready for Review <span class="count">(%s)</span>', 'Ready for Review <span class="count">(%s)</span>')
            )
        );
    }

    public function add_awaiting_verification_to_order_statuses($order_statuses)
    {
        $new_order_statuses = array();
        // add new order status after processing
        foreach ($order_statuses as $key => $status) {
            if ('wc-processing' === $key) {
                $new_order_statuses['wc-must-verify'] = _x('Awaiting Verification', 'Order status', $this->text_domain);
                $new_order_statuses['wc-needs-review'] = _x('Ready for Review', 'Order status', $this->text_domain);
            }
            $new_order_statuses[$key] = $status;
        }
        return $new_order_statuses;
    }

    public function should_display_receipt($order_id)
    {

        if (!isset($order_id)) {
            return true;
        }

        $order = wc_get_order($order_id);

        if (!$order || is_wp_error($order)) {
            return true;
        }

        if (true !== $this->is_order_quarantined($order_id)) {
            return true;
        }

        if (!$this->is_verification_required_for_order($order_id)) {
            return true;
        }

        if ($this->is_verification_complete($order_id)) {
            return true;
        }

        if ($this->is_verification_info_submitted($order_id)) {
            return true;
        }

        return false;

    }

    public function is_verification_complete($order_id)
    {

        $reasons = $this->get_order_reputation_reasons($order_id);

        if (empty($reasons)) {
            return false;
        }

        if ($reasons->is_positive('ageVerified') || $reasons->is_positive('govtIdPositiveReview')) {
            return true;
        }

        return false;

    }

    public function get_order_reputation_reasons($order_id, $force_refresh = false)
    {

        $this->get_order_reputation($order_id, $force_refresh);

        if (is_wp_error($this->order_reputation_result)) {
            tot_display_error($this->order_reputation_result);
            return null;
        }

        if (!isset($this->order_reputation_result->reasons)) {
            return null;
        }

        return new Reasons($this->order_reputation_result->reasons);

    }

    public function get_email_reputation($order_id, $force_refresh = false)
    {
        if (empty($this->email_reputation_result) || $force_refresh) {
            $current_user_id = get_current_user_id();
            $order = wc_get_order($order_id);
            $tot_userid = tot_create_appuserid_from_email($current_user_id, $order);
            $tot_user = new User(null, $tot_userid);
            // We don't save the email_reputation since it could be different from the user rep.
            $this->email_reputation_result = $tot_user->get_reputation_reasons($tot_userid);
        };
        return $this->email_reputation_result;
    }

    public function get_order_reputation($order_id, $force_refresh = false)
    {
        if ((null == $this->order_reputation_result) || (true == $force_refresh)) {
            $this->order_reputation_result = tot_get_wc_order_reputation($order_id);
        }
        return $this->order_reputation_result;
    }

    public function should_receipt_display_verification_prompt($order)
    {

        if (!$order || is_wp_error($order)) {
            tot_log_as_html_comment("should_receipt_display_verification_prompt:require_verification_at_checkout", "Not displaying verification prompt bc order = empty");
            return false;
        }

        $order_id = $order->get_id();

        if (!isset($order_id) || is_wp_error($order_id)) {
            tot_log_as_html_comment("should_receipt_display_verification_prompt:require_verification_at_checkout", "Not displaying verification prompt bc order_id = empty");
            return false;
        }

        $require_verification_at_checkout = $this->tot_is_verification_on_checkout_enabled();
        if (!$require_verification_at_checkout) {
            tot_log_as_html_comment("should_receipt_display_verification_prompt:require_verification_at_checkout", "Not displaying verification prompt bc tot_field_checkout_require = false");
            return false;
        }

        if (!$this->is_verification_required_for_order($order_id)) {
            tot_log_as_html_comment("is_verification_required_for_order", "false");
            return false;
        }

        if ($this->is_verification_complete($order_id)) {
            tot_log_as_html_comment("is_verification_complete", "true");
            return false;
        }

        if (!$this->user_can_verify_order($order_id)) {
            tot_log_as_html_comment("user_can_verify_order", "false");
            return false;
        }

        tot_log_as_html_comment("none_of_the_above", "true");
        return true;

    }

    // TODO - move this over to using class-verify.php.
    public function verify($order, $force_refresh = false, $error_callback = null)
    {

        if (!$force_refresh && ($this->verify_result !== null)) {
            return $this->verify_result;
        }

        $order_id = $order->get_id();

        if (!$order_id) {
            return new WP_Error('tot-no-order-id', 'There was a problem finding this order');
        }

        $is_verification_info_submitted = $this->is_verification_info_submitted($order_id);
        if (!$force_refresh && $is_verification_info_submitted) {
            tot_log_as_html_comment('Not updated bc $is_verification_info_submitted', $is_verification_info_submitted);
            return;
        }

        // Set that the order has been checked.
        // update_post_meta( $order_id, 'tot_last_updated', current_time( 'mysql' ) );

        $tot_transaction_id = get_post_meta($order_id, 'tot_transaction_id', true);
        if (!$tot_transaction_id) {
            $tot_transaction_id = tot_create_guid();
            update_post_meta($order_id, 'tot_transaction_id', $tot_transaction_id);
        }

        $use_shipping_details = $order->get_shipping_first_name();
        if ($use_shipping_details) {
            $first_name = $order->get_shipping_first_name();
            $last_name = $order->get_shipping_last_name();

            $country = $order->get_shipping_country();
            $address_1 = $order->get_shipping_address_1();
            $address_2 = $order->get_shipping_address_2();
            $city = $order->get_shipping_city();
            $state = $order->get_shipping_state();
            $postcode = $order->get_shipping_postcode();
        } else {
            $first_name = $order->get_billing_first_name();
            $last_name = $order->get_billing_last_name();

            $country = $order->get_billing_country();
            $address_1 = $order->get_billing_address_1();
            $address_2 = $order->get_billing_address_2();
            $city = $order->get_billing_city();
            $state = $order->get_billing_state();
            $postcode = $order->get_billing_postcode();
        }
        $email = $order->get_billing_email();

        $verify_person_data = [
            'appTransactionId' => $tot_transaction_id,
            // 'appTransactionTags' => ['wine'], // Todo: implement order/onboarding tags once available in core.
            'person' => [
                'givenName' => $first_name,
                'familyName' => $last_name,
                'email' => $email,
                'location' => [
                    'countryCode' => $country,
                    "line1" => $address_1,
                    'line2' => $address_2,
                    'locality' => $city,
                    'region' => $state,
                    'postalCode' => $postcode
                ]
            ]
        ];

        $order_whitelist_data = $this->get_order_whitelist_data($order_id);
        if ($order_whitelist_data) {
            $verify_person_data['person']['preApproved'] = $order_whitelist_data;
        }

        $orderUserid = $order->get_user_id();
        if (!$orderUserid) {
            $verify_person_data['guest'] = 'true';
        }
        $verify_person_data['appUserid'] = tot_user_id($orderUserid, $order, false);

        $verify_person_data = apply_filters('tot_order_verification_data', $verify_person_data, $order_id);
        $request = new API_Request('api/person', $verify_person_data, 'POST');

        tot_log_as_html_comment('Verifying with', $verify_person_data);
        $this->verify_result = $request->send($error_callback);

        return $this->verify_result;

    }

    public function process_order($order_id)
    {

        if (!isset($order_id)) {
            return;
        }

        $order = wc_get_order($order_id);

        if (is_wp_error($order)) {
            return;
        }

        $tot_transaction_id = get_post_meta($order_id, 'tot_transaction_id', true);
        if (!$tot_transaction_id) {
            $tot_transaction_id = tot_create_guid();
            update_post_meta($order_id, 'tot_transaction_id', $tot_transaction_id);
        }

        $require_verification_at_checkout = $this->tot_is_verification_on_checkout_enabled();
        if (!$require_verification_at_checkout) {
            return;
        }

        if (!$this->is_verification_required_for_order($order_id)) {
            return;
        }

        // Do not re-quarantine if we've already checked this order
        if ($this->has_order_been_checked_with_tot($order_id)) {
            return;
        }

        // Set that the order has been checked.
        update_post_meta($order_id, 'tot_last_updated', current_time('mysql'));

        // Send transaction to TOT for EIDV and other verification steps.
        $verify_result = $this->verify($order);
        $reasons = $this->get_order_reputation_reasons($order_id, true);
        $order_state = $this->order_result_verification_state($reasons, $order_id);

        // Apply notes from order status
        if (!empty($order_state['messages'])) {
            $order->add_order_note(implode(' ', $order_state['messages']));
        }

        // Determine if order should be quarantine and allow site to override. Default to yes.
        $set_quarantine = $order_state['name'] === 'pass' ? false : true;
        $set_quarantine = apply_filters('tot_process_order_set_quarantine', $set_quarantine, $order_id, $verify_result);
        if ($set_quarantine) {
            update_post_meta($order_id, 'tot_quarantined', true);
            $order->add_order_note(__('Awaiting verification.', $this->text_domain));
        }

        // Order verification failed, place in quarantine
        if ('failed' === $order_state['name']) {
            $order->update_status(
                apply_filters('tot_order_age_verification_failed', 'on-hold', 'process_order', $order, $reasons, $verify_result),
                __('Updating order status from verification result', $this->text_domain)
            );
        }
    }

    public function post_payment_status_check($order_id)
    {
        $is_order_quarantined = $this->is_order_quarantined($order_id);
        if ($is_order_quarantined) {
            // In theory the order would already be unquarantined if it could be - so this should not be necessary.
            $order = wc_get_order($order_id);
            $reasons = $this->get_order_reputation_reasons($order_id);
            $this->processUpdatedReasons($order, $reasons, 'post-payment');
        }
    }

    public function post_payment_cod_status_check($status, $order)
    {
        $order_id = $order->get_id();
        $this->post_payment_status_check($order_id);
        return $order->get_status();
    }

    public function user_can_verify_order($order_id)
    {

        $order_user_id = get_post_meta($order_id, '_customer_user', true);

        if (isset($order_user_id) && !is_wp_error($order_user_id) && (strval($order_user_id) === '0')) {

            // Guest checkout
            return true;

        } else {

            // Member checkout
            if (is_user_logged_in() && $this->order_belongs_to_current_member($order_id)) {
                return true;
            }

        }

        return false;

    }

    public function is_order_quarantined($order_id)
    {

        if (!isset($order_id)) {
            return false;
        }

        $quarantined = get_post_meta($order_id, 'tot_quarantined', true);
        return tot_option_has_a_value($quarantined);
    }

    public function has_order_been_checked_with_tot($order_id)
    {

        if (!isset($order_id)) {
            return false;
        }

        $last_updated_by_tot = get_post_meta($order_id, 'tot_last_updated', true);
        return tot_option_has_a_value($last_updated_by_tot);
    }

    public function order_belongs_to_current_member($order_id)
    {

        $customer_id = get_post_meta($order_id, '_customer_user', true);

        return $customer_id == get_current_user_id();

    }

    public function is_verification_required_for_order($order_id = null, $cart = null)
    {
        $is_order_preapproved = $this->is_order_preapproved($order_id);
        if ($is_order_preapproved) {
            return apply_filters('tot_is_verification_required_for_order', false, $order_id, $cart);
        }

        $order = null;
        $subtotal = 0;
        $cart_contents = [];

        if ($order_id !== null) {
            $order = wc_get_order($order_id);
            $subtotal = $order->get_subtotal();  // TODO : Should be total?
            foreach ($order->get_items() as $line_item) {
                $product = $line_item->get_product();
                array_push($cart_contents, $product->get_id());
            }
        } else if ($cart !== null) {
            $subtotal = $cart->subtotal;
            $cart_contents = $cart->cart_contents;
        } else {
            return false;
        }

        $require_verification_at_checkout = $this->tot_is_verification_on_checkout_enabled();
        $minimum_cart_value = Settings::get_setting('tot_field_checkout_require_total_amount');
        $cart_amount_is_over_minimum = !isset($minimum_cart_value) ? false : floatval($subtotal) > floatval($minimum_cart_value);

        $has_product_in_restricted_category = $this->has_product_in_restricted_category($cart_contents);
        $has_product_in_restricted_tag = $this->has_product_in_restricted_tag($cart_contents);
        $has_required_payment_method = $this->has_required_payment_method($order);

        $requires_verification =
            ($require_verification_at_checkout && $has_required_payment_method) &&
            ($cart_amount_is_over_minimum || $has_product_in_restricted_category || $has_product_in_restricted_tag);

// TODO - this is great to log but is placed within a page element so comment and pre don't work.
//        tot_log_as_html_comment("requires_verification: ", array(
//            '$require_verification_at_checkout' => $require_verification_at_checkout,
//            '$has_required_payment_method' => $has_required_payment_method,
//            '$cart_amount_is_over_minimum' => $cart_amount_is_over_minimum,
//            '$has_product_in_restricted_category' => $has_product_in_restricted_category,
//            '$has_product_in_restricted_tag' => $has_product_in_restricted_tag
//        ));

        return apply_filters('tot_is_verification_required_for_order', $requires_verification, $order_id, $cart);
    }

    public function is_verification_consent_required_for_order($order_id = null, $cart = null)
    {
        $consent_is_required = apply_filters('tot_is_verification_consent_required_for_order', true, $order_id, $cart);
        return $consent_is_required && !$this->is_order_preapproved($order_id);
    }

    public function has_product_in_restricted_category($cart_contents = array())
    {
        $restricted_categories = Settings::get_setting('tot_field_checkout_require_categories');
        if (!is_array($cart_contents) || !isset($restricted_categories) ||
            ($restricted_categories == '') || !is_array($restricted_categories)) {
            return false;
        }

        foreach ($cart_contents as $item) {
            $product_id = is_array($item) ? $item['product_id'] : $item;
            $categories = $this->get_product_terms($product_id, 'product_cat');

            if (!is_array($categories)) {
                tot_log_as_html_comment("CATEGORIES NOT FOUND", $categories);
                continue;
            }

            tot_log_as_html_comment("USING PRODUCT CATEGORIES for " . $product_id, $categories);
            foreach ($categories as $category) {
                $category_id = $category->term_id;
                if (in_array($category_id, $restricted_categories)) {
                    tot_log_as_html_comment("MATCHES CATEGORY", "CATEGORY (" . $category_id . ") MATCHES CATEGORY (" . implode(',', $restricted_categories) . ")");
                    return true;
                } else {
                    tot_log_as_html_comment("DOES NOT MATCH CATEGORY", "CATEGORY (" . $category_id . ") DOES NOT MATCH CATEGORY (" . implode(',', $restricted_categories) . ")");
                }
            }
        }

        tot_log_as_html_comment("NOTHING IN CART MATCHES CATEGORY", $cart_contents);
        return false;
    }

    public function has_product_in_restricted_tag($cart_contents = array())
    {
        $restricted_tags = Settings::get_setting('tot_field_checkout_require_tags');
        if (!is_array($cart_contents) || !isset($restricted_tags) ||
            ($restricted_tags == '') || !is_array($restricted_tags)) {
            return false;
        }

        foreach ($cart_contents as $item) {
            $product_id = is_array($item) ? $item['product_id'] : $item;
            $tags = $this->get_product_terms($product_id, 'product_tag');

            tot_log_as_html_comment("USING PRODUCT TAGS for " . $product_id, $tags);

            if (!is_array($tags)) {
                tot_log_as_html_comment("TAGS NOT FOUND", $tags);
                continue;
            }
            foreach ($tags as $tag) {
                $tag_id = $tag->term_id;
                if (in_array($tag_id, $restricted_tags)) {
                    tot_log_as_html_comment("MATCHES TAG", "TAG (" . $tag_id . ") MATCHES RESTRICTED TAG (" . $restricted_tags . ")");
                    return true;
                } else {
                    tot_log_as_html_comment("DOES NOT MATCH TAG", "TAG (" . $tag_id . ") DOES NOT MATCH RESTRICTED TAG (" . $restricted_tags . ")");
                }
            }
        }

        tot_log_as_html_comment("NOTHING IN CART MATCHES RESTRICTED TAGS", $cart_contents);

        return false;
    }

    public function has_required_payment_method($order)
    {
        $required_payment_methods = Settings::get_setting('tot_field_checkout_require_payment_methods');
        if (!isset($required_payment_methods) || ($required_payment_methods == '') || !is_array($required_payment_methods)) {
            // Then no payment methods explicitly required.
            return true;
        }

        if (!isset($order)) {
            return true;
        }

        $method_of_payment = $order->get_payment_method();
        if (!isset($method_of_payment)) {
            return true;
        }

        if (in_array($method_of_payment, $required_payment_methods)) {
            return true;
        }

        return false; // payment method not found.
    }

    public function enqueue_javascript()
    {
        wp_enqueue_script(
            'admin-token-of-trust',
            plugins_url('/wc-checkout.js', __FILE__),
            array('jquery'));
    }

    public function checkout_field_verification_acknowledgement($checkout)
    {

        $wc = \WC();
        if (!$this->is_verification_required_for_order(null, $wc->cart)) {
            return;
        }
        if (!$this->is_verification_consent_required_for_order(null, $wc->cart)) {
            return;
        }


        echo '<div id="tot_verification_acknowledgement_field">';
        echo '<h2>' . __('Verification', $this->text_domain) . '</h2>';
        echo '<p>' . __('This order requires verification using Token of Trust.', $this->text_domain) . '</p>';


        woocommerce_form_field('tot_verification_acknowledgement', array(
            'type' => 'checkbox',
            'class' => array('tot-verification-acknowledgement-field'),
            'label' => __('I agree to share information with Token of Trust', $this->text_domain),
            'required' => true
        ), $checkout->get_value('tot_verification_acknowledgement'));

        echo '</div>';

    }

    public function checkout_field_validation()
    {

        $wc = \WC();

        if (!$this->is_verification_consent_required_for_order(null, $wc->cart)) {
            return;
        }

        if (!$this->is_verification_required_for_order(null, $wc->cart)) {
            return;
        }

        // Check if set, if its not set add an error.
        if (!isset($_POST['tot_verification_acknowledgement'])) {
            wc_add_notice(__('<strong>Verification</strong> is required.', $this->text_domain), 'error');
        }

    }

    public function order_result_verification_state($reasons, $order_id)
    {
        $is_order_preapproved = $this->is_order_preapproved($order_id, $reasons);
        if ($is_order_preapproved === 'appPreApproved') {
            return array(
                'name' => 'pass',
                'code' => 'passed-white-listed',
                'messages' => array(
                    __('Order white-listed. Skipping Token of Trust verification.', $this->text_domain)
                )
            );
        }

        if (empty($reasons)) {
            return array(
                'name' => 'no-action'
            );
        }

        $govtIdPositiveAppReview = $reasons->is_positive('govtIdPositiveAppReview');
        $force_accept_on_app_approve = empty(Settings::get_setting('tot_field_dont_force_accept_on_app_approve'));
        if ($force_accept_on_app_approve && $govtIdPositiveAppReview) {
            // WARNING: This overrides any age settings!!
            return array(
                'name' => 'pass',
                'code' => 'passed-vendor-review',
                'messages' => array(
                    __('Order verified by admin review.', $this->text_domain)
                )
            );
        }

        // TODO use api key setting for min age instead of local setting.
        $wp_min_age = !empty(Settings::get_setting('tot_field_min_age'));
        if ($wp_min_age) {
            // Then we pass based upon minimum age criteria.
            $process_min_age = $this->process_min_age($reasons, $wp_min_age);
            if (!empty($process_min_age)) {
                return $process_min_age;
            }
        } else {
            if ($govtIdPositiveAppReview) {
                return array(
                    'name' => 'pass',
                    'code' => 'passed-vendor-review',
                    'messages' => array(
                        __('Order verified by admin review.', $this->text_domain)
                    )
                );
            }
            if ($reasons->is_positive('govtIdPositiveReview')) {
                return array(
                    'name' => 'pass',
                    'code' => 'passed-tot-review',
                    'messages' => array(
                        __('Order verified by Token of Trust.', $this->text_domain)
                    )
                );
            }
        }

        if ($reasons->is_positive('govtIdPendingAppReview')) {
            return array(
                'name' => 'needs-review',
                'code' => 'pending-app-review',
                'messages' => array(
                    __('Customer submitted verification. Order is ready for review.', $this->text_domain)
                )
            );
        }

        $order = wc_get_order($order_id);
        $order_status = $order->get_status();

        if (in_array($order_status, array('processing', 'completed'))) {
            return array(
                'name' => 'must-verify', // to ensure we process results later if we go through vendor review.
                'code' => 'customer-must-verify',
                'messages' => array(
                    __('Payment processing complete. Order requires verification.', $this->text_domain)
                )
            );
        } else {
            return array(
                'name' => 'must-verify', // to ensure we process results later if we go through vendor review.
                'code' => 'customer-must-verify'
            );
        }
    }

    public function process_min_age($reasons, $wp_min_age)
    {

        if (!$reasons->reason_has_value('ageVerified')) {
            return array(
                'name' => 'must-verify'
            );
        }

        if ($reasons->has_insufficient_data('ageVerified')) {
            return array(
                'name' => 'must-verify'
            );
        }

        if (!$reasons->is_positive('ageVerified')) {
            return array(
                'name' => 'failed',
                'code' => 'failed-negative-age-verified-reason',
                'messages' => array(
                    __('Age did not pass verification from the information given.', $this->text_domain)
                )
            );
        }

        if (!isset($reasons->reasons->ageVerified->ageRange->min)) {
            return array(
                'name' => 'failed',
                'code' => 'failed-no-verified-minimum-age',
                'messages' => array(
                    __('Minimum age cannot be determined from the information given.', $this->text_domain)
                )
            );
        }

        // TODO: Migrate to use: "meetsMinimumAgeRequirement"
        $verified_min_age = intval($reasons->reasons->ageVerified->ageRange->min);

        if ($verified_min_age < $wp_min_age) {
            return array(
                'name' => 'failed',
                'code' => 'failed-age-is-under-minimum',
                'messages' => array(
                    __('Age is at least ', $this->text_domain)
                    . $verified_min_age
                    . __(' or older, but required age is ', $this->text_domain)
                    . $wp_min_age
                    . '.'
                )
            );
        }

        if ($verified_min_age >= $wp_min_age) {
            return array(
                'name' => 'pass',
                'messages' => array(
                    __('Age is at least ', $this->text_domain)
                    . $verified_min_age
                    . __(' or older, required age is ', $this->text_domain)
                    . $wp_min_age
                    . '.'
                )
            );
        }

        return null;
    }

    public function default_autoprocess_webhook($name, $body, $input = null)
    {
        if (
            ('reputation.updated' !== $name)
            && ('reputation.created' !== $name)
            && ('totManualReview.updated' !== $name)
            && ('totReview.updated' !== $name)
            && ('appReview.updated' !== $name)
        ) {
            return;
        }

        if (isset($body->appTransactionId) && isset($body->reasons)) {
            // Critical to register_awaiting_verification_order_status so that we can move orders into states.
            $this->register_awaiting_verification_order_status();
            $order = $this->get_order_by_guid($body->appTransactionId);
            $reasons = new Reasons($body->reasons);
            $this->processUpdatedReasons($order, $reasons, $name);
        }
    }

    public function get_order_by_guid($guid)
    {

        $orders = get_posts(array(
            'numberposts' => 1,
            'post_type' => wc_get_order_types(),
            'post_status' => 'any',
            'meta_key' => 'tot_transaction_id',
            'meta_value' => $guid
        ));

        if (isset($orders) && is_array($orders) && (count($orders) == 1)) {
            return wc_get_order($orders[0]->ID);
        }

        return null;
    }

    function order_lookup_redirect()
    {

        global $wp;
        if (($wp->request == 'token-of-trust/wc/order') && isset($_GET['guid'])) {

            if (!current_user_can('manage_woocommerce')) {
                return;
            }

            $guid = sanitize_text_field($_GET['guid']);
            $order = $this->get_order_by_guid($guid);

            if ($order) {
                $edit_link = get_edit_post_link($order->get_id(), 'redirect');
                wp_redirect($edit_link);
                exit;
            }
        }

    }

    /**
     * Proper update of the reasons on the order as well as the 'quarantine status.
     *
     * @param $order
     * @param Reasons $reasons
     * @param $context
     */
    public function processUpdatedReasons($order, $reasons, $context)
    {
        if (empty($order) || $reasons === null || empty($reasons)) {
            return null;
        }

        $order_id = $order->get_id();
        $order_status = $order->get_status();

        if (!$this->is_order_quarantined($order_id)) {
            tot_log_debug("Order not quarantined skipping processing reasons.");
            return $order_status;
        }

        $okayToUpdateStatus = in_array($order_status, array('processing', 'completed', 'must-verify', 'needs-review'));
        $updatedOrderStatus = null;

        $verification_state = apply_filters('tot_order_status', null, $order, $reasons);
        if ($verification_state === null) {
            $verification_state = $this->order_result_verification_state($reasons, $order_id);
        }

        $verification_state_name = $verification_state['name'];
        $verification_state_message = isset($verification_state['messages']) ? implode(' ', $verification_state['messages']) : '';

        $note = null;
        if ('failed' === $verification_state_name) {
            $note = __('Automatically updating status from webhook.', $this->text_domain) . ' ' . $verification_state_message;
            update_post_meta($order_id, 'tot_last_updated', current_time('mysql'));
            $updatedOrderStatus = apply_filters('tot_order_verification_failed_next_woo_state', 'on-hold', $context, $order, $reasons);
            do_action('tot_order_verification_failed', $order, $reasons);
        } else if ('pass' === $verification_state_name) {
            update_post_meta($order_id, 'tot_last_updated', current_time('mysql'));
            update_post_meta($order_id, 'tot_quarantined', false);
            $updatedOrderStatus = $this->tot_order_verification_passed_next_woo_state($order_status, $verification_state, $order, $reasons);
            do_action('tot_order_verification_passed', $order, $reasons);
            $wp_min_age = Settings::get_setting('tot_field_min_age');
            if (isset($updatedOrderStatus)) {
                if ($order_status === 'must-verify' || $order_status === 'needs-review') {
                    if (!empty($wp_min_age)) {
                        $note = __('Automatically removing age verification hold because: ', $this->text_domain) . ' ' . $verification_state_message;
                    } else {
                        $note = __('Automatically removing verification hold because: ', $this->text_domain) . ' ' . $verification_state_message;
                    }
                } else {
                    if (!empty($wp_min_age)) {
                        $note = __('Age verified: ', $this->text_domain) . ' ' . $verification_state_message;
                    } else {
                        $note = $verification_state_message;
                    }
                }
            }
        } else if ('must-verify' === $verification_state_name || 'needs-review' === $verification_state_name) {
            $updatedOrderStatus = $verification_state_name;
            $okayToAddNote = in_array($order_status, array('pending', 'processing', 'completed', 'must-verify', 'needs-review'));
            if ($okayToAddNote && $updatedOrderStatus !== $order_status) {
                $note = $verification_state_message;
            }
        } else {
            $updatedOrderStatus = $order_status;
            // means we got: no-action, must-verify.
            // TODO: we could add a note here (when reputation.updated?) to indicate that verification was started?
            return $updatedOrderStatus;
        }

        $willUpdateOrderStatus = $okayToUpdateStatus && $updatedOrderStatus !== $order_status;
        if ($willUpdateOrderStatus) {
            // tot_log_debug("Updating status from $order_status to $updatedOrderStatus with note: $note");
            if (empty($note)) {
                $order->update_status($updatedOrderStatus);
            } else {
                $order->update_status($updatedOrderStatus, $note);
            }
        } else {
            if (!empty($note)) {
                $order->add_order_note($note);
            }
        }

        $order_status = $order->get_status();
        // tot_log_debug("Now in  $order_status.");
        return $order_status;
    }

    public function tot_is_verification_on_checkout_enabled()
    {
        return Settings::get_setting('tot_field_checkout_require');
    }

    public function tot_order_verification_next_woo_state($from_order_status, $verification_state, $order, Reasons $reasons)
    {
        $order_id = $order->get_id();
        $is_order_quarantined = $this->is_order_quarantined($order_id);
        switch ($from_order_status) {
            // If order is in processing or completed
            // AND quarantined it should be in must-verify.
            // Aside: The order can be moved out of quarantine either by review or by admin-action.

            case 'needs-review':
            case 'must-verify':
                if (!$is_order_quarantined) {
                    return apply_filters('tot_order_status_after_positive_review', 'processing', $order, $reasons);
                }
                break;
            case 'processing':
            case 'completed':
                if ($is_order_quarantined) {
                    return 'must-verify';
                }
                break;
            default:
        }
        return $from_order_status;
    }

    public function tot_order_verification_passed_next_woo_state($from_order_status, $verification_state, $order, Reasons $reasons)
    {
        return apply_filters('tot_order_verification_passed_next_woo_state', $this->tot_order_verification_next_woo_state($from_order_status, $verification_state, $order, $reasons), $from_order_status, $verification_state, $order, $reasons);
    }

    public function is_order_preapproved($order_id, $reasons = null)
    {
        $order_whitelist_data = $this->get_order_whitelist_data($order_id);
        if (!empty($order_whitelist_data)) {
            return true;
        }

        // Currently we're forcing use of "email reputation" for pre-approval.
        $reasons = !empty($reasons) ? $reasons : $this->get_email_reputation($order_id);
        $has_reasons = !empty($reasons) && !is_wp_error($reasons);
        $orderIsPreapproved = $has_reasons && $reasons->is_positive('appPreApproved');
        if ($orderIsPreapproved) {
            return 'appPreApproved';
        }

        return $orderIsPreapproved;
    }

    /**
     * Fetches the product terms. For variable products tries to use terms for parent.
     * @param $product_id
     * @return mixed
     */
    public function get_product_terms($product_id, $term = 'product_cat')
    {
        $terms = get_the_terms($product_id, $term);
        if (!is_array($terms)) {
            $variation = wc_get_product($product_id);
            if (!empty($variation)) {
                $terms = get_the_terms($variation->get_parent_id(), $term);
            }
            if (is_array($terms)) {
                tot_log_as_html_comment("USING PRODUCT TERMS FOR PARENT PRODUCT", $terms);
            }
        }
        return $terms;
    }

}

class Checkout
{

    protected $text_domain;

    /**
     * Tries to find a valid order id (and ensures it is a WC Order).
     *
     * @param null $order_id
     * @return |null
     */
    public static function get_current_wc_order_id($order_id = null)
    {
        global $post;
        $order = null;

        // Try to fetch using current post.
        if (empty($order_id) && class_exists('WooCommerce')) {
            $order_id = $post->ID;
            $order = wc_get_order($order_id);
            $order_id = empty($order) ? null : $order_id;
            if (!empty($order_id)) {
                tot_log_as_html_comment('Used postId to fetch order_id ', $order_id);
            }
        }

        if (empty($order_id)) {
            // try to fetch from the order received page.

            $wcOrderKeyFromQuery = getWcOrderKeyFromQuery();
            $order_key = !empty($wcOrderKeyFromQuery) ? $wcOrderKeyFromQuery : '';
            if (!empty($order_key)) {
                $order_key = sanitize_text_field($order_key);
                $order_id = wc_get_order_id_by_order_key($order_key);
                $order = wc_get_order($order_id);
                $order_id = empty($order) ? null : $order_id;
                if (!empty($order_id)) {
                    tot_log_as_html_comment('Used "key" query param to fetch order_id ', $order_id);
                }
            }
        }

        if (empty($order_id)) {
            tot_log_as_html_comment('get_current_wc_order_id:error', 'Unable to find active order.');
        }

        return $order_id;
    }

    public function __construct()
    {
        global $tot_plugin_text_domain;
        $this->text_domain = $tot_plugin_text_domain;
    }

    public function get_name()
    {
        return "Checkout Baseclass";
    }

    public function register_wordpress_hooks()
    {
    }

    public function register_wordpress_hooks_after_load()
    {
    }

    public function handle_verify_person_api_error($response, $request = null, $url = null, $data='')
    {
    }
}

/** Bridge allows us to create a kill switch. **/
class Checkout_Bridge extends Checkout
{

    private $bridge;

    public function __construct()
    {
        parent::__construct();
        if (Settings::get_setting('tot_field_checkout_require')) {
            $this->bridge = new Checkout_Enabled();
        } else {
            $this->bridge = new Checkout_Disabled();
        }
        $name = $this->get_name();
        // echo "Checkout Class: $name! <br>";
    }

    public function get_name()
    {
        return $this->bridge->get_name();
    }

    public function register_wordpress_hooks()
    {
        $this->bridge->register_wordpress_hooks();
    }

    public function register_wordpress_hooks_after_load()
    {
        $this->bridge->register_wordpress_hooks_after_load();
    }

    public function handle_verify_person_api_error($response, $request = null, $url = null, $data = '')
    {
        $this->bridge->handle_verify_person_api_error($response, $request, $url, $data);
    }
}

class Checkout_Disabled extends Checkout
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_name()
    {
        return "Checkout_Disabled";
    }
}

function getWcOrderKeyFromQuery()
{
        foreach (['ctp_order_key', 'key'] as $key) {
            $value = get_query_var($key, NULL);
            if (!empty($value)) {
                return $value;
            }
        }
}