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
use Opal_Job\API\Api_Auth;
/**
 * Abstract class to define/implement base methods for all controller classes
 *
 * @since      1.0.0
 * @package    Opal_Job
 * @subpackage Opal_Job/controllers
 */
class Api_Register {
	
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_base_name The string used to uniquely identify this plugin.
	 */	
	public $base = 'job-api';

	/**
	 * Registers a new rewrite endpoint for accessing the API
	 *
	 * @access public
	 *
	 * @param array $rewrite_rules WordPress Rewrite Rules
	 *
	 * @since  1.1
	 */
	public function init() {
		
		add_action( 'rest_api_init', [$this,'register_resources'] ); 
		$this->register_resources(); 
	}


	/**
	 * Registers a new rewrite endpoint for accessing the API
	 *
	 * @access public
	 *
	 * @param array $rewrite_rules WordPress Rewrite Rules
	 *
	 * @since  1.1
	 */
	public function add_endpoint( $rewrite_rules ) { 
		add_rewrite_endpoint( $this->base, EP_ALL );
	}

	/**
	 * Registers a new rewrite endpoint for accessing the API
	 *
	 * @access public
	 *
	 * @param array $rewrite_rules WordPress Rewrite Rules
	 *
	 * @since  1.1
	 */
	public function register_resources (   ) {  
		$api_classes = apply_filters( 'woocommerce_api_classes',
			array(
				'\\Opal_Job\\API\\V1\\Job_Api',
				'\\Opal_Job\\API\\V1\\Candidate_Api',
				'\\Opal_Job\\API\\V1\\Employer_Api'
			)
		);

		$auth = new Api_Auth();
		foreach ( $api_classes as $api_class ) {
			$api_class = new $api_class(  );
		}
	}

}