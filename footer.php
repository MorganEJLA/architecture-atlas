<?php
/**
 * Site footer: closes <body> and <html>.
 *
 * @package atlas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="site-footer">
	<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
