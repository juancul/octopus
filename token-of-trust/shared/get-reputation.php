<?php

use TOT\API_Request;

function tot_get_wc_order_reputation($order_id)
{
    $tot_transaction_id = get_post_meta($order_id, 'tot_transaction_id', true);
    if( empty($tot_transaction_id) ) {
        return null;
    }

    return tot_get_order_reputation($tot_transaction_id);
}

/**
 * @param $tot_transaction_id
 * @return |null
 */
function tot_get_order_reputation($tot_transaction_id)
{
    $request = new API_Request(
        'api/reputation/transaction/' . $tot_transaction_id,
        array(),
        'GET'
    );
    return $request->send();
}

function tot_get_wp_user_reputation($wp_user_id)
{
    $app_userid = !empty($wp_user_id) ? tot_user_id($wp_user_id, null, false) : null;
    return tot_get_user_reputation($app_userid);

}

function tot_get_user_reputation($app_userid)
{
    if( empty($app_userid) ) {
        return null;
    }

    $endpoint_path      = 'api/reputation/' . $app_userid;
    $data               = array(
        'appUserid' => $app_userid
    );
    $request = new API_Request( $endpoint_path, $data, 'GET' );
    return $request->send();
}

