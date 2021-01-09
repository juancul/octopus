<?php
/**
 *
 * TOT API Response
 */

namespace TOT;

class API_Response {

	public $error            = null;
	public $response_raw     = null;
	public $response_decoded = null;
	public $request          = null;
	public $url              = null;

	public function __construct( $response, $request, $url ) {

		$this->response_raw = $response;
		$this->request      = $request;
		$this->url          = $url;

		$this->set_wp_error();
		$this->decode();
		$this->set_api_error();

	}

	public function set_wp_error() {

		if ( is_wp_error( $this->response_raw ) ) {
			$this->error = tot_respond_to_error_with_link(
				'tot_api_error',
				'There was an error connecting to the Token of Trust API.',
				array(
					'request_url' => $this->url,
					'request'     => $this->request,
					'response'    => $this->response_raw,
				)
			);
		}

	}

	public function decode() {

		if ( null !== $this->error ) {
			return null;
		}

		$decoded = json_decode( $this->response_raw['body'] );

		if (
			empty( $decoded )
			|| ! isset( $decoded->content )
			|| ! isset( $this->response_raw['response']['code'] )
		) {

			$this->error = tot_respond_to_error_with_link(
				'tot_api_error_decode',
				'There was an error with the Token of Trust API response.',
				array(
					'request_url' => $this->url,
					'request'     => $this->request,
					'response'    => $this->response_raw,
				),
				$decoded
			);
			return;

		}

		$this->response_decoded = $decoded->content;
	}

	public function set_api_error() {

		if ( null !== $this->error ) {
			return null;
		}

		$http_code = strval( $this->response_raw['response']['code'] );

		if (
			( isset( $this->response_decoded->content->type ) && ( 'error' === $this->response_decoded->content->type ) )
			|| '2' !== substr( $http_code, 0, 1 )
		) {

			$this->error = tot_respond_to_error_with_link(
				'tot_api_error_response',
				'The Token of Trust API responded with an error.',
				array(
					'request_url' => $this->url,
					'request'     => $this->request,
					'response'    => $this->response_raw,
				),
				$this->response_decoded
			);

		}

	}

	public function has_error() {
		return null !== $this->error;
	}

}