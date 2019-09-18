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
namespace Opal_Job\Core;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use ReflectionClass;
use Opal_Job\Admin\Admin;
use Opal_Job\Core\Template_Loader;
use Opal_Job\Admin\Metabox as Metabox;
use Opal_Job\Common\Posttypes;
use Opal_Job\Common\Taxonomies;
use Opal_Job\Frontend\Enqueue;
use Opal_Job\Frontend\Controller as Controller;
use Opal_Job\Common\Shortcodes as Shortcodes;

use Opal_Job\Common\Integrations\Favorite;
use Opal_Job\Common\Interfaces\Intergration;

use Opal_Job\Libraries\User_Rating\User_Rating;

/**
 * The core plugin class.
 * Defines internationalization, admin-specific hooks, and public-facing site hooks.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author     WpOpal
 */
class Init {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @var      Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_base_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_basename;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * The text domain of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $plugin_text_domain;

	/**
	 * Initialize and define the core functionality of the plugin.
	 */
	public function __construct() {

		$this->plugin_name        = OPAL_JOB;
		$this->version            = OPAL_JOB_VERSION;
		$this->plugin_basename    = OPAL_JOB_PLUGIN_BASENAME;
		$this->plugin_text_domain = OPAL_JOB_PLUGIN_TEXT_DOMAIN;

		$this->load_dependencies();
		$this->set_locale();

		$this->define_global_init();

		if ( is_admin() ) {
			$this->define_admin_hooks();
		} else {
			$this->define_frontend_hooks();
		}

		$this->define_intergrations();

		// Test user rating.
		new User_Rating();
	}

	/**
	 * Loads the following required dependencies for this plugin.
	 *
	 * - Loader - Orchestrates the hooks of the plugin.
	 * - Internationalization_I18n - Defines internationalization functionality.
	 * - Admin - Defines all hooks for the admin area.
	 * - Frontend - Defines all hooks for the public side of the site.
	 *
	 * @access    private
	 */
	private function load_dependencies() {
		$this->loader = new Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Internationalization_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @access    private
	 */
	private function set_locale() {

		$plugin_i18n = new Internationalization_I18n( $this->plugin_text_domain );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
		$this->loader->add_action( 'plugins_loaded', $this, 'load_vendors' );
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Internationalization_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @access    private
	 */
	public function define_intergrations() {

		// define list of intergration to make rich features
		$intergrations = [
			'Recaptcha',
			'Favorite',
			'Form_Builder',
			'Email',
			'User_Overrider',
		];

		foreach ( $intergrations as $intergration ) {
			$class  = "Opal_Job\\Common\\Integrations\\" . $intergration;
			$object = new   $class();
			if ( $object instanceof Intergration ) {
				$this->loader->add_action( 'init', $object, 'register_frontend_actions', 1, 2 );
				$this->loader->add_action( 'admin_init', $object, 'register_admin_actions', 1, 2 );
			}
		}

		// load intergration from vendors which working with 3rd 
		/// if emable opal-membership is enabled

	}

	public function load_vendors() {
		if ( class_exists( 'OpalMembership' ) ) {
			$class  = "Opal_Job\\Common\\Vendors\\Opalmembership\\Membership";
			$object = new   $class();
			if ( $object instanceof Intergration ) {

				if ( is_admin() ) {
					$object->register_admin_actions();
				}
				$object->register_frontend_actions();
				// $this->loader->add_action( 'init', $object, 'register_frontend_actions'  );
				// $this->loader->add_action( 'admin_init', $object, 'register_admin_actions'  );
			}
		}
	}


	/**
	 * Define Taxonomies and Postypes Using for global
	 *
	 * Uses the Internationalization_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @access    private
	 */
	private function define_global_init() {

		$taxomoies = new Taxonomies();
		$posttypes = new Posttypes();

		$template = new Template_Loader();

		$this->loader->add_action( 'init', $taxomoies, 'definition' );
		$this->loader->add_action( 'init', $posttypes, 'definition' );


		$this->loader->add_filter( 'template_include', $template, 'template', 3 );
		$this->loader->add_filter( 'template_include', $template, 'load_custom_pages', 3 );
		$this->loader->add_filter( 'theme_page_templates', $template, 'register_custom_pages', 10, 4 );

		//// 
		///
		///
		/// 
		//// custom set user permission ////  

		///
		///
		///
		$this->load_shortcodes_hooks();


		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			$this->load_controller( "User@register_ajax_hook_callbacks" );
			$this->load_controller( "Job@register_ajax_hook_callbacks" );
			$this->load_controller( "Email@register_ajax_hook_callbacks" );
			$this->load_controller( "Submission@register_ajax_hook_callbacks" );
		}
	}

	/**
	 * Define Taxonomies and Postypes Using for global
	 *
	 * Uses the Internationalization_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @access    private
	 */
	public function define_controllers() {

		if ( is_user_logged_in() ) {
			$this->load_controller( "Dashboard@register_hook_callbacks" );
		}

		$controllers = [
			'user'       => 'User@register_hook_callbacks',
			'email'      => 'Email@register_hook_callbacks',
			'submission' => "Submission@register_hook_callbacks",
			'job'        => 'Job@register_hook_callbacks',
		];

		foreach ( $controllers as $kye => $class ) {
			$this->load_controller( $class );
		}
	}

	/**
	 * Define Taxonomies and Postypes Using for global
	 *
	 * Uses the Internationalization_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @access    private
	 */
	public function load_controller( $call ) {
		@list( $controller, $action ) = explode( '@', $call );
		$controller = "\Opal_Job\Frontend\Controller\\" . $controller;
		$object     = $controller::get_instance();
		$object->{$action}();
	}

	/**
	 * Define Metabox fields for Post Types and Taxonomies
	 *
	 * Uses the Internationalization_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @access    private
	 */
	private function define_admin_metabox() {

		// register post type metabox
		$metaboxes = [
			'admin/metabox/job'           => Metabox\Job_Metabox::class,
			'admin/metabox/term_type'     => Metabox\Term_Type_Metabox::class,
			'admin/metabox/term_category' => Metabox\Term_Category_Metabox::class,
			'admin/metabox/term_tag'      => Metabox\Term_Tag_Metabox::class,
			'admin/metabox/term_location' => Metabox\Term_Location_Metabox::class,
			'admin/metabox/user'          => Metabox\User_Metabox::class,
		];

		// register metaxbox for custom post type ; 
		foreach ( $metaboxes as $key => $metabox_class ) {

			$metabox = ( new $metabox_class() );

			if ( $metabox->get_mode() == 'taxonomy' ) {

				// disable
				if ( isset( $_GET['taxonomy'] ) ) {
					foreach ( $metabox->get_types() as $item ) {
						$this->loader->add_action( $item . '_edit_form', $metabox, 'output', 10, 2 );
						$this->loader->add_action( $item . '_add_form_fields', $metabox, 'output', 10, 2 );
					}
				}
				$this->loader->add_action( 'created_term', $metabox, 'save', 10, 3 );
				$this->loader->add_action( 'edited_terms', $metabox, 'save_', 10, 3 );

				$this->loader->add_action( 'edited_terms', $metabox, 'delete', 10, 3 );

				add_action( 'created_term', [ $metabox, 'save_term' ], 10, 3 );
				add_action( 'edited_terms', [ $metabox, 'save_term' ], 10, 2 );
				add_action( 'delete_term', [ $metabox, 'delete' ], 10, 3 );

			} elseif ( $metabox->get_mode() == 'user' ) {

				add_action( 'show_user_profile', [ $metabox, 'output' ], 10 );
				add_action( 'edit_user_profile', [ $metabox, 'output' ], 10 );

				add_action( 'personal_options_update', [ $metabox, 'save' ] );
				add_action( 'edit_user_profile_update', [ $metabox, 'save' ] );

			} else {

				foreach ( $metabox->get_types() as $item ) {
					$this->loader->add_action( 'add_meta_boxes_' . $item, $metabox, 'setup' );
					$this->loader->add_action( 'save_post_' . $item, $metabox, 'save', 10, 2 );
				}
			}
		}
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @access    private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Admin( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'update_settings' );


		$this->define_admin_metabox();
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @access    public
	 */
	public function define_frontend_hooks() {

		$plugin_public = new Enqueue( $this->get_plugin_name(),
			$this->get_version(), $this->get_plugin_text_domain()
		);

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $this, 'define_controllers', 3 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @access    private
	 */
	private function load_shortcodes_hooks() {

		// load shortcodes
		$shortcodes = [
			'user' => Shortcodes\User::class,
			'job'  => Shortcodes\Job::class,
		];

		foreach ( $shortcodes as $tag => $class ) {
			$object = ( new ReflectionClass( $class ) )->newInstance();
			$object->register();
		}
	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the text domain of the plugin.
	 *
	 * @return    string    The text domain of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_text_domain() {
		return $this->plugin_text_domain;
	}

}
