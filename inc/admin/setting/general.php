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
namespace Opal_Job\Admin\Setting;

use Opal_Job\Core as Core;

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
class General extends Core\Metabox {

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function get_tab() {
		return [ 'id' => 'general', 'heading' => esc_html__( 'General' ) ];
	}

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function get_settings() {

		$settings = [];

		$prefix = OPAL_JOB_METABOX_PREFIX;

		$settings = [
			/**
			 * Repeatable Field Groups
			 */
			'form_field_options'    => apply_filters( 'opaljob_field_options', [
				'id'        => 'form_field_options',
				'title'     => esc_html__( 'Donation Options', 'opaljob' ),
				'icon-html' => '<span class="opaljob-icon opaljob-icon-heart"></span>',
				'fields'    => apply_filters( 'opaljob_donation_form_metabox_fields', [
					// Display Style.
					[
						'name'        => esc_html__( 'Display Style', 'opaljob' ),
						'description' => esc_html__( 'Set how the donations levels will display on the form.', 'opaljob' ),
						'id'          => $prefix . 'display_style',
						'type'        => 'radio_inline',
						'default'     => 'buttons',
						'options'     => [
							'buttons'  => esc_html__( 'Buttons', 'opaljob' ),
							'radios'   => esc_html__( 'Radios', 'opaljob' ),
							'dropdown' => esc_html__( 'Dropdown', 'opaljob' ),
						],
					],
					// Custom Amount.
					[
						'name'        => esc_html__( 'Custom Amount', 'opaljob' ),
						'description' => esc_html__( 'Do you want the user to be able to input their own donation amount?', 'opaljob' ),
						'id'          => $prefix . 'custom_amount',
						'type'        => 'radio',
						'default'     => 'disabled',
						'options'     => [
							'enabled'  => esc_html__( 'Enabled', 'opaljob' ),
							'disabled' => esc_html__( 'Disabled', 'opaljob' ),
						],
					],
					[
						'name'        => esc_html__( 'Test select', 'opaljob' ),
						'description' => esc_html__( 'Do you want the user to be able to input their own donation amount?', 'opaljob' ),
						'id'          => $prefix . 'custom_amount',
						'type'        => 'select',
						'default'     => 'disabled',
						'options'     => [
							'enabled'  => esc_html__( 'Enabled', 'opaljob' ),
							'disabled' => esc_html__( 'Disabled', 'opaljob' ),
						],
					],

					[
						'name'          => esc_html__( 'Custom Amount Text', 'opaljob' ),
						'description'   => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'            => $prefix . 'custom_amount_text',
						'type'          => 'text_medium',
						'attributes'    => [
							'rows'        => 3,
							'placeholder' => esc_html__( 'Give a Custom Amount', 'opaljob' ),
						],
						'wrapper_class' => 'opaljob-hidden',
					],
					// Donation Levels.
					[
						'id'            => $prefix . 'donation_levels',
						'type'          => 'group',
						'options'       => [
							'add_button'    => esc_html__( 'Add Level', 'opaljob' ),
							'header_title'  => esc_html__( 'Donation Level', 'opaljob' ),
							'remove_button' => '<span class="dashicons dashicons-no"></span>',
						],
						'wrapper_class' => 'opaljob-hidden',
						// Fields array works the same, except id's only need to be unique for this group.
						// Prefix is not needed.
						'fields'        => apply_filters( 'opaljob_donation_levels_table_row', [
							[
								'name' => esc_html__( 'ID', 'opaljob' ),
								'id'   => $prefix . 'id',
								'type' => 'levels_id',
							],

							[
								'name'       => esc_html__( 'Text', 'opaljob' ),
								'id'         => $prefix . 'text',
								'type'       => 'text',
								'attributes' => [
									'placeholder' => esc_html__( 'Donation Level', 'opaljob' ),
									'class'       => 'opaljob-multilevel-text-field',
								],
							],
							[
								'name' => esc_html__( 'Default', 'opaljob' ),
								'id'   => $prefix . 'default',
								'type' => 'opaljob_default_radio_inline',
							],
						] ),
					],

					[
						'name'        => esc_html__( 'Colorpicker', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'color_test',
						'type'        => 'colorpicker',
					],
					[
						'name'        => esc_html__( 'Upload', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'new_upload_test',
						'type'        => 'file',
					],
					[
						'name'        => esc_html__( 'Upload List', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'the_upload_list',
						'type'        => 'file_list',
						'button_text' => 'Test button text',
					],
					[
						'name'        => esc_html__( 'Date picker test', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'test_datepicker',
						'type'        => 'date',
					],
					[
						'name'        => esc_html__( 'Taxonomy select', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'test_taxonomy_select',
						'type'        => 'taxonomy_select',
						'taxonomy'    => 'opaljob_specialism',
						'multiple'    => true,
					],
					[
						'name'        => esc_html__( 'Taxonomy multicheck', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'test_taxonomy_multicheck',
						'type'        => 'taxonomy_multicheck',
						'taxonomy'    => 'category',
					],
					[
						'name'        => esc_html__( 'Checkbox', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'test_checkbox',
						'type'        => 'checkbox',
					],
					[
						'name'        => esc_html__( 'Switch', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'test_switch__123',
						'type'        => 'switch',
						'default'     => 'on',
					],
					[
						'name'        => esc_html__( 'Test text with default', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'test_text_default_123456',
						'type'        => 'text',
						'placeholder' => 'The placeholder text',
						// 'default'     => 'The default',
					],
					[
						'name'        => esc_html__( 'Test number', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'test_text_number',
						'type'        => 'text_number',
						'default'     => 5,
						'attributes'  => [
							'min' => 1,
							'max' => 10,
						],
					],
					[
						'name'        => esc_html__( 'Test small', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'test_text_small',
						'type'        => 'text_small',
					],
					[
						'name'        => esc_html__( 'Test url', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'test_url',
						'type'        => 'text_url',
						'placeholder' => 'The placeholder url',
					],
					[
						'name'        => esc_html__( 'Test text', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'test_text',
						'type'        => 'text_email',
					],
					[
						'name'        => esc_html__( 'Test map', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'test_map',
						'type'        => 'map',
					],
					[
						'name'        => esc_html__( 'Test iconpicker', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'test_icon',
						'type'        => 'iconpicker',
					],
					[
						'name'        => esc_html__( 'Test iconpicker 2', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'test_icon_2',
						'type'        => 'iconpicker',
					],
					[
						'name'        => esc_html__( 'Test hidden', 'opaljob' ),
						'description' => esc_html__( 'This text appears as a label below the custom amount field for set donation forms. For multi-level forms the text will appear as it\'s own level (ie button, radio, or select option).',
							'opaljob' ),
						'id'          => 'test_hidden',
						'type'        => 'hidden',
						'default'     => '123',
					],
				] ),
			] ),

			/**
			 * Display Options
			 */
			'form_display_options'  => apply_filters( 'opaljob_form_display_options', [
					'id'        => 'form_display_options',
					'title'     => esc_html__( 'Form Display', 'opaljob' ),
					'icon-html' => '<span class="opaljob-icon opaljob-icon-display"></span>',
					'fields'    => apply_filters( 'opaljob_display_options_metabox_fields', [
						[
							'name'    => esc_html__( 'Display Options', 'opaljob' ),
							'desc'    => sprintf( esc_html__( 'How would you like to display donation information for this form?', 'opaljob' ), '#' ),
							'id'      => $prefix . 'payment_display',
							'type'    => 'radio_inline',
							'options' => [
								'onpage' => esc_html__( 'All Fields', 'opaljob' ),
								'modal'  => esc_html__( 'Modal', 'opaljob' ),
								'reveal' => esc_html__( 'Reveal', 'opaljob' ),
								'button' => esc_html__( 'Button', 'opaljob' ),
							],
							'default' => 'onpage',
						],
						[
							'id'            => $prefix . 'reveal_label',
							'name'          => esc_html__( 'Continue Button', 'opaljob' ),
							'desc'          => esc_html__( 'The button label for displaying the additional payment fields.', 'opaljob' ),
							'type'          => 'text_small',
							'attributes'    => [
								'placeholder' => esc_html__( 'Donate Now', 'opaljob' ),
							],
							'wrapper_class' => 'opaljob-hidden',
						],
						[
							'id'         => $prefix . 'checkout_label',
							'name'       => esc_html__( 'Submit Button', 'opaljob' ),
							'desc'       => esc_html__( 'The button label for completing a donation.', 'opaljob' ),
							'type'       => 'text_small',
							'attributes' => [
								'placeholder' => esc_html__( 'Donate Now', 'opaljob' ),
							],
						],
						[
							'name' => esc_html__( 'Default Gateway', 'opaljob' ),
							'desc' => esc_html__( 'By default, the gateway for this form will inherit the global default gateway (set under Give > Settings > Payment Gateways). This option allows you to customize the default gateway for this form only.',
								'opaljob' ),
							'id'   => $prefix . 'default_gateway',
							'type' => 'default_gateway',
						],
						[
							'name'    => esc_html__( 'Name Title Prefix', 'opaljob' ),
							'desc'    => esc_html__( 'Do you want to add a name title prefix dropdown field before the donor\'s first name field? This will display a dropdown with options such as Mrs, Miss, Ms, Sir, and Dr for donor to choose from.',
								'opaljob' ),
							'id'      => $prefix . 'name_title_prefix',
							'type'    => 'radio_inline',
							'options' => [
								'global'   => esc_html__( 'Global Option', 'opaljob' ),
								'required' => esc_html__( 'Required', 'opaljob' ),
								'optional' => esc_html__( 'Optional', 'opaljob' ),
								'disabled' => esc_html__( 'Disabled', 'opaljob' ),
							],
							'default' => 'global',
						],
						[
							'name'          => esc_html__( 'Title Prefixes', 'opaljob' ),
							'desc'          => esc_html__( 'Add or remove salutations from the dropdown using the field above.', 'opaljob' ),
							'id'            => $prefix . 'title_prefixes',
							'type'          => 'chosen',
							'data_type'     => 'multiselect',
							'style'         => 'width: 100%',
							'wrapper_class' => 'opaljob-hidden opaljob-title-prefixes-wrap',
							'options'       => [],
						],
						[
							'name'    => esc_html__( 'Company Donations', 'opaljob' ),
							'desc'    => esc_html__( 'Do you want a Company field to appear after First Name and Last Name?', 'opaljob' ),
							'id'      => $prefix . 'company_field',
							'type'    => 'radio_inline',
							'default' => 'global',
							'options' => [
								'global'   => esc_html__( 'Global Option', 'opaljob' ),
								'required' => esc_html__( 'Required', 'opaljob' ),
								'optional' => esc_html__( 'Optional', 'opaljob' ),
								'disabled' => esc_html__( 'Disabled', 'opaljob' ),

							],
						],
						[
							'name'    => esc_html__( 'Anonymous Donations', 'opaljob' ),
							'desc'    => esc_html__( 'Do you want to provide donors the ability mark themselves anonymous while giving. This will prevent their information from appearing publicly on your website but you will still receive their information for your records in the admin panel.',
								'opaljob' ),
							'id'      => "{$prefix}anonymous_donation",
							'type'    => 'radio_inline',
							'default' => 'global',
							'options' => [
								'global'   => esc_html__( 'Global Option', 'opaljob' ),
								'enabled'  => esc_html__( 'Enabled', 'opaljob' ),
								'disabled' => esc_html__( 'Disabled', 'opaljob' ),
							],
						],
						[
							'name'    => esc_html__( 'Donor Comments', 'opaljob' ),
							'desc'    => esc_html__( 'Do you want to provide donors the ability to add a comment to their donation? The comment will display publicly on the donor wall if they do not select to opaljob anonymously.',
								'opaljob' ),
							'id'      => "{$prefix}donor_comment",
							'type'    => 'radio_inline',
							'default' => 'global',
							'options' => [
								'global'   => esc_html__( 'Global Option', 'opaljob' ),
								'enabled'  => esc_html__( 'Enabled', 'opaljob' ),
								'disabled' => esc_html__( 'Disabled', 'opaljob' ),
							],
						],
						[
							'name'    => esc_html__( 'Guest Donations', 'opaljob' ),
							'desc'    => esc_html__( 'Do you want to allow non-logged-in users to make donations?', 'opaljob' ),
							'id'      => $prefix . 'logged_in_only',
							'type'    => 'radio_inline',
							'default' => 'enabled',
							'options' => [
								'enabled'  => esc_html__( 'Enabled', 'opaljob' ),
								'disabled' => esc_html__( 'Disabled', 'opaljob' ),
							],
						],
						[
							'name'    => esc_html__( 'Registration', 'opaljob' ),
							'desc'    => esc_html__( 'Display the registration and login forms in the payment section for non-logged-in users.', 'opaljob' ),
							'id'      => $prefix . 'show_register_form',
							'type'    => 'radio',
							'options' => [
								'none'         => esc_html__( 'None', 'opaljob' ),
								'registration' => esc_html__( 'Registration', 'opaljob' ),
								'login'        => esc_html__( 'Login', 'opaljob' ),
								'both'         => esc_html__( 'Registration + Login', 'opaljob' ),
							],
							'default' => 'none',
						],
						[
							'name'    => esc_html__( 'Floating Labels', 'opaljob' ),
							/* translators: %s: forms http://docs.opaljobwp.com/form-floating-labels */
							'desc'    => sprintf( esc_html__( 'Select the <a href="%s" target="_blank">floating labels</a> setting for this Give form. Be aware that if you have the "Disable CSS" option enabled, you will need to style the floating labels yourself.',
								'opaljob' ), esc_url( 'http://docs.opaljobwp.com/form-floating-labels' ) ),
							'id'      => $prefix . 'form_floating_labels',
							'type'    => 'radio_inline',
							'options' => [
								'global'   => esc_html__( 'Global Option', 'opaljob' ),
								'enabled'  => esc_html__( 'Enabled', 'opaljob' ),
								'disabled' => esc_html__( 'Disabled', 'opaljob' ),
							],
							'default' => 'global',
						],
						[
							'name'  => 'form_display_docs',
							'type'  => 'docs_link',
							'url'   => 'http://docs.opaljobwp.com/form-display-options',
							'title' => esc_html__( 'Form Display', 'opaljob' ),
						],
					] ),
				]
			),

			/**
			 * Donation Goals
			 */
			'donation_goal_options' => apply_filters( 'opaljob_donation_goal_options', [
				'id'        => 'donation_goal_options',
				'title'     => esc_html__( 'Donation Goal', 'opaljob' ),
				'icon-html' => '<span class="opaljob-icon opaljob-icon-target"></span>',
				'fields'    => apply_filters( 'opaljob_donation_goal_metabox_fields', [
					// Goals
					[
						'name'        => esc_html__( 'Donation Goal', 'opaljob' ),
						'description' => esc_html__( 'Do you want to set a donation goal for this form?', 'opaljob' ),
						'id'          => $prefix . 'goal_option',
						'type'        => 'radio_inline',
						'default'     => 'disabled',
						'options'     => [
							'enabled'  => esc_html__( 'Enabled', 'opaljob' ),
							'disabled' => esc_html__( 'Disabled', 'opaljob' ),
						],
					],

					[
						'name'        => esc_html__( 'Goal Format', 'opaljob' ),
						'description' => esc_html__( 'Do you want to display the total amount raised based on your monetary goal or a percentage? For instance, "$500 of $1,000 raised" or "50% funded" or "1 of 5 donations". You can also display a donor-based goal, such as "100 of 1,000 donors have opaljobn".',
							'opaljob' ),
						'id'          => $prefix . 'goal_format',
						'type'        => 'donation_form_goal',
						'default'     => 'amount',
						'options'     => [
							'amount'     => esc_html__( 'Amount Raised', 'opaljob' ),
							'percentage' => esc_html__( 'Percentage Raised', 'opaljob' ),
							'donation'   => esc_html__( 'Number of Donations', 'opaljob' ),
							'donors'     => esc_html__( 'Number of Donors', 'opaljob' ),
						],
					],

					[
						'id'         => $prefix . 'number_of_donation_goal',
						'name'       => esc_html__( 'Donation Goal', 'opaljob' ),
						'desc'       => esc_html__( 'Set the total number of donations as a goal.', 'opaljob' ),
						'type'       => 'number',
						'default'    => 1,
						'attributes' => [
							'placeholder' => 1,
						],
					],
					[
						'id'         => $prefix . 'number_of_donor_goal',
						'name'       => esc_html__( 'Donor Goal', 'opaljob' ),
						'desc'       => esc_html__( 'Set the total number of donors as a goal.', 'opaljob' ),
						'type'       => 'number',
						'default'    => 1,
						'attributes' => [
							'placeholder' => 1,
						],
					],
					[
						'name'          => esc_html__( 'Progress Bar Color', 'opaljob' ),
						'desc'          => esc_html__( 'Customize the color of the goal progress bar.', 'opaljob' ),
						'id'            => $prefix . 'goal_color',
						'type'          => 'colorpicker',
						'default'       => '#2bc253',
						'wrapper_class' => 'opaljob-hidden',
					],

					[
						'name'          => esc_html__( 'Close Form', 'opaljob' ),
						'desc'          => esc_html__( 'Do you want to close the donation forms and stop accepting donations once this goal has been met?', 'opaljob' ),
						'id'            => $prefix . 'close_form_when_goal_achieved',
						'type'          => 'radio_inline',
						'default'       => 'disabled',
						'options'       => [
							'enabled'  => esc_html__( 'Enabled', 'opaljob' ),
							'disabled' => esc_html__( 'Disabled', 'opaljob' ),
						],
						'wrapper_class' => 'opaljob-hidden',
					],
					[
						'name'          => esc_html__( 'Goal Achieved Message', 'opaljob' ),
						'desc'          => esc_html__( 'Do you want to display a custom message when the goal is closed?', 'opaljob' ),
						'id'            => $prefix . 'form_goal_achieved_message',
						'type'          => 'wysiwyg',
						'default'       => esc_html__( 'Thank you to all our donors, we have met our fundraising goal.', 'opaljob' ),
						'wrapper_class' => 'opaljob-hidden',
					],
					[
						'name'  => 'donation_goal_docs',
						'type'  => 'docs_link',
						'url'   => 'http://docs.opaljobwp.com/form-donation-goal',
						'title' => esc_html__( 'Donation Goal', 'opaljob' ),
					],
				] ),
			] ),

			/**
			 * Content Field
			 */
			'form_content_options'  => apply_filters( 'opaljob_content_options', [
				'id'        => 'form_content_options',
				'title'     => esc_html__( 'Form Content', 'opaljob' ),
				'icon-html' => '<span class="opaljob-icon opaljob-icon-edit"></span>',
				'fields'    => apply_filters( 'opaljob_content_options_metabox_fields', [

					// Donation content.
					[
						'name'        => esc_html__( 'Display Content', 'opaljob' ),
						'description' => esc_html__( 'Do you want to add custom content to this form?', 'opaljob' ),
						'id'          => $prefix . 'display_content',
						'type'        => 'radio_inline',
						'options'     => [
							'enabled'  => esc_html__( 'Enabled', 'opaljob' ),
							'disabled' => esc_html__( 'Disabled', 'opaljob' ),
						],
						'default'     => 'disabled',
					],

					// Content placement.
					[
						'name'          => esc_html__( 'Content Placement', 'opaljob' ),
						'description'   => esc_html__( 'This option controls where the content appears within the donation form.', 'opaljob' ),
						'id'            => $prefix . 'content_placement',
						'type'          => 'radio_inline',
						'options'       => apply_filters( 'opaljob_content_options_select', [
								'opaljob_pre_form'  => esc_html__( 'Above fields', 'opaljob' ),
								'opaljob_post_form' => esc_html__( 'Below fields', 'opaljob' ),
							]
						),
						'default'       => 'opaljob_pre_form',
						'wrapper_class' => 'opaljob-hidden',
					],
					[
						'name'          => esc_html__( 'Content', 'opaljob' ),
						'description'   => esc_html__( 'This content will display on the single opaljob form page.', 'opaljob' ),
						'id'            => $prefix . 'form_content',
						'type'          => 'wysiwyg',
						'wrapper_class' => 'opaljob-hidden',
					],
					[
						'name'  => 'form_content_docs',
						'type'  => 'docs_link',
						'url'   => 'http://docs.opaljobwp.com/form-content',
						'title' => esc_html__( 'Form Content', 'opaljob' ),
					],
				] ),
			] ),

			/**
			 * Terms & Conditions
			 */
			'form_terms_options'    => apply_filters( 'opaljob_terms_options', [
				'id'        => 'form_terms_options',
				'title'     => esc_html__( 'Terms & Conditions', 'opaljob' ),
				'icon-html' => '<span class="opaljob-icon opaljob-icon-checklist"></span>',
				'fields'    => apply_filters( 'opaljob_terms_options_metabox_fields', [
					// Donation Option
					[
						'name'        => esc_html__( 'Terms and Conditions', 'opaljob' ),
						'description' => esc_html__( 'Do you want to require the donor to accept terms prior to being able to complete their donation?', 'opaljob' ),
						'id'          => $prefix . 'terms_option',
						'type'        => 'radio_inline',
						'options'     => apply_filters( 'opaljob_content_options_select', [
								'global'   => esc_html__( 'Global Option', 'opaljob' ),
								'enabled'  => esc_html__( 'Customize', 'opaljob' ),
								'disabled' => esc_html__( 'Disable', 'opaljob' ),
							]
						),
						'default'     => 'global',
					],
					[
						'id'            => $prefix . 'agree_label',
						'name'          => esc_html__( 'Agreement Label', 'opaljob' ),
						'desc'          => esc_html__( 'The label shown next to the agree to terms check box. Add your own to customize or leave blank to use the default text placeholder.', 'opaljob' ),
						'type'          => 'textarea',
						'attributes'    => [
							'placeholder' => esc_html__( 'Agree to Terms?', 'opaljob' ),
							'rows'        => 1,
						],
						'wrapper_class' => 'opaljob-hidden',
					],

					[
						'name'  => 'terms_docs',
						'type'  => 'docs_link',
						'url'   => 'http://docs.opaljobwp.com/form-terms',
						'title' => esc_html__( 'Terms and Conditions', 'opaljob' ),
					],
				] ),
			] ),
		];

		return $settings;
	}
}
