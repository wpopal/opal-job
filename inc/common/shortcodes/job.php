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
use Opal_Job\Common\Model\Query\Job_Query; 
use Opal_Job\Common\Taxonomies;
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
			'job_listing' 			=> array( $this, 'render_job_listing' ),
			'category_blocks'		=> array( $this, 'render_category_blocks' ),
			'search_map'			=> array( $this, 'render_search_map' ),
			'search_view_jobs' 		=> array( $this, 'render_search_view_jobs' ),
			'submission'		    => array( $this, 'render_submission' ),
		);

		foreach ( $shortcodes as $tag => $shortcode ){  
 			add_shortcode( 'opaljob_' .$tag , $shortcode, 1 );
		}
	}

	/**
	 * Render Login Shortcode
	 *
	 * show login form and register form, forgotpass form in same box.
	 *
	 * @since    1.0.0
	 */
	public function render_job_listing ( $atts=array() ) {

		$default = array(
			'show_pagination' => '',
			'show_more' 	  => '',
			'show_categories' => '',
			'show_featured'   => '',
			'layout'		  => 'content-job-list',
			'items_per_grid'  => 1,
			'grid_class'	  => '',
		);   
		
		$atts  = is_array( $atts ) ? $atts  : array();
		$atts = array_merge( $default, $atts ); 

		$query = new Job_Query(
			array(
				'posts_per_page'      => 4,
				'post_status' 	      => 'publish',
				'paged'			      => 2
			)
		); 

		$atts['jobs']  = $query->get_list();
		$atts['count'] =  1; 

		return View::render_template( 'shortcodes/job-listing', $atts );
	}

	/**
	 * Render Login Shortcode
	 *
	 * show login form and register form, forgotpass form in same box.
	 *
	 * @since    1.0.0
	 */
	public function render_search_map ( $atts ) {
		
		$posts_per_page = 10; 
		$paged = 1;

		$args = [
	 		'posts_per_page' => $posts_per_page,
		 	'paged'          => $paged 
		];

		$gets = array(
			'location'  	=> 'location',
			'types' 		=> 'types',
			'categories'	=> 'categories',
			'specialism'	=> 'specialism',
			'tag'			=> 'tags'
		); 

		foreach ( $gets as $key =>  $get ) {
			if( isset($_GET[$get]) && $_GET[$get] != -1 ) {
				$args[$key] =  $_GET[$get];
			}
		}

		wp_enqueue_script( 'infobox' );
		wp_enqueue_script( 'markerclusterer' );

		$default = array(
			'show_pagination' => '',
			'show_more' 	  => '',
			'show_categories' => '',
			'show_featured'   => '',
			'layout'		  => 'content-job-search-map',
			'items_per_grid'  => 1,
			'grid_class'	  => '',
		);   
		
		$atts  = is_array( $atts ) ? $atts  : array();
		$atts  = array_merge( $default, $atts ); 

		$query = Job_Query::get_job_query( $args ); 

		$atts['query']  = $query;
		
		return View::render_template( 'shortcodes/search-map', $atts );
	}

	/**
	 * Render Login Shortcode
	 *
	 * show login form and register form, forgotpass form in same box.
	 *
	 * @since    1.0.0
	 */
	public function render_category_blocks ( $atts=array() ) {

		$atts  = is_array( $atts ) ? $atts  : array();
		$atts['terms'] = Taxonomies::get_category_list();
		
		return View::render_template( 'shortcodes/category-blocks', $atts );
	}

	/**
	 * Render Login Shortcode
	 *
	 * show login form and register form, forgotpass form in same box.
	 *
	 * @since    1.0.0
	 */
	public function render_search_view_jobs ( $atts ) {

		wp_enqueue_script( 'jquery-sticky-kit' );
		
		$atts  = is_array( $atts ) ? $atts  : array();
		$get_post_id = isset( $_GET['view_job_id'] ) ? intval( $_GET['view_job_id'] ) : 0 ;
		$posts_per_page = 10; 
		$paged = 1;

		$args = [
	 		'posts_per_page' => $posts_per_page,
		 	'paged'          => $paged 
		];

		$gets = array(
			'location'  	=> 'location',
			'types' 		=> 'types',
			'categories'	=> 'categories',
			'specialism'	=> 'specialism',
			'tag'			=> 'tags'
		); 

		foreach ( $gets as $key =>  $get ) {
			if( isset($_GET[$get]) && $_GET[$get] != -1 ) {
				$args[$key] =  $_GET[$get];
			}
		}

				

		$default = array(
			'show_pagination' => '',
			'show_more' 	  => '',
			'show_categories' => '',
			'show_featured'   => '',
			'layout'		  => 'content-job-search-map',
			'items_per_grid'  => 1,
			'grid_class'	  => '',
		);   
		
		$atts  = is_array( $atts ) ? $atts  : array();
		$atts  = array_merge( $default, $atts ); 

		$query = Job_Query::get_job_query( $args ); 

		$atts['query']  = $query;

		if( $query->posts ) {
			$job_post = $get_post_id ? get_post( $get_post_id ) : $query->posts[0];
			$atts['job_post']	=  $job_post; 
		} else {
			$atts['job_post']	= null;
		}

		// echo '<Pre>' . print_r( $job_post ,1 );
		return View::render_template( 'shortcodes/search-view-jobs', $atts );
	}

	/**
	 * Render Login Shortcode
	 *
	 * show login form and register form, forgotpass form in same box.
	 *
	 * @since    1.0.0
	 */
	public function render_submission () {
		 
		do_action( "opaljob/dashboard/tab_content/submission" );
	}
}