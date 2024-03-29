<?php
$defaults = [
	'id'          => '',
	'name'        => '',
	'description' => null,
	'class'       => 'opaljob-switch form-control',
	'data'        => [],
	'disabled'    => false,
    'default'     => '',
];

$args = wp_parse_args( $args, $defaults );

$valued = $this->get_field_value( $args );

if ( null == $valued ) {
	$value = $args['default'] && in_array( $args['default'], [ 'on', 'off' ] ) ? esc_attr( $args['default'] ) : 'off';
} else {
	$value = $valued ? $valued : 'off';
}

$data = '';
if ( $args['disabled'] ) {
	$data .= ' disabled="disabled"';
}

if ( ! empty( $args['data'] ) ) {
	foreach ( $args['data'] as $key => $value ) {
		$data .= 'data-' . $key . '="' . $value . '" ';
	}
}

$output = '<div class="opaljob-field-wrap opaljob-switch-field-wrap form-group" id="' . sanitize_key( $this->form_id . $args['id'] ) . '-wrap">';

if ( $args['name'] ) {
	$output .= '<label class="opaljob-label" for="' . sanitize_key( $this->form_id . $args['id'] ) . '">' . esc_html( $args['name'] ) . '</label>';
}

$output .= '<label class="opaljob-switch-input">';

$output .= '<input type="checkbox" name="' . esc_attr( $args['id'] ) . '" id="' . esc_attr( $this->form_id . $args['id'] ) . '" value="on" class="' . $args['class'] . '" ' . checked( $value,
		'on', false ) . ' ' . $data . ' />';
$output .= '<span class="slider round"></span>';

$output .= '</label>';

if ( ! empty( $args['description'] ) ) {
	$output .= '<p class="opaljob-description">' . esc_html( $args['description'] ) . '</p>';
}

$output .= '</div>';

echo $output;
