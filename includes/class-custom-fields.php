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
 * Custom Fields
 *
 * Custom fields enable you to attach field types to a contact that suit
 * your needs (including but not limited to dropdowns, radio buttons, textareas, date fields, and more).
 * The API enables you to create, update, delete, and view custom field resources.
 *
 * @package WPS\ActiveCampaign
 */
class Custom_Fields extends Resource {

	/**
	 * Custom_Fields constructor.
	 *
	 * @param WP_Client $client HTTP Client.
	 */
	public function __construct( $client ) {

		$this->resource = 'fields';

		parent::__construct( $client );

	}

	/**
	 * Create a custom field
	 * When the field_type is dropdown, radio, checkbox or listbox,
	 * you need to add field options using fieldOption/bulk endpoint.
	 *
	 * A contact can only see a custom field if the contact is part of a list that this custom field is related to.
	 * Use fieldRel endpoint to specify which list gets to see the custom field.
	 *
	 * @param array $data Field.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#retrieve-fields
	 */
	public function create( array $data ) {

		$custom_field['field'] = wp_parse_args( $data, $this->get_custom_field_defaults() );

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource ),
			$custom_field
		);

	}

	/**
	 * Retrieve a custom field
	 *
	 * @param int $id Custom field ID to retrieve.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#retrieve-a-field
	 */
	public function get( int $id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * Update a custom field
	 *
	 * @param int   $id      Custom field ID.
	 * @param array $updates Updates.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#update-a-field
	 */
	public function update( int $id, array $updates ) {

		return $this->get_client()->put(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id ),
			[ 'field' => $updates ]
		);

	}

	/**
	 * Delete a custom field
	 *
	 * @param int $id Custom field ID.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#delete-a-field
	 */
	public function delete( int $id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * List all custom fields
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#retrieve-fields-1
	 */
	public function list() {

		return $this->get_client()->get(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource )
		);

	}

	/**
	 * Create a custom field relationship to list(s)
	 *
	 * @param int $field_id Custom Field ID.
	 * @param int $list_id  List ID.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-a-custom-field-relationship-to-lists
	 */
	public function create_list_relationship( int $field_id, int $list_id ) {

		$data['field'] = $field_id;
		$data['relid'] = $list_id;

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource ),
			[ 'fieldRel' => $data ]
		);

	}

	/**
	 * Create custom field options
	 * TODO: Keeps returning: Bulk operation failed. Request must contain an array of fieldOption objects.
	 *
	 * @param int   $field_id       Custom field ID.
	 * @param array $custom_options Field Options.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-custom-field-options
	 */
	public function create_field_options( int $field_id, array $custom_options ) {

		$options = [];
		// Make sure we only grab what we need.
		foreach ( $custom_options as $option ) {
			$o              = [];
			$o['field']     = $field_id;
			$o['label']     = $option['label'] ?? '';
			$o['value']     = $option['value'] ?? '';
			$o['orderid']   = $option['orderid'] ?? '';
			$o['isdefault'] = $option['isdefault'] ?? false;

			$options[] = $o;

		}

		return $this->get_client()->post(
			sprintf( '%s/%s/%s', $this->get_client()->get_base_endpoint(), 'fieldOption', 'bulk' ),
			[ $options ]
		);

	}

	/**
	 * Custom field have a Title and Type required by default.
	 *
	 * @return array
	 */
	private function get_custom_field_defaults(): array {

		return [
			'type'  => 'text',
			'title' => 'Custom Field',
		];

	}
}