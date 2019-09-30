<?php
$defaults = [
	'id'               => '',
	'name'             => null,
	'options'          => [],
	'description'      => null,
	'class'            => 'opaljob-select form-control',
	'autocomplete'     => 'off',
	'selected'         => 0,
	'chosen'           => false,
	'placeholder'      => null,
	'multiple'         => false,
	'select_atts'      => false,
	'show_option_all'  => esc_html__( 'All', 'opaljob' ),
	'show_option_none' => esc_html__( 'None', 'opaljob' ),
	'data'             => [],
	'attributes'       => [],
	'readonly'         => false,
	'disabled'         => false,
	'required'         => '',
];

$args = wp_parse_args( $args, $defaults );

$valued = $this->get_field_value( $args );

if ( null == $valued ) {
	$value = $args['selected'] ? $args['selected'] : '';
} else {
	$value = $valued;
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

if ( $args['required'] ) {
	$data .= ' required="required" ';
}

if ( ! empty( $args['data'] ) ) {
	foreach ( $args['data'] as $key => $value ) {
		$data .= ' data-' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
	}
}

if ( ! empty( $args['attributes'] ) ) {
	foreach ( $args['attributes'] as $key => $value ) {
		$data .= $key . '="' . esc_attr( $value ) . '" ';
	}
}

$output = '<div class="opaljob-field-wrap opaljob-select-field-wrap form-group" id="' . sanitize_key( $this->form_id . $args['id'] ) . '-wrap" >';
if(  $this->show_label ) {
	$output .= '<label class="opaljob-label" for="' . esc_attr( sanitize_key( str_replace( '-', '_', $this->form_id . $args['id'] ) ) ) . '">' . esc_html( $args['name'] ) . '</label>';
}
$output .= sprintf(
	'<select id="%1$s" class="%2$s" name="%3$s"  %4$s>',
	sanitize_key( $this->form_id . $args['id'] ),
	esc_attr( $args['class'] ),
	$args['multiple'] ? esc_attr( $args['id'] ) . '[]' : esc_attr( $args['id'] ),
	$data
);

if ( $args['show_option_all'] ) {
	if ( $args['multiple'] ) {
		$value = $value ? $value : array();
		$selected = selected( true, in_array( 0, $value ), false );
	} else {
		$selected = selected( $value, 0, false );
	}
}

if ( ! empty( $args['options'] ) ) {

	if ( $args['show_option_none'] ) {
		if ( $args['multiple'] ) {
			$selected = selected( true, in_array( -1, $value ), false );
		} else {
			$selected = selected( $value, -1, false );
		}
	}

	foreach ( $args['options'] as $key => $option ) {

		if ( $args['multiple'] && is_array( $value ) ) {
			$selected = selected( true, in_array( $key, $value ), false );
		} else {
			$selected = selected( $value, $key, false );
		}

		$output .= '<option value="' . esc_attr( $key ) . '"' . $selected . '>' . esc_html( $option ) . '</option>';
	}
}

$output .= '</select>';

if ( ! empty( $args['description'] ) ) {
	$output .= '<p class="opaljob-description">' . esc_html( $args['description'] ) . '</p>';
}

$output .= '</div>';

echo $output;
