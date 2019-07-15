<?php

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

$language = 'en';
$title = 'Digital Zen';
$description = 'New theme';
$css_file = get_css_file($component);

?>
<!doctype html>
<html class="no-js" lang="<?php echo $language; ?>">

<head>
  <meta charset="utf-8">
  <title><?php echo $title; ?></title>
  <meta name="description" content="<?php echo $description; ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo $css_file; ?>">

  <meta name="theme-color" content="aqua">
</head>

<body>
  <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
