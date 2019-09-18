<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://wpopal.com
 * @since             1.0.0
 * @package           Opal_Job
 *
 * @wordpress-plugin
 * Plugin Name:       Opal Job
 * Plugin URI:        http://wpopal.com/opal-job-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            WpOpal
 * Author URI:        http://wpopal.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       opal-job
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
use Opal_Job\Core\Init;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Constants
 */

define( 'OPAL_JOB', 'opal-job' );
define( 'OPAL_JOB_VERSION', '1.0.0' );
define( 'OPAL_JOB_DIR', plugin_dir_path( __FILE__ ) );
define( 'OPAL_JOB_URL', plugin_dir_url( __FILE__ ) );
define( 'OPAL_JOB_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'OPAL_JOB_PLUGIN_TEXT_DOMAIN', 'opal-job' );

define( 'OPAL_JOB_METABOX_PREFIX', '_' );

/**
 * Autoload Classes
 */

require_once( OPAL_JOB_DIR . 'vendor/autoload.php' );
require_once( OPAL_JOB_DIR . 'inc/core/functions.php' );

require_once( OPAL_JOB_DIR . 'inc/frontend/hooks/template-functions.php' );
require_once( OPAL_JOB_DIR . 'inc/frontend/hooks/single-functions.php' );
/**
 * Register Activation and Deactivation Hooks
 * This action is documented in inc/core/class-activator.php
 */

register_activation_hook( __FILE__, array( 'Opal_Job\Core\Activator', 'activate' ) );

/**
 * The code that runs during plugin deactivation.
 * This action is documented inc/core/class-deactivator.php
 */

register_deactivation_hook( __FILE__, array( 'Opal_Job\Core\Deactivator', 'deactivate' ) );

if ( ! defined( "OPALJOB_CLUSTER_ICON_URL" ) ) {
	define( 'OPALJOB_CLUSTER_ICON_URL', apply_filters( 'opaljob_cluster_icon_url',
				OPAL_JOB_URL . 'assets/images/cluster-icon.png' ) );
}

/**
 * Plugin Singleton Container
 *
 * Maintains a single copy of the plugin app object
 *
 * @since    1.0.0
 */
class Opal_Job {

	/**
	 * The instance of the plugin.
	 *
	 * @since    1.0.0
	 * @var      Init $init Instance of the plugin.
	 */
	private static $init;
	/**
	 * Loads the plugin
	 *
	 * @access    public
	 */
	public static function init() {

		if ( null === self::$init ) {
			self::$init = new Init();
			self::$init->run();
		}

		return self::$init;
	}
}

/**
 * Begins execution of the plugin
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * Also returns copy of the app object so 3rd party developers
 * can interact with the plugin's hooks contained within.
 **/
function opal_job_name_init() {
	return Opal_Job::init();
}

$min_php = '5.6.0';

// Check the minimum required PHP version and run the plugin.
if ( version_compare( PHP_VERSION, $min_php, '>=' ) ) {
		opal_job_name_init();
}
