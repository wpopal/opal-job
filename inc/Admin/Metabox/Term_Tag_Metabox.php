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
class Term_Tag_Metabox extends Core\Metabox {

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {

		$this->set_types(
			[
				'opaljob_tag',
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
	 * @param string $plugin_text_domain The text domain of this plugin.
	 * @since    1.0.0
	 */
	public function get_settings() {
		$prefix   = OPAL_JOB_METABOX_PREFIX;
		$settings = apply_filters( 'opaljob_term_tag_metabox_fields', [
			[
				'name'         => esc_html__( 'Image', 'opaljob' ),
				'description'  => esc_html__( 'Set an image.', 'opaljob' ),
				'id'           => $prefix . 'image',
				'type'         => 'file',
				'default'      => '',
				'preview_size' => 'small',
				'options'      => [
					'url' => false,
				],
			],
			[
				'name'        => esc_html__( 'Icon', 'opaljob' ),
				'description' => esc_html__( 'Set an icon.', 'opaljob' ),
				'id'          => $prefix . 'icon',
				'type'        => 'iconpicker',
			],
		] );

		return $settings;
	}
}
