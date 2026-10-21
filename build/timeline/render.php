<?php
/**
 * Server-side render for the atlas/timeline block.
 *
 * Available variables: $attributes, $content, $block.
 *
 * @package atlas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$atlas_movements = new WP_Query(
	array(
		'post_type'      => 'atlas_movement',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'no_found_rows'  => true,
		'meta_query'     => array(
			'start_year_clause' => array(
				'key'     => 'start_year',
				'type'    => 'NUMERIC',
				'compare' => 'EXISTS',
			),
		),
		'orderby'        => array(
			'start_year_clause' => 'ASC',
			'title'             => 'ASC',
		),
	)
);

if ( ! $atlas_movements->have_posts() ) {
	return;
}
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => 'atlas-timeline' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by core. ?> aria-label="<?php esc_attr_e( 'Timeline of movements', 'atlas' ); ?>">
	<ol class="atlas-timeline__list">
		<?php foreach ( $atlas_movements->posts as $atlas_post ) : ?>
			<?php
			$atlas_id     = $atlas_post->ID;
			$atlas_start  = function_exists( 'get_field' ) ? get_field( 'start_year', $atlas_id ) : '';
			$atlas_end    = function_exists( 'get_field' ) ? get_field( 'end_year', $atlas_id ) : '';
			$atlas_terms  = get_the_terms( $atlas_id, 'atlas_place' );
			$atlas_terms  = ( $atlas_terms && ! is_wp_error( $atlas_terms ) ) ? $atlas_terms : array();
			$atlas_slugs  = implode( ' ', wp_list_pluck( $atlas_terms, 'slug' ) );
			$atlas_places = implode( ', ', wp_list_pluck( $atlas_terms, 'name' ) );

			if ( $atlas_start && $atlas_end ) {
				$atlas_years = $atlas_start . '–' . $atlas_end;
			} else {
				$atlas_years = $atlas_start ? $atlas_start : $atlas_end;
			}
			?>
			<li class="atlas-timeline__item" data-place="<?php echo esc_attr( $atlas_slugs ); ?>">
				<a href="<?php echo esc_url( get_permalink( $atlas_id ) ); ?>"><?php echo esc_html( get_the_title( $atlas_id ) ); ?></a>
				<?php if ( $atlas_years ) : ?>
					<span class="atlas-timeline__years"><?php echo esc_html( $atlas_years ); ?></span>
				<?php endif; ?>
				<?php if ( $atlas_places ) : ?>
					<span class="atlas-timeline__place"><?php echo esc_html( $atlas_places ); ?></span>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ol>
</section>
