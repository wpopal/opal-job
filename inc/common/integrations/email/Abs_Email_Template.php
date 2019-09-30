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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @class   Abs_Email_Template
 *
 * @version 1.0
 */
abstract class Abs_Email_Template {
 	
 	public $args = array();

	/**
	 * Get the unique email notification key.
	 *
	 * @return string
	 */
	public function get_key() {
		return 'opaljob-notification';
	}

 	/**
	 * Get the friendly name for this email notification.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Admin Notice of Expiring Job Listings', 'opaljob' );
	}

	/**
	 * Get the description for this email notification.
	 *
	 * @type abstract
	 * @return string
	 */
	public function get_description() {
		return esc_html__( 'Send notices to the site administrator before a job listing expires.', 'opaljob' );
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
	public function to_email () {
		
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
	public function get_content_template() {

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
	public function set_args ( $args ) {
		return $this->args = $args;
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
	public function replace_tags ( $body ) {
    	
    	$args = $this->args; 

    	$template = $this->get_content_template(); 

    	$default  = array(
    		'receiver_name'	=> '',
    		'name'			=> '',
    		'receiver_email'			=> '',
    		'job_link' => '',
    		'message'		=> '',
    		'site_link'		=> get_home_url(),
    		'current_time'	=> date("F j, Y, g:i a"),
    		'phone'			=> '' 
    	);

    	$args   = array_merge( $default, $args );

		$tags 	= array();
		$values = array() ;	

		foreach ( $args as $key => $value ) {
			$tags[] = "{".$key."}";
			$values[] = $value;
		}	
		
		$message = str_replace( $tags, $values, $template );
		
		return $message;
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
    public function get_subject () {

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
    public function from_email() {
    	return opaljob_get_option( 'from_email' ,  get_bloginfo( 'admin_email' ) );
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
    public function from_name() {
    	return opaljob_get_option('from_name',  get_bloginfo( 'name' ) );
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
    public function get_cc() {

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
	public function get_body(){
		return $this->replace_tags( $this->args['message'] ); 
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
	public function get_plain_text_body () {

	}
}
