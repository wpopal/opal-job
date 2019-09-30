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
 * @class   New_Submitted
 *
 * @version 1.0
 */
class  New_Submitted extends Abs_Email_Template {
 
	/**
	 * Send Email
	 */
	public function get_subject () {
		$propety_title = '' ;
		return sprintf( esc_html__( 'New Property Listing Submitted: %s', 'opaljob' ),  $propety_title );
	}

	/**
	 * Send Email
	 */
	public function get_content_template() {
 		return opaljob_load_template_path( 'emails/request-reviewing' );
	}	

	public static function get_default_template() {
		
		return trim(preg_replace('/\t+/', '','
						Hi {user_name},
						<br>
						Thanks you so much for submitting {job_name}  at  {site_name}:<br>
						 Give us a few moments to make sure that we are got space for you. You will receive another email from us soon.
						 If this request was made outside of our normal working hours, we may not be able to confirm it until we are open again.
						<br>
							You may review your job at any time by logging in to your client area.
						<br>
						<em>This message was sent by {site_link} on {current_time}.</em>'
		) );
	}

	/**
	 * Send Email
	 */
	public function to_email () {
		return $this->args ['receiver_email'];
	}

	/**
	 * Send Email
	 */
	public function cc_email () {
		return $this->args ['sender_email'];
	}

	/**
	 * Send Email
	 */
	public function get_body() {
		
		$post = get_post( $this->args['post_id'] ); 
		
		$this->args['email'] = $this->args['receiver_email'];
		$this->args['job_link'] = $post->post_title; 

		return parent::get_body();
	}
}
?>