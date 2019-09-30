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
namespace Opal_Job\API\V1;
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Opal_Job\API\Base_Api;
use WP_REST_Server;
use WP_REST_Response;
use Opal_Job\Common\Model\Query\Job_Query;

/**
 * @class Job_Api
 *
 * @since      1.0.0
 * @package    Opal_Job
 * @subpackage Opal_Job/controllers
 */
class Settings_Api  extends  Base_Api {

	/**
	 * The unique identifier of the route resource.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string $base.
	 */
	public $base = '/settings';
 	
 	/**
	 * Register Routes
	 *
	 * Register all CURD actions with POST/GET/PUT and calling function for each
	 *
	 * @since 1.0
	 *
	 * @return avoid
	 */
	public function register_routes ( ) { 
	 	/// call http://domain.com/wp-json/job-api/v1/settings  ////
		register_rest_route( $this->namespace, $this->base, array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => array( $this, 'get_settings' ),
			'permission_callback' => array( $this, 'validate_request'  ),
		));
	}

	/**
	 * Get List Of Job
	 *
	 * Based on request to get collection
	 *
	 * @since 1.0
	 *
	 * @return WP_REST_Response is json data
	 */
	public function get_settings () {

		$response = array();

		$settings = get_option( 'opaljob_settings' );
 
		$response['settings'] = $settings;

		return $this->get_response( 200, $response );
	}

}