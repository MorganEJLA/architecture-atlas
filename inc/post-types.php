<?php
/**
 * Custom post types.
 *
 * @package atlas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Movement custom post type.
 */
function atlas_register_movement_post_type() {
	$labels = array(
		'name'               => __( 'Movements', 'atlas' ),
		'singular_name'      => __( 'Movement', 'atlas' ),
		'add_new_item'       => __( 'Add New Movement', 'atlas' ),
		'edit_item'          => __( 'Edit Movement', 'atlas' ),
		'new_item'           => __( 'New Movement', 'atlas' ),
		'view_item'          => __( 'View Movement', 'atlas' ),
		'search_items'       => __( 'Search Movements', 'atlas' ),
		'not_found'          => __( 'No movements found.', 'atlas' ),
		'not_found_in_trash' => __( 'No movements found in Trash.', 'atlas' ),
		'all_items'          => __( 'All Movements', 'atlas' ),
		'menu_name'          => __( 'Movements', 'atlas' ),
	);

	register_post_type(
		'atlas_movement',
		array(
			'labels'       => $labels,
			'public'       => true,
			'has_archive'  => 'movements',
			'rewrite'      => array( 'slug' => 'movements' ),
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-building',
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		)
	);
}
add_action( 'init', 'atlas_register_movement_post_type' );
