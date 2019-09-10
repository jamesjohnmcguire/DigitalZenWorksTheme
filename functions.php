<?php

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
