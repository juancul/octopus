<?php

/**
 * A plugin that adds collection information to the woocommerce subscription edit page
 *
 * @package cul-woocommerce-remove-checkout-fields-renewals
 *
 * Plugin Name:       CUL - Remove checkout fields for renewal payments
 * Description:       Plugin that Remove checkout fields for renewal payments
 * Version:           1.0
 * Author:            CUL
 */

//Find the offer related product in the active cart
function cul_find_offer_product_in_cart() {

    $products = WC()->cart->cart_contents;
    $cartTitles = '';
    foreach ($products as $product) {
        $cartTitles .= $product['quantity'] . '-' . $product['data']->get_title();;
    }

    if (strpos($cartTitles, 'Oferta por alquiler') !== false) {
        return true;
    }

    else {
      return false;
    }
  
}

/* Hide checkout fields for renewl payment*/

add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');

function custom_override_checkout_fields($fields) {
    $cart_data = WC()->session->get('cart');
    $cart = $cart_data[array_key_first($cart_data)];
    if(isset($cart['subscription_renewal']) && isset($cart['subscription_renewal']['subscription_id'])) {
        //unset($fields['billing']);
        echo '<script>
                setTimeout(function(){ 
                    var address_1 = document.getElementById("billing_address_1").value.length;
                    var nhood = document.getElementById("billing_nhood").value.length;
                    var phone = document.getElementById("billing_phone").value.length;
                    var docid = document.getElementById("billing_docid").value.length;
            
                    if (address_1 != 0 && nhood != 0 && phone != 0 && docid != 0){
                      
                      document.getElementsByClassName("woocommerce-billing-fields__field-wrapper")[0].style.display = "none";              
                    }
                    }, 10);
                </script>

                <style> 
                    /*.woocommerce-billing-fields__field-wrapper { 
                        display:none;!important; 
                    }*/
                    .woocommerce-shipping-totals { 
                        display:none;!important; 
                    }
                    .woocommerce-additional-fields { 
                        display:none;!important; 
                    }
                    .woocommerce-billing-fields h3 { 
                        display:none;!important; 
                    }
                    .cart-notice { 
                        display:none;!important; 
                    }
                </style>';
    }
    else if (cul_find_offer_product_in_cart() === true) {
        $notice = '<div class="woocommerce-info">
                    <strong><span class="cart-notice" style="color: #a374dd">Este es un pago para oferta.</span></strong>
                </div>';
        echo $notice.' <script>
                setTimeout(function(){ 
                    var address_1 = document.getElementById("billing_address_1").value.length;
                    var nhood = document.getElementById("billing_nhood").value.length;
                    var phone = document.getElementById("billing_phone").value.length;
                    var docid = document.getElementById("billing_docid").value.length;
            
                    if (address_1 != 0 && nhood != 0 && phone != 0 && docid != 0){
                      
                      document.getElementsByClassName("woocommerce-billing-fields__field-wrapper")[0].style.display = "none";              
                    }
                    }, 10);
                </script>

                <style> 
                    /*.woocommerce-billing-fields__field-wrapper { 
                        display:none;!important; 
                    }*/
                    .woocommerce-shipping-totals { 
                        display:none;!important; 
                    }
                    .woocommerce-additional-fields { 
                        display:none;!important; 
                    }
                    .woocommerce-billing-fields h3 { 
                        display:none;!important; 
                    }
                    .plan-commitment { 
                        display:none;!important; 
                    }
                </style>';
    }
    else {
        echo ' <style>
                    .mwb_upsell_offer_parent_wrapper { 
                        display:none;!important; 
                    }
                </style>
                <style> 
                    .woocommerce-billing-fields__field-wrapper { 
                        display:none;!important; 
                    }
                    .woocommerce-shipping-totals { 
                        display:none;!important; 
                    }
                    .woocommerce-additional-fields { 
                        display:none;!important; 
                    }
                    .woocommerce-billing-fields h3 { 
                        display:none;!important; 
                    }
                    .place-order { 
                        display:none;!important; 
                    }
                    .woocommerce-checkout-review-order { 
                        display:none;!important; 
                    }
                    .showlogin { 
                        display:none;!important; 
                    }
                    nsl-container { 
                        display:none;!important; 
                    }
                    #account_password_field { 
                        display:none;!important; 
                    }
                </style>
                <div class="woocommerce-info">
                    <strong><span class="cart-notice" style="color: #a374dd">En este momento no estamos recibiendo solicitudes nuevas de alquiler. Vuelve pronto!</span></strong>
                </div>';
    }
    return $fields;
}