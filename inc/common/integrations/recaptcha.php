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

use Opal_Job\Common\Interfaces\Intergration; 
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
 * @class   Recaptcha
 *
 * @version 1.0
 */
class Recaptcha implements Intergration {
	
	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */	
	public function register_admin_actions() {  
		add_filter( 'opaljob/settings/third_party/page_options', [ $this, 'admin_content_setting' ], 10, 1 );
	}

	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function register_frontend_actions() {
		
		if( is_admin() ){
			return ;
		}

		define( 'WPOPAL_CAPTCHA_LOAED', true );
		$this->theme = opaljob_options( 'captcha_theme', 'light' );
		add_action( 'wp_head', [ $this, 'add_custom_styles' ] );
		add_action( 'opaljob_message_form_after', [ __CLASS__, 'show_captcha' ] );
		add_action( 'opaljob_process_send_email_before', [ __CLASS__, 'ajax_verify_captcha' ] );
	}

	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function add_custom_styles() {
		$lang = null;
		echo '<script src="https://www.google.com/recaptcha/api.js?render=reCAPTCHA_' . opaljob_options( 'site_key' ) . '" async defer></script>' . "\r\n";
	}

	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public static function show_captcha() {

		if ( isset( $_GET['captcha'] ) && $_GET['captcha'] == 'failed' ) {

		}
		echo '<div style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;" class="g-recaptcha" data-sitekey="' . opaljob_options( 'site_key' ) . '" data-theme="' . opaljob_options( 'captcha_theme',
				'light' ) . '"></div>';
	}

	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public static function ajax_verify_captcha() {

		$response = isset( $_POST['g-recaptcha-response'] ) ? esc_attr( $_POST['g-recaptcha-response'] ) : '';
		$remote_ip = $_SERVER["REMOTE_ADDR"];

		// make a GET request to the Google reCAPTCHA Server
		$request = wp_remote_get(
			'https://www.google.com/recaptcha/api/siteverify?secret=' . opaljob_options( 'secret_key' ) . '&response=' . $response . '&remoteip=' . $remote_ip
		);

		// get the request response body
		$response_body = wp_remote_retrieve_body( $request );

		$result = json_decode( $response_body, true );

		if ( isset( $result['hostname'] ) && ! empty( $result['hostname'] ) && empty( $result['success'] ) ) {
			$result['success'] = 1;
		}
		if ( ! $result['success'] ) {
			$return = [ 'status' => false, 'msg' => esc_html__( 'The captcha is not verified, please try again!', 'opaljob' ) ];
			echo json_encode( $return );
			die();
		}
	}

	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function admin_content_setting( $settings=array() ) {

		$fields = apply_filters( 'opaljob_settings_google_captcha', [

			[
				'name'    => esc_html__( 'Show Captcha In Form', 'opaljob' ),
				'desc'    => esc_html__( 'Enable google captch in contact , register form. After Set yes, you change setting in Google Captcha Tab. Register here:<a href="https://www.google.com/recaptcha/admin" target="_blank"> https://www.google.com/recaptcha/admin</a> Version 2',
					'opaljob' ),
				'id'      => 'show_captcha',
				'type'    => 'switch',
				'options' => [
					'off' => esc_html__( 'No', 'opaljob' ),
					'on'  => esc_html__( 'Yes', 'opaljob' ),
				],
				'default' => 'on',
			],

			[
				'name' => esc_html__( 'Google Captcha page Settings', 'opaljob' ),
				'desc' => '<hr>',
				'id'   => 'opaljob_title_google_captcha_settings_1',
				'type' => 'title',
			],

			[
				'name' => esc_html__( 'Site Key', 'opaljob' ),
				'desc' => esc_html__( 'Used for displaying the CAPTCHA. Grab it %s', 'opaljob' ),
				'id'   => 'site_key',
				'type' => 'text',
			],

			[
				'name' => esc_html__( 'Secret key', 'opaljob' ),
				'desc' => esc_html__( 'Used for communication between your site and Google. Grab it.', 'opaljob' ),
				'id'   => 'secret_key',
				'type' => 'text',
			],

			[
				'name'    => esc_html__( 'Theme', 'opaljob' ),
				'desc'    => esc_html__( 'Display captcha box with color style.', 'opaljob' ),
				'id'      => 'captcha_theme',
				'type'    => 'select',
				'options' => [
					'light' => esc_html__( 'Light', 'opaljob' ),
					'dark'  => esc_html__( 'Dark', 'opaljob' ),
				],
			],

		] );

		$settings['form_field_options'] =  apply_filters( 'opaljob_field_options', array(
			'id'        => 'form_field_options',
			'title'     => esc_html__( 'Google reCAPTCHA Options', 'opaljob' ),
			'icon-html' => '<span class="opaljob-icon opaljob-icon-heart"></span>',
			'fields'    => $fields 
		));

		return $settings;
	}

	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function admin_tab_setting( $tabs ) {
		$tabs['google_captcha_page'] = esc_html__( 'Google Captcha', 'opaljob' );
		return $tabs;
	}
}