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
use  Opal_Job\Admin\Table\Api_Table;

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
class API_Keys extends Core\Metabox {

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function get_tab() {
		return array( 'id' => 'api_keys', 'heading' => esc_html__('API Keys') );
	}

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function get_settings() {


		$settings = apply_filters( "opaljob/settings/api_keys/page_options", [] , 3 );
		
		add_action( 'opaljob_form_render_field_api_tables', [$this,'api_tables'] );

		$fields  =  apply_filters( 'opaljob_settings_api',[
					[
						'id'   => 'api_keys',
						'name' => esc_html__( 'API', 'opaljob' ),
						'type' => 'api_tables',
					],
				]
		);

		return $fields;
	}


	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function api_tables() {
		
		if ( ! current_user_can( 'manage_opaljob_settings' ) ) {
			return;
		}

		do_action( 'opaljob_tools_api_keys_keys_before' );

		$keys_table_list = new Api_Table();
		$keys_table_list->prepare_items();

		echo '<input type="hidden" name="page" value="wc-settings" />';
		echo '<input type="hidden" name="tab" value="api" />';
		echo '<input type="hidden" name="section" value="keys" />';

		$keys_table_list->views();
		$keys_table_list->search_box( __( 'Search Key', 'woocommerce' ), 'key' );
		$keys_table_list->display();
		?>

		<style>
			.opaljob_properties_page_opaljob-settings .opaljob-submit-wrap {
				display: none; /* Hide Save settings button on System Info Tab (not needed) */
			}
		</style>
		<?php

		do_action( 'opaljob_tools_api_keys_keys_after' );

	}
}
