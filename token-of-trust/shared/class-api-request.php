<?php
/**
 *
 * TOT API Request
 *
 * References
 *   - TOT API docs
 *     https://docs.google.com/document/d/1xQ9yymU1CVt5BWxNsmkI76S3otrMO1kuW3HruMkcKrk/edit#heading=h.iuu091a3j2tn
 *     https://app.tokenoftrust.com/developer/guide/embed/
 *
 */

namespace TOT;

class API_Request extends API_Connection {

	public $endpoint_url;
	public $request_details;
	public $data;

	public function __construct( $endpoint_path, $data = array(), $method = 'POST', $headers = array() ) {

        $connection = parent::__construct();

		if(is_wp_error($connection)) {
			return $connection;
		}

		$this->endpoint_url = $this->base_url . '/' . $endpoint_path;
		$this->set_details($data, $method, $headers);

	}

	public function set_details( $data = array(), $method = 'POST', $headers = array() ) {

        $this->data = $data;
		$this->request_details = array(
			'method' => $method,
			'headers' => array_merge(array(
				'charset' => 'utf-8',
				'Accept-Language' => 'en-US,en;q=0.9'
			), $headers),
			'body' => array_merge($data, array(
				'totApiKey' => $this->public_key,
				'totSecretKey' => $this->secret_key,
				'appDomain' => $this->app_domain
			)),
			'sslverify' => tot_ssl_verify(),
		);

	}

	public function send( $error_callback = null ) {

		$response = wp_remote_post(
			$this->endpoint_url,
			$this->request_details
		);
		return $this->handle_response( $response, $error_callback);

	}

	public function handle_response( $response, $error_callback = null ) {

        $request = $this->request_details;
        $url = $this->endpoint_url;
        $response = new API_Response( $response, $request, $url);

		if ( $response->has_error() && empty( $error_callback ) ) {

			return $response->error;

		} elseif ( $response->has_error() && ! empty( $error_callback ) ) {

			call_user_func( $error_callback, $response, $request, $url, $this->data);
			return $response->error;

		}

		return $response->response_decoded;

	}

}