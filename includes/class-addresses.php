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
 * Addresses
 *
 * Every campaign sent via ActiveCampaign is required to have a physical mailing address associated with it.
 * The API enables you to create, update, and delete address resources,
 * as well as associate an address with a specific list or user group.
 *
 * @package WPS\ActiveCampaign
 * @status  Implemented, Not Tested
 */
class Addresses extends Resource {

	/**
	 * Addresses constructor.
	 *
	 * @param WP_Client $client HTTP Client.
	 */
	public function __construct( $client ) {

		$this->resource = 'addresses';

		parent::__construct( $client );

	}

	/**
	 * Create an address
	 *
	 * @param array $data Address fields.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#testinput
	 */
	public function create( array $data ) {

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource ),
			[ 'address' => $data ]
		);

	}

	/**
	 * Retrieve an address
	 *
	 * @param int $id ID of the Address to retrieve.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#retrieve-an-address
	 */
	public function get( int $id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * Update an address
	 *
	 * @param int   $id      ID of the Address being changed.
	 * @param array $updates Updated data.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#update-an-address-2
	 */
	public function update( int $id, array $updates ) {

		return $this->get_client()->put(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id ),
			$updates
		);

	}

	/**
	 * Delete an address
	 *
	 * It appears that once you mark an address as default it can't be deleted afterwards.
	 * It will return a 403 error code when you try to delete it.
	 *
	 * @param int $id ID of the Address to delete.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#delete-an-address
	 */
	public function delete( int $id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * Delete address associated with a specific user group
	 *
	 * @param int $id ID of the AddressGroup to delete.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#delete-an-addressgroup
	 */
	public function delete_address_group( int $id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'addressGroups', $id )
		);

	}

	/**
	 * Delete address associated with a specific list
	 *
	 * @param int $id ID of the AddressList to delete.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#delete-an-addresslist
	 */
	public function delete_address_list( int $id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'addressLists', $id )
		);

	}

	/**
	 * List all addresses
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#list-all-addresses
	 */
	public function list() {

		return $this->get_client()->get(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource )
		);

	}

}
