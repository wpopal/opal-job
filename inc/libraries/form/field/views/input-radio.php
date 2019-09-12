<?php
$defaults = [
	'options'          => [],
	'name'             => null,
	'class'            => 'form-control',
	'id'               => '',
	'autocomplete'     => 'off',
	'selected'         => 0,
	'chosen'           => false,
	'multiple'         => false,
	'select_atts'      => false,
	'show_option_all'  => esc_html__( 'All', 'opaljob' ),
	'show_option_none' => esc_html__( 'None', 'opaljob' ),
	'data'             => [],
];

$args             = wp_parse_args( $args, $defaults );
$args['selected'] = $this->get_field_value( $args );


$data_elements = '';
foreach ( $args['data'] as $key => $value ) {
	$data_elements .= ' data-' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
}

$multiple = '';
if ( $args['multiple'] ) {
	$multiple = 'MULTIPLE';
}

if ( $args['chosen'] ) {
	$args['class'] .= ' opaljob-select-chosen';
}
$output = '<div class="opaljob-field-wrap opaljob-radio-field-wrap form-group" id="' . sanitize_key( $this->form_id . $args['id'] ) . '-wrap" >';
$output .= '<label class="opaljob-label" for="' . esc_attr( sanitize_key( str_replace( '-', '_', $this->form_id . $args['id'] ) ) ) . '">' . esc_html( $args['name'] ) . '</label>';

$output .= '<ul class="opaljob-radio inline-list">';
if ( ! empty( $args['options'] ) ) {


	foreach ( $args['options'] as $key => $option ) {
		$_id      = esc_attr( sanitize_key( str_replace( '-', '_', $this->form_id . $args['id'] . $key ) ) );
		$selected = checked( $args['selected'], $key, false );
		$output   .= '<li><input name="' . esc_attr( $args['id'] ) . '" id="' . esc_attr( $_id ) . '" type="radio" value="' . esc_attr( $key ) . '"' . $selected . '/><label for="' . esc_attr( $_id ) . '">' . esc_html( $option ) . '</label><li>';
	}
}
$output .= '</ul>';
$output .= '</div>';

echo $output;
