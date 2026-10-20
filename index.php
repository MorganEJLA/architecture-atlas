<?php
/**
 * Fallback template.
 *
 * @package atlas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="content">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article>
				<h2><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h2>
				<?php the_excerpt(); ?>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing found.', 'atlas' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
