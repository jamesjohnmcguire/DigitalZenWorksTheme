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
