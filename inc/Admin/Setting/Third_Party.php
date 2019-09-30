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
namespace Opal_Job\Admin\Setting;
 
use Opal_Job\Core as Core;
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author    WpOpal
 */
class Third_Party extends Core\Metabox {

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function get_tab() {
		return array( 'id' => 'third_party', 'heading' => esc_html__('Third Party') );
	}

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function get_settings() {
		$prefix = '';
		$post_id = 0;
		$settings = apply_filters( "opaljob/settings/third_party/page_options", [] , 3 );

		$fields  = array(
			array(
				'name'    => esc_html__( 'Google Map API', 'opaljob' ),
				'desc'    => __( 'You need to register <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Google API Key</a>, then put the key in this setting.',
					'opaljob' ),
				'id'      => 'google_map_api_keys',
				'type'    => 'text',
				'default' => 'AIzaSyCfMVNIa7khIqYHCw6VBn8ShUWWm4tjbG8',
			)
		);	

		$settings['form_gmap_field_options'] =  apply_filters( 'form_gmap_field_options', array(
			'id'        => 'form_gmap_field_options',
			'title'     => esc_html__( 'Google Map Options', 'opaljob' ),
			'icon-html' => '<span class="opaljob-icon opaljob-icon-heart"></span>',
			'fields'    => $fields 
		));

		return $settings;
	}

}
