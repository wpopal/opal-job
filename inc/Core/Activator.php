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

use Opal_Job\Core\Roles; 

/**
 * Fired during plugin activation
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author     WpOpal
 **/
class Activator {

	/**
	 * Short Description.
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

			$min_php = '5.6.0';

		// Check PHP Version and deactivate & die if it doesn't meet minimum requirements.
		if ( version_compare( PHP_VERSION, $min_php, '<' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( 'This plugin requires a minmum PHP Version of ' . $min_php );
		}

		self::add_roles();
		// active some options setting.
	}

	public static function add_roles(){ 

		global $wp_roles;

		if ( ! is_object( $wp_roles ) ) {
			return;
		}
		
		if ( ! array_key_exists( 'opaljob_manager', $wp_roles->roles ) ) {
			$roles = new Roles;
			$roles->add_roles();
			$roles->add_caps();
		} else {
			// remove_role( 'opaljob_manager' );
			// remove_role( 'opaljob_manager' );
			// $roles = new Opaljob_Roles;
			// $roles->remove_caps();
		}

	}

}
