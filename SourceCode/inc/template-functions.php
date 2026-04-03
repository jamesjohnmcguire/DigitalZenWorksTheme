<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package   DigitalZen
 * @author    James John McGuire <jamesjohnmcguire@gmail.com>
 * @copyright 2021 - 2026 James John McGuire <jamesjohnmcguire@gmail.com>
 * @license   GPLv2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param string[] $classes Classes for the body element.
 * @return string[]
 */
function digitalzen_body_classes( array $classes ) : array
{
	$is_singular = is_singular();

	// Adds a class of hfeed to non-singular pages.
	if ( false === $is_singular )
	{
		$classes[] = 'hfeed';
	}

	$is_active_sidebar = is_active_sidebar( 'sidebar-1' );

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( false === $is_active_sidebar )
	{
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'digitalzen_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 *
 * @return void
 */
function digitalzen_pingback_header()
{
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'digitalzen_pingback_header' );
