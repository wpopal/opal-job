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
namespace Opal_Job\Common\Model;
 
use Opal_Job\Core\URI;
use Opal_Job\Common\Model\Query\Job_Query; 

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author    WpOpal
 */
class User {

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	public $user_id; 

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	public $roles; 

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	public $data; 

 

	public static function get_instance(){
		static $_instance;
		if( !$_instance ){
			$_instance = new User();
		}
		return $_instance;
	}

	/**
	 * Constructor
	 */
	public function __construct () { 
		$this->user_id = get_current_user_id();
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
	public function is_type () {

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
	public function get_settings_form() {

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
	public function save_metabox() {

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
	public function save_profile() {

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
	public function get_dashboard_menu(){
	 
		if( opaljob_has_role('employer') ){
			return $this->get_employer_menu();
		}else if( opaljob_has_role('candidate') ){
			return $this->get_candidate_menu();
		}

		return $this->get_user_menu();
		
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
	public function get_user_menu () {
		$menu = [];

		$menu['menu_title'] = [
			'type'	=> 'title',
			'icon'  => 'fa fa-user',
			'link'  => URI::get_dashboard_url( 'summary' ),
			'title' => esc_html__( 'Menu', 'opaljob' ),
		];


		$menu['summary'] = [
			'icon'  => 'fa fa-columns',
			'link'  => URI::get_dashboard_url( 'summary' ),
			'title' => esc_html__( 'Dashboard', 'opaljob' ),
		];

		$menu['profile'] = [
			'icon'  => 'fa fa-user',
			'link'  => URI::get_dashboard_url( 'profile' ),
			'title' => esc_html__( 'Profile', 'opaljob' ),
		];

		$menu['favorite'] = [
			'icon'  => 'fa fa-heart',
			'link'  => URI::get_dashboard_url( 'favorite' ),
			'title' => esc_html__( 'Favorited Jobs', 'opaljob' )
		];

		$menu['changepassword'] = [
			'icon'  => 'fa fa-key',
			'link'  => URI::get_dashboard_url( 'changepassword' ),
			'title' => esc_html__( 'Change Password', 'opaljob' ),
		];

	
  		$menu['logout'] = [
			'icon'  => 'fa fa-sign-out',
			'link'  => wp_logout_url( home_url( '/' ) ),
			'title' => esc_html__( 'Logout', 'opaljob' ),
		];
 
		$menu = apply_filters( 'opaljob_dashboard_user_menu', $menu );
		return $menu;
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
	public function get_employer_menu (){
		$menu = [];

		$menu['menu_title'] = [
			'type'	=> 'title',
			'icon'  => 'fa fa-user',
			'title' => esc_html__( 'Information', 'opaljob' ),
		];

		$menu['summary'] = [
			'icon'  => 'fa fa-columns',
			'link'  => URI::get_dashboard_url( 'summary' ),
			'title' => esc_html__( 'Dashboard', 'opaljob' ),
		];

		$menu['profile'] = [
			'icon'  => 'fa fa-user',
			'link'  => URI::get_dashboard_url( 'profile' ),
			'title' => esc_html__( 'Profile', 'opaljob' ),
		];

		$menu['favorited_candidates'] = [
			'icon'  => 'fa fa-heart',
			'link'  => URI::get_dashboard_url( 'favorite' ),
			'title' => esc_html__( 'Favorited Candidates', 'opaljob' )
		];

		$menu['reviews'] = [
			'icon'  => 'fa fa-star',
			'link'  => URI::get_dashboard_url( 'reviews' ),
			'title' => esc_html__( 'Reviews', 'opaljob' ),
		];

		$menu['reviews'] = [
			'icon'  => 'fa fa-star',
			'link'  => URI::get_dashboard_url( 'reviews' ),
			'title' => esc_html__( 'Reviews', 'opaljob' ),
		];

		$menu['messages'] = [
			'icon'  => 'fa fa-envelope',
			'link'  => URI::get_dashboard_url( 'messages' ),
			'title' => esc_html__( 'Messages', 'opaljob' ),
		];


		$menu['submission'] = [
			'icon'  => 'fa fa-upload',
			'link'  => URI::get_dashboard_url( 'submission' ),
			'title' => esc_html__( 'Submit Job', 'opaljob' ),
		];

		$menu['my_listing'] = [
			'icon'  => 'fa fa-building',
			'link'  => URI::get_dashboard_url( 'my_listing' ),
			'title' => esc_html__( 'My Listing', 'opaljob' ),
		];


		$menu['changepassword'] = [
			'icon'  => 'fa fa-key',
			'link'  => URI::get_dashboard_url( 'changepassword' ),
			'title' => esc_html__( 'Change Password', 'opaljob' ),
		];

		$menu['logout'] = [
			'icon'  => 'fa fa-sign-out',
			'link'  => wp_logout_url( home_url( '/' ) ),
			'title' => esc_html__( 'Logout', 'opaljob' ),
		];
		
		$menu = apply_filters( 'opaljob_dashboard_employer_menu', $menu );
		return $menu;
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
	public function get_candidate_menu(){
		$menu = [];

		$menu['dashboard'] = [
			'icon'  => 'fa fa-columns',
			'link'  => URI::get_dashboard_url( 'summary' ),
			'title' => esc_html__( 'Dashboard', 'opaljob' ),
		];

		$menu['profile'] = [
			'icon'  => 'fa fa-user',
			'link'  => URI::get_dashboard_url( 'profile' ),
			'title' => esc_html__( 'Profile', 'opaljob' ),
		];

		$menu['resume'] = [
			'icon'  => 'fa fa-file',
			'link'  => URI::get_dashboard_url( 'resume' ),
			'title' => esc_html__( 'Resume', 'opaljob' ),
		];


		$menu['resumecv'] = [
			'icon'  => 'fa fa-share-alt',
			'link'  => URI::get_dashboard_url( 'resumecv' ),
			'title' => esc_html__( 'CV and Cover Letter', 'opaljob' ),
		];
		
		$menu['myapplied'] = [
			'icon'  => 'fa fa-share-alt',
			'link'  => URI::get_dashboard_url( 'myapplied' ),
			'title' => esc_html__( 'My applied', 'opaljob' ),
		];


		$menu['favorite'] = [
			'icon'  => 'fa fa-heart',
			'link'  => URI::get_dashboard_url( 'favorite' ),
			'title' => esc_html__( 'Favorite', 'opaljob' )
		];

		$menu['following_employers'] = [
			'icon'  => 'fa fa-users',
			'link'  => URI::get_dashboard_url( 'following_employers' ),
			'title' => esc_html__( 'Followed employers', 'opaljob' ),
		];

		$menu['reviews'] = [
			'icon'  => 'fa fa-star',
			'link'  => URI::get_dashboard_url( 'reviews' ),
			'title' => esc_html__( 'Reviews', 'opaljob' ),
		];

		$menu['messages'] = [
			'icon'  => 'fa fa-envelope',
			'link'  => URI::get_dashboard_url( 'messages' ),
			'title' => esc_html__( 'Messages', 'opaljob' ),
		];

		$menu['saved_search'] = [
			'icon'  => 'fa fa-search-plus',
			'link'  => URI::get_dashboard_url( 'saved_search' ),
			'title' => esc_html__( 'Saved search', 'opaljob' ),
		];

		$menu['changepassword'] = [
			'icon'  => 'fa fa-key',
			'link'  => URI::get_dashboard_url( 'changepassword' ),
			'title' => esc_html__( 'Change Password', 'opaljob' ),
		];

		$menu['logout'] = [
			'icon'  => 'fa fa-sign-out',
			'link'  => wp_logout_url( home_url( '/' ) ),
			'title' => esc_html__( 'Logout', 'opaljob' ),
		];

		$menu = apply_filters( 'opaljob_dashboard_candidate_menu', $menu );

		return $menu ;
	}

	/**
	 * Process Save Data Post Profile
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_apply_form_fields ( $job_id, $employer_id ) {

		$prefix = '';
		$name   = '' ;
		$email  = '';
		$phone  = '';
		$candidate_id = '';
		 
 	 
		$user = opaljob_new_user_object( $this->user_id );
		$msg  = $user->get_meta( 'cover_letter' );

		$fields =  array(
			array(
				'id'   		   => "type",
				'name' 		   => esc_html__( 'Type', 'opaljob' ),
				'type' 		   => 'hidden',		
				'default'	   => 'send_equiry',		 
				'description'  => "",
			),
			array(
				'id'   		   => "job_id",
				'name' 		   => esc_html__( 'Job ID', 'opaljob' ),
				'type' 		   => 'hidden',		
				'default'	   => $job_id,		 
				'description'  => "",
			),
			array(
				'id'   		   => "candidate_id",
				'name' 		   => esc_html__( 'candidate ID', 'opaljob' ),
				'type' 		   => 'hidden',		
				'default'	   => $this->user_id,		 
				'description'  => "",
			),
			array(
				'id'   		   => "employer_id",
				'name' 		   => esc_html__( 'Employer ID', 'opaljob' ),
				'type' 		   => 'hidden',		
				'default'	   => $employer_id,		 
				'description'  => "",
			),
			array(
				'id'   		   => "{$prefix}name",
				'name' 		   => esc_html__( 'Name', 'opaljob' ),
				'type' 		   => 'text',
				'before_row'   =>  '',
				'required' 	   => 'required',
				'default'	   => $user->get_name(),
				'description'  => "",
			),
			array(
				'id'   => "{$prefix}email",
				'name' => esc_html__( 'Email', 'opaljob' ),
				'type' => 'text',
				'default'	=> $user->get_email(),
				'description'  => "",
				'required' => 'required',
			),
			array(
				'id'  		   => "{$prefix}phone",
				'name' 		   => esc_html__( 'Phone', 'opaljob' ),
				'type' 		   => 'text',
				'description'  => "",
				'default'	   => $user->get_phone(), 
				'required' 	   => 'required',
			),
			array(
				'id'   		   => "{$prefix}cv_file",
				'name' 		   => esc_html__( 'Name', 'opaljob' ),
				'type' 		   => 'uploader',
				'before_row'   =>  '',
				'required' 	   => 'required',
				'default'	   => $user->get_name(),
				'description'  => "",
			),
			array(
				'id'   => "{$prefix}message",
				'name' => esc_html__( 'Message', 'opaljob' ),
				'type' => 'textarea',
				'description'  => "",
				'default'	=> $msg,
				'required' => 'required',
			)
		);

		return $fields;
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
	public  function save_password () {

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
	public function get_listing() {
		
		$query = new Job_Query();
		$query->post_author = $this->user_id;
		$query->post_status = 'any';
	
		$data = $query->get_list(); 

		return $data;
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
	public function get_profile () {

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
	public function bussiness_profile () {
		
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
	public function toggle_following_employer ( $employer_id ) {
		 
		$items = get_user_meta( $this->user_id,  '_following_employer', true );
		if( !is_array($items) ){
			$items = array();
		}
		$items = array_unique( $items );	
		$status = true; 
		// remove following employer
    	if( in_array( $employer_id, $items ) ){  
    		$key = array_search( $employer_id, $items);
    		unset($items[$key]);
    		$status = false;
    	}else { 
    		$items[] = $employer_id;
    	}
    	// remove items emty 
    	foreach( $items as $key => $value ) {
    		if( empty($value) ) {
    			unset( $items[$key] );
    		}
    	}


    	update_user_meta( $this->user_id,  '_following_employer', $items );
    	return $status;
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
	public function applied_job ( $job_id ) {
		$items = get_user_meta( $this->user_id,  '_applied_job', true );
		if( !is_array($items) ){
			$items = array();
		}
		
    	$items[] = $job_id;
  		$items = array_unique( $items );	
    	// remove items emty 
    	foreach( $items as $key => $value ) {
    		if( empty($value) ) {
    			unset( $items[$key] );
    		}
    	}

    	update_user_meta( $this->user_id,  '_applied_job', $items );
    	return $status;	
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
	public function get_meta ( $key ) {
		return get_user_meta( $this->user_id,  OPAL_JOB_METABOX_PREFIX.$key, true );
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
	public function get_followers() {
		$items = get_user_meta( $this->user_id,  '_following_employer', true );
		return $items; 
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
	private function get_applied_jobs_ids () {
		$items = get_user_meta( $this->user_id, '_applied_job', true );

		if( empty( $items ) ){
			return array(99999);
		}
		return $items;
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
	public function has_user_applied( $job_id ) {

		if( $this->user_id == 0 ){
			return false ;
		}
		
		$items = get_user_meta( $this->user_id, '_applied_job', true );

		if( is_array($items) && in_array( $job_id , $items ) ){
			$existed = 1;
		} else {
			$existed = 0;
		}

 	    return $existed;
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
	public function get_applied_jobs () {

		$query = new Job_Query();
		$query->post__in = $this->get_applied_jobs_ids();
		$data = $query->get_list(); 

		return $data; 
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
	public function can_edit_job ( $job_id ) {

		$can_edit = true;

		if ( ! is_user_logged_in() || ! $job_id ) {
			$can_edit = false;
		} else {
			$job = get_post( $job_id );

			if ( ! $job || ( absint( $job->post_author ) !== get_current_user_id() && ! current_user_can( 'edit_post', $job_id ) ) ) {
				$can_edit = false;
			}
		}

		return apply_filters( 'opaljob_user_can_edit_job', $can_edit, $job_id );
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
	public function can_submit_job () {

		if( $this->user_id ){ 
			return true; 
		}
		return false;
	}
}