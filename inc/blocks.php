<?php
/**
 * Block registration.
 *
 * @package atlas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom blocks from the build folder (wp-scripts output).
 */
function atlas_register_blocks() {
	$block_dir = get_template_directory() . '/build/timeline';

	if ( ! file_exists( $block_dir . '/block.json' ) ) {
		return;
	}

	register_block_type( $block_dir );
}
add_action( 'init', 'atlas_register_blocks' );
