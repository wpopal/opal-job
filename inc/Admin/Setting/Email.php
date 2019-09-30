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
namespace Opal_Job\Admin\Setting;
 
use Opal_Job\Core as Core;
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author    WpOpal
 */
class Email extends Core\Metabox {

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function get_tab() {
		return array( 'id' => 'email', 'heading' => esc_html__('Email') );
	}

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function get_settings() {
		$contact_list_tags = '<div>
				<p class="tags-description">Use the following tags to automatically add property information to the emails. Tags labeled with an asterisk (*) can be used in the email subject as well.</p>
				
				<div class="opaljob-template-tags-box">
					<strong>{receive_name}</strong> Name of the agent who made the property
				</div>

				<div class="opaljob-template-tags-box">
					<strong>{property_link}</strong> Property of the user who made the property
				</div>
	
				<div class="opaljob-template-tags-box">
					<strong>{name}</strong> Name of the user who contact via email form
				</div>

				<div class="opaljob-template-tags-box">
					<strong>{email}</strong> Email of the user who contact via email form
				</div>

				<div class="opaljob-template-tags-box">
					<strong>{property_link}</strong> * Link of the property
				</div>
			
				<div class="opaljob-template-tags-box">
					<strong>{message}</strong> * Message content of who sent via form
				</div>

				</div> ';

		$list_tags = '<div>
				<p class="tags-description">Use the following tags to automatically add property information to the emails. Tags labeled with an asterisk (*) can be used in the email subject as well.</p>
				
				<div class="opaljob-template-tags-box">
					<strong>{property_name}</strong> Email of the user who made the property
				</div>

				<div class="opaljob-template-tags-box">
					<strong>{property_link}</strong> Email of the user who made the property
				</div>
	
				<div class="opaljob-template-tags-box">
					<strong>{user_email}</strong> Email of the user who made the property
				</div>

				<div class="opaljob-template-tags-box">
					<strong>{submitted_date}</strong> Email of the user who made the property
				</div>

				<div class="opaljob-template-tags-box">
					<strong>{user_name}</strong> * Name of the user who made the property
				</div>
			
				<div class="opaljob-template-tags-box">
					<strong>{date}</strong> * Date and time of the property
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
				

		$fields = 
			apply_filters( 'opaljob_settings_emails', array(
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
						'id'      			=> 'newproperty_email_subject',
						'name'    			=> esc_html__( 'Email Subject', 'opaljob' ),
						'type'    			=> 'text',
						'desc'				=> esc_html__( 'The email subject for admin notifications.', 'opaljob' ),
						'attributes'  		=> array(
	        										'placeholder' 		=> 'Your package is expired',
	        										'rows'       	 	=> 3,
	    										),
						'default'			=>  esc_html__( 'New Property Listing Submitted: {property_name}', 'opaljob' )

					),
					array(
						'id'      => 'newproperty_email_body',
						'name'    => esc_html__( 'Email Body', 'opaljob' ),
						'type'    => 'wysiwyg',
						'desc'	=> esc_html__( 'Enter the email an admin should receive when an initial payment request is made.', 'opaljob' ),
						'default' => ""
					),	
					//------------------------------------------
					array(
						'name' => esc_html__( 'Approve property for publish', 'opaljob' ),
						'desc' => '<hr>',
						'id'   => 'opaljob_title_email_settings_4',
						'type' => 'title'
					),

                    array(
                        'name'    		=> esc_html__( 'Enable approve property email', 'opaljob' ),
                        'desc'			=> esc_html__( 'Enable approve property email.', 'opaljob' ),
                        'id'      => 'enable_approve_property_email',
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
						'desc'			=> esc_html__( 'The email subject a user should receive when they make an initial property request.', 'opaljob' ),
						'attributes'  	=> array(
	        									'placeholder' 		=> 'Your property at I Love WordPress is pending',get_bloginfo( 'name' ),
	        									'rows'       	 	=> 3,
	    									),
						'default'	=> esc_html__( 'New Property Listing Submitted: {property_name}', 'opaljob' )
					),

					array(
						'id'      	=> 'approve_email_body',
						'name'    	=> esc_html__( 'Email Body', 'opaljob' ),
						'type'    	=> 'wysiwyg',
						'desc'		=> esc_html__( 'Enter the email a user should receive when they make an initial payment request.', 'opaljob' ),
						'default' 	=> ""
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
						'desc'			=> esc_html__( 'The email subject a user should receive when they make an initial property request.', 'opaljob' ),
						'attributes'  	=> array(
	        									'placeholder' 		=> 'Your property at I Love WordPress is pending',get_bloginfo( 'name' ),
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
			);
		return $fields;
	}

}