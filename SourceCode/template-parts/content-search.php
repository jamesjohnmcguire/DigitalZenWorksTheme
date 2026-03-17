<?php
/**
 * Template part for displaying results in search pages
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
$permalink = digitalzen_get_permalink_safe();

$title = sprintf(
	'<h2 class="entry-title"><a href="%s" rel="bookmark">',
	esc_url( $permalink ) );

	the_title( $title, '</a></h2>' );

if ( 'post' === get_post_type() )
{
	digitalzen_show_entry_meta();
}
?>
	</header><!-- .entry-header -->

	<?php digitalzen_post_thumbnail(); ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php digitalzen_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
