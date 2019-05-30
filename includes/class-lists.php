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
 * Lists
 *
 * A list is a group of contacts that campaigns can be sent to.
 * Every campaign is required to be sent to at least one list. Contacts can be added to and removed from lists manually
 * in the ActiveCampaign UI, via automations, or via the API.
 *
 * @package WPS\ActiveCampaign
 * @status  Implemented, Not Tested
 */
class Lists extends Resource {

	/**
	 * Lists constructor.
	 *
	 * @param WP_Client $client HTTP Client.
	 */
	public function __construct( $client ) {

		$this->resource = 'lists';

		parent::__construct( $client );

	}

	/**
	 * Create a list
	 *
	 * @param array $data List Data.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-new-list
	 */
	public function create( array $data ) {

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource ),
			[ 'list' => $data ]
		);

	}

	/**
	 * Retrieve a list
	 *
	 * @param int $id ID of the lists to retrieve.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#retrieve-a-list
	 */
	public function get( int $id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * Delete a list
	 *
	 * @param int $id ID of the list to delete.
	 *
	 * @return array|WP_Error
	 */
	public function delete( int $id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * Retrieve all lists
	 *
	 * @return array|WP_Error
	 */
	public function list() {

		return $this->get_client()->get(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource )
		);

	}

	/**
	 * Create a list group permission
	 *
	 * @param int $list_id  ID of the list.
	 * @param int $group_id ID of the group that list should be associated with.
	 *
	 * @return array|WP_Error
	 */
	public function create_group_permission( int $list_id, int $group_id ) {

		$data['listid']  = $list_id;
		$data['groupid'] = $group_id;

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'listGroups' ),
			[ 'listGroup' => $data ]
		);

	}
}
