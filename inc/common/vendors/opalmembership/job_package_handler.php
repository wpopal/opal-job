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
 * @class OpalJob_Membership: as vendor class is using for processing logic with update/set permission for user submitting job.
 *
 * @version 1.0
 */
class Job_Package_Handler {
	
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
	 	add_filter( 'opaljob_admin_employer_fields_options', array( $this, 'register_user_metabox') , 2, 1  );
	 	// hook to show options in package of membership.
	 	add_filter( 'opalmembership_postype_membership_metaboxes_fields', array( $this, 'register_package_metabox' ), 10 );

	 	add_action( 'profile_update' , array( $this, 'on_update_user' ), 10, 1 );	

	 	/**
		 *  Call Hook after updated membership information in user data.
		 */
		add_action( 'opalmembership_after_update_user_membership' , array( $this,'on_set_user_update_membership') , 10, 3 );

		// Check to see if user posted first time.
		add_action( 'transition_post_status', array( $this, 'update_pending_to_publish' ) , 99, 3 );
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


		$this->user_id = get_current_user_id(); 


		if( $this->user_id ){ 

			$package_id    =  $this->get_current_user_meta( 'package_id' );
			$this->package = new Package_entity( $package_id, $this->user_id );

			$this->hooks_process_submit_job();
	 	 	
			/**
			 * HOOK to Submssion Page: Check permission before submitting
			 */
			// check validation before
		//	add_action( 'opaljob/submision/render_submit_form/before'		 , array( $this, 'check_membership_validation' ), 1 );

		 	/**
			 *  Call Hook after updated membership information in user data.
			 */
			add_action( 'opalmembership_after_update_user_membership' , array( $this,'on_set_user_update_membership') , 10, 3 );

			add_action( 'opaljob/submision/render_submit_form/before'  	     , array( $this, 'check_membership_validation_message' ) );

			// hook actions logic 		
			add_action( 'opaljob/submission/process_new/edit'  , array( $this, 'check_edit_post' )  );
			add_action( 'opaljob/submission/process_new/before'   , array( $this, 'check_add_post' )  );
			/// check before uploading image
			
			/**
			 * HOOK to user management Menu
			 */
 
			// show in membership dashboard
		//	add_action( 'opalmembership_dashboard_container_before'		, array( $this, 'check_membership_validation_message' ) );
			// included logic functions
			add_action( 'opaljob_dashboard_employer_summary_middle_right' , array( $this, 'summary_middle_right' ) );
		}

		/**
		 * Hook to loop of package membership
		 */
		// add_action( 'opalmembership_content_single_before' 			, array( $this, 'render_membership_pricing_box' ) );
	}


	function update_pending_to_publish( $new, $old, $post ) {

	    if ( ( $new == 'publish' ) && ( $old != 'publish' ) && ( $post->post_type == 'opaljob_job' ) ) {
	        $this->update_user_post_date_expired( $post );
	    } else {
	    	return;
	    }
	}


	public function hooks_process_submit_job () {
			

			/**
			 * HOOK TO My Jobs Page Set action to check when user set job as featured.
			 */
			add_filter( 'opaljob_set_feature_job_checked'      , array( $this,'feature_job_checked')  );
			add_action( 'opaljob_toggle_featured_job_before'   , array( $this,'update_featured_remaining_listing'), 10, 2 );

			// update remaining listing
			add_action( 'opaljob/submission/process_new/after'		 , array( $this, 'update_remainng_listing' ) , 10, 3 );

			/**
			 * Hook to widget to show addition about current package.
			 */
			add_action( 'opalmembership_current_package_summary_after' , array( $this, 'render_membership_summary' ), 10, 2 );
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
		
		$prefix = OPALMEMBERSHIP_USER_PREFIX_;

		$fields[] = array(
			'name' => esc_html__( 'Package Type', 'opaljob' ),
			'id'   => $prefix . 'package_type',
			'type' => 'select',
			'options' => array(
				'submit_job' 		=> esc_html__( 'Employer Submit Job', 'opaljob' ),
				'apply_job' 		=> esc_html__( 'Candidate Apply Job', 'opaljob' ),
			),
			'std' => '1',
			'default' => 'submit_job',
			'before_row' => '<h3>' . esc_html__( 'Package Detail Configuration', 'opaljob' ) . '</h3><hr>',
			'description' => esc_html__( 'Number of jobs with this package. If not set it will be unlimited.', 'opaljob' )
		);


		$fields[] = array(
			'name' => esc_html__( 'Number Of Jobs', 'opaljob' ),
			'id'   => $prefix . 'package_listings',
			'type' => 'text',
			'attributes' => array(
				'type' 		=> 'number',
				'pattern' 	=> '\d*',
				'min'		=> 0
			),
			'std' => '1',
			'before_row' => '<div id="opaljob-package-submit_job" class="opaljob-target-show-container">',
			'description' => esc_html__( 'Number of jobs with this package. If not set it will be unlimited.', 'opaljob' )
		);

		$fields[] = array(
			'name' => esc_html__( 'Number Of Featured Jobs', 'opaljob' ),
			'id'   => $prefix . 'package_featured_listings',
			'type' => 'text',
			'attributes' => array(
				'type' 		=> 'number',
				'pattern' 	=> '\d*',
				'min'		=> 0
			),
			'std' => '1',
			'description' => esc_html__( 'Number of jobs can make featured with this package.', 'opaljob' )
		);

		$fields[] = array(
			'name' => esc_html__( ' Unlimited listings ?', 'opaljob' ),
			'id'   => $prefix . 'unlimited_listings',
			'type' => 'checkbox',
			'std'  => '1',
			'description' => esc_html__( 'No, it is not unlimited, If not set it will be unlimited. Number of jobs can make featured with this package.', 'opaljob' )
		);

		$fields[] = array(
				'name' => esc_html__( 'Listing Expired Date In', 'opalmembership' ),
				'id'   => "{$prefix}listing_expired",
				'type' => 'text',
				'attributes' => array(
					'type' 		=> 'number',
					'pattern' 	=> '\d*',
					'min'		=> 0
				),
				'std' => '1',
				'description' => esc_html__('Enter expired number. Example 1, 2, 3 to hide job','opalmembership')
			);

		$fields[] = array(
				'name' => esc_html__( 'Listing Expired Date Type', 'opalmembership' ),
				'id'   => "{$prefix}listing_duration_unit",
				'type' => 'select',
				'options' => opalmembership_package_expiry_labels(),
				'description' => esc_html__( 'Enter expired date type. Example Day(s), Week(s), Month(s), Year(s)', 'opalmembership' ),
				'after_row' => '</div>'
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
				'name' => esc_html__( 'Number Of Jobs', 'opaljob' ),
				'id'   => $prefix . 'package_listings',
				'type' => 'text',
				'attributes' => array(
					'type' 		=> 'number',
					'pattern' 	=> '\d*',
					'min'		=> 0
				),
				'std' => '1',
				'description' => esc_html__( 'Number of jobs with this package. If not set it will be unlimited.', 'opaljob' )
			);

		$fields[] = array(
			'name' => esc_html__( 'Number Of Featured Jobs', 'opaljob' ),
			'id'   => $prefix . 'package_featured_listings',
			'type' => 'text',
			'attributes' => array(
				'type' 		=> 'number',
				'pattern' 	=> '\d*',
				'min'		=> 0
			),
			'std' => '1',
			'description' => esc_html__( 'Number of jobs can make featured with this package.', 'opaljob' )
		);

		$fields[] = array(
			'name' => esc_html__( 'Expired', 'opaljob' ),
			'id'   => $prefix . 'package_expired_date',
			'type' => 'text',
			'default' => $date,
			'std' => '1',
			'description' => esc_html__( 'Show expired time in double format.', 'opaljob' )
		);

		$fields[] = array(
			'name' => esc_html__( 'Expired', 'opaljob' ),
			'id'   => $prefix . 'package_expired',
			'type' => 'date',
			'std' => '1',
			'description' => esc_html__( 'Show expired time in double format.', 'opaljob' )
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
	 * This function is called when payment status is completed. It will update new number of featured, listing for user.
	 *
	 * @return void
	 */
	public function on_set_user_update_membership(  $package_id, $user_id=0, $payment_id=0 ){

		if( Package_entity::get_package_type( $package_id ) == 'submit_job' ) {

		 	$this->package = new Package_entity( $package_id, $user_id );
			$this->user_id = $user_id;

			/**
			 * Get some information from selected package.
			 */
		    $pack_listings            = $this->package->get_package_listings(); 
		    $pack_featured_listings   = $this->package->get_package_featured_listings();
		    $is_unlimited_listings    = $this->package->get_package_unlimited_listings();

		    $pack_unlimited_listings  = $is_unlimited_listings == 'on' ? 1:0;

		  	/**
		  	 * Get package information with user logined
		  	 */
		    $current_listings           =  $this->package->get_user_package_listings();
		    $curent_featured_listings   =  $this->package->get_user_package_featured_listings();
		    $current_pack 				=  $this->package->get_actived_package();

		    $user_current_listings           = opaljob_get_user_current_listings ( $user_id ); // get user current listings ( no expired )
		    $user_current_featured_listings  = opaljob_get_user_current_featured_listings( $user_id ); // get user current featured listings ( no expired )

		    if( opaljob_check_package_downgrade_status( $user_id, $package_id ) ) {
		        $new_listings           =  $pack_listings;
		        $new_featured_listings  =  $pack_featured_listings;
		    }else{
		        $new_listings           =  $pack_listings - $user_current_listings ;
		        $new_featured_listings  =  $pack_featured_listings -  $user_current_featured_listings ;
		    }

		    // in case of downgrade
		    if( $new_listings < 0 ) {
		        $new_listings = 0;
		    }

		    if( $new_featured_listings < 0 ) {
		        $new_featured_listings = 0;
		    }


		    if ( $pack_unlimited_listings == 1 ) {
		        $new_listings = -1;
		    }
			
			$listing_expired_unit =  (int) $this->package->get_listing_expired_unit();

		    /**
		     * Update new number of packages listings and featured listing.
		     */ 
		    $this->update_user_meta( 'package_id', $package_id );
		    $this->update_user_meta( 'package_listings', $new_listings );
		    $this->update_user_meta( 'package_featured_listings', $new_featured_listings ); 
		    $this->update_user_meta( 'package_listing_expired_unit', $listing_expired_unit ); 
		}
	}

	/**
	 * This function is called when user set job as featured.
	 *
	 *  @return boolean. true is user having permission.
	 */
	private function update_user_meta( $key, $value ) {
		update_user_meta( $this->user_id, OPALMEMBERSHIP_USER_PREFIX_.$key, $value) ;	
	}

	/**
	 * This function is called when user set job as featured.
	 *
	 *  @return boolean. true is user having permission.
	 */
	public function feature_job_checked(){
		global $current_user;
	    wp_get_current_user();
	    $user_id =   $current_user->ID;

		if( isset($_POST['job_id']) ){
			return opaljob_get_user_featured_remaining_listing( $user_id );
		}
		return false;
	}


	/**
	 * Reduce -1 when set featured status is done.
	 *
	 */
	public function update_featured_remaining_listing( $user_id, $job_id ){
		opaljob_update_package_number_featured_listings(  $user_id );
	}

	/**
	 * Reduce -1 when set featured status is done.
	 *
	 */
	public function update_remainng_listing( $job_id , $isedit=true ){
	 
		opaljob_update_package_number_listings( $this->user_id );
		// update showing expired time
		$this->update_post_date_expired( $job_id );
		
	}

	public function update_user_post_date_expired ( $post ) {
		$time 	 = time();

		$unit 	 = get_user_meta( $post->post_author, OPALMEMBERSHIP_USER_PREFIX_.'package_listing_expired_unit', true );

		if( $unit ) {  
 
			$this->update_post_meta( $post->ID, 'expired_date', date( 'm/d/Y', intval($time+$unit) )  );
		}
	}

	public function update_post_date_expired ( $job_id ) {
		$time 	 = time();
		$unit 	 = $this->get_current_user_meta( 'package_listing_expired_unit' ); 
		if( $unit ) {
			$this->update_post_meta( $job_id, 'expired_date', date(  'm/d/Y', intval($time+$unit) )  );
		}
	}

	/**
	 * Hooked method to display more information about actived package.
	 *
	 */
	private function get_current_user_meta( $key ) {

		return get_user_meta( $this->user_id, OPALMEMBERSHIP_USER_PREFIX_.$key , true );
	}

	private function update_post_meta( $job_id, $key, $value ) {  
		 
		return update_post_meta( $job_id, OPAL_JOB_METABOX_PREFIX.$key, $value );
	}

	/**
	 * Hooked method to display more information about actived package.
	 *
	 */
	public function render_membership_summary ( $package_id=0, $payment_id=0 ){

		global $current_user;

		wp_get_current_user();
	 	$user_id = $current_user->ID;

		$this->package = new Package_entity( $package_id , $user_id );
		
	

		$current_listings           =  $this->package->get_user_package_listings();
	    $curent_featured_listings   =  $this->package->get_user_package_featured_listings();

	    ///
	  
	    $pack_unlimited_listings  = $this->package->get_package_unlimited_listings();
	    $unlimited_listings       =  $pack_unlimited_listings == 'on' ? 1 : 0;
	    ///

	    $output = '';
	    if( $unlimited_listings == 1 ){
	    	$output .= '<li><span>'.__('(Package) Listings Included:','opaljob').'</span> '.__( 'Unlimited', 'opaljob' ).'</span></li>';
	    	$output .= '<li><span>'.__('(Package) Featured Included:','opaljob').'</span> '.__( 'Unlimited', 'opaljob' ).'</li>';
	    }else { 
	    	$output .= '<li><span>'.__('Listings Remaining:','opaljob').'</span> <span class="text-primary">'.$current_listings.'</span></li>';
	    	$output .= '<li><span>'.__('Featured Remaining:','opaljob').'</span>  <span class="text-primary">'.$curent_featured_listings.'</span></li>';
	    }

	    echo $output;
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
	public function on_update_user( $user_id ) {
		 if( $user_id ){
		 	$prefix = OPALMEMBERSHIP_USER_PREFIX_;
		 	$field = $prefix.'package_expired_date'; 
		 	if( isset($_POST[$field]) && !empty($_POST[$field]) ) {
		 		$expired_time =  strtotime($_POST[$field]);
		 		$_POST[$prefix . 'package_expired'] = $expired_time;
			    update_user_meta( $user_id, $prefix.'package_expired', $expired_time );
		 	}
		 }
	}


	/**
	 * Check permission to allow creating any job. The package is not valid, it is automatic redirect to membership page.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function check_add_post(){

		global $current_user;
	    wp_get_current_user();
	    $user_id =   $current_user->ID;

		$has = opaljob_check_has_add_listing( $user_id );
		if( $has  == false ){
			wp_redirect( opalmembership_get_membership_page_uri( array('warning=2') ) ); exit;
		}
	}


	/**
	 * Check any action while editing page
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function check_edit_post(){
		return true;
	}


	/**
	 * Display membership warning at top of submission form.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function check_membership_validation_message(){

		global $current_user;
	    
	    wp_get_current_user();
	    
	    $user_id =   $current_user->ID;
	    if( isset($_GET['id']) && $_GET['id']  > 0 ){
	    	return ;
	    }

		echo opaljob_render_template( 'membership/warning', array('user_id' => $user_id) );
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
	public function render_membership_pricing_box(){
		echo opaljob_render_template( 'membership/pricing-info', array() );
	}

	public function summary_middle_right(){
		echo opaljob_render_template( 'membership/summary', array() );
	}
}