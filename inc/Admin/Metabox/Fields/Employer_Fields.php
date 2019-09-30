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
namespace Opal_Job\Admin\Metabox\Fields;

use Opal_Job\Admin\Metabox\Fields\User_Fields;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @author OPALWP
 */
class Employer_Fields extends User_Fields {
	
	/**
	 * Callback function save
	 *
	 * All data of post parameters will be updated for each metadat of the post and stored in post_meta table
	 *
	 * @since    1.0.0
	 * @param string $plugin_text_domain The text domain of this plugin.
	 */
	public  function get_fields() {
		$settings = [];

		$prefix = OPAL_JOB_METABOX_PREFIX;
		$post_id = 0;
		$settings = [

			/**
			 * Base Fields Settings
			 */
			'base_field_options'    => apply_filters( 'opaljob_base_field_options', [
				'id'        => 'base_field_options',
				'title'     => esc_html__( 'Information', 'opaljob' ),
				'icon-html' => '<span class="fa fa-heart"></span>',
				'fields'    =>  $this->get_base_fields()
			] ),

			/**
			 * Base Fields Settings
			 */
			'address_field_options'    => apply_filters( 'opaljob_address_field_options', [
				'id'        => 'address_field_options',
				'title'     => esc_html__( 'Address', 'opaljob' ),
				'icon-html' => '<span class="fa fa-heart"></span>',
				'fields'    =>  $this->get_address_fields()
			] ),

			/**
			 * Social Fields Settings
			 */
			'social_field_options'    => apply_filters( 'opaljob_social_field_options', [
				'id'        => 'social_field_options',
				'title'     => esc_html__( 'Social', 'opaljob' ),
				'icon-html' => '<span class="fa fa-heart"></span>',
				'fields'    =>  $this->get_social_fields()
			] ),


		];

		return apply_filters( "opaljob_admin_employer_fields_options", $settings );
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
	public function get_base_fields(  ) {

		$prefix=OPAL_JOB_METABOX_PREFIX;

		return [
			[
				'id'          => "{$prefix}featured",
				'name'        => esc_html__( 'Is Featured', 'opaljob' ),
				'type'        => 'switch',
				'description' => esc_html__( 'Set member as featured', 'opaljob' ),
				'options'     => [
					0 => esc_html__( 'No', 'opaljob' ),
					1 => esc_html__( 'Yes', 'opaljob' ),
				],
			],

			[
				'id'          => "{$prefix}trusted",
				'name'        => esc_html__( 'Trusted', 'opaljob' ),
				'type'        => 'switch',
				'description' => esc_html__( 'Set this member as Trusted Member', 'opaljob' ),
				'options'     => [
					0 => esc_html__( 'No', 'opaljob' ),
					1 => esc_html__( 'Yes', 'opaljob' ),
				],
			],
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
				'name'   => esc_html__( 'Gallery', 'opal-job' ),
				'desc'   => esc_html__( 'This image will display in user detail and profile box information', 'opal-job' ),
				'id'     => $prefix . 'gallery',
				'type'   =>  'file_list' ,
				'single' => true,
				'avatar' => true,
			],
			[
				'name'       => esc_html__( 'Video', 'opaljob' ),
				'id'         => "{$prefix}video",
				'type'       => 'text',
				'required'	 => true		
			],
			[
				'name'       => esc_html__( 'Company Name', 'opaljob' ),
				'id'         => "{$prefix}company",
				'type'       => 'text',
				'required'	 => true		
			],
			[
				'name'       => esc_html__( 'Slogan', 'opaljob' ),
				'id'         => "{$prefix}slogan",
				'type'       => 'text',
	
				'attributes'	 => [
					'required' => true
				]
			],

			[
				'name'       => esc_html__( 'Company Size', 'opaljob' ),
				'id'         => "{$prefix}company_size",
				'type'       => 'select',
				'options'	 => opaljob_get_company_sizes_options(),
				'attributes'	 => [
					'required' => true
				]
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
				'name'     => esc_html__( 'Tags', 'opaljob' ),
				'desc'     => esc_html__( 'Select one, to add new you create in location of estate panel', 'opaljob' ),
				'id'       => $prefix . "tags",
				'taxonomy' => 'opaljob_tag', //Enter Taxonomy Slug
				"multiple" => true,
				'type'     => 'taxonomy_select',
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
}
?>