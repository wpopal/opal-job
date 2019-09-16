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
namespace Opal_Job\Common\Model;
 
use Opal_Job\Core\URI;
use Opal_Job\Common\Model\Query\Job_Query; 

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
class Statistic {
	public $user_id; 

	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public static function get_instance(){
		static $_instance;
		if( !$_instance ){
			$_instance = new Statistic();
		}
		return $_instance;
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
	public function __construct () {
		$this->user_id = get_current_user_id();
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
	public function count_publish_jobs () {
		$query = new Job_Query();
		$query->post_author = $this->user_id;
		$query->post_status = array( 'public' );

		return $query->get_count();
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
	public function count_pending_jobs () {
		$query = new Job_Query();
		$query->post_author = $this->user_id;
		$query->post_status = array( 'pending' );

		return $query->get_count();
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
	public function count_expired_jobs () {
		$query = new Job_Query();
		$query->post_author = $this->user_id;
		$query->post_status = array( 'expired' );

		return $query->get_count();
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
	public function get_featured () {
		return Job_Query::get_job_query( array(
			'post_author' => $this->user_id, 
			'post_status' => 'publish',
			'showmode'    => 'featured'
		) )->found_posts;
	}
}