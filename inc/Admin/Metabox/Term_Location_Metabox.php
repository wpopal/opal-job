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
 * @author     WpOpal
 */
class Term_Location_Metabox extends Core\Metabox {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param Avoid
	 */
	public function __construct() {

		$this->set_types(
			[
				'opaljob_location',
			]
		);
		$this->mode = 'taxonomy';

		$this->metabox_id    = 'opaljob-metabox-form-data';
		$this->metabox_label = esc_html__( 'Options', 'opaljob' );
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

		$prefix   = OPAL_JOB_METABOX_PREFIX;
		$post_id  = '';
		$settings = apply_filters( 'opaljob_term_location_metabox_fields', [
			
			[
				'name'        => esc_html__( 'Image', 'opaljob' ),
				'description' => esc_html__( 'Set Background Images for this, it will used in widget', 'opaljob' ),
				'id'          => $prefix . 'image',
				'type'        => 'file',

			]
		] );

		return $settings;
	}
}
