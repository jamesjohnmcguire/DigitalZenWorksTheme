<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package   DigitalZen
 * @author    James John McGuire <jamesjohnmcguire@gmail.com>
 * @copyright 2021 - 2026 James John McGuire <jamesjohnmcguire@gmail.com>
 * @license   GPLv2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! function_exists( 'digitalzen_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 *
	 * @return void
	 */
	function digitalzen_entry_footer()
	{
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'digital-zen' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				$message = esc_html__( 'Posted in %1$s', 'digital-zen' );
				printf( '<span class="cat-links">' . $message . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'digital-zen' ) );
			$is_error = is_wp_error( $tags_list );

			if ( false === $is_error && $tags_list )
			{
				/* translators: 1: list of tags. */
				$message = esc_html__( 'Tagged %1$s', 'digital-zen' );
				printf( '<span class="tags-links">' . $message . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'digital-zen' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'digital-zen' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'digitalzen_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * @return void
	 */
	function digitalzen_post_thumbnail()
	{
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'digitalzen_wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @return void
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function digitalzen_wp_body_open()
	{
		do_action( 'digitalzen_wp_body_open' );
	}
endif;
