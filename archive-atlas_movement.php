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

	<?php echo do_blocks( '<!-- wp:atlas/timeline /-->' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Block markup is escaped in render.php. ?>

	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class( 'movement' ); ?>>
				<h2 class="movement-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
				</h2>
				<?php get_template_part( 'template-parts/movement-meta' ); ?>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No movements found.', 'atlas' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
