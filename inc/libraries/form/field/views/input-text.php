<?php
$defaults = [
	'id'           => '',
	'name'         => '',
	'type'         => 'text',
	'description'  => null,
	'placeholder'  => '',
	'class'        => 'opaljob-text regular-text form-control',
	'disabled'     => false,
	'autocomplete' => 'off',
	'data'         => [],
	'default'      => '',
	'required'     => false,
	'attributes'   => [],
];

$args   = wp_parse_args( $args, $defaults );
$valued = $this->get_field_value( $args );

if ( null == $valued ) {
	$value = $args['default'] ? esc_attr( $args['default'] ) : '';
} else {
	$value = $valued;
}

$data = '';

if ( $args['placeholder'] ) {
	$data .= ' placeholder="' . esc_attr( $args['placeholder'] ) . '"';
}

if ( 'on' === $args['autocomplete'] ) {
	$data .= ' autocomplete="' . esc_attr( $args['autocomplete'] ) . '"';
}

if ( ! empty( $args['attributes'] ) && empty($value)) {
	foreach ( $args['attributes'] as $key => $value ) {
		$data .= $key . '="' . esc_attr( $value ) . '" ';
	}
}

if ( ! empty( $args['data'] ) ) {
	foreach ( $args['data'] as $key => $value ) {
		$data .= 'data-' . $key . '="' . esc_attr( $value ) . '" ';
	}
}

if ( $args['disabled'] ) {
	$data .= ' disabled="disabled"';
}

$required_label = '';
if ( $args['required'] ) {
	$required_label = '<span class="required"> *</span>';
	$data           .= ' required="required" ';
}

$output = '';
if ( 'hidden' !== $args['type'] ) {
	$output .= '<div class="opaljob-field-wrap opaljob-text-field-wrap form-group" id="' . sanitize_key( $this->form_id . $args['id'] ) . '-wrap">';

	if ( $args['name'] ) {
		$output .= '<label class="opaljob-label" for="' . sanitize_key( $this->form_id . $args['id'] ) . '">' . esc_html( $args['name'] ) . $required_label . '</label>';
	}
}


$output .= sprintf( '<input type="%1$s" id="%2$s" class="%3$s" name="%4$s" value="%5$s" %6$s />',
	esc_attr( $args['type'] ),
	esc_attr( $this->form_id . $args['id'] ),
	esc_attr( $args['class'] ),
	esc_attr( $args['id'] ),
	esc_attr( $value ),
	$data
);

if ( 'hidden' !== $args['type'] ) {
	if ( ! empty( $args['description'] ) ) {
		$output .= '<p class="opaljob-description">' . esc_html( $args['description'] ) . '</p>';
	}

	$output .= '</div>';
}

echo $output;
