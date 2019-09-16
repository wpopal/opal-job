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
namespace Opal_Job\Common\Integrations;

use Opal_Job\Common\interfaces\Intergration;
use Opal_Job\Libraries\Form_Builder\Ajax;
use Opal_Job\Libraries\Form_Builder\Create_Fields;

/**
 * Fired during plugin deactivation
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author     WpOpal
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @class   Form_Builder
 *
 * @version 1.0
 */
class Form_Builder implements Intergration {
	/**
	 * The ID.
	 *
	 * @var string
	 */
	public $id = 'form-builder';

	/**
	 * Register admin actions.
	 *
	 * @since 1.0
	 *
	 */
	public function register_admin_actions() {
		new Ajax();
		add_action( 'admin_init', [ $this, 'save_options' ] );
		add_action( "opaljob_admin_candidate_fields_options", [ $this, 'add_meta_candidate_fields'] , 9 ,1 );
		add_action( "opaljob_admin_employer_fields_options",  [ $this, 'add_meta_employer_fields'] , 9 ,1 );
		add_action( "opaljob_job_fields_options",  			  [ $this, 'add_job_fields'] , 9 ,1 );
	}

	/**
	 * Register frontend actions.
	 *
	 * @since 1.0
	 *
	 */
	public function register_frontend_actions() {
		if ( is_admin() ) {
			add_action( 'admin_menu', [ $this, 'admin_menu' ], 8 );
		}
	}

	/**
	 * Register admin sub-menu page.
	 *
	 * @since 1.0
	 *
	 */
	public function admin_menu() {
		add_submenu_page(
			'edit.php?post_type=opaljob_job',
			apply_filters( $this->id . '-settings-page-title', esc_html__( 'Meta Builder', 'opaljob' ) ),
			apply_filters( $this->id . '-settings-menu-title', esc_html__( 'Meta Builder', 'opaljob' ) ),
			'manage_options',
			$this->id . '-settings',
			[ $this, 'render_page' ]
		);
	}

	/**
	 * Register property types.
	 *
	 * @return array
	 */
	public function add_job_fields ( $settings ) {
		$option_key = 'opaljob_builder_job';
		$options = get_option( $option_key );

		if( !empty($options) ) {
			$settings['meta_builder_job'] = [
				'id'        => 'meta_builder_job',
				'title'     => esc_html__( 'Meta data', 'opaljob' ),
				'icon-html' => '<span class="fa fa-server"></span>',
				'fields'    => $options
			];
		}
		return $settings;
	}

	/**
	 * Register property types.
	 *
	 * @return array
	 */
	public function add_meta_candidate_fields ( $settings ) {
		$option_key = 'opaljob_builder_candidate';
		$options = get_option( $option_key );

		if( !empty($options) ) {
			$settings['candidate_meta_builder_fields'] = [
				'id'        => 'candidate_meta_builder_fields',
				'title'     => esc_html__( 'Meta data', 'opaljob' ),
				'icon-html' => '<span class="fa fa-server"></span>',
				'fields'    => $options
			];
		}
		return $settings;
	}

	/**
	 * Register property types.
	 *
	 * @return array
	 */
	public function add_meta_employer_fields ( $settings ) {
		$option_key = 'opaljob_builder_employer';
		$options = get_option( $option_key );

		if( !empty($options) ) {
			$settings['employer_meta_builder_fields'] = [
				'id'        => 'employer_meta_builder_fields',
				'title'     => esc_html__( 'Meta data', 'opaljob' ),
				'icon-html' => '<span class="fa fa-server"></span>',
				'fields'    => $options
			];
		}
		return $settings;
	}
	
	/**
	 * Register property types.
	 *
	 * @return array
	 */
	public function get_property_types() {
		return apply_filters( 'opaljob_get_form_builder_types', [
			'job'       => esc_html__( 'Job Meta Property', 'opaljob' ),
			'employer'  => esc_html__( 'Employer Meta Property', 'opaljob' ),
			'candidate' => esc_html__( 'Candidate Meta Property', 'opaljob' ),
		] );
	}

	/**
	 * Save options.
	 *
	 * Handler options and save them.
	 *
	 * @since 1.0
	 *
	 */
	public function save_options() {
		$matching = $this->get_property_types();

		$tab_active = isset( $_GET['tab'] ) ? trim( $_GET['tab'] ) : 'job';

		if ( ! array_key_exists( $tab_active, $matching ) ) {
			return;
		}

		$option_key = 'opaljob_builder_' . $tab_active;

		$form = new Create_Fields( $option_key );
		$form->save();
	}

	/**
	 * Render page.
	 *
	 * Display page with tabs.
	 *
	 * @since 1.0
	 *
	 */
	public function render_page() {
		$matching = $this->get_property_types();

		$tab_active = isset( $_GET['tab'] ) ? trim( $_GET['tab'] ) : 'job';

		if ( ! array_key_exists( $tab_active, $matching ) ) {
			return;
		}

		echo '<div class="opaljob-settings-page">';
		echo '<p class="opaljob-settings-page-desc">' . esc_html__( 'Property builder using for show', 'opaljob' ) . '</p>';
		echo '<div class="setting-tab-head"><ul class="inline-list">';

		foreach ( $matching as $match => $tab ) {
			$tab_url = esc_url( add_query_arg( [
				'settings-updated' => false,
				'tab'              => $match,
				'subtab'           => false,
			] ) );

			$class = $match == $tab_active ? ' class="active"' : "";

			echo '<li' . $class . '><a href="' . $tab_url . '" >' . $tab . '</a></li>';
		}
		echo '</ul></div>';

		$option_key = 'opaljob_builder_' . $tab_active;

		$form = new Create_Fields( $option_key );
		$form->render();

		echo '</div>';
	}
}
