<?php
/**
 * DigitalZen Theme Customizer
 *
 * @package   DigitalZen
 * @author    James John McGuire <jamesjohnmcguire@gmail.com>
 * @copyright 2021 - 2026 James John McGuire <jamesjohnmcguire@gmail.com>
 * @license   GPLv2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function digitalzen_customize_register( $wp_customize ) : void
{
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial(
		'blogname',
		[
			'selector'        => '.site-title a',
			'render_callback' => 'digitalzen_customize_partial_blogname',
		]
	);
	$wp_customize->selective_refresh->add_partial(
		'blogdescription',
		[
			'selector'        => '.site-description',
			'render_callback' => 'digitalzen_customize_partial_blogdescription',
		]
	);
}
add_action( 'customize_register', 'digitalzen_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function digitalzen_customize_partial_blogname()
{
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function digitalzen_customize_partial_blogdescription()
{
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @return void
 */
function digitalzen_customize_preview_js()
{
	wp_enqueue_script(
		'digitalzen-customizer',
		get_template_directory_uri() . '/js/customizer.js',
		[ 'customize-preview' ], DIGITALZEN_VERSION, true );
}
add_action( 'customize_preview_init', 'digitalzen_customize_preview_js' );
