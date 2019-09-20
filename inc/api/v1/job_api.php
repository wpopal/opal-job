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
 * Abstract class to define/implement base methods for all controller classes
 *
 * @since      1.0.0
 * @package    Opal_Job
 * @subpackage Opal_Job/controllers
 */
class Job_Api  extends  Base_Api {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_base_name The string used to uniquely identify this plugin.
	 */
	public $base = '/job';
 	
 	/**
	 * Definition
	 *
	 *	Register all Taxonomy related to Job post type as location, category, Specialism, Types
	 *
	 * @since 1.0
	 *
	 * @return avoid
	 */
	public function register_routes ( ) {  
	 	/// call http://domain.com/wp-json/job-api/v1/job/list  ////
		register_rest_route( $this->namespace, $this->base.'/list', array(
			'methods' => 'GET',
			'callback' => array( $this, 'get_list' ),
		));
		/// call http://domain.com/wp-json/job-api/v1/job/create  ////
		register_rest_route( $this->namespace, $this->base.'/create', array(
			'methods' => 'GET',
			'callback' => array( $this, 'create' ),
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
		));

		/**
		 *  List job by tags and taxonmies 
		 */
		/// call http://domain.com/wp-json/job/v1/jobs  ////
		register_rest_route( $this->namespace, $this->base.'/tags', array(
			'methods' => 'GET',
			'callback' => array( $this, 'delete' ),
		));

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
	private function get_job ( $job_id ){

		$job =   opaljob_new_job_object( get_the_ID() );

	
		$member = $job->get_employer();

		$employer = array(
			'name' 	 => $member->get_name(),
			'avatar' => $member->get_avatar(),
			'ID'	 => $member->ID	
		);

		$output = array(
			'employer' 	   	=> $employer,
			'ID'		   	=> $job->ID,
			'post_title'   	=> $job->post_title,
			'post_content' 	=> $job->post_content,
			'post_excerpt' 	=> $job->post_excerpt,
			'post_status'  	=> $job->post_status,
			'post_excerpt' 	=> $job->post_excerpt,
			'modified'     	=> $job->post_modified,
			'expired'	   	=> $job->get_meta( 'expired_date' ),
			'deadline_date' => $job->get_meta( 'deadline_date' ),
			'guid' 		    => $job->guid
		);

		return $output;
		return $job; 
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
	public function get_list ( $request ) {

		// if enable cache 
		$response 		     = array();
 		
 		$response['message'] = esc_html__( 'Fetched jobs done', 'opaljob' );

 		$args   = []; 
		$query  = Job_Query::get_job_query( $args ); 
		$jobs   = [];

		while ( $query->have_posts() ) {
			$query->the_post();
			$jobs[] = $this->get_job( get_the_ID() );
		}

		wp_reset_query();

		$response['jobs'] = $jobs;

		return $this->get_response( 200, $response );
	}


	public function delete( ) {

	}

	
}