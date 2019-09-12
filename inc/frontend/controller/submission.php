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
use Opal_Job\Frontend\Metabox;
use Opal_Job\Common\Model;

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
class Submission  extends Controller {

	/**
	 * Store Instance of Model/User
	 *
	 * @var User $model
	 */
	public $model;

	/**
	 * Register callbacks for actions and filters
	 *
	 * @since    1.0.0
	 */
	public function register_ajax_hook_callbacks () {
		add_action( 'wp_ajax_opaljob_submitted_job_data', 			 	 array( $this, 'save' ) );
		add_action( 'wp_ajax_nopriv_opaljob_submitted_job_data',	 	 array( $this, 'save') );
	}

	/**
	 * Register callbacks for actions and filters
	 *
	 * @since    1.0.0
	 */
	public function register_hook_callbacks() {
		add_action( "opaljob/dashboard/tab_content/submission", array( $this, 'render_submission_form' ) );
		add_action( "opaljob/dashboard/tab_content/submission_edit", array( $this, 'render_submission_form' ) );
		add_filter( "opaljob_job_edit_link", array( $this, 'get_edit_link' ) , 1 );
		

		add_action( "init", array( $this, 'save' ) );
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
	 * Get/Set User Model 
	 *
	 * Check the module is loaded or not to create new Model/User Object.
	 *
	 * @since 1.0
	 *
	 * @return Model/User is instance of this
	 */
	public function save () {

		if( isset( $_POST['submission_action'] ) ){ 
			
			$status = false;
			$edit 	= false;
			if ( wp_verify_nonce( $_POST['submission_action'], 'save-submission-data' ) ) {
	 	 		///
	 	 		do_action( "opaljob/submission/process_submit/before" );	

	 	 		///
	 	 		$prefix 	  = OPAL_JOB_METABOX_PREFIX;
	 	 		$user_id      = get_current_user_id();
	 	 		$post_status  = 'pending';	
	 	 		$post_date    = '';
	 	 		$post_id 	  = ! empty( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : false;

	 	 		$post_content = isset( $_POST[ $prefix . 'text' ] ) ? wp_kses( $_POST[ $prefix . 'text' ],
						'<b><strong><i><em><h1><h2><h3><h4><h5><h6><pre><code><span><p>' ) : '';

				$data    = [
					'post_title'   => sanitize_text_field( $_POST[ $prefix . 'title' ] ),
					'post_author'  => $user_id,
					'post_status'  => $post_status,
					'post_date'    => $post_date,
					'post_content' => $post_content,
				];

				if ( ! empty( $post_id ) ) {
					$edit       = true;
					$data['ID'] = $post_id;

					do_action( "opaljob/submission/process_edit/before" );	
				} else {
					do_action( "opaljob/submission/process_new/before" );	
				}

				$post_id = $this->get_model()->save( $data );
			 	
				if ( ! empty( $post_id ) ) {					
					$metabox = new Metabox\Job_Metabox();
					$metabox->save_fields_data( 'post', $post_id ); 
				}

				////
				$status = true; 
				/// 
	 	 		do_action( "opaljob/submission/process_submit/after" );	

	 	 		if( $edit  ) {
	 	 			do_action( "opaljob/submission/process_edit/after" );	

	 	 			$message = esc_html__('The property has edited success. Please wait to redirect to back the list', 'opaljob' ); 
	 	 			return opaljob_output_msg_json( $status,
							$message,
							array( 
								'heading'  => esc_html__('Edited Job' ,'opaljob'),
								'redirect' => URI::get_dashboard_url( 'my_listing', array('do' => 'completed') )
							)
					 );

	 	 		} else {
	 	 			do_action( "opaljob/submission/process_new/after" , $post_id );	
	 	 		}
	 	 		
	 	 		///
	 	 		$message = esc_html__('The property has updated completed with new information', 'opaljob' ); 
 	 		 	
 	 		 	return opaljob_output_msg_json( $status,
						$message,
						array( 
							'heading'  => esc_html__('Submitted Job' ,'opaljob'),
							'redirect' => URI::get_dashboard_url( 'submission', array('do' => 'completed') )
						)
				 );
	 		}

			$message = esc_html__('Your submission could not save, please try to check all information', 'opaljob' ); 
	 		
	 		return opaljob_output_msg_json( $status,
				$message,
				array( 
					'heading'  => esc_html__('Submitted Job' ,'opaljob')
				)
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
	public function render_submission_form () {
		
		if( !opaljob_has_role('employer') ) {
			echo View::render_template( "dashboard/has-not-permission" );
		} else {
			if( isset($_GET['do']) && $_GET['do'] == 'completed' ) {
				echo View::render_template( "submission/completed" );
			} else {

				$metabox = new Metabox\Job_Metabox();  

				$post_id =  isset($_GET['post_id'] ) ? intval( $_GET['post_id'] ) : 0;  
				$metabox->set_object_id (  $post_id  ); 

				$allow = false;

				if( $post_id > 0 ) {
					$allow = opaljob_user_can_edit_job( $post_id ); 
					echo View::render_template( "submission/submission-form-edit", array( 'metabox' => $metabox, 'allow' => $allow ) );
				} else {
					$allow = opaljob_user_can_submit_job( $post_id ); 
					echo View::render_template( "submission/submission-form", array( 'metabox' => $metabox, 'allow' => $allow ) );
				}
			}
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
	public function get_edit_link ( $id )  {
		return URI::get_dashboard_url( 'submission_edit', array('post_id' => $id ) );
	}
}