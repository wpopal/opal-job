<?php

namespace Opal_Job\Common\Shortcodes;

use Opal_Job\Core\View;
/**
 * Fired during plugin deactivation
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author     WpOpal
 **/
class User { 


	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function register( ) {
		$shortcodes =  array(
			'login' 		=> array( $this, 'render_login'),
			'dashboard' 	=> array( $this, 'render_dashboard')
		);

		foreach ( $shortcodes as $tag => $shortcode ){  
 			add_shortcode( 'opaljob_' .$tag , $shortcode );
		}
	}

	/**
	 * Dashboart Shortcode Render
	 *
	 * Display Menu on right of sidebar allow click item with prameter `tab` to show page for management
	 *
	 * @since    1.0.0
	 */
	public function dashboard(){

	}

	/**
	 * Render Login Shortcode
	 *
	 * show login form and register form, forgotpass form in same box.
	 *
	 * @since    1.0.0
	 */
	public function render_login () {  
		return View::render_template( 'user/myaccount' );
	}


	/**
	 * Render Login Shortcode
	 *
	 * show login form and register form, forgotpass form in same box.
	 *
	 * @since    1.0.0
	 */
	public function render_dashboard () {  
		return View::render_template( 'dashboard/main' );
	}
}