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
 namespace Opal_Job\Integrations\Email;
 use Opal_Job\Integrations\Email\Abs_Email_Template;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @class   Approve
 *
 * @version 1.0
 */
class  Approve extends Abs_Email_Template {
 
	/**
	 *  
	 */
	public function get_subject () {
		$propety_title = '' ;
		return sprintf( esc_html__( 'New Property Listing Submitted: %s', 'opaljob' ),  $propety_title );
	}

	/**
	 *  
	 */
	public function get_content_template() {
 		return opaljob_load_template_path( 'emails/request-reviewing' );
	}	

	/**
	 *
	 */
	public static function get_default_template() {
		
		return trim(preg_replace('/\t+/', '', "Hi {user_name},<br>
				<br>
				Thank you so much for submitting to {site_name}.
				<br>
				 We have completed the auditing process for your job '{job_name}'  and are pleased to inform you that your submission has been accepted.
				 <br>
				<br>
				Thanks again for your contribution
				<br>
				&nbsp;<br>
				<br>
				<em>This message was sent by {site_link} on {current_time}.</em>"
		));
	}

	/**
	 *  
	 */
	public function to_email () {
		return $this->args ['receiver_email'];
	}

	/**
	 *  
	 */
	public function cc_email () {
		return $this->args ['sender_email'];
	}

	/**
	 *  
	 */
	public function get_body() {
		
		$post = get_post( $this->args['post_id'] ); 
		
		$this->args['email'] = $this->args['receiver_email'];
		$this->args['job_link'] = $post->post_title; 

		return parent::get_body();
	}
}
?>