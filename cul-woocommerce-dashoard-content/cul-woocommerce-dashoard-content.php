<?php

/**
 * A plugin that adds collection information to the woocommerce subscription edit page
 *
 * @package cul-woocommerce-dashboard-content
 *
 * Plugin Name:       CUL - Add content to WooCommerce Dashboard
 * Description:       Plugin that Adds content to WooCommerce Dashboard
 * Version:           1.0
 * Author:            CUL
 */

// add the action 
add_filter( 'woocommerce_account_dashboard', 'action_woocommerce_account_dashboard', 10, 0 ); 

// define the woocommerce_account_dashboard callback 
function action_woocommerce_account_dashboard(  ) {
echo "<h3 id='cul-verify-id'>Verifica tu identidad</h3>";
        echo '<center>';
        echo do_shortcode( '[tot-reputation-status auto-launch-when-not-verified="true"]' );
        echo "</center><hr>";
        echo "<br><h3 id='questions-form'>Responde las siguientes preguntas para poder despachar tu alquiler</h3>";
        echo "<br><p>Por favor responde con sinceridad, en algunos casos solicitaremos corroborar las respuestas con solicitudes posteriores, por ejemplo un certificado laboral.</p>";
        echo do_shortcode( '[user-meta-profile form="User Extra Info"]' );
        echo "<br><br>"; 
    // make action magic happen here... 
};