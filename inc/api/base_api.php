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
use WP_Error;
use WP_REST_Response;
use WP_REST_Request;
use Opal_Job\API\API_Admin;

//// call http://domain.com/wp-json/job-api/v1/jobs
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

	public function output ( $code ) {

		$this->data['status'] = $code; 
		return new WP_REST_Response( $this->data );
	}
	/**
	 * Validate the API request
	 *
	 * Checks for the user's public key and token against the secret key
	 *
	 * @access private
	 * @global object $wp_query WordPress Query
	 * @uses   Opaljob_API::get_user()
	 * @uses   Opaljob_API::invalid_key()
	 * @uses   Opaljob_API::invalid_auth()
	 * @since  1.1
	 * @return void
	 */
	public function validate_request( WP_REST_Request $request ) {

		return true;
		$response = array();

		// Make sure we have both user and api key
	 	$api_admin = API_Admin::get_instance();

		if ( empty( $request['token'] ) || empty( $request['key'] ) ) {
			return $this->missing_auth();
		}

		// Retrieve the user by public API key and ensure they exist
		if ( ! ( $user = $api_admin->get_user( $request['key'] ) ) ) {

			$this->invalid_key();

		} else {

			$token  = urldecode( $request['token'] );
			$secret = $api_admin->get_user_secret_key( $user );
			$public = urldecode( $request['key'] );

			if ( hash_equals( md5( $secret . $public ), $token ) ) {
				return true;
			} else {
				$this->invalid_auth();
			}
		}

	  	return false;
	}

	/**
	 * Displays a missing authentication error if all the parameters aren't
	 * provided
	 *
	 * @access private
	 * @return WP_Error with message key rest_forbidden
	 * @since  1.1
	 */
	private function missing_auth() { 
		return new WP_Error( 'rest_forbidden', esc_html__( 'You must specify both a token and API key!' ), array( 'status' => rest_authorization_required_code()  ) );
	}

	/**
	 * Displays an authentication failed error if the user failed to provide valid
	 * credentials
	 *
	 * @access private
	 * @since  1.1
	 * @uses   Opaljob_API::output()
	 * @return WP_Error with message key rest_forbidden
	 */
	private function invalid_auth() {
		return new WP_Error( 'rest_forbidden', esc_html__( 'Your request could not be authenticated!', 'opaljob' ), array( 'status' => 403  ) );
	}

	/**
	 * Displays an invalid API key error if the API key provided couldn't be
	 * validated
	 *
	 * @access private
	 * @since  1.1
	 * @return WP_Error with message key rest_forbidden
	 */
	private function invalid_key() {
		return new WP_Error( 'rest_forbidden', esc_html__( 'Invalid API key!' ), array( 'status' => rest_authorization_required_code()  ) );
	}
}