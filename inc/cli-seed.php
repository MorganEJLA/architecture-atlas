<?php
/**
 * WP-CLI command: seed Movement posts from data/movements.json.
 *
 * @package atlas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Seeds the atlas_movement post type from the theme's JSON data file.
 */
class Atlas_Seed_Command {

	/**
	 * ACF field keys, indexed by field name (see inc/acf-fields.php).
	 *
	 * @var array<string,string>
	 */
	const FIELD_KEYS = array(
		'start_year' => 'field_atlas_start_year',
		'end_year'   => 'field_atlas_end_year',
		'swatch_1'   => 'field_atlas_swatch_1',
		'swatch_2'   => 'field_atlas_swatch_2',
		'swatch_3'   => 'field_atlas_swatch_3',
	);

	/**
	 * Create or update Movement posts from data/movements.json.
	 *
	 * Posts are matched by slug, so running this repeatedly creates no duplicates.
	 *
	 * ## EXAMPLES
	 *
	 *     wp atlas seed
	 *
	 * @param array $args       Positional arguments (unused).
	 * @param array $assoc_args Associative arguments (unused).
	 */
	public function __invoke( $args, $assoc_args ) {
		$file = get_template_directory() . '/data/movements.json';

		if ( ! is_readable( $file ) ) {
			WP_CLI::error( "Cannot read {$file}" );
		}

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local theme file, not a remote URL.
		$movements = json_decode( file_get_contents( $file ), true );

		if ( ! is_array( $movements ) ) {
			WP_CLI::error( 'movements.json is missing or not valid JSON.' );
		}

		$has_acf = function_exists( 'update_field' );
		if ( ! $has_acf ) {
			WP_CLI::warning( 'ACF is not active. Posts and terms will be seeded, but custom fields will be skipped.' );
		}

		$created = 0;
		$updated = 0;

		foreach ( $movements as $movement ) {
			$slug = isset( $movement['slug'] ) ? sanitize_title( $movement['slug'] ) : '';

			if ( '' === $slug || empty( $movement['title'] ) ) {
				WP_CLI::warning( 'Skipping an entry with no title or slug.' );
				continue;
			}

			$existing = get_posts(
				array(
					'post_type'      => 'atlas_movement',
					'name'           => $slug,
					'post_status'    => 'any',
					'posts_per_page' => 1,
					'fields'         => 'ids',
				)
			);

			$postarr = array(
				'post_type'    => 'atlas_movement',
				'post_status'  => 'publish',
				'post_title'   => sanitize_text_field( $movement['title'] ),
				'post_name'    => $slug,
				'post_excerpt' => isset( $movement['summary'] ) ? sanitize_textarea_field( $movement['summary'] ) : '',
			);

			if ( $existing ) {
				$postarr['ID'] = $existing[0];
				$post_id       = wp_update_post( $postarr, true );
			} else {
				$post_id = wp_insert_post( $postarr, true );
			}

			if ( is_wp_error( $post_id ) ) {
				WP_CLI::warning( "{$slug}: " . $post_id->get_error_message() );
				continue;
			}

			$existing ? $updated++ : $created++;

			$this->assign_place( $post_id, $movement, $slug );

			if ( $has_acf ) {
				$this->save_fields( $post_id, $movement );
			}

			WP_CLI::log( ( $existing ? 'Updated: ' : 'Created: ' ) . $slug );
		}

		WP_CLI::success( "Seed complete. Created {$created}, updated {$updated}." );
	}

	/**
	 * Assign the atlas_place term, looked up by name.
	 *
	 * @param int    $post_id  Movement post ID.
	 * @param array  $movement One entry from movements.json.
	 * @param string $slug     Movement slug, for log messages.
	 */
	private function assign_place( $post_id, $movement, $slug ) {
		if ( empty( $movement['place'] ) ) {
			return;
		}

		$term = get_term_by( 'name', $movement['place'], 'atlas_place' );

		if ( ! $term ) {
			WP_CLI::warning( "{$slug}: no atlas_place term named \"{$movement['place']}\"." );
			return;
		}

		// Replaces existing terms, so repeat runs never pile up assignments.
		wp_set_object_terms( $post_id, (int) $term->term_id, 'atlas_place' );
	}

	/**
	 * Save the ACF fields using their field keys.
	 *
	 * @param int   $post_id  Movement post ID.
	 * @param array $movement One entry from movements.json.
	 */
	private function save_fields( $post_id, $movement ) {
		foreach ( array( 'start_year', 'end_year' ) as $name ) {
			if ( isset( $movement[ $name ] ) ) {
				update_field( self::FIELD_KEYS[ $name ], absint( $movement[ $name ] ), $post_id );
			}
		}

		foreach ( array( 'swatch_1', 'swatch_2', 'swatch_3' ) as $name ) {
			if ( empty( $movement[ $name ] ) ) {
				continue;
			}

			$color = sanitize_hex_color( $movement[ $name ] );

			if ( $color ) {
				update_field( self::FIELD_KEYS[ $name ], $color, $post_id );
			} else {
				WP_CLI::warning( "{$movement['slug']}: invalid hex for {$name}, skipped." );
			}
		}
	}
}

WP_CLI::add_command( 'atlas seed', 'Atlas_Seed_Command' );
