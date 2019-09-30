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
namespace Opal_Job\Libraries\Form\Field;

use Opal_Job\Libraries\Form\Form;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * HTML Form
 *
 * A helper class for outputting common HTML elements, such as product drop downs
 *
 * @package     OpalJob
 * @subpackage  Opal_Job\Libraries
 */
class Iconpicker {
	/**
	 * @var array
	 */
	public $args;

	/**
	 * @var \Opal_Job\Libraries\Form\Form
	 */
	public $form;

	/**
	 * @var
	 */
	public $type;

	/**
	 * Init Constructor of this
	 *
	 * @return string
	 *
	 */
	public function __construct( $args, Form $form ) {
		$classes = [
			'opaljob-iconpicker',
			'regular-text',
			'form-control',
		];

		$defaults = [
			'id'          => '',
			'name'        => '',
			'description' => '',
			'class'       => esc_attr( implode( ' ', array_map( 'sanitize_html_class', $classes ) ) ),
			'required'    => false,
			'default'     => '',
		];

		$args = wp_parse_args( $args, $defaults );

		$this->args = $args;
		$this->form = $form;

		$icons           = new Fontawesome();
		$this->icon_data = $icons->get_icons();

		$this->render();
	}

	/**
	 * Render file.
	 */
	public function render() {
		wp_enqueue_script( 'fonticonpicker' );

		$args = $this->args;

		$valued = $this->form->get_field_value( $args );

		if ( null == $valued ) {
			$value = $args['default'] ? $args['default'] : '';
		} else {
			$value = $valued;
		}

		$output = '<div class="opaljob-field-wrap opaljob-iconpicker-wrap form-group" id="' . sanitize_key( $this->form->form_id . $args['id'] ) . '-wrap" >';

		$output .= '<label class="opaljob-label" for="' . esc_attr( sanitize_key( str_replace( '-', '_', $this->form->form_id . $args['id'] ) ) ) . '">' . esc_html( $args['name'] ) . '</label>';

		$output .= sprintf(
			'<select id="%1$s" class="%2$s" name="%3$s">',
			sanitize_key( $this->form->form_id . $args['id'] ),
			esc_attr( $args['class'] ),
			esc_attr( $args['id'] )
		);

		foreach ( $this->icon_data as $icon_item ) {
			$full_icon_class = $icon_item['prefix'] . ' ' . $icon_item['class'];
			$output          .= '<option value="' . $full_icon_class . '" ' . selected( $full_icon_class, $value, false ) . '>' . esc_html( $icon_item['class'] ) . '</option>';
		}

		$output .= '</select>';

		if ( ! empty( $args['description'] ) ) {
			$output .= '<p class="opaljob-description">' . esc_html( $args['description'] ) . '</p>';
		}

		$output .= '</div>';

		echo $output;
	}
}
