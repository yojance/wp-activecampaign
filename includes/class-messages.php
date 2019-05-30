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
 * Messages
 *
 * @package WPS\ActiveCampaign
 * @status  Implemented, Not Tested
 */
class Messages extends Resource {

	/**
	 * Messages constructor.
	 *
	 * @param WP_Client $client HTTP Client.
	 */
	public function __construct( $client ) {

		$this->resource = 'messages';

		parent::__construct( $client );

	}

	/**
	 * Create a message
	 *
	 * @param array $data Message's data.
	 *
	 * @return array|WP_Error
	 */
	public function create( array $data ) {

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource ),
			[ 'message' => $data ]
		);

	}

	/**
	 * Retrieve a message
	 *
	 * @param int $id ID of the message to retrieve.
	 *
	 * @return array|WP_Error
	 */
	public function get( int $id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * Update a message
	 *
	 * @param int   $id      ID of the message to update.
	 * @param array $updates Data updates.
	 *
	 * @return array|WP_Error
	 */
	public function update( int $id, array $updates ) {

		return $this->get_client()->put(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id ),
			[ 'message' => $updates ]
		);

	}

	/**
	 * Delete a message
	 *
	 * @param int $id ID of the message to delete.
	 *
	 * @return array|WP_Error
	 */
	public function delete( int $id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * List all messages
	 */
	public function list() {

		return $this->get_client()->get(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource )
		);

	}

}
