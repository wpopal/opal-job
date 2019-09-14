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

		$results     = array();
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

				$results = $this->collection;
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
	            'taxonomy'  => 'property_category',
	            'terms' 	=> implode( ',', $args['categories'] ),
	            'field' 	=> 'slug',
	            'operator'	=> 'IN'
	        ));
	    }

	    if ( !empty($args['types']) ) {
	        array_push($condition['tax_query'], array(
	            'taxonomy'  => 'opalestate_types',
	            'terms' 	=> $args['types'],
	            'field' 	=> 'slug',
	            'operator'	=> 'IN'
	        ));
	    } 


	    if ( !empty($args['statuses']) ) {
	        array_push($condition['tax_query'], array(
	            'taxonomy'  => 'opalestate_status',
	            'terms' 	=> $args['statuses'],
	            'field' 	=> 'slug',
	            'operator'	=> 'IN'
	        ));
	    } 


	    if ( !empty($args['labels']) ) {
	        array_push($condition['tax_query'], array(
	            'taxonomy'  => 'opalestate_label',
	            'terms' 	=>  $args['labels'],
	            'field' 	=> 'slug',
	        ));
	    } 

	    if ( !empty($args['cities']) ) {
	        array_push($condition['tax_query'], array(
	            'taxonomy'  => 'opalestate_city',
	            'terms' 	=> $args['cities'],
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
}