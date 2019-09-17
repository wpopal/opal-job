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
class User_Entity {

	/**
	 * The job ID
	 *
	 * @since 2.2
	 */
	public $ID; 

	/**
	 * The job ID
	 *
	 * @since 2.2
	 */
	public $roles; 

	/**
	 * The job ID
	 *
	 * @since 2.2
	 */
	public $data; 

	/**
	 * The job ID
	 *
	 * @since 2.2
	 */
	public $business_profile = null; 

	/**
	 * The job ID
	 *
	 * @since 2.2
	 */
	private $related_id; 

	public $display_name; 
	public $user_email; 
	public $address; 
	public $vacancies; 
	public $description;
	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function __construct ( $id ) {

		$this->ID = $id; 
		$this->setup(); 
	}

	public function setup(){
		if( $this->ID ){

		
			$user = get_userdata( $this->ID );
	 		$this->display_name = $user->display_name;
	 		$this->user_email   = $user->user_email; 
	 		$this->description  = $user->description;
	 	}
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

	public function get_related_id() {
		return get_user_meta( $this->ID, 'related_id', true );
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
	public  function save_password () {

	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_meta( $key ) {
		return get_user_meta( $this->ID, OPAL_JOB_METABOX_PREFIX.$key, true );
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function position() {

	}

 
	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_address() {
		return $this->get_meta( 'address' );
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_map() {
		return $this->get_meta( 'map' );
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_socials() {

	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_website() {

	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_email() {
		return $this->user_email; 
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_name() {
		return "ha cong tien";
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_link(){
		return get_author_posts_url( $this->ID );
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_avatar() {  
		
		$id  = $this->get_meta( 'avatar_id' );
		$url = wp_get_attachment_url( $id );
		if( !empty($url) ){
			return $url;
		}
		return 'placehold image here';
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_banner() {
		$id  = $this->get_meta( 'banner_id' );
		$url = wp_get_attachment_url( $id );
		if( !empty($url) ){
			return $url;
		}
		return 'placehold image here';
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_video_url() {
		return $this->get_meta( 'video' );
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function is_featured() {
		return $this->get_meta( 'featured' );
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function is_trusted () {
		return $this->get_meta( 'trusted' );
	}

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_phone() {
		return $this->get_meta( 'phone' );
	}
}