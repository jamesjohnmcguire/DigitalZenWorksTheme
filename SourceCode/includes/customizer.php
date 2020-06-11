<?php
/**
 * Digital Zen Theme Customizer
 *
 * @package DigitalZen
 */

add_action( 'customize_register', 'digitalzen_customize_register' );
add_action( 'customize_preview_init', 'digitalzen_customize_preview_js' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function digitalzen_customize_register($wp_customize)
{
    $wp_customize->get_setting('blogname' )->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription' )->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor' )->transport =
        'postMessage';

    if (isset($wp_customize->selective_refresh))
    {
        $options = array(
            'selector' => '.site-title a',
            'render_callback' => 'digitalzen_customize_partial_blogname');

        $wp_customize->selective_refresh->add_partial('blogname', $options);

        $options = array(
            'selector' => '.site-description',
            'render_callback' =>
                'digitalzen_customize_partial_blogdescription');

        $wp_customize->selective_refresh->add_partial(
            'blogdescription', $options);
    }
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function digitalzen_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function digitalzen_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function digitalzen_customize_preview_js() {
    wp_enqueue_script( 'digitalzen-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
