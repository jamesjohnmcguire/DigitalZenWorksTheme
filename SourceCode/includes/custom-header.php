<?php
/**
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package DigitalZen
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses digitalzen_header_style()
 */
add_action( 'after_setup_theme', 'digitalzen_custom_header_setup' );

function digitalzen_custom_header_setup()
{
    $options = array(
        'default-image' => '',
        'default-text-color' => '000000',
        'width' => 1000,
        'height' => 250,
        'flex-height' => true,
        'wp-head-callback' => 'digitalzen_header_style');

    $filters = apply_filters('digitalzen_custom_header_args', $options);
    add_theme_support('custom-header', $filters);
}

if (!function_exists('digitalzen_header_style'))
{
    /**
     * Styles the header image and text displayed on the blog.
     *
     * @see digitalzen_custom_header_setup().
     */
    function digitalzen_header_style()
    {
        $header_text_color = get_header_textcolor();

        /*
         * If no custom options for text are set, let's bail.
         * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
         */
        $test_value = get_theme_support('custom-header', 'default-text-color' );
        if ($test_value === $header_text_color)
        {
            return;
        }

        // If we get this far, we have custom styles. Let's do this.
?>
    <style type="text/css">
<?php
        // Has the text been hidden?
        if (! display_header_text())
        {
?>
        .site-title,
        .site-description
        {
            position: absolute;
            clip: rect(1px, 1px, 1px, 1px);
        }
<?php
        }
        // If the user has set a custom color for the text use that.
        else
        {
?>
        .site-title a,
        .site-description
        {
            color: #<?php echo esc_attr($header_text_color); ?>;
        }
<?php
        }
?>
    </style>
<?php
    }
}
