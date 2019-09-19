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
use Opal_Job\Common\Model;
use Opal_Job\Libraries\Form\Form; 
use Opal_Job\Frontend\Metabox\User_Metabox;
use Opal_Job\Common\Model\Query\User_Query;

// use Opal_Job\Common\Model\User;
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
class User extends Controller {

	public $model;

	public $control; 
	

	public function get_control () {  
		if( opaljob_has_role('employer') ){
			$this->control = new \Opal_Job\Frontend\Controller\Employer();
		}else if( opaljob_has_role('candidate') ){
			$this->control = new \Opal_Job\Frontend\Controller\Candidate();
		}
		return $this->control; 
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
	public function register_ajax_hook_callbacks() {
		
		// ajax process actions 
		add_action( 'wp_ajax_opaljob_save_changepass', array($this,'save_change_password') );
		add_action( 'wp_ajax_nopriv_opaljob_save_changepass', array($this,'save_change_password') );
		add_action( 'wp_ajax_opaljob_get_html_search_candidates',  array($this,'get_html_search_candidates') ); 
		

		add_action( 'wp_ajax_opaljob_get_candidates_map', array($this, 'get_candidates_map') );

		// call sub controller to process addition functions follow by role
		if( !is_admin() && $this->get_control() ) {
			$this->control->register_ajax_hook_callbacks();
		}
	}
 
	/**
	 * Register callbacks for actions and filters
	 *
	 * @since    1.0.0
	 */
	public function register_hook_callbacks() {
		
		///// display content of profile page in user dashboard ///////
 		add_action( "opaljob/dashboard/tab_content/profile", array( $this, 'render_dashboard_profile' ) );
		add_action( "init", array( $this, 'process_save_user_data' ) ); 
		// 
		add_action( "opaljob/dashboard/tab_content/changepassword", array( $this, 'render_dashboard_changepassword' ) );
		/////// 
		add_action( 'wp_footer', array( $this, 'apply_form_popup') );
		// process login and register 
		add_action( 'init', array( $this, 'process_login' ) );
		add_action( 'init', array( $this, 'process_register' ) );
		add_action( 'init', array( $this, 'load_form_enqueue' ) );

		// call sub controller to process addition functions follow by role
	 	add_action( 'init', array( $this, 'load_role_control') ) ;

	///	add_action( 'wp_footer', array( $this, 'login_register_form_popup') ); 
	///	
	///	is single job //
	///	

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
	public function apply_form_popup () {

		if( is_single_job() ){

			global $job; 

			$member = $job->get_employer();
			$fields = array();  

			$fields = $this->get_model()->get_apply_form_fields( get_the_ID(), $member->ID );


			$form = Form::get_instance();
			$form->set_type( 'custom' );
			$args = [];
			
			$args = array(
				'form' 	 => $form ,
				'fields' => $fields
			);

	        echo View::render_template( 'user/apply-job-popup', $args );
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
	public function load_role_control () {
		if( $this->get_control() ) {
			$this->control->register_hook_callbacks();
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
	public function load_form_enqueue () {

		\Opal_Job\Libraries\Form\Scripts::enqueue_scripts();
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
	public static function process_login() {
 
		$nonce_value = isset( $_POST['_wpnonce'] ) ? $_POST['_wpnonce'] : '';
		$nonce_value = isset( $_POST['opaljob-login-nonce'] ) ? $_POST['opaljob-login-nonce'] : $nonce_value;
		

		/* verify wp nonce */
		if (  ! wp_verify_nonce( $nonce_value, 'opaljob-login' ) ) return;
		
		try {	

			do_action( 'opaljob_user_proccessing_login_before' );

			$credentials    = array();
			$username = isset( $_POST['username'] ) ? sanitize_user( $_POST['username'] ) : '';
			$password = isset( $_POST['password'] ) ? sanitize_text_field( $_POST['password'] ) : '' ;

			/* sanitize, allow hook process like block somebody =)))) */
			$validation = apply_filters( 'opaljob_validation_process_login_error', new WP_Error(), $username, $password );
			if ( $validation->get_error_code() ) {
				throw new Exception( '<strong>' . esc_html__( 'ERROR', 'opaljob' ) . ':</strong> ' . $validation->get_error_message() );
			}
	
			/* validate username */
			if ( ! $username ) {
				throw new Exception( '<strong>' . esc_html__( 'ERROR', 'opaljob' ) . ':</strong> ' . esc_html__( 'Username is required.', 'opaljob' ) );
			} else {

				if ( is_email( $username ) ) {
					/* user object */
					$user = get_user_by( 'email', $username );
					if ( $user->user_login ) {
						$credentials['user_login'] = $user->user_login;
					} else {
						throw new Exception( '<strong>' . esc_html__( 'ERROR', 'opaljob' ) . ':</strong> ' . esc_html__( 'A user could not be found with this email address.', 'opaljob' ) );
					}
				} else {
					$credentials['user_login'] = $username;
				}

			}

			/* validate password if it empty */
			if ( ! $password ) {
				throw new Exception( '<strong>' . esc_html__( 'ERROR', 'opaljob' ) . ':</strong> ' . esc_html__( 'Password is required.', 'opaljob' ) );
			}
			$credentials['user_password'] = $password;
			/* is rembemer me checkbox */
			$credentials['remember'] = isset( $_POST['remember'] );

			/* signon user */
			$user = wp_signon( $credentials, is_ssl() );
			if ( is_wp_error( $user ) ) { 
				throw new Exception( $user->get_error_message() );
			} else {
			
				/* after signon successfully */
				do_action( 'opaljob_after_signon_successfully', $user );
				$redirect =  "";//opaljob_get_dashdoard_page_uri();
				
				if ( ! empty( $_POST['redirect'] ) ) {
					$redirect = $_POST['redirect'];
				} else if ( wp_get_referer() ) {
					$redirect = wp_get_referer();
				}

				$redirect = apply_filters( 'opaljob_signon_redirect_url', $redirect );
				
				/*
				if ( opaljob_is_ajax_request() ) {

					opaljob_add_notice( 'success',  esc_html__( 'Logged successfully, welcome back!', 'opaljob' )  );
				///	ob_start();
					opaljob_print_notices();
					$message = ob_get_clean();


					wp_send_json( array( 
						'status' => true, 
						'message'	=> $message,
						'redirect' => $redirect ) );

				} else {
					wp_safe_redirect( $redirect ); exit();
				} */
			}

			do_action( 'opaljob_user_proccessing_login_after' );

		} catch( Exception $e ) {
			opaljob_add_notice( 'error', $e->getMessage() );
		}

		/*
		if ( opaljob_is_ajax_request() ) {
			ob_start();
		//	opaljob_print_notices();
			$message = ob_get_clean();
			wp_send_json( array(
					'status' 	=> false,
					'message'	=> $message
				) );
		} */
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
	public function process_register() {
		
		if( !isset($_POST['opaljob-register-nonce']) ){
			return ;
		}
		$nonce_value = isset( $_POST['_wpnonce'] ) ? $_POST['_wpnonce'] : '';
		$nonce_value = isset( $_POST['opaljob-register-nonce'] ) ? $_POST['opaljob-register-nonce'] : $nonce_value;

		 
		/* verify wp nonce */
		if ( ! isset( $_POST['confirmed_register'] ) || ! wp_verify_nonce( $nonce_value, 'opaljob-register' ) ) return;
		

		try {

			do_action( 'opaljob_user_proccessing_register_before' );

			$credentials    = array();
			$username 	    = isset( $_POST['username'] ) ? sanitize_user( $_POST['username'] ) : '';
			$email 			= isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
			$password   	= isset( $_POST['password'] ) ? sanitize_text_field( $_POST['password'] ) : '' ;
			$password1  	= isset( $_POST['password1'] ) ? sanitize_text_field( $_POST['password1'] ) : '' ;

			/* sanitize, allow hook process like block somebody =)))) */
			$validation = apply_filters( 'opaljob_validation_process_register_error', new WP_Error(), $username, $email );


			/* sanitize */
			if ( $validation->get_error_code() ) {
				throw new Exception( '<strong>' . esc_html__( 'ERROR', 'opaljob' ) . ':</strong> ' . $validation->get_error_message() );
			}

			/* validate username */
			if ( ! $username ) {
				throw new Exception( '<strong>' . esc_html__( 'ERROR', 'opaljob' ) . ':</strong> ' . esc_html__( 'Username is required.', 'opaljob' ) );
			} else {
				$credentials['user_login'] = $username;
			}

			/* validate email */
			if ( ! $email ) {
				throw new Exception( '<strong>' . esc_html__( 'ERROR', 'opaljob' ) . ':</strong> ' . esc_html__( 'Email is required.', 'opaljob' ) );
			} else {
				$credentials['user_email'] = $email;
			}

			/* validate password */
			if ( ! $password ) {
				throw new Exception( '<strong>' . esc_html__( 'ERROR', 'opaljob' ) . ':</strong> ' . esc_html__( 'Password is required.', 'opaljob' ) );
			}
			if ( $password !== $password1 ) {
				throw new Exception( '<strong>' . esc_html__( 'ERROR', 'opaljob' ) . ':</strong> ' . esc_html__( 'Re-Password is not match.', 'opaljob' ) );
			}
			$credentials['user_pass'] = $password;


			/* create new user */
			$user_id = opaljob_create_user( $credentials );

			if ( is_wp_error( $user_id ) ) {
				throw new Exception( '<strong>' . esc_html__( 'ERROR', 'opaljob' ) . ':</strong> ' . $user_id->get_error_message() );
			} else {

				/* after register successfully */
				do_action( 'opaljob_after_register_successfully', $user_id );

				$redirect = home_url();
				if ( opaljob_get_option( 'login_user' ) ){
					wp_set_auth_cookie( $user_id );
					$redirect = opaljob_get_dashdoard_page_uri();
				} else if ( ! empty( $_POST['redirect'] ) ) {
					$redirect = sanitize_text_field( $_POST['redirect'] );
				} else if ( wp_get_referer() ) {
					$redirect = wp_get_referer();
				}


				do_action( 'opaljob_user_proccessing_register_after' );
				
				$redirect = apply_filters( 'opaljob_register_redirect_url', $redirect );

				/* is ajax request */
				if ( opaljob_is_ajax_request() ) {
					wp_send_json( array( 'status' => true, 'redirect' => $redirect ) );
				} else {
					wp_safe_redirect( $redirect ); exit();
				}
			}

		} catch( Exception $e ) {
			opaljob_add_notice( 'error', $e->getMessage() );
		}

		/* is ajax request */
		if ( opaljob_is_ajax_request() ) {
			ob_start();
			opaljob_print_notices();
			$message = ob_get_clean();
			wp_send_json( array(
					'status' 	=> false,
					'message'	=> $message
				) );
		}
	}

	/**
	 * Process user doForgotPassword with username/password
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return Json Data with messsage and login status
	 */	
	public function process_forgot_password(){
	 
		// First check the nonce, if it fails the function will break
	    check_ajax_referer( 'ajax-pbr-lostpassword-nonce', 'security' );
		
		global $wpdb;
		
		$account = sanitize_text_field( $_POST['user_login'] );
		
		if( empty( $account ) ) {
			$error = esc_html__( 'Enter an username or e-mail address.', 'opaljob' );
		} else {
			if(is_email( $account )) {
				if( email_exists($account) ) 
					$get_by = 'email';
				else	
					$error = esc_html__( 'There is no user registered with that email address.', 'opaljob' );
			}
			else if (validate_username( $account )) {
				if( username_exists($account) ) 
					$get_by = 'login';
				else	
					$error = esc_html__( 'There is no user registered with that username.', 'opaljob' );
			}
			else
				$error = esc_html__(  'Invalid username or e-mail address.', 'opaljob' );
		}	
		
		if(empty ($error)) {
			
			$random_password = wp_generate_password();

			$user = get_user_by( $get_by, $account );
				
			$update_user = wp_update_user( array ( 'ID' => $user->ID, 'user_pass' => $random_password ) );
				
			if( $update_user ) {
				
				$from = get_option('admin_email'); // Set whatever you want like mail@yourdomain.com
				
				if(!(isset($from) && is_email($from))) {		
					$sitename = strtolower( $_SERVER['SERVER_NAME'] );
					if ( substr( $sitename, 0, 4 ) == 'www.' ) {
						$sitename = substr( $sitename, 4 );					
					}
					$from = 'do-not-reply@'.$sitename; 
				}
				
				$to = $user->user_email;
				$subject = esc_html__( 'Your new password', 'opaljob' );
				$sender = 'From: '.get_option('name').' <'.$from.'>' . "\r\n";
				
				$message = esc_html__( 'Your new password is: ', 'opaljob' ) .$random_password;
					
				$headers[] = 'MIME-Version: 1.0' . "\r\n";
				$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers[] = "X-Mailer: PHP \r\n";
				$headers[] = $sender;
					
				$mail = wp_mail( $to, $subject, $message, $headers );
				if( $mail ) 
					$success = esc_html__( 'Check your email address for you new password.', 'opaljob' );
				else
					$error = esc_html__( 'System is unable to send you mail containg your new password.', 'opaljob' );
			} else {
				$error =  esc_html__( 'Oops! Something went wrong while updating your account.', 'opaljob' );
			}
		}
	
		if( ! empty( $error ) )
			echo wp_send_json(array('status'=>false, 'message'=> ($error)));
				
		if( ! empty( $success ) )
			echo wp_send_json(array('status'=>false, 'message'=> $success ));	
		die();
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
	public function save_change_password(){

 		global $current_user;
 		
 		$status = false; 

 		if ( !wp_verify_nonce( $_POST['save_front_user_data'], 'save_changechangepassword' ) ) {

 			$message = esc_html__( 'You are hack this site ?', 'opaljob' ); 

 		} else {
 
	 		do_action( 'opaljob_change_password_form_process_before' );

	        wp_get_current_user();

	        $userID         = $current_user->ID;

	 		$oldpassword	  = sanitize_text_field( $_POST['oldpassword'] );
	 		$new_password 	  = sanitize_text_field( $_POST['new_password'] );
	 		$confirm_password = sanitize_text_field( $_POST['confirm_password'] );


	 		if( empty($oldpassword) ||  empty($new_password) || empty($confirm_password ) ){
	 			$message = esc_html__( 'passwords fields are not empty', 'opaljob' );  
				return opaljob_output_msg_json( $status,
					$message,
					array( 'heading'  => esc_html__('Change Password' ,'opaljob') ) );
	 		}
	 		
	 		if( $new_password != $confirm_password ){
	 			$message = esc_html__( 'New password is not same confirm password', 'opaljob' ); 
	 			return opaljob_output_msg_json( $status,
					$message,
					array( 'heading'  => esc_html__('Change Password' ,'opaljob') ) ); 
	 		}
	 
			$user = get_user_by( 'id', $userID );

	        if( $user && wp_check_password( $oldpassword, $user->data->user_pass, $userID ) ) {
	            wp_set_password( $new_password, $userID );
	            $status = true;
	            $message = esc_html__( 'Password Updated', 'opaljob' );
	        } else {
	            $message = esc_html__( 'Old password is not correct', 'opaljob' );
	        }
	        do_action( 'opaljob_change_password_form_process_after' );
	  	}
        return opaljob_output_msg_json( $status,
				$message,
				array( 'heading'  => esc_html__('Change Password' ,'opaljob') ) );
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
	public function process_save_user_data() {

		if( isset($_POST) && isset($_POST['save_front_user_data']) && isset($_POST['target']) ) {


			$target = sanitize_text_field( $_POST['target'] );
			
			if ( wp_verify_nonce( $_POST['save_front_user_data'], 'save_change'.$target ) ) {
				$user_id = get_current_user_id(); 
				do_action( "opaljob_save_front_user_".$target, $user_id, $_POST );
				do_action( "opaljob_save_front_user_before", $user_id, $_POST );

				
				$metabox = new User_Metabox();
				$metabox->type = $target; 


				$metabox->save_user_options( $user_id );

				do_action( "opaljob_save_front_user_after", $user_id, $_POST );
			}
		}
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
	public function get_model() {
		return opaljob_get_user_model();
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
	public function render_dashboard_profile (){
		
		$metabox = new User_Metabox();
		$type = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : "profile"; 
		$metabox->type = $type;

		echo View::render_template( "dashboard/metabox-form", array( 
																	'metabox' => $metabox , 
																	'action' => 'save_change'.$type, 
																	'type' => $type ) );
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
	public function render_dashboard_changepassword () {
		$metabox = new User_Metabox();
		
		$type = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : "changepassword"; 
		$metabox->type = $type;
		
		$args = array( 
			'metabox' 	=> $metabox,
			'action'	=> 'save_change'.$type,
			'type'		=> $type,
			'form_id'	=> 'opaljob-changepassword-form' 
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
	public function get_html_search_candidates () {
		echo do_shortcode(  "[opaljob_search_map_candidates]" );die;
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
	public function get_candidates_map () {

		$query = new User_Query(); 

		$atts  = is_array( $atts ) ? $atts  : array();
		$atts = array_merge( $default, $atts ); 


		$members = $query->get_list_data_candidates(); 
		$atts['members'] = $members; 
		$atts['count']	 = 10;

		echo json_encode( $members ); exit;
	}
}