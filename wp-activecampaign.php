<?php
/**
 * Plugin Name: WP Active Campaign
 * Plugin URI: https://wpsuperstar.com/
 * Description: Active Campaign API using WordPress Requests
 * Version: 0.0.1
 * Author: Yojance Rabelo
 * Author URI: https://wpsuperstar.com/
 */

// Runs when the plugin is activated.
register_activation_hook( __FILE__, 'WP_ActiveCampaign::plugin_activation' );
// Runs when the plugin is deactivated.
register_deactivation_hook( __FILE__, 'WP_ActiveCampaign::plugin_deactivation' );

/**
 * Class WP_ActiveCampaign
 */
class WP_ActiveCampaign {

	/**
	 * Instance of this class
	 *
	 * @var $instance
	 */
	protected static $instance;

	/**
	 * WP_ActiveCampaign constructor.
	 */
	public function __construct() {

		$this->includes();
	}

	/**
	 * What we need to make everything work
	 */
	public function includes() {

		require_once __DIR__ . '/includes/class-wp-client.php';
		require_once __DIR__ . '/includes/class-resource.php';
		require_once __DIR__ . '/includes/class-contacts.php';
		require_once __DIR__ . '/includes/class-custom-fields.php';
		require_once __DIR__ . '/includes/class-tags.php';

	}

	/**
	 * Retrieve instance of this class
	 *
	 * @return WP_ActiveCampaign
	 */
	public static function instance(): WP_ActiveCampaign {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Runs when the plugin is activated
	 */
	public static function plugin_activation() {
	}

	/**
	 * Runs when the plugin is de-activated
	 */
	public static function plugin_deactivation() {
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public static function plugin_url(): string {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public static function plugin_path(): string {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Get Ajax URL.
	 *
	 * @return string
	 */
	public static function ajax_url(): string {
		return admin_url( 'admin-ajax.php', 'relative' );
	}

	/**
	 * What type of request is this?
	 *
	 * @param string $type admin, ajax, cron or frontend.
	 *
	 * @return bool
	 */
	public static function is_request( $type ): bool {

		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}

		return false;

	}
}

add_action( 'plugins_loaded', 'load_active_campaign' );
//phpcs:ignore
function load_active_campaign() {
	return WP_ActiveCampaign::instance();
}
