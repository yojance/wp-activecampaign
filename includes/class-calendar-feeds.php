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
 * Calendar Feeds
 *
 * Calendar feeds allow users to sync ActiveCampaign tasks with Google Calendar,
 * Apple Calendar, Microsoft Outlook, or any calendar client that supports subscription calendars.
 *
 * The API enables you to add, view, update, and delete calendar feeds.
 *
 * @package WPS\ActiveCampaign
 * @status  Implemented, Not Tested
 */
class Calendar_Feeds extends Resource {

	/**
	 * Calendar_Feeds constructor.
	 *
	 * @param WP_Client $client HTTP Client.
	 */
	public function __construct( $client ) {

		$this->resource = 'calendars';

		parent::__construct( $client );

	}

	/**
	 * Create a calendar feed
	 *
	 * @param array $data Calendar's Feed data.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-a-calendar-feed
	 */
	public function create( array $data ) {

		return $this->get_client()->post(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), 'calendars' ),
			[ 'calendar' => $data ]
		);

	}

	/**
	 * Retrieve a calendar feed
	 *
	 * @param int $id ID of the calendar feed to retrieve.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#list-all-calendar-feeds-1
	 */
	public function get( int $id ) {

		return $this->get_client()->get(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * Update a calendar feed
	 *
	 * @param int   $id      ID of the calendar feed to update.
	 * @param array $updates Updated Calendar Feed's data.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#update-a-calendar-feed
	 */
	public function update( int $id, array $updates ) {

		return $this->get_client()->post(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id ),
			[ 'calendar' => $updates ]
		);

	}

	/**
	 * Delete a calendar feed
	 *
	 * @param int $id ID of the calendar feed to delete.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#remove-a-calendar-feed
	 */
	public function delete( int $id ) {

		return $this->get_client()->delete(
			sprintf( '%s/%s/%d', $this->get_client()->get_base_endpoint(), $this->resource, $id )
		);

	}

	/**
	 * List all calendar feeds
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#list-all-calendar-feeds
	 */
	public function list() {

		return $this->get_client()->get(
			sprintf( '%s/%s', $this->get_client()->get_base_endpoint(), $this->resource )
		);

	}

	/**
	 * Create a Deals calendar feed
	 *
	 * @param array $data Calendar's Feed data.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-a-calendar-feed
	 */
	public function create_deals_calendar_feed( array $data ) {

		$data['type'] = 'Deals';

		return $this->create( $data );

	}

	/**
	 * Create a Contacts calendar feed
	 *
	 * @param array $data Calendar's Feed data.
	 *
	 * @return array|WP_Error
	 * @link https://developers.activecampaign.com/reference#create-a-calendar-feed
	 */
	public function create_contacts_calendar_feed( array $data ) {

		$data['type'] = 'Contacts';

		return $this->create( $data );

	}

}
