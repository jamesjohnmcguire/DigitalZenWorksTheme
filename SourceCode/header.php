<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DigitalZen
 */

if ((PHP_SAPI == 'cli') || (!array_key_exists("SERVER_NAME", $_SERVER)))
{
	// running on command line, possibly from CRON
	// $_SERVER["SERVER_NAME"] won't be set
	// cron jobs should have predefined this.
	defined('WP_DEBUG') OR define('WP_DEBUG', true);
	defined('ENVIRONMENT') OR define('ENVIRONMENT', 'development');
}
else
{
	defined('WP_DEBUG') OR define('WP_DEBUG', false);
	defined('ENVIRONMENT') OR define('ENVIRONMENT', 'production');
}

if (WP_DEBUG == true)
{
	defined('ENVIRONMENT') OR define('ENVIRONMENT', 'development');
}
else
{
	defined('ENVIRONMENT') OR define('ENVIRONMENT', 'production');
}

$data = digitalzen_theme_data(null);
$component = $data['page_type'];

$language = 'en';
$title = 'Digital Zen';
$description = 'New theme';
$css_file = digitalzen_get_css_file($component);

?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
  <meta charset="utf-8">
  <title><?php echo $title; ?></title>
  <meta name="description" content="<?php echo $description; ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo $css_file; ?>">

  <meta name="theme-color" content="aqua">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->

  <div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'digitalzen' ); ?></a>

    <header id="masthead" class="site-header">
      <div class="site-branding">
<?php
the_custom_logo();

if (is_front_page() && is_home())
{
?>
        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
<?php
}
else
{
?>
        <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
<?php
}

$digitalzen_description = get_bloginfo( 'description', 'display' );
if ($digitalzen_description || is_customize_preview())
{
?>
        <p class="site-description"><?php echo $digitalzen_description; /* WPCS: xss ok. */ ?></p>
<?php
}
?>
      </div><!-- .site-branding -->

    <nav id="site-navigation" class="main-navigation">
      <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'digitalzen' ); ?></button>
<?php
wp_nav_menu(array(
	'theme_location' => 'menu-1',
	'menu_id'        => 'primary-menu',
));
?>
    </nav><!-- #site-navigation -->
  </header><!-- #masthead -->

  <div id="content" class="site-content">
