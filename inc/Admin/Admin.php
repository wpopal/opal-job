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
namespace Opal_Job\Admin;

use Opal_Job\Admin\Setting as Setting;
use Opal_Job\Libraries as Libraries;
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
class Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * The text domain of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_text_domain The text domain of this plugin.
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

		$this->plugin_name        = $plugin_name;
		$this->version            = $version;
		$this->plugin_text_domain = $plugin_text_domain;
	}

	public $settings_objs = [];

 
	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name . '_admin', OPAL_JOB_URL . 'assets/css/admin/admin.css', [], $this->version, 'all' );
		
		wp_enqueue_style( 'select2', OPAL_JOB_URL . 'assets/3rd/select2/css/select2.min.css', null, '4.0.7', false );
		wp_register_style( 'font-awesome', OPAL_JOB_URL . 'assets/3rd/font-awesome/css/all.min.css', [], '5.10.2' );
		wp_enqueue_style( 'font-awesome' );
		wp_register_style( 'hint', OPAL_JOB_URL . 'assets/3rd/hint.min.css', [], '2.6.0' );
		wp_enqueue_style( 'hint' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/*
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

		wp_enqueue_script( 'select2', OPAL_JOB_URL . 'assets/3rd/select2/js/select2.min.js', null, '4.0.7', false );
		wp_enqueue_script( 'opaljob-admin', OPAL_JOB_URL . 'assets/js/admin.js', null, '4.0.7', false );
		
		do_action( 'opaljob_admin_enqueue_scripts', $this );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		add_submenu_page(
			'edit.php?post_type=opaljob_job',
			apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'Settings', 'opaljob' ) ),
			apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Settings', 'opaljob' ) ),
			'manage_options',
			$this->plugin_name . '-settings',
			[ $this, 'page_options' ]
		);

		add_submenu_page(
			'edit.php?post_type=opaljob_job',
			apply_filters( $this->plugin_name . '-addons-page-title', esc_html__( 'Addons', 'opaljob' ) ),
			apply_filters( $this->plugin_name . '-addons-menu-title', esc_html__( 'Addons', 'opaljob' ) ),
			'manage_options',
			$this->plugin_name . '-addons',
			[ $this, 'page_addons' ]
		);
		remove_meta_box( 'authordiv', 'opaljob_job', 'normal' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	private function load_object_settings() {
		if ( empty( $this->settings_objs ) ) {
			$matching = apply_filters( 'opaljob_job_load_settings', [
				'general'     => Setting\General::class,
				'display'     => Setting\Display::class,
				'email'       => Setting\Email::class,
				'third_party' => Setting\Third_Party::class,
				'api_keys' 	  => Setting\API_Keys::class,
			] );

			foreach ( $matching as $match => $class ) {
				$object                        = new $class();
				$this->settings_objs[ $match ] = $object;
			}
		}

		return $this->settings_objs;
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function update_settings() {


		if ( isset( $_POST['save_page_options'] ) ) {
			$tab     = $this->get_tab_active();
			$objects = $this->load_object_settings();
			if ( isset( $objects[ $tab ] ) ) {

				$settings = $objects[ $tab ]->get_settings();
				$objects[ $tab ]->save_settings_options( $settings, 'opaljob_settings' );
			}
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	private function get_tab_active() {
		$tab = 'general';
		if ( isset( $_GET['tab'] ) && ! empty( $_GET['tab'] ) ) {
			$tab = trim( $_GET['tab'] );
		}

		return $tab;
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */


	public function page_options() {

		$matching   = $this->load_object_settings();
		$tab_active = $this->get_tab_active();

		echo '<div class="opaljob-settings-page">';
		echo '<div class="setting-tab-head"><ul class="inline-list">';
		foreach ( $matching as $match => $object ) {
			$tab = $object->get_tab();

			$tab_url = esc_url( add_query_arg( [
				'settings-updated' => false,
				'tab'              => $tab['id'],
				'subtab'           => false,
			] ) );

			$class = $tab['id'] == $tab_active ? ' class="active"' : "";

			echo '<li' . $class . '><a href="' . $tab_url . '" >' . $tab['heading'] . '</a></li>';
		}
		echo '</ul></div>';


		$form = Libraries\Form\Form::get_instance();

		$form->setup( 'page_options', 'opaljob_settings' );

		$args = [];

		echo '<form action="" method="post">';
		if ( isset( $matching[ $tab_active ] ) && isset( $this->settings_objs[ $tab_active ] ) ) {
			$object   = $this->settings_objs[ $tab_active ];
			$settings = $object->get_settings();
			echo $form->render( $args, $settings );
		}

		echo '<button class="btn btn-submit button button-primary" name="save_page_options" value="savedata" type="submit">' . esc_html__( 'Save' ) . '</button>';
		echo '</form>';

		echo '</div>';

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function page_addons() {

	}

}
