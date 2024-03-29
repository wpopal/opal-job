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

use stdClass; 

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
	private $related_id; 

	public $display_name; 
	public $user_email; 
	public $address; 
	public $description;
	public $avatar; 
	public $user_login;
	public $map;
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
	 		$this->user_login   = $user->user_login;
	 		$this->description  = $user->description;
	 		$this->avatar 		= $this->get_avatar();
	 		$this->address 	    = $this->get_address();
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
		return $this->display_name;
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
		return get_avatar_url( $this->ID );
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
		return opaljob_get_image_placeholder_src( 'banner' );
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

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_search_map_data () {

		$prop     	  = new stdClass();
		$map      	  = $this->get_map( 'map' );
	 	$url 		  = $this->get_avatar();
 
		$prop->id     = $this->ID;
		$prop->title  = $this->get_name();
		$prop->url    = $this->get_link();

		$prop->lat     = $map['latitude'];
		$prop->lng     = $map['longitude'];
		$prop->address = $this->get_address();

		$prop->pricehtml  = '';//opaljob_price_format( $this->get_price() );
		$prop->pricelabel = '';//$this->get_price_label();
		$prop->thumb      = $url;

		if ( file_exists( get_template_directory() . '/images/map/cluster-icon.png' ) ) {
			$prop->icon = get_template_directory_uri() . '/images/map/cluster-icon.png';
		} else {
			$prop->icon = OPAL_JOB_URL . '/assets/images/cluster-icon.png';
		}

		$prop->featured = $this->get_meta( 'featured' );

		$prop->metas  = array();
		$prop->status = array(); 

		return $prop;
	}

	/**
	 * Magic __get function to dispatch a call to retrieve a private job
	 *
	 * @since 1.0
	 */
	public function __get( $key ) {  

		if( method_exists( $this, 'get_' . $key ) ) {
			return call_user_func( array( $this, 'get_' . $key ) );
		} else {
			return $this->get_meta( $key );
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
	protected function get_term_data( $meta_key, $tax ) {
		$output = array(); 
		$category = $this->get_meta( $meta_key ); 
		if( $category ){
			foreach ( $category as $slug ) {
				$term = get_term_by( 'slug', $slug, $tax );
				if( !is_wp_error( $term ) ) {
					$output[] = array(
						'name' => $term->name,
						'link' => get_term_link( $term->term_id )
					);
				}
			}
		}

		return $output;
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
	public function get_location() {
		return $this->get_meta( 'location' ); 
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
	public function get_field_name( $key ) {
		return OPAL_JOB_METABOX_PREFIX.$key;
	}
}