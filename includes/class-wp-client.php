<?php
/**
 * Active Campaign
 *
 * PHP version 7.2
 *
 * @package WPS\ActiveCampaign
 */

namespace WPS\ActiveCampaign;

use WP_Error;

/**
 * Class Client
 *
 * @package WPS\ActiveCampaign
 * @link https://developers.activecampaign.com/reference
 * @link https://developers.activecampaign.com/blog
 */
class WP_Client {

	/**
	 * API Endpoint URL
	 *
	 * @var string $api_url
	 */
	protected $api_url;

	/**
	 * API Version
	 *
	 * @var string $api_version
	 */
	protected $api_version;

	/**
	 * API Key
	 *
	 * @var string $api_key
	 */
	protected $api_key;

	/**
	 * Whether or not to enable debugging
	 *
	 * @var bool $debug
	 */
	protected $debug = true;

	/**
	 * WP_Client constructor.
	 *
	 * @param string $api_key     API Key.
	 * @param string $api_url     API URL.
	 * @param string $api_version API Version.
	 *
	 * @see https://developers.activecampaign.com/reference#authentication
	 */
	public function __construct( $api_key, $api_url = 'https://account.api-us1.com', $api_version = '3' ) {

		$this->api_key     = $api_key;
		$this->api_url     = $api_url;
		$this->api_version = $api_version;

	}

	/**
	 * Get the API URL
	 *
	 * @return string
	 */
	public function get_api_url() {
		return $this->api_url;
	}

	/**
	 * Get the API Version
	 *
	 * @return int
	 */
	public function get_api_version() {
		return $this->api_version;
	}

	/**
	 * Get the API Key
	 *
	 * @return string
	 */
	public function get_api_key() {
		return $this->api_key;
	}

	/**
	 * Post data to an endpoint
	 *
	 * @param string $url  Endpoint URL.
	 * @param array  $data Data required for the endpoint.
	 *
	 * @return array|WP_Error
	 */
	public function post( $url, $data ) {


		$args['method']  = 'POST';
		$args['headers'] = $this->get_default_headers();
		$args['body']    = json_encode( $data ); //phpcs:ignore

		$response = wp_remote_request( $url, $args );

		$this->debug( $url, $data, $response, debug_backtrace()[1] ); // phpcs:ignore

		return $response;
	}

	/**
	 * Get data from an endpoint
	 *
	 * @param string     $url  Endpoint URL.
	 * @param array|null $data Data for the endpoint if needed.
	 *
	 * @return array|WP_Error
	 */
	public function get( $url, $data = null ) {

		$args['method']  = 'GET';
		$args['headers'] = $this->get_default_headers();
		if ( ! empty( $data ) ) {
			$args['body'] = json_encode( $data ); //phpcs:ignore
		}

		$response = wp_remote_request( $url, $args );

		$this->debug( $url, $data, $response, debug_backtrace()[1] ); // phpcs:ignore

		return $response;

	}

	/**
	 * Put data to an endpoint
	 *
	 * @param string     $url  Endpoint URL.
	 * @param array|null $data Data for the endpoint if needed.
	 *
	 * @return array|WP_Error
	 */
	public function put( $url, $data = null ) {

		$args['method']  = 'PUT';
		$args['headers'] = $this->get_default_headers();
		if ( ! empty( $data ) ) {
			$args['body'] = json_encode( $data ); //phpcs:ignore
		}

		$response = wp_remote_request( $url, $args );

		$this->debug( $url, $data, $response, debug_backtrace()[1] ); // phpcs:ignore

		return $response;
	}

	/**
	 * Send delete request to an endpoint
	 *
	 * @param string $url Endpoint URL.
	 *
	 * @return array|WP_Error
	 */
	public function delete( $url ) {

		$args['method']  = 'DELETE';
		$args['headers'] = $this->get_default_headers();

		$response = wp_remote_request( $url, $args );

		$this->debug( $url, [], $response, debug_backtrace()[1] ); // phpcs:ignore

		return $response;
	}

	/**
	 * Get the base endpoint made of API URL and API Version number.
	 *
	 * @return string
	 */
	public function get_base_endpoint(): string {
		return sprintf( '%s/api/%s', $this->get_api_url(), $this->get_api_version() );
	}

	/**
	 * Default Headers
	 *
	 * @return array
	 */
	protected function get_default_headers() {
		return [
			'Content-Type' => 'application/json; charset=utf-8',
			'Api-Token'    => $this->get_api_key(),
		];
	}

	/**
	 * Debug the request
	 *
	 * @param string     $endpoint Endpoint being called.
	 * @param array|null $data     Payload.
	 * @param array      $response Response received from the server.
	 * @param array      $caller   Calling method.
	 */
	private function debug( $endpoint, $data, $response, $caller ): void {

		if ( $this->debug ) {
			$log['caller']              = sprintf( '%s::%s', $caller['class'], $caller['function'] );
			$log['request']['endpoint'] = $endpoint;
			$log['request']['data']     = $data;

			if ( ! is_wp_error( $response ) ) {
				$log['response']['code']         = wp_remote_retrieve_response_code( $response );
				$log['response']['message']      = wp_remote_retrieve_response_message( $response );
				$log['response']['body']['raw']  = wp_remote_retrieve_body( $response );
				$log['response']['body']['json'] = json_decode( wp_remote_retrieve_body( $response ), false );
			}


			//phpcs:ignore
			error_log( print_r( $log, true ) );
		}
	}

}