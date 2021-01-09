<?php

require 'tot-test-origin.php';

function tot_is_production() {

	$result = false;

    if(isset($_COOKIE['totForceTestMode'])) {
	    $result = false;
    }else {
        $result = !is_wp_error(tot_keys_work('live')) && tot_keys_work('live');
    }

    return apply_filters('tot_is_production', $result);
}

function tot_origin() {
    if (is_wp_error(tot_is_production())) {
        return tot_test_origin();
    } else {
        return tot_is_production() ? tot_production_origin() : tot_test_origin();
    }
}

function tot_get_current_origin()
{

    $port = $_SERVER['SERVER_PORT'];
    $host = $_SERVER['HTTP_HOST'];
    $domain = ($port == '80') || ($port == '443') ? $host : $host . ':' . $port;
    $protocol = isset($_SERVER['HTTPS']) && (strtoupper($_SERVER['HTTPS']) == 'ON') ? 'https' : 'http';

    return $protocol . '://' . $domain;
}

function tot_user_id($wp_user_id = NULL, $order = NULL, $auto_create_guid_for_user = true)
{
    $id = !empty($wp_user_id) ? $wp_user_id : get_current_user_id();

    if (!empty($id)) {
        // We can look up (and store) on the user object.

        // Try with traditional guid.
        $tot_appuserid_as_guid = tot_get_stored_appuserid_as_guid($id);
        if (!empty($tot_appuserid_as_guid)) {
            return $tot_appuserid_as_guid;
        }

        // Try with newer email hash.
        $tot_appuserid_as_hash = tot_get_stored_appuserid_as_hash($id);
        if (!empty($tot_appuserid_as_hash)) {
            return $tot_appuserid_as_hash;
        }
    }

    // 1. Try creating with an email hash.
    $tot_appuserid_as_hash = tot_create_appuserid_from_email($wp_user_id, $order);
    if (isset($tot_appuserid_as_hash)) {
        if (!empty($id)) {
            $database_key = 'tot_email_hash';
            add_user_meta(
                $id,
                $database_key,
                $tot_appuserid_as_hash,
                true
            );
        }
        return $tot_appuserid_as_hash;
    }

    if ($auto_create_guid_for_user && !empty($id)) {
        // 2. If email hash fails - use a guid.
        $guid = tot_create_guid();
        $database_key = 'tot_guid';
        add_user_meta(
            $id,
            $database_key,
            $guid,
            true
        );
        return $guid;
    }

    return null;
}

function tot_get_stored_appuserid_as_guid($user_id = NULL)
{
    return tot_get_user_attr('tot_guid', $user_id);
}

function tot_get_stored_appuserid_as_hash($user_id = NULL)
{
    return tot_get_user_attr('tot_email_hash', $user_id);
}

function tot_get_user_attr($database_key, $user_id = NULL)
{
    $id = isset($user_id) && $user_id !== NULL ? $user_id : get_current_user_id();
    return get_user_meta(
        $id,
        $database_key,
        true
    );
}


function tot_production_website()
{
    return 'https://tokenoftrust.com';
}

function tot_production_origin()
{
    return 'https://app.tokenoftrust.com';
}

function tot_is_error( $response_object ) {

	if(!isset($response_object) || !isset($response_object['body'])) {
		return false;
	}
	$decoded = json_decode($response_object['body']);

	if( $decoded->content->type === 'error' ) {
		return true;
	}else {
		return false;
	}

}

function tot_get_setting_prod_domain() {
    $options = get_option('tot_options');

    //Remove headers(https://, www., etc.) from domains names
    if( isset($options) && array_key_exists('tot_field_prod_domain', $options)) {
        return tot_scrub_prod_domain($options['tot_field_prod_domain']);
    }
}

/*
 * Replaces all instances of unnecessary domain name headers.
 */
function tot_scrub_prod_domain($domain){
    if(!empty($domain) && isset($domain)) {
        $domain_check_array = array("https://", "http://", "www.", "https:/", "https//", "https:", "http:/", "http//", "http:");
        foreach ($domain_check_array as $value) {
            if (strpos($domain, $value) !== false) {
                $domain = str_replace($value, "", $domain);
            }
        }
        return trim($domain);
    }
}

function tot_normalize_url_path( $url ) {
    $url = strtolower($url);
    $url = preg_replace('/\s*/', '', $url);
    if (preg_match('/^https?:\/\//', $url)) {
        $url = preg_replace('/^https?:\/\//', '', $url);
        $pos = strpos($url,'/');
        if ($pos !== false) {
            $url = substr_replace($url,'',0, $pos);
        }
    }
    $url = preg_replace('/\/$/', '', $url);
    $url = preg_replace('/^\/*/', '', $url);
    $url = strtolower($url);
    return $url;
}

function tot_get_setting_license_key() {
    $options = get_option('tot_options');

    if( isset( $options ) ) {
        if(isset($options['tot_field_license_key'])) {
            $app_license = $options['tot_field_license_key'];
            return trim($app_license);
        }
    }
}

function tot_respond_to_error( $error_key, $error_description, $error_details ) {
	return new WP_Error( $error_key, $error_description, $error_details );
}

function tot_display_error($error)
{
    if (tot_debug_mode()) {
        tot_always_display_error($error);
    }
}

function tot_error_text($error)
{
    $error_codes = $error->get_error_codes();
    $html = '';
    foreach ($error_codes as $code) {
        $html .= $error->get_error_message($code) . ' ';
        if ($error->get_error_data($code)) {
            $html .= $error->get_error_data($code) . ' ';
        }
    }
    return $html;
}

function tot_always_display_error($error)
{
	if(!method_exists($error, 'get_error_codes')) {
		return;
	}
    $error_codes = $error->get_error_codes();
    echo '<pre>';
    foreach ($error_codes as $code) {
        echo '----------' . "\n";
        echo $error->get_error_message($code) . "\n";
        if ($error->get_error_data($code)) {
            echo "\n";
            print_r($error->get_error_data($code));
            echo "\n";
        }
        echo '----------' . "\n";
    }
    echo '</pre>';
}

function tot_is_json($string)
{
    if (is_string($string)) {
        return is_array(json_decode($string, true)) ? true : false;
    }
    return false;
}

function tot_create_guid()
{
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);
        return $uuid;
    }
}

function tot_create_appuserid_from_email($wp_user_id = null, $order = null)
{
    $app_id = tot_get_app_id();
    $user_data = get_userdata($wp_user_id);

    $has_user_email = !empty($user_data) && !empty($user_data->user_email);
    if ($has_user_email) {
        $email_to_hash = $user_data->user_email;
    } else {
        $email_to_hash = empty($order) ? null : $order->get_billing_email();
    }

    return tot_generate_app_userid_from_email_and_appid($email_to_hash, $app_id);
}

/**
 * @param $email
 * @param $app_id
 * @return string
 */
function tot_generate_app_userid_from_email_and_appid($email, $app_id)
{
    if (empty($app_id) || empty($email)) {
        return NULL;
    }

    $hyphen = chr(45); // "-"
    $appUseridPreHash = strtolower($email) . $hyphen . $app_id;
    $app_userid = hash('sha3-256', $appUseridPreHash);
    return $app_userid;
}

function tot_default_successful_mock_response()
{
    return array(
        'headers' => (object)array(),
        'body' => json_encode('{}'),
        'response' => array(
            'code' => 200,
            'message' => 'Ok'
        )
    );
}

function tot_api_call($method, $endpoint, $user_locale, $data, $mock_response = null)
{
    $requestUrl = tot_origin() . $endpoint;
    $public_key = tot_get_public_key();
    $secret_key = tot_get_secret_key();

    if (is_wp_error($public_key)) {
        return array('error' => $public_key);
    } elseif (is_wp_error($secret_key)) {
        return array('error' => $secret_key);
    }

    // check to make sure the user is not trying to run from an unsupported localhost port.
    $localhost = "localhost";
    $port = $_SERVER['SERVER_PORT'];
    $host = $_SERVER['HTTP_HOST'];

    if (substr($host, 0, strlen($localhost)) === $localhost && ($port && !tot_isSupportedLocalhostPort($port))) {
        global $tot_supportedLocalhostPorts;
        return array('error' => tot_respond_to_error_with_link(
            'tot_set_connection',
            'Unsupported localhost port. Please try again with a supported port.', array(
            'supportedLocalhostPorts' => $tot_supportedLocalhostPorts
        )));
    }

    $appDomain = tot_get_option('tot_field_prod_domain');
    $request_data = array_merge(array(
        'totApiKey' => $public_key,
        'totSecretKey' => $secret_key,
        'appDomain' => $appDomain
    ), $data);

    $requestDetails = array(
        'method' => $method,
        'headers' => array(
            'charset' => 'utf-8',
            'Accept-Language' => $user_locale),
        'body' => $request_data
    );
	$response_content = null;
    if (isset($mock_response)) {

        $response = $mock_response;
        $response_content = json_decode($mock_response['body']);

    } else {

        $response = wp_remote_post(
            $requestUrl,
            $requestDetails
        );

        if (is_wp_error($response)) {

            $error = tot_respond_to_error_with_link('tot_api_error', 'There was an error connecting to the Token of Trust API.', array(
                'request_url' => $requestUrl,
                'request' => $requestDetails,
                'response' => $response
            ));

        } else {

            $decoded = json_decode($response["body"]);

            if (!$decoded || !$decoded->content || (isset($decoded->content->type) && ($decoded->content->type === 'error')) || ($response['response']['code'] == 404)) {
                $error = tot_respond_to_error_with_link('tot_api_error_decode', 'The Token of Trust API responded with an error.', array(
                    'request_url' => $requestUrl,
                    'request' => $requestDetails,
                    'response' => $response
                ), $decoded);
            } else {

                $response_content = $decoded->content;
            }
        }
    }
    if(!isset($error)) $error = "No error";


    return array(
        'error' => $error,
        'request_details' => $requestDetails,
        'response' => $response,
        'response_content' => $response_content
    );

}
