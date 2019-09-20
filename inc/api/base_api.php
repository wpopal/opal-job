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
namespace Opal_Job\API;
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use WP_REST_Response;
//// call http://domain.com/wp-json/job/v1/jobs
/**
 * Abstract class to define/implement base methods for all controller classes
 *
 * @since      1.0.0
 * @package    Opal_Job
 * @subpackage Opal_Job/controllers
 */
abstract class Base_API {
	
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_base_name The string used to uniquely identify this plugin.
	 */
	public $base ; 

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_base_name The string used to uniquely identify this plugin.
	 */
	public $namespace = 'job-api/v1'; 
	
	/**
	 * Definition
	 *
	 *	Register all Taxonomy related to Job post type as location, category, Specialism, Types
	 *
	 * @since 1.0
	 *
	 * @return avoid
	 */
	public function __construct () {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Definition
	 *
	 *	Register all Taxonomy related to Job post type as location, category, Specialism, Types
	 *
	 * @since 1.0
	 *
	 * @return avoid
	 */
	public function register_routes() {
		
		
	}

	public function get_response ( $code, $output ) {
		
		$response = array();
 	
		$response['status'] = $code;
		$response = array_merge( $response, $output );

		return new WP_REST_Response( $response );
	}
}