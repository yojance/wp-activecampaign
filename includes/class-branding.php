<?php
/**
 * Active Campaign
 *
 * PHP version 7.2
 *
 * @package WPS\ActiveCampaign
 * @status  Implemented, Not Tested
 */

namespace WPS\ActiveCampaign;

use WP_Error;

/**
 * Branding
 *
 * Campaigns are broadcast emails sent out to a list of contacts.
 *
 * @package WPS\ActiveCampaign
 * @status  Implemented, Not Tested
 */
class Branding extends Resource {

	/**
	 * Branding constructor.
	 *
	 * @param WP_Client $client HTTP Client.
	 */
	public function __construct( $client ) {

		$this->resource = 'brandings';

		parent::__construct( $client );

	}

	/**
	 * Retrieve a branding
	 *
	 * @param int $id Branding ID.
	 *
	 * @return array|WP_Error
	 */
	public function get( int $id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * Update an existing branding resource
	 *
	 * @param int   $id      Branding ID.
	 * @param array $updates Branding's updated data.
	 *
	 * @return array|WP_Error
	 */
	public function update( int $id, array $updates ) {

		return $this->get_client()->put(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id ),
			[ 'branding' => $updates ]
		);

	}

	/**
	 * List all existing branding resources
	 *
	 * @return array|WP_Error
	 */
	public function list() {

		return $this->get_client()->get(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'brandings' )
		);

	}

}
