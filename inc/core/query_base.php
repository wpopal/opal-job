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
namespace Opal_Job\Core;
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Register all actions and filters for the plugin
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author     WpOpal
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 */
class Query_Base { 

	/**
	 * Preserve args
	 *
	 * @since  1.8.17
	 * @access public
	 *
	 * @var    array
	 */
	public $_args = array();

	/**
	 * The args to pass to the give_get_collection() query
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @var    array
	 */
	public $args = array();

	/**
	 * The collection found based on the criteria set
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @var    array
	 */
	public $collection = array();

	/**
	 *
	 */
	public function __construct () {

		$defaults = array(
			'output'          => 'collection',
			'post_type'       => '',
			'start_date'      => false,
			'end_date'        => false,
			'number'          => 20,
			'page'            => null,
			'orderby'         => 'ID',
			'order'           => 'DESC',
			'user'            => null,  
			'status'          => '',
			'meta_key'        => null,
			'year'            => null,
			'month'           => null,
			'day'             => null,
			's'               => null,
			'search_in_notes' => false,
			'children'        => false,
			'fields'          => null,
			'offset'          => null,

			'group_by'        => '',
			'count'           => false,
		);

		// We do not want WordPress to handle meta cache because WordPress stores in under `post_meta` key and cache object while we want it under `donation_meta`.
		// Similar for term cache
		$args['update_post_meta_cache'] = false;

		$this->args = $this->_args = wp_parse_args( $args, $defaults );

		$this->init();
	}

	/**
	 * Set a query variable.
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @param $query_var
	 * @param $value
	 */
	public function __set( $query_var, $value ) {
		if ( in_array( $query_var, array( 'meta_query', 'tax_query' ) ) ) {
			$this->args[ $query_var ][] = $value;
		} else {
			$this->args[ $query_var ] = $value;
		}
	}

	/**
	 * Unset a query variable.
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @param $query_var
	 */
	public function __unset( $query_var ) {
		unset( $this->args[ $query_var ] );
	}

	/**
	 * Modify the query/query arguments before we retrieve collection.
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @return void
	 */
	public function init() {
	}

	/**
	 * Set query filter.
	 *
	 * @since  1.8.9
	 * @access private
	 */
	private function set_filters() {

	}

	/**
	 * Post Status
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @return void
	 */
	public function status() {
		if ( ! isset( $this->args['status'] ) ) {
			return;
		}

		$this->__set( 'post_status', $this->args['status'] );
		$this->__unset( 'status' );
	}

	/**
	 * Current Page
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @return void
	 */
	public function page() {
		if ( ! isset( $this->args['page'] ) ) {
			return;
		}

		$this->__set( 'paged', $this->args['page'] );
		$this->__unset( 'page' );
	}

	/**
	 * If querying a specific date, add the proper filters.
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @return void
	 */
	public function date_filter_pre() {
		if ( ! ( $this->args['start_date'] || $this->args['end_date'] ) ) {
			return;
		}

		$this->setup_dates( $this->args['start_date'], $this->args['end_date'] );

		$is_start_date = property_exists( __CLASS__, 'start_date' );
		$is_end_date   = property_exists( __CLASS__, 'end_date' );

		if ( $is_start_date || $is_end_date ) {
			$date_query = array();

			if ( $is_start_date && ! is_wp_error( $this->start_date ) ) {
				$date_query['after'] = date( 'Y-m-d H:i:s', $this->start_date );
			}

			if ( $is_end_date && ! is_wp_error( $this->end_date ) ) {
				$date_query['before'] = date( 'Y-m-d H:i:s', $this->end_date );
			}

			// Include Start Date and End Date while querying.
			$date_query['inclusive'] = true;

			$this->__set( 'date_query', $date_query );

		}
	}

	/**
	 * Posts Per Page
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @return void
	 */
	public function per_page() {

		if ( ! isset( $this->args['number'] ) ) {
			return;
		}

		if ( $this->args['number'] == - 1 ) {
			$this->__set( 'nopaging', true );
		} else {
			$this->__set( 'posts_per_page', $this->args['number'] );
		}

		$this->__unset( 'number' );
	}

	/**
	 * Current Month
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @return void
	 */
	public function month() {
		if ( ! isset( $this->args['month'] ) ) {
			return;
		}

		$this->__set( 'monthnum', $this->args['month'] );
		$this->__unset( 'month' );
	}

	/**
	 * Order by
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @return void
	 */
	public function orderby() {

		$this->__set( 'orderby', $this->args['orderby'] );

	}

	/**
	 * Retrieve collection.
	 *
	 * The query can be modified in two ways; either the action before the
	 * query is run, or the filter on the arguments (existing mainly for backwards
	 * compatibility).
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @return array
	 */
	public function get_list() { 

	}

	public static function update_meta_cache( $ids ) {
	}
}