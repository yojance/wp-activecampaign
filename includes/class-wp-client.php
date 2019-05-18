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
 * @package KO\ActiveCampaign
 */
class WP_Client {

	/**
	 * API Endpoint URL
	 *
	 * @var string $api_url
	 */
	protected $api_url = '';

	/**
	 * API Version
	 *
	 * @var int $api_version
	 */
	protected $api_version = 3;

	/**
	 * API Key
	 *
	 * @var string $api_key
	 */
	protected $api_key = '';

	/**
	 * WP_Client constructor.
	 */
	public function __construct() {

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

		return wp_remote_request( $this->attach_api_key( $url ), $args );

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

		return wp_remote_request( $this->attach_api_key( $url ), $args );

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

		return wp_remote_request( $this->attach_api_key( $url ), $args );

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

		return wp_remote_request( $this->attach_api_key( $url ), $args );

	}

	/**
	 * Get the base endpoint made of API URL and API Version number.
	 *
	 * @return string
	 */
	public function get_base_endpoint(): string {
		return sprintf( '%s/%s', $this->get_api_url(), $this->get_api_version() );
	}

	/**
	 * Attach API Key to a URL
	 *
	 * @param string $url URL Endpoint.
	 *
	 * @return string
	 */
	public function attach_api_key( $url ): string {
		return add_query_arg( [ 'api_key' => $this->get_api_key() ], $url );
	}

	/**
	 * Default Headers
	 *
	 * @return array
	 */
	protected function get_default_headers() {
		return [
			'Content-Type' => 'application/json; charset=utf-8',
		];
	}

}