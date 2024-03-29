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
use Opal_Job\Core\View;

use Opal_Job\Core;
use Opal_Job\Core\URI;
use Opal_Job\Core\Controller;
use Opal_Job\Frontend\Metabox\User_Metabox;
use Opal_Job\Libraries\Form\Scripts;
use Opal_Job\Common\Model\User; 

/**
 * Class Dashboard Controller
 *
 * After logined system, this will be used for show menu dashboard, and contents of management pages
 * Such as show sidebar content , main content with hooks in each view templates
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author    WpOpal
 */

class Candidate extends Controller {

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
		//// Candidate actions //////
		add_action( 'wp_ajax_opaljob_candidate_apply_now', array($this,'process_candidate_apply') );
		add_action( 'wp_ajax_nopriv_opaljob_candidate_apply_now', array($this,'process_candidate_apply') );
 	
		add_action( 'wp_ajax_nopriv_opaljob_toggle_candidate_favorite', array($this,'process_candidate_favorite') );

		/// apply job ///
		/// 
		add_action( 'wp_ajax_opaljob_apply_job_data', array($this,'process_candidate_apply') );
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
	public function register_hook_callbacks () { 
		add_action( "opaljob/dashboard/tab_content/resume", array( $this, 'render_dashboard_resume' ) );
		add_action( "opaljob/dashboard/tab_content/resumecv", array( $this, 'render_dashboard_resumecv' ) );
		add_action( "opaljob/dashboard/tab_content/following_employers", array( $this, 'render_following_employers' ) );
		add_action( "opaljob/dashboard/tab_content/myapplied", array( $this, 'render_myapplied' ) );
		add_action( 'opaljob/dashboard/tab_content/summary', [$this, 'tab_content_summary'] );
		// add_action( "opaljob/dashboard/tab_content/profile", array( $this, 'render_dashboard_profile' ) );
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
			$this->model = User::get_instance();
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
	public function process_candidate_apply() {

		if( isset($_POST['employer_id']) && intval($_POST['employer_id']) > 0 && isset($_POST['job_id']) && intval($_POST['job_id']) ){



			$employer_id = intval( $_POST['employer_id'] ); 
			$job_id 	 = intval( $_POST['job_id'] ); 

			$member 	 = opaljob_new_employer_object( $employer_id );
			$job 	 	 = opaljob_new_job_object( $job_id );


			do_action( 'opaljob/user/candidate_apply/before', $employer_id, $member );

			$status	 	 = $this->get_model()->applied_job( $job_id );
			
			
			$msg = esc_html__( 'You followed this employer success.', 'opaljob' );
		
			
			$member->update_count_followers( $status );
			$html 	 	 =  View::render_template( 'single-job/parts/apply-button', array('member' => $member ,'id' => $job_id ) );

			return opaljob_output_msg_json(
				true,
				$msg,
				array( 'html' => $html )
			);
		}
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
	public function render_myapplied() {

		$jobs = $this->get_model()->get_applied_jobs();

		$args = array(
			'jobs' => $jobs
		);

		echo View::render_template( "dashboard/candidate/applied-jobs", $args );
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
	public function render_following_employers() {

		$members = $this->get_model()->get_followers();

		$args = array(
			'members' => $members
		);

		echo View::render_template( "dashboard/candidate/following-employers", $args );
	}


	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function render_dashboard_resume() {
		$metabox = new User_Metabox();
		
		$type = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : "resume"; 
		$metabox->type = $type;

		$args = array( 
			'metabox' 	=> $metabox,
			'action'	=> 'save_change'.$type,
			'type'		=> $type 
		); 
		echo View::render_template( "dashboard/metabox-form", $args );
	}
	
	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function render_dashboard_resumecv() {
		$metabox = new User_Metabox();
		
		$type = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : "resumecv"; 
		$metabox->type = $type;

		$args = array( 
			'metabox' 	=> $metabox,
			'action'	=> 'save_change'.$type,
			'type'		=> $type 
		); 
		echo View::render_template( "dashboard/metabox-form", $args );
	}

	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function tab_content_summary (){   

	//	add_action( 'opaljob_dashboard_candidate_summary_top' , array( $this, 'summary_top' ) );
	//	add_action( 'opaljob_dashboard_candidate_summary_middle_left'  , array( $this, 'summary_middle_left' ) );
	 
		echo View::render_template( "dashboard/candidate/summary" );
	}
}