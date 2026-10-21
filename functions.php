<?php
/**
 * Atlas theme setup.
 *
 * @package atlas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/taxonomies.php';
require_once get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/blocks.php';

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once get_template_directory() . '/inc/cli-seed.php';
}

/** Register theme features. */


function atlas_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
}
add_action( 'after_setup_theme', 'atlas_setup' );

/**
 * Enqueue the theme stylesheet.
 */
function atlas_enqueue_styles() {
	wp_enqueue_style(
		'atlas-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'atlas_enqueue_styles' );

/**
 * Order the Movement archive by start_year, oldest first, all on one page.
 *
 * @param WP_Query $query The main query.
 */
function atlas_order_movement_archive( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'atlas_movement' ) ) {
		return;
	}

	$query->set( 'meta_key', 'start_year' );
	$query->set(
	'orderby',
	array(
		'meta_value_num' => 'ASC',
		'title'          => 'ASC',
	)
);

	$query->set( 'posts_per_page', -1 );
}
add_action( 'pre_get_posts', 'atlas_order_movement_archive' );
