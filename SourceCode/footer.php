<?php
/**
 * The template for displaying the footer
 *
 * @package   DigitalZen
 * @author    James John McGuire <jamesjohnmcguire@gmail.com>
 * @copyright 2021 - 2022 James John McGuire <jamesjohnmcguire@gmail.com>
 * @license   GPLv2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped

/* translators: %s: CMS name, i.e. WordPress. */
$digitalzen_text = esc_html__( 'Proudly powered by %s', 'digital-zen' );
$digitalzen_text = sprintf( $digitalzen_text, 'WordPress' );

/* translators: 1: Theme name, 2: Theme author. */
$digitalzen_text2 = esc_html__( 'Theme: %1$s by %2$s.', 'digital-zen' );
$digitalzen_text2 = sprintf(
	$digitalzen_text,
	'digital-zen',
	'<a href="https://digitalzenworks.com">James John McGuire</a>' );
?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'digital-zen' ) ); ?>">
				<?php echo $digitalzen_text; ?>
			</a>
			<span class="sep"> | </span>
			<?php echo $digitalzen_text2; ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
