<?php
/**
 * The template for displaying all single posts
 *
 * @package   DigitalZen
 * @author    James John McGuire <jamesjohnmcguire@gmail.com>
 * @copyright 2021 - 2026 James John McGuire <jamesjohnmcguire@gmail.com>
 * @license   GPLv2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

declare(strict_types=1);

get_header();
?>
  <main id="primary" class="site-main">
<?php
$have_posts = have_posts();

while ( true === $have_posts )
{
	the_post();

	$post_type = digitalzen_get_post_type_safe();

	get_template_part( 'template-parts/content', $post_type );

	$prev_text = '<span class="nav-subtitle">' .
		esc_html__( 'Previous:', 'digital-zen' ) .
		'</span> <span class="nav-title">%title</span>';

	$next_text = '<span class="nav-subtitle">' .
		esc_html__( 'Next:', 'digital-zen' ) .
		'</span> <span class="nav-title">%title</span>';

	the_post_navigation(
		[
			'prev_text' => $prev_text,
			'next_text' => $next_text,
		]
	);

	// If comments are open or we have at least one comment,
	// load up the comment template.
	if ( comments_open() || get_comments_number() )
	{
		comments_template();
	}
}
?>
  </main><!-- #main -->
<?php
get_sidebar();
get_footer();
