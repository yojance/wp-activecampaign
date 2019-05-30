<?php
/**
 * Active Campaign
 *
 * PHP version 7.2
 *
 * @package WPS\ActiveCampaign
 */

namespace WPS\ActiveCampaign;

use stdClass;
use WP_Error;

/**
 * Contacts
 *
 * Contacts are the center of activity in ActiveCampaign and represent the people that
 * the owner of an ActiveCampaign account is marketing to or selling to.
 *
 * @package WPS\ActiveCampaign
 */
class Contacts extends Resource {

	/**
	 * Tags handler.
	 *
	 * @var Tags $tags
	 */
	protected $tags;

	/**
	 * Automations handler
	 *
	 * @var Automations $automations
	 */
	protected $automations;

	/**
	 * Custom Fields handler.
	 *
	 * @var Custom_Fields $custom_fields
	 */
	protected $custom_fields;

	/**
	 * Custom Field Values handler.
	 *
	 * @var Custom_Field_Values $custom_field_values
	 */
	protected $custom_field_values;

	/**
	 * Contacts constructor.
	 *
	 * @param WP_Client $client HTTP Client.
	 */
	public function __construct( $client ) {

		$this->resource = 'contacts';

		parent::__construct( $client );

		// Handlers.
		$this->tags                = new Tags( $this->get_client() );
		$this->automations         = new Automations( $this->get_client() );
		$this->custom_fields       = new Custom_Fields( $this->get_client() );
		$this->custom_field_values = new Custom_Field_Values( $this->get_client() );

	}

	/**
	 * Create a contact
	 *
	 * Response Code:
	 * 201: Created successfully
	 * 422: Email address already exists in the system
	 *
	 * @param array $data Contact's information.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-contact
	 * @link https://gist.github.com/yojance/d538e09bba6d3d9dbf26ccf118890aca#file-contacts-create-json
	 */
	public function create( array $data ) {

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource ),
			[ 'contact' => $data ]
		);

	}

	/**
	 * Create or update a contact.
	 *
	 * Response Code:
	 * 201: Created successfully
	 * 422: Email address already exists in the system
	 *
	 * @param array $data Contact's information.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-contact-sync
	 */
	public function sync( array $data ) {

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource ),
			[ 'contact' => $data ]
		);

	}

	/**
	 * Retrieve an existing contact
	 *
	 * Code 200: Success
	 * Code 404: No Result found for Subscriber with id %d
	 *
	 * @param int $id Contact ID.
	 *
	 * @return array|WP_Error
	 * @see https://developers.activecampaign.com/reference#get-contact
	 */
	public function get( int $id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * Get a contact by an arbitrary field key and value
	 *
	 * @param string $field       One of the following values:
	 *                            id, contact_id, contact, email.
	 * @param mixed  $field_value Field value.
	 *
	 * @return stdClass|WP_Error
	 */
	public function get_by( string $field, $field_value ) {

		// Get by ID.
		if ( in_array( strtolower( $field ), [ 'id', 'contact_id', 'contact' ], true ) ) {
			$response = $this->get( $field_value );

			if ( is_wp_error( $response ) ) {
				return $response;
			}
		}

		$endpoint = sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource );
		$endpoint = add_query_arg( [ 'email' => rawurlencode( $field_value ) ], $endpoint );
		$endpoint = esc_url( $endpoint );

		return $this->get_client()->get( $endpoint );

	}

	/**
	 * Update a contact By ID
	 *
	 * @param int   $contact_id Contact iD.
	 * @param array $updates    Updated contact information.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#update-a-contact
	 */
	public function update( int $contact_id, array $updates ) {

		return $this->get_client()->put(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $contact_id ),
			[ 'contact' => $updates ]
		);

	}

	/**
	 * Delete an existing contact.
	 *
	 * Response code:
	 * 200: Deleted successfully
	 * 404: No Result found for Subscriber
	 *
	 * @param int $id Contact ID.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#delete-contact
	 */
	public function delete( int $id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * Subscribe a contact to a list
	 *
	 * @param int $contact_id Contact ID.
	 * @param int $list_id    List ID.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#update-list-status-for-contact
	 */
	public function subscribe( int $contact_id, int $list_id ) {

		$data['status']  = 1;
		$data['contact'] = $contact_id;
		$data['list']    = $list_id;

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'contactLists' ),
			[ 'contactList' => $data ]
		);

	}

	/**
	 * Unsubscribe a contact from a list
	 *
	 * @param int $contact_id Contact ID.
	 * @param int $list_id    List ID.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#update-list-status-for-contact
	 */
	public function unsubscribe( int $contact_id, int $list_id ) {

		$data['status']  = 2;
		$data['contact'] = $contact_id;
		$data['list']    = $list_id;

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'contactLists' ),
			[ 'contactList' => $data ]
		);

	}

}
