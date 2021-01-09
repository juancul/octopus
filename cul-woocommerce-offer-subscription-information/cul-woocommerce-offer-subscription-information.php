<?php

/**
 * A plugin that adds collection information to the woocommerce subscription edit page
 *
 * @package cul-woocommerce-offer-subscription-information
 *
 * Plugin Name:       CUL - Offers for Woocommerce rental information
 * Description:       Plugin that adds  a maken an offer button to subscription and adds subscription information to the woocommerce offer edit page
 * Version:           1.0
 * Author:            CUL
 */



add_action('make_offer_form_before_submit_button', 'add_custom_field_make_offer_form', 10);
add_action('make_offer_after_save_form_data', 'save_custom_field_make_offer_form', 10, 2);
add_action('make_offer_after_buyer_meta_display', 'display_custom_field_buyer_section');
add_action('make_offer_email_display_custom_field_after_buyer_contact_details', 'display_custom_field_after_buyer_contact_details', 10, 1);

function add_custom_field_make_offer_form() {
    ?>
    <div class="woocommerce-make-offer-form-section">
        <label for="offer_postcode"><?php echo __('Alquiler: '.$_POST["subscription-id"], 'offers-for-woocommerce'); ?></label>
        <br><input type="hidden" value="<?php echo $_POST['subscription-id'];?>" required="required" name="offer_subscription_id" id="offer_subscription_id">
        <style>
            .single_add_to_cart_button{
                display:none!important;
            }
        </style>
    </div>
    <?php
}

function save_custom_field_make_offer_form($post_id, $post) {
    if (isset($post['offer_subscription_id']) && !empty($post['offer_subscription_id'])) {
        add_post_meta($post_id, 'offer_subscription_id', $post['offer_subscription_id']);
    }
}

function display_custom_field_buyer_section($post_id) {
    $offer_subscription_id = get_post_meta($post_id, 'offer_subscription_id', true);
    ?>
    <li><span><?php echo __('Alquiler:', 'offers-for-woocommerce'); ?>&nbsp;</span>
        <?php echo (isset($offer_subscription_id)) ?
            stripslashes($offer_subscription_id) : __('Missing Meta Value', 'offers-for-woocommerce'); ?>
    </li>
    <?php
}

function display_custom_field_after_buyer_contact_details($post_id) {
    $offer_subscription_id = get_post_meta($post_id, 'offer_subscription_id', true);
    echo (isset($offer_subscription_id) && !empty($offer_subscription_id)) ?
        '<br /><strong>' . __('Alquiler:', 'offers-for-woocommerce') . '&nbsp;</strong>' . stripslashes($offer_subscription_id) : '';
}

// Add meta box for collections information
add_action( 'add_meta_boxes', 'offers_rental_data_box' );
function offers_rental_data_box() {
    add_meta_box(
        'offers-meta-box',
        'Información Alquiler',
        'offer_meta_box_callback',
        'woocommerce_offer',
        'side',
        'core'
    );
}

function offer_meta_box_callback( $post )
{

        $offer_subscription_id = get_post_meta($post->ID, 'offer_subscription_id', true);
        $sub_user_email =get_post_meta( $post->ID, 'offer_email', true );
        $sub_user = get_user_by( 'email', $sub_user_email );
        $sub_user_id = $sub_user->ID;
    if($offer_subscription_id){
        $subscription = wcs_get_subscription($offer_subscription_id);
        $subscription_length = wcs_estimate_periods_between( $subscription->get_time( 'start' ), $subscription->get_time( 'end' ), $subscription->get_billing_period() );
        $subscription_payments = $subscription->get_completed_payment_count();
        $subscription_relared_orders = $subscription->get_related_orders();
        $recurring_total = $subscription->get_total();

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
       /* $allSubscriptions = WC_Subscriptions_Manager::get_users_subscriptions($sub_user_id);
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
                }*/

        //Start Meta Box Information 
        echo 'Pagos hechos en el plan: ' . $subscription_completed_order_count;
        if ($subscription_pending_order_count > 0){
            echo '<br><br><span style ="background-color: #f54b42; color: #ffffff; padding: 3px;border-radius: 2px;">Pagos pendientes en el plan: ' . $subscription_pending_order_count . '</span>';
            echo '<br><br><span style ="background-color: #f54b42; color: #ffffff; padding: 3px;border-radius: 2px;">Valor pendiente: ' . wc_price($pending_total) . '</span>';
        }
        echo '<br><br>Pagos plan total: ' . $subscription_length;
        echo '<br><br>Pagos restantes en plan: ' . ($subscription_length-$subscription_completed_order_count); 
        echo '<br><br>Valor restante en plan: ' . wc_price(($subscription_length-$subscription_completed_order_count)*$recurring_total);
        echo '<br><br>Oferta Aceptable: ' . wc_price((($subscription_length-$subscription_completed_order_count)*$recurring_total)*.9);
    }
    else {
       echo 'No relacionó alquiler<br> <a href ="https://vivecul.com.co/wp-admin/edit.php?post_type=shop_subscription&_customer_user='.$sub_user_id.'" target="_blank"> Ver Alquileres</a>';
    }
}


/**
*Display Make an Offer button in subscription detail page
*/
add_action('woocommerce_subscription_details_table', 'add_offer_button');

function add_offer_button($subscription) {       
    
    $subscription_relared_orders = $subscription->get_related_orders();
    $recurring_total = $subscription->get_total();
    $subscription_completed_order_count = 0;
    $subscription_pending_order_count = 0;
    $pending_total = 0;
    $subscription_length = wcs_estimate_periods_between( $subscription->get_time( 'start' ), $subscription->get_time( 'end' ), $subscription->get_billing_period() );
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

    $suggested_offer = ($subscription_length - $subscription_completed_order_count) * $recurring_total;
    //echo $subscription_length.'<br>';
    //echo $subscription_completed_order_count.'<br>';
    //echo ($subscription_length - $subscription_completed_order_count).'<br>';

    if (($subscription_completed_order_count/$subscription_length)>.8) {
        echo '<h2>Hacer una oferta</h2>
               <p>Puedes hacer una oferta para quedarte con el/los producto(s) que tienes en este alquiler haciendo clic en este botón:</p>';
               
           /* if ($subscription_length-$subscription_completed_order_count > 8){
               echo '<p>Oferta sugerida en este momento: <strong>'. wc_price($suggested_offer*.9).' a '. wc_price($suggested_offer*1.1).'</strong></p>';
            } 
            else if ($subscription_length-$subscription_completed_order_count > 2 && $subscription_length-$subscription_completed_order_count <= 8){
               echo '<p>Oferta sugerida en este momento: <strong>' . wc_price($suggested_offer*.95).' a '. wc_price($suggested_offer*1.1).'</strong></p>';
            }
            else if ($subscription_length-$subscription_completed_order_count > 0 && $subscription_length-$subscription_completed_order_count <= 2){
               echo '<p>Oferta sugerida en este momento: <strong>' . wc_price($suggested_offer).' a '. wc_price($suggested_offer*1.1).'</strong></p>';
            }else if ($subscription_length-$subscription_completed_order_count == 0 ){
               echo '<p>Oferta sugerida en este momento mayor a <strong>$5000</strong></p>';
            }  */  

        //echo '<p>Esto es un cálculo basado en tus pagos cumplidos. Puedes ofrecer otro valor comlpletamente diferente si deseas.</p>';

        /*echo '<a href="'.site_url().'/producto/oferta-por-alquiler/?subscription='.$subscription->ID.'" class="button">Hacer una oferta</a><br>
               <br><br><br>';*/ 

        echo '<form action="/producto/oferta-por-alquiler/" method="post">
                <input type="hidden" name="subscription-id" value="'.$subscription->ID.'" />
                <input type="submit" value="Hacer una oferta" class="button"/>
              </form><br><br><br>';
    }
}