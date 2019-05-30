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
 * Notes
 *
 * Notes are a way to add arbitrary information to a contact or a deal.
 *
 * @package WPS\ActiveCampaign
 */
class Notes extends Resource {

	/**
	 * Notes constructor.
	 *
	 * @param WP_Client $client HTTP Client.
	 */
	public function __construct( $client ) {

		$this->resource = 'notes';

		parent::__construct( $client );

	}

	/**
	 * Create a note
	 *
	 * @param array $data Note's data.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-a-note
	 */
	public function create( array $data ) {

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource ),
			[ 'note' => $data ]
		);

	}

	/**
	 * Retrieve a note
	 *
	 * @param int $id ID of the note to retrieve.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#retrieve-a-note
	 */
	public function get( int $id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * Update a note
	 *
	 * @param int   $id      ID of the note to update.
	 * @param array $updates Note's updated data.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#update-a-note
	 */
	public function update( int $id, array $updates ) {

		return $this->get_client()->put(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id ),
			[ 'note' => $updates ]
		);

	}

	/**
	 * Delete a note
	 *
	 * @param int $id ID of the note to delete.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#delete-note
	 */
	public function delete( int $id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * Create an Activity note
	 *
	 * @param array $data Note's data.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-a-note
	 */
	public function create_activity_note( array $data ) {

		$data['reltype'] = 'Activity';

		return $this->create( $data );

	}

	/**
	 * Create a Deal note
	 *
	 * @param array $data Note's data.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-a-note
	 */
	public function create_deal_note( array $data ) {

		$data['reltype'] = 'Deal';

		return $this->create( $data );

	}

	/**
	 * Create a DealTask note
	 *
	 * @param array $data Note's data.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-a-note
	 */
	public function create_deal_task_note( array $data ) {

		$data['reltype'] = 'DealTask';

		return $this->create( $data );

	}

	/**
	 * Create a Subscriber note
	 *
	 * @param array $data Note's data.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-a-note
	 */
	public function create_subscriber_note( array $data ) {

		$data['reltype'] = 'Subscriber';

		return $this->create( $data );

	}

}
