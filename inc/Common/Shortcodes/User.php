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

namespace Opal_Job\Common\Shortcodes;

use Opal_Job\Common\Model\Query\User_Query; 
use Opal_Job\Core\View;
/**
 *
 * @class User
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author     WpOpal
 **/
class User { 

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
			'myaccount' 		=> array( $this, 'render_myaccount'),
			'dashboard' 	=> array( $this, 'render_dashboard'),
			'candidates'	=> array ( $this, 'render_candidates' ),
			'employers'		=> array ( $this, 'render_employers' ),
			'search_map_candidates'  => array ( $this, 'render_search_candidates' ),
			'search_map_employers'  => array ( $this, 'render_search_employers' ),
		);

		foreach ( $shortcodes as $tag => $shortcode ){  
 			add_shortcode( 'opaljob_' .$tag , $shortcode, 1 );
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
	public function render_myaccount () {  
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
 	
 	/**
	 * Render Login Shortcode
	 *
	 * show login form and register form, forgotpass form in same box.
	 *
	 * @since    1.0.0
	 */
	public function render_candidates ( $atts ) {
		
		$default = array(
			'show_pagination' => '',
			'show_more' 	  => '',
			'show_categories' => '',
			'show_featured'   => '',
			'layout'		  => 'content-candidate-list',
			'items_per_grid'  => 1,
			'grid_class'	  => '',
		);   

		$query = new User_Query(); 

		$atts  = is_array( $atts ) ? $atts  : array();
		$atts = array_merge( $default, $atts ); 


		$members = $query->get_list_candidates(); 
		$atts['members'] = $members; 
		$atts['count']	 = 10;

		return View::render_template( 'shortcodes/candidate-listing', $atts );
	}

	/**
	 * Render Login Shortcode
	 *
	 * show login form and register form, forgotpass form in same box.
	 *
	 * @since    1.0.0
	 */
	public function render_employers ( $atts ) {
		$default = array(
			'show_pagination' => '',
			'show_more' 	  => '',
			'show_categories' => '',
			'show_featured'   => '',
			'layout'		  => 'content-employer-list',
			'items_per_grid'  => 1,
			'grid_class'	  => '',
		);   

		$query = new User_Query(); 

		$atts  = is_array( $atts ) ? $atts  : array();
		$atts = array_merge( $default, $atts ); 


		$members = $query->get_list_employers(); 
		$atts['members'] = $members; 
		$atts['count']	 = 10;

		return View::render_template( 'shortcodes/employer-listing', $atts );
	}

	/**
	 * Render Login Shortcode
	 *
	 * show login form and register form, forgotpass form in same box.
	 *
	 * @since    1.0.0
	 */
	public function render_search_candidates ( $atts ) {
		
		wp_enqueue_script( 'infobox' );
		wp_enqueue_script( 'markerclusterer' );

		$default = array(
			'show_pagination' => '',
			'show_more' 	  => '',
			'show_categories' => '',
			'show_featured'   => '',
			'layout'		  => 'content-candidate-list',
			'items_per_grid'  => 1,
			'grid_class'	  => '',
		);   

		$query = new User_Query(); 

		$atts  = is_array( $atts ) ? $atts  : array();
		$atts = array_merge( $default, $atts ); 


		$members = $query->get_list_candidates(); 
		$atts['members'] = $members; 
		$atts['count']	 = 10;

		return View::render_template( 'shortcodes/search-map-candidates', $atts );
	}

	/**
	 * Render Login Shortcode
	 *
	 * show login form and register form, forgotpass form in same box.
	 *
	 * @since    1.0.0
	 */
	public function render_search_employers ( $atts ) {
		
		wp_enqueue_script( 'infobox' );
		wp_enqueue_script( 'markerclusterer' );

		$default = array(
			'show_pagination' => '',
			'show_more' 	  => '',
			'show_categories' => '',
			'show_featured'   => '',
			'layout'		  => 'content-employer-list',
			'items_per_grid'  => 1,
			'grid_class'	  => '',
		);   

		$query = new User_Query(); 

		$atts  = is_array( $atts ) ? $atts  : array();
		$atts = array_merge( $default, $atts ); 


		$members = $query->get_list_employers(); 
		$atts['members'] = $members; 
		$atts['count']	 = 10;

		return View::render_template( 'shortcodes/search-map-employers', $atts );
	}
}