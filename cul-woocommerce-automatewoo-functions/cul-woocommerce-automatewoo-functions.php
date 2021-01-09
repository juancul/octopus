<?php

/**
 * A plugin that adds collection information to the woocommerce subscription edit page
 *
 * @package cul-woocommerce-automatewoo-functions
 *
 * Plugin Name:       CUL - Woocommerce AutomateWoo Custom Functions
 * Description:       Plugin that adds Custom functions to AutomateWoo
 * Version:           1.0
 * Author:            CUL
 */


/**
 * ALL AUTOMATEWOO CUSTOM FUNCTIONS
 */

/**
 * Custom function to create renewal ordervia AutomateWoo action
 * @param $workflow AutomateWoo\Workflow
 */
function my_automatewoo_create_renewal_order( $workflow ) {

    // retrieve the workflow data from the data layer
    $sub = $workflow->data_layer()->get_subscription();
    //$customer = $workflow->data_layer()->get_customer();

    // Create the renewal order
    wcs_create_renewal_order( $sub );
    $sub->add_order_note( __( 'AutomateWoo Create Renewal Order.', 'woocommerce-subscriptions' ), false, true );
    $workflow->log_action_note( $workflow , __( 'Renewal order created', 'automatewoo' ) );
}

/**
 * Custom function to create change subscription status when late payment is made
 * @param $workflow AutomateWoo\Workflow
 */
function my_automatewoo_change_late_payment_status( $workflow ) {

    // retrieve the workflow data from the data layer
    $sub = $workflow->data_layer()->get_subscription();
    
    // get al related orders to subscription array
    $relared_orders_ids_array = $sub->get_related_orders();

    // count pending orders
    $pending_order_count = 0;
    foreach ($relared_orders_ids_array as $order_id){
        $order = wc_get_order( $order_id );
        //$order_status  = $order->get_status();

        if ( $order->has_status('pending') || $order->has_status('bad-payment') || $order->has_status('unreachable') || $order->has_status('late-payment') ) {
        $pending_order_count += 1;
        }
    }

    // change to proper late status
    if ($pending_order_count == 0) {
        $sub->update_status( 'active' );
        $sub->add_order_note( __( 'AutomateWoo Change Late Payment Status.', 'woocommerce-subscriptions' ), false, true );
        $workflow->log_action_note( $workflow , __( 'Late Payment order paid Subscription status changed to active', 'automatewoo' ) );
    }
    else if ($pending_order_count == 1) {
        $sub->update_status( 'late-payment-30' );
        $sub->add_order_note( __( 'AutomateWoo Change Late Payment Status.', 'woocommerce-subscriptions' ), false, true );
        $workflow->log_action_note( $workflow , __( 'Late Payment order paid Subscription status changed to late-payment-30', 'automatewoo' ) );
    }
    else if ($pending_order_count == 2) {
        $sub->update_status( 'late-payment-60' );
        $sub->add_order_note( __( 'AutomateWoo Change Late Payment Status.', 'woocommerce-subscriptions' ), false, true );
        $workflow->log_action_note( $workflow , __( 'Late Payment order paid Subscription status changed to late-payment-60', 'automatewoo' ) );
    }
    else if ($pending_order_count == 3) {
        $sub->update_status( 'late-payment-90' );
        $sub->add_order_note( __( 'AutomateWoo Change Late Payment Status.', 'woocommerce-subscriptions' ), false, true );
        $workflow->log_action_note( $workflow , __( 'Late Payment order paid Subscription status changed to late-payment-90', 'automatewoo' ) );
    }
    else if ($pending_order_count == 4) {
        $sub->update_status( 'late-payment-120' );
        $sub->add_order_note( __( 'AutomateWoo Change Late Payment Status.', 'woocommerce-subscriptions' ), false, true );
        $workflow->log_action_note( $workflow , __( 'Late Payment order paid Subscription status changed to late-payment-120', 'automatewoo' ) );
    }
    else if ($pending_order_count == 5) {
        $sub->update_status( 'late-payment-150' );
        $sub->add_order_note( __( 'AutomateWoo Change Late Payment Status.', 'woocommerce-subscriptions' ), false, true );
        $workflow->log_action_note( $workflow , __( 'Late Payment order paid Subscription status changed to late-payment-150', 'automatewoo' ) );
    }
    else if ($pending_order_count == 6) {
        $sub->update_status( 'late-payment-180' );
        $sub->add_order_note( __( 'AutomateWoo Change Late Payment Status.', 'woocommerce-subscriptions' ), false, true );
        $workflow->log_action_note( $workflow , __( 'Late Payment order paid Subscription status changed to late-payment-180', 'automatewoo' ) );
    }

}

/**
 * Custom function to add subscription meta data with the number of periods in the whole subscription
 * @param $workflow AutomateWoo\Workflow
 */
function my_automatewoo_subscription_length_meta( $workflow ) {
    $subscription = $workflow->data_layer()->get_subscription();
    $subscription_length = wcs_estimate_periods_between( $subscription->get_time( 'start' ), $subscription->get_time( 'end' ), $subscription->get_billing_period() );
    
    add_post_meta( $subscription->id, 'aw_subscription_length', $subscription_length, true );

    $workflow->log_action_note( $workflow , __( 'subscription length is: '.$subscription_length, 'automatewoo' ) );
}


/**
 * Custom function to change subscription status to wc-expired-offer when and offer is completed and log offer id and order id in the subscription metadata
 * @param $workflow AutomateWoo\Workflow
 */
function my_automatewoo_subscrition_status_finalized_offer( $workflow ) {
    //get order id from data layer
    $order = $workflow->data_layer()->get_order();
    $order_id = $order->id;
    
    // get offer id from order
    global $wpdb;
    $offer_ids_query = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'offer_order_id' AND meta_value = $order->id");
    $offer_id = $offer_ids_query[0]->post_id;

    //get sub id from postmeta of offer
    $subscription_id = get_post_meta( $offer_id, 'offer_subscription_id', true );

    //change sub status with sub id
    $subscription_obj = wcs_get_subscription($subscription_id);
    $subscription_obj->update_status( 'expired-offer' );

    //Add offer and order to subscription postmeta
    add_post_meta( $subscription_id, 'aw_offer_order_id', $order_id, true );
    add_post_meta( $subscription_id, 'aw_offer_id', $offer_id, true );

    //Automatewoo log
    $workflow->log_action_note( $workflow , __( 'subscription moved to finalized with offer (expired-offer) with order id:'.$order_id. ' and offer id: '.$offer_id.' Subscription id: '.$subscription_id, 'automatewoo' ) );
}