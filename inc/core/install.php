<?php
/**
 * Define 
 * Note: only use for internal purpose.
 *
 * @package     OpalJob
 * @copyright   Copyright (c) 2019, WpOpal <https://www.wpopal.com>
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.0
 */
namespace Opal_Job\Core;
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Install {
	/**
	 * Install Opalestate.
	 */
	public static function install() {
		if ( ! is_blog_installed() ) {
			return;
		}

		// Check if we are not already running this routine.
		if ( 'yes' === get_transient( 'opaljob_installing' ) ) {
			return;
		}

		// If we made it till here nothing is running yet, lets set the transient now.
		set_transient( 'opaljob_installing', 'yes', MINUTE_IN_SECONDS * 10 );

		static::create_options();
		static::create_tables();
		static::create_roles();
		static::setup_environment();
		static::update_opaljob_version();

		// Add the transient to redirect.
		set_transient( '_opaljob_activation_redirect', true, 30 );

		delete_transient( 'opaljob_installing' );

		// Remove rewrite rules and then recreate rewrite rules.
		flush_rewrite_rules();

		do_action( 'opaljob_installed' );
	}

	/**
	 * Setup Opalestate environment - post types, taxonomies, endpoints.
	 */
	private static function setup_environment() {

	}

	/**
	 * Set up the database tables which the plugin needs to function.
	 */
	private static function create_tables() {

	}

	/**
	 * Create roles and capabilities.
	 */
	public static function create_roles() {

	}

	/**
	 * Default options.
	 *
	 * Sets up the default options used on the settings page.
	 */
	private static function create_options() {
		global $opaljob_options;

		// Add Upgraded From Option
		$current_version = get_option( 'opaljob_version' );
		if ( $current_version ) {
			update_option( 'opaljob_version_upgraded_from', $current_version );
		}

		// Setup some default options
		$options = [];

		//Fresh Install? Setup Test Mode, Base Country (US), Test Gateway, Currency
		if ( empty( $current_version ) ) {
			$options['test_mode'] = 1;
		}

		// Populate some default values
		update_option( 'opaljob_settings', array_merge( $opaljob_options, $options ) );

		// Add a temporary option to note that Give pages have been created
		set_transient( '_opaljob_installed', $options, 30 );
	}

	/**
	 * Update Opalestate version to current.
	 */
	private static function update_opaljob_version() {
		update_option( 'opaljob_version', OPALJOB_VERSION );
	}
}

