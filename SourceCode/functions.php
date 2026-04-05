<?php
/**
 * DigitalZen functions and definitions
 *
 * @package   DigitalZen
 * @author    James John McGuire <jamesjohnmcguire@gmail.com>
 * @copyright 2021 - 2026 James John McGuire <jamesjohnmcguire@gmail.com>
 * @license   GPLv2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://developer.wordpress.org/themes/basics/theme-functions/
 */

declare(strict_types=1);

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Post customiz additions.
 */
require get_template_directory() . '/inc/posts-support.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

if ( ! defined( 'DIGITALZEN_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'DIGITALZEN_VERSION', '0.4.17' );
}

add_action( 'after_setup_theme', 'digitalzen_setup' );
add_action( 'after_setup_theme', 'digitalzen_content_width', 0 );
add_action( 'widgets_init', 'digitalzen_widgets_init' );
add_action( 'wp_enqueue_scripts', 'dequeue_polyfill', 100 );
add_action(
	'wp_enqueue_scripts',
	'dequeue_wpcf7_recaptcha_when_not_needed',
	100);
add_action( 'wp_enqueue_scripts', 'digitalzen_scripts' );

if ( ! function_exists( 'dequeue_polyfill' ) )
{
	function dequeue_polyfill()
	{
		wp_dequeue_script( 'regenerator-runtime' );
		wp_deregister_script( 'regenerator-runtime' );

		wp_dequeue_script( 'wp-polyfill' );
		wp_deregister_script( 'wp-polyfill' );
	}
}

if ( ! function_exists( 'dequeue_wpcf7_recaptcha_when_not_needed' ) )
{
	function dequeue_wpcf7_recaptcha_when_not_needed()
	{
		// Only check for the frontend
		if ( ! is_admin() )
		{
			// Check if the current post content contains
			// a Contact Form 7 shortcode.
			global $post;

			if ( ! isset( $post ) ||
				! has_shortcode( $post->post_content, 'contact-form-7' ) )
			{
				// Dequeue the reCAPTCHA script and its inline data.
				wp_dequeue_script( 'wpcf7-recaptcha-js' );
				wp_deregister_script( 'wpcf7-recaptcha-js' );

				// Remove the inline script.
				add_filter(
					'script_loader_tag',
					'\DigitalZenWorksTheme\remove_wpcf7_recaptcha_inline_script',
					10,
					2);

				add_filter( 'wpcf7_load_js', '__return_false' );
				add_filter( 'wpcf7_load_css', '__return_false' );
			}
		}
	}
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 * @return void
 */
function digitalzen_content_width()
{
	$GLOBALS['content_width'] = apply_filters( 'digitalzen_content_width', 640 );
}

if ( ! function_exists( 'digitalzen_get_pagination_links' ) )
{
	function digitalzen_get_pagination_links()
	{
		$page_links =
		[
			'before' => '<div class="page-links">' .
				esc_html__( 'Pages:', 'digital-zen' ),
			'after'  => '</div>'
		];

		return $page_links;
	}
}

if ( ! function_exists( 'digitalzen_get_permalink_safe' ) )
{
	function digitalzen_get_permalink_safe()
	{
		$permalink = get_permalink();

		if ( $permalink === false )
		{
			$permalink = '';
		}

		return $permalink;
	}
}

if ( ! function_exists( 'digitalzen_get_post_type_safe' ) )
{
	function digitalzen_get_post_type_safe()
	{
		$post_type = get_post_type();

		if ( false === $post_type )
		{
			$post_type = null;
		}

		return $post_type;
	}
}

if ( ! function_exists( 'digitalzen_posted_by' ) )
{
	/**
	 * Prints HTML with meta information for the current author.
	 *
	 * @return void
	 */
	function digitalzen_posted_by()
	{
		/* translators: %s: post author. */
		$prefix = esc_html_x( 'by %s', 'post author', 'digital-zen' );
		$author_meta = get_the_author_meta( 'ID' );

		$author_url = get_author_posts_url( $author_meta );
		$author_url = esc_url( $author_url );

		$author = get_the_author();
		$author = esc_html( $author );

		$span = '<span class="author vcard"><a class="url fn n" href="' .
			$author_url . '">' . $author . '</a></span>';

		$byline = sprintf( $prefix, $span );

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'digitalzen_posted_on' ) )
{
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 *
	 * @return void
	 */
	function digitalzen_posted_on()
	{
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) )
			 {
			$time_string =
				'<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'digital-zen' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'digitalzen_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @return void
	 */
	function digitalzen_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on DigitalZen, use a find and replace
		 * to change 'digital-zen' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'digital-zen', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			[
				'menu-1' => esc_html__( 'Primary', 'digital-zen' ),
			]
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			]
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'digitalzen_custom_background_args',
				[
					'default-color' => 'ffffff',
					'default-image' => '',
				]
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			[
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			]
		);
	}
}

/**
 * Enqueue scripts and styles.
 *
 * @return void
 */
function digitalzen_scripts()
{
	wp_enqueue_style( 'digitalzen-style', get_stylesheet_uri(), [], DIGITALZEN_VERSION );
	wp_style_add_data( 'digitalzen-style', 'rtl', 'replace' );

	wp_enqueue_script( 'digitalzen-navigation', get_template_directory_uri() . '/js/navigation.js', [], DIGITALZEN_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

if ( ! function_exists( 'digitalzen_show_entry_meta' ) )
{
	function digitalzen_show_entry_meta()
	{
?>
      <div class="entry-meta">
<?php
		digitalzen_posted_on();
		digitalzen_posted_by();
?>
      </div><!-- .entry-meta -->
<?php
	}
}

if ( ! function_exists( 'digitalzen_get_span_allows' ) )
{
	function digitalzen_get_span_allows()
	{
		$class = [];
		$span = [ 'class' => $class ];
		$allows =
		[
			'span' => $span
		];

		return $allows;
	}
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @return void
 */
function digitalzen_widgets_init()
{
	register_sidebar(
		[
			'name'          => esc_html__( 'Sidebar', 'digital-zen' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'digital-zen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		]
	);
}

if ( ! function_exists( 'remove_wpcf7_recaptcha_inline_script' ) )
{
	// Remove unused inline script tags for contact forms and reCAPTCHA.
	function remove_wpcf7_recaptcha_inline_script( $tag, $handle )
	{
		if ( $handle === 'contact-form-7' ||
			$handle === 'google-recaptcha' ||
			$handle === 'swv' ||
			$handle === 'wp-i18n' ||
			$handle === 'wpcf7-recaptcha' ||
			$handle === 'wpcf7-recaptcha-js-before' )
		{
			$tag = '';
		}

		return $tag;
	}
}
