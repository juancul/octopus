<?php

/**
 * A plugin that adds collection information to the woocommerce subscription edit page
 *
 * @package cul-woocommerce-rental-collections
 *
 * Plugin Name:       CUL - Woocommerce rental collections information
 * Description:       Plugin that adds collection information to the woocommerce subscription edit page
 * Version:           1.0
 * Author:            CUL
 */


// Add meta box for collections information
add_action( 'add_meta_boxes', 'collections_data_box' );
function collections_data_box() {
    add_meta_box(
        'collections-meta-box',
        'Info Cartera',
        'collections_meta_box_callback',
        'shop_subscription',
        'side',
        'core'
    );
}

// Callback that displays collections information in the meta box
function collections_meta_box_callback( $post )
{
    
    
    $name = get_post_meta( $post->ID, '_billing_first_name', false )[0]." ".get_post_meta( $post->ID, '_billing_last_name', false )[0];
    $email = get_post_meta( $post->ID, '_billing_email', false )[0];
    $b_phone = get_post_meta( $post->ID, '_billing_phone', false )[0];

    $subscription = wcs_get_subscription($post->ID);
    $sub_user_id =get_post_meta( $post->ID, '_customer_user', false )[0];
    $subscription_length = wcs_estimate_periods_between( $subscription->get_time( 'start' ), $subscription->get_time( 'end' ), $subscription->get_billing_period() );
    $subscription_payments = $subscription->get_completed_payment_count();
    $subscription_relared_orders = $subscription->get_related_orders();

    //Get completed order count for subscription
    $subscription_completed_order_count = 0;
    $subscription_pending_order_count = 0;
    $pending_total = 0;
    foreach ($subscription_relared_orders as $order_id){
        $order = wc_get_order( $order_id );
        
        if ( $order->has_status('completed') ) {
        $subscription_completed_order_count += 1;
        }
        if ( $order->has_status('pending') ) {
        $subscription_pending_order_count += 1;
        $pending_total += $order->get_total();
        }
    }

    //Get subscription counts for user
    $allSubscriptions = WC_Subscriptions_Manager::get_users_subscriptions($sub_user_id);
            $active_sub_quantity = 0;
            $onhold_sub_quantity = 0;
            foreach ($allSubscriptions as $sub){
                $sub_status = $sub['status'];
                if ($sub_status == 'active') {
                    $active_sub_quantity += 1;
                }
                else if ($sub_status == 'on-hold' || $sub_status == 'late-payment-30' || $sub_status == 'late-payment-60' || $sub_status == 'late-payment-90' || $sub_status == 'late-payment-120' || $sub_status == 'late-payment-150' || $sub_status == 'late-payment-180' || $sub_status == 'bad-payment') {
                    $onhold_sub_quantity += 1;
                }
            }

    // Get COMPLETED orders for customer
    $args = array(
        'customer_id' => $sub_user_id,
        'post_status' => 'completed',
        'post_type' => 'shop_order',
        'return' => 'ids',
    );
    $num_orders_completed = 0;
    $num_orders_completed = count( wc_get_orders( $args ) ); // count the array of orders

    //Get family and friend references
    $friend = get_user_meta( $sub_user_id, 'uform_friend_ref', true );
    $friend_tel = get_user_meta( $sub_user_id, 'uform_friend_phone', true );
    $family = get_user_meta( $sub_user_id, 'uform_family_ref', true );
    $family_rel = get_user_meta( $sub_user_id, 'uform_family_relation', true );
    $family_tel = get_user_meta( $sub_user_id, 'uform_family_phone', true );

    
    echo '<h4>Información del usuario</h4>';
    echo get_post_meta( $post->ID, '_billing_first_name', false )[0]." ".get_post_meta( $post->ID, '_billing_last_name', false )[0].'<br><br>';
    echo '<a href="https://wa.me/'.substr($b_phone,1).'" target="_blank"> Whatsapp ' . $b_phone.'</a></strong>';
    echo '<br><br><a href="skype:'.$b_phone.'?call" target="_blank"> Skype ' . $b_phone.'</a></strong>';
    echo '<br><br><strong><a href="mailto:'.$email.'">' . $email . '</a></strong><br>';

    echo '<hr><h4>Información de este alquiler</h4>';
    echo 'Pagos hechos en el plan: ' . $subscription_completed_order_count;
    if ($subscription_pending_order_count > 0){
        echo '<br><br><span style ="background-color: #f54b42; color: #ffffff; padding: 3px;border-radius: 2px;">Pagos pendientes en el plan: ' . $subscription_pending_order_count . '</span>';
        echo '<br><br><span style ="background-color: #f54b42; color: #ffffff; padding: 3px;border-radius: 2px;">Valor pendiente: ' . wc_price($pending_total) . '</span>';
    }
    echo '<br><br>Pagos plan total: ' . $subscription_length;
    echo '<br><br>Pagos restantes en plan: ' . ($subscription_length-$subscription_completed_order_count);

    echo '<hr><h4>Información Global del usuario</h4>';
    echo '<a href="https://vivecul.com.co/wp-admin/edit.php?post_status=wc-completed&post_type=shop_order&_customer_user='.$wp_user_id.'"> Pagos Exitosos Totales: ' . $num_orders_completed . '</a>';
    echo '<br><br><a href="https://vivecul.com.co/wp-admin/edit.php?post_status=wc-active&post_type=shop_subscription&_customer_user='.$wp_user_id.'"> Alquileres En Cumplimiento: ' . $active_sub_quantity . '</a>';
    echo '<br><br><a href="https://vivecul.com.co/wp-admin/edit.php?post_status=wc-on-hold&post_type=shop_subscription&_customer_user='.$wp_user_id.'"> Alquileres Pago Demorado: ' . $onhold_sub_quantity . '</a>';



    if (get_post_status($post->ID) != 'wc-active' && $friend.$family != "") {
            echo '<hr><h4>Referencias</h4>';
            echo 'Amigo: '.$friend.' <a href="skype:57'.$friend_tel.'?call" target="_blank">'.$friend_tel.'</a><br><br>';
            echo 'Familiar: '.$family_rel.' - '.$family.' <a href="skype:57'.$family_tel.'?call" target="_blank">'.$family_tel.'</a>';
    }

}