<?php
/**
 * Active Campaign
 *
 * PHP version 7.2
 *
 * @package WPS\ActiveCampaign
 * @status  Not Tested
 */

namespace WPS\ActiveCampaign;

use WP_Error;

/**
 * Automations
 *
 * Automations allow you to automate marketing communications to your contacts, as well as business processes
 * like deals moving between stages, tags being added/removed from contacts,
 * notes being added/removed to deals/contacts, etc.
 *
 * Contacts can be added to any number of automations and be at different positions in each automation.
 * The API enables you to add a contact to an automation, learn what automations a contact is in,
 * and remove a contact from an automation.
 *
 * @important At this time, it is not possible to create, edit, update, or delete automations via API.
 *
 * @package   WPS\ActiveCampaign
 * @status    Implemented, Not Tested
 */
class Automations extends Resource {

	/**
	 * Automations constructor.
	 *
	 * @param WP_Client $client HTTP Client.
	 */
	public function __construct( $client ) {

		$this->resource = 'automations';

		parent::__construct( $client );

	}

	/**
	 * Add a contact to an automation
	 *
	 * @param int $contact_id    Contact ID of the Contact, to be linked to the contactAutomation.
	 * @param int $automation_id Automation ID of the automation, to be linked to the contactAutomation.
	 *
	 * @return array|WP_Error
	 */
	public function create_contact_automation( int $contact_id, int $automation_id ) {

		$data['contact']    = $contact_id;
		$data['automation'] = $automation_id;

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'contactAutomations' ),
			[ 'contactAutomation' => $data ]
		);

	}

	/**
	 * Retrieve an automation a contact is in
	 *
	 * @param int $id ID of the contactAutomation to retrieve.
	 *
	 * @return array|WP_Error
	 */
	public function get_contact_automation( int $id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'contactAutomations', $id )
		);

	}

	/**
	 * Remove a contact from an automation
	 *
	 * @param int $id ID of the contactAutomation to delete.
	 *
	 * @return array|WP_Error
	 */
	public function delete_contact_automation( int $id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), 'contactAutomations', $id )
		);

	}

	/**
	 * List all automations
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#automation
	 */
	public function list() {

		return $this->get_client()->get(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource )
		);

	}

}
