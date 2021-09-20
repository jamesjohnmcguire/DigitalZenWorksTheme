<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DigitalZen
 */

// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped

/* translators: %s: CMS name, i.e. WordPress. */
$digitalzen_text = esc_html__( 'Proudly powered by %s', 'digital-zen' );
$digitalzen_text = sprintf( $digitalzen_text, 'WordPress' );

/* translators: 1: Theme name, 2: Theme author. */
$digitalzen_text2 = esc_html__( 'Theme: %1$s by %2$s.', 'digital-zen' )
?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'digital-zen' ) ); ?>">
				<?php echo $digitalzen_text; ?>
			</a>
			<span class="sep"> | </span>
				<?php
				printf( $digitalzen_text, 'digital-zen', '<a href="https://digitalzenworks.com">James John McGuire</a>' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
