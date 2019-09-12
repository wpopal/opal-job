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
namespace Opal_Job\Common\Integrations;
use Opal_Job\Common\interfaces\Intergration; 
/**
 * Fired during plugin deactivation
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author     WpOpal
 *
 */

class Email implements Intergration {

	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */	
	public function register_admin_actions() {  
	 	add_filter( 'opaljob_settings_tabs', array( __CLASS__, 'setting_email_tab'), 1 );
  		add_filter( 'opaljob_registered_emails_settings', array( __CLASS__, 'setting_email_fields'), 10, 1   );
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
	public function register_frontend_actions() {
 		add_action(  'opaljob_processed_new_submission' , array( __CLASS__ , 'new_submission_email'), 10, 2 );
	  	//add_action(  'opaljob_processed_edit_submission' , array( __CLASS__ , 'new_submission_email'), 10, 2 );
	  	 
        $enable_approve_job_email = opaljob_options( 'enable_approve_job_email' );

	  	if ( $enable_approve_job_email == 'on' ) {
            add_action(  'transition_post_status', array( __CLASS__, 'send_email_when_publish_job') , 10, 3 );
            add_action(  'opaljob_processed_approve_publish_job', array( __CLASS__, 'approve_publish_job_email') , 10, 1 );
        }

        /**
         * Send email when User contact via Enquiry Form and Contact Form
         */
      	add_action( 'opaljob_send_email_notifycation', array(__CLASS__,'send_notifycation')  );  
      	add_action( 'opaljob_send_email_submitted',    array(__CLASS__,'new_submission_email')  );  	

      	add_action( 'opaljob_send_email_request_reviewing', array( __CLASS__, 'send_email_request_reviewing') );
	}

	/**
	 * Render Sidebar
	 *
	 *	init action to automatic send email when user edit or submit a new submission and init setting form in plugin setting of admin
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public static function init() {

	  	
	}

 
	/**
	 * Send Email Notifycation with two types: Enquiry or Contact
	 */
	public static function send_notifycation ( $content ) {
 
		$mail = new OpalEstate_Send_Email_Notification() ;
		$mail->set_args ( $content );
		
		$return =  self::send_mail_now( $mail );

		if( isset($content['data']) ){
			$return['data'] = $content['data'];
		}
		echo json_encode( $return ); die();
	}

	/**
	 * Send email to requet viewing a job
	 */
	public static function send_email_request_reviewing( $content ){

		$mail = new OpalEstate_Send_Email_Request_Reviewing();
		$mail->set_args( $content );

		$return =  self::send_mail_now( $mail );


		echo json_encode( $return ); die();
		
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
	public static function send_mail_now( $mail ) {

 		$from_name 	= $mail->from_name();
		$from_email = $mail->from_email(); 
		$headers 	= sprintf( "From: %s <%s>\r\n Content-type: text/html", $from_name, $from_email );

		$subject 	= $mail->get_subject(); 
		$message    = $mail->get_body(); 

		if(  $mail->to_email() ) {

			if( $mail->get_cc() ){
				$status = @wp_mail( $mail->get_cc(), $subject, $message, $headers );
		 	}

		 	$status =  @wp_mail( $mail->to_email(), $subject, $message, $headers );
			$return = array( 'status' => true, 'msg' => esc_html__( 'Message has been successfully sent.', 'opaljob' ) );

		} else {
			$return = array( 'status' => true, 'msg' => esc_html__( 'Message has been successfully sent.', 'opaljob' ) );
		}

		return $return;
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
    public static function send_email_when_publish_job( $new_status, $old_status, $post ) {

	    if( is_object( $post ) ){
            if ( $post->post_type == 'opaljob_job' ) {
                if ( $new_status != $old_status ) {
                    if ($new_status == 'publish' ) {
                        if ($old_status == 'draft' || $old_status == 'pending') {
                            // Send email
                            $post_id = $post->ID;
                            do_action( "opaljob_processed_approve_publish_job", $post_id  );
                        }
                    }
                }
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
	public static function setting_email_tab( $tabs ) {

		$tabs['emails'] = esc_html__( 'Email', 'opaljob' );
		return $tabs;
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
	public static function newjob_email_body() {
	 
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
 	public static function approve_email_body() {
 
 	}		

	/**
	 * render setting email fields with default values
	 */
	public static function setting_email_fields( $fields ) { 

		$contact_list_tags = '<div>
				<p class="tags-description">Use the following tags to automatically add job information to the emails. Tags labeled with an asterisk (*) can be used in the email subject as well.</p>
				
				<div class="opaljob-template-tags-box">
					<strong>{receive_name}</strong> Name of the agent who made the job
				</div>

				<div class="opaljob-template-tags-box">
					<strong>{job_link}</strong> Property of the user who made the job
				</div>
	
				<div class="opaljob-template-tags-box">
					<strong>{name}</strong> Name of the user who contact via email form
				</div>

				<div class="opaljob-template-tags-box">
					<strong>{email}</strong> Email of the user who contact via email form
				</div>

				<div class="opaljob-template-tags-box">
					<strong>{job_link}</strong> * Link of the job
				</div>
			
				<div class="opaljob-template-tags-box">
					<strong>{message}</strong> * Message content of who sent via form
				</div>

				</div> ';

		$list_tags = '<div>
				<p class="tags-description">Use the following tags to automatically add job information to the emails. Tags labeled with an asterisk (*) can be used in the email subject as well.</p>
				
				<div class="opaljob-template-tags-box">
					<strong>{job_name}</strong> Email of the user who made the job
				</div>

				<div class="opaljob-template-tags-box">
					<strong>{job_link}</strong> Email of the user who made the job
				</div>
	
				<div class="opaljob-template-tags-box">
					<strong>{user_email}</strong> Email of the user who made the job
				</div>

				<div class="opaljob-template-tags-box">
					<strong>{submitted_date}</strong> Email of the user who made the job
				</div>

				<div class="opaljob-template-tags-box">
					<strong>{user_name}</strong> * Name of the user who made the job
				</div>
			
				<div class="opaljob-template-tags-box">
					<strong>{date}</strong> * Date and time of the job
				</div>

				<div class="opaljob-template-tags-box">
					<strong>{site_name}</strong> The name of this website
				</div>
				<div class="opaljob-template-tags-box">
					<strong>{site_link}</strong> A link to this website
				</div>
				<div class="opaljob-template-tags-box">
					<strong>{current_time}</strong> Current date and time
				</div></div>';

		$list_tags = apply_filters( 'opaljob_email_tags', $list_tags );
				

		$fields = array(
			'id'         => 'options_page',
			'title' => esc_html__( 'Email Settings', 'opaljob' ),
			'show_on'    => array( 'key' => 'options-page', 'value' => array( 'opaljob_settings' ), ),
			'fields'     => apply_filters( 'opaljob_settings_emails', array(
					array(
						'name' => esc_html__( 'Email Settings', 'opaljob' ),
						'desc' => '<hr>',
						'id'   => 'opaljob_title_email_settings_1',
						'type' => 'title'
					),
					array(
						'id'      => 'from_name',
						'name'    => esc_html__( 'From Name', 'opaljob' ),
						'desc'    => esc_html__( 'The name donation receipts are said to come from. This should probably be your site or shop name.', 'opaljob' ),
						'default' => get_bloginfo( 'name' ),
						'type'    => 'text'
					),
					array(
						'id'      => 'from_email',
						'name'    => esc_html__( 'From Email', 'opaljob' ),
						'desc'    => esc_html__( 'Email to send donation receipts from. This will act as the "from" and "reply-to" address.', 'opaljob' ),
						'default' => get_bloginfo( 'admin_email' ),
						'type'    => 'text'
					),

				

			 		array(
						'name' => esc_html__( 'Email Submission Templates (Template Tags)', 'opaljob' ),
						'desc' => $list_tags.'<br><hr>',
						'id'   => 'opaljob_title_email_settings_2',
						'type' => 'title'
					),

				

					array(
						'name' => esc_html__( 'Notification For New Property Submission', 'opaljob' ),
						'desc' => '<hr>',
						'id'   => 'opaljob_title_email_settings_3',
						'type' => 'title'
					),
				

					array(
						'id'      			=> 'newjob_email_subject',
						'name'    			=> esc_html__( 'Email Subject', 'opaljob' ),
						'type'    			=> 'text',
						'desc'				=> esc_html__( 'The email subject for admin notifications.', 'opaljob' ),
						'attributes'  		=> array(
	        										'placeholder' 		=> 'Your package is expired',
	        										'rows'       	 	=> 3,
	    										),
						'default'			=> esc_html__( 'New job submitted - {job_name}', 'opaljob' )	

					),
					array(
						'id'      => 'newjob_email_body',
						'name'    => esc_html__( 'Email Body', 'opaljob' ),
						'type'    => 'wysiwyg',
						'desc'	=> esc_html__( 'Enter the email an admin should receive when an initial payment request is made.', 'opaljob' ),
						'default' => self::newjob_email_body(),
					),	
					//------------------------------------------
					array(
						'name' => esc_html__( 'Approve job for publish', 'opaljob' ),
						'desc' => '<hr>',
						'id'   => 'opaljob_title_email_settings_4',
						'type' => 'title'
					),

                    array(
                        'name'    		=> esc_html__( 'Enable approve job email', 'opaljob' ),
                        'desc'			=> esc_html__( 'Enable approve job email.', 'opaljob' ),
                        'id'      => 'enable_approve_job_email',
                        'type'    => 'switch',
                        'options' => array(
                            'on' 	=> esc_html__( 'Enable', 'opaljob' ),
                            'off'   => esc_html__( 'Disable', 'opaljob' ),
                        ),
                        'default' => 'off',
                    ),

					array(
						'id'      		=> 'approve_email_subject',
						'name'    		=> esc_html__( 'Email Subject', 'opaljob' ),
						'type'    		=> 'text',
						'desc'			=> esc_html__( 'The email subject a user should receive when they make an initial job request.', 'opaljob' ),
						'attributes'  	=> array(
	        									'placeholder' 		=> 'Your job at I Love WordPress is pending',get_bloginfo( 'name' ),
	        									'rows'       	 	=> 3,
	    									),
						'default'	=> esc_html__('Approve For Publish - {job_name}','opaljob')
					),

					array(
						'id'      	=> 'approve_email_body',
						'name'    	=> esc_html__( 'Email Body', 'opaljob' ),
						'type'    	=> 'wysiwyg',
						'desc'		=> esc_html__( 'Enter the email a user should receive when they make an initial payment request.', 'opaljob' ),
						'default' 	=> self::approve_email_body(),
					),	

					/// email contact template ////
					array(
						'name' => esc_html__( 'Email Contact Templates (Template Tags)', 'opaljob' ),
						'desc' => $contact_list_tags.'<br><hr>',
						'id'   => 'opaljob_title_email_settings_6',
						'type' => 'title'
					),

					array(
						'id'      		=> 'contact_email_subject',
						'name'    		=> esc_html__( 'Email Subject', 'opaljob' ),
						'type'    		=> 'text',
						'desc'			=> esc_html__( 'The email subject a user should receive when they make an initial job request.', 'opaljob' ),
						'attributes'  	=> array(
	        									'placeholder' 		=> 'Your job at I Love WordPress is pending',get_bloginfo( 'name' ),
	        									'rows'       	 	=> 3,
	    									),
						'default'	=> esc_html__('You got a message', 'opaljob') 
					),

					array(
						'id'      	=> 'contact_email_body',
						'name'    	=> esc_html__( 'Email Body', 'opaljob' ),
						'type'    	=> 'wysiwyg',
						'desc'		=>  trim(preg_replace('/\t+/', '', "Hi {receive_name},<br>
							You have got message from {name} with email {email}. Here is detail:
						 <br>
						<br>
						{message}
						<br>
						&nbsp;<br>
						<br>
						<em>This message was sent by {site_link} on {current_time}.</em>"))
					)
				)
			)
		);

		return $fields;
	}

	/**
	 * get data of newrequest email
	 *
	 * @var $args  array: job_id , $body 
	 * @return text: message
	 */
	public static function replace_shortcode( $args, $body ) {

		$tags =  array(
			'user_name' 	=> "",
			'user_mail' 	=> "",
			'submitted_date' => "",
			'job_name' => "",
			'site_name' => '',
			'site_link'	=> '',
			'job_link' => '',
		);
		$tags = array_merge( $tags, $args );

		extract( $tags );

		$tags 	 = array( "{user_mail}",
						  "{user_name}",
						  "{submitted_date}",
						  "{site_name}",
						  "{site_link}",
						  "{current_time}",
						  '{job_name}',
						  '{job_link}');

		$values  = array(   $user_mail, 
							$user_name ,
							$submitted_date ,
							get_bloginfo( 'name' ) ,
							get_home_url(), 
							date("F j, Y, g:i a"),
							$job_name,
							$job_link
		);

		$message = str_replace($tags, $values, $body);

		return $message;
	}

	/**
	 * general function to send email to agent with specify subject, body content
	 */
	public static function send( $emailto, $subject, $body ){

		$from_name 	= opaljob_options('from_name');
		$from_email = opaljob_options('from_email');
		$headers 	= sprintf( "From: %s <%s>\r\n Content-type: text/html", $from_name, $from_email );

		if( empty($emailto) || empty( $subject) || empty($body) ){
			return ;
		}

		wp_mail( @$emailto, @$subject, @$body, $headers );

	}

	/**
	 * get collection of key and value base on tags which using to replace custom tags
	 */
	public static function get_email_args_by_job(  $job_id ){
	 	
	 	$job 	   = get_post( $job_id );
		$user    	   = get_userdata( $job->post_author ); 
		$email 		   = get_user_meta( $job->post_author, OPALESTATE_USER_PROFILE_PREFIX . 'email', true ); 
 		$email  	   = $email ? $email : $user->data->user_email;

		$args = array(
			'user_mail' 		 => $email,
			'user_name'			 => $user->display_name,
			'submitted_date'	 => $job->post_date,
			'job_name'	 	 => $job->post_title,
			'job_link'		 => get_permalink( $job_id )
		); 

		return $args ;
	}

	/**
	 * send email if agent submit a new job
	 */
	public static function new_submission_email( $user_id,  $post_id ){

		 
		$args = self::get_email_args_by_job( $post_id );

		$subject = opaljob_options( 'newjob_email_subject' );
		$body 	 = opaljob_options( 'newjob_email_body', self::newjob_email_body() );

		// repleace all custom tags
		$subject = self::replace_shortcode( $args, $subject );
		$body 	 = self::replace_shortcode( $args, $body );
 
		self::send( $args['user_mail'], $subject, $body );
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
	public static function approve_publish_job_email( $post_id ) {

        $args = self::get_email_args_by_job( $post_id );

        $subject = opaljob_options( 'approve_email_subject' );
        $body 	 = opaljob_options( 'approve_email_body', self::approve_email_body() );

        // repleace all custom tags
        $subject = self::replace_shortcode( $args, $subject );
        $body 	 = self::replace_shortcode( $args, $body );

        self::send( $args['user_mail'], $subject, $body );

    }
}