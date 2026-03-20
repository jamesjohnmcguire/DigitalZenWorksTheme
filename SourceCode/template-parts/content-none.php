<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package   DigitalZen
 * @author    James John McGuire <jamesjohnmcguire@gmail.com>
 * @copyright 2021 - 2026 James John McGuire <jamesjohnmcguire@gmail.com>
 * @license   GPLv2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

declare(strict_types=1);
?>

  <section class="no-results not-found">
    <header class="page-header">
      <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'digital-zen' ); ?></h1>
    </header><!-- .page-header -->

    <div class="page-content">
<?php
$is_home = is_home();
$is_user_can_publish = current_user_can( 'publish_posts' );
$is_search = is_search();

if ( true === $is_home && true === $is_user_can_publish )
{
	$message = 'Ready to publish your first post? <a href="%1$s">' .
		'Get started here</a>.';

	$anchor =
	[
		'a' => [ 'href' => [] ]
	];

	$admin_url = admin_url( 'post-new.php' );
	$admin_url = esc_url( $admin_url );
	$escaped_message = wp_kses(
		/* translators: 1: link to WP admin new post page. */
		__( $message, 'digital-zen' ),
		$anchor	);

	$outer_message = '<p>' . $escaped_message . '</p>';

	printf( $outer_message, $admin_url );
}
elseif ( true === $is_search )
{
	$message = 'Sorry, but nothing matched your search terms. ' .
		'Please try again with some different keywords.';
?>
      <p><?php esc_html_e( $message, 'digital-zen' ); ?></p>
<?php
	get_search_form();
}
else
{
	$message = 'It seems we can&rsquo;t find what you&rsquo;re ' .
	'looking for. Perhaps searching can help.';
?>
      <p><?php esc_html_e( $message, 'digital-zen' ); ?></p>
<?php
	get_search_form();
}
?>
    </div><!-- .page-content -->
  </section><!-- .no-results -->
