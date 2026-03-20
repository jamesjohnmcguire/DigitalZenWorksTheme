<?php
/**
 * Template part for displaying posts
 *
 * @package   DigitalZen
 * @author    James John McGuire <jamesjohnmcguire@gmail.com>
 * @copyright 2021 - 2026 James John McGuire <jamesjohnmcguire@gmail.com>
 * @license   GPLv2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

declare(strict_types=1);
?>
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
<?php
$is_singular = is_singular();

if ( true === $is_singular )
{
	the_title( '<h1 class="entry-title">', '</h1>' );
}
else
{
	$permalink = digitalzen_get_permalink_safe();

	$title_prefix = '<h2 class="entry-title"><a href="' . esc_url( $permalink ) .
		'" rel="bookmark">';
	the_title( $title_prefix, '</a></h2>' );
}

if ( 'post' === get_post_type() )
{
	digitalzen_show_entry_meta();
}
?>
    </header><!-- .entry-header -->

<?php digitalzen_post_thumbnail(); ?>

    <div class="entry-content">
<?php
$allows = digitalzen_get_span_allows();

$page_links = digitalzen_get_pagination_links();

the_content(
	sprintf(
		wp_kses(
			/* translators: %s: Name of current post. Only visible to screen readers */
			__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'digital-zen' ),
			$allows
		),
		wp_kses_post( get_the_title() )
	)
);

wp_link_pages( $page_links );
?>
	</div><!-- .entry-content -->

    <footer class="entry-footer">
		<?php digitalzen_entry_footer(); ?>
    </footer><!-- entry-footer -->
  </article><!-- #post-<?php the_ID(); ?> -->
