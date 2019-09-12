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

use  Opal_Job\Common\Vendors\Opalmembership\Package_entity;
/**
 * @class OpalJob_Membership: as vendor class is using for processing logic with update/set permission for user submitting property.
 *
 * @version 1.0
 */
class Apply_Package_Handler {
	
	/**
	 * Class instance.
	 *
	 * @var User_Package instance
	 */
	protected static $instance = false;


	/**
	 * Class instance.
	 *
	 * @var User_Package instance
	 */
	protected $package; 

	/**
	 * Class instance.
	 *
	 * @var User_Package instance
	 */
	protected $user_id; 

	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */	
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
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
	public function register_admin_actions() {  
	 	
	 	// hook to filter show more options in user edit profile 
	 	add_filter( 'opaljob_admin_candidate_fields_options', array( $this, 'register_user_metabox') , 2, 1  );
	 	// hook to show options in package of membership.
	 	add_filter( 'opalmembership_postype_membership_metaboxes_fields', array( $this, 'register_package_metabox' ), 10 );
	 	add_action( 'profile_update' , array( $this, 'on_update_user' ), 10, 1 );	

	 	/**
		 *  Call Hook after updated membership information in user data.
		 */
		add_action( 'opalmembership_after_ mbership' , array( $this,'on_set_user_update_membership') , 10, 3 );
	}

	/**
	 * This function is called when payment status is completed. It will update new number of featured, listing for user.
	 *
	 * @return void
	 */
	public function on_set_user_update_membership(  $package_id, $user_id=0, $payment_id=0 ){
		if( Package_entity::get_package_type( $package_id ) == 'apply_job' ) {

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
	public function register_package_metabox( $fields ) {
		
		$prefix = OPALJOB_MEMBERSHIP_PREFIX;

		


		$fields[] = array(
			'name' => esc_html__( 'Number of View Listing', 'opaljob' ),
			'id'   => $prefix . 'package_view_listings',
			'type' => 'text',
			'attributes' => array(
				'type' 		=> 'number',
				'pattern' 	=> '\d*',
				'min'		=> 0
			),
			'std' => '1',
			'before_row' => '<div id="opaljob-package-apply_job" class="opaljob-target-show-container">',
			'description' => esc_html__( 'Number of jobs with this package. If not set it will be unlimited.', 'opaljob' )
		);

		$fields[] = array(
			'name' => esc_html__( 'Number Of Apply Listing', 'opaljob' ),
			'id'   => $prefix . 'package_apply_listings',
			'type' => 'text',
			'attributes' => array(
				'type' 		=> 'number',
				'pattern' 	=> '\d*',
				'min'		=> 0
			),
			'std' => '1',
			'description' => esc_html__( 'Number of jobs can make featured with this package.', 'opaljob' ),
			'after_row'   => '</div>'
		);

	

		return $fields;
	}
	/**
	 * Render Sidebar
	 *
	 * Hook in and add a metabox to add fields to the user profile pages
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function register_user_metabox( $settings ) {

		if( !defined("OPALJOB_MEMBERSHIP_PREFIX")  || !current_user_can( 'manage_options' )  ){
			return ;
		}

		$prefix = OPALMEMBERSHIP_USER_PREFIX_;
		$fields = array();
 
 		foreach( $fields as $field ){
			$cmb_user->add_field( $field  );
		}

		$fields = array();
		$date = null ;
		
		$current_user = wp_get_current_user();
		
		if( (isset($_GET['user_id']) && $_GET['user_id']) ){
			$user_id = (int)$_GET['user_id'];
		} else {
			$user_id = get_current_user_id();
		}

		$date = get_user_meta( $user_id, $prefix.'package_expired', true );


 	
 		$fields[] = array(
				'name' => esc_html__( 'Package', 'opaljob' ),
				'id'   => $prefix . 'package_id',
				'type' => 'text',
				'attributes' => array(
					'type' 		=> 'number',
					'pattern' 	=> '\d*',
					'min'		=> 0
				),
				'std' => '1',
				'description' => esc_html__( 'Set package ID with -1 as free package.', 'opaljob' ),
				'before_row' => '<hr><h3> '.__( 'Membership Information', 'opaljob' ).' </h3>'
			);


		 $fields[] = array(
			'name' => esc_html__( 'Number of View Listing', 'opaljob' ),
			'id'   => $prefix . 'package_view_listings',
			'type' => 'text',
			'attributes' => array(
				'type' 		=> 'number',
				'pattern' 	=> '\d*',
				'min'		=> 0
			),
			'std' => '1',
			'before_row' => '<div id="opaljob-package-apply_job" class="opaljob-target-show-container">',
			'description' => esc_html__( 'Number of jobs with this package. If not set it will be unlimited.', 'opaljob' )
		);

		$fields[] = array(
			'name' => esc_html__( 'Number Of Apply Listing', 'opaljob' ),
			'id'   => $prefix . 'package_apply_listings',
			'type' => 'text',
			'attributes' => array(
				'type' 		=> 'number',
				'pattern' 	=> '\d*',
				'min'		=> 0
			),
			'std' => '1',
			'description' => esc_html__( 'Number of jobs can make featured with this package.', 'opaljob' ),
			'after_row'   => '</div>'
		);
		//// //////	
		$settings['membership_field_options'] =  array(
			'id'        => 'membership_field_options',
			'title'     => esc_html__( 'Membership', 'opaljob' ),
			'icon-html' => '<span class="fa fa-users"></span>',
			'fields'    => $fields
		);

		return $settings;
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
	public function register_global_actions () {


	}
}