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

	public static function get_instance(){
		static $_instance;
		if( !$_instance ){
			$_instance = new Statistic();
		}
		return $_instance;
	}

	public function __construct () {
		$this->user_id = get_current_user_id();
	}

	public function count_publish_jobs () {
		$query = new Job_Query();
		$query->post_author = $this->user_id;
		$query->post_status = array( 'public' );

		return $query->get_count();
	}

	public function count_pending_jobs () {
		$query = new Job_Query();
		$query->post_author = $this->user_id;
		$query->post_status = array( 'pending' );

		return $query->get_count();
	}

	public function count_expired_jobs () {
		$query = new Job_Query();
		$query->post_author = $this->user_id;
		$query->post_status = array( 'expired' );

		return $query->get_count();
	}
}