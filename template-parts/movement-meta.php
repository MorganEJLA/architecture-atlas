<?php
/**
 * Template part: a movement's years and color swatches.
 *
 * Used inside the Loop by archive-atlas_movement.php and single-atlas_movement.php.
 *
 * @package atlas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$atlas_start = function_exists( 'get_field' ) ? get_field( 'start_year' ) : '';
$atlas_end   = function_exists( 'get_field' ) ? get_field( 'end_year' ) : '';

if ( $atlas_start && $atlas_end ) {
	$atlas_years = $atlas_start . '–' . $atlas_end;
} else {
	$atlas_years = $atlas_start ? $atlas_start : $atlas_end;
}

$atlas_swatches = array();
if ( function_exists( 'get_field' ) ) {
	foreach ( array( 1, 2, 3 ) as $atlas_i ) {
		$atlas_color = sanitize_hex_color( (string) get_field( 'swatch_' . $atlas_i ) );
		if ( $atlas_color ) {
			$atlas_swatches[ $atlas_i ] = $atlas_color;
		}
	}
}
?>
<?php if ( $atlas_years ) : ?>
	<p class="movement-years"><?php echo esc_html( $atlas_years ); ?></p>
<?php endif; ?>

<?php if ( $atlas_swatches ) : ?>
	<ul class="swatches">
		<?php foreach ( $atlas_swatches as $atlas_i => $atlas_color ) : ?>
			<li class="swatch" style="--swatch: <?php echo esc_attr( $atlas_color ); ?>;">
				<span class="screen-reader-text">
					<?php
					/* translators: 1: swatch number, 2: hex color. */
					echo esc_html( sprintf( __( 'Swatch %1$d: %2$s', 'atlas' ), $atlas_i, $atlas_color ) );
					?>
				</span>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
