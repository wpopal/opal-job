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
namespace Opal_Job\Frontend\Metabox;
 
use Opal_Job\Core;

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
class Job_Metabox extends Core\Metabox {
	

	/**
	 * Hook Update Save Post Data
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function save( $user_id, $post ) {
		return $this->save_user_options( $user_id );
	}

	/**
	 * Callback function save
	 *
	 * All data of post parameters will be updated for each metadat of the post and stored in post_meta table
	 *
	 * @since    1.0.0
	 * @param string $plugin_text_domain The text domain of this plugin.
	 */
	public function get_settings() {
 
		$settings = [];

		$prefix = OPAL_JOB_METABOX_PREFIX;
		$post_id = 0;
		$settings = [

			/**
			 * Repeatable Field Groups
			 */
			'info_field_options'    => apply_filters( 'opaljob_job_info_field_options', [
				'id'        => 'info_field_options',
				'title'     => esc_html__( 'Information', 'opaljob' ),
				'icon-html' => '<span class="fa fa-heart"></span>',
				'fields'    => $this->metaboxes_management_fields(),
			] ),

			/**
			 * Repeatable Field Groups
			 */
			'salary_field_options'    => apply_filters( 'opaljob_job_salary_field_options', [
				'id'        => 'salary_field_options',
				'title'     => esc_html__( 'Salary', 'opaljob' ),
				'icon-html' => '<span class="fa fa-heart"></span>',
				'fields'    =>  $this->metaboxes_salary_fields(),
			] )	
		];

		return apply_filters( "opaljob_job_fields_options", $settings );
	}


	public function metaboxes_salary_fields () {
		$prefix = OPAL_JOB_METABOX_PREFIX;
		$fields = [
			[
				'name'    => esc_html__( 'Required Login To View', 'opaljob' ),
				'id'      => $prefix . 'request_login',
				'type'    => 'switch',
				'options' => [
					0 => esc_html__( 'No', 'opaljob' ),
					1 => esc_html__( 'Yes', 'opaljob' ),
				],
				'default' => 0,
				'description' => esc_html__( 'Only Show when user logined', 'opaljob' ),
			],
			[
				'name'        => esc_html__( 'Salary From', 'opaljob' ),
				'id'          => $prefix . 'salary_from',
				'type'        => 'text',
				'description' => esc_html__( 'Please Enter Your Job SKU', 'opaljob' ),
			],
			[
				'name'        => esc_html__( 'Salary To', 'opaljob' ),
				'id'          => $prefix . 'salary_to',
				'type'        => 'text',
				'description' => esc_html__( 'Please Enter Your Job SKU', 'opaljob' ),
			],
			[
				'name'        => esc_html__( 'Currency', 'opaljob' ),
				'id'          => $prefix . 'currency',
				'type'        => 'text',
				'description' => esc_html__( 'Please Enter Your Job SKU', 'opaljob' ),
			],
			[
				'name'        => esc_html__( 'For', 'opaljob' ),
				'id'          => $prefix . 'for_unit',
				'type'        => 'select',
				'options'	  => array( 
					'hour'   => esc_html__( 'Per Hour', 'opaljob' ), 
					'day'  	 => esc_html__( 'Per Day', 'opaljob' ), 
					'month'  => esc_html__( 'Per Month', 'opaljob' ), 
				),
				'description' => esc_html__( 'Please Enter Your Job SKU', 'opaljob' ),
			],
			 
		];

		return apply_filters( 'opaljob_postype_job_salary_metaboxes_fields', $fields );
	}

	/**
	 *
	 */
	public function metaboxes_management_fields() {

		$prefix = OPAL_JOB_METABOX_PREFIX;

		$data = array(
			'title' => '',
			'content'	 => ''
		);
		
		if( $this->object_id ) {
			$post = get_post( $this->object_id );
			if( !is_wp_error($post) && $post ) {  
				$data['title'] = $post->post_title;
				$data['content'] = $post->post_content;
			}
		}

		$fields = [
			[
				'id'          => 'post_id',
				'type'        => 'hidden',
				'default'		  => $this->object_id
			],
			[
				'name'        => esc_html__( 'Title', 'opaljob' ),
				'id'          => $prefix . 'title',
				'type'        => 'text',
				'description' => esc_html__( 'Please Enter Your Job Title', 'opaljob' ),
				'default'	  => $data['title']
			],
			[
				'name'        => esc_html__( 'Description', 'opaljob' ),
				'id'          => $prefix . 'text',
				'type'        => 'textarea_small',
				'description' => esc_html__( 'Please Enter Your Job Content', 'opaljob' ),
				'default'	  => $data['content']
			],
			[
				'name'        => esc_html__( 'Job SKU', 'opaljob' ),
				'id'          => $prefix . 'sku',
				'type'        => 'text',
				'description' => esc_html__( 'Please Enter Your Job SKU', 'opaljob' ),
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
				'name'     => esc_html__( 'Categories', 'opaljob' ),
				'desc'     => esc_html__( 'Select one, to add new you create in location of estate panel', 'opaljob' ),
				'id'       => $prefix . "category",
				'taxonomy' => 'opaljob_category', //Enter Taxonomy Slug
				"multiple" => true,
				'type'     => 'taxonomy_select',
			],
			[
				'name'        => esc_html__( 'Expired Date', 'opaljob' ),
				'id'          => $prefix . 'expired_date',
				'type'        => 'date',
				'description' => esc_html__( 'Please Enter Your Job SKU', 'opaljob' ),
			],
			[
				'name'        => esc_html__( 'Application Deadline Date', 'opaljob' ),
				'id'          => $prefix . 'deadline_date',
				'type'        => 'date',
				'description' => esc_html__( 'Please Enter Your Job SKU', 'opaljob' ),
			],
			[
				'name'        => esc_html__( 'External URL', 'opaljob' ),
				'id'          => $prefix . 'external_url',
				'type'        => 'text_url',
				'description' => esc_html__( 'Please Enter Your Job SKU', 'opaljob' ),
			],
			[
				'id'          => "{$prefix}video",
				'name'        => esc_html__( 'Video', 'opaljob' ),
				'type'        => 'text_url',
				'description' => esc_html__( 'Input for videos, audios from Youtube, Vimeo and all supported sites by WordPress. It has preview feature.', 'opaljob' ),
			],
			[
				'name'       => esc_html__( 'Address', 'opaljob' ),
				'id'         => $prefix . 'address',
				'type'       => 'text',
				'attributes' => [
					'required' => 'required',
				],
			],
			[
				'name'     => esc_html__( 'Location', 'opaljob' ),
				'desc'     => esc_html__( 'Select one, to add new you create in location of estate panel', 'opaljob' ),
				'id'       => $prefix . "location",
				'taxonomy' => 'opaljob_location', //Enter Taxonomy Slug
				"multiple" => true,
				'type'     => 'taxonomy_select',
			],
			[
				'name'       => esc_html__( 'Post Code', 'opaljob' ),
				'id'         => $prefix . 'postcode',
				'type'       => 'text',
				'attributes' => [
					'required' => 'required',
				],
			],
			[
				'id'              => $prefix . 'map',
				'name'            => esc_html__( 'Location', 'opaljob' ),
				'type'            => 'map',
				'sanitization_cb' => 'opal_map_sanitise',
				'split_values'    => true,
			]
		];

		return apply_filters( 'opaljob_postype_job_information_metaboxes_fields', $fields );
	}
}
