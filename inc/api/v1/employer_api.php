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
use Opal_Job\Common\Model\Query\User_Query; 

/**
 * Abstract class to define/implement base methods for all controller classes
 *
 * @since      1.0.0
 * @package    Opal_Job
 * @subpackage Opal_Job/controllers
 */
class Employer_Api  extends  Base_Api {

	/**
	 * The unique identifier of the route resource.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string $base.
	 */
	public $base = '/employer';
 	
 	/**
	 * Register Routes
	 *
	 * Register all CURD actions with POST/GET/PUT and calling function for each
	 *
	 * @since 1.0
	 *
	 * @return avoid
	 */
	public function register_routes () {  
	 	/// call http://domain.com/wp-json/job-api/v1/jobs  ////
		register_rest_route( $this->namespace, $this->base.'/list', array(
			'methods' => 'GET',
			'callback' => array( $this, 'get_list' ),
			'permission_callback' => array( $this, 'validate_request'  ),
		));
		/// call http://domain.com/wp-json/job-api/v1/jobs  ////
		register_rest_route( $this->namespace, $this->base.'/create', array(
			'methods' => 'GET',
			'callback' => array( $this, 'create' ),
			'permission_callback' => array( $this, 'validate_request'  ),
		));
		/// call http://domain.com/wp-json/job-api/v1/jobs  ////
		register_rest_route( $this->namespace, $this->base.'/edit', array(
			'methods' => 'GET',
			'callback' => array( $this, 'edit' ),
			'permission_callback' => array( $this, 'validate_request'  ),
		));
		/// call http://domain.com/wp-json/job-api/v1/jobs  ////
		register_rest_route( $this->namespace, $this->base.'/delete', array(
			'methods' => 'GET',
			'callback' => array( $this, 'delete' ),
			'permission_callback' => array( $this, 'validate_request'  ),
		));
	}

	/**
	 * Get List Of Employer
	 *
	 * Based on request to get collection
	 *
	 * @since 1.0
	 *
	 * @return WP_REST_Response is json data
	 */
	public function get_list (  ) {

		$response 		     = array();

 		$response['message'] = esc_html__( 'Fetched employers done', 'opaljob' );

 		$default = array(
			'show_pagination' => '',
			'show_more' 	  => '',
			'show_categories' => '',
			'show_featured'   => '',
			'layout'		  => 'content-candidate-list',
			'items_per_grid'  => 1,
			'grid_class'	  => '',
		);   

		$query = new User_Query(); 
		
		$members = $query->get_api_list_candidates(); 

		$response['employers'] = $members;

		return $this->get_response( 200, $response );
	}
}