<?php

function tot_respond_to_error_with_link($error_key, $error_description, $error_details, $tot_error = null)
{
    $hash = md5($error_key . $error_description . json_encode($error_details));

    $error = array(
        'timestamp' => date("F j, Y, g:i a"),
        'key' => $error_key,
        'description' => $error_description,
        'details' => $error_details
    );

    if (isset($tot_error) && isset($tot_error->content) && isset($tot_error->content->causedBy)) {
        $tot_loop_error = $tot_error->content;
        while (isset($tot_loop_error->causedBy)) {
            $tot_loop_error = $tot_loop_error->causedBy;
        }
        $error['tot-error'] = $tot_loop_error;
    }

    set_transient('tot_error_' . $hash, json_encode($error), MINUTE_IN_SECONDS * 10);

    return new WP_Error($error_key, $error_description . ' <a href="' . admin_url('admin.php') . '?page=totsettings&tot-error=' . $hash . '">See details</a>, details will expire in 10 minutes.');
}

function tot_option_has_a_value( $value ) {

    if(is_wp_error($value)) {
        tot_respond_to_error_with_link('tot_field_error', 'There was an error retrieving the field', array(
            'value' => $value
        ));
        return false;
    }

    if (!isset($value) || ($value === false) || ($value === '')) {
        return false;
    }

    return true;
}