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
 * @class   Notification
 *
 * @version 1.0
 */
class Notification extends Abs_Email_Template {

	public $type = '';
 
	/**
	 * Send Email
	 */
	public function get_subject () {
		switch ( $this->type ) {
			case 'enquiry':
				$subject = html_entity_decode( esc_html__('You got a message enquiry', 'opaljob')  );
				break;
			
			default:
				$subject = html_entity_decode( esc_html__('You got a message contact', 'opaljob')  );
				break;
		}

		return $subject; 
	}

	/**
	 * Send Email
	 */
	public function get_content_template() {

		switch ( $this->type ) {
			case 'enquiry':
				return opaljob_load_template_path( 'emails/enquiry' );
				break;
			
			default:
				return opaljob_load_template_path( 'emails/contact' );
				break;
		}
	}	

	public function to_email () {
		return $this->args ['receiver_email'];
	}

	public function cc_email () {
		return $this->args ['sender_email'];
	}

	public function get_body() {
		$this->args['email'] = $this->args['receiver_email'];
		return parent::get_body();
	}
}
?>