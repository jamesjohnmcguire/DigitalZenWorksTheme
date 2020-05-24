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

add_action('after_setup_theme', 'digitalzen_setup');
add_action('after_setup_theme', 'digitalzen_content_width', 0);
add_action('widgets_init', 'digitalzen_widgets_init');
add_action('wp_enqueue_scripts', 'digitalzen_scripts');

function digitalzen_comment_debug()
{
	$item = '';
	$post_id = '';

	if (!empty($_SERVER))
	{
		if (array_key_exists('REQUEST_URI', $_SERVER))
		{
			$item = $_SERVER['REQUEST_URI'];
			$item  = trim($item, '/');
		}
	}

	if (!empty($item))
	{
		$post = get_page_by_path($item);

		if (!empty($post))
		{
			$post_id = $post->ID;
		}
	}

	echo "\r\n<!--*****DEBUG: item: $item :: post: $post_id*****-->\r\n";
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function digitalzen_content_width()
{
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters('digitalzen_content_width', 640);
}

function digitalzen_get_css_file($component)
{
	$css_file = '';

	if (ENVIRONMENT == 'development')
	{
		$css_file = $component . '.css';
	}
	else
	{
		$css_file = $component . '.min.css';
	}

	return $css_file;
}

/**
 * Enqueue scripts and styles.
 */
function digitalzen_scripts()
{
	$styles_path = get_stylesheet_uri();
	$template_path = get_template_directory_uri();

	$navigation_file = $template_path . '/js/navigation.js';
	$fix_file = $template_path . '/js/skip-link-focus-fix.js';

	wp_enqueue_style('digitalzen-style', $styles_path);
	wp_enqueue_script('digitalzen-navigation', $navigation_file, array(), '20151215', true);
	wp_enqueue_script('digitalzen-skip-link-focus-fix', $fix_file, array(), '20151215', true);

	if (is_singular() && comments_open() && get_option( 'thread_comments'))
	{
		wp_enqueue_script('comment-reply');
	}
}

if (!function_exists('digitalzen_setup'))
{
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function digitalzen_setup()
	{
		$template_path = get_template_directory();

		$languages_file = $template_path . '/languages';

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Digital Zen, use a find and replace
		 * to change 'digitalzen' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('digitalzen', $languages_file);

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'menu-1' => esc_html__('Primary', 'digitalzen'),
		));

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		// Set up the WordPress core custom background feature.
		$filter_data =  apply_filters('digitalzen_custom_background_args',
			array
			(
				'default-color' => 'ffffff',
				'default-image' => '',
			));
		add_theme_support('custom-background', $filter_data);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support('custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		));
	}
}

function digitalzen_theme_data($data)
{
	static $theme_data = null;

	if (!empty($data))
	{
		foreach($data as $key => $item)
		{
			$theme_data[$key] = $item;
		}
	}

	return $theme_data;
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function digitalzen_widgets_init()
{
	register_sidebar(array(
		'name'          => esc_html__( 'Sidebar', 'digitalzen' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'digitalzen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
}
