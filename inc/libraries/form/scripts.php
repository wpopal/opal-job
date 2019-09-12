<?php
namespace Opal_Job\Libraries\Form;

use Opal_Job\Libraries\Form\Field\File;
use Opal_Job\Libraries\Form\Field\Map;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles the dependencies and enqueueing of the Opaljob JS scripts
 *
 * @package   Opaljob
 * @author    Opal team
 */
class Scripts {

	/**
	 * The Opaljob JS handle
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	protected static $handle = 'opaljob-form';

	/**
	 * The Opaljob JS variable name
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	protected static $js_variable = 'opalJob_l10';

	/**
	 * Array of Opaljob JS dependencies
	 *
	 * @var   array
	 * @since 1.0.0
	 */
	protected static $dependencies = [
		'jquery' => 'jquery',
	];

	/**
	 * Array of Opaljob fields model data for JS.
	 *
	 * @var   array
	 * @since 1.0.0
	 */
	protected static $fields = [];

	/**
	 * Add a dependency to the array of Opaljob JS dependencies
	 *
	 * @param array|string $dependencies Array (or string) of dependencies to add.
	 * @since 1.0.0
	 */
	public static function add_dependencies( $dependencies ) {
		foreach ( (array) $dependencies as $dependency ) {
			static::$dependencies[ $dependency ] = $dependency;
		}
	}

	/**
	 * Enqueue the form CSS
	 *
	 * @since  1.0.0
	 */
	public static function enqueue_styles() {
		
		$url = strtolower( plugin_dir_url( __FILE__ )  );
		// Iconpicker.
		wp_register_style( 'fonticonpicker', $url . '/assets/3rd/font-iconpicker/css/jquery.fonticonpicker.min.css' );
		wp_register_style( 'fonticonpicker-grey-theme', $url . '/assets/3rd/font-iconpicker/themes/grey-theme/jquery.fonticonpicker.grey.min.css' );

		wp_enqueue_style( 'fonticonpicker' );
		wp_enqueue_style( 'fonticonpicker-grey-theme' );

		// Enqueue CSS.
		wp_enqueue_style( static::$handle, $url . 'assets/css/form.css', [], OPAL_JOB_VERSION );
	}

	/**
	 * Enqueue the form JS
	 *
	 * @since  1.0.0
	 */
	public static function enqueue_scripts() {
		// Filter required script dependencies.
		$dependencies = static::$dependencies = apply_filters( 'opaljob_script_dependencies', static::$dependencies );

		// Only use minified files if SCRIPT_DEBUG is off.
		$debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;

		// if colorpicker.
		// if ( isset( $dependencies['wp-color-picker'] ) ) {
		//
		// }

		if ( ! is_admin() ) {
			static::colorpicker_frontend();
		}

		// if file/file_list.
		// if ( isset( $dependencies['media-editor'] ) ) {
		wp_enqueue_media();
		
		// }

		$dependencies = [ 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'media-editor' ];

		if ( is_admin() ) {
			$dependencies[] = 'wp-color-picker';
		}

		// Iconpicker.
		wp_register_script( 'fonticonpicker', plugin_dir_url( __FILE__ ) . 'assets/3rd/font-iconpicker/jquery.fonticonpicker.min.js', [ 'jquery' ], '2.0.0', false );

		// Enqueue JS.
		wp_enqueue_script( static::$handle, plugin_dir_url( __FILE__ ) . 'assets/js/form.js', $dependencies, OPAL_JOB_VERSION, true );

		static::localize( $debug );

		do_action( 'opaljob_footer_enqueue' );
		add_action( 'wp_footer', array( __CLASS__, 'load_template_script' ) );
	}


	public static function load_template_script () {
		File::output_js_underscore_templates();
	}

	/**
	 * Localize the php variables for Opaljob JS
	 *
	 * @param mixed $debug Whether or not we are debugging.
	 * @since  1.0.0
	 *
	 */
	protected static function localize( $debug ) {
		static $localized = false;
		if ( $localized ) {
			return;
		}

		$localized = true;
		$l10n      = [
			'script_debug'      => $debug,
			'up_arrow_class'    => 'dashicons dashicons-arrow-up-alt2',
			'down_arrow_class'  => 'dashicons dashicons-arrow-down-alt2',
			'user_can_richedit' => user_can_richedit(),
			'defaults'          => [
				'code_editor'  => false,
				'color_picker' => false,
				'date_picker'  => [
					'changeMonth'     => true,
					'changeYear'      => true,
					'dateFormat'      => _x( 'mm/dd/yy', 'Valid formatDate string for jquery-ui datepicker', 'opaljob' ),
					'dayNames'        => explode( ',', esc_html__( 'Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday', 'opaljob' ) ),
					'dayNamesMin'     => explode( ',', esc_html__( 'Su, Mo, Tu, We, Th, Fr, Sa', 'opaljob' ) ),
					'dayNamesShort'   => explode( ',', esc_html__( 'Sun, Mon, Tue, Wed, Thu, Fri, Sat', 'opaljob' ) ),
					'monthNames'      => explode( ',', esc_html__( 'January, February, March, April, May, June, July, August, September, October, November, December', 'opaljob' ) ),
					'monthNamesShort' => explode( ',', esc_html__( 'Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec', 'opaljob' ) ),
					'nextText'        => esc_html__( 'Next', 'opaljob' ),
					'prevText'        => esc_html__( 'Prev', 'opaljob' ),
					'currentText'     => esc_html__( 'Today', 'opaljob' ),
					'closeText'       => esc_html__( 'Done', 'opaljob' ),
					'clearText'       => esc_html__( 'Clear', 'opaljob' ),
				],
			],
			'strings'           => [
				'upload_file'  => esc_html__( 'Use this file', 'opaljob' ),
				'upload_files' => esc_html__( 'Use these files', 'opaljob' ),
				'remove_image' => esc_html__( 'Remove Image', 'opaljob' ),
				'remove_file'  => esc_html__( 'Remove', 'opaljob' ),
				'file'         => esc_html__( 'File:', 'opaljob' ),
				'download'     => esc_html__( 'Download', 'opaljob' ),
				'check_toggle' => esc_html__( 'Select / Deselect All', 'opaljob' ),
			],
		];

		if ( isset( static::$dependencies['code-editor'] ) && function_exists( 'wp_enqueue_code_editor' ) ) {
			$l10n['defaults']['code_editor'] = wp_enqueue_code_editor( [
				'type' => 'text/html',
			] );
		}

		$url = strtolower( plugin_dir_url( __FILE__ ) ); 

		wp_register_script( 'opaljob-google-maps', Map::get_map_api_uri(), null, OPAL_JOB_VERSION, false );
		wp_register_script( 'opaljob-google-maps-js', $url . 'assets/js/google.js', [], OPAL_JOB_VERSION );

		wp_register_script( 'opaljob-uploader-js', $url . 'assets/js/uploader.js', [], OPAL_JOB_VERSION );

		wp_localize_script( static::$handle, static::$js_variable, apply_filters( 'opaljob_localized_data', $l10n ) );
	}

	/**
	 * We need to register colorpicker on the front-end
	 *
	 * @since  1.0.0
	 */
	public static function colorpicker_frontend() {
		wp_register_script( 'iris', admin_url( 'js/iris.min.js' ), [ 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ], OPAL_JOB_VERSION );
		wp_register_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), [ 'iris' ], OPAL_JOB_VERSION );
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', [
			'clear'         => esc_html__( 'Clear', 'opaljob' ),
			'defaultString' => esc_html__( 'Default', 'opaljob' ),
			'pick'          => esc_html__( 'Select Color', 'opaljob' ),
			'current'       => esc_html__( 'Current Color', 'opaljob' ),
		] );
	}
}
