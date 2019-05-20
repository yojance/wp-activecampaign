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
 * Class Custom_Fields
 *
 * Custom Fields
 *
 * Custom fields enable you to attach field types to a contact that suit
 * your needs (including but not limited to dropdowns, radio buttons, textareas, date fields, and more).
 * The API enables you to create, update, delete, and view custom field resources.
 *
 * Custom Field Values
 *
 * The API enables you to add, update, delete, and get custom field values for contacts.
 *
 * @package WPS\ActiveCampaign
 */
class Custom_Fields extends Resource {

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
	 * @return array|\WP_Error
	 * @link https://developers.activecampaign.com/reference#retrieve-fields
	 */
	public function create( array $data ) {

		$custom_field['field'] = wp_parse_args( $data, $this->get_custom_field_defaults() );

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'fields' ),
			$custom_field
		);

	}

	/**
	 * Retrieve a custom field
	 *
	 * @param int $field_id Custom field ID to retrieve.
	 *
	 * @return array|\WP_Error
	 * @link https://developers.activecampaign.com/reference#retrieve-a-field
	 */
	public function get( $field_id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'fields', $field_id )
		);

	}

	/**
	 * Update a custom field
	 *
	 * @param int   $field_id Custom field ID.
	 * @param array $data     Updates.
	 *
	 * @return array|\WP_Error
	 * @link https://developers.activecampaign.com/reference#update-a-field
	 */
	public function update( $field_id, $data ) {

		return $this->get_client()->put(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'fields', $field_id ),
			[ 'field' => $data ]
		);

	}

	/**
	 * Delete a custom field
	 *
	 * @param int $field_id Custom field ID.
	 *
	 * @return array|\WP_Error
	 * @link https://developers.activecampaign.com/reference#delete-a-field
	 */
	public function delete( $field_id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'fields', $field_id )
		);

	}

	/**
	 * List all custom fields
	 *
	 * @return array|\WP_Error
	 * @link https://developers.activecampaign.com/reference#retrieve-fields-1
	 */
	public function list_all() {

		return $this->get_client()->get(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'fields' )
		);

	}

	/**
	 * Create a custom field relationship to list(s)
	 *
	 * @param int $field_id Custom Field ID.
	 * @param int $list_id  List ID.
	 *
	 * @return array|\WP_Error
	 * @link https://developers.activecampaign.com/reference#create-a-custom-field-relationship-to-lists
	 */
	public function add_list_relationship( $field_id, $list_id ) {

		$relationship['fieldRel']['field'] = $field_id;
		$relationship['fieldRel']['relid'] = $list_id;

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'fields' ),
			$relationship
		);

	}

	/**
	 * Create custom field options
	 * TODO: Keeps returning: Bulk operation failed. Request must contain an array of fieldOption objects.
	 *
	 * @param array $field_id       Custom field ID.
	 * @param array $custom_options Field Options.
	 *
	 * @return array|\WP_Error
	 * @link https://developers.activecampaign.com/reference#create-custom-field-options
	 */
	public function create_field_options( $field_id, array $custom_options ) {

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
	 * Create a custom field value
	 *
	 * @param array $data Array containing all required fields and values.
	 *
	 * @return array|\WP_Error
	 * @see https://developers.activecampaign.com/reference#create-fieldvalue
	 */
	public function create_contact_field_value( array $data ) {

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'fieldValues' ),
			$data
		);

	}

	/**
	 * Retrieve a custom field value
	 *
	 * @param int $field_value_id Custom field value assigned to a Contact.
	 *                            This is not the custom field id, instead, use the unique
	 *                            ID returned when the field was originally created.
	 *
	 * @return array|\WP_Error
	 * @link https://developers.activecampaign.com/reference#retrieve-a-fieldvalues
	 */
	public function get_contact_field_value( $field_value_id ) {

		return $this->get_client()->get(
			sprintf( '%s/%d', $this->get_client()->get_base_endpoint(), $field_value_id )
		);

	}

	/**
	 * Update a custom field value for contact
	 *
	 * @param int   $field_value_id Custom field value assigned to a Contact.
	 *                              This is not the custom field id, instead, use the unique
	 *                              ID returned when the field was originally created.
	 * @param array $updated_data   Array containing all updated fields and values.
	 *
	 * @return array|\WP_Error
	 * @see https://developers.activecampaign.com/reference#update-a-custom-field-value-for-contact
	 */
	public function update_contact_field_value( $field_value_id, array $updated_data ) {

		return $this->get_client()->put(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'fieldValues', $field_value_id ),
			$updated_data
		);

	}

	/**
	 * Delete a custom field value
	 *
	 * @param int $field_value_id   Custom field value assigned to a Contact.
	 *                              This is not the custom field id, instead, use the unique
	 *                              ID returned when the field was originally created.
	 *
	 * @return array|\WP_Error
	 * @see https://developers.activecampaign.com/reference#delete-a-fieldvalue-1
	 */
	public function delete_contact_field_value( $field_value_id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'fieldValues', $field_value_id )
		);

	}

	/**
	 * List all custom field values
	 *
	 * @return array|\WP_Error
	 * @see https://developers.activecampaign.com/reference#list-all-custom-field-values-1
	 */
	public function list_all_contact_field_values() {

		return $this->get_client()->get(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'fieldValues' )
		);

	}

	/**
	 * Allowed custom field types.
	 *
	 * @return array
	 */
	private function get_allowed_custom_field_types() {

		return [
			'textarea',
			'text',
			'date',
			'dropdown',
			'listbox',
			'radio',
			'checkbox',
			'hidden',
		];

	}

	/**
	 * Custom field have a Title and Type required by default.
	 *
	 * @return array
	 */
	private function get_custom_field_defaults() {

		return [
			'type'  => 'text',
			'title' => 'Custom Field',
		];

	}
}