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
class Job_Api  extends  Base_Api {

	/**
	 * The unique identifier of the route resource.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string $base.
	 */
	public $base = '/job';
 	
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
	 	/// call http://domain.com/wp-json/job-api/v1/job/list  ////
		register_rest_route( $this->namespace, $this->base.'/list', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => array( $this, 'get_list' ),
			'permission_callback' => array( $this, 'validate_request'  ),
		));
		/// call http://domain.com/wp-json/job-api/v1/job/1  ////
		register_rest_route( $this->namespace, $this->base.'/(?P<id>\d+)', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => array( $this, 'get_job' ),
			'permission_callback' => array( $this, 'validate_request' ),
		));

		/// call http://domain.com/wp-json/job-api/v1/job/create  ////
		register_rest_route( $this->namespace, $this->base.'/create', array(
			'methods' => 'GET',
			'callback' => array( $this, 'create' ),
			'permission_callback' => array( $this, 'validate_request' ),
		));
		/// call http://domain.com/wp-json/job-api/v1/job/edit  ////
		register_rest_route( $this->namespace, $this->base.'/edit', array(
			'methods' => 'GET',
			'callback' => array( $this, 'edit' ),
		));
		/// call http://domain.com/wp-json/job-api/v1/job/delete  ////
		register_rest_route( $this->namespace, $this->base.'/delete', array(
			'methods' => 'GET',
			'callback' => array( $this, 'delete' ),
			'permission_callback' => array( $this, 'validate_request' ),
		));

		/**
		 *  List job by tags and taxonmies 
		 */
		/// call http://domain.com/wp-json/job-api/v1/jobs  ////
		register_rest_route( $this->namespace, $this->base.'/tags', array(
			'methods' => 'GET',
			'callback' => array( $this, 'delete' ),
			'permission_callback' => array( $this, 'validate_request' ),
		));
	}

	/**
	 * Get Job Data
	 *
	 * Formating output of data with job information and employer information
	 *
	 * @since 1.0
	 *
	 * @return avoid
	 */
	private function get_job_data ( $job_id ){

		$job 	=   opaljob_new_job_object( get_the_ID() );

		$member = $job->get_employer();

		// employer data
		$employer = array(
			'name' 	 => $member->get_name(),
			'avatar' => $member->get_avatar(),
			'ID'	 => $member->ID	
		);
		// categories
		$categories = array() ;

		/// tags
		$tags = array();

		/// 
		$images = array();

		$output = array(
			'ID'		   	=> $job->ID,
			'post_title'   	=> $job->post_title,
			'post_content' 	=> $job->post_content,
			'post_excerpt' 	=> $job->post_excerpt,
			'post_status'  	=> $job->post_status,
			'post_excerpt' 	=> $job->post_excerpt,
			'modified'     	=> $job->post_modified,
			'expired'	   	=> $job->get_meta( 'expired_date' ),
			'deadline_date' => $job->get_meta( 'deadline_date' ),
			'guid' 		    => $job->guid,
			'employer' 	   	=> $employer,
			'types'			=> array(),
			'categories'	=> $categories,
		);

		$taxs = array(
			'opaljob_specialism',
			'opaljob_category',
			'opaljob_tag',
			'opaljob_location',
			'opaljob_types'
		);

		foreach ( $taxs as $tax ) {
			$tdata = wp_get_post_terms( $job_id, $tax );
			if( !is_wp_error( $tdata )  ) {
				foreach ( $tdata as $t ) {
					$tax = str_replace( "opaljob_", "", $tax );
					$output[$tax][] = array(
						'name' 	  => $t->name,
						'slug' 	  => $t->slug,
						'term_id' => $t->term_id
					);
				}
			}
		} 

		return $output;
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
	public function get_list ( $request ) {

		// if enable cache 
		$response 		     = array();
 		
 		$response['message'] = esc_html__( 'Fetched jobs done', 'opaljob' );

 		$args   = []; 
		$query  = Job_Query::get_job_query( $args ); 
		$jobs   = [];

		while ( $query->have_posts() ) {
			$query->the_post();
			$jobs[] = $this->get_job_data( get_the_ID() );
		}

		wp_reset_query();

		$response['jobs'] 	 = $jobs;
		$response['pages'] 	 = 4; 
		$response['current'] = 1;
		return $this->get_response( 200, $response );
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
	public function get_job ( $request ) { 
		
		$response 		     = array();

		if( $request['id'] > 0 ) {
			$job = $this->get_job_data( $request['id'] );
			$response['job'] = $job['ID'] ? $job : array();
		}

 		return $this->get_response( 200, $response );
	}

	/**
	 * Delete job
	 *
	 * Based on request to get collection
	 *
	 * @since 1.0
	 *
	 * @return WP_REST_Response is json data
	 */
	public function delete( ) {

	}


	public function reviews () {

	}

	public function categories () {

	}
	
	public function tags () {
		
	}
}