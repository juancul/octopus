<?php

function tot_log_as_html_comment($key, $message, $return=false) {
    $output = " <!-- " . tot_log_key_value($key, $message) . " --> ";
    if(!$return) {
        if (tot_debug_mode()) {
            echo $output;
        }
    }
    return $output;
}

function tot_log_as_html_pre($key, $message, $return=false) {
    $output = '<pre>' . tot_log_key_value($key, $message) . '</pre>';
    if(!$return) {
        if (tot_debug_mode()) {
            echo $output;
        }
    }
    return $output;
}

function tot_log_key_value($key, $message) {
    return "[tot-debug][$key]" . print_r( $message, true );
}

function tot_log_debug($log) {
    if (true === WP_DEBUG && tot_debug_mode()) {
        if (is_array($log) || is_object($log)) {
            error_log(print_r($log, true));
        } else {
            error_log($log);
        }
    }
}