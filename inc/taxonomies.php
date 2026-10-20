<?php
/**
 * Taxonomies.
 *
 * @package atlas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Place taxonomy for Movements.
 */
function atlas_register_place_taxonomy() {
	$labels = array(
		'name'              => __( 'Places', 'atlas' ),
		'singular_name'     => __( 'Place', 'atlas' ),
		'search_items'      => __( 'Search Places', 'atlas' ),
		'all_items'         => __( 'All Places', 'atlas' ),
		'edit_item'         => __( 'Edit Place', 'atlas' ),
		'update_item'       => __( 'Update Place', 'atlas' ),
		'add_new_item'      => __( 'Add New Place', 'atlas' ),
		'new_item_name'     => __( 'New Place Name', 'atlas' ),
		'not_found'         => __( 'No places found.', 'atlas' ),
		'menu_name'         => __( 'Places', 'atlas' ),
	);

	register_taxonomy(
		'atlas_place',
		array( 'atlas_movement' ),
		array(
			'labels'       => $labels,
			'hierarchical' => false,
			'public'       => true,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'place' ),
		)
	);
}
add_action( 'init', 'atlas_register_place_taxonomy' );

/**
 * Seed the five Place terms once.
 *
 * Runs on init (priority 20, after the taxonomy is registered at 10) rather
 * than after_switch_theme, because the theme is already active. A version
 * option records that seeding is done, so most requests cost one cached
 * option read. term_exists() keeps repeat runs from creating duplicates.
  * Change $seed_version to re-seed after editing the list.
 */
function atlas_seed_place_terms() {
	$seed_version = '1';

	if ( get_option( 'atlas_places_seeded' ) === $seed_version ) {
		return;
	}

	$places = array(
		'Southern California',
		'New York',
		'New Orleans',
		'Chicago',
		'New Mexico',
	);

	foreach ( $places as $place ) {
	if ( ! term_exists( $place, 'atlas_place' ) ) {
		$result = wp_insert_term( $place, 'atlas_place' );
		if ( is_wp_error( $result ) ) {
			return;
		}
	}
}

	update_option( 'atlas_places_seeded', $seed_version );
}
add_action( 'init', 'atlas_seed_place_terms', 20 );
