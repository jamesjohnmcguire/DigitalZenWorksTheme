<?php
/**
 * Digital Zen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Digital_Zen
 */

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/includes/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/includes/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION'))
{
	require get_template_directory() . '/includes/jetpack.php';
}

add_action('after_setup_theme', 'digitalzen_content_width', 0);
add_action('after_setup_theme', 'digitalzen_setup');
add_filter('script_loader_tag', 'add_attributes_to_scripts', 10, 3);
add_action('widgets_init', 'digitalzen_widgets_init');
add_action('wp_enqueue_scripts', 'digitalzen_enqueue_scripts');
