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
namespace Opal_Job\Frontend;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author    WpOpal
 */
class Enqueue {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The text domain of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_text_domain    The text domain of this plugin.
	 */
	private $plugin_text_domain;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since       1.0.0
	 * @param       string $plugin_name        The name of this plugin.
	 * @param       string $version            The version of this plugin.
	 * @param       string $plugin_text_domain The text domain of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_text_domain ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_text_domain = $plugin_text_domain;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, OPAL_JOB_URL . 'assets/css/frontend/frontend.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, OPAL_JOB_URL . 'assets/js/frontend.js', array( 'jquery' ), $this->version, false );

		$this->register_3rd(); 

		wp_localize_script( $this->plugin_name, 'opaljobJS',
		[
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'siteurl'    => get_template_directory_uri(),
			'mapiconurl' => OPAL_JOB_URL . 'assets/map/',
			'rtl'        => is_rtl() ? 'true' : 'false',
			'confirmed'	 =>  esc_html__( 'Are you sure to remove?', 'opaljob' ),
			'error_upload_size'  =>  esc_html__( 'This file is has large volume size, please try to upload other.', 'opaljob' ),
			'size_image'  => opaljob_options( 'upload_image_max_size', 0.5 )*1000000,
			'mfile_image' => opaljob_options( 'upload_image_max_files', 10 ),
			'size_other'  => opaljob_options( 'upload_other_max_size', 0.8 )*1000000,
			'mfile_other' => opaljob_options( 'upload_other_max_files', 10 )
		] );
		
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function register_3rd(){

		wp_register_script(
			'jquery-modernizr',
			OPAL_JOB_URL . '/assets/3rd/magnific-popup/jquery.magnific-popup.min.js',
			[
				'jquery',
			],
			'4.4.3',
			true
		);
		wp_enqueue_script( 'jquery-magnific-popup' );

		// register using 3rd javascript libs
		wp_register_script( 'jquery-sticky-kit', 
			trailingslashit( OPAL_JOB_URL ) . 'assets/3rd/sticky/jquery.sticky-kit.min.js',
			[],  
			null, 
			true 
		);


		wp_register_script( 'jquery-toast',
			OPAL_JOB_URL . 'assets/3rd/toast/jquery.toast.js', 
			[],  
			null, 
			true 
		);

		wp_enqueue_script( 'jquery-toast' );

		 //1. load jquery swiper javascript libs
        wp_register_script(
            'jquery-swiper',
            OPAL_JOB_URL . '/assets/3rd/swiper/js/swiper.min.js',
            [
                'jquery',
            ],
            '4.4.3',
            true
        );

        wp_enqueue_script( 'jquery-swiper' );

		wp_enqueue_style( 'select2',
			OPAL_JOB_URL . 'assets/3rd/select2/css/select2.min.css', 
			null, 
			'4.0.7', 
			false 
		);
		wp_enqueue_script( 'select2', 
			OPAL_JOB_URL . 'assets/3rd/select2/js/select2.min.js', 
			null, 
			'4.0.7', 
			false 
		);

		/// maps google ////
		wp_enqueue_script( 'opaljob-google-maps', 
			$this->get_map_api_uri(), 
			null, 
			'0.0.1', 
			false );

		wp_register_script( 'infobox', 
			OPAL_JOB_URL . 'assets/js/infobox.js', 
			[ 'jquery' ], 
			1.0, 
			false
		);

		wp_register_script( 'markerclusterer', 
			OPAL_JOB_URL . 'assets/js/markerclusterer.js', 
			[ 'jquery' ], 
			'1.3', 
			false 
		);

		/// tooltipster /// 
		wp_enqueue_style( 'tooltipster',
			OPAL_JOB_URL . 'assets/3rd/tooltipster/css/tooltipster.bundle.min.css', 
			null, 
			'4.0.7', 
			false 
		);
		wp_enqueue_script( 'tooltipster', 
			OPAL_JOB_URL . 'assets/3rd/tooltipster/js/tooltipster.bundle.min.js', 
			null, 
			'4.0.7', 
			false 
		);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function get_map_api_uri() {

		$key = opaljob_options( 'google_map_api_keys' ) ?
			opaljob_options( 'google_map_api_keys' ) : 'AIzaSyAvJkbm23fhVAYcbdeVB0nkHjZmDeZ62bc';

		$api = 'https://maps.googleapis.com/maps/api/js?key=' . $key . '&libraries=geometry,places,drawing&ver=5.2.2';
		$api = apply_filters( 'opaljob_google_map_api_uri', $api );

		return $api;
	}
}
