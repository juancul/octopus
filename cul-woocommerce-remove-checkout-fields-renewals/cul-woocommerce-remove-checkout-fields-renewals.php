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
        $cartTitles .= $product['data']->get_title();
    }

    if (strpos($cartTitles, 'Oferta por alquiler') !== false) {
        return true;
    }

    else {
      return false;
    }
  
}

// This function returns the smallest amount of months one of the plans has in the cart
function cul_find_plan_duration_in_cart() {

    $products = WC()->cart->cart_contents;
    $all_variation_titles = '';
    foreach ($products as $product) {
        $variation_id = $product['variation_id'].'<br>';
        $all_variation_titles .= get_the_title($variation_id);

        if (strpos($all_variation_titles, '6 Meses') !== false) {
            return 6;
        }
        else if (strpos($all_variation_titles, '9 Meses') !== false) {
            return 9;
        }
        else if (strpos($all_variation_titles, '12 Meses') !== false) {
            return 12;
        }
        else if (strpos($all_variation_titles, '18 Meses') !== false) {
            return 18;
        }

        else {
          return false;
        }
        
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
        //Show a message depending of the smallest plan in the cart
        if (cul_find_plan_duration_in_cart() == 6){
            echo '<div class="woocommerce-info">
                    <strong><span class="cart-notice" style="color: #a374dd">Este alquiler es un compromiso por 6 meses. Solo podrás hacer una oferta para quedarte con los productos si vuelves a alquilar por otros 6 meses una vez termines este plan</span></strong>
              </div>';
        }
        else if (cul_find_plan_duration_in_cart() == 9){
            echo '<div class="woocommerce-info">
                    <strong><span class="cart-notice" style="color: #a374dd">Este alquiler es un compromiso por 9 meses. Solo podrás hacer una oferta para quedarte con los productos si vuelves a alquilar por otros 4 meses una vez termines este plan</span></strong>
              </div>';
        }
        else if (cul_find_plan_duration_in_cart() == 12){
            echo '<div class="woocommerce-info">
                    <strong><span class="cart-notice" style="color: #a374dd">Este alquiler es un compromiso por 12 meses. Solo podrás hacer una oferta para quedarte con los productos si vuelves a alquilar por otros 2 meses una vez termines este plan</span></strong>
              </div>';
        }
        else if (cul_find_plan_duration_in_cart() == 18){
            echo '<div class="woocommerce-info">
                    <strong><span class="cart-notice" style="color: #a374dd">Este alquiler es un compromiso por 18 meses. Solo podrás hacer una oferta para quedarte con los productos una vez termines este plan</span></strong>
              </div>';
        }
        else{
            echo '<div class="woocommerce-info">
                    <strong><span class="cart-notice" style="color: #a374dd">Recuerda que te está comprometiendo a un plan de 6, 12 o 18 meses. Si el plan al que te comprometes es de 6, 9 o 12 meses recuerda que para hacer una oferta debes alquilar algunos meses más.</span></strong>
              </div>';

        }
        
        /*echo ' <style>
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
                </div>';*/
    }
    return $fields;
}