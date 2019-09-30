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
use Opal_Job\Core\Query_Base;
use Opal_Job\Core\Cache_Data; 
use Opal_Job\Common\Model\Entity\Job_Entity;

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
class Job_Query extends Query_Base { 
	
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
	public function init() {
		$this->post_type = 'opaljob_job';
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
	public function get_query_object() {
		/* @var WP_Query $query */	
		$query = new WP_Query( $this->args );
		return $query; 
	}

 

	public function get_count() {
		return $this->count;
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
	public function get_list() { 

		global $post;

		$results     = array(
			'founds'	 => 0, 
			'collection' => array()
		);
		$this->collection = null;
		$cache_key   = Cache_Data::get_key( 'opaljob_form_query', $this->args, false );
		//$this->collection = Cache_Data::get_db_query( $cache_key );

		// Return cached result.
		if ( ! is_null( $this->collection ) ) {
			return $this->collection;
		}
	
		$query = $this->get_query_object();
		$this->count = $query->found_posts(); 
		
		$custom_output = array(
			'collection',
			'opaljob_collection',
		);

		if ( $query->have_posts() ) {
			$this->update_meta_cache( wp_list_pluck( $query->posts, 'ID' ) );

			if ( ! in_array( $this->args['output'], $custom_output ) ) {
				$results = $query->posts;

			} else {
				$previous_post = $post;

				while ( $query->have_posts() ) {
					$query->the_post();

					$form_id = get_post()->ID;
					$form    = new Job_Entity( $form_id );

					$this->collection[] = apply_filters( 'opaljob_query_base', $form, $form_id, $this );
				}

				wp_reset_postdata();

				// Prevent nest loop from producing unexpected results.
				if ( $previous_post instanceof WP_Post ) {
					$post = $previous_post;
					setup_postdata( $post );
				}

				$results = array(
					'founds' 		=> $query->found_posts,
					'collection'	=> $this->collection
				);
			}
		}
		return $results;
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
	public static function get_job_query( $args=array() ){

		$condition = array(
			'post_type'         => 'opaljob_job',
			'post_status'		=> 'publish',
			'posts_per_page'	=> isset($args['posts_per_page']) ? $args['posts_per_page'] : 5,
			'paged'				=> isset($args['paged']) ? $args['paged'] : 1,
			
		);
 		
		$relation = "AND";
		
		$condition['meta_query'] = array(); 

	    $condition['tax_query'] = array(
	        'relation' => $relation
	    );

	    if ( !empty($args['categories']) ) {
	        array_push($condition['tax_query'], array(
	            'taxonomy'  => 'opaljob_category',
	            'terms' 	=>  $args['categories'],
	            'field' 	=> 'slug',
	            'operator'	=> 'IN'
	        ));
	    }


	    if ( !empty($args['types']) ) {
	        array_push($condition['tax_query'], array(
	            'taxonomy'  => 'opaljob_types',
	            'terms' 	=> $args['types'],
	            'field' 	=> 'slug',
	            'operator'	=> 'IN'
	        ));
	    } 


	    if ( !empty($args['tags']) ) {
	        array_push($condition['tax_query'], array(
	            'taxonomy'  => 'opaljob_tag',
	            'terms' 	=>  $args['tags'],
	            'field' 	=> 'slug',
	        ));
	    } 

	    if ( !empty($args['location']) ) {
	        array_push($condition['tax_query'], array(
	            'taxonomy'  => 'opaljob_location',
	            'terms' 	=>  $args['location'],
	            'field' 	=> 'slug',
	            'operator'	=> 'IN'
	        ));
	    } 

	    if ( !empty($args['specialism']) ) {
	        array_push($condition['tax_query'], array(
	            'taxonomy'  => 'opaljob_specialism',
	            'terms' 	=>  $args['specialism'],
	            'field' 	=> 'slug',
	            'operator'	=> 'IN'
	        ));
	    } 

	    if ( !empty($args['tag']) ) {
	        array_push($condition['tax_query'], array(
	            'taxonomy'  => 'opaljob_tag',
	            'terms' 	=>  $args['tag'],
	            'field' 	=> 'slug',
	            'operator'	=> 'IN'
	        ));
	    } 

	  	if ( !empty($args['showmode']) ) {
	  		if( $args['showmode'] == 'featured' ) {
	  			array_push( $condition['meta_query'], array(
			    	'key'       => OPAL_JOB_METABOX_PREFIX . 'featured',
					'value'     => 'on',
					'compare'   => '=',
				) );
			} else if( $args['showmode'] == 'normal' ) {
				array_push( $condition['meta_query'], array(
			    	'key'       => OPAL_JOB_METABOX_PREFIX . 'featured',
					'value'     => 'on',
					'compare'   => '!=',
				) );
			}	
 	 	}


		$query =  new WP_Query( $condition );

		wp_reset_postdata();
 
		return $query;
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
	public static function query_get_list( $args=array() ) {
		$collection = array();

		return $collection;
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
	public static function query_get_item( $args=array() ) {
		$item = array();
		return $item; 
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
	public static function filter_by_location( $geo_lat, $geo_long, $radius, $prefix = OPALESTATE_PROPERTY_PREFIX ) {

		global $wpdb;

		$radius_measure = '';
		$earth          = 3959;

		if ( $radius_measure == 'km' ) {
			$earth = 6371;
		}

		$latitude  = $prefix . 'map_latitude';
		$longitude = $prefix . 'map_longitude';

		$sql = "SELECT $wpdb->posts.ID,
            ( %s * acos(
                    cos( radians(%s) ) *
                    cos( radians( latitude.meta_value ) ) *
                    cos( radians( longitude.meta_value ) - radians(%s) ) +
                    sin( radians(%s) ) *
                    sin( radians( latitude.meta_value ) )
            ) )
            AS distance, latitude.meta_value AS latitude, longitude.meta_value AS longitude
            FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta
                    AS latitude
                    ON $wpdb->posts.ID = latitude.post_id
            INNER JOIN $wpdb->postmeta
                    AS longitude
                    ON $wpdb->posts.ID = longitude.post_id
            WHERE 1=1

                    AND latitude.meta_key = '" . $latitude . "'
                    AND longitude.meta_key= '" . $longitude . "'
            HAVING distance < %s
            ORDER BY $wpdb->posts.menu_order ASC, distance ASC";

		$query = $wpdb->prepare( $sql,

			$earth,
			$geo_lat,
			$geo_long,
			$geo_lat,
			$radius
		);

		$post_ids = $wpdb->get_results( $query, OBJECT_K );
		if ( $post_ids ) {
			$post_ids = array_keys( $post_ids );

			return $post_ids;
		}

		return [ 0 ];
	}
}