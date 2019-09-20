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
use WP_REST_Request;
use Opal_Job\API\Base_Api;

/**
 * Opalestate_API Class
 *
 * Renders API returns as a JSON/XML array
 *
 * @since  1.1
 */
class API_Admin {

	/**
	 * Latest API Version
	 */
	const VERSION = 1;

	/**
	 * Pretty Print?
	 *
	 * @var bool
	 * @access private
	 * @since  1.1
	 */
	private $pretty_print = false;

	/**
	 * Log API requests?
	 *
	 * @var bool
	 * @access public
	 * @since  1.1
	 */
	public $log_requests = true;

	/**
	 * Is this a valid request?
	 *
	 * @var bool
	 * @access private
	 * @since  1.1
	 */
	private $is_valid_request = false;

	/**
	 * User ID Perpropertying the API Request
	 *
	 * @var int
	 * @access public
	 * @since  1.1
	 */
	public $user_id = 0;

	/**
	 * Instance of Opalestate Stats class
	 *
	 * @var object
	 * @access private
	 * @since  1.1
	 */
	private $stats;

	/**
	 * Response data to return
	 *
	 * @var array
	 * @access private
	 * @since  1.1
	 */
	private $data = array();

	/**
	 *
	 * @var bool
	 * @access public
	 * @since  1.1
	 */
	public $override = true;
  

	/**
	 * Setup the Opalestate API
	 *
	 * @since 1.1
	 * @access public
	 */
	public function __construct() {

		add_action( 'admin_init', array( $this,'process_action') );
		add_action( 'show_user_profile', array( $this, 'user_key_field' ) );
		add_action( 'edit_user_profile', array( $this, 'user_key_field' ) );
		add_action( 'personal_options_update', array( $this, 'update_key' ) );
		add_action( 'edit_user_profile_update', array( $this, 'update_key' ) );
		add_action( 'opaljob_action', array( $this, 'process_api_key' ) );

		// Setup a backwards compatibility check for user API Keys
		add_filter( 'get_user_metadata', array( $this, 'api_key_backwards_compat' ), 10, 4 );

		// Determine if JSON_PRETTY_PRINT is available
		$this->pretty_print = defined( 'JSON_PRETTY_PRINT' ) ? JSON_PRETTY_PRINT : null;

		// Allow API request logging to be turned off
		$this->log_requests = apply_filters( 'opaljob_api_log_requests', $this->log_requests );
	}

	/**
	 * Registers query vars for API access
	 *
	 * @access public
	 * @since  1.1
	 *
	 * @param array $vars Query vars
	 *
	 * @return string[] $vars New query vars
	 */
	public function process_action() {

		if( isset($_REQUEST['opaljob_action']) ){

			$args = array(
				'user_id' => isset( $_REQUEST['user_id'] ) ? sanitize_text_field( $_REQUEST['user_id'] ) : 0,
				'key_permissions' => isset( $_REQUEST['key_permissions'] ) ? sanitize_text_field( $_REQUEST['key_permissions'] ) : 'read',
				'description' => isset( $_REQUEST['description'] ) ? sanitize_text_field( $_REQUEST['description'] ) : '',
				'opaljob_api_process' => isset( $_REQUEST['opaljob_api_process'] ) ? sanitize_text_field( $_REQUEST['opaljob_api_process'] ) : ''
			);

 
			do_action( 'opaljob_action', $args  );
		}	
	}

	/**
	 * Registers query vars for API access
	 *
	 * @access public
	 * @since  1.1
	 *
	 * @param array $vars Query vars
	 *
	 * @return string[] $vars New query vars
	 */
	public function query_vars( $vars ) {

		$vars[] = 'token';
		$vars[] = 'key';
		$vars[] = 'query';
		$vars[] = 'type';
		$vars[] = 'property';
		$vars[] = 'number';
		$vars[] = 'date';
		$vars[] = 'startdate';
		$vars[] = 'enddate';
		$vars[] = 'donor';
		$vars[] = 'propertyat';
		$vars[] = 'id';
		$vars[] = 'purchasekey';
		$vars[] = 'email';

		return $vars;
	}

	/**
	 * Retrieve the API versions
	 *
	 * @access public
	 * @since  1.1
	 * @return array
	 */
	public function get_versions() {
		return $this->versions;
	}

	/**
	 * Retrieve the API version that was queried
	 *
	 * @access public
	 * @since  1.1
	 * @return string
	 */
	public function get_queried_version() {
		return $this->queried_version;
	}

	/**
	 * Retrieves the default version of the API to use
	 *
	 * @access public
	 * @since  1.1
	 * @return string
	 */
	public function get_default_version() {

		$version = get_option( 'opaljob_default_api_version' );

		if ( defined( 'OPALESTATE_API_VERSION' ) ) {
			$version = OPALESTATE_API_VERSION;
		} elseif ( ! $version ) {
			$version = 'v1';
		}

		return $version;
	}

	/**
	 * Sets the version of the API that was queried.
	 *
	 * Falls back to the default version if no version is specified
	 *
	 * @access private
	 * @since  1.1
	 */
	private function set_queried_version() {

		global $wp_query;

		$version = $wp_query->query_vars['opaljob-api'];

		if ( strpos( $version, '/' ) ) {

			$version = explode( '/', $version );
			$version = strtolower( $version[0] );

			$wp_query->query_vars['opaljob-api'] = str_replace( $version . '/', '', $wp_query->query_vars['opaljob-api'] );

			if ( array_key_exists( $version, $this->versions ) ) {

				$this->queried_version = $version;

			} else {

				$this->is_valid_request = false;
				$this->invalid_version();
			}

		} else {

			$this->queried_version = $this->get_default_version();

		}

	}

	/**
	 * Validate the API request
	 *
	 * Checks for the user's public key and token against the secret key
	 *
	 * @access private
	 * @global object $wp_query WordPress Query
	 * @uses   Opalestate_API::get_user()
	 * @uses   Opalestate_API::invalid_key()
	 * @uses   Opalestate_API::invalid_auth()
	 * @since  1.1
	 * @return void
	 */
	private function validate_request() {
		global $wp_query;

		$this->override = false;

		// Make sure we have both user and api key
		if ( ! empty( $wp_query->query_vars['opaljob-api'] ) && ( $wp_query->query_vars['opaljob-api'] != 'properties' || ! empty( $wp_query->query_vars['token'] ) ) ) {

			if ( empty( $wp_query->query_vars['token'] ) || empty( $wp_query->query_vars['key'] ) ) {
				$this->missing_auth();
			}

			// Retrieve the user by public API key and ensure they exist
			if ( ! ( $user = $this->get_user( $wp_query->query_vars['key'] ) ) ) {

				$this->invalid_key();

			} else {

				$token  = urldecode( $wp_query->query_vars['token'] );
				$secret = $this->get_user_secret_key( $user );
				$public = urldecode( $wp_query->query_vars['key'] );

				if ( hash_equals( md5( $secret . $public ), $token ) ) {
					$this->is_valid_request = true;
				} else {
					$this->invalid_auth();
				}
			}
		} elseif ( ! empty( $wp_query->query_vars['opaljob-api'] ) && $wp_query->query_vars['opaljob-api'] == 'properties' ) {
			$this->is_valid_request = true;
			$wp_query->set( 'key', 'public' );
		}
	}

	/**
	 * Retrieve the user ID based on the public key provided
	 *
	 * @access public
	 * @since  1.1
	 * @global WPDB $wpdb Used to query the database using the WordPress
	 *                      Database API
	 *
	 * @param string $key Public Key
	 *
	 * @return bool if user ID is found, false otherwise
	 */
	public function get_user( $key = '' ) {
		global $wpdb, $wp_query;

		if ( empty( $key ) ) {
			$key = urldecode( $wp_query->query_vars['key'] );
		}

		if ( empty( $key ) ) {
			return false;
		}

		$user = get_transient( md5( 'opaljob_api_user_' . $key ) );

		if ( false === $user ) {
			$user = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = %s LIMIT 1", $key ) );
			set_transient( md5( 'opaljob_api_user_' . $key ), $user, DAY_IN_SECONDS );
		}

		if ( $user != null ) {
			$this->user_id = $user;

			return $user;
		}

		return false;
	}

	public function get_user_public_key( $user_id = 0 ) {
		global $wpdb;

		if ( empty( $user_id ) ) {
			return '';
		}

		$cache_key       = md5( 'opaljob_api_user_public_key' . $user_id );
		$user_public_key = get_transient( $cache_key );

		if ( empty( $user_public_key ) ) {
			$user_public_key = $wpdb->get_var( $wpdb->prepare( "SELECT meta_key FROM $wpdb->usermeta WHERE meta_value = 'opaljob_user_public_key' AND user_id = %d", $user_id ) );
			set_transient( $cache_key, $user_public_key, HOUR_IN_SECONDS );
		}

		return $user_public_key;
	}

	public function get_user_secret_key( $user_id = 0 ) {
		global $wpdb;

		if ( empty( $user_id ) ) {
			return '';
		}

		$cache_key       = md5( 'opaljob_api_user_secret_key' . $user_id );
		$user_secret_key = get_transient( $cache_key );

		if ( empty( $user_secret_key ) ) {
			$user_secret_key = $wpdb->get_var( $wpdb->prepare( "SELECT meta_key FROM $wpdb->usermeta WHERE meta_value = 'opaljob_user_secret_key' AND user_id = %d", $user_id ) );
			set_transient( $cache_key, $user_secret_key, HOUR_IN_SECONDS );
		}

		return $user_secret_key;
	}

 

	/**
	 * Log each API request, if enabled
	 *
	 * @access private
	 * @since  1.1
     *
	 * @global Opalestate_Logging $opaljob_logs
	 * @global WP_Query     $wp_query
	 *
	 * @param array $data
	 *
	 * @return void
	 */
	private function log_request( $data = array() ) {
		if ( ! $this->log_requests ) {
			return;
		}

        /**
         * @var Opalestate_Logging $opaljob_logs
         */
		global $opaljob_logs;

        /**
         * @var WP_Query $wp_query
         */
        global $wp_query;

		$query = array(
			'opaljob-api'    => $wp_query->query_vars['opaljob-api'],
			'key'         => isset( $wp_query->query_vars['key'] ) ? $wp_query->query_vars['key'] : null,
			'token'       => isset( $wp_query->query_vars['token'] ) ? $wp_query->query_vars['token'] : null,
			'query'       => isset( $wp_query->query_vars['query'] ) ? $wp_query->query_vars['query'] : null,
			'type'        => isset( $wp_query->query_vars['type'] ) ? $wp_query->query_vars['type'] : null,
			'property'        => isset( $wp_query->query_vars['property'] ) ? $wp_query->query_vars['property'] : null,
			'customer'    => isset( $wp_query->query_vars['customer'] ) ? $wp_query->query_vars['customer'] : null,
			'date'        => isset( $wp_query->query_vars['date'] ) ? $wp_query->query_vars['date'] : null,
			'startdate'   => isset( $wp_query->query_vars['startdate'] ) ? $wp_query->query_vars['startdate'] : null,
			'enddate'     => isset( $wp_query->query_vars['enddate'] ) ? $wp_query->query_vars['enddate'] : null,
			'id'          => isset( $wp_query->query_vars['id'] ) ? $wp_query->query_vars['id'] : null,
			'purchasekey' => isset( $wp_query->query_vars['purchasekey'] ) ? $wp_query->query_vars['purchasekey'] : null,
			'email'       => isset( $wp_query->query_vars['email'] ) ? $wp_query->query_vars['email'] : null,
		);

		$log_data = array(
			'log_type'     => 'api_request',
			'post_excerpt' => http_build_query( $query ),
			'post_content' => ! empty( $data['error'] ) ? $data['error'] : '',
		);

		$log_meta = array(
			'request_ip' => opaljob_get_ip(),
			'user'       => $this->user_id,
			'key'        => isset( $wp_query->query_vars['key'] ) ? $wp_query->query_vars['key'] : null,
			'token'      => isset( $wp_query->query_vars['token'] ) ? $wp_query->query_vars['token'] : null,
			'time'       => $data['request_speed'],
			'version'    => $this->get_queried_version()
		);
	}


	/**
	 * Retrieve the output data
	 *
	 * @access public
	 * @since  1.1
	 * @return array
	 */
	public function get_output() {
		return $this->data;
	}

	/**
	 * Output Query in either JSON/XML. The query data is outputted as JSON
	 * by default
	 *
	 * @since 1.1
	 * @global WP_Query $wp_query
	 *
	 * @param int $status_code
	 */
	public function output( $status_code = 200 ) {
        /**
         * @var WP_Query $wp_query
         */
		global $wp_query;

		$propertyat = $this->get_output_propertyat();

		status_header( $status_code );

		do_action( 'opaljob_api_output_before', $this->data, $this, $propertyat );

		switch ( $propertyat ) :

			case 'xml' :

				require_once OPALESTATE_PLUGIN_DIR . 'inc/libraries/array2xml.php';
				$xml = Array2XML::createXML( 'opaljob-pro', $this->data );
				echo $xml->saveXML();

				break;

			case 'json' :

				header( 'Content-Type: application/json' );
				if ( ! empty( $this->pretty_print ) ) {
					echo json_encode( $this->data, $this->pretty_print );
				} else {
					echo json_encode( $this->data );
				}

				break;


			default :

				// Allow other propertyats to be added via extensions
				do_action( 'opaljob_api_output_' . $propertyat, $this->data, $this );

				break;

		endswitch;

		do_action( 'opaljob_api_output_after', $this->data, $this, $propertyat );

		die();
	}

	/**
	 * Modify User Profile
	 *
	 * Modifies the output of profile.php to add key generation/revocation
	 *
	 * @access public
	 * @since  1.1
	 *
	 * @param object $user Current user info
	 *
	 * @return void
	 */
	function user_key_field( $user ) {

		if ( ( opaljob_get_option( 'api_allow_user_keys', false ) || current_user_can( 'manage_opaljob_settings' ) ) && current_user_can( 'edit_user', $user->ID ) ) {
			$user = get_userdata( $user->ID );
			?>
			<hr class="clearfix clear">
			<table class="property-table">
				<tbody>
				<tr>
					<th>
						<?php esc_html_e( 'Opalestate API Keys', 'opaljob-pro' ); ?>
					</th>
					<td>
						<?php
						$public_key = $this->get_user_public_key( $user->ID );
						$secret_key = $this->get_user_secret_key( $user->ID );
						?>
						<?php if ( empty( $user->opaljob_user_public_key ) ) { ?>
							<input name="opaljob_set_api_key" type="checkbox" id="opaljob_set_api_key" value="0"/>
							<span class="description"><?php esc_html_e( 'Generate API Key', 'opaljob-pro' ); ?></span>
						<?php } else { ?>
							<strong style="display:inline-block; width: 125px;"><?php esc_html_e( 'Public key:', 'opaljob-pro' ); ?>&nbsp;</strong>
							<input type="text" disabled="disabled" class="regular-text" id="publickey" value="<?php echo esc_attr( $public_key ); ?>"/>
							<br/>
							<strong style="display:inline-block; width: 125px;"><?php esc_html_e( 'Secret key:', 'opaljob-pro' ); ?>&nbsp;</strong>
							<input type="text" disabled="disabled" class="regular-text" id="privatekey" value="<?php echo esc_attr( $secret_key ); ?>"/>
							<br/>
							<strong style="display:inline-block; width: 125px;"><?php esc_html_e( 'Token:', 'opaljob-pro' ); ?>&nbsp;</strong>
							<input type="text" disabled="disabled" class="regular-text" id="token" value="<?php echo esc_attr( $this->get_token( $user->ID ) ); ?>"/>
							<br/>
							<input name="opaljob_set_api_key" type="checkbox" id="opaljob_set_api_key" value="0"/>
							<span class="description"><label for="opaljob_set_api_key"><?php esc_html_e( 'Revoke API Keys', 'opaljob-pro' ); ?></label></span>
						<?php } ?>
					</td>
				</tr>
				</tbody>
			</table>
		<?php }
	}

	/**
	 * Process an API key generation/revocation
	 *
	 * @access public
	 * @since  1.1
	 *
	 * @param array $args
	 *
	 * @return void
	 */
	public function process_api_key( $args ) {  
		
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'opaljob-api-nonce' ) ) {
			wp_die( esc_html__( 'Nonce verification failed.', 'opaljob-pro' ), esc_html__( 'Error', 'opaljob-pro' ), array( 'response' => 403 ) );
		}

		if ( empty( $args['user_id'] ) ) {
			wp_die( esc_html__( 'User ID Required.', 'opaljob-pro' ), esc_html__( 'Error', 'opaljob-pro' ), array( 'response' => 401 ) );
		}

		if ( is_numeric( $args['user_id'] ) ) {
			$user_id = isset( $args['user_id'] ) ? absint( $args['user_id'] ) : get_current_user_id();
		} else {
			$userdata = get_user_by( 'login', $args['user_id'] );
			$user_id  = $userdata->ID;
		}
		$process = isset( $args['opaljob_api_process'] ) ? strtolower( $args['opaljob_api_process'] ) : false;

		

		if ( $user_id == get_current_user_id() && ! opaljob_get_option( 'allow_user_api_keys' ) && ! current_user_can( 'manage_opaljob_settings' ) ) {
			wp_die(
				sprintf(
					/* translators: %s: process */
					esc_html__( 'You do not have permission to %s API keys for this user.', 'opaljob-pro' ),
					$process
				),
				esc_html__( 'Error', 'opaljob-pro' ),
				array( 'response' => 403 )
			);
		} elseif ( ! current_user_can( 'manage_opaljob_settings' ) ) {
			wp_die(
				sprintf(
					/* translators: %s: process */
					esc_html__( 'You do not have permission to %s API keys for this user.', 'opaljob-pro' ),
					$process
				),
				esc_html__( 'Error', 'opaljob-pro' ),
				array( 'response' => 403 )
			);
		}

		switch ( $process ) {
			case 'generate':
				if ( $this->generate_api_key( $user_id ) ) {
					delete_transient( 'opaljob_total_api_keys' );
					wp_redirect( add_query_arg( 'opaljob-message', 'api-key-generated', 'edit.php?post_type=opaljob_job&page=opal-job-settings&tab=api_keys' ) );
					exit();
				} else {
					wp_redirect( add_query_arg( 'opaljob-message', 'api-key-failed', 'edit.php?post_type=opaljob_job&page=opal-job-settings&tab=api_keys' ) );
					exit();
				}
				break;
			case 'regenerate':
				$this->generate_api_key( $user_id, true );
				delete_transient( 'opaljob_total_api_keys' );
				wp_redirect( add_query_arg( 'opaljob-message', 'api-key-regenerated', 'edit.php?post_type=opaljob_job&page=opal-job-settings&tab=api_keys' ) );
				exit();
				break;
			case 'revoke':
				$this->revoke_api_key( $user_id );
				delete_transient( 'opaljob_total_api_keys' );
				wp_redirect( add_query_arg( 'opaljob-message', 'api-key-revoked', 'edit.php?post_type=opaljob_job&page=opal-job-settings&tab=api_keys' ) );
				exit();
				break;
			default;
				break;
		}
	}

	/**
	 * Generate new API keys for a user
	 *
	 * @access public
	 * @since  1.1
	 *
	 * @param int $user_id User ID the key is being generated for
	 * @param boolean $regenerate Regenerate the key for the user
	 *
	 * @return boolean True if (re)generated succesfully, false otherwise.
	 */
	public function generate_api_key( $user_id = 0, $regenerate = false ) {

		if ( empty( $user_id ) ) {
			return false;
		}

		$user = get_userdata( $user_id );

		if ( ! $user ) {
			return false;
		}

		$public_key = $this->get_user_public_key( $user_id );
		$secret_key = $this->get_user_secret_key( $user_id );

		if ( empty( $public_key ) || $regenerate == true ) {
			$new_public_key = $this->generate_public_key( $user->user_email );
			$new_secret_key = $this->generate_private_key( $user->ID );
		} else {
			return false;
		}

		if ( $regenerate == true ) {
			$this->revoke_api_key( $user->ID );
		}


		update_user_meta( $user_id, $new_public_key, 'opaljob_user_public_key' );
		update_user_meta( $user_id, $new_secret_key, 'opaljob_user_secret_key' );

		return true;
	}

	/**
	 * Revoke a users API keys
	 *
	 * @access public
	 * @since  1.1
	 *
	 * @param int $user_id User ID of user to revoke key for
	 *
	 * @return string
	 */
	public function revoke_api_key( $user_id = 0 ) {

		if ( empty( $user_id ) ) {
			return false;
		}

		$user = get_userdata( $user_id );

		if ( ! $user ) {
			return false;
		}

		$public_key = $this->get_user_public_key( $user_id );
		$secret_key = $this->get_user_secret_key( $user_id );
		if ( ! empty( $public_key ) ) {
			delete_transient( md5( 'opaljob_api_user_' . $public_key ) );
			delete_transient( md5( 'opaljob_api_user_public_key' . $user_id ) );
			delete_transient( md5( 'opaljob_api_user_secret_key' . $user_id ) );
			delete_user_meta( $user_id, $public_key );
			delete_user_meta( $user_id, $secret_key );
		} else {
			return false;
		}

		return true;
	}

	public function get_version() {
		return self::VERSION;
	}


	/**
	 * Generate and Save API key
	 *
	 * Generates the key requested by user_key_field and stores it in the database
	 *
	 * @access public
	 * @since  1.1
	 *
	 * @param int $user_id
	 *
	 * @return void
	 */
	public function update_key( $user_id ) {
		if ( current_user_can( 'edit_user', $user_id ) && isset( $_POST['opaljob_set_api_key'] ) ) {

			$user = get_userdata( $user_id );

			$public_key = $this->get_user_public_key( $user_id );
			$secret_key = $this->get_user_secret_key( $user_id );

			if ( empty( $public_key ) ) {
				$new_public_key = $this->generate_public_key( $user->user_email );
				$new_secret_key = $this->generate_private_key( $user->ID );

				update_user_meta( $user_id, $new_public_key, 'opaljob_user_public_key' );
				update_user_meta( $user_id, $new_secret_key, 'opaljob_user_secret_key' );
			} else {
				$this->revoke_api_key( $user_id );
			}
		}
	}

	/**
	 * Generate the public key for a user
	 *
	 * @access private
	 * @since  1.1
	 *
	 * @param string $user_email
	 *
	 * @return string
	 */
	private function generate_public_key( $user_email = '' ) {
		$auth_key = defined( 'AUTH_KEY' ) ? AUTH_KEY : '';
		$public   = hash( 'md5', $user_email . $auth_key . date( 'U' ) );

		return $public;
	}

	/**
	 * Generate the secret key for a user
	 *
	 * @access private
	 * @since  1.1
	 *
	 * @param int $user_id
	 *
	 * @return string
	 */
	private function generate_private_key( $user_id = 0 ) {
		$auth_key = defined( 'AUTH_KEY' ) ? AUTH_KEY : '';
		$secret   = hash( 'md5', $user_id . $auth_key . date( 'U' ) );

		return $secret;
	}

	/**
	 * Retrieve the user's token
	 *
	 * @access private
	 * @since  1.1
	 *
	 * @param int $user_id
	 *
	 * @return string
	 */
	public function get_token( $user_id = 0 ) {
		return hash( 'md5', $this->get_user_secret_key( $user_id ) . $this->get_user_public_key( $user_id ) );
	}

	/**
	 * API Key Backwards Compatibility
	 *
	 * A Backwards Compatibility call for the change of meta_key/value for users API Keys
	 *
	 * @since  1.3.6
	 *
	 * @param  string $check     Whether to check the cache or not
	 * @param  int    $object_id The User ID being passed
	 * @param  string $meta_key  The user meta key
	 * @param  bool   $single    If it should return a single value or array
	 *
	 * @return string            The API key/secret for the user supplied
	 */
	public function api_key_backwards_compat( $check, $object_id, $meta_key, $single ) {

		if ( $meta_key !== 'opaljob_user_public_key' && $meta_key !== 'opaljob_user_secret_key' ) {
			return $check;
		}

		$return = $check;

		switch ( $meta_key ) {
			case 'opaljob_user_public_key':
				$return = $this->get_user_public_key( $object_id );
				break;
			case 'opaljob_user_secret_key':
				$return =$this->get_user_secret_key( $object_id );
				break;
		}

		if ( ! $single ) {
			$return = array( $return );
		}

		return $return;

	}
}
