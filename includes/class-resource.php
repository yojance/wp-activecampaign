<?php
/**
 * Active Campaign
 *
 * PHP version 7.2
 *
 * @package WPS\ActiveCampaign
 */

namespace WPS\ActiveCampaign;

/**
 * Class Resource
 * Serves as a base class for all resources/endpoints
 *
 * @package WPS\ActiveCampaign
 */
class Resource {

	/**
	 * Main Active Campaign HTTP Client
	 *
	 * @var $client
	 */
	protected $client;

	/**
	 * Contact constructor.
	 *
	 * @param WP_Client $client Current client.
	 */
	public function __construct( $client ) {
		$this->client = $client;
	}

	/**
	 * Get the client
	 * Should this be protected?
	 *
	 * @return WP_Client
	 */
	public function get_client() {
		return $this->client;
	}
}
