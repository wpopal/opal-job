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
class Job { 
    
    public static $instance;

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since  1.26.0
	 * @static
	 * @return self Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function register( ) {

		$shortcodes =  array(
			'job_listing' 		=> array( $this, 'job_listing'),
			'dashboard' 	=> array( $this, 'render_dashboard')
		);

		foreach ( $shortcodes as $tag => $shortcode ){  
 			add_shortcode( 'opaljob_' .$tag , $shortcode );
		}
	}

	/**
	 * Render Login Shortcode
	 *
	 * show login form and register form, forgotpass form in same box.
	 *
	 * @since    1.0.0
	 */
	public function job_listing ( $atts ) {

		$default = array(
			'show_pagination' => '',
			'show_more' 	 => '',
			'show_categories' => '',
			'show_featured'   => '',
			'layout'		  => '',
		);   

		$atts = array_merge( $default, $atts ); 

		return View::render_template( 'shortcodes/job-listing', $atts );
	}

}