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
use Opal_Job\Common\Model\User; 

use Opal_Job\Libraries\Form\Scripts;


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
class Dashboard extends Controller {
	
	/**
	 * Store Instance of Model/User
	 *
	 * @var User $model
	 */
	public $model; 

	/**
	 * Register callbacks for actions and filters using for frontend
	 *
	 * @since    1.0.0
	 */
	public function register_hook_callbacks() {
		
		add_action( "opaljob_dashboard_sidebar" , [$this,'render_extra_block'] , 2 );
		add_action( "opaljob_dashboard_sidebar" , [$this,'render_sidebar'] , 3 );
		add_action( "opaljob_dashboard_content" , [$this,'render_content'] , 3 );
		add_action( "wp_enqueue_scripts", [$this,'enqueue_scripts'] );
		add_action( "wp_enqueue_scripts", [$this,'enqueue_styles'] );

		do_action( "opaljob_dashboard_int" );
	}	
	
	/**
	 * Enqueue Scripts
	 *
	 * Check and only load javascript, stylesheet files for dashboard/user use.
	 *
	 * @since 1.0
	 *
	 * @return Avoid
	 */
	public function enqueue_scripts () {
		
		if( isset($_GET['tab']) ) {
			Scripts::enqueue_scripts();
		}
	}

	/**
	 * Enqueue Styles
	 *
	 * Check and only load javascript, stylesheet files for dashboard/user use.
	 *
	 * @since 1.0
	 *
	 * @return Avoid
	 */
	public function enqueue_styles() {
		//if( isset($_GET['tab']) ) {
			Scripts::enqueue_styles();
			wp_enqueue_style( 'opaljob-dashboard', OPAL_JOB_URL . 'assets/css/frontend/dashboard.css', array(), '1.0', 'all' );
		// }
	}
	
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
	 * Get/Set User Model 
	 *
	 * Check the module is loaded or not to create new Model/User Object.
	 *
	 * @since 1.0
	 *
	 * @return Model/User is instance of this
	 */
	public function render_extra_block() {	
		$model =  $this->get_model(); 
		if( opaljob_has_role('employer') ) {
			echo View::render_template( "dashboard/employer/extra-block" );
		} else if( opaljob_has_role('candidate') ) {
			echo View::render_template( "dashboard/candidate/extra-block");
		}
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
	public function render_sidebar() {

		$tab = isset($_GET['tab']) ? sanitize_text_field( trim($_GET['tab']) ) : "summary";
		$menu = $this->get_model()->get_dashboard_menu(); 
		
		echo View::render_template( "dashboard/dashboard-menu", array( 'menu' => $menu, 'active' => $tab ) );
	}	

	/**
	 * Render Main Content
	 *
	 *	Main content sidebar is showed in right side and detect by parameter Tag to call do_action
	 *	which allow 3rd hook for showing if having not method in this object.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function render_content() {
		
		$tab = isset($_GET['tab']) ? sanitize_text_field( trim($_GET['tab']) ) : "summary";
		$method = 'tab_content_'.$tab;
		if( method_exists( $this,$method) ) {  
			return $this->{$method}();
		} else {
			$content = do_action( 'opaljob/dashboard/tab_content/'.$tab, $tab );
		}
	}	
}