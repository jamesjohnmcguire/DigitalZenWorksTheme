<?php
/**
 * Template part for displaying page content in page.php
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
      <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->

    <?php digitalzen_post_thumbnail(); ?>

    <div class="entry-content">
<?php
the_content();

$page_links = digitalzen_get_pagination_links();
wp_link_pages( $page_links );
?>
    </div><!-- .entry-content -->

<?php
$post_link = get_edit_post_link();

if ( null !== $post_link )
{
?>
    <footer class="entry-footer">
<?php
$allows = digitalzen_get_span_allows();

edit_post_link(
	sprintf(
		wp_kses(
			/* translators: %s: Name of current post. Only visible to screen readers */
			__( 'Edit <span class="screen-reader-text">%s</span>', 'digital-zen' ),
			$allows
		),
		wp_kses_post( get_the_title() )
	),
	'<span class="edit-link">',
	'</span>'
);
?>
    </footer><!-- .entry-footer -->
<?php
}
?>
  </article><!-- #post-<?php the_ID(); ?> -->
