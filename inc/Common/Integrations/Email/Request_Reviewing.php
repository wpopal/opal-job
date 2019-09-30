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
 * @class   Request_Reviewing
 *
 * @version 1.0
 */
class Request_Reviewing extends Abs_Email_Template {
 
	/**
	 * Send Email
	 */
	public function get_subject () {
		$propety_title = '' ;
		return sprintf( esc_html__( 'You have a message request reviewing: %s at', 'opaljob' ),  $propety_title );
	}

	/**
	 * Send Email
	 */
	public function get_content_template() {
 		return opaljob_load_template_path( 'emails/request-reviewing' );
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
		$this->args['job_link'] = get_permalink( $post->ID ); 
		$this->args['job_name'] = $post->post_title; 
 

		return parent::get_body();
	}
}
?>