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
use Opal_Job\Common\Model\Message; 
use Opal_Job\Libraries\Form\Form; 
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
class Email  extends Controller {

	/**
	 * Store ID of User
	 *
	 * @var Integer $user_id
	 */
	protected $user_id = 0; 

	/**
	 * Store Status:on|off allow store message in table
	 *
	 * @var Boolean $is_log
	 */
	protected $is_log; 
	
	/**
	 * Store Instance of Model/User
	 *
	 * @var User $model
	 */
	protected $model;

	/**
	 * Register Hook Callback function using for Front-End
	 *
	 * Show content of message page, show enquiry, contact form.
	 *
	 * @since 1.0
	 *
	 * @return Avoid
	 */
	public function register_hook_callbacks(){

		// process ajax 
		add_filter( 'opaljob_user_content_messages_page', 		 array( $this, 'render_user_content_page' ) );

		add_filter( 'opaljob_email_enquiry_form', 				 array( $this, 'get_equiry_form_fields') );
		add_filter( 'opaljob_email_contact_form', 				 array( $this, 'get_contact_form_fields') );
		
	}

	/**
	 * Register Hook Callback functions is called if have Ajax
	 *
	 * Ajax process reply email, send email.
	 *
	 * @since 1.0
	 *
	 * @return Avoid
	 */
	public function register_ajax_hook_callbacks () {
		add_action( 'wp_ajax_send_email_contact_reply', 	     array( $this, 'process_send_reply_email' ) );
		add_action( 'wp_ajax_nopriv_send_email_contact_reply',	 array( $this, 'process_send_reply_email') );
		/// process ajax send message 
		add_action( 'wp_ajax_opaljob_send_email_contact', 			 	 array( $this, 'process_send_email' ) );
		add_action( 'wp_ajax_nopriv_opaljob_send_email_contact',	 	 array( $this, 'process_send_email') );
	}

	/**
	 * Set values when user logined in system
	 *
	 *
	 * @since 1.0
	 *
	 * @return Avoid
	 */
	public function init(){

		global $current_user;
		wp_get_current_user();

        $this->user_id =  $current_user->ID;
        $this->is_log  = opaljob_get_option( 'message_log' );
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
			$this->model = new Message();
		}
		return $this->model; 
	}

    /**
	 * Render Sidebar
	 *
	 * Set values when user logined in system
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
    public function send_equiry( $post, $member ) {

    	$default = array(
    		'send_equiry_name'    => '',
    		'action'			  => '',
    		'post_id'	      => '',
    		'sender_id'		 	  => '',
    		'email'	  			  => '',
    		'phone'	  			  => '',
    		'message' 			  => '',
    		'message_action'	  => '',
    	);
    	$post = array_merge( $default, $post );

   	
		$post['property_link'] 	  = (int)$post['post_id'] ? get_permalink( $post['post_id'] ) :  get_home_url();
		$post['receive_name']     = $member['name'];
		$subject = html_entity_decode( esc_html__('You got a message', 'opaljob')  );
		$post['receiver_name']	= $member['receiver_name']; 

		$output = array(
			'subject'		    => $subject,
			'name'				=> $member['name'],
			'receiver_email'	=> $member['receiver_email'],
			'receiver_id'		=> $member['receiver_id'],
			'sender_id'			=> get_current_user_id(),
			'sender_email'		=> $post['email'],
			'phone'				=> $post['phone'],
			'message'			=> $post['message'],
			'post_id'   		=> $post['post_id'],
			'type'				=> 'send_enquiry'
		);

		if( $output['sender_id'] == $output['receiver_id'] ){
			// return false;
		}

		return $output;
    }

    /**
	 * Render Sidebar
	 *
	 * Set values when user logined in system
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
    public function send_contact( $post ) {
     	
     
		
 	  	$receiver_id 	= intval( $post['receiver_id'] );
     	$receiver 		= opaljob_new_user_object( $receiver_id );
     	$receiver_email = $receiver->get_email();
     
     	$member = array(
			'receiver_email' 	=> $receiver_email,
			'receiver_name'		=> $receiver->get_name(),
			'receiver_id' 		=> $receiver_id,			
		);

    	$default = array(
    		'send_equiry_name'    => '',
    		'action'			  => '',
    		'post_id'	      => '',
    		'sender_id'		 	  => '',
    		'email'	  			  => '',
    		'phone'	  			  => '',
    		'message' 			  => '',
    		'message_action'	  => '',
    	);
    	$post = array_merge( $default, $post );

		$post['link'] 	  		  =  $receiver->get_link();
		$subject 				  = html_entity_decode( esc_html__('You got a message contact', 'opaljob')  );
		$post['receiver_name']	  = $member['receiver_name']; 


		 
		$output = array(
			'subject'			=> $subject,
			'name'				=> $member['name'],
			'receiver_email'	=> $member['receiver_email'],
			'receiver_id'		=> $member['receiver_id'],
			'sender_id'			=> get_current_user_id(),
			'sender_email'		=> $post['email'],
			'phone'				=> $post['phone'],
			'message'			=> $post['message'],
			'receiver_id'   	=> $post['receiver_id'],
			'type'				=> 'send_contact'
		);

		if( $output['sender_id'] == $output['receiver_id'] ){
			// return false;
		}

		return $output;

    }

    /**
	 * Set values when user logined in system
	 */
    public function get_member_email_data( $post_id ){

    	// return opaljob_get_member_email_data( $post_id );
    }

    /**
	 * Set values when user logined in system
	 */
    public function process_send_reply_email() {
    	
    	if(  isset($_POST)  &&  $this->is_log ){
    		$id = 2;
    		$message = $this->get_message( intval($_POST['message_id']) );

 
    		if( $message ) {

	    		$data = array(
	    			'message_id' 	 => $message->id,
	    			'sender_id'  	 => $this->user_id,
	    			'receiver_id'	 => $message->sender_id,
    				'message'		 => $_POST['message'],
	  	  			'created'		 => current_time('mysql', 1)
	    		);

	    		$id = $this->insert_reply( $data );
	    		
	    		$reply = $this->get_reply( $id );
	
	    		$data['data'] = array(
	    			'created' => $reply->created,
	    			'message'	=> $reply->message,
	    			'avatar'	=> OpalEstate_User::get_author_picture( $message->sender_id )
	    		);
	    		// send email for user to inbox email.
				do_action( 'opaljob_send_email_notifycation', $data );
				$return = array( 
					'status'  => true, 
					'msg' 	  => esc_html__( 'Email Sent successful', 'opaljob' ) , 
					'heading' => esc_html__( 'Sending Message', 'opaljob') 
				);
    		}
    	} else {
    		$return = array( 'status' => false, 'msg' => esc_html__( 'Unable to send a message.', 'opaljob' ), 'heading' => esc_html__( 'Sending Message', 'opaljob') );
    	}

    	
		echo json_encode($return); die();

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
	public function process_send_email() {
 

		do_action( 'opaljob_process_send_email_before' );

		$status = false;
		$content = array(); 

		if( wp_verify_nonce( $_POST['message_action'], 'send-contact-form' ) ) {  
			$content = $this->send_contact( $_POST );
		}
		
		if( $content ) {
			// only save in db for user only
			if( $content['receiver_id'] > 0 &&  $this->is_log  ){
				$this->insert( $content );
			}
	
			// send email for user to inbox email.
			do_action( 'opaljob_send_email_notifycation', $content );
		}	
	 
		$return = array( 'status' => $status, 'msg' => esc_html__( 'Unable to send a message.', 'opaljob' ) );

		echo json_encode($return); die();
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
	public function is_saved(){

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
	public function get_equiry_form_fields( $msg='' ) {  

		$fields = array();

		$fields = $this->get_model()->get_equiry_form_fields();

		$form = Form::get_instance();
		$form->set_type( 'custom' );
		$args = [];

	 
		return $form->render( $args, $fields );
		 
 
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
	public function get_reply_form_fields () {
		 
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
	public function get_contact_form_fields( $msg= '' ) {
 	
 		$fields = array();  

 		 
		$fields = $this->get_model()->get_contact_form_fields();

		$form = Form::get_instance();
		$form->set_type( 'custom' );
		$args = [];

	 
		return $form->render( $args, $fields );
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
	public function get_request_review_form_fields( $msg= '' ) {

		$prefix 	  = '';
		$id 		  = '';
		$sender_id 	  = '';
		$post_id  = get_the_ID();
		$email 		  = '';
		$current_user = wp_get_current_user();
		$name = '';
		
		if ( 0 != $current_user->ID ) { 
			$email = $current_user->user_email;
			$name = $current_user->user_firstname .' ' . $current_user->user_lastname; 
			$sender_id 	  = $current_user->ID;
		}	

		$fields =  array(
			array(
				'id'   		   => "type",
				'name' 		   => esc_html__( 'Type', 'opaljob' ),
				'type' 		   => 'hidden',		
				'default'	   => 'send_request_review',		 
				'description'  => "",
			),
			array(
				'id'   		   => "post_id",
				'name' 		   => esc_html__( 'Property ID', 'opaljob' ),
				'type' 		   => 'hidden',		
				'default'	   => $post_id,		 
				'description'  => "",
			),
			array(
				'id'   		   => "sender_id",
				'name' 		   => esc_html__( 'Sender ID', 'opaljob' ),
				'type' 		   => 'hidden',		
				'default'	   => $sender_id,		 
				'description'  => "",
			),
			array(
				'id'   => "{$prefix}date",
				'name' => esc_html__( 'Schedule', 'opaljob' ),
				'type' => 'date',
				'before_row' =>  '',
				'required' => 'required',
				'description'  => "",
			),
			array(
				'id'   => "{$prefix}time",
				'name' => esc_html__( 'Time', 'opaljob' ),
				'type' => 'select',
				'options'	=> opaljob_get_time_lapses(),
				'description'  => "",
				'required' => 'required',
			),
			array(
				'id'  		   => "{$prefix}phone",
				'name' 		   => esc_html__( 'Phone', 'opaljob' ),
				'type' 		   => 'text',
				'description'  => "",
				'required' 	   => 'required',
			),

			array(
				'id'   => "{$prefix}message",
				'name' => esc_html__( 'Message', 'opaljob' ),
				'type' => 'textarea',
				'description'  => "",
				'default'		=> $msg,
				'required' => 'required',
			),

		);

		return $fields;
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
	public function render_user_content_page () {

		if( isset($_GET['message_id']) ){
			
			$message = $this->get_message( (int)$_GET['message_id'] ); 
			return opaljob_load_template_path( 'user/read-messages' ,
					 array( 
					 		'message' => $message, 
					 	    'fields'  => $this->get_reply_form_fields() ,
					 	    'replies' => $this->get_replies( (int)$_GET['message_id'] ) 
					)		 
			);

		} else {
			return opaljob_load_template_path( 'user/messages' );	
		}
	}
}