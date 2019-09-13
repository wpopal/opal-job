<?php
$defaults = [
	'id'              => '',
	'value'           => isset( $args['default'] ) ? $args['default'] : null,
	'id_value'        => '',
	'name'            => '',
	'description'     => null,
	'placeholder'     => '',
	'class'           => 'opaljob-datepicker regular-text form-control',
	'data'            => false,
	'disabled'        => false,
	'date_format'     => '',
	'date_storage'    => '',
	'data-datepicker' => [],
];

$args = wp_parse_args( $args, $defaults );

$valued = $this->get_field_value( $args );

if ( null == $valued ) {
	$value = '';
} else {
	$value = $valued;
}

$id_value         = $this->get_field_value( [ 'id' => $args['id'] . '_id' ] );
$id_value         = $id_value ? sanitize_text_field( $id_value ) : '';
$args['id_value'] = $id_value;

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

$data_datepicker         = '';
$args['data-datepicker'] = wp_parse_args( $args['data-datepicker'], [
	'dateFormat' => $args['date_format'] ? $args['date_format'] : 'mm/dd/yy',
	'altFormat'  => $args['date_storage'] ? $args['date_storage'] : '@',
	'altField'   => '#' . $args['id'] . '_id',
] );

if ( ! empty( $args['data-datepicker'] ) ) {
	$data_datepicker = 'data-datepicker=\'' . json_encode( $args['data-datepicker'] ) . '\'';
}

$output = '<div class="opaljob-field-wrap opaljob-date-field-wrap form-group" id="' . sanitize_key( $this->form_id . $args['id'] ) . '-wrap">';

$output .= '<label class="opaljob-label" for="' . sanitize_key( $this->form_id . $args['id'] ) . '">' . esc_html( $args['name'] ) . '</label>';

$output .= '<input type="text" name="' . esc_attr( $args['id'] ) . '" id="' . esc_attr( $this->form_id . $args['id'] ) . '" value="' . esc_attr( $value ) . '" placeholder="' .
           esc_attr( $args['placeholder'] ) . '" class="' . $args['class'] . '" ' . $data . '' . $disabled . $data_datepicker . '/>';

$output .= '<input type="hidden" name="' . esc_attr( $args['id'] ) . '_id" id="' . esc_attr( $this->form_id . $args['id'] ) . '_id" value="' . esc_attr( $args['id_value'] ) . '" />';

if ( ! empty( $args['description'] ) ) {
	$output .= '<p class="opaljob-description">' . esc_html( $args['description'] ) . '</p>';
}

$output .= '</div>';

echo $output;
