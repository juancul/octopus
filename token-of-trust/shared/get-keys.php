<?php

function tot_get_keys()
{
    $keys = get_transient('tot_keys');
    $current_origin = site_url();

    if ( ( $keys === false ) || !isset($keys['test']) || !isset($keys['request_domain']) || !isset($keys['app_id']) || ($keys['request_domain'] !== $current_origin) ) {

        $keys = array();
        $keys['live'] = array();
        $keys['test'] = array();

        $test_response = tot_request_license_details(tot_test_origin());
        if (is_wp_error($test_response)) {
            return $test_response;
        } elseif (tot_is_error($test_response)) {
            return tot_respond_to_error_with_link('tot_license_api_error', 'An error occurred when connecting to the Token of Trust license API.', array(
                'response' => $test_response
            ));
        }

        $raw_keys = json_decode($test_response);
        $keys['request_domain'] = $current_origin;
        $keys['app_id'] = $raw_keys->content->appId;
        $keys['app_title'] = $raw_keys->content->appTitle;
        $keys['public_test'] = $raw_keys->content->apiKeys->test->apiKey;
        $keys['secret_test'] = $raw_keys->content->apiKeys->test->secretKey;
	    $keys['wooCommerceBeta'] = isset($raw_keys->content->options->wooCommerceBeta) ? $raw_keys->content->options->wooCommerceBeta : '';
        $keys['test']['webhooks'] = isset($raw_keys->content->options->webhooks) ? json_encode($raw_keys->content->options->webhooks) : '';
        $webhooks = $keys['test']['webhooks'];
        tot_log_debug("Test webhooks settings: '$webhooks'");

        // We need to test the keys bc the license itself was fetched via the license keys.
        $keys['tot_test_request'] = tot_test_connection(tot_test_origin(), $keys['public_test'], $keys['secret_test'] );

        set_transient( 'tot_keys', $keys, DAY_IN_SECONDS * 7 );

        $live_response = tot_request_license_details(tot_production_origin());

        if (is_wp_error($live_response)) {
            $live_response;
        } elseif (tot_is_error($live_response)) {
            tot_respond_to_error_with_link('tot_license_api_error', 'An error occurred when connecting to the Token of Trust license API.', array(
                'response' => $live_response
            ));
        } else {
            $raw_keys = json_decode( $live_response );
            $keys['app_id'] = $raw_keys->content->appId;
            $keys['app_title'] = $raw_keys->content->appTitle;
            $keys['wooCommerceBeta'] = isset($raw_keys->content->options->wooCommerceBeta) ? $raw_keys->content->options->wooCommerceBeta : '';
            $keys['live']['webhooks'] = isset($raw_keys->content->options->webhooks) ? json_encode($raw_keys->content->options->webhooks) : '';
            $webhooks = $keys['live']['webhooks'];
            tot_log_debug("Live webhooks settings: '$webhooks'");
            if(isset( $raw_keys->content->apiKeys->live)){
                $keys['public_live'] = $raw_keys->content->apiKeys->live->apiKey;
                $keys['secret_live'] = $raw_keys->content->apiKeys->live->secretKey;
                $keys['tot_live_request'] = tot_test_connection(tot_production_origin(), $keys['public_live'], $keys['secret_live'] );
            }
            set_transient( 'tot_keys', $keys, DAY_IN_SECONDS * 7 );
        }
    }

    return $keys;
}

/**
 * @param string $key_type - 'live' or 'test'
 * @return bool
 */
function tot_keys_work($key_type = 'test')
{
    $tot_keys = tot_get_keys();
    $request_type = $key_type == 'live' ? 'tot_live_request' : 'tot_test_request';
    if (is_wp_error($tot_keys) || !isset($tot_keys) || !isset($tot_keys[$request_type])) {
        return false;
    }
    return $tot_keys[$request_type];
}


function tot_refresh_keys()
{
    delete_transient('tot_keys');
    $tot_keys = tot_get_keys();
    if (tot_debug_mode()) {
        tot_respond_to_error_with_link('refreshed_keys', 'Token of Trust response for refreshed keys.', array(
            'request_url' => "none",
            'request' => "none",
            'response' => $tot_keys
        ));
    }
    return $tot_keys;
}

function tot_request_license_details($origin = null)
{

    $options = get_option('tot_options');

    if (!isset($options)) {
        return tot_respond_to_error('tot_no_options', 'Token of Trust settings are missing.', array());
    }

    if(isset(get_option('tot_options')['tot_field_license_key'])) {
        $license_key = get_option('tot_options')['tot_field_license_key'];
    }
    if (!isset($license_key)) {
        return tot_respond_to_error('tot_no_license', 'Token of Trust license key is not set in plugin settings.', array());
    }

    $app_domain = tot_get_setting_prod_domain();

    if(!$app_domain) {
        return tot_respond_to_error('tot_no_app_domain', 'Token of Trust setting for Live Site Domain is missing.', array());
    }

    $baseUrl = isset($origin) ? $origin : tot_origin();
    $endpoint = '/api/apps/' . $app_domain;

    $request_details = array(
        'method' => 'GET',
        'headers' => array(
            'Content-Type: application/json',
            'charset: utf-8',
            'authorization: ' . $license_key,
            'referer: ' . $app_domain
        )
    );

    return tot_curl_request($baseUrl, $endpoint, $request_details);
}



function tot_test_connection($baseUrl, $public_key, $secret_key) {
    $endpoint = '/api/accessToken';
    $request_details = array(
        'method' => 'POST',
        'headers' => array(
            'Content-Type: application/json',
            'charset: utf-8',
            'referer: ' . site_url()
        ),
        'body' => array(
            'totApiKey' => $public_key,
            'totSecretKey' => $secret_key,
            'appDomain' => tot_get_setting_prod_domain()
        ),
        'sslverify' => tot_ssl_verify()
    );
    return tot_curl_request($baseUrl, $endpoint, $request_details);
}
/**
 * @param $baseUrl
 * @param $endpoint
 * @param array $request_details
 * @return bool|string|WP_Error
 */
function tot_curl_request($baseUrl, $endpoint, array $request_details, $logResults = false)
{
    $request_url = $baseUrl . $endpoint;

    // Using curl because of this issue https://core.trac.wordpress.org/ticket/37820
    $ch = curl_init();

    if ($request_details['method'] == 'POST' ) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_details['body']));
    }

    if (isset($request_details['query'])) {
        $query = http_build_query($request_details['query']);
        // We're intentionally not polluting $requrest_url to keep errors and logging (below) clean.
        curl_setopt($ch, CURLOPT_URL, $request_url."?".$query);
    } else {
        curl_setopt($ch, CURLOPT_URL, $request_url);
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_details['headers']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, tot_ssl_verify());
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout in seconds

    $output = curl_exec($ch);

    $is_ssl_configured = true;

    if ((curl_errno($ch) == 60)) { //if there's an SSL error

        $is_ssl_configured = false;

        if (class_exists('Requests') && method_exists('Requests', 'get_certificate_path')) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CAINFO, Requests::get_certificate_path());
            $output = curl_exec($ch);
            delete_option('tot_ssl_misconfiguration');
        } else {
            update_option('tot_ssl_misconfiguration', true);
        }

    } else {
        delete_option('tot_ssl_misconfiguration');
    }

    if (curl_errno($ch)) { //check for other CURL errors
        return tot_respond_to_error_with_link('tot_curl_request_connection_error:' . $endpoint, 'There was an error connecting to the Token of Trust API with : ' . $request_url, array(
            'request_url' => $request_url,
            'request' => $request_details,
            'response' => $output,
            'request_error' => curl_errno($ch) . ": " . curl_error($ch),
            'request_info' => curl_getinfo($ch)
        ));

    }

    curl_close($ch);

    if( tot_is_json( $output ) ) {
        $decoded = json_decode( $output );
        if( !$decoded || !$decoded->content || (isset($decoded->content->type) && ($decoded->content->type  === 'error')) ) {

            return tot_respond_to_error_with_link('tot_curl_request_error:' . $endpoint, 'Token of Trust api error with : ' . $request_url, array(
                'request_url' => $request_url,
                'request' => $request_details,
                'response' => $output
            ), $decoded);

        } elseif (!$is_ssl_configured) { //return a error if SSL in not configured and app in is production

            return tot_respond_to_error_with_link('tot_get_ssl_not_configured_error', 'SSL is not properly configured on Wordpress.', array(
                'request_url' => $request_url,
                'request' => $request_details,
                'response' =>
                    'SSL certificate library not found.
					Please download \'cacert.pem\' certificates from https://curl.haxx.se/docs/caextract.html
					Upload the file to your host.
					Add the following line to your php.ini server file: curl.cainfo = "path_to_cert\cacert.pem".'
            ));

        } else {
            if ($logResults) {
                return tot_respond_to_error_with_link('tot_curl_request_results' . $endpoint, 'Token of Trust response for'.$request_url, array(
                    'request_url' => $request_url,
                    'request' => $request_details,
                    'response' => $output
                ));
            }
            return $output;
        }

    } else {
        return tot_respond_to_error_with_link('tot_curl_request_json_error:' . $endpoint, 'Token of Trust invalid json response from : ' . $request_url, array(
            'request_url' => $request_url,
            'request' => $request_details,
            'response' => $output
        ));
    }
}

function tot_live_mode_available() {
    $tot_keys_work = tot_keys_work('live');
    return !is_wp_error($tot_keys_work) && $tot_keys_work;
}

function tot_get_public_key () {
    $is_production = tot_is_production();

    $keys = tot_get_keys();

    if( !is_wp_error($is_production) && !is_wp_error( $keys ) && $is_production ) {

        return $keys['public_live'];

    }elseif( !is_wp_error($is_production) && !is_wp_error( $keys ) ) {

        return $keys['public_test'];

    }else {
        return $keys;
    }
}

function tot_get_app_id () {
    $keys = tot_get_keys();
    return (!empty($keys) && !is_wp_error($keys)) ? $keys['app_id'] : null;
}

function tot_get_secret_key () {

    $is_production = tot_is_production();
    $keys = tot_get_keys();

    if( !is_wp_error($is_production) && !is_wp_error( $keys ) && $is_production ) {

        return $keys['secret_live'];

    } elseif( !is_wp_error($is_production) && !is_wp_error( $keys ) ) {

        return $keys['secret_test'];

    }else {
        return $keys;
    }
}