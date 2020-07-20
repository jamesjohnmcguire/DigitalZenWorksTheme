<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Digital_Zen
 */

add_action( 'wp_head', 'digitalzen_pingback_header' );

add_filter( 'body_class', 'digitalzen_body_classes' );

function add_attribs_to_scripts($tag, $handle, $src)
{
	// The handles of the enqueued scripts we want to modify
	$scripts = array('theme-bootstrap-async');

	if (in_array($handle, $scripts)) {
		$integrity = "sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM";
		$crossorigin = "anonymous";

		$tag = '<script src="' . $src . '" integrity="' . $integrity .
			'" crossorigin="anonymous"></script>' . "\n";
	}

	if (!is_admin())
	{
		$async_position = strpos($handle, 'async');
		$defer_position = strpos($handle, 'defer');

		if ($async_position !== false)
		{
			$tag = str_replace('<script ', '<script async ', $tag);
		}

		if ($defer_position !== false)
		{
			$tag = str_replace('<script ', '<script defer ', $tag);
		}
	}

	return $tag;
}

if (!function_exists('base_enqueue_scripts'))
{
	function base_enqueue_scripts()
	{
		$theme_path = get_template_directory_uri();
		$css_path = $theme_path . '/assets/css/';
		$js_path = $theme_path . '/assets/js/';

		$theme = wp_get_theme();
		$version = $theme->get('Version');

		wp_enqueue_style('bootstrap-style', "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css");
		wp_enqueue_style('fontawesome-style', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css");

		if (WP_DEBUG === true)
		{
			// if false, these will be enqueued by the child theme
			wp_enqueue_style('theme-style', $css_path . 'style.css');
			wp_enqueue_style('social-media-style', $css_path  . 'social-media.css');
		}

		$file = $js_path . 'vendor/modernizr-3.11.2.min.js';
		wp_register_script('modernizr-script-async-defer', $file, array(),
			false, true);
		wp_enqueue_script('modernizr-script-async-defer');

		$file = 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js';
		wp_register_script('theme-bootstrap-async', $file, array('jquery'),
			false, true);
		wp_enqueue_script('theme-bootstrap-async');

		if (WP_DEBUG === true)
		{
			// if false, these will be enqueued by the child theme
			$file = $js_path . 'bootstrap.slide-menu.js';
			wp_register_script('theme-slide-menu-async', $file, array('jquery'),
				false, true);
			wp_enqueue_script('theme-slide-menu-async');
		}

		$file = 'https://www.google.com/recaptcha/api.js';
		wp_register_script('recaptcha-script-async-defer', $file, array(),
			false, true);
		wp_enqueue_script('recaptcha-script-async-defer');

		$file = $js_path . 'navigation.js';
		wp_register_script('navigation-script-async-defer', $file, array(),
			false, true);
		wp_enqueue_script('navigation-script-async-defer');

		$file = $js_path . 'plugins.js';
		wp_register_script('plugins-script-async-defer', $file, array(),
			false, true);
		wp_enqueue_script('plugins-script-async-defer');

		$file = $js_path . 'skip-link-focus-fix.js';
		wp_register_script('skip-link-script-async-defer', $file, array(),
			false, true);
		wp_enqueue_script('skip-link-script-async-defer');

		if (is_singular() && comments_open() && get_option( 'thread_comments'))
		{
			wp_enqueue_script('comment-reply');
		}
	}
}

if (!function_exists('digitalzen_enqueue_scripts'))
{
	function digitalzen_enqueue_scripts()
	{
		base_enqueue_scripts();
	}
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function digitalzen_body_classes( $classes )
{
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}

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
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function digitalzen_pingback_header()
{
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}

/**
 * Enqueue scripts and styles.
 */
function digitalzen_scripts()
{
	$template_path = get_template_directory_uri();

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
		 * If you're building a theme based on Digital Zen, use a find and
		 * replace to change 'digital-zen' to the name of your theme in all the
		 * template files.
		 */
		load_theme_textdomain('digital-zen', $languages_file);

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
			'menu-1' => esc_html__('Primary', 'digital-zen'),
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
		'name'          => esc_html__( 'Sidebar', 'digital-zen' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'digital-zen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
}
