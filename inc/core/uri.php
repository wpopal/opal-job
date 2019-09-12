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
namespace Opal_Job\Core;
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Responsible for Rendering Urls for Project
 *
 * @since      1.0.0
 * @package    Opal_Job
 * @subpackage Opal_Job/views
 */
class URI {

	/**
	 * Get Dashboard URL
	 *
	 * Get Full url with tab parameter and other parameters for  logined user used
	 *
	 * @since 1.0
	 * 
	 * @param String $tab is Tab name
	 * @param Array $_args passing custom parameters
	 * 
	 * @return string
	 */
	public static function get_dashboard_url( $tab, $_args=array() ) {

		global $wp;
		
		$args = array( 'tab' => $tab );
		$args = array_merge( $args , $_args );

		$current_url = home_url( add_query_arg( $args, $wp->request ) );
		
		return $current_url;

	}

	/**
	 * Get Edit Jobj URL
	 *
	 * Return URL for editing a job by id
	 *
	 * @since 1.0
	 * 
	 * @param String $id is ID of job
	 * 
	 * @return string
	 */
	public static function get_edit_job_url ( $id ) {
		$tab  = 'submission';	
		return self::get_dashboard_url( $tab, array('id' => $id ) );
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
	public static function get_delete_job_url( $id ) {
		$tab  = 'my_listing';	
		return self::get_dashboard_url( $tab, array('id' => $id, 'action' => 'job/delete' ) );
	}
}