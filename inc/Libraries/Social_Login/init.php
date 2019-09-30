<?php

namespace Opal_Job\Libraries\Social_Login;

class Init {
	public function __construct() {
		add_action( 'opaljob_member_after_login_form', [ $this, 'login_template' ] );
		add_action( 'opalelementor_after_render_login_form', [ $this, 'login_template' ] );

		if ( is_admin() ) {
			add_filter( 'opaljob_settings_3rd_party_subtabs_nav', [ $this, 'register_admin_setting_tab' ], 1 );
			add_filter( 'opaljob_settings_3rd_party_subtabs_social_login_fields', [ $this, 'register_admin_settings' ], 10, 1 );
		}

		$this->inludes();
		$this->process();
	}

	public function inludes() {
		require_once 'class-opaljob-facebook-login.php';
		require_once 'class-opaljob-google-login.php';
	}

	public function process() {
		new Facebook_Login();
		new Google_Login();
	}

	public function login_template() {
		echo opaljob_load_template_path( 'user/social-login/social-login' );
	}

	public function register_admin_setting_tab( $tabs ) {
		$tabs['social_login'] = esc_html__( 'Social Login', 'opaljob' );

		return $tabs;
	}

	public function register_admin_settings( $fields ) {
		$fields = apply_filters( 'opaljob_settings_review', [
			[
				'name'      => esc_html__( 'Google', 'opaljob' ),
				'desc'      => '',
				'type'      => 'opaljob_title',
				'id'        => 'opaljob_title_general_settings_google',
				'after_row' => '<hr>',
			],
			[
				'name'    => esc_html__( 'Enable Google login', 'opaljob' ),
				'desc'    => esc_html__( 'Enable Google login', 'opaljob' ),
				'id'      => 'enable_google_login',
				'type'    => 'switch',
				'options' => [
					'on'  => esc_html__( 'Enable', 'opaljob' ),
					'off' => esc_html__( 'Disable', 'opaljob' ),
				],
				'default' => 'off',
			],
			[
				'name' => esc_html__( 'Google Client ID', 'opaljob' ),
				'desc' => esc_html__( 'Google Client ID is required for Google Login.', 'opaljob' ),
				'id'   => 'google_client_id',
				'type' => 'text',
			],
			[
				'name' => esc_html__( 'Google Client Secret', 'opaljob' ),
				'desc' => esc_html__( 'Google Client Secret is required for Google Login.', 'opaljob' ),
				'id'   => 'google_client_secret',
				'type' => 'text',
			],
			[
				'name' => esc_html__( 'Google API key', 'opaljob' ),
				'desc' => esc_html__( 'Google API key is required for Google Login.', 'opaljob' ),
				'id'   => 'google_api_key',
				'type' => 'text',
			],
			[
				'name'       => esc_html__( 'Facebook', 'opaljob' ),
				'desc'       => '',
				'type'       => 'opaljob_title',
				'id'         => 'opaljob_title_general_settings_facebook',
				'before_row' => '<hr>',
				'after_row'  => '<hr>',
			],
			[
				'name'    => esc_html__( 'Enable Facebook login', 'opaljob' ),
				'desc'    => esc_html__( 'Enable Facebook login', 'opaljob' ),
				'id'      => 'enable_facebook_login',
				'type'    => 'switch',
				'options' => [
					'on'  => esc_html__( 'Enable', 'opaljob' ),
					'off' => esc_html__( 'Disable', 'opaljob' ),
				],
				'default' => 'off',
			],
			[
				'name' => esc_html__( 'Facebook Application ID', 'opaljob' ),
				'desc' => esc_html__( 'Facebook Application ID is required for Facebook login.', 'opaljob' ),
				'id'   => 'facebook_app_id',
				'type' => 'text',
			],
			[
				'name' => esc_html__( 'Facebook Secret', 'opaljob' ),
				'desc' => esc_html__( 'Facebook Secret is required for Facebook login.', 'opaljob' ),
				'id'   => 'facebook_secret',
				'type' => 'text',
			],
		] );

		return $fields;
	}

	/**
	 * Gets redirect URL.
	 *
	 * @return mixed|void
	 */
	public static function get_redirect_url() {
		if ( isset( $_GET['redirect_to'] ) && $_GET['redirect_to'] != '' ) {
			$redirect = get_permalink( sanitize_text_field( $_GET['redirect_to'] ) );
		} else {
			$redirect = esc_url( home_url( '/' ) );
		}

		return apply_filters( 'opal_social_login_redirect_to', $redirect );
	}
}

new Init();
