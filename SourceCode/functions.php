<?php

function comment_debug()
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

function get_css_file($component)
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

function theme_data($data)
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
