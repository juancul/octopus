<?php

use TOT\Settings;
global $tot_plugin_text_domain;

add_action('template_redirect', 'tot_custom_redirects', 9);

function tot_custom_redirects()
{
    // check for COOKIE related updates.
    tot_check_force_test_mode_url();
    tot_check_for_time_based_cookie('debug_mode');
    tot_check_for_time_based_cookie('checkout_require');
}

add_action('init', tot_add_query_params('ctp_order_key'));
add_action('init', tot_add_query_params('debug_mode'));
add_action('init', tot_add_query_params('checkout_require'));

function tot_add_query_params($query_var) {
    return function() use ($query_var){
        global $wp;
        $wp->add_query_var($query_var);
    };
}

function tot_check_for_time_based_cookie($cookie) {
    $paramValue = get_query_var($cookie, NULL);
    if (isset($paramValue)) {
        setcookie($cookie, $paramValue, time() + 60 * 30, '/');
        // echo "$cookie = $paramValue";
    } else {
        $paramValue = Settings::get_param_or_cookie($cookie);
    }

    if ($paramValue) {
        tot_log_as_html_comment($cookie, $paramValue);
    }
}

// TODO ?debug_mode=1 on the url is probably better than this.
function tot_check_force_test_mode_url()
{

    global $wp;
    if ($wp->request == 'token-of-trust/enable-force-test-mode') {
        setcookie('totForceTestMode', '1', time() + 60 * 60 * 24 * 365, '/');
        echo 'Force test mode is enabled.';
        die();
    } else if ($wp->request == 'token-of-trust/disable-force-test-mode') {
        unset($_COOKIE['totForceTestMode']);
        setcookie('totForceTestMode', null, -1, '/');
        echo 'Force test mode is disabled.';
        die();
    }

}