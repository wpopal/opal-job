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

/**
 * Register all actions and filters for the plugin
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author     WpOpal
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 */
class Roles {
	/**
	 * Get things going
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_filter( 'opaljob_map_meta_cap', [ $this, 'meta_caps' ], 10, 4 );
	}

	/**
	 * Add new shop roles with default WP caps
	 *
	 * @access public
	 * @return void
	 * @since  1.0.0
	 */
	public function add_roles() {
		add_role( 'opaljob_manager', esc_html__( 'Opal Job Manager', 'opaljob' ), [
			'read'                   => true,
			'edit_posts'             => true,
			'delete_posts'           => true,
			'unfiltered_html'        => true,
			'upload_files'           => true,
			'export'                 => true,
			'import'                 => true,
			'delete_others_pages'    => true,
			'delete_others_posts'    => true,
			'delete_pages'           => true,
			'delete_private_pages'   => true,
			'delete_private_posts'   => true,
			'delete_published_pages' => true,
			'delete_published_posts' => true,
			'edit_others_pages'      => true,
			'edit_others_posts'      => true,
			'edit_pages'             => true,
			'edit_private_pages'     => true,
			'edit_private_posts'     => true,
			'edit_published_pages'   => true,
			'edit_published_posts'   => true,
			'manage_categories'      => true,
			'manage_links'           => true,
			'moderate_comments'      => true,
			'publish_pages'          => true,
			'publish_posts'          => true,
			'read_private_pages'     => true,
			'read_private_posts'     => true,
		] );

		add_role( 'opaljob_employer', esc_html__( 'Opal Job Employer', 'opaljob' ), [
			'read'               => true,
			'edit_posts'         => false,
			'upload_files'       => true,
			'delete_posts'       => false,
			'publish_posts'      => false,
			'edit_attachments'   => true,
			'delete_attachments' => true,
			'delete_post'        => true,
		] );

		add_role( 'opaljob_candidate', esc_html__( 'Opal Job Candicate', 'opaljob' ), [
			'read'          => true,
			'edit_posts'    => false,
			'upload_files'  => true,
			'delete_posts'  => false,
			'publish_posts' => false,
		] );

	}

	/**
	 * Add new shop-specific capabilities
	 *
	 * @access public
	 * @return void
	 * @global \WP_Roles $wp_roles
	 * @since  1.0.0
	 */
	public function add_caps() {
		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) ) {
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
		}

		if ( is_object( $wp_roles ) ) {
			$wp_roles->add_cap( 'opaljob_manager', 'view_opaljob_reports' );
			$wp_roles->add_cap( 'opaljob_manager', 'view_opaljob_sensitive_data' );
			$wp_roles->add_cap( 'opaljob_manager', 'export_opaljob_reports' );
			$wp_roles->add_cap( 'opaljob_manager', 'manage_opaljob_settings' );

			$wp_roles->add_cap( 'administrator', 'view_opaljob_reports' );
			$wp_roles->add_cap( 'administrator', 'view_opaljob_sensitive_data' );
			$wp_roles->add_cap( 'administrator', 'export_opaljob_reports' );
			$wp_roles->add_cap( 'administrator', 'manage_opaljob_settings' );

			// Add the main post type capabilities
			$capabilities = $this->get_core_caps();
			foreach ( $capabilities as $cap_group ) {
				foreach ( $cap_group as $cap ) {
					$wp_roles->add_cap( 'opaljob_manager', $cap );
					$wp_roles->add_cap( 'administrator', $cap );
					$wp_roles->add_cap( 'opaljob_employer', $cap );
					$wp_roles->add_cap( 'opaljob_candidate', $cap );
				}
			}

			$wp_roles->add_cap( 'opaljob_accountant', 'edit_opaljob_jobs' );
			$wp_roles->add_cap( 'opaljob_accountant', 'read_private_forms' );
			$wp_roles->add_cap( 'opaljob_accountant', 'view_opaljob_reports' );
			$wp_roles->add_cap( 'opaljob_accountant', 'export_opaljob_reports' );
			$wp_roles->add_cap( 'opaljob_accountant', 'edit_opaljob_payments' );

		}
	}

	/**
	 * Gets the core post type capabilities
	 *
	 * @access public
	 * @return array $capabilities Core post type capabilities
	 * @since  1.0.0
	 */
	public function get_core_caps() {
		$capabilities = [];

		$capability_types = [ 'opaljob_jobs', 'opaljob_employers' ];

		foreach ( $capability_types as $capability_type ) {
			$capabilities[ $capability_type ] = [
				// Post type
				"edit_{$capability_type}",
				"read_{$capability_type}",
				"delete_{$capability_type}",
				"edit_{$capability_type}s",
				"edit_others_{$capability_type}s",
				"publish_{$capability_type}s",
				"read_private_{$capability_type}s",
				"delete_{$capability_type}s",
				"delete_private_{$capability_type}s",
				"delete_published_{$capability_type}s",
				"delete_others_{$capability_type}s",
				"edit_private_{$capability_type}s",
				"edit_published_{$capability_type}s",

				// Terms
				"manage_{$capability_type}_terms",
				"edit_{$capability_type}_terms",
				"delete_{$capability_type}_terms",
				"assign_{$capability_type}_terms",

				// Custom
				"view_{$capability_type}_stats",
			];
		}

		return $capabilities;
	}

	/**
	 * Map meta caps to primitive caps
	 *
	 * @access public
	 * @return array $caps
	 * @since  1.0
	 */
	public function meta_caps( $caps, $cap, $user_id, $args ) {

		switch ( $cap ) {

			case 'view_opaljob_jobs_stats' :

				if ( empty( $args[0] ) ) {
					break;
				}

				$form = get_post( $args[0] );
				if ( empty( $form ) ) {
					break;
				}

				if ( user_can( $user_id, 'view_opaljob_reports' ) || $user_id == $form->post_author ) {
					$caps = [];
				}

				break;
		}

		return $caps;

	}

	/**
	 * Remove core post type capabilities (called on uninstall)
	 *
	 * @access public
	 * @return void
	 * @since  1.0
	 */
	public function remove_caps() {

		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) ) {
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
		}

		if ( is_object( $wp_roles ) ) {
			/** Opalestate Manager Capabilities */
			$wp_roles->remove_cap( 'opaljob_manager', 'view_opaljob_reports' );
			$wp_roles->remove_cap( 'opaljob_manager', 'view_opaljob_sensitive_data' );
			$wp_roles->remove_cap( 'opaljob_manager', 'export_opaljob_reports' );
			$wp_roles->remove_cap( 'opaljob_manager', 'manage_opaljob_settings' );

			/** Site Administrator Capabilities */
			$wp_roles->remove_cap( 'administrator', 'view_opaljob_reports' );
			$wp_roles->remove_cap( 'administrator', 'view_opaljob_sensitive_data' );
			$wp_roles->remove_cap( 'administrator', 'export_opaljob_reports' );
			$wp_roles->remove_cap( 'administrator', 'manage_opaljob_settings' );

			/** Remove the Main Post Type Capabilities */
			$capabilities = $this->get_core_caps();

			foreach ( $capabilities as $cap_group ) {
				foreach ( $cap_group as $cap ) {
					$wp_roles->remove_cap( 'opaljob_manager', $cap );
					$wp_roles->remove_cap( 'administrator', $cap );
					$wp_roles->remove_cap( 'opaljob_employer', $cap );
					$wp_roles->remove_cap( 'opaljob_candidate', $cap );
				}
			}

			/** Shop Accountant Capabilities */
			$wp_roles->remove_cap( 'opaljob_accountant', 'edit_opaljob_jobs' );
			$wp_roles->remove_cap( 'opaljob_accountant', 'read_private_forms' );
			$wp_roles->remove_cap( 'opaljob_accountant', 'view_opaljob_reports' );
			$wp_roles->remove_cap( 'opaljob_accountant', 'export_opaljob_reports' );
		}
	}
}
