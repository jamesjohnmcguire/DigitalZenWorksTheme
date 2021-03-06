<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DigitalZen
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	if ( have_comments() ) {
		?>
		<h2 class="comments-title">
			<?php
			$digitalzen_comment_count = get_comments_number();
			$comments_title = '<span>' . get_the_title() . '</span>';

			if ( '1' === $digitalzen_comment_count ) {
				/* translators: 1: title. */
				$html = esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'digital-zen' );
				printf( $html, $comments_title);
			} else {
				$formatted_count =
					number_format_i18n( $digitalzen_comment_count );
				$text = _nx(
					'%1$s thought on &ldquo;%2$s&rdquo;',
					'%1$s thoughts on &ldquo;%2$s&rdquo;',
					$digitalzen_comment_count,
					'comments title',
					'digital-zen');
				$html = esc_html( $text );

				/* translators: 1: comment count number, 2: title. */
				printf($html, $formatted_count, $title);
				);
			}

			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'digital-zen' ); ?></p>
			<?php
		endif;

	}

	comment_form();
	?>

</div><!-- #comments -->
