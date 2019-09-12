<?php
$defaults = [
	'id'          => '',
	'value'       => isset( $args['default'] ) ? $args['default'] : null,
	'name'        => '',
	'description' => null,
	'placeholder' => '',
	'class'       => 'opaljob-datepicker regular-text form-control',
	'data'        => false,
	'disabled'    => false,
];

$args = wp_parse_args( $args, $defaults );

$args['value'] = $this->get_field_value( $args );

$disabled = '';
if ( $args['disabled'] ) {
	$disabled = ' disabled="disabled"';
}

$data = '';
if ( ! empty( $args['data'] ) ) {
	foreach ( $args['data'] as $key => $value ) {
		$data .= 'data-' . $key . '="' . $value . '" ';
	}
}

$output = '<div class="opaljob-field-wrap opaljob-date-field-wrap form-group" id="' . sanitize_key( $this->form_id . $args['id'] ) . '-wrap">';

$output .= '<label class="opaljob-label" for="' . sanitize_key( $this->form_id . $args['id'] ) . '">' . esc_html( $args['name'] ) . '</label>';

$output .= '<input type="text" name="' . esc_attr( $args['id'] ) . '" id="' . esc_attr( $this->form_id . $args['id'] ) . '" value="' . esc_attr( $args['value'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" class="' . $args['class'] . '" ' . $data . '' . $disabled . '/>';

if ( ! empty( $args['description'] ) ) {
	$output .= '<p class="opaljob-description">' . esc_html( $args['description'] ) . '</p>';
}

$output .= '</div>';

echo $output;
