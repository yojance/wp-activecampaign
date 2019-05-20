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
 * Class Contact
 *
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
	 * Custom Fields handler.
	 *
	 * @var Custom_Fields $custom_fields
	 */
	protected $custom_fields;

	/**
	 * Contacts constructor.
	 *
	 * @param WP_Client $client HTTP Client.
	 */
	public function __construct( $client ) {

		parent::__construct( $client );

		// Handlers.
		$this->tags          = new Tags( $this->get_client() );
		$this->custom_fields = new Custom_Fields( $this->get_client() );

	}

	/**
	 * Create a contact
	 *
	 * Response Code:
	 * 201: Created successfully
	 * 422: Email address already exists in the system
	 *
	 * @param array $contact Contact's information.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-contact
	 * @link https://gist.github.com/yojance/d538e09bba6d3d9dbf26ccf118890aca#file-contacts-create-json
	 */
	public function create( array $contact ) {

		$data['contact'] = $contact;

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'contacts' ),
			$data
		);

	}

	/**
	 * Create or update a contact.
	 *
	 * Response Code:
	 * 201: Created successfully
	 * 422: Email address already exists in the system
	 *
	 * @param array $contact Contact's information.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-contact-sync
	 */
	public function sync( array $contact ) {

		$data['contact'] = $contact;

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'contacts' ),
			$data
		);

	}

	/**
	 * Retrieve an existing contact
	 *
	 * Code 200: Success
	 * Code 404: No Result found for Subscriber with id %d
	 *
	 * @param int $contact_id Contact ID.
	 *
	 * @return array|WP_Error
	 * @see https://developers.activecampaign.com/reference#get-contact
	 */
	public function get( int $contact_id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'contacts', $contact_id )
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
	public function get_by( $field, $field_value ) {

		// Get by ID.
		if ( in_array( strtolower( $field ), [ 'id', 'contact_id', 'contact' ], true ) ) {
			$response = $this->get( $field_value );

			if ( is_wp_error( $response ) ) {
				return $response;
			}
		}

		$endpoint = sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'contacts' );
		$endpoint = add_query_arg( [ 'email' => rawurlencode( $field_value ) ], $endpoint );
		$endpoint = esc_url( $endpoint );

		return $this->get_client()->get( $endpoint );

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
	public function subscribe( $contact_id, $list_id ) {

		$data['contactList']['status']  = 1;
		$data['contactList']['contact'] = $contact_id;
		$data['contactList']['list']    = $list_id;

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'contactLists' ),
			$data
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
	public function unsubscribe( $contact_id, $list_id ) {

		$data['contactList']['status']  = 2;
		$data['contactList']['contact'] = $contact_id;
		$data['contactList']['list']    = $list_id;

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'contactLists' ),
			$data
		);

	}

	/**
	 * Update a contact By ID
	 *
	 * @param int   $contact_id Contact iD.
	 * @param array $contact    Updated contact information.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#update-a-contact
	 */
	public function update( $contact_id, $contact ) {

		$data['contact'] = $contact;

		return $this->get_client()->put(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'contacts', $contact_id ),
			$data
		);

	}

	/**
	 * Delete an existing contact.
	 *
	 * Response code:
	 * 200: Deleted successfully
	 * 404: No Result found for Subscriber
	 *
	 * @param int $contact_id Contact ID.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#delete-contact
	 */
	public function delete( int $contact_id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'contacts', $contact_id )
		);

	}

}
