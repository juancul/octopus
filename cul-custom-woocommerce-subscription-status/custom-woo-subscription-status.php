<?php

/**
 * - Add new status to the status list.
 * - Show new status in drop down only if the current subscription has certain status.
 * - Handle update code for new status.
 * - Show status option in bulk action dropdown on the listing page
 * - Add custom color for the new status tag on the list page
 * - Handle bulk update action
 * - Add Same status in Woocommerce
 * - Mark all subscription in an order with same status if status is changed from woocommerce order page.
 *
 * @package custom-woocommerce-subscription-status
 *
 * Plugin Name:       CUL - Custom Woocommerce Subscription Status Late Payments
 * Description:       Plugin to add new custom woocommerce subscription statuses for bad payment, late payment and fraud similar to `On Hold` status
 * Version:           1.0.1
 * Author:            CUL
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

require plugin_dir_path(__FILE__) . 'class-custom-woocommerce-subscriptions-status.php';
$CWSS = new Custom_Woocommerce_Subscription_Status();
$CWSS->run(); // initiate the status hooks from woocommerce subscription

/*require plugin_dir_path(__FILE__) . 'class-custom-woocommerce-status-for-subscription.php';
$CWSFS = new Custom_Woocommerce_Status_For_Subscription();
$CWSFS->run(); // initiate the status hooks from woocommerce*/