<?php
/**
 * Atlas theme setup.
 *
 * @package atlas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Register theme features.
 */
function atlas_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
}
