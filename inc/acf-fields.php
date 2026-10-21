<?php
/**
 * ACF field groups.
 *
 * @package atlas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Movement field group (years and color swatches).
 */
function atlas_register_movement_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'          => 'group_atlas_movement',
			'title'        => __( 'Movement Details', 'atlas' ),
			'fields'       => array(
				array(
					'key'   => 'field_atlas_start_year',
					'label' => __( 'Start Year', 'atlas' ),
					'name'  => 'start_year',
					'type'  => 'number',
				),
				array(
					'key'   => 'field_atlas_end_year',
					'label' => __( 'End Year', 'atlas' ),
					'name'  => 'end_year',
					'type'  => 'number',
				),
				array(
					'key'   => 'field_atlas_swatch_1',
					'label' => __( 'Swatch 1', 'atlas' ),
					'name'  => 'swatch_1',
					'type'  => 'color_picker',
				),
				array(
					'key'   => 'field_atlas_swatch_2',
					'label' => __( 'Swatch 2', 'atlas' ),
					'name'  => 'swatch_2',
					'type'  => 'color_picker',
				),
				array(
					'key'   => 'field_atlas_swatch_3',
					'label' => __( 'Swatch 3', 'atlas' ),
					'name'  => 'swatch_3',
					'type'  => 'color_picker',
				),
			),
			'location'     => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'atlas_movement',
					),
				),
			),
			'show_in_rest' => true,
		)
	);
}
add_action( 'acf/init', 'atlas_register_movement_fields' );
