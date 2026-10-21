<?php
/**
 * Archive template for Movements (/movements/).
 *
 * @package atlas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="content" class="site-main">
	<h1><?php post_type_archive_title(); ?></h1>

	<?php $atlas_timeline = do_blocks( '<!-- wp:atlas/timeline /-->' ); ?>

	<?php if ( '' !== trim( $atlas_timeline ) ) : ?>
		<?php echo $atlas_timeline; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Block markup is escaped in render.php. ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No movements found.', 'atlas' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
