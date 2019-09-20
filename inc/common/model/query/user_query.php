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
namespace Opal_Job\Common\Model\Query;

use WP_Query;
use WP_User_Query;
use Opal_Job\Core\Query_Base;
use Opal_Job\Core\Cache_Data; 
use Opal_Job\Common\Model\Entity\Employer_Entity;
use Opal_Job\Common\Model\Entity\Candidate_Entity;
 
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
class User_Query extends Query_Base { 
	
	public $count = 0;

	/**
	 * Default query arguments.
	 *
	 * Not all of these are valid arguments that can be passed to WP_Query. The ones that are not, are modified before
	 * the query is run to convert them to the proper syntax.
	 *
	 * @since  2.5.0
	 * @access public
	 *
	 * @param  $args array The array of arguments that can be passed in and used for setting up this form query.
	 */
	public function __construct( $args = array() ) {
		$defaults = array(
			'output'    => 'collection',
			'post_type' => array( 'opaljob_job' ),
			'number'          => 20,
			'offset'          => 0,
			'paged'           => 1,
			'orderby'         => 'id',
			'order'           => 'DESC'
		);

		$args['update_post_meta_cache'] = false;

		$this->args = $this->_args = wp_parse_args( $args, $defaults );
	}
 	
	/**
	 * 
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
 	public function get_list_candidates ( $args=array() ) {

	    $args = array(
        	'role' => 'opaljob_candidate' 
        );
       
        $query = new WP_User_Query( $args );

        $collection = array();
        foreach ( $query->results as $user ) {
       		$collection[] = new Candidate_Entity( $user->ID );  
        }

        return $collection;
 	}	

 	/**
	 * 
	 * Render Sidebar
	 *
	 * Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
 	public function get_api_list_candidates ( $args=array() ) {

	    $args = array(
        	'role' => 'opaljob_candidate' 
        );
       
        $query = new WP_User_Query( $args );

        $collection = array();
        foreach ( $query->results as $user ) {

        	$candidate =  new Candidate_Entity( $user->ID ); 
        	$map      	  = $candidate->get_map( 'map' );

        	$candidate->map = array(
        		'address'	=>  $candidate->get_address(),
        		'latitude'	=>  $map['latitude'],
        		'longitude'	=>  $map['longitude'],
        	);

       		$collection[] = $candidate;
        }

        return $collection;
 	}	

 	/**
	 * 
	 * Render Sidebar
	 *
	 * Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
 	public function get_api_list_employers ( $args=array() ) {

	    $args = array(
        	'role' => 'opaljob_employer' 
        );
       
        $query = new WP_User_Query( $args );

        $collection = array();
        foreach ( $query->results as $user ) {

        	$candidate =  new Candidate_Entity( $user->ID ); 
        	$map      	  = $candidate->get_map( 'map' );

        	$candidate->map = array(
        		'address'	=>  $candidate->get_address(),
        		'latitude'	=>  $map['latitude'],
        		'longitude'	=>  $map['longitude'],
        	);

       		$collection[] = $candidate;
        }

        return $collection;
 	}	

 	/**
	 * 
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
 	public function get_list_data_candidates ( $args=array() ) {

 		$args = array(
        	'role' => 'opaljob_candidate' 
        );
       
        $query = new WP_User_Query( $args );

        $collection = array();
        foreach ( $query->results as $user ) {
        	$candidate =  new Candidate_Entity( $user->ID );  
       		$collection[] = $candidate->get_search_map_data(); 
        }

        return $collection;
 		
 	}

 	/**
	 * 
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
 	public function get_list_data_employers ( $args=array() ) {

 		$args = array(
        	'role' => 'opaljob_employer' 
        );
       
        $query = new WP_User_Query( $args );

        $collection = array();
        foreach ( $query->results as $user ) {
        	$employer 	  =  new Employer_Entity( $user->ID );  
       		$collection[] = $employer->get_search_map_data(); 
        }

        return $collection;
 		
 	}

 	/**
	 * 
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
 	public function get_list_employers ( $args=array() ) {

 		 $args = array(
        	'role' => 'opaljob_employer' 
        );
       
        $query = new WP_User_Query( $args );

        $collection = array();
        foreach ( $query->results as $user ) {
       		$collection[] = new Candidate_Entity( $user->ID );  
        }

        return $collection;
 	}

}