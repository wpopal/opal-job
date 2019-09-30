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
 * @author     WpOpal
 */
class General extends Core\Metabox {

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function get_tab() {
		return [ 'id' => 'general', 'heading' => esc_html__( 'General' ) ];
	}

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function get_settings() {

		$settings = [];

		$prefix = OPAL_JOB_METABOX_PREFIX;

		$settings = [
			/**
			 * Repeatable Field Groups
			 */
			'listing_field_options'    => apply_filters( 'opaljob_isting_field_options', [
				'id'        => 'listing_field_options',
				'title'     => esc_html__( 'General Options', 'opaljob' ),
				'icon-html' => '<span class="opaljob-icon opaljob-icon-heart"></span>',
				'fields'    => apply_filters( 'opaljob_donation_form_metabox_fields', [
					// Display Style.
					[
						'name'        => esc_html__( 'Listing Per Page', 'opaljob' ),
						'description' => esc_html__( 'Number of job listings to display per page.', 'opaljob' ),
						'id'          => $prefix . 'listing_per_page',
						'type'        => 'text',
						'default'     => '10'
					],
					[
						'name'        => esc_html__( 'Hide Expired Listings', 'opaljob' ),
						'description' => esc_html__( 'Expired job listings will not be searchable.', 'opaljob' ),
						'id'          => $prefix . 'listing_hide_expired',
						'type'        => 'switch',
						'default'     => 'on'
					],
					[
						'name'        => esc_html__( 'Hide Expired Listings Content', 'opaljob' ),
						'description' => esc_html__( 'Hide content in expired single job listings.', 'opaljob' ),
						'id'          => $prefix . 'listing_hide_single_expired',
						'type'        => 'switch',
						'default'     => 'on'
					],
					[
						'name'        => esc_html__( 'Hide Expired Listings Content', 'opaljob' ),
						'id'          => $prefix . 'listing_hide_single_expired',
						'type'        => 'html',
						'content'	  => '<h4>'.esc_html__( 'Currency Setting.', 'opaljob' ).'</h4>'
					],
					[
						'name'        => esc_html__( 'Default Currency', 'opaljob' ),
						'description' => esc_html__( 'Set currency as default global.', 'opaljob' ),
						'id'          => $prefix . 'currency',
						'type'        => 'select',
						'options'	  => opaljob_get_currencies_options () 
					],
					[
						'name'        => esc_html__( 'Support Currencies', 'opaljob' ),
						'description' => esc_html__( 'Set multiple currencies allowing employer posting job select expected currency', 'opaljob' ),
						'id'          => $prefix . 'supported_currency',
						'type'        => 'select',
						'multiple'	  => true,
						'options'	  => opaljob_get_currencies_options () 
					]
				] ),
			] ),
			'pages_field_options'    => apply_filters( 'opaljob_pages_field_options', [
				'id'        => 'pages_field_options',
				'title'     => esc_html__( 'Page Options', 'opaljob' ),
				'icon-html' => '<span class="opaljob-icon opaljob-icon-heart"></span>',
				'fields'    => $this->get_pages_fields(),
			] ),
		];

		return $settings;
	}

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	private function get_pages_fields () {

		$prefix = OPAL_JOB_METABOX_PREFIX;
		
		return apply_filters( 'opaljob_donation_form_metabox_fields', [
					// Display Style.
			[
				'name'        => esc_html__( 'Dashboard Page', 'opaljob' ),
				'description' => esc_html__( 'Select the page where you\'ve used the [opaljob_dashboard] shortcode. This lets the plugin know the location of the form.', 'opaljob' ),
				'id'          => $prefix . 'dashboard_page',
				'type'        => 'page_select',
				'default'     => ''
			],
			[
				'name'        => esc_html__( 'Search Page', 'opaljob' ),
				'description' => esc_html__( 'Select the page where you\'ve used the [opaljob_search] shortcode. This lets the plugin know the location of the form.', 'opaljob' ),
				'id'          => $prefix . 'search_page',
				'type'        => 'page_select',
				'default'     => ''
			],
			[
				'name'        => esc_html__( 'Submission Page', 'opaljob' ),
				'description' => esc_html__( 'Select the page where you\'ve used the [opaljob_submission] shortcode. This lets the plugin know the location of the form.', 'opaljob' ),
				'id'          => $prefix . 'submission_page',
				'type'        => 'page_select',
				'default'     => ''
			]
		]);
	}
}
