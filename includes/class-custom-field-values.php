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
 * Custom Field Values
 *
 * The API enables you to add, update, delete, and get custom field values for contacts.
 * To create or remove custom fields, please see the "Custom Fields" section.
 *
 * @package WPS\ActiveCampaign
 */
class Custom_Field_Values extends Resource {

	/**
	 * Custom_Field_Values constructor.
	 *
	 * @param WP_Client $client HTTP Client.
	 */
	public function __construct( $client ) {

		$this->resource = 'fieldValues';

		parent::__construct( $client );

	}

	/**
	 * Create a custom field value
	 *
	 * @param array $data Array containing all required fields and values.
	 *
	 * @return array|WP_Error
	 * @see https://developers.activecampaign.com/reference#create-fieldvalue
	 */
	public function create( array $data ) {

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource ),
			$data
		);

	}

	/**
	 * Retrieve a custom field value
	 *
	 * @param int $id Custom field value assigned to a Contact. This is not the custom field id, instead, use the
	 *                unique ID returned when the field was originally created.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#retrieve-a-fieldvalues
	 */
	public function get( int $id ) {

		return $this->get_client()->get(
			sprintf( '%s/%d', $this->get_client()->get_base_endpoint(), $id )
		);

	}

	/**
	 * Update a custom field value for contact
	 *
	 * @param int   $id      Custom field value assigned to a Contact. This is not the custom field id, instead, use
	 *                       the unique ID returned when the field was originally created.
	 * @param array $updates Array containing all updated fields and values.
	 *
	 * @return array|WP_Error
	 * @see https://developers.activecampaign.com/reference#update-a-custom-field-value-for-contact
	 */
	public function update( int $id, array $updates ) {

		return $this->get_client()->put(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id ),
			$updates
		);

	}

	/**
	 * Delete a custom field value
	 *
	 * @param int $id Custom field value assigned to a Contact. This is not the custom field id, instead, use the
	 *                unique ID returned when the field was originally created.
	 *
	 * @return array|WP_Error
	 * @see https://developers.activecampaign.com/reference#delete-a-fieldvalue-1
	 */
	public function delete( int $id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * List all custom field values
	 *
	 * @return array|WP_Error
	 * @see https://developers.activecampaign.com/reference#list-all-custom-field-values-1
	 */
	public function list() {

		return $this->get_client()->get(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource )
		);

	}
}
