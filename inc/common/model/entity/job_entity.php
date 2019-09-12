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
namespace Opal_Job\Common\Model\Entity;

use WP_Post;
use Opal_Job\Core\URI; 
use Opal_Job\Common\Model\Entity\Employer_Entity;
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
class Job_Entity {

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

	public function __construct ( $_id ) {

		$job = WP_Post::get_instance( $_id );
		$this->ID = $_id;
		return $this->setup( $job );
	}

	/**
	 * Magic __get function to dispatch a call to retrieve a private property
	 *
	 * @since 1.0
	 */
	public function __get( $key ) {

		if( method_exists( $this, 'get_' . $key ) ) {
			return call_user_func( array( $this, 'get_' . $key ) );
		} else {
			return new WP_Error( 'opaljob-invalid-property', sprintf( esc_html__( 'Can\'t get property %s', 'opaljob' ), $key ) );
		}

	}

	/**
	 * Creates a job
	 *
	 * @since 1.0
	 * @param  array  $data Array of attributes for a job
	 * @return mixed  false if data isn't passed and class not instantiated for creation, or New Download ID
	 */
	public function create( $data = array() ) {

		if ( $this->id != 0 ) {
			return false;
		}

		$defaults = array(
			'post_type'   => 'opaljob_job',
			'post_status' => 'draft',
			'post_title'  => esc_html__( 'New Job', 'opaljob' )
		);

		$args = wp_parse_args( $data, $defaults );

		/**
		 * Fired before a job is created
		 *
		 * @param array $args The post object arguments used for creation.
		 */
		do_action( 'opaljob_pre_create', $args );

		$id = wp_insert_post( $args, true );

		$job = WP_Post::get_instance( $id );

		/**
		 * Fired after a job is created
		 *
		 * @param int   $id   The post ID of the created item.
		 * @param array $args The post object arguments used for creation.
		 */
		do_action( 'opaljob_post_create', $id, $args );

		return $this->setup( $job );

	}

	/**
	 * Given the job data, let's set the variables
	 *
	 * @since  1.0
	 * @param  WP_Post $job The WP_Post object for job.
	 * @return bool         If the setup was successful or not
	 */
	private function setup( $job ) {

		if( ! is_object( $job ) ) {
			return false;
		}

		if( ! $job instanceof WP_Post ) {
			return false;
		}

		if( 'opaljob_job' !== $job->post_type ) {
			return false;
		}

		foreach ( $job as $key => $value ) {
			$this->$key = $value;
		}

		$this->related_id = get_post_meta( $this->ID, 'related_id' , true );
		return true;
	}

	/**
	 * Delete Job
	 *
	 * Check Job is owned by current user and allow delete it if right?.
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function delete() {

	}

	/**
	 * Get Job Permerlink
	 *
	 *	return link to detail of the job.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_link() {
		return get_permalink( $this->ID );
	}

	public function get_link_edit() {
		return apply_filters( 'opaljob_job_edit_link', $this->ID );
	}
	/**
	 * Edit Link
	 *
	 *	Return link to edit the post related with user dashboard 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function edit_link() {
		return URI::get_edit_job_url( $this->ID );
	}

	/**
	 * Delete Link
	 *
	 *	Return link to edit the post related with user dashboard 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function delete_link() {
		return URI::get_delete_job_url( $this->ID );
	}

	/**
	 * Posted Date
	 *
	 * Return create post with format by args,it support type: ago, date 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_post_date(){
		return $this->post_date; 
	}

	/**
	 * Updated Date
	 *
	 * Return create post with format by args,it support type: ago, date 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_updated_date() {
		return $this->post_modified;
	}

	/**
	 * Updated Date
	 *
	 * Return create post with format by args,it support type: ago, date 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function has_employer() {
		return true; 
	}

	/**
	 * Updated Date
	 *
	 * Return create post with format by args,it support type: ago, date 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_employer() {
 		
 		if( $this->employer == '' ) {  
			$this->employer = new Employer_Entity( $this->post_author );
 		}
 		return $this->employer;
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
		return get_post_meta( $this->ID, OPAL_JOB_METABOX_PREFIX.$key, $single );
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
	public function get_map() {
		return $this->map;
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
	public function get_address() {
		return $this->address;
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
	public function get_sku() {
		return $this->sku;
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
	public function get_category_tax() {
		$terms = wp_get_post_terms( $this->post_id, 'property_category' );

		return $terms;
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
	public function get_types_tax() {
		$terms = wp_get_post_terms( $this->post_id, 'opaljob_types' );

		return $terms;
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function islogin_to_view(){
		if( !get_current_user_id() ){
			return true; 
		}
		return false; 
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_salary() {
		return $this->get_meta( 'salary_from' ) . ' - ' . $this->get_meta( 'salary_to' ) ;	
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_salary_label () {

	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_views() {
		return 1000;
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function has_user_applied() { 
		
	}
}