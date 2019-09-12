<?php
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
class Taxonomy {
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
	public function __construct( $args, Form $form, $type = 'taxonomy_select' ) {
		$classes = [
			'opaljob-taxonomy-field',
			'opaljob-select',
			'regular-text',
			'form-control',
		];

		$defaults = [
			'id'               => '',
			'taxonomy'         => '',
			'name'             => '',
			'value_type'       => 'slug',
			'query_args'       => [],
			'description'      => null,
			'class'            => esc_attr( implode( ' ', array_map( 'sanitize_html_class', $classes ) ) ),
			'autocomplete'     => 'off',
			'selected'         => 0,
			'chosen'           => false,
			'placeholder'      => null,
			'multiple'         => false,
			'select_atts'      => false,
			'show_option_all'  => esc_html__( 'All', 'opaljob' ),
			'show_option_none' => esc_html__( 'None', 'opaljob' ),
			'data'             => [],
			'readonly'         => false,
			'disabled'         => false,
			'required'         => '',
		];

		$args             = wp_parse_args( $args, $defaults );
		$args['selected'] = $form->get_field_value( $args );

		$this->args = $args;
		$this->form = $form;
		$this->type = $type;

		$this->render();
	}

	/**
	 * Render.
	 */
	public function render() {
		if ( 'taxonomy_select' === $this->type ) {
			$this->render_taxonomy_select();
		} elseif ( 'taxonomy_multicheck' === $this->type ) {
			$this->render_taxonomy_multicheck();
		}
	}

	/**
	 * Render taxonomy select.
	 */
	public function render_taxonomy_select() {
		$args = $this->args;

		$all_terms = $this->get_terms();

		if ( ! $all_terms || is_wp_error( $all_terms ) ) {
			echo $this->no_terms_result( $all_terms, 'strong' );
			return;
		}

		if ( $args['chosen'] ) {
			$args['class'] .= ' opaljob-select-chosen';
		}

		$data = '';
		if ( $args['multiple'] ) {
			$data .= ' multiple="multiple"';
		}

		if ( $args['readonly'] ) {
			$data .= ' readonly';
		}

		if ( 'on' === $args['autocomplete'] ) {
			$data .= ' autocomplete="' . esc_attr( $args['autocomplete'] ) . '"';
		}

		if ( $args['placeholder'] ) {
			$data .= ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '"';
		}

		if ( $args['disabled'] ) {
			$data .= ' disabled="disabled"';
		}

		if ( ! empty( $args['data'] ) ) {
			foreach ( $args['data'] as $key => $value ) {
				$data .= ' data-' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
			}
		}

		if ( $args['required'] ) {
			$data .= ' required="required" ';
		}

		$output = '<div class="opaljob-field-wrap opaljob-taxonomy-select-wrap form-group" id="' . sanitize_key( $this->form->form_id . $args['id'] ) . '-wrap" >';

		$output .= '<label class="opaljob-label" for="' . esc_attr( sanitize_key( str_replace( '-', '_', $this->form->form_id . $args['id'] ) ) ) . '">' . esc_html( $args['name'] ) . '</label>';

		$output .= sprintf(
			'<select id="%1$s" class="%2$s" name="%3$s"  %4$s>',
			sanitize_key( $this->form->form_id . $args['id'] ),
			esc_attr( $args['class'] ),
			$args['multiple'] ? esc_attr( $args['id'] ) . '[]' : esc_attr( $args['id'] ),
			$data
		);

		if ( ! empty( $all_terms ) ) {
			$output .= $this->loop_terms( $all_terms );
		}

		$output .= '</select>';

		if ( ! empty( $args['description'] ) ) {
			$output .= '<p class="opaljob-description">' . esc_html( $args['description'] ) . '</p>';
		}

		$output .= '</div>';

		echo $output;
	}

	/**
	 * Render taxonomy multicheck.
	 */
	public function render_taxonomy_multicheck() {

	}

	/**
	 * Wrapper for `get_terms` to account for changes in WP 4.6 where taxonomy is expected
	 * as part of the arguments.
	 *
	 * @return mixed Array of terms on success
	 */
	public function get_terms() {
		$args = [
			'taxonomy'   => $this->args['taxonomy'],
			'hide_empty' => false,
		];

		$args = wp_parse_args( $this->args['query_args'], $args );

		return get_terms( $args );
	}

	protected function no_terms_result( $error, $tag = 'li' ) {
		if ( is_wp_error( $error ) ) {
			$message = $error->get_error_message();
			$data    = 'data-error="' . esc_attr( $error->get_error_code() ) . '"';
		} else {
			$message = esc_html__( 'No terms', 'opaljob' );
			$data    = '';
		}

		$this->args['select_all_button'] = false;

		return sprintf( '<%3$s><label %1$s>%2$s</label></%3$s>', $data, esc_html( $message ), $tag );
	}

	protected function loop_terms( $all_terms ) {
		$args    = $this->args;
		$options = '';

		foreach ( $all_terms as $term ) {
			$value = $term->{$args['value_type']};

			if ( $args['multiple'] && is_array( $args['selected'] ) ) {
				$selected = selected( true, in_array( $value, $args['selected'] ), false );
			} else {
				$selected = selected( $args['selected'], $value, false );
			}

			$options .= sprintf( '<option value="%1$s" %2$s>%3$s</option>',
				$value,
				$selected,
				esc_html( $term->name )
			);
		}

		return $options;
	}
}
