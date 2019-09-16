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
namespace Opal_Job\Admin\Metabox;

use Opal_Job\Core as Core;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @author OPALWP
 */
class Job_Metabox extends Core\Metabox {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param Avoid
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->set_types(
			[
				'opaljob_job',
			]
		);

		$this->metabox_id    = 'opaljob-metabox-form-data';
		$this->metabox_label = esc_html__( 'Options', 'opaljob' );
	}

	/**
	 * Callback function save
	 *
	 * All data of post parameters will be updated for each metadat of the post and stored in post_meta table
	 *
	 * @since    1.0.0
	 * @param string $post_id The id of current post.
	 * @param string $post The instance of Post having post typo opaljob
	 */
	public function save( $post_id, $post ) {

		// $post_id and $post are required.
		if ( empty( $post_id ) || empty( $post ) ) {
			return;
		}

		// Don't save meta boxes for revisions or autosaves.
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check user has permission to edit.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['opaljob_meta_nonce'] ) ) {
			$this->save_fields_data( 'post', $post_id );
		}
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
				'icon-html' => '<span class="fa fa-info-circle"></span>',
				'fields'    => $this->metaboxes_management_fields(),
			] ),

			/**
			 * Repeatable Field Groups
			 */
			'salary_field_options'    => apply_filters( 'opaljob_job_salary_field_options', [
				'id'        => 'salary_field_options',
				'title'     => esc_html__( 'Salary', 'opaljob' ),
				'icon-html' => '<span class="fa fa-money-check-alt"></span>',
				'fields'    =>  $this->metaboxes_salary_fields(),
			] ),

			/**
			 * Repeatable Field Groups
			 */
			'author_field_options'    => apply_filters( 'opaljob_job_author_field_options', [
				'id'        => 'author_field_options',
				'title'     => esc_html__( 'Author', 'opaljob' ),
				'icon-html' => '<span class="fa fa-user"></span>',
				'fields'    =>  $this->metaboxes_owner_fields(),
			] ),	
		];

		return apply_filters( "opaljob_job_fields_options", $settings );
	}

	/**
	 * Callback function save
	 *
	 * All data of post parameters will be updated for each metadat of the post and stored in post_meta table
	 *
	 * @since    1.0.0
	 * @param string $plugin_text_domain The text domain of this plugin.
	 */
	public function metaboxes_owner_fields () {
		$prefix = OPAL_JOB_METABOX_PREFIX;
		$fields = [
			[
				'name'    => esc_html__( 'Change Owner', 'opaljob' ),
				'id'      => $prefix . 'request_login',
				'type'    => 'switch',
				'options' => [
					0 => esc_html__( 'No', 'opaljob' ),
					1 => esc_html__( 'Yes', 'opaljob' ),
				],
				'default' => 0,
				'description' => esc_html__( 'Change Owner of this to other author', 'opaljob' ),
			],
			 
		];

		return apply_filters( 'opaljob_postype_job_salary_metaboxes_fields', $fields );
	}

	/**
	 * Callback function save
	 *
	 * All data of post parameters will be updated for each metadat of the post and stored in post_meta table
	 *
	 * @since    1.0.0
	 * @param string $plugin_text_domain The text domain of this plugin.
	 */
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
	 * Callback function save
	 *
	 * All data of post parameters will be updated for each metadat of the post and stored in post_meta table
	 *
	 * @since    1.0.0
	 * @param string $plugin_text_domain The text domain of this plugin.
	 */
	public function metaboxes_management_fields() {
		$prefix = OPAL_JOB_METABOX_PREFIX;
		$fields = [
			[
				'name'    => esc_html__( 'Featured', 'opaljob' ),
				'id'      => $prefix . 'featured',
				'type'    => 'switch',
				'options' => [
					0 => esc_html__( 'No', 'opaljob' ),
					1 => esc_html__( 'Yes', 'opaljob' ),
				],
				'default' => 0,
			],
			[
				'name'        => esc_html__( 'Job SKU', 'opaljob' ),
				'id'          => $prefix . 'sku',
				'type'        => 'text',
				'description' => esc_html__( 'Please Enter Your Job SKU', 'opaljob' ),
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
				'type'       => 'textarea_small',
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
			],

			[
				'name' => esc_html__( 'Postal Code / Zip', 'opaljob' ),
				'id'   => $prefix . 'zipcode',
				'type' => 'text',

			]
		];

		return apply_filters( 'opaljob_postype_job_information_metaboxes_fields', $fields );
	}
}
