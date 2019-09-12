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
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @author OPALWP
 */
class User_Fields {

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

		return $settings;
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
	public function get_address_fields(   ) {
		$prefix=OPAL_JOB_METABOX_PREFIX;
		return [
			[
				'name'     => esc_html__( 'Location', 'opaljob' ),
				'desc'     => esc_html__( 'Select one, to add new you create in location of estate panel', 'opaljob' ),
				'id'       => $prefix . "location",
				'taxonomy' => 'opaljob_location', //Enter Taxonomy Slug
				'type'     => 'taxonomy_select',
			],
	 
			[
				'name'       => esc_html__( 'Address', 'opaljob' ),
				'id'         => "{$prefix}address",
				'type'       => 'text',
				'attributes' => [
					'required' => 'required',
				],
			],
			[
				'id'              => "{$prefix}map",
				'name'            => esc_html__( 'Map Location', 'opaljob' ),
				'type'            => 'map',
				'sanitization_cb' => 'opal_map_sanitise',
				'split_values'    => true,
				'attributes'      => [
					'required' => 'required',
				],
			],
		];
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
				'name'   => esc_html__( 'Avatar Pictures', 'cmb2' ),
				'desc'   => esc_html__( 'This image will display in user detail and profile box information', 'cmb2' ),
				'id'     => $prefix . 'avatar',
				'type'   => 'file' ,
				'single'	  => true,
				'avatar' => true,
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
	 * @param string $post_id The id of current post.
	 * @param string $post The instance of Post having post typo opaljob
	 */
	public function get_social_fields( ) {
		$prefix = OPAL_JOB_METABOX_PREFIX; 
		return [
			[
				'name' => esc_html__( 'Twitter', 'opaljob' ),
				'id'   => "{$prefix}twitter",
				'type' => 'text_url',
				'before_row' => '<div class="field-row-2">',
			],

			[
				'name' => esc_html__( 'Facebook', 'opaljob' ),
				'id'   => "{$prefix}facebook",
				'type' => 'text_url',
			],

			[
				'name' => esc_html__( 'Google', 'opaljob' ),
				'id'   => "{$prefix}google",
				'type' => 'text_url',
			],

			[
				'name' => esc_html__( 'LinkedIn', 'opaljob' ),
				'id'   => "{$prefix}linkedin",
				'type' => 'text_url',
			],

			[
				'name' => esc_html__( 'Pinterest', 'opaljob' ),
				'id'   => "{$prefix}pinterest",
				'type' => 'text_url',
			],
			[
				'name' => esc_html__( 'Instagram', 'opaljob' ),
				'id'   => "{$prefix}instagram",
				'type' => 'text_url',
				'after_row' => '</div>'
			],
		];
	}	
}
?>