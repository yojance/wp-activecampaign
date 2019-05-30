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
 * Campaigns
 *
 * Campaigns are broadcast emails sent out to a list of contacts.
 *
 * @package WPS\ActiveCampaign
 * @status  Implemented, Not Tested
 */
class Campaigns extends Resource {

	/**
	 * Messages constructor.
	 *
	 * @param WP_Client $client HTTP Client.
	 */
	public function __construct( $client ) {

		$this->resource = 'campaigns';

		parent::__construct( $client );

	}

	/**
	 * Retrieve a campaign
	 *
	 * @param int $id ID of campaign to retrieve.
	 *
	 * @return array|WP_Error
	 */
	public function get( int $id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * List all campaigns
	 *
	 * @return array|WP_Error
	 */
	public function list() {

		return $this->get_client()->get(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource )
		);

	}

	/**
	 * Retrieve links associated to campaign
	 *
	 * @param int $id ID of campaign to retrieve Links for.
	 *
	 * @return array|WP_Error
	 */
	public function get_links( int $id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d/%s', $this->get_client()->get_base_endpoint(), $this->resource, $id, 'links' )
		);

	}

}
