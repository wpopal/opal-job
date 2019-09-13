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
namespace Opal_Job\Frontend\Controller;
use Opal_Job\Core\View;

use Opal_Job\Core;
use Opal_Job\Core\URI;
use Opal_Job\Core\Controller;
use Opal_Job\Libraries\Form\Scripts;
 
use Opal_Job\Common\Model\User; 
use Opal_Job\Common\Model\Statistic; 


/**
 * Class Dashboard Controller
 *
 * After logined system, this will be used for show menu dashboard, and contents of management pages
 * Such as show sidebar content , main content with hooks in each view templates
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author    WpOpal
 */
class Employer extends Controller {

	public $statistic;
	/**
	 * Get/Set User Model 
	 *
	 * Check the module is loaded or not to create new Model/User Object.
	 *
	 * @since 1.0
	 *
	 * @return Model/User is instance of this
	 */
	public function get_model (){
		if(!$this->model ){
			$this->model = User::get_instance();
		}
		return $this->model; 
	}

	/**
	 * Process Save Data Post Profile
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function register_ajax_hook_callbacks () {
		
	}
	

	public function register_hook_callbacks () { 
		add_action( 'opaljob/dashboard/tab_content/my_listing', [ $this, 'tab_content_my_listing' ] );
		add_action( 'opaljob/dashboard/tab_content/summary', [$this, 'tab_content_summary'] );
	}
	
	/**
	 * Show Content Tab of My Listing 
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function tab_content_my_listing() {
		$jobs = $this->get_model()->get_listing();
		echo View::render_template( "dashboard/employer/my-listing", array( 'jobs' => $jobs ) );
	}

	public function summary_top () {
		echo View::render_template( "dashboard/employer/widgets/top" );
	}


	public function summary_middle_left() {
		echo View::render_template( "dashboard/employer/widgets/middle-left" );
	}
	public function summary_middle_right () {
		echo View::render_template( "dashboard/employer/widgets/middle-right" );
	}


	public function tab_content_summary (){ 

		add_action( 'opaljob_dashboard_employer_summary_top' , array( $this, 'summary_top' ) );
		add_action( 'opaljob_dashboard_employer_summary_middle_left'  , array( $this, 'summary_middle_left' ) );
		add_action( 'opaljob_dashboard_employer_summary_middle_right' , array( $this, 'summary_middle_right' ) );
		echo View::render_template( "dashboard/employer/summary" );
	}
}