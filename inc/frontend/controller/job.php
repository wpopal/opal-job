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
namespace Opal_Job\Frontend\Controller;

use WP_Error;
use Exception; 
use Opal_Job\Core\View;
use Opal_Job\Core\URI;
use Opal_Job\Core\Controller;
use Opal_Job\Common\Model as Model; 
use Opal_Job\Frontend\Metabox;
use Opal_Job\Common\Model\Query\Job_Query;
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author    WpOpal
 */
class Job  extends Controller {

	/**
	 * Store Instance of Model/User
	 *
	 * @var User $model
	 */
	public $model;

	/**
	 * Process Save Data Post Profile
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function register_ajax_hook_callbacks () {
 
		add_action( 'wp_ajax_opaljob_get_jobs_map', array($this,'get_jobs_map') );
 
	}

	/**
	 * Register callbacks for actions and filters
	 *
	 * @since    1.0.0
	 */
	public function register_hook_callbacks() {
		add_action( "opaljob/job/listing/employer", array( $this, 'render_listing_by_employer' ) , 1, 1 );
	}	

	/**
	 * Get/Set User Model 
	 *
	 * Check the module is loaded or not to create new Model/User Object.
	 *
	 * @since 1.0
	 *
	 * @return Model/User is instance of this
	 */
	public function get_model (){
		if(!$this->model ){
			$this->model = new Model\Job();
		}
		return $this->model; 
	}
	/**
	 * Process Save Data Post Profile
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function render_listing_by_employer( $id ){

		//if( opaljob_has_role('employer') ) {
			$jobs = $this->get_model()->get_list_by_employer( $id ); 
			echo View::render_template( "common/job/by-employer", array( 'jobs' =>  $jobs, 'founds' => 12 ) );
	//	} else {
//			echo View::render_template( "dashboard/has-not-permission" );
	//	}
	}

	public function get_jobs_map () {

		$query = Job_Query::get_job_query();
		$output = [];

		while ( $query->have_posts() ) {
			$query->the_post();
			$property = opalesetate_property( get_the_ID() );
			$output[] = $property->get_meta_search_objects();
		}

		wp_reset_query();

		echo json_encode( $output );
		exit;
	}
	
}