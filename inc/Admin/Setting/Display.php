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
class Display extends Core\Metabox {

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function get_tab() {
		return array( 'id' => 'display', 'heading' => esc_html__('Display') );
	}

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function get_settings() {
		$prefix = OPAL_JOB_METABOX_PREFIX;
		$fields = array(
			array(
				'name'        => esc_html__( 'Donation Option', 'opaljob' ),
				'description' => esc_html__( 'Do you want this form to have one set donation price or multiple levels (for example, $10, $20, $50)?', 'opaljob' ),
				'id'          => $prefix . 'price_option2',
				'type'        => 'text',
				'default'     => '',
				'options'     => apply_filters( 'opaljob_price_options', array(
					'multi' => esc_html__( 'Multi-level Donation', 'opaljob' ),
					'set'   => esc_html__( 'Set Donation', 'opaljob' ),
				) ),
			),
		); 
		$settings = $fields;
		return $settings;
	}

}
