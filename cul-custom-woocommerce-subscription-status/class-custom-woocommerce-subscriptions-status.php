<?php

class Custom_Woocommerce_Subscription_Status
{

    /**
     * Initialize Hooks.
     *
     * @access public
     */
    public function run()
    {
    	add_filter('woocommerce_valid_order_statuses_for_payment', array($this, 'add_valid_order_statuses_for_payment'), 100, 2);

        /**
         *  hook: apply_filters( 'wcs_subscription_statuses', $subscription_statuses )
         *  in file `woocommerce-subscriptions/woocommerce-subscriptions.php`
         */
        add_filter('woocommerce_subscriptions_registered_statuses', array($this, 'register_new_post_status'), 100, 1);

        /**
         *  hook: apply_filters( 'wcs_subscription_statuses', $subscription_statuses )
         *  in file `woocommerce-subscriptions/wcs-functions.php`
         */
        add_filter('wcs_subscription_statuses', array($this, 'add_new_subscription_statuses'), 100, 1);

        /**
         *  hook: apply_filters('woocommerce_can_subscription_be_updated_to', $can_be_updated, $new_status, $subscription)
         *  in file `woocommerce-subscriptions/includes/class-wc-subscription.php`
         */
        add_filter('woocommerce_can_subscription_be_updated_to', array($this, 'extends_can_be_updated'), 100, 3);
        /**
         * Alternative hooks available for the above hook :
         * apply_filters('woocommerce_can_subscription_be_updated_to_' . $new_status, $can_be_updated, $subscription );
         */

        /**
         *  hook: do_action('woocommerce_subscription_status_updated', $subscription, $new_status, $old_status)
         *  in file `woocommerce-subscriptions/includes/class-wc-subscription.php`
         */
        add_action('woocommerce_subscription_status_updated', array($this, 'extends_update_status'), 100, 3);
        /**
         * Alternative hooks available for the above hook :
         * do_action('woocommerce_subscription_status_' . $new_status, $subscription);
         * do_action('woocommerce_subscription_status_' . $old_status . '_to_' . $new_status, $subscription);
         * do_action('woocommerce_subscription_status_updated', $subscription, $new_status, $old_status);
         * do_action('woocommerce_subscription_status_changed', $subscription_id, $old_status, $new_status);
         */

        /**
         *  hook: apply_filters('woocommerce_can_subscription_be_updated_to_' . $new_status, $can_be_updated, $subscription)
         *  in file `woocommerce-subscriptions/includes/class-wc-subscription.php`
         */
        add_filter('woocommerce_can_subscription_be_updated_to_active', array($this, 'enable_active_in_new_statuses'), 100, 2);
        add_filter('woocommerce_can_subscription_be_updated_to_on-hold', array($this, 'enable_on_hold_in_new_statuses'), 100, 2);

        /**
         *  hook: apply_filters('woocommerce_subscription_bulk_actions', $bulk_actions)
         *  in file `woocommerce-subscriptions/includes/class-wc-subscription.php`
         */
        add_filter('woocommerce_subscription_bulk_actions', array($this, 'add_new_status_bulk_actions'), 100, 1);

        /**
         *  Following is a WordPress core hook. You will find it's woocommerce-subscription implementation
         *  in file `includes/admin/class-wcs-admin-post-types.php`
         */
        add_action('load-edit.php', array($this, 'parse_bulk_actions'));

        /**
         *  WordPress hook for adding styles and scripts to dashboard
         */
        add_action('admin_enqueue_scripts', array($this, 'custom_subscription_status_style'));
    }
    
    public function add_valid_order_statuses_for_payment( $statuses, $instance ) {
        return array_merge($statuses, ['late-payment']);
    }
    


    /**
     * Registered new status by adding `Late Payment` and others to $registered_statuses array.
     *
     * @access public
     *
     * @param array $registered_statuses Registered Statuses array.
     * @return array $registered_statuses with the new status added to it.
     */
    public function register_new_post_status($registered_statuses)
    {
        $registered_statuses['wc-like-on-hold'] = _nx_noop('Falla pago inicial <span class="count">(%s)</span>', 'Falla pago inicial <span class="count">(%s)</span>', 'post status label including post count', 'custom-wcs-status-texts');
        

        $registered_statuses['wc-late-payment'] = _nx_noop('Pago Demorado <span class="count">(%s)</span>', 'Pago Demorado <span class="count">(%s)</span>', 'post status label including post count', 'custom-wcs-status-texts');

        $registered_statuses['wc-late-payment-30'] = _nx_noop('Pago Demorado 30 <span class="count">(%s)</span>', 'Pago Demorado 30 <span class="count">(%s)</span>', 'post status label including post count', 'custom-wcs-status-texts');

        $registered_statuses['wc-late-payment-60'] = _nx_noop('Pago Demorado 60 <span class="count">(%s)</span>', 'Pago Demorado 60 <span class="count">(%s)</span>', 'post status label including post count', 'custom-wcs-status-texts');

        $registered_statuses['wc-late-payment-90'] = _nx_noop('Pago Demorado 90 <span class="count">(%s)</span>', 'Pago Demorado 90 <span class="count">(%s)</span>', 'post status label including post count', 'custom-wcs-status-texts');

        $registered_statuses['wc-late-payment.120'] = _nx_noop('Pago Demorado 120 <span class="count">(%s)</span>', 'Pago Demorado 120 <span class="count">(%s)</span>', 'post status label including post count', 'custom-wcs-status-texts');

        $registered_statuses['wc-late-payment-150'] = _nx_noop('Pago Demorado 150 <span class="count">(%s)</span>', 'Pago Demorado 150 <span class="count">(%s)</span>', 'post status label including post count', 'custom-wcs-status-texts');

        $registered_statuses['wc-late-payment-180'] = _nx_noop('Pago Demorado 180 <span class="count">(%s)</span>', 'Pago Demorado 180 <span class="count">(%s)</span>', 'post status label including post count', 'custom-wcs-status-texts');
        
        $registered_statuses['wc-fraud'] = _nx_noop('Fraude <span class="count">(%s)</span>', 'Fraude <span class="count">(%s)</span>', 'post status label including post count', 'custom-wcs-status-texts');

        $registered_statuses['wc-bad-payment'] = _nx_noop('No Pago <span class="count">(%s)</span>', 'No Pago <span class="count">(%s)</span>', 'post status label including post count', 'custom-wcs-status-texts');

        $registered_statuses['wc-expired-offer'] = _nx_noop('Finalizado Oferta Aceptada <span class="count">(%s)</span>', 'Finalizado Oferta Aceptada <span class="count">(%s)</span>', 'post status label including post count', 'custom-wcs-status-texts');
        return $registered_statuses;
    }

    /**
     * Add new status `Late Payment` and others to $subscription_statuses array.
     *
     * @access public
     *
     * @param array $subscription_statuses current subscription statuses array.
     * @return array $subscription_statuses with the new status added to it.
     */
    public function add_new_subscription_statuses($subscription_statuses)
    {
        $subscription_statuses['wc-like-on-hold'] = _x('Falla pago inicial', 'Subscription status', 'custom-wcs-status-texts');
        $subscription_statuses['wc-late-payment'] = _x('Pago Demorado', 'Subscription status', 'custom-wcs-status-texts');
        $subscription_statuses['wc-late-payment-30'] = _x('Pago Demorado 30', 'Subscription status', 'custom-wcs-status-texts');
        $subscription_statuses['wc-late-payment-60'] = _x('Pago Demorado 60', 'Subscription status', 'custom-wcs-status-texts');
        $subscription_statuses['wc-late-payment-90'] = _x('Pago Demorado 90', 'Subscription status', 'custom-wcs-status-texts');
        $subscription_statuses['wc-late-payment-120'] = _x('Pago Demorado 120', 'Subscription status', 'custom-wcs-status-texts');
        $subscription_statuses['wc-late-payment-150'] = _x('Pago Demorado 150', 'Subscription status', 'custom-wcs-status-texts');
        $subscription_statuses['wc-late-payment-180'] = _x('Pago Demorado 180', 'Subscription status', 'custom-wcs-status-texts');
        $subscription_statuses['wc-fraud'] = _x('Fraude', 'Subscription status', 'custom-wcs-status-texts');
        $subscription_statuses['wc-bad-payment'] = _x('No Pago', 'Subscription status', 'custom-wcs-status-texts');
        $subscription_statuses['wc-expired-offer'] = _x('Finalizado Oferta Aceptada', 'Subscription status', 'custom-wcs-status-texts');
        return $subscription_statuses;
    }

    /**
     * Extends can_be_updated_to($status) functions of Woocommerce Subscription plugin.
     *
     * @access public
     *
     * @param boolean $can_be_updated default value if the current subscription can be updated to new status or not.
     * @param string $new_status New status to which current subscription it is to be updated.
     * @param object $subscription current subscription object.
     * @return boolean $can_be_updated If the current subscription can be updated to new status or not.
     */
    public function extends_can_be_updated($can_be_updated, $new_status, $subscription)
    {
        if ($new_status == 'like-on-hold') {
            if ($subscription->payment_method_supports('subscription_suspension') && $subscription->has_status(array('active', 'pending', 'on-hold'))) {
                $can_be_updated = true;
            } else {
                $can_be_updated = false;
            }
        }

        if ($new_status == 'late-payment') {
            if ($subscription->payment_method_supports('subscription_suspension') && $subscription->has_status(array('active', 'pending', 'on-hold', 'like-on-hold', 'late-payment', 'late-payment-30', 'late-payment-60', 'late-payment-90', 'late-payment-120', 'late-payment-150', 'late-payment-180', 'fraud', 'bad-payment', 'expired-offer'))) {
                $can_be_updated = true;
            } else {
                $can_be_updated = false;
            }
        }

        if ($new_status == 'late-payment-30') {
            if ($subscription->payment_method_supports('subscription_suspension') && $subscription->has_status(array('active', 'pending', 'on-hold', 'like-on-hold', 'late-payment', 'late-payment-30', 'late-payment-60', 'late-payment-90', 'late-payment-120', 'late-payment-150', 'late-payment-180', 'fraud', 'bad-payment', 'expired-offer'))) {
                $can_be_updated = true;
            } else {
                $can_be_updated = false;
            }
        }

        if ($new_status == 'late-payment-60') {
            if ($subscription->payment_method_supports('subscription_suspension') && $subscription->has_status(array('active', 'pending', 'on-hold', 'like-on-hold', 'late-payment', 'late-payment-30', 'late-payment-60', 'late-payment-90', 'late-payment-120', 'late-payment-150', 'late-payment-180', 'fraud', 'bad-payment', 'expired-offer'))) {
                $can_be_updated = true;
            } else {
                $can_be_updated = false;
            }
        }
        if ($new_status == 'late-payment-90') {
            if ($subscription->payment_method_supports('subscription_suspension') && $subscription->has_status(array('active', 'pending', 'on-hold', 'like-on-hold', 'late-payment', 'late-payment-30', 'late-payment-60', 'late-payment-90', 'late-payment-120', 'late-payment-150', 'late-payment-180', 'fraud', 'bad-payment', 'expired-offer'))) {
                $can_be_updated = true;
            } else {
                $can_be_updated = true;
            }
        }
        if ($new_status == 'late-payment-120') {
            if ($subscription->payment_method_supports('subscription_suspension') && $subscription->has_status(array('active', 'pending', 'on-hold', 'like-on-hold', 'late-payment', 'late-payment-30', 'late-payment-60', 'late-payment-90', 'late-payment-120', 'late-payment-150', 'late-payment-180', 'fraud', 'bad-payment', 'expired-offer'))) {
                $can_be_updated = true;
            } else {
                $can_be_updated = false;
            }
        }
        if ($new_status == 'late-payment-150') {
            if ($subscription->payment_method_supports('subscription_suspension') && $subscription->has_status(array('active', 'pending', 'on-hold', 'like-on-hold', 'late-payment', 'late-payment-30', 'late-payment-60', 'late-payment-90', 'late-payment-120', 'late-payment-150', 'late-payment-180', 'fraud', 'bad-payment', 'expired-offer'))) {
                $can_be_updated = true;
            } else {
                $can_be_updated = false;
            }
        }
        if ($new_status == 'late-payment-180') {
            if ($subscription->payment_method_supports('subscription_suspension') && $subscription->has_status(array('active', 'pending', 'on-hold', 'like-on-hold', 'late-payment', 'late-payment-30', 'late-payment-60', 'late-payment-90', 'late-payment-120', 'late-payment-150', 'late-payment-180', 'fraud', 'bad-payment', 'expired-offer'))) {
                $can_be_updated = true;
            } else {
                $can_be_updated = false;
            }
        }
        if ($new_status == 'fraud') {
            if ($subscription->payment_method_supports('subscription_suspension') && $subscription->has_status(array('active', 'pending', 'on-hold', 'like-on-hold', 'late-payment', 'late-payment-30', 'late-payment-60', 'late-payment-90', 'late-payment-120', 'late-payment-150', 'late-payment-180', 'fraud', 'bad-payment', 'expired-offer'))) {
                $can_be_updated = true;
            } else {
                $can_be_updated = false;
            }
        }

        if ($new_status == 'bad-payment') {
            if ($subscription->payment_method_supports('subscription_suspension') && $subscription->has_status(array('active', 'pending', 'on-hold', 'like-on-hold', 'late-payment', 'late-payment-30', 'late-payment-60', 'late-payment-90', 'late-payment-120', 'late-payment-150', 'late-payment-180', 'fraud', 'bad-payment', 'expired-offer'))) {
                $can_be_updated = true;
            } else {
                $can_be_updated = false;
            }
        }

        if ($new_status == 'expired-offer') {
            if ($subscription->payment_method_supports('subscription_suspension') && $subscription->has_status(array('active', 'pending', 'on-hold', 'like-on-hold', 'late-payment', 'late-payment-30', 'late-payment-60', 'late-payment-90', 'late-payment-120', 'late-payment-150', 'late-payment-180', 'fraud', 'bad-payment', 'expired-offer', 'expired'))) {
                $can_be_updated = true;
            } else {
                $can_be_updated = false;
            }
        }
        return $can_be_updated;
    }

    /**
     * Enable `Active` status in the status change dropdown of the subcription with this new status.
     * This function replaces the default code with the new one.
     * This code will also activate `reactivate` link in the list page for the subscription with `Like On Hold` status
     *
     * @access public
     *
     * @param boolean $can_be_updated default value if the current subscription can be updated to new status or not.
     * @param object $subscription current subscription object.
     * @return boolean $can_be_updated If the current Subscription can be updated to new status or not.
     */
    public function enable_active_in_new_statuses($can_be_updated, $subscription)
    {
        if ($subscription->payment_method_supports('subscription_reactivation') && $subscription->has_status(array('on-hold', 'like-on-hold','late-payment', 'late-payment-30', 'late-payment-60', 'late-payment-90', 'late-payment-120', 'late-payment-150', 'late-payment-180', 'fraud', 'bad-payment', 'expired-offer'))) {
            $can_be_updated = true;
        } elseif ($subscription->has_status('pending')) {
            $can_be_updated = true;
        } else {
            $can_be_updated = false;
        }
        return $can_be_updated;
    }

    /**
     * Enable `On Hold` status in the status change dropdown of the subcription with this new status.
     * This function replaces the default code with the new one.
     * This code will also activate `suspend` link in the list page for the subscription with `Like On Hold` status
     *
     * @access public
     *
     * @param boolean $can_be_updated default value if the current subscription can be updated to new status or not.
     * @param object $subscription current subscription object.
     * @return boolean $can_be_updated If the current subscription can be updated to new status or not.
     */
    public function enable_on_hold_in_new_statuses($can_be_updated, $subscription)
    {
        if ($subscription->payment_method_supports('subscription_suspension') && $subscription->has_status(array('active', 'pending', 'like-on-hold', 'late-payment', 'late-payment-30', 'late-payment-60', 'late-payment-90', 'late-payment-120', 'late-payment-150', 'late-payment-180', 'fraud', 'bad-payment', 'expired-offer'))) {
            $can_be_updated = true;
        } else {
            $can_be_updated = false;
        }
        return $can_be_updated;
    }

    /**
     * Actions to be performed while the status is updated should be handled here
     * For this example, I am simply copying the `On Hold` actions as it is.
     *
     * @access public
     *
     * @param object $subscription current subscription object.
     * @param string $new_status New status to which current subscription it is to be updated.
     * @param string $old_status Current status of current subscription.
     * @return boolean $can_be_updated If the current subscription can be updated to new status or not.
     */
    public function extends_update_status($subscription, $new_status, $old_status)
    {
        if ($new_status == 'like-on-hold') {
            $subscription->update_suspension_count($subscription->suspension_count + 1);
            wcs_maybe_make_user_inactive($subscription->customer_user);
        }
        if ($new_status == 'late-payment') {
            $subscription->update_suspension_count($subscription->suspension_count + 1);
            wcs_maybe_make_user_inactive($subscription->customer_user);
        }
        if ($new_status == 'late-payment-30') {
            $subscription->update_suspension_count($subscription->suspension_count + 1);
            wcs_maybe_make_user_inactive($subscription->customer_user);
        }
        if ($new_status == 'late-payment-60') {
            $subscription->update_suspension_count($subscription->suspension_count + 1);
            wcs_maybe_make_user_inactive($subscription->customer_user);
        }
        if ($new_status == 'late-payment-90') {
            $subscription->update_suspension_count($subscription->suspension_count + 1);
            wcs_maybe_make_user_inactive($subscription->customer_user);
        }
        if ($new_status == 'late-payment-120') {
            $subscription->update_suspension_count($subscription->suspension_count + 1);
            wcs_maybe_make_user_inactive($subscription->customer_user);
        }
        if ($new_status == 'late-payment-150') {
            $subscription->update_suspension_count($subscription->suspension_count + 1);
            wcs_maybe_make_user_inactive($subscription->customer_user);
        }
        if ($new_status == 'late-payment-180') {
            $subscription->update_suspension_count($subscription->suspension_count + 1);
            wcs_maybe_make_user_inactive($subscription->customer_user);
        }
        if ($new_status == 'fraud') {
            $subscription->update_suspension_count($subscription->suspension_count + 1);
            wcs_maybe_make_user_inactive($subscription->customer_user);
        }
        if ($new_status == 'bad-payment') {
            $subscription->update_suspension_count($subscription->suspension_count + 1);
            wcs_maybe_make_user_inactive($subscription->customer_user);
        }
        if ($new_status == 'expired-offer') {
            $subscription->update_suspension_count($subscription->suspension_count + 1);
            wcs_maybe_make_user_inactive($subscription->customer_user);
        }
    }

    /**
     * Add the new status on the bulk actions drop down of the link
     *
     * @access public
     *
     * @param array $bulk_actions current bulk action array.
     * @return array $bulk_actions with the new status added to it.
     */
    public function add_new_status_bulk_actions($bulk_actions)
    {
        
        $bulk_actions['like-on-hold'] = _x('Mark Falla pago inicial', 'an action on a subscription', 'custom-wcs-status-texts');
        $bulk_actions['late-payment'] = _x('Mark Pago Demorado', 'an action on a subscription', 'custom-wcs-status-texts');
        $bulk_actions['late-payment-30'] = _x('Mark Pago Demorado 30', 'an action on a subscription', 'custom-wcs-status-texts');
        $bulk_actions['late-payment-60'] = _x('Mark Pago Demorado 60', 'an action on a subscription', 'custom-wcs-status-texts');
        $bulk_actions['late-payment-90'] = _x('Mark Pago Demorado 90', 'an action on a subscription', 'custom-wcs-status-texts');
        $bulk_actions['late-payment-120'] = _x('Mark Pago Demorado 120', 'an action on a subscription', 'custom-wcs-status-texts');
        $bulk_actions['late-payment-150'] = _x('Mark Pago Demorado 150', 'an action on a subscription', 'custom-wcs-status-texts');
        $bulk_actions['late-payment-180'] = _x('Mark Pago Demorado 180', 'an action on a subscription', 'custom-wcs-status-texts');
        $bulk_actions['fraud'] = _x('Mark Fraude', 'an action on a subscription', 'custom-wcs-status-texts');
        $bulk_actions['bad-payment'] = _x('Mark No Pago', 'an action on a subscription', 'custom-wcs-status-texts');
        $bulk_actions['expired-offer'] = _x('Mark Finalizado Oferta Aceptada', 'an action on a subscription', 'custom-wcs-status-texts');
        return $bulk_actions;
    }

    /**
     * Deals with bulk actions. The style is similar to what WooCommerce is doing. Extensions will have to define their
     * own logic by copying the concept behind this method.
     *
     * @access public
     *
     */
    public function parse_bulk_actions()
    {

        // We only want to deal with shop_subscriptions. In case any other CPTs have an 'active' action
        if (!isset($_REQUEST['post_type']) || 'shop_subscription' !== $_REQUEST['post_type'] || !isset($_REQUEST['post'])) {
            return;
        }

        $action = '';

        if (isset($_REQUEST['action']) && -1 != $_REQUEST['action']) {
            $action = $_REQUEST['action'];
        } elseif (isset($_REQUEST['action2']) && -1 != $_REQUEST['action2']) {
            $action = $_REQUEST['action2'];
        }

        switch ($action) {
            case 'active':
            case 'on-hold':
            case 'cancelled':
            case 'like-on-hold':
            case 'late-payment':
            case 'late-payment-30':
            case 'late-payment-60':
            case 'late-payment-90':
            case 'late-payment-120':
            case 'late-payment-150':
            case 'late-payment-180':
            case 'fraud':
            case 'bad-payment':
            case 'expired-offer':
                $new_status = $action;
                break;
            default:
                return;
        }

        $report_action = 'marked_' . $new_status;

        $changed = 0;

        $subscription_ids = array_map('absint', (array) $_REQUEST['post']);

        $sendback_args = array(
            'post_type' => 'shop_subscription',
            $report_action => true,
            'ids' => join(',', $subscription_ids),
            'error_count' => 0,
        );

        foreach ($subscription_ids as $subscription_id) {
            $subscription = wcs_get_subscription($subscription_id);
            $order_note = _x('Subscription status changed by bulk edit:', 'Used in order note. Reason why status changed.', 'woocommerce-subscriptions');

            try {
                if ('cancelled' == $action) {
                    $subscription->cancel_order($order_note);
                } else {
                    $subscription->update_status($new_status, $order_note, true);
                }

                // Fire the action hooks
                switch ($action) {
                    case 'active':
                    case 'on-hold':
                    case 'cancelled':
                    case 'like-on-hold':
                    case 'late-payment':
                    case 'late-payment-30':
                    case 'late-payment-60':
                    case 'late-payment-90':
                    case 'late-payment-120':
                    case 'late-payment-150':
                    case 'late-payment-180':
                    case 'fraud':
                    case 'bad-payment':
                    case 'expired-offer':
                    case 'trash':
                        do_action('woocommerce_admin_changed_subscription_to_' . $action, $subscription_id);
                        break;
                }

                $changed++;
            } catch (Exception $e) {
                $sendback_args['error'] = urlencode($e->getMessage());
                $sendback_args['error_count']++;
            }
        }

        $sendback_args['changed'] = $changed;
        $sendback = add_query_arg($sendback_args, wp_get_referer() ? wp_get_referer() : '');
        wp_safe_redirect(esc_url_raw($sendback));

        exit();
    }


    /**
     * Add css to admin dashboard
     *
     * @access public
     *
     * @param string top level hook for current page
     *
     */
    public function custom_subscription_status_style($hook)
    {
        wp_register_style('subscription-status-style', plugin_dir_url(__FILE__) . 'assets/css/subscription-status.css');
        if ('edit.php' == $hook && $_GET['post_type']=='shop_subscription') {
            wp_enqueue_style('subscription-status-style');
        }
    }
}