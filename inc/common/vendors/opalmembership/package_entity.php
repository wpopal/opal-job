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
use WP_Post;
/**
 * @class OpalJob_Membership: as vendor class is using for processing logic with update/set permission for user submitting property.
 *
 * @version 1.0
 */
class Package_Entity {


	/**
	 * The job ID
	 *
	 * @since 2.2
	 */
	public $ID = 0;

	/**
	 * The job price
	 *
	 * @since 2.2
	 */
	private $price;

	/**
	 * The job prices, if Variable Prices are enabled
	 *
	 * @since 2.2
	 */
	private $prices;

	/**
	 * The job files
	 *
	 * @since 2.2
	 */
	private $address;

	/**
	 * The job's file job limit
	 *
	 * @since 2.2
	 */
	private $map;

	/**
	 * The job type, default or bundle
	 *
	 * @since 2.2
	 */
	private $type;

	/**
	 * The bundled jobs, if this is a bundle type
	 *
	 * @since 2.2
	 */
	private $bundled_jobs;

	/**
	 * The job's sale count
	 *
	 * @since 2.2
	 */
	private $sales;

	/**
	 * The job's total earnings
	 *
	 * @since 2.2
	 */
	private $related;

	/**
	 * The job's notes
	 *
	 * @since 2.2
	 */
	private $notes;

	/**
	 * The job sku
	 *
	 * @since 2.2
	 */
	private $sku;

	/**
	 * The job sku
	 *
	 * @since 2.2
	 */
	private $user_id; 

	/**
	 * Declare the default properties in WP_Post as we can't extend it
	 * Anything we've declared above has been removed.
	 */
	public $post_author = 0;
	public $post_date = '0000-00-00 00:00:00';
	public $post_date_gmt = '0000-00-00 00:00:00';
	public $post_content = '';
	public $post_title = '';
	public $post_excerpt = '';
	public $post_status = 'publish';
	public $comment_status = 'open';
	public $ping_status = 'open';
	public $post_password = '';
	public $post_name = '';
	public $to_ping = '';
	public $pinged = '';
	public $post_modified = '0000-00-00 00:00:00';
	public $post_modified_gmt = '0000-00-00 00:00:00';
	public $post_content_filtered = '';
	public $post_parent = 0;
	public $guid = '';
	public $menu_order = 0;
	public $post_mime_type = '';
	public $comment_count = 0;
	public $filter;

	public $employer = null ;

	public function __construct ( $_id , $user_id ) { 

		$package = WP_Post::get_instance( $_id );
		$this->ID = $_id;
		$this->user_id = $user_id;

		return $this->setup( $package );
	}

	/**
	 * Given the job data, let's set the variables
	 *
	 * @since  1.0
	 * @param  WP_Post $job The WP_Post object for job.
	 * @return bool         If the setup was successful or not
	 */
	private function setup( $package ) {

		if( ! is_object( $package ) ) {
			return false;
		}

		if( ! $package instanceof WP_Post ) {
			return false;
		}

		if( 'membership_packages' !== $package->post_type ) {
			return false;
		}

		foreach ( $package as $key => $value ) {
			$this->$key = $value;
		}

		return true;
	}


	/**
	 * Gets meta box value
	 *
	 * Return create post with format by args,it support type: ago, date 
	 *
	 * @access public
	 * @param $key
	 * @param $single
	 * @return string
	 */
	public function get_meta( $key, $single = true ) {
		return get_post_meta( $this->ID, OPALMEMBERSHIP_USER_PREFIX_.$key, $single );
	}

	public function get_user_meta( $key, $single = true ) { 
		return get_user_meta( $this->user_id, OPALMEMBERSHIP_USER_PREFIX_.$key, $single );
	}

	/**
	 * Gets meta box value
	 *
	 * Return create post with format by args,it support type: ago, date 
	 *
	 * @access public
	 * @param $key
	 * @param $single
	 * @return string
	 */
	public function is_for_user_role() {

	}

	/**
	 * Gets meta box value
	 *
	 * Return create post with format by args,it support type: ago, date 
	 *
	 * @access public
	 * @param $key
	 * @param $single
	 * @return string
	 */
	public function get_package_listings() {
		return $this->get_meta( 'package_listings' );
	}

	/**
	 * Gets meta box value
	 *
	 * Return create post with format by args,it support type: ago, date 
	 *
	 * @access public
	 * @param $key
	 * @param $single
	 * @return string
	 */
	public function get_package_featured_listings() {
		return $this->get_meta( 'package_featured_listings' );
	}

	/**
	 * Gets meta box value
	 *
	 * Return create post with format by args,it support type: ago, date 
	 *
	 * @access public
	 * @param $key
	 * @param $single
	 * @return string
	 */
	public function get_package_unlimited_listings() {
		return $this->get_meta( 'unlimited_listings' );
	}

	/**
	 * Gets meta box value
	 *
	 * Return create post with format by args,it support type: ago, date 
	 *
	 * @access public
	 * @param $key
	 * @param $single
	 * @return string
	 */
	public function get_user_package_listings () {
		return $this->get_user_meta( 'package_listings' );
	}

	/**
	 * Gets meta box value
	 *
	 * Return create post with format by args,it support type: ago, date 
	 *
	 * @access public
	 * @param $key
	 * @param $single
	 * @return string
	 */
	public function get_user_package_featured_listings () {
		return $this->get_user_meta( 'package_featured_listings' );
	}
	/**
	 * Gets meta box value
	 *
	 * Return create post with format by args,it support type: ago, date 
	 *
	 * @access public
	 * @param $key
	 * @param $single
	 * @return string
	 */
	public function get_user_unlimited_listings () {
		return $this->get_user_meta( 'unlimited_listings' );
	}

	public function get_actived_package() {
		return $this->get_user_meta( 'package_id' );
	}

	/**
	 * Gets meta box value
	 *
	 * Return create post with format by args,it support type: ago, date 
	 *
	 * @access public
	 * @param $key
	 * @param $single
	 * @return string
	 */
	public static function get_package_type( $id ) {
		return  get_post_meta( $id, OPAL_JOB_METABOX_PREFIX.'package_type', true );
	}
}