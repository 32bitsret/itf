<?php

function ld_dashboard_get_field_html( $field ) {
	switch ( $field['tag'] ) {
		case 'input':
			echo ld_dashboard_get_input_field_html( $field );
			break;
		case 'select':
			echo ld_dashboard_get_select_field_html( $field );
			break;
		case 'textarea':
			echo ld_dashboard_get_textarea_field_html( $field );
			break;
		default:
			break;
	}
}

function ld_dashboard_get_input_field_html( $field ) {

	$html = '<input type="' . $field['type'] . '" name="' . esc_attr( $field['name'] ) . '" value="' . esc_attr( $field['value'] ) . '">';
	return $html;
}

function ld_dashboard_get_select_field_html( $field ) {

	$html = '<select name="' . $field['name'] . '">';
	if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {
		foreach ( $field['options'] as $option => $option_text ) {
			$selected = ( $field['value'] === $option ) ? 'selected' : '';
			$html    .= '<option value="' . esc_attr( $option ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $option_text ) . '</option>';
		}
	}
	$html .= '</select>';
	return $html;
}

function ld_dashboard_get_textarea_field_html( $field ) {
	$html = '<textarea name="' . esc_attr( $field['name'] ) . '">' . esc_html( $field['value'] ) . '</textarea>';
	return $html;
}
