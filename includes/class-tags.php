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
 * Class Tags
 *
 * Tags
 *
 * A contact can have any number of tags applied to them.
 * The API enables you to add or remove a tag from a contact and see all
 * the tags that have been applied to a specific contact.
 *
 * The contactTags API endpoint is used to assign existing tags to existing contacts.
 * If either the tag or the contact does not exist you must create them before trying to assign a tag to a contact.
 *
 * @package WPS\ActiveCampaign
 */
class Tags extends Resource {

	/**
	 * Create a tag
	 *
	 * A 201 response code is returned when it is initially created.
	 * A 500 response code is returned when you try creating a tag that already exists.
	 *
	 * @param array $data Tag data.
	 *
	 * @return array|\WP_Error
	 */
	public function create( array $data ) {

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'tags' ),
			[ 'tag' => $data ]
		);

	}

	/**
	 * Retrieve a tag
	 *
	 * @param int $id ID of the tag to retrieve.
	 *
	 * @return array|\WP_Error
	 */
	public function get( int $id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'tags', $id )
		);

	}

	/**
	 * Update a tag
	 * TODO: Check with AC on why I'm able to change tagType to anything other than `template` or `contact.
	 *
	 * A 200 response code is returned when the tags is updated successfully.
	 *
	 * @param int   $id           ID of the tag to update.
	 * @param array $updated_data Updated data.
	 *
	 * @return array|\WP_Error
	 */
	public function update( int $id, array $updated_data ) {

		return $this->get_client()->put(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'tags', $id ),
			[ 'tag' => $updated_data ]
		);

	}

	/**
	 * Delete a tag
	 *
	 * @param int $id ID of the tag to remove.
	 *
	 * @return array|\WP_Error
	 */
	public function delete( int $id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'tags', $id )
		);

	}

	/**
	 * List all tags
	 *
	 * @return array|\WP_Error
	 */
	public function list_all() {

		return $this->get_client()->get(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'tags' )
		);

	}

	/**
	 * Add a tag to contact
	 *
	 * @param int $tag_id     Tag's id.
	 * @param int $contact_id Contact's id.
	 *
	 * @return array|\WP_Error
	 */
	public function create_contact_tag( int $tag_id, int $contact_id ) {

		$data['contactTag']['tag']     = $tag_id;
		$data['contactTag']['contact'] = $contact_id;

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'contactTags' ),
			$data
		);

	}

	/**
	 * Retrieve a list of Tags for a Contact
	 *
	 * @param int $contact_id Contact ID.
	 *
	 * @return array|\WP_Error
	 */
	public function get_contact_tags( int $contact_id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d/%s', $this->get_client()->get_base_endpoint(), 'contacts', $contact_id, 'contactTags' )
		);

	}

	/**
	 * Remove a tag from a contact
	 *
	 * @param int $unique_id The contactTag id.
	 *
	 * @return array|\WP_Error
	 */
	public function delete_contact_tag( $unique_id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'contactTags', $unique_id )
		);

	}

}
