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
namespace Opal_Job\Common\Vendors\Opalmembership; 
use Opal_Job\Core\URI;
use Opal_Job\Common\interfaces\Intergration;
use Opal_Job\Common\Vendors\Opalmembership\Job_Package_Handler;
use Opal_Job\Common\Vendors\Opalmembership\Apply_Package_Handler;

/**
 * @class OpalJob_Membership: as vendor class is using for processing logic with update/set permission for user submitting job.
 *
 * @version 1.0
 */
class Membership  implements Intergration{

	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */	
	public function register_admin_actions() {  
		require_once( 'functions.php' );
		Job_Package_Handler::get_instance()->register_admin_actions();  
		Apply_Package_Handler::get_instance()->register_admin_actions();  
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
	public function register_frontend_actions() {
 		 
 		define( "OPALJOB_MEMBERSHIP_PREFIX", OPAL_JOB_METABOX_PREFIX );
 		require_once( 'functions.php' );
 		if( get_current_user_id() ){
 			// show menu in dashboard 
 			add_filter( 'opaljob_dashboard_employer_menu' , array( $this, 'membership_menu' )  );
 			add_filter( "opalmembership_get_payment_history_page_uri", array($this,'get_history_page_uri') );
 			// show list of invoices in dashboard page.
 			add_action( "opaljob/dashboard/tab_content/invoices", array( $this, 'render_invoices_tab_content' ) );

 			// display information in my membership tab page of dashboard
 			add_action( "opaljob/dashboard/tab_content/mymembership", array( $this, 'render_mymembership_tab_content' ) );
	 	
	 		 	
	 		if( opaljob_has_role('employer') ){ 
				Job_Package_Handler::get_instance()->register_global_actions();  
			}else if( opaljob_has_role('candidate') ){
				Job_Package_Handler::get_instance()->register_global_actions();  
			}

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
	public function show_membership_warning(){
		if( isset($_GET['id']) && $_GET['id'] > 0 ){
			return true; 
		} 
		if( class_exists("Opalmembership_User") ){
			return Opalmembership_User::show_membership_warning();
		}
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Internationalization_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @access    private
	 */
	public function get_history_page_uri () {
		return URI::get_dashboard_url( 'invoices' );
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
	public function membership_menu( $menu ){  
		if( function_exists("opalmembership_get_dashdoard_page_uri") ){
			global $opalmembership_options;

			$menu['membership_menu_title'] = [
				'type'	=> 'title',
				'icon'  => 'fa fa-gear',
				'title' => esc_html__( 'Membership', 'opaljob' ),
			];


			$menu['membership'] = array(
				'icon'			=> 'fa fa-user',
				'link'		 	=> URI::get_dashboard_url( 'mymembership' ),
				'title'			=> esc_html__( 'My Membership', 'opaljob' ),
				'id'			=> isset( $opalmembership_options['dashboard_page'] ) ? $opalmembership_options['dashboard_page'] : 0
			);

			$menu['membership_history'] = array(
				'icon'			=> 'fa fa-user',
				'link'		 	=> URI::get_dashboard_url( 'invoices' ),
				'title'			=> esc_html__( 'My Invoices', 'opaljob' ),
				'id'			=> isset( $opalmembership_options['dashboard_page'] ) ? $opalmembership_options['dashboard_page'] : 0
			);

			/* 
			$menu['packages'] = array(
				'icon'			=> 'fa fa-certificate',
				'link'		 	=> opalmembership_get_membership_page_uri(),
				'title'			=> esc_html__( 'Renew membership', 'opaljob' ),
				'id'			=> isset( $opalmembership_options['dashboard_page'] ) ? $opalmembership_options['dashboard_page'] : 0
			); */
		}	
		return $menu;
	}

	/**
	 * Check user having any actived package and the package is not expired.
	 * Auto redirect to membership packages package.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function check_membership_validation(){
		$check = opaljob_is_membership_valid();
		if( !$check ){

			return opaljob_output_msg_json( true,
				__('Your membership package is expired or Your package has 0 left listing, please upgrade now.', 'opaljob' ),
				array( 
					'heading'  => esc_html__('Submission Information' ,'opaljob'),
					'redirect' => opalmembership_get_membership_page_uri(array('warning=1')) 
				)) ;
		}
		return ;
	}

	/**
	 * Display membership warning at top of submission form.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function render_invoices_tab_content () {
		echo do_shortcode( "[opalmembership_history]" );
	}

	/**
	 * Display membership warning at top of submission form.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function render_mymembership_tab_content ()  {
		echo do_shortcode( "[opalmembership_dashboard]" );
	}
}