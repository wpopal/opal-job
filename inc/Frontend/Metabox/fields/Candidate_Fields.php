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
namespace Opal_Job\Frontend\Metabox\Fields;

use Opal_Job\Frontend\Metabox\Fields\User_Fields;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @author OPALWP
 */
class Candidate_Fields extends User_Fields {

	/**
	 * Callback function save
	 *
	 * All data of post parameters will be updated for each metadat of the post and stored in post_meta table
	 *
	 * @since    1.0.0
	 * @param string $post_id The id of current post.
	 * @param string $post The instance of Post having post typo opaljob
	 */
	public function get_base_fields(  ) {
		$prefix=OPAL_JOB_METABOX_PREFIX;
		return [
			[
				'name'   => esc_html__( 'Avatar Pictures', 'opal-job' ),
				'desc'   => esc_html__( 'This image will display in user detail and profile box information', 'opal-job' ),
				'id'     => $prefix . 'avatar',
				'type'   => 'file' ,
				'single'	  => true,
				'avatar' => true,
			],

			[
				'name'   => esc_html__( 'Banner', 'opal-job' ),
				'desc'   => esc_html__( 'This image will display in user detail and profile box information', 'opal-job' ),
				'id'     => $prefix . 'banner',
				'type'   =>  'file' ,
				'single'	  => true,
				'avatar' => true,
			],

			[
				'name'     => esc_html__( 'Specialism', 'opaljob' ),
				'desc'     => esc_html__( 'Select one, to add new you create in location of estate panel', 'opaljob' ),
				'id'       => $prefix . "specialism",
				'taxonomy' => 'opaljob_specialism', //Enter Taxonomy Slug
							"multiple" => true,
				'type'     => 'taxonomy_select',
			],

			[
				'name'       => esc_html__( 'Video', 'opaljob' ),
				'id'         => "{$prefix}video",
				'type'       => 'text',
				'required'	 => true		
			],
			[
				'name'       => esc_html__( 'Job Title', 'opaljob' ),
				'id'         => "{$prefix}job_title",
				'type'       => 'text',
				'required'	 => true		
			],
			[
				'name'       => esc_html__( 'Email', 'opaljob' ),
				'id'         => "{$prefix}email",
				'type'       => 'text',
			],
			[
				'name' => esc_html__( 'Website', 'opaljob' ),
				'id'   => "{$prefix}web",
				'type' => 'text_url',
			],
			[
				'name' => esc_html__( 'Phone', 'opaljob' ),
				'id'   => "{$prefix}phone",
				'type' => 'text',
			],

			[
				'name' => esc_html__( 'Mobile', 'opaljob' ),
				'id'   => "{$prefix}mobile",
				'type' => 'text',
			],

			[
				'name'      => esc_html__( 'Fax', 'opaljob' ),
				'id'        => "{$prefix}fax",
				'type'      => 'text',
			],
		];
	}

	/**
	 * Callback function save
	 *
	 * All data of post parameters will be updated for each metadat of the post and stored in post_meta table
	 *
	 * @since    1.0.0
	 * @param string $plugin_text_domain The text domain of this plugin.
	 */
	public  function get_fields( $type='' ) {
		$settings = [];

		$prefix = OPAL_JOB_METABOX_PREFIX;
		$post_id = 0;

		if( $type == 'resumecv' ) {
			return $this->get_cv_fields();
		} elseif( $type == 'resume' ) {
			return  $this->get_resume_fields();
		} else if( $type == 'changepassword' ){
			return $this->get_change_password_fields();
		}else {
			$settings = [

				/**
				 * Base Fields Settings
				 */
				'base_field_options'    => apply_filters( 'opaljob_base_field_options', [
					'id'        => 'base_field_options',
					'title'     => esc_html__( 'Information', 'opaljob' ),
					'icon-html' => '<span class="fa fa-info"></span>',
					'fields'    =>  $this->get_base_fields()
				] ),

				/**
				 * Base Fields Settings
				 */
				'address_field_options'    => apply_filters( 'opaljob_address_field_options', [
					'id'        => 'address_field_options',
					'title'     => esc_html__( 'Address', 'opaljob' ),
					'icon-html' => '<span class="fa fa-address-book"></span>',
					'fields'    =>  $this->get_address_fields()
				] ),

				/**
				 * Social Fields Settings
				 */
				'social_field_options'    => apply_filters( 'opaljob_social_field_options', [
					'id'        => 'social_field_options',
					'title'     => esc_html__( 'Social', 'opaljob' ),
					'icon-html' => '<span class="fa fa-share-alt-square"></span>',
					'fields'    =>  $this->get_social_fields()
				] )
			];
		}

/*
 		$settings = [
			'resume_field_options'    => apply_filters( 'opaljob_resume_field_options', [
				'id'        => 'resume_field_options',
				'title'     => esc_html__( 'Resume', 'opaljob' ),
				'icon-html' => '<span class="fa fa-heart"></span>',
				'fields'    =>  $this->get_resume_fields()
			] )
		];
 */
		return $settings;
	}	

	public function get_cv_fields () {
		$prefix = OPAL_JOB_METABOX_PREFIX;
		return apply_filters( 'opaljob_candidate_cv_fields', array(
			array(
				'name' => esc_html__( 'Docs CV', 'opaljob' ),
				'id'   => $prefix . 'cv_docs',
				'type' => 'file'
			),
			array(
				'name'       => esc_html__( 'Cover Letter', 'opaljob' ),
				'id'         => $prefix . 'cover_letter',
				'type'       => 'text' 
			) 
		) );
	}

	/**
	 * Callback function save
	 *
	 * All data of post parameters will be updated for each metadat of the post and stored in post_meta table
	 *
	 * @since    1.0.0
	 * @param string $plugin_text_domain The text domain of this plugin.
	 */
	public function get_resume_fields() {
		$prefix = OPAL_JOB_METABOX_PREFIX;
		$settings = array(); 
		// Award
		$settings[] = array(
			'id'            => $prefix . 'resume_award',
			'type'          => 'group',
			'options'       => array(
				'add_button'    => esc_html__( 'Award', 'opaljob' ),
				'header_title'  => esc_html__( 'Award #1', 'opaljob' ),
				'remove_button' => '<span class="dashicons dashicons-no"></span>',
			),
			'description'	=> 'Qualification',
			'name'	    => '<h2><i class="fa fa-trash"></i>  '.__( 'Award', 'opaljob' ).' </h2>',
			'fields'        => apply_filters( 'opaljob_candidate_resume_adward_fields', array(
				array(
					'name' => esc_html__( 'Award Name', 'opaljob' ),
					'id'   => $prefix . 'name',
					'type' => 'text'
				),
				array(
					'name'       => esc_html__( 'Select Year', 'opaljob' ),
					'id'         => $prefix . 'year',
					'type'       => 'date'
				),
				array(
					'name'       => esc_html__( 'Description', 'opaljob' ),
					'id'         => $prefix . 'description',
					'type'       => 'text' 
				) 
			) ),
		) ;
		// Education
	 	$settings[] = array(
			'id'            => $prefix . 'resume_education',
			'type'          => 'group',
			'options'       => array(
				'add_button'    => esc_html__( 'Education', 'opaljob' ),
				'header_title'  => esc_html__( 'Education #1', 'opaljob' ),
				'remove_button' => '<span class="dashicons dashicons-no"></span>',
			),
			'description'	=> 'Qualification',
			'name'	    => '<h2><i class="fa fa-trash"></i>  '. esc_html__( 'Education', 'opaljob' ).' </h2>',
			'fields'        => apply_filters( 'opaljob_candidate_resume_adward_fields', array(
				array(
					'name' => esc_html__( 'Award Name', 'opaljob' ),
					'id'   => $prefix . 'name',
					'type' => 'text',
				),
				array(
					'name'       => esc_html__( 'Start Date', 'opaljob' ),
					'id'         => $prefix . 'start_date',
					'type'       => 'date',
					'col'		 => '6 col-md-6'
				),
				array(
					'name'       => esc_html__( 'End Date', 'opaljob' ),
					'id'         => $prefix . 'end_date',
					'type'       => 'date',
					'col'		 => '6 col-md-6'
				),
				array(
					'name'       => esc_html__( 'Academy', 'opaljob' ),
					'id'         => $prefix . 'academy',
					'type'       => 'text' 
				), 
				array(
					'name'       => esc_html__( 'Description', 'opaljob' ),
					'id'         => $prefix . 'description',
					'type'       => 'textarea' 
				) 
			) ),
		) ;

		// Education
	 	$settings[] = array(
			'id'            => $prefix . 'resume_experience',
			'type'          => 'group',
			'options'       => array(
				'add_button'    => esc_html__( 'Experience', 'opaljob' ),
				'header_title'  => esc_html__( 'Experience #1', 'opaljob' ),
				'remove_button' => '<span class="dashicons dashicons-no"></span>',
			),
			'description'	=> 'Qualification',
			'name'	    => '<h2><i class="fa fa-trash"></i>  '. esc_html__( 'Experience', 'opaljob' ).' </h2>',
			'fields'        => apply_filters( 'opaljob_candidate_resume_adward_fields', array(
				array(
					'name' => esc_html__( 'Award Name', 'opaljob' ),
					'id'   => $prefix . 'name',
					'type' => 'text',
				),
				array(
					'name'       => esc_html__( 'Start Date', 'opaljob' ),
					'id'         => $prefix . 'start_date',
					'type'       => 'date',
					'col'		 => '6 col-md-6'
				),
				array(
					'name'       => esc_html__( 'End Date', 'opaljob' ),
					'id'         => $prefix . 'end_date',
					'type'       => 'date',
					'col'		 => '6 col-md-6'
				),
				array(
					'name'       => esc_html__( 'Company', 'opaljob' ),
					'id'         => $prefix . 'company',
					'type'       => 'text' 
				), 
				array(
					'name'       => esc_html__( 'Description', 'opaljob' ),
					'id'         => $prefix . 'description',
					'type'       => 'textarea' 
				) 
			) ),
		) ;

	 	// Portfolio
	 	$settings[] = array(
			'id'            => $prefix . 'resume_portfolio',
			'type'          => 'group',
			'options'       => array(
				'add_button'    => esc_html__( 'Portfolio', 'opaljob' ),
				'header_title'  => esc_html__( 'Portfolio #1', 'opaljob' ),
				'remove_button' => '<span class="dashicons dashicons-no"></span>',
			),
			'description'	=> 'Qualification',
			'name'	    => '<h2><i class="fa fa-trash"></i>  '. esc_html__( 'Portfolio', 'opaljob' ).' </h2>',
			'fields'        => apply_filters( 'opaljob_candidate_resume_portfolio_fields', array(
				array(
					'name'       => esc_html__( 'Title', 'opaljob' ),
					'id'         => $prefix . 'title',
					'type'       => 'text',
					'col'		 => '6 col-md-6'
				),
				array(
					'name'       => esc_html__( 'End Date', 'opaljob' ),
					'id'         => $prefix . 'banner_file',
					'type'       => 'file',
					'col'		 => '6 col-md-6'
				)
			) ),
		) ;

	 	// Skill
	 	$settings[] = array(
			'id'            => $prefix . 'resume_skill',
			'type'          => 'group',
			'options'       => array(
				'add_button'    => esc_html__( 'Skill', 'opaljob' ),
				'header_title'  => esc_html__( 'Skill #1', 'opaljob' ),
				'remove_button' => '<span class="dashicons dashicons-no"></span>',
			),
			'description'	=> 'Qualification',
			'name'	    => '<h2><i class="fa fa-trash"></i>  '. esc_html__( 'Skill', 'opaljob' ).' </h2>',
			'fields'        => apply_filters( 'opaljob_candidate_resume_skill_fields', array(
				array(
					'name'       => esc_html__( 'Title', 'opaljob' ),
					'id'         => $prefix . 'title',
					'type'       => 'text'
				),
				array(
					'name'       => esc_html__( 'Percentage', 'opaljob' ),
					'id'         => $prefix . 'percentage',
					'type'       => 'slider'
				)
			) ),
		) ;


		return $settings;
	}
}
?>